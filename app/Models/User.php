<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'mail', 'pass', 'permit'];

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
