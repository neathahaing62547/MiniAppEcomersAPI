<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rating;
use Illuminate\Support\Facades\Auth;

class ratingController extends Controller
{
    public function store(Request $request)
    {    
    $userID = Auth::id();
        
        $request->validate([
            'star' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $rating = rating::create([
            'user_id' => $userID,
            'star' => $request->star,
            'comment' => $request->comment,
        ]);
        return response()->json([
            'Message' => 'Your Rating was Sent ',
             'Data' => $rating
        ]);
    }
}
