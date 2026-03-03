<?php

namespace Modules\Profile\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Profile\Entities\Profile;

class User extends Model
{
    use HasFactory;

  protected $fillable = [
        'name',
        'email',
        'password',
    ];    
   public function profile() {
        return $this->hasOne(Profile::class);
    }
}
