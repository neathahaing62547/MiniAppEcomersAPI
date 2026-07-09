<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Models\product;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
     public function index()
     {

          $product = product::where('status', 'active')
               ->with('category')
               ->orderBy('id', 'DESC')
               ->paginate(10);

          if ($product->isEmpty()) {
               return response()->json([
                    'Message' => 'Data NOT Found '
               ]);
          }
          return response()->json([
               'Message' => 'Show product fronted ',
               'Data' => $product
          ]);
     }
     public function productdetail($id)
     {
          $product = product::with('category')->find($id);
         
          if (!$product) {
               return response()->json([
                    'Message' => 'Detail product Not Found',
               ]);
          }
          $product->first();

          return response()->json([
               'Message' => 'Product Detail Found',
               'Data' => $product
          ]);
     }
   
}
