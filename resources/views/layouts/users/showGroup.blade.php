@extends('layouts.base')
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="nameuser"><h2>{{ $group->name }}</h2>
                </div>
                <div  class="thumbnailmy">
                    <div class="align-right ">
                        @if($group->avatar == "qqq")
                            <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-responsive img-rounded img-thumbnail">
                            <div class="text-left">

                            </div>
                            <hr>
                        @endif
                        @if($group->avatar != "qqq")
                            <img src="{{ asset('storage/images/' . $group->avatar) }}" alt="" class="img-responsive img-rounded img-thumbnail">
                            <hr>
                        @endif
                    </div>
                </div>
                <div class="align-right">

                </div>
                <div class="linetext">{{trans('messages.maininfo')}}</div>
                <div class="nameuser">
                    <table class="infostyle" width="50%">
                        <tr>
                            <td class="tdpad"><div class="textlight">{{trans('')}}</div></td>
                            <td class="tdpad"> {{ $group->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="linetext">{{trans('messages.coninfo')}}</div>
                <div class="nameuser">
                    <table class="infostyle" width="100%">

                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="linetext">{{trans('messages.newrec')}}</div>
                <div class="form-horizontal">
                    <div class="form-group">
                        {{ Form::model(null, ['files' => true, 'method' => 'POST', 'route' => ['storeMessageToGroup', $group->id] ]) }}
                        <div class="col-md-11 col-md-offset-1">
                            {{ Form::textarea('content',null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 control-label">
                            {{ Form::label('tag_id', trans('messages.tags')) }}
                        </div>
                        <div class="col-md-10">
                            {{ Form::text('tag_id',null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-11 col-md-offset-1">
                            {{ Form::label ('file', "Добавить изображения") }}
                        </div>
                        <div class="col-md-11 col-md-offset-1">
                            {{
                            Form::file('file', [
                            'aria-describedby' => 'file-help',
                            'class' => 'btn btn-primary',

                            ])
                            }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div  class="sendbtn">
                            {{ Form::submit(trans('messages.messages.send'), ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                @if (count($errors))
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @foreach($group->getMessages as $message)
                <div class="panel panel-default">
                    <div>
                        <table class="message text-left">
                            <tr class="autor-message">
                                <td rowspan="2">
                                    <a href="{{ route('users.show.user', ['user' => $message->whoSend['name']]) }}">
                                        @if($message->whoSend['filename'] == "qqq")
                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                        @if($message->whoSend['filename'] != "qqq")
                                            <img src="{{ asset('storage/images/' . $message->whoSend['filename']) }}" alt="" class="img-rounded img-crop-center">
                                        @endif
                                    </a>
                                </td>
                                <td class="tableuser">
                                    <a href="{{ route('users.show.user', ['user' => $message->whoSend['name']]) }}">
                                        {{ $message->whoSend['name'] }}
                                    </a>
                                </td>
                                <td rowspan="2" align="right" width="70%">

                                </td>
                            </tr>
                            <tr class="data-message">
                                <td class="tableuser">
                                    {{ $message->created_at }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="message-content">
                        <a href="#myModal{{ $message->id }}" class="modalWindow" data-toggle="modal" style="text-decoration: none; color: #636b6f">
                            {{ $message->content }}
                        </a>
                    </div>
                    <div class="text-center">
                        @if($message->filename != "not")
                            <a href="#myModal{{ $message->id }}" class="modalWindow" data-toggle="modal">
                                <img src="{{ asset('storage/images/' . $message->filename) }}" alt="" class="img-rounded img-crop-post" style="width: 300px;height: 500px;">
                            </a>
                        @endif
                    </div>
                    <hr>
                    <div class="message">

                    </div>
                    <div class="tags-message text-right message">
                        {{trans('messages.tags').':'}}
                        @foreach($message->tags as $tag)
                            <a href="{{ route('messages.show.asTag' , ['tag' => $tag->title]) }}" class="add">{{ $tag->title . ", " }}</a>
                        @endforeach
                        <hr>
                    </div>
                    <hr>

                    @foreach($message->getComments as $comment)

                        <div id="firstComments" class="col-lg-offset-2">
                            <table class="message text-left">
                                <tr class="autor-message-c">
                                    <td rowspan="2">
                                        @if($comment->whoSend['filename'] == "qqq")
                                            <a href="{{ route('users.show.user', ['user' => $comment->whoSend['name']]) }}">
                                                <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                            </a>
                                        @endif
                                        @if($comment->whoSend['filename'] != "qqq")
                                            <a href="{{ route('users.show.user', ['user' => $comment->whoSend['name']]) }}">
                                                <img src="{{ asset('storage/images/' . $comment->whoSend['filename']) }}" alt="" class="img-rounded img-crop-center-c">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="tableuser">
                                        <a href="{{ route('users.show.user', ['user' => $comment->whoSend['name']]) }}">
                                            {{ $comment->whoSend['name'] }}
                                        </a>
                                    </td>
                                    <td rowspan="2" align="right" width="70%">

                                    </td>
                                </tr>
                                <tr class="data-message-c">
                                    <td class="tableuser">
                                        {{ $comment->created_at }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-offset-2 message-content">
                            {{ $comment->content }}
                        </div>
                        <div class="message">

                        </div>
                    @endforeach

                    <script type="text/javascript">

                        function hideComments() {
                            $('#lastComments').hide(1000, function () {
                                $('#hide').hide();
                                $('#show').show();
                            });
                        }

                        function showComments() {
                            $('#lastComments').show(1000, function () {
                                $('#hide').show();
                                $('#show').hide();
                            });
                        }

                        $(document).ready (function () {
                            $("#lastComments").hide();
                            $("#hide").bind("click", hideComments());
                            $("#show").bind("click", showComments());
                        });

                    </script>

                    <? /*  @if($comments->where('message_id','=', $m->id)->count() > 5555)
                    <a href="#" id="hide" onclick="return false" style="display:none">Скрыть комментарии</a>
                    <a href="#" id="show" onclick="return false">Показать больше комментариев</a>
                    @endif
                     */ ?>

                    <? // $count = 0 ?>

                    <?/*<div id="lastComments123">
                   @foreach($comments->where('message_id','=', $m->id)->take(50) as $c)
                       <? $count++ ?>
                       @if($count > 3)
                       <div class="col-lg-offset-2">
                           <table class="message text-left">
                               <tr class="autor-message-c">
                                   <td rowspan="2">
                                       @if($c->filenameAvatarUser == "qqq")
                                           <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                               <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                           </a>
                                       @endif
                                       @if($c->filenameAvatarUser != "qqq")
                                           <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                               <img src="{{ asset('storage/images/' . $c->filenameAvatarUser) }}" alt="" class="img-rounded img-crop-center-c">
                                           </a>
                                       @endif
                                   </td>
                                   <td class="tableuser">
                                       <a href="{{ route('users.show.user', ['user' => $c->name]) }}">
                                           {{ $c->name }}
                                       </a>
                                   </td>
                                   <td rowspan="2" align="right" width="70%">
                                       @if($c->user_id == $authUser)
                                           {{ Form::model($c , [
                                               'method' => 'DELETE',
                                               'route' => [
                                                   'users.deleteCommentFromMessage',
                                                   $user->name,
                                                   $c->id,
                                               ]
                                           ]) }}
                                           {{ Form::submit(trans('messages.delc'), ['class' => 'btn btn-primary']) }}
                                           {{ Form::close() }}
                                       @endif
                                   </td>
                               </tr>
                               <tr class="data-message-c">
                                   <td class="tableuser">
                                       {{ $c->created_at }}
                                   </td>
                               </tr>
                           </table>
                       </div>
                       <div class="col-lg-offset-2 message-content">
                           {{ $c->content }}
                       </div>
                       @endif
                   @endforeach
               </div>
            */ ?>

                    <div class="form-horizontal">
                        {{ Form::model(null, ['route' => [
                        'storeCommentToMessage',
                        $group->id,
                        $message->id,
                        ], 'style' => 'margin-top: 40px;'
                        ]) }}
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                {{ Form::textarea('content',null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group align-right btn-cmmnt">
                        {{ Form::submit(trans('messages.sendc'), ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
                    @if (count($errors))
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>


                <!-- Кнопка, вызывающее модальное окно -->
                <!-- HTML-код модального окна -->
            @endforeach

        </div>
    </div>
@endsection
</body>
</html>