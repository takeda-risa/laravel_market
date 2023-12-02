@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <ul class="posts">
      @forelse($like_items as $item)
        <li class="goods_list">
            <div>
              <div>
                <div>
                  <div>
                    @if($item->image !== '')
                        <a href="{{ route('items.show', $item) }}">
                          <img src="{{ asset('storage/' . $item->image) }}">
                        </a>
                    @else
                      <a href="{{ route('items.show', $item) }}">
                        <img src="{{ asset('images/no_image.png') }}">
                      </a>
                    @endif
                    {{ $item->description }} 
                  </div>
                  <div>
                    商品名：{{ $item->name }}　値段：{{ $item->price }}
                  </div>
                  <div>
                    カテゴリ：{{ $item->category->name }}({{ $item->created_at }})
                  </div>
                  <div>
                    @if($item->isOrderBy($item))
                    【売り切れ】
                    @else
                    【出品中】
                    @endif
                  </div>
                </div>
            </div>
        </li>
      @empty
          <li class="goods_list">商品はありません</li>
      @endforelse
  </ul>@endsection