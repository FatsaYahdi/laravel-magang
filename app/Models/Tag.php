<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable = [
        'tag',
        'created_by',
        'description'
    ];
    protected $attributes = [
        'description' => ''
    ];

    public function tags() {
        return $this->belongsToMany(Post::class,'post_tag');
    }
}