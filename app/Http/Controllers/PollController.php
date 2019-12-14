<?php

namespace App\Http\Controllers;

use App\Http\Resources\PollResourceLite;
use App\Http\Resources\PollResource;
use App\Http\Resources\PollCollection;
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
        // TODO : Check authorisations

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PollCollection(Poll::with('items')->paginate(25));
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
        attach($poll->users(), $request->users, "admin");
        attach($poll->items(), $request->items);

        return response()->json();
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
        foreach(json_decode($request->ratings, true) as $rating)
        {
            DB::insert('insert into poll_ratings (poll_id, user_id, item_id, rating) values (?, ?, ?, ?)', [$pollId, Auth::id(), $rating['id'], $rating['rating']]);
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
        return new PollResource(Poll::with('items')->find($poll));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $poll
     * @return \Illuminate\Http\Response
     */
    public function showLite($poll)
    {
        return new PollResourceLite(Poll::with('items')->find($poll));
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
        $is_admin = $poll->users->find(Auth::id())->pivot->admin == 1;
        $ratings = DB::select('select * from poll_ratings where poll_id = ? AND user_id = ?',[$poll->id, Auth::id()]);
        $is_not_empty = count($ratings) > 0;
        error_log("admin : " . $poll->users->find(Auth::id())->pivot->admin);
        if($is_admin && $is_not_empty)
        {
            $poll->update(['chosen_item_id' => 1]);
        }
        else
        {
            return response()->json([
                'code'      => 401,
                'message'   => $is_admin ? "There isn't any ratings for this poll" : "You are not admin of this poll",
            ], 401);
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
