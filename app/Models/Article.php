<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    const TABLE = 'articles';
    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'author_id',
    ];
}
