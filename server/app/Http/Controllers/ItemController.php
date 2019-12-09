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
        error_log($request);
        error_log(implode(',', $request->all()));
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image_url' => $request->image_url,
        ]);
        foreach (json_decode($request->users) as $user) {
            $item->users()->attach($user->{'id'}, ["rating" => $user->{'rating'}]);
        }
        foreach (json_decode($request->groups) as $group) {
            $item->groups()->attach($group->{'id'});
        }
        foreach (json_decode($request->polls) as $poll) {
            $item->polls()->attach($poll->{'id'});
        }


        return new ItemResource(Item::with('users', 'groups', 'polls')->find($item));
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
        function update($target, $data, $delete=false, $pivots = "")
        {
            if ($data != null) 
            {
                var_dump(json_decode($data,true));
                var_dump("LELELEL");
                foreach (json_decode($data,true) as $d) 
                {
                    if (!$delete)  {
                        var_dump($pivots);
                        if ($pivots == "")
                        {
                            $target->sync($d['id'], false);
                        }
                        else
                        {
                            $target->sync([$d['id'], [$pivots => $d[$pivots]]], false);
                        }
                    }
                    else
                    {
                        $target->detach($d['id']);
                    }
                }
            }
        }
        //error_log($request->pollsToAdd);

        $item->update($request->only(['name', 'description', 'url', 'image_url']));

        update($item->users(), $request->usersToAdd, false, "");
        update($item->polls(), $request->pollsToAdd);
        update($item->groups(), $request->groupsToAdd);

        update($item->users(), $request->usersToRemove, true);
        update($item->polls(), $request->pollsToRemove, true);
        update($item->groups(), $request->groupsToRemove, true);

        
        // if ($request->pollsToRemove != null) {
        //     foreach (json_decode($request->pollsToRemove) as $poll) {
        //         $item->polls()->detach($poll->{'id'});
        //     }
        // }
        // foreach (json_decode($request->groupsToRemove) as $group) {
        //     $item->groups()->detach($group->{'id'});
        // }
        // foreach (json_decode($request->usersToRemove) as $user) {
        //     $item->users()->detach($user->{'id'});
        // }

        return new ItemResource($item);
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
