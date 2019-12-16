<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PollResourceLite extends JsonResource
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
            'user_count' => DB::table('poll_ratings')->select(DB::raw('count(DISTINCT user_id) as count'))->where('poll_id', $this->id)->first()->count,
            'chosen_item_id' => $this->chosen_item_id,
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
