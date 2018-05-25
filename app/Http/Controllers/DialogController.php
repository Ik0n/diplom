<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\DialogParticipant;
use App\Message;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class DialogController extends Controller
{
    public function __construct()
    {
        $this->disk = 'image_disk';
    }

    public function myDialogs(User $user) {
        $dialogs = $user->dialogs;

        return view('layouts.users.myDialogs', ['user' => Auth::user(),'dialogs' => $dialogs,'authUser' => Auth::user(),'authUserName' => Auth::user()['name']]);
    }

    public function dialogCreate(User $user) {
        $inboxFriends = $user->inboxFriends()->pluck('name', 'id');
        $outboxFriends = $user->outboxFriends()->pluck('name', 'id');
        $test = $inboxFriends->toArray() + $outboxFriends->toArray();


        return view('layouts.users.dialogCreate', ['user' => $user,'friends' => $test, 'authUser' => Auth::user(), 'authUserName' => Auth::user()['name']]);
    }

    public function dialogStore(User $user,Request $request) {
        $attributes = $request->only(['name', 'dialog_participants']);
        $attributes['avatar'] = $request->file;

        if($attributes['avatar'] == null) {
            $attributes['avatar'] = "not";
            $dialog = Dialog::create($attributes);
        }
        else {
            $file = $request->file('file');
            $filename = $this->fixedStore($file, '', $this->disk);
            try {
                $attributes['avatar'] = $filename;
                $dialog = Dialog::create($attributes);
            }
            catch (\Exception $exception) {
                Storage::disk($this->disk)->delete($filename);
                throw $exception;
            }
        }

        //var_dump($attributes['dialog_participants']);

        DialogParticipant::create(['dialog_id' => $dialog->id, 'user_id' => Auth::user()->getAuthIdentifier()]);

        for ($i = 0; $i < count($attributes['dialog_participants']); $i++) {
            DialogParticipant::create(['dialog_id' => $dialog->id,'user_id' => $attributes['dialog_participants'][$i]]);
        }


        //$dialog->participants()->sync($attributes['dialog_participants']);
        return redirect(route('myDialogs', ['user' => Auth::user(), 'authUserName' => Auth::user()['name']]));

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

    public function showDialog($dialog) {
        $objectDialog = Dialog::findOrFail($dialog);
        $user = Auth::user();

        if ($user->dialogs->contains($objectDialog->id)){
            return view('layouts.users.showDialog', [$objectDialog->id, 'dialog' => $objectDialog, 'user' => Auth::user(), 'authUserName' => Auth::user()['name']]);
        } else {
            return redirect(route('myDialogs', ['user' => Auth::user(), 'authUserName' => Auth::user()['name']]));
        }


    }

    public function dialogStoreMessage($dialog, Request $request) {
        $objectDialog = Dialog::findOrFail($dialog);
        $attributes = $request->only(['content']);
        $attributes['user_id_sender'] = Auth::user()->getAuthIdentifier();
        $attributes['author'] = Auth::user()->getAuthIdentifier();
        $attributes['filename'] = 'not';
        $attributes['private'] = '1';
        $attributes['recipient_id'] = $objectDialog->id;
        $attributes['recipient_type'] = "App\Dialog";

        Message::create($attributes);

        return redirect(route('showDialog', [$objectDialog->id, 'authUserName' => Auth::user()['name']]));
    }
}
