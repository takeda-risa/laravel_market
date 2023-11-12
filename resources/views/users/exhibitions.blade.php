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
            <li>商品名：{{ $item->name }} {{ $item->price }}円 </li>
            <li>カテゴリ：{{ $item->category->name }}　({{ $item->created_at }})</li>

            [<a href="{{ route('items.edit', $item) }}">編集</a>]
            [<a href="{{ route('items.edit_image', $item) }}">画像を変更</a>]
            <form method="post" class="delete" action="{{ route('items.destroy', $item) }}">
              @csrf
              @method('delete')
              <input type="submit" value="削除" class="delete_btn">
            </form>
            <li>
              @if($item->isOrderBy($item))
              【売り切れ】
              @else
              【出品中】
              @endif
            </li>
          </ul>
        </li>
      @empty
        <li class="goods_list">商品はありません。</li>
      @endforelse
  </ul>
@endsection