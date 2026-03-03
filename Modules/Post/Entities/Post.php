<?php

namespace Modules\Post\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Entities\Comment;
use Modules\Post\Entities\Like;
use Modules\Post\Entities\PostImage;
use Modules\Post\Entities\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

   
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
    

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}

