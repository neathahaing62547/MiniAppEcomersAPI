<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Message;

class ratingController extends Controller
{
    public function index()
    {
        $rating = rating::with('user')->latest('id')->get();

        if ($rating->isEmpty()) {
            return response()->json([
                'Message' => 'rating is Empty'
            ]);
        }
        return response()->json([
            'Message' => 'Show All Rating',
            'Data' => $rating
        ]);
    }
    public function topRatings()
    {
        $ratings  =  rating::with('user')
            ->whereIn('star', [4, 5])
            ->whereHas('user', function ($q) {
                $q->where('role', 'user');
            })
            ->latest()
            ->take(5)
            ->get();
        return response()->json([
            'data' => $ratings
        ]);
    }
    public function store(Request $request)
    {
        try {
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
            DB::commit();
            return response()->json([
                'Message' => 'Your Rating was Sent ',
                'Data' => $rating
            ]);
        } catch (\Exception $e) {
            return response()->json([
                DB::rollBack(),
                'Message' => 'Eror'  . $e->getMessage()
            ]);
        }
    }
    public function delete($id)
    {
        try {
            $rating = rating::find($id);

            if (!$rating) {
                return response()->json([
                    'Message' => 'Rating you want to delete is Not Found ',
                    'data' => $id
                ]);
            } else {
                $rating->delete();
                return response()->json([
                    'Message' => 'rating delete Successfully ',
                    'Data' => $rating
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'Message' => 'eror' . $e->getMessage()
            ]);
        }
    }
    public function deleteAll()
    {
        rating::query()->delete();

        return response()->json([
            'success' => true,
            'message' => 'All Rating deleted successfully.'
        ]);
    }
}
