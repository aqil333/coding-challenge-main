<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SentRequestsController extends Controller
{
    public function index()
    {
        $sentRequests = auth()->user()->sentRequests()->with('receiver')->get();

        return response()->json($sentRequests);
    }
    public function destory(Request $request,$id)
    {
        $user = User::findOrFail($id);

        auth()->user()->sentRequests()->where('receiver_id', $user->id)->delete();

        return response()->json(['message' => 'Connection request withdrawn.']);
    }

}
