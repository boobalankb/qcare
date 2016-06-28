<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    use \Conner\Tagging\Taggable;

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

    /**
     * Local scope filter for location and distance.
     *
     * @param $query object
     * @param $latitude string
     * @param $longitude string
     * @param $distance int
     * @param $unit string
     *
     * @return Builder $query object
     */
    public function scopeFilterByLocationAndDistance($query, $latitude, $longitude, $distance, $unit)
    {
        $latitude = (double) $latitude;
        $longitude = (double) $longitude;
        if($unit == 'km') $unitConv = 3959;
        else $unitConv = 6371;

        $haversine = "(".$unitConv." * acos(cos(radians($latitude)) * cos(radians(charities.latitude)) * cos(radians(charities.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(charities.latitude))))";

        return $query
            ->selectRaw("{$haversine} AS distance")
            ->orderBy('distance', 'asc')
            ->whereRaw("{$haversine} < ?", [$distance]);
    }
}
