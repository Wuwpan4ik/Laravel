<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    public function book_connect() {
        return $this->hasMany('App\Book_connect');
    }

    final function getShortContent() {
        return Str::words((string) $this['text'], 10);
    }
}
