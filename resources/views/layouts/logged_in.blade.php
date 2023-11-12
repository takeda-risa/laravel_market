@extends('layouts.default')
 
@section('header')
<header>
    <ul class="header_nav">
      <li style="color:blue;font-weight:bold;"><a href="{{ route('index') }}">Market</a></li> 
      <li>こんにちは、{{ Auth::user()->name }}さん！</li>
      <li>
        <a href="{{ route('users.show', Auth::user()) }}">プロフィール</a>
      </li>
      <li>
        <a href="{{ route('likes.index') }}">
          お気に入りリスト
        </a>
      </li>
      <li>
        <a href="{{ route('users.exhibitions', Auth::user()) }}">
          出品商品一覧
        </a>
      </li>
      <li>
          <form action="{{ route('logout') }}" method="POST">
              @csrf
              <input type="submit" value="ログアウト" class="logout">
          </form>
      </li>
    </ul>

</header>
@endsection