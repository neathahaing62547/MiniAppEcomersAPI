<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {

        $search = $request->query('search');
        $query = category::with('product');

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('description', 'LIKE', '%' . $search . '%')
                ->orwhere('status', 'LIKE', '%' . $search . '%')
                ->orderBY('id',  'DESC')
                ->paginate(10);
        }
        $category = $query->get();
        if ($category->isEmpty()) {

            return response()->json([
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'message' => 'data category from search',
            'Data' => $category
        ]);
    }
}
