<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The users of this group
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'group_users')->withPivot('admin');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'group_items');
    }
}
