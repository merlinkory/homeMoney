<!doctype html>
<html>
<head>
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="{ assert('css/app.css') }}" rel="stylesheet">
    <style>
        .my_input{
            font-size: 36px;
            padding: 10px;
            margin-top: 5px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<form class="col-3 offset-4 border rounded" style="text-align: center; margin-top: 30%;" method="POST" action="/login">
    @csrf
    <div class="form-group">
        <input class="form-control my_input" id="email" name="email" type="text" placeholder="Email">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input  class="form-control my_input" id="password" name="password" type="password">
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-lg btm-primary my_input" type="submit" name="sendMe" value="1">Login</button>
    </div>
</form>
</body>
</html>
