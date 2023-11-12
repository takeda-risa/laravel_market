@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method="POST" action="{{ route('items.update',$item) }}">
      @csrf
      @method('patch')
      <div>
          <label>
            商品名:
            <input type="text" name="name" value="{{ $item->name }}">
          </label>
      </div>
      <div>
          <label>
            商品説明:
            <input type="text" name="description" value="{{ $item->description }}">
          </label>
      </div>
      <div>
          <label>
            価格:
            <input type="number" name="price" value="{{ $item->price }}">
          </label>
      </div>      
      <div>
        <select name="category_id">
            <?php foreach($category_ids as $category): ?>
                    <?php if($category->id === $item->category_id): ?>
                        <option value="{{ $category->id }}" selected>
                            {{ $category->name }}
                        </option>
                    <?php else: ?>
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    <?php endif; ?>
            <?php endforeach; ?>
        </select>
      </div>
      
      
      <input type="submit" value="出品">
  </form>
@endsection