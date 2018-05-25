<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="nameuser"><h2>{{ $group->name }}</h2>
            </div>
            <div  class="thumbnailmy">
                <div class="align-right ">
                    @if($group->avtar == "qqq")
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
                        <td class="tdpad"><div class="textlight">{{trans('messages.sn').':'}}</div></td>
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
                                <a href="{{ route('users.show.user', $message->whoSend['name']) }}">
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
                                q
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
                        <a href="#myModal{{ $m->id }}" class="modalWindow" data-toggle="modal">
                            <img src="{{ asset('storage/images/' . $message->filename) }}" alt="" class="img-rounded img-crop-post">
                        </a>
                    @endif
                </div>
                <hr>
                <div class="message">
                    q
                </div>
                <div class="tags-message text-right message">
                    {{trans('messages.tags').':'}}
                    @foreach($message->tags as $tag)
                        <a href="{{ route('messages.show.asTag' , ['tag' => $tag->title]) }}" class="add">{{ $tag->title . ", " }}</a>
                    @endforeach

                </div>
                <hr>
                @if( $message->author != $message->user_id_sender)
                    Автор сообщения : <a href="{{ route('users.show.user', ['user' => $m->whoAuthor['name']]) }}">{{ $m->whoAuthor['name'] }}</a>
                @endif
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
            </div>
    </div>
    @endforeach
    <div class="form-horizontal">
        {{ Form::model(null, ['route' => [
        'users.storeCommentToMessage',
        $authUserName,
        $message->id,
        ]
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
    @endforeach

</div>