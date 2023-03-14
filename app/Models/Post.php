<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'content',
        'created_by',
        'slug',
        'is_pinned',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postSaves()
    {
        return $this->hasMany(PostSave::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}