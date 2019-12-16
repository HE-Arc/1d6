<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'weight' => $this->whenPivotLoaded('poll_items', function() {
                return DB::select('select SUM(rating) as weight from poll_ratings where poll_id = ? AND item_id = ?',[$this->pivot->poll_id, $this->id])[0]->weight;
            }),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'polls' => ItemResource::collection($this->whenLoaded('polls')),
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
        ];
    }
}
