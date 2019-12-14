<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PollResourceCollection extends JsonResource
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
            'total_user_count' => count($this->users),
            'user_count' => count(DB::select('select user_id from poll_ratings where poll_id = ? GROUP BY user_id',[$this->id])),
            'chosen_item_id' => $this->chosen_item_id,
        ];
    }
}
