@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
    <dl>
      <dt>商品名</dt>
      <dd>{{ $item->name }}</dd>
      
      <dt>画像</dt>
      <dd>
        @if($item->image !== '')
          <img src="{{ asset('storage/' . $item->image) }}">
        @endif
      </dd>
      
      <dt>カテゴリ</dt>
      <dd>{{ $item->category->name }}</dd>
      
      <dt>説明</dt>
      <dd>{{ $item->description }}</dd>
      
        @if(!$item->isOrderBy($item))
          <form method="post" class="like" action="{{ route('items.finish', $item) }}">
            @csrf
            <button class=button>購入</button>
          </form>      
        @else
          【売り切れ】
        @endif      
    </dl>  
  @endsection