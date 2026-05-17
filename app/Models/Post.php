<?php

namespace App\Models;

use App\Casts\CompressedBinaryCast;
use Illuminate\Database\Eloquent\Casts\AsBinary;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'tags',
        'publish_date',
        'lang',
        'visibility'
    ];

    protected function casts()
    {
        return [
            'uuid' => AsBinary::uuid(),
            'content' => CompressedBinaryCast::class,
            'tags' => 'array'
        ];
    }
}
