<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * Books this Author has wrote
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
