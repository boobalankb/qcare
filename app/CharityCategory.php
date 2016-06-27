<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharityCategory extends Model
{
    /**
     * Get the charities for a category.
     */
    public function charities()
    {
        return $this->hasMany('App\Charity', 'charity_category_id');
    }
}
