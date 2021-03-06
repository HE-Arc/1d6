<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\ItemResource;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    // TODO : Check authorisations

    /**
     * Display a listing of the authentified user's groups
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
     * Store a newly created group with users and items. Returns the newly created group id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = Group::create([
            'name' => $request->name,
        ]);

        $items = $request->items;

        $users = addLoggedUserToData($request->users, "id", Auth::id(), function (&$arr, $index) {
            // Make sure owner is admin
            $arr[$index]["admin"] = true;
        }, function (&$arr) {
            // Dirty trick to create an object as "object" is reserved by laravel (wtf?)
            $arr[] = ["id" => Auth::id(), "admin" => true];
        });

        // TODO: Check if it is not possible to do only one query
        foreach ($users as $key => $user) {
            $group->users()->sync([$user["id"] => ['admin' => $user["admin"]]], false);
        }

        $itemsToInsert = [];
        foreach ($items as $key => $item) {
            $itemsToInsert[] = [
                "name" => $item["name"],
                "description" => $item["description"] ?? "",
                "url" => $item["url"] ?? "",
                "image_url" => $item["image_url"] ?? "",
            ];
        }

        $group->items()->createMany($itemsToInsert);

        return json_encode(["data" => ["id" => $group->id]]);
    }

    /**
     * Display the specified group if the authenticated user is in it.
     *
     * @param  int  $group
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        return new GroupResource(Group::with('users', 'items')->find($group));
    }

    /**
     * Update the specified group name, users and items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if ($group->users()->find(Auth::id())->pivot->admin === 1) {
            $group->update($request->only(['name']));

            // TODO: Using json_decode seems fishy, there must be a nicer way to do that
            $usersToAdd = $request->users_to_add;
            $usersToRemove = $request->users_to_remove;
            $itemsToAdd = $request->items_to_add;
            $itemsToRemove = $request->items_to_remove;

            // We should not be able to find the connected user in any array, if we do it means something is wrong
            foreach ($usersToAdd as $key => $value) {
                if (intval($usersToAdd[$key]["id"]) === Auth::id()) {
                    return response()->json(["errors" => ["Cannot update self user."]], 401);
                }
            }
            foreach ($usersToRemove as $key => $value) {
                if (intval($usersToRemove[$key]["id"]) === Auth::id()) {
                    return response()->json(["errors" => ["Cannot remove self user."]], 401);
                }
            }

            // TODO: Check if it is not possible to do only one query
            foreach ($usersToAdd as $key => $user) {
                $group->users()->sync([$user["id"] => ['admin' => $user["admin"]]], false);
            }

            $itemsToInsert = [];
            foreach ($itemsToAdd as $key => $item) {
                $itemsToInsert[] = [
                    "name" => $item["name"],
                    "description" => $item["description"],
                    "url" => $item["url"],
                    "image_url" => $item["image_url"],
                ];
            }

            $group->items()->createMany($itemsToInsert);

            foreach ($usersToRemove as $key => $user) {
                $group->users()->detach($user["id"]);
            }
            foreach ($itemsToRemove as $key => $item) {
                $group->items()->detach($item["id"]);
            }

            return null;
        } else {
            return response()->json(null, 401);
        }
    }

    /**
     * Remove the specified group from storage.
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
