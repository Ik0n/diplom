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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <table class="table">
                    <tr>
                        <td colspan="2">Отправитель</td>
                        <td>Содержимое</td>
                        <td class="align-right">Дата и время отправления</td>
                    </tr>
                    @foreach($dialog->getMessages as $message)
                        <tr>
                                <td>
                                    @if($message->whoSend['filename'] == "qqq")
                                        <img src="{{ asset('storage/images/' . 'defavatar.png') }}" alt="" class="img-rounded img-crop-center-c">
                                    @endif
                                    @if($message->whoSend['filename'] != "qqq")
                                        <img src="{{ asset('storage/images/' . $message->whoSend['filename']) }}" alt="" class="img-rounded img-crop-center-c">
                                    @endif
                                </td>
                                <td>{{ $message->whoSend['name'] }} :</td>
                                <td>{{ $message->content }}</td>
                                <td class="align-right">{{ $message->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12 text-center">
            {{ Form::model(null, [
                'method' => 'POST',
                'route' => [
                    'dialogStoreMessage',
                    $dialog
                ]]) }}
            {{ Form::textarea('content', null, ['class' => 'form-control']) }}
            <hr>
            {{ Form::submit('Отправить', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
</body>
</html>