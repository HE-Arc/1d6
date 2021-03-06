<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $itemRating = Auth::user()->items()->find($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->image_url,
            // weight is the total sum of ratings the item in this poll has received. it is only loaded when by a poll
            'weight' => $this->whenPivotLoaded('poll_items', function() {
                return intval(DB::select('select SUM(rating) as weight from poll_ratings where poll_id = ? AND item_id = ?',[$this->pivot->poll_id, $this->id])[0]->weight);
            }),
            'default_rating' => $itemRating !== null ? $itemRating->pivot->rating : 1,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'polls' => ItemResource::collection($this->whenLoaded('polls')),
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
        ];
    }
}
