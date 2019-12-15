<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Group;
use App\User;
use App\Http\Resources\GroupsCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return GroupResource::collection(Group::whereHas('users', function ($query) {
            $query->whereIn('user_id', [Auth::id()]);
        })->paginate(25));
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

        $users = addLoggedUserToData($request->users, "id", Auth::id(), function (&$arr, $index) {
            // Make sure owner is admin
            $arr[$index]->admin = true;
        }, function (&$arr) {
            $arr[] = ["id" => Auth::id(), "admin" => true];
        });

        attach($group->users(), $users, "admin");
        attach($group->items(), $request->items);

        return json_encode(["data" => ["id" => $group->id]]);
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
        if ($group->users()->find(Auth::id())->pivot->admin === 1) {
            $group->update($request->only(['name']));

            update($group->users(), $request->users_to_add, false, "admin");
            update($group->items(), $request->items_to_add);

            update($group->users(), $request->users_to_remove, true);
            update($group->items(), $request->items_to_remove, true);

            return null;
        } else {
            return response()->json(null, 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->users()->find(Auth::id())->pivot->admin === 1) {
            $group->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(null, 401);
        }
    }
}
