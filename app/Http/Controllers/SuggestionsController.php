<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as ConnectionRequest;
use Illuminate\Support\Facades\Auth;
class SuggestionsController extends Controller
{
    public function index()
    {
        $users = User::whereNotIn('id', [auth()->user()->id])
            ->whereDoesntHave('connections', function ($query) {
            $query->where('connection_id', auth()->user()->id);
        })
            ->whereDoesntHave('sentRequests', function ($query) {
            $query->where('receiver_id', auth()->user()->id)
                ->where('request_type', 'connect');
        })
            ->whereDoesntHave('receivedRequests', function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->where('request_type', 'connect');
        })->paginate(10);

        return response()->json($users);
    }
}
