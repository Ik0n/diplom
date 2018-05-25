<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Group;
use App\GroupParticipant;
use App\Message;
use App\Tag;
use Auth;
use Illuminate\Http\Request;
use Storage;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->disk = 'image_disk';
    }

    public function showGroup($group) {
        return view('layouts.users.showGroup', ['group' => Group::findOrFail($group), 'authUserName' => Auth::user()['name'], 'authUser' => Auth::user()]);
    }

    public function storeMessageToGroup($group, Request $request) {
        $objectGroup = Group::findOrFail($group);
        $attributes = $request->only(['content', 'tag_id', 'filename', 'private']);
        $attributes['user_id_sender'] = Auth::user()->getAuthIdentifier();
        $attributes['author'] = Auth::user()->getAuthIdentifier();
        $attributes['filename'] = $request->file;
        $attributes['private'] = 0;
        $attributes['recipient_id'] = $objectGroup->id;
        $attributes['recipient_type'] = "App\Group";

        if($attributes['filename'] == null) {
            $attributes['filename'] = "not";
            $message = Message::create($attributes);
            if ($attributes['tag_id'] != null) {
                $message->tags()->attach($this->createAndGetTags($attributes['tag_id']));
            }
        }
        else {
            $file = $request->file('file');
            $filename = $this->fixedStore($file, '', $this->disk);
            try {
                $attributes['filename'] = $filename;
                $message = Message::create($attributes);
                if ($attributes['tag_id'] != null) {
                    $message->tags()->attach($this->createAndGetTags($attributes['tag_id']));
                }
            }
            catch (\Exception $exception) {
                Storage::disk($this->disk)->delete($filename);
                throw $exception;
            }
        }

        return redirect(route('showGroup',  $objectGroup->id));
    }

    private function createAndGetTags($str) {
        $tags = null;
        foreach(explode(' ', $str) as $tag) {
            $tags[] = Tag::where('title', '=', $tag)->get()->count() == 0 ?
                Tag::create(['title' => $tag])->id :
                Tag::where('title', '=', $tag)->get()->first()->id;
        }
        return $tags;
    }

    private function fixedStore($file, $path, $disk) {
        $folder = Storage::disk($disk)->getAdapter()->getPathPrefix();
        $temp = tempnam($folder, '');
        $filename = pathinfo($temp, PATHINFO_FILENAME);
        $extension = $file->extension();

        try {
            $basename = $file->storeAs($path, "$filename.$extension", $disk);
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            unlink($temp);
        }
        return $basename;
    }

    public function storeCommentToMessage($group, $message, Request $request) {
        $objectGroup = Group::findOrFail($group);
        $objectMessage = Message::findOrFail($message);
        $attributes = $request->only(['content']);
        $attributes['message_id'] = $objectMessage->id;
        $attributes['user_id'] = Auth::user()->getAuthIdentifier();;
        Comment::create($attributes);

        return redirect(route('showGroup',  $objectGroup->id));
    }

    public function joinGroup($group) {
        $objectGroup = Group::findOrFail($group);
        GroupParticipant::create(['user_id' => Auth::user()->getAuthIdentifier(), 'group_id' => $objectGroup->id]);

        return redirect(route('users.index',  ['searchOption' => 'groups'] ));
    }

    public function quitGroup($group) {
        $objectGroup = Group::findOrFail($group);
        $objectGroupParticipant = GroupParticipant::where('user_id','=',Auth::user()->getAuthIdentifier())->where('group_id','=',$objectGroup->id);;
        //$objectGroupParticipant = $objectGroupParticipant->where('user_id','=',Auth::user()->getAuthIdentifier());
        //$objectGroupParticipant = $objectGroupParticipant->where('group_id','=',$objectGroup->id);

        $objectGroupParticipant->delete();

        return redirect(route('users.index',  ['searchOption' => 'groups'] ));
    }
}
