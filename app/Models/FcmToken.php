<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = ['user_id', 'token'];
    protected $table = 'fcm_tokens';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
