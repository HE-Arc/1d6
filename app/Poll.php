<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Group;

class Poll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'chosen_item_id'
    ];

    /**
     * The users participating in the poll
     */
    public function users() {
        return $this->belongsToMany('App\User', 'poll_users')->withPivot('admin');
    }

    /**
     * The items for which the poll provides choice
     */
    public function items() {
        return $this->belongsToMany('App\Item', 'poll_items');
    }

    /**
     * The items which have receiveed
     */
    public function itemsWithVotes($itemId) {
        return $this->belongsToMany('App\Item', 'poll_ratings')->wherePivot('item_id', $itemId)->withPivot('rating');
    }

    /**
     * Import users and items from the group
     */
    public function createPoll(Group $group)
    {
        // TODO
    }
}
