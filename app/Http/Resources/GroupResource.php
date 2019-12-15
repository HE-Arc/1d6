<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class GroupResource extends JsonResource
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
            'user_count' => $this->users()->count(),
            'is_admin' =>  $this->users()->find(Auth::id())->pivot->admin,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
