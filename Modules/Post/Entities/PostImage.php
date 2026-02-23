<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Entities\Post;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'image_path'];

    
}