<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'category',
        'description',
        'created_by',
    ];
    protected $attributes = [
        'description' => ''
    ];

    public function categories() {
        return $this->belongsToMany(Post::class,'post_category');
    }
}
