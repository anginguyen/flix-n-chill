<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public $timestamps = [ "created_at" ]; 

    public function media() {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
