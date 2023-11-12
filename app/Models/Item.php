<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'name', 
        'description', 
        'price', 
        'category_id', 
        'image'
    ];
        
    public function user(){
      return $this->belongsTo(User::class);
    }
        
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function likes(){
        return $this->hasMany(Like::class);
    }
 
    public function likedUsers(){
        return $this->belongsToMany(User::class, 'likes');
    }
    
    public function isLikedBy($user){
        $liked_users_ids = $this->likedUsers->pluck('id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }
    
    public function orders(){
        return $this->hasMany(Order::class);
    }
 
    public function OrderUsers(){
        return $this->belongsToMany(User::class, 'orders');
    }
    
    public function isOrderBy($item){
        $order_item_ids = $this->orders->pluck('item_id');
        $result = $order_item_ids->contains($item->id);
        return $result;
    }
    
}
