@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <div style="margin:10px auto;">
    <a href="{{ route('items.create') }}">新規出品</a>
  </div>
  <ul>
      @forelse($items as $item)
          <li class="goods_list">
            <ul>
              
              <li>
                @if($item->image !== '')
                  <a href="{{ route('items.show', $item) }}">
                    <img src="{{ asset('storage/' . $item->image) }}">
                  </a>
                @endif
                {{ $item->description }}
              </li>              
              
              <li>商品名：{{ $item->name }} 
                <a class="like_button">{{ $item->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                <form method="post" class="like" action="{{ route('items.toggle_like', $item) }}">
                  @csrf
                  @method('patch')
                </form>              
              </li>

              <li>カテゴリ：{{ $item->category->name }}　({{ $item->created_at }})</li>
              
            </ul>
      @empty
          <li>商品はありません。</li>
      @endforelse
  </ul>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    /* global $ */
    $('.like_button').each(function(){
      $(this).on('click', function(){
        $(this).next().submit();
      });
    });
  </script>
@endsection