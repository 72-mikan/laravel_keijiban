<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'file_pass', 'file_type'];


    public function post()
    {

        return $this->belongsTo('App\Models\Post');
    }
}
