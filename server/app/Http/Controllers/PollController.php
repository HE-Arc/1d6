<?php

namespace App\Http\Controllers;

use App\Http\Resources\PollResource;
use App\Poll;
use Illuminate\Http\Request;

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
        return PollResource::collection(Poll::all());
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
            'url' => $request->url,
          ]);
    
        return new PollResource($poll);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        return new PollResource($poll);
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
        $poll->update($request->only(['name','url']));

        return new PollResource($poll);
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
