<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Post extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'html',
        'image',
        'image_urls',
        'is_published',
    ];

    protected $appends = [
        'is_bookmarked',
        'is_liked',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'image_urls' => 'array',
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
