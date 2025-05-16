<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'html',
        'image',
        'is_published',
    ];

    protected $appends = [
        'is_bookmarked',
        'is_liked',
        'likes_count',
        'comments_count',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function getIsBookmarkedAttribute()
    {
        $user = User::find(Auth::id());
        if (!$user) return false;

        return $user->favoritePosts()->where('post_id', $this->id)->exists();
    }

    public function getIsLikedAttribute()
    {
        $user = User::find(Auth::id());
        if (!$user) return false;

        return $user->likePost()->where('post_id', $this->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likedByUsers()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentByUsers()
    {
        return $this->belongsToMany(User::class, 'comments')->withTimestamps();
    }

    public function getCommentsCountAttribute()
    {
        return $this->commentByUsers()->count();
    }
}
