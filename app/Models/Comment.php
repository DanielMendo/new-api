<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'parent_id',
        'post_id',
        'user_id',
        'content',
    ];

    protected $appends = [
        'likes',
        'is_liked',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes_comments')->withTimestamps();
    }

    public function getIsLikedAttribute()
    {
        $user = User::find(Auth::id());
        if (!$user) return false;

        return $user->likeComment()->where('comment_id', $this->id)->exists();
    }

    public function getLikesAttribute()
    {
        return $this->likedByUsers()->count();
    }
}
