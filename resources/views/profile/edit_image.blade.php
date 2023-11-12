@extends('layouts.logged_in')
 
@section('content')
    <h1>{{ $title }}</h1>
    <h2>現在の画像</h2>
    @if($user->image !== '')
        <img src="{{ \Storage::url($user->image) }}">
    @endif
    <form
        method="POST"
        action="{{ route('profile.update_image', $user->id) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('patch')
        <div>
            <label>
                画像を選択:
                <input type="file" name="image">
            </label>
        </div>
        <input type="submit" value="更新">
    </form>
    <a href="{{ route('users.show',auth()->user()->id) }}">戻る</a>
@endsection