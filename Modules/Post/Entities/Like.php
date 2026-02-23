<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\User;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}