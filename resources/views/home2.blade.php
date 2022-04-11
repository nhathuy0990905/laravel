<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
</head>
<body>
    @include('parts.header')
    <h1>{{$welcome}}</h1>
    <h2>{{$content}}</h2>
    @for($i=1;$i<=5;$i++)
        <h3>In lần thứ {{$i}} : {{request()->key}}</h3> <!-- Lấy dữ liệu của "key" trên url -->
    @endfor
    @if ($check==10)
        <p>Giá trị của người dùng là : {{$check}}</p>
    @endif
    @include('parts.footer')
</body>
</html>