<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Item;


use App\Http\Requests\UserRequest;
use App\Http\Requests\UserImageRequest;

use App\Services\FileUploadService;


class UserController extends Controller
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
        $user = \Auth::user();
        return view('index', [
          'title' => 'トップページ',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, FileUploadService $service){
        //画像投稿処理
        $user = Auth::user();
        $path = $service->saveImage($request->file('image'));

        User::create([
          'user_id' => \Auth::user()->id,
          'name' => $request->name,
          'email' => $request->email,
          'profile' => $request->profile,
          'image' => $path, // ファイルパスを保存
        ]);
        session()->flash('success', '投稿を追加しました');
        return redirect()->route('users.show',auth()->user()->id);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      // $user = Auth::user();

      $user = User::find($id);
      $itemCount = $user->items()->count();
      $purchase_items = $user->OrderItems;
      // $seller = User::with('name')->get();
      
      return view('users.index', [
          'title' => 'プロフィール詳細',
          'user' => $user,
          'itemCount' => $itemCount,
          'purchase_items' => $purchase_items,
          // 'seller' => $seller,
      ]);
    }

    // 編集フォーム
    public function edit()
    {
      $user = \Auth::user();
      return view('profile.edit', [
        'title' => 'プロフィール編集',
        'user' => $user,
      ]);
    }
    
    public function update(UserRequest $request)
    {
      $user = Auth::user();
      $user->name = $request->name;
      $user->profile = $request->input('profile') ?? '';
      $user->save();
      session()->flash('success', 'ユーザー情報を変更しました');
      return redirect()->route('users.show',auth()->user()->id);
    }
    
    // 画像変更処理
    public function editImage()
    {
      $user = Auth::user();
      return view('profile.edit_image', [
          'title' => '画像変更画面',
          'user' => $user,
      ]);
    }
    
    // 画像変更処理
    public function updateImage(UserImageRequest $request, FileUploadService $service){
        
 
        //画像投稿処理
        $path = $service->saveImage($request->file('image'));
        $user = Auth::user();
        if($user->image !== ''){
          \Storage::disk('public')->delete('photos/' . $user->image);
        }
        $user->update([
          'image' => $path, // ファイル名を保存
        ]);
        session()->flash('success', '画像を変更しました');
        return redirect()->route('users.show',auth()->user()->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    // 投稿削除処理
    public function destroy($id)
    {
        $user = User::find($id);
 
        // 画像の削除
        if($user->image !== ''){
          \Storage::disk('public')->delete($user->image);
        }
 
        $user->delete();
        session()->flash('success', '投稿を削除しました');
        return redirect()->route('users.index');
    }
    
    public function exhibitions()
    {
        $user = \Auth::user();
        $items = $user->items()->latest()->get();
        
        return view('users.exhibitions', [
          'title' => '出品商品一覧',
          'items' => $items,
        ]);
    }
}
