<?php

namespace App\Http\Resources;

use App\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            // 'defaultRatings' => $this->temporaryRatings(),
            'polls' => PollResource::collection($this->whenLoaded('polls')),
            'admin' => $this->whenPivotLoaded('group_users', function () {
                return $this->pivot->admin;}), 
        ];
    }
}
