<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "name"
    ];
    public function items()
    {
        // カテゴリから見た場合は一対多になる
        return $this->hasMany(Item::class);
    }
}
