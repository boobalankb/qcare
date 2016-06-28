<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Get the charity that owns the image.
     */
    public function charity()
    {
        return $this->belongsToMany('App\Charity');
    }
}
