<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'release_date'];

    /**
     * Author/s of this Book
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
