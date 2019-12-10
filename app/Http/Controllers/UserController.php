<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // TODO : Check authorisations

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::with('groups', 'items', 'polls')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        attach($user->groups(), $request->groups);
        attach($user->items(), $request->items, "rating");
        attach($user->polls(), $request->polls);

        return new UserResource(User::with('groups', 'items', 'polls')->find($user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return new UserResource(User::with('groups', 'items', 'polls')->find($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email']));

        update($user->items(), $request->usersToAdd, false, "rating");
        update($user->polls(), $request->pollsToAdd);
        update($user->groups(), $request->groupsToAdd);

        update($user->items(), $request->usersToRemove, true);
        update($user->polls(), $request->pollsToRemove, true);
        update($user->groups(), $request->groupsToRemove, true);

        return new UserResource(User::with('groups', 'items', 'polls')->find($user->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
