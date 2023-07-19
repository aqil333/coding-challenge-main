<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReceivedRequestsController extends Controller
{  
    public function index()
    {
        $receivedRequests = auth()->user()->receivedRequests()->where('request_type', 'connect')->with('sender')->get();

        return response()->json($receivedRequests);
    }

    public function store($id)
    {
        $user = User::findOrFail($id);

        auth()->user()->receivedRequests()
            ->where('user_id', $user->id)
            ->update(['request_type' => 'connected']);

        auth()->user()->connections()->attach($user->id);
        $user->connections()->attach(auth()->id());

        return response()->json(['message' =>  'Connection request accepted.']);
    }

}
