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
    protected $fillable = [
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
        return $this->belongsToMany('App\Group', 'group_items');
    }

    public function polls()
    {
        return $this->belongsToMany('App\Poll', 'poll_items');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'item_default_ratings')->withPivot('rating');
    }
}
