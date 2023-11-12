<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
 
    <!--Bootstrapの読み込み-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
    <link rel="stylesheet" href="{{ secure_asset('css/styles.css') }}">
</head>
<body>
 
{{-- divを追加 --}}
<div class="container">
 
    @yield('header')
 
    {{-- エラーメッセージを出力 --}}
    @foreach($errors->all() as $error)
      <p class="error">{{ $error }}</p>
    @endforeach
 
    {{-- 成功メッセージを出力 --}}
    @if (\Session::has('success'))
        <div class="success">
            {{ \Session::get('success') }}
        </div>
    @endif
 
    @yield('content')
 
{{-- 閉じタグも忘れずに --}}
</div>
 
</body>
</html>