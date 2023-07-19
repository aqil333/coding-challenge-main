<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Connection;

class CommonConnectionsController extends Controller
{
    public function index($id)
    {

        $connectionIds = auth()->user()->connections->pluck('id')->toArray();

        $commonConnections = User::whereHas('connections', function ($query) use ($connectionIds) {
            $query->whereIn('connection_id', $connectionIds);
        })
            ->where('id', '<>', auth()->user()->id) //
            ->get();

        return response()->json($commonConnections);
    }

}
