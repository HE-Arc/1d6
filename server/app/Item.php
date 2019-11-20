<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $attributes = [
        'name',
        'description',
        'url',
        'image_url'
    ];

    /**
     * The groups which poll over this item
     */
    public function groups() 
    {
        return $this->belongsToMany('App\Groups', 'group_items');
    }
}
