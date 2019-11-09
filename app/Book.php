<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Author/s of this Book
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
