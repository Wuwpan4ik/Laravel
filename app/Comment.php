<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use NodeTrait;
    protected $fillable = [
        'title', 'description', 'user_id', 'user_to'
    ];
}
