@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
  @if(isset($item->id))
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
      
      <a href="{{ route('items.confirm', $item) }}" class="button">購入する</a>
    </dl>
  @else
  その商品はありません
  @endif    

@endsection