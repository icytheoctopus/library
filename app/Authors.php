<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    /**
     * Books this Author has wrote
     */
    public function books()
    {
        return $this->belongsToMany(Books::class);
    }
}
