@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" >
      @csrf
      <div>
          <label>
            商品名:
            <input type="text" name="name">
          </label>
      </div>
      <div>
          <label>
            商品説明:
            <input type="text" name="description">
          </label>
      </div>
      <div>
          <label>
            価格:
            <input type="number" name="price">
          </label>
      </div>      
      <div>
        <select name="category_id">
            <?php foreach($category_ids as $category): ?>
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            <?php endforeach; ?>
        </select>
      </div>
      <div>
          <label>
            画像:
            <input type="file" name="image">
          </label>
      </div>
      <input type="submit" value="出品">
  </form>
@endsection