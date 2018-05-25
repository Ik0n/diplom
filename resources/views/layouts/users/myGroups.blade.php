@extends('layouts.base')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $user->name }}</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @section('content')
        <div class="container">
            <div class="col-lg-12">
                {{ Form::model($user , [
                'method' => 'GET',
                'route' => [
                    'users.groupCreate',
                    $user->name,
                ]]) }}
                {{ Form::submit('Создать группу', ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            </div>
        </div>
        <div class="container">
            <div class="col-lg-12">
                @foreach($user->groups as $group)
                    <div class="text-center">
                        <hr>
                        <table class="message text-left">
                            <tr class="autor-message"><td rowspan="6">
                                    <a href="{{ route('users.show.user', ['user' => $group->name]) }}">
                                        @if($group->avatar == "qqq")
                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                        @endif
                                        @if($group->avatar != "qqq")
                                            <img src="{{ asset('storage/images/' . $group->avatar) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                        @endif
                                    </a>
                                </td>
                                <td class="tableuser">
                                    <a href="{{ route('showGroup', ['group' => $group->id]) }}">{{ $group->name }}</a>
                                </td>
                                <td>
                                <td>
                                    @if($group->getUsers->contains($authUser))
                                        {{ Form::model($group , [
                                            'method' => 'DELETE',
                                            'route' => [
                                                'quitGroup',
                                                $group
                                            ]
                                            ]) }}
                                        {{ Form::submit(trans('Выйти из группы'), ['class' => 'btn btn-primary']) }}
                                        {{ Form::close() }}
                                    @endif
                                </td>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
</body>
</html>