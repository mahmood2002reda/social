<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id'];

    // علاقة التعليقات بالمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة التعليقات بالمنشور
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
