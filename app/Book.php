<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function connect() {
        return $this->hasMany('App\Book_connect');
    }
}
