<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Log\LogServiceProvider;

class wishlistsController extends Controller
{
    public function store($id)
    {
        $product_id = product::find($id);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->exists();
        if ($exists) {
            return response()->json([
                'message' => 'Product is already in your wishlist.'
            ]);
        }
        if ($product_id) {
            $wishlist =  Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
            ]);
        } else {
            return response()->json([
                'Message' => 'product Dont have in list '
            ]);
        }
        return response()->json([
            'Message' => 'Product Add To Favorith Successfully',
            'Data' => $wishlist
        ]);
    }
    public function index()
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id',  Auth::id())
            ->latest()
            ->get();

        if ($wishlist->isEmpty()) {
            return response()->json([
                'Message' => 'Your Favorith Product IS Empty'
            ]);
        }
        return response()->json([
            'Message' => 'Your Favorith Product',
            'Data' => $wishlist
        ]);
    }
    public function removefromfavorith($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return response()->json([
                'Message' => 'Favorith Product You want to Delete is Not Found'
            ]);
        }
        $wishlist->delete();
        return response()->json([
            'Message' => 'Favorith Product Delete Successfully',
            'Data'  => $wishlist
        ]);
    }
}
