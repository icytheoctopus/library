<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;
    protected $fillable = ['firstname', 'lastname','age', 'address'];
    /**
     * Books this Author has wrote
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
