<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    public function SearchProduct(Request $request)
    {
        $query = Product::query();

        $query->where('status', 'active');

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '<=', $request->min_price);
        }
        if ($request->filled('price')) {
            $query->where('price',  $request->price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '>=', $request->max_price);
        }
        $products = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'Message' => 'Data product From earch',
            'Data' => $products
        ]);
    }
    public function filterproductbycategory($id)
    {
        $category = category::with(['product' => function ($query) {
            $query->where('status', 'active')
                ->orderBY('id', 'DESC')
                ->paginate(10);
        }])->find($id);

        if(!$category ) {
             return response()->json([
                 'Message' => 'Product you filter is not found'
             ]);
        }
        return response()->json([
            'Message' => 'Fillter by category',
            'Data' => $category->product
        ]);
    }
}
