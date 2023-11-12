<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Category;
use App\Models\Like;
use App\Models\Order;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemImageRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Controllers\CategoryController;

use App\Services\FileUploadService;



class ItemController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::where('user_id', '!=', \Auth::user()->id)->latest()->get();
        return view('index', [
          'title' => 'トップページ',
          'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_ids = Category::all();
        return view('items.create', [
          'title' => '新規出品',
          'category_ids' => $category_ids,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request, FileUploadService $service)
    {
        //画像投稿処理
        $path = $service->saveImage($request->file('image'));

        $item = Item::create([
          'user_id' => \Auth::user()->id,
          'name' => $request->name,
          'description' => $request->description,
          'price' => $request->price,
          'category_id' => $request->category_id,
          'image' => $path,
        ]);
        \Session::flash('success', '商品を登録しました');
        return redirect()->route('items.show', $item->id);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::find($id);
        $category_ids = Category::all();
        
        return view('items.show', [
          'title' => '商品詳細',
          'item'  => $item,
          'category_ids' => $category_ids,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $item = Item::find($id);
        $category_ids = Category::all();
        if ($item->user_id !== $user->id) {
            return redirect()->route('items.show', $item->id);
        }
        
        return view('items.edit', [
          'title' => '投稿編集',
          'item'  => $item,
          'category_ids' => $category_ids,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ItemUpdateRequest $request)
    {
        $item = Item::find($id);
        $item->update($request->only(['name', 'description', 'price', 'category_id']));
        session()->flash('success', '編集しました');
        return redirect()->route('items.show', $item->id);
    }

    // 画像変更処理
    public function editImage($id)
    {
      $item = Item::find($id);
      return view('items.edit_image', [
          'title' => '画像変更画面',
          'item' => $item,
      ]);
    }
    
      
    // 画像変更処理
    public function updateImage($id, ItemImageRequest $request, FileUploadService $service){
 
      $path = $service->saveImage($request->file('image'));
 
      $item = Item::find($id);
      if($item->image !== ''){
        \Storage::disk('public')->delete('photos/' . $item->image);
      }
      $item->update([
        'image' => $path, // ファイル名を保存
      ]);
 
      \Session::flash('success', '画像を変更しました');
      return redirect()->route('items.show', $item->id);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        
        // 画像の削除
        if($item->image !== ''){
          \Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();
        \Session::flash('success', '削除しました');
        return redirect('/');
    }
    
    
    public function toggleLike($id){
        $user = \Auth::user();
        $item = Item::find($id);

        if($item->isLikedBy($user)){
            // いいねの取り消し
            $item->likes->where('user_id', $user->id)->first()->delete();
            \Session::flash('success', 'いいねを取り消しました');
        } else {
            // いいねを設定
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            \Session::flash('success', 'いいねしました');
        }
        return redirect('/');
    }
  
    public function confirm($id)
    {
        $user = \Auth::user();
        $item = Item::find($id);

        return view('items.confirm', [
          'title' => '購入確認',
          'item' => $item,
        ]);
    }
    
    public function finish($id)
    {
        $user = \Auth::user();
        $item = Item::find($id);
        
        // dd($item->isOrderBy($item));
        if(!$item->isOrderBy($item)){
            Order::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            \Session::flash('success', '購入しました');
        }else{
            \Session::flash('success', '申し訳ありません。ちょっと前に売り切れました。');
            return redirect()->route('items.show', $item->id);
        }

        return view('items.finish', [
          'title' => 'ご購入ありがとうございました。',
          'item' => $item,
        ]);
    }  
  
    public function toggleOrder($id){
        $user = \Auth::user();
        $item = Item::find($id);

        if($item->isOrderBy($user)){
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            \Session::flash('success', '購入しました');
        }
        return redirect('/');
    }
  
}
