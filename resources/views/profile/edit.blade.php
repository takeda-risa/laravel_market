@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  [<a href="{{ route('users.show',auth()->user()->id) }}">戻る</a>]
  <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('patch')
      <div class="profile_edit">
        <label>
            名前：
            <input type="text" name="name" value="{{ $user->name }}">
        </label>  
        <label>
            プロフィール：<br>
            <textarea type="text" cols="40" rows="4" name="profile">{{ $user->profile }}</textarea>
        </label> 
      </div>
      
      <input type="submit" value="更新">
  </form>
@endsection