<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Http\Request;

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
        return ItemResource::collection(Item::with('users', 'groups', 'polls')->paginate(25));
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

        attach($item->groups(), $request->groups);
        attach($item->users(), $request->users, "rating");
        attach($item->polls(), $request->polls);

        return new ItemResource(Item::with('users', 'groups', 'polls')->find($item->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $item)
    {
        return new ItemResource(Item::with('users', 'groups', 'polls')->find($item));
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
        $item->update($request->only(['name', 'description', 'url', 'image_url']));

        update($item->users(), $request->usersToAdd, false, "rating");
        update($item->polls(), $request->pollsToAdd);
        update($item->groups(), $request->groupsToAdd);

        update($item->users(), $request->usersToRemove, true);
        update($item->polls(), $request->pollsToRemove, true);
        update($item->groups(), $request->groupsToRemove, true);

        return new ItemResource(Item::with('users', 'groups', 'polls')->find($item->id));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
