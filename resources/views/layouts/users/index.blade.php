@extends('layouts.base')

@section('title', trans('messages.users'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('messages.users')}}</div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                {{ Form::model(null , [
                                    'method' => 'GET',
                                    'route' => [
                                    'users.index',
                                    ]])
                                }}
                                <div class="col-md-10">
                                    {{ Form::text('search', null, ['class' => 'form-control']) }}
                                    {{ Form::select('searchOption', ['users' => 'Пользователи', 'groups' => 'Группы'], '', ['class' => 'form-control', 'style' => 'margin-top:15px;']) }}
                                </div>
                                <div class="col-md-2">
                                    {{ Form::submit('Поиск', ['class' => 'btn btn-primary'])}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    @if($searchResult == 'users')
                    @foreach($searchUsers as $user)
                        <div class="text-center">
                            <hr>
                            <table class="message text-left">
                                <tr class="autor-message"><td rowspan="6">
                                        <a href="{{ route('users.show.user', ['user' => $user->name]) }}">
                                            @if($user->filename == "qqq")
                                                <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                            @endif
                                            @if($user->filename != "qqq")
                                                <img src="{{ asset('storage/images/' . $user->filename) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="tableuser">
                                        <a href="{{ route('users.show.user', ['user' => $user->name]) }}">{{ $user->name }}</a>
                                    </td>
                                        @if($userAuth->name != $user->name)
                                            @if($userAuth->inboxFriends->contains($user) || $userAuth->outboxFriends->contains($user))
                                                <td style="font-size: 11px">
                                                    Уже в друзьях
                                                    {{ Form::model(null , [
'method' => 'DELETE',
'route' => [
'users.deleteFromFriendList',
'user' => $user,
]
]) }}
                                                    {{ Form::submit(trans('Удалить из друзей'), ['class' => 'btn btn-primary']) }}
                                                    {{ Form::close() }}
                                                </td>
                                            @elseif ($userAuth->outboxRequestFriends->contains($user))
                                                <td style="font-size: 11px">
                                                    Вы отправили заявку
                                                    {{ Form::model(null , [
    'method' => 'DELETE',
    'route' => [
        'users.deleteRequestToBeFriends',
        'user' => $user,
    ]
    ]) }}
                                                    {{ Form::submit(trans('Отменить заявку в друзья'), ['class' => 'btn btn-primary']) }}
                                                    {{ Form::close() }}
                                                </td>
                                            @elseif ($userAuth->inboxRequestFriends->contains($user))
                                                <td style="font-size: 11px">
                                                    Вам отправили заявку
                                                    {{ Form::model(null , [
    'method' => 'PUT',
    'route' => [
        'users.addToFriendList',
        'user' => $user,
    ]
    ]) }}
                                                    {{ Form::submit(trans('Принять заявку в друзья'), ['class' => 'btn btn-primary']) }}
                                                    {{ Form::close() }}
                                                </td>
                                            @else
                                            <td>
                                                {{ Form::model($user , [
                                                    'method' => 'POST',
                                                    'route' => [
                                                        'users.requestToBeFriends',
                                                        $user->name
                                                    ]
                                                    ]) }}
                                                {{ Form::submit(trans('Добавить в друзья'), ['class' => 'btn btn-primary']) }}
                                                {{ Form::close() }}
                                            </td>
                                            @endif
                                        @endif
                                </tr>
                                <tr class="data-message"><td class="tableuser">{{ $user->first_name.' '.$user->last_name.' '.$user->third_name }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ $user->city.', '.$user->country }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.num').': '.$user->number }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.email').': '.$user->email }}</td></tr>
                                <tr class="data-message"><td class="tableuser">{{ trans('messages.regdate').': '.$user->created_at }}</td></tr>
                                <? // @if($authUserName == "admin" and $u->name != "admin" or $authUser->admin == '1' and $u->admin == '0' and $u->name != 'admin' or $odmen == 1 and $u->name != 'admin' and $u->admin != '1')
                                ?>
                                @if($authUserName == "Admin" and $user->name != "Admin" or $authUser->admin == '1' and $user->admin == '0' and $user->name != 'Admin')
                                <tr>
                                    <td class="align-right">
                                        Удаление пользователя
                                    </td>
                                    <td class="align-right" colspan="2">
                                        {{ Form::model($user , [
                                             'method' => 'DELETE',
                                             'route' => [
                                                 'users.destroy',
                                                  $user->id
                                             ]
                                         ]) }}
                                        {{ Form::submit("Удалить", ['class' => 'btn btn-primary']) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        @endforeach
                        @endif
                        <hr>
                        @if($searchResult == 'groups')
                            @foreach($searchUsers as $user)
                                <div class="text-center">
                                    <hr>
                                    <table class="message text-left">
                                        <tr class="autor-message"><td rowspan="6">
                                                <a href="{{ route('users.show.user', ['user' => $user->name]) }}">
                                                    @if($user->avatar == "qqq")
                                                        <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                                    @endif
                                                    @if($user->avatar != "qqq")
                                                        <img src="{{ asset('storage/images/' . $user->avatar) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="tableuser">
                                                <a href="{{ route('showGroup', ['group' => $user->id]) }}">{{ $user->name }}</a>
                                            </td>
                                            <td>
                                            <td>
                                                @if($user->getUsers->contains($authUser))
                                                {{ Form::model($user , [
                                                    'method' => 'DELETE',
                                                    'route' => [
                                                        'quitGroup',
                                                        $user
                                                    ]
                                                    ]) }}
                                                {{ Form::submit(trans('Выйти из группы'), ['class' => 'btn btn-primary']) }}
                                                {{ Form::close() }}
                                                @else
                                                    {{ Form::model($user , [
                                                        'method' => 'POST',
                                                        'route' => [
                                                            'joinGroup',
                                                            $user
                                                        ]
                                                        ]) }}
                                                    {{ Form::submit(trans('Вступить в группу'), ['class' => 'btn btn-primary']) }}
                                                    {{ Form::close() }}
                                                @endif
                                            </td>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
