<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    /**
     * The groups the user is in
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_users');
    }

    /**
     * The items for which the user has given a default rating
     * Access it via :
     *  user->items()[i]->pivot->rating
     */
    public function items()
    {
        return $this->belongsToMany('App\Item', 'item_default_ratings')->withPivot('rating');
    }

    /**
     * The items and associated ratings given by the user in the given poll
     * Access the rating via:
     *  user->temporaryRatings(i)[j]->pivot->rating
     */
    public function temporaryRatings($pollId)
    {
        return $this->belongsToMany('App\Item', 'poll_ratings')->wherePivot('poll_id', $pollId)->withPivot("rating");
    }

    /**
     * Polls in which the user participates
     * Access whether the user is admin via:
     *  user->polls()[i]->pivot->admin
     */
    public function polls()
    {
        return $this->belongsToMany('App\Poll', 'poll_users')->withPivot('admin');
    }
}
