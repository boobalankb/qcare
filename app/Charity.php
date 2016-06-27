<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
	/**
     * Get the images for the charity.
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * Get the category for charity.
     */
    public function category()
    {
        return $this->belongsTo('App\CharityCategory', 'charity_category_id');
    }
}
