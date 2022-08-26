<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }
}
