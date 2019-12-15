<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    // TODO : Check authorisations

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([], 404);
        //return ItemResource::collection(Item::with('users', 'groups', 'polls')->paginate(25));
    }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $item)
    {
        return response()->json([], 404);
        //return new ItemResource(Item::with('users', 'groups', 'polls')->find($item));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if ($request->rating != null) {
            $item->users->find(Auth::id())->pivot->rating = $request->rating;
            return response()->json();
        } else {
            return response()->json([], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //$item->delete();

        return response()->json([], 404);
    }
}
