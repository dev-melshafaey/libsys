<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function borrows() {
        return $this->hasOne('App\BookBorrow');
    }
}
