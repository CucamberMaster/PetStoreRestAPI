<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['name', 'status', 'category'];

    protected $casts = [
        'category' => 'array',
        'photoUrls' => 'array',
        'tags' => 'array',
    ];

    protected $appends = ['category_id', 'category_name', 'tag_ids', 'tag_names'];

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with Tag
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    // Add accessor methods to get related data
    public function getCategoryIdAttribute()
    {
        return $this->category->id;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function getTagIdsAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('name')->all();
    }
}
