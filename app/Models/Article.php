<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasAuthor, ModelHelpers;
    //
    const TABLE = 'articles';
    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'author_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
