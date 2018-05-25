@extends('layouts.base')
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @section('content')
        <div class="container">
            <div class="col-lg-12">
                {{ Form::model($authUser , [
                'method' => 'GET',
                'route' => [
                    'dialogCreate',
                    $authUser,
                ]]) }}
                {{ Form::submit('Создать диалог', ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            </div>
        </div>
        <div class="container">
            <div class="col-lg-12">
                @foreach($user->dialogs as $dialog)
                    <div class="text-center">
                        <hr>
                        <table class="message text-left">
                            <tr class="autor-message"><td rowspan="6">
                                    <a href="{{ route('showDialog', ['dialog' => $dialog->id]) }}">
                                        @if($dialog->avatar == "qqq")
                                            <img src="{{ asset('storage/images/' . "defavatar.png") }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                        @endif
                                        @if($dialog->avatar != "qqq")
                                            <img src="{{ asset('storage/images/' . $dialog->avatar) }}" alt="" class="img-rounded img-crop-center-list img-thumbnail">
                                        @endif
                                    </a>
                                </td>
                                <td class="tableuser">
                                    <a href="{{ route('showDialog', ['dialog' => $dialog->id]) }}">{{ $dialog->name }}</a>
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