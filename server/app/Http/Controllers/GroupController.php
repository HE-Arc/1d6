<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
        // TODO : Check authorisations

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupResource::collection(Group::with('users', 'items')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $group = Group::create([
            'name' => $request->name, 
          ]);
        foreach (explode(',',$request->users) as $user)
        {
            $group->users()->attach($user, ["admin" => false]); // TODO : deal with admin rights
        }
        foreach (explode(',',$request->items) as $item)
        {
            $group->items()->attach($item);
        }
    
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        return new GroupResource(Group::with('users', 'items')->find($group));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->only(['name']));

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json(null, 204);
    }
}
