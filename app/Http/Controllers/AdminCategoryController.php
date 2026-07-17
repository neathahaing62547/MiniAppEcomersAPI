<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\category;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
  public function  index()
  {
    $category = category::with('product')->get();

    if ($category->isEmpty()) {
      return response()->json([
        'Message'  => 'Category Not Found '
      ]);
    }
    return response()->json([
      'Message' =>  'Show all Categoey',
      'Data' => $category,
    ]);
  }
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|min:5|max:30',
      'description' => 'required|string|min:10|max:100',
      'status' => 'required|in:active,draft'
    ]);

    $category = category::create($request->all());

    return response()->json([
      'Message' => 'Category Create susscessfully',
      'Data' => $category,
    ]);
  }
  public function update(Request $request, $id)
  {
    $category = category::find($id);

    if (!$category) {
      return response()->json([
        'Message' => 'Category You wannt to Update is Not Found '
      ]);
    }
    $request->validate([
      'name' => 'required|string|min:5|max:30',
      'description' => 'required|string|min:10|max:100',
      'status' => 'required|in:active,draft'
    ]);

    $category->update($request->all());

    return response()->json([
      'Message' => 'Category Update susscessfully',
      'Data' => $category
    ]);
  }
  public function delete($id)
  {
    $category  = category::find($id);

    if (!$category) {
      return response()->json([
        'Message' => 'Category You wannt to Delete is Not Found '
      ]);
    }
    $category->product()->delete();
    $category->delete();

    return response()->json([
      'Message' => 'Category Delete susscessfully',
      'Data' => $category,
    ]);
  }
}
