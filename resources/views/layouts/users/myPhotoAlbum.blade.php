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
                @foreach($user->photoAlbum as $image)
                    <div class="col-lg-4">
                        <section class="albumPhoto" style="text-align: center; margin-bottom: 50px">
                            <img src="{{ asset('storage/images/' . $image->filename) }}" alt="" style="width: 350px; height: 500px">
                        </section>
                    </div>
                @endforeach
        </div>
        <div class="container">
            <div class="col-lg-12">
                <div class="col-lg-8">
                    <div class="panel panel-default" style="">
                        <div class="linetext">Добавить изображение в фотоальбом</div>
                        <div class="form-horizontal">
                            <div class="form-group">
                                {{ Form::model(null, ['files' => true, 'method' => 'POST', 'route' => ['users.storePhotoToAlbum',$user->name,] ]) }}
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
