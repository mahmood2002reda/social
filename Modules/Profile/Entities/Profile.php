<?php

namespace Modules\Profile\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Profile\Entities\User;

class Profile extends Model {
    protected $fillable = ['user_id', 'profile_picture', 'bio'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}