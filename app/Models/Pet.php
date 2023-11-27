<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{

    protected $casts = [
        'category' => 'array',
        'photoUrls' => 'array',
        'tags' => 'array',
    ];

    protected $appends = ['category_id', 'category_name', 'tag_ids', 'tag_names'];

}
