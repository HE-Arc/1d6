<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Item;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Store a newly created item in storage and return it's id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image_url' => $request->image_url,
        ]);

        return response()->json(["id" => $item->id]);
    }

    /**
     * Update the specified items default ratings in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRatings(Request $request)
    {
        $items = $request->ratings;
        
        $validator = Validator::make($items, ['*.rating' => 'integer|required|max:10|min:1']);

        if ($validator->passes()) {
            // TODO: Check how to do only 1 request
            foreach ($items as $key => $item) {
                Item::find($item["id"])->users()->sync([Auth::id() => ['rating' => $item["rating"]]], false);
            }
            return null;
        } else {
            return response()->json(["errors" => ["Invalid rating range."]], 401);
        }
    }
}
