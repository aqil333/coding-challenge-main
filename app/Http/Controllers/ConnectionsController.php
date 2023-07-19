<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as ConnectionRequest;


class ConnectionsController extends Controller
{
    public function index()
    {
        $connections = auth()->user()->connections;

        return response()->json($connections);
    }
    public function destory($id)
    {
        $user = User::findOrFail($id);

        auth()->user()->connections()->detach($user->id);
        $user->connections()->detach(auth()->id());

        return response()->json(['message' => 'Connection removed.']);
    }
    public function store(Request $request, $id)
    {
        $receiver = User::findOrFail($id);
        ConnectionRequest::create([
            'user_id' => auth()->user()->id,
            'receiver_id' => $receiver->id,
            'request_type' => 'connect',
        ]);

        return response()->json(['message' => 'Connection request sent successfully']);
    }

}
