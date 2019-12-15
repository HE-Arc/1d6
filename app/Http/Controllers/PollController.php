<?php

namespace App\Http\Controllers;

use App\Http\Resources\PollResourceLite;
use App\Http\Resources\PollResource;
use App\Http\Resources\PollCollection;
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Validator;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PollResource::collection(Poll::whereHas('users', function ($query) {
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
        $poll = Poll::create([
            'name' => $request->name,
            'url' => ""
        ]);

        $items = jsonDecodeToArray($request->items);

        if (count($items) > 0) {
            try {
                $users = addLoggedUserToData(jsonDecodeToArray($request->users, true), "id", Auth::id(), function (&$arr, $index) {
                    // Make sure owner is admin
                    $arr[$index]["admin"] = true;
                }, function (&$arr) {
                    $arr[] = ["id" => Auth::id(), "admin" => true];
                });

                // TODO: Check if it is not possible to do only one query
                foreach ($users as $key => $user) {
                    $poll->users()->sync([$user["id"] => ['admin' => $user["admin"]]], false);
                }

                foreach ($items as $key => $item) {
                    // TODO: Security issue here, see #113
                    $poll->items()->attach($item->id);
                }
            } catch (\Throwable $th) {
                // If anything fails, delete the poll
                $poll->delete();
            }
        } else {
            $poll->delete();
            return response()->json(["errors" => ["Cannot create poll without items."]], 401);
        }

        return response()->json(json_encode(["id" => $poll->id]));
    }

    /**
     * Store a newly created rating in storage in the poll_ratings table.
     *
     * @param  \Illuminate\Http\Request  $request$
     * @param  int  $pollId
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, int $pollId)
    {
        $ratings = jsonDecodeToArray($request->ratings, true);
        $validator = Validator::make($ratings, ['*.rating' => 'integer|required|max:10|min:0']);

        if ($validator->passes()) {
            // Can only vote if we are in the poll
            $poll = Poll::find($pollId);

            if ($poll->users()->find(Auth::id())->exists()) {
                // TODO: Check how to do only 1 request
                foreach ($ratings as $rating) {
                    // Can only vote on a rating if it's in a poll
                    if ($poll->items()->find($rating['id']) !== null) {
                        // TODO: Fix doing so many queries here
                        // TODO: Allow user to update their vote
                        // TODO: Do not use insert directly, find a way to make *many to many to many* properly or at least make this query nicer
                        DB::insert('insert into poll_ratings (poll_id, user_id, item_id, rating) values (?, ?, ?, ?)', [$pollId, Auth::id(), $rating['id'], $rating['rating']]);
                    } else {
                        return response()->json(["errors" => ["Item does not exists in poll."]], 401);
                    }
                }
            } else {
                return response()->json(["errors" => ["Cannot vote in this poll."]], 401);
            }
            return null;
        } else {
            return response()->json(["errors" => ["Invalid rating range."]], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($poll)
    {
        $poll = Poll::with('items')->find($poll);
        if ($poll->users()->find(Auth::id()) !== null) {
            return new PollResource($poll);
        } else {
            return response()->json(["errors" => ["No access to this poll."]], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $poll
     * @return \Illuminate\Http\Response
     */
    public function showLite($poll)
    {
        $poll = Poll::with('items')->find($poll);
        if ($poll->users()->find(Auth::id()) !== null) {
            return new PollResourceLite($poll);
        } else {
            return response()->json(["errors" => ["No access to this poll."]], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        $isPollAdmin = $poll->users->find(Auth::id())->pivot->admin === 1;
        $ratings = DB::select('select * from poll_ratings where poll_id = ? AND user_id = ?', [$poll->id, Auth::id()]);
        $hasRatings = count($ratings) > 0;
        error_log("admin : " . $poll->users->find(Auth::id())->pivot->admin);
        if ($isPollAdmin && $hasRatings) {
            $poll->update(['chosen_item_id' => 1]);
        } else {
            return response()->json(["errors" => ["Cannot update this poll."]], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();

        return response()->json(null, 204);
    }
}
