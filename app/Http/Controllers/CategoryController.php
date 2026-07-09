<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
      public function  index()
  {
    $category = category::where('status' , 'active')
               ->with('product')
               ->orderBY('id' , 'DESC')
               ->paginate(10);
               
    if ($category->isEmpty()) {
      return response()->json([
        'Message'  => 'Category Not Found '
      ]);
    }
    return response()->json([
      'Message' =>  'Show all category in fronted',
      'Data' => $category,
    ]);
  }
}
