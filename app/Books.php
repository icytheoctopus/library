<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /**
     * Author/s of this Book
     */
    public function authors()
    {
        return $this->belongsToMany(Authors::class);
    }
}
