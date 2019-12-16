<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_admin' => $this->users->find(Auth::id())->pivot->admin,
            'total_user_count' => $this->users->count(),
            // Count the amount of distinct users who have voted on the poll
            'user_count' => DB::table('poll_ratings')->select(DB::raw('count(DISTINCT user_id) as count'))->where('poll_id', $this->id)->first()->count,
            'chosen_item_id' => $this->chosen_item_id,
            // Check if the authenticated user has voted on at least 1 item
            'has_voted' => DB::table('poll_ratings')->select(DB::raw('count(DISTINCT user_id) as count'))->where([['poll_id', $this->id], ['user_id', Auth::id()]])->first()->count > 0,
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
