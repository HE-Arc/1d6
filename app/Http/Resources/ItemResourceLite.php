<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ItemResourceLite extends JsonResource
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
            'weight' => $this->whenPivotLoaded('poll_items', function() {
                return intval(DB::select('select SUM(rating) as weight from poll_ratings where poll_id = ? AND item_id = ?',[$this->pivot->poll_id, $this->id])[0]->weight);
            }),
        ];
    }
}
