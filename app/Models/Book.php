<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user_like(){
        return $this->belongsToMany(User::class, 'likes','book_id','user_id');
    }

    public function favourite(){
        return $this->belongsToMany(User::class, 'favourites','book_id','user_id');
    }
}
