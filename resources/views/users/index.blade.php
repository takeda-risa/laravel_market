@extends('layouts.logged_in')
@section('title', $title)
@section('content')
  <h1>{{ $title }}</h1>
  <dl>
    <dt>名前</dt>
    <dd>{{ $user->name }}</dd>
    
    <dt>プロフィール画像</dt>
    <dd style="margin-bottom:0.5rem;">                    
      @if($user->image !== '')
          <img src="{{ \Storage::url($user->image) }}">
      @else
          <img src="{{ asset('images/no_image.png') }}">
      @endif
    </dd>
    <dd>
      [<a href="{{ route('profile.edit_image') }}">画像を変更</a>]
    </dd>
    
    <dt>プロフィール</dt>
    <dd style="margin-bottom:0.5rem;">
      @if($user->profile !== '')
          {{ $user->profile }}
      @else
          プロフィールが設定されていません。
      @endif
    </dd>
    <dd>
      [<a href="{{ route('profile.edit') }}">プロフィールを変更</a>]
    </dd>
    
    <dd>出品数：{{$itemCount}}</dd>
    
    <dt>購入履歴</dt>
    <dd>
      @forelse($purchase_items as $item)
        <ul>
          <li>
            <a href="{{ route('items.show', $item) }}">{{ $item->name }}</a>：{{ $item->price }}円 {{ $item->user->name }}さん
          </li>
        </ul>
      @empty
          <li>商品はありません</li>
      @endforelse
    </dd>
  </dl>

@endsection