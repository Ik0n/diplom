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
                <div class="col-lg-8">
                    <div class="panel panel-default" style="">
                        <div class="linetext">Создать группу</div>
                        <div class="form-horizontal">
                            <div class="form-group">
                                {{ Form::model(null, ['files' => true, 'method' => 'POST', 'route' => ['users.storeGroup',$user->name,] ]) }}
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-md-offset1">
                                    {{ Form::label('name', 'name') }}
                                </div>
                                <div class="col-md-12 col-md-offset1">
                                    {{ Form::text('name') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-11 col-md-offset-1">
                                    {{ Form::label ('file', "Добавить аватар") }}
                                </div>
                                <div class="col-md-11 col-md-offset-1">
                                    {{
                                    Form::file('file', [
                                    'aria-describedby' => 'file-help',
                                    'class' => 'btn btn-primary',

                                    ])
                                    }}
                                </div>
                                <div class="form-group" style="margin: 10px 20px 20px 500px;">
                                    <div>
                                        {{ Form::submit(trans('messages.messages.send'), ['class' => 'btn btn-primary']) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>
</html>