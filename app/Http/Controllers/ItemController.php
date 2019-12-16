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
     * Store a newly created resource in storage.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRatings(Request $request)
    {
        $items = jsonDecodeToArray($request->ratings, true);
        $validator = Validator::make($items, ['*.rating' => 'integer|required|max:10|min:0']);

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
