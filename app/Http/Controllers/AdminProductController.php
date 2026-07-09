<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $product = product::with('category')->get();
          
        if ($product->isEmpty()) {
            return response()->json([
                'Message' => 'Products Not Found ',
                'Data' => $product
            ]);
        }
        return response()->json([
            'Message' => 'Show All PRoducts',
            'Data' => $product
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'name'        => 'required|string|max:255',
            'description' => 'required|string|min:20|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'      => 'required|in:active,draft',
        ]);
        $productData = $request->all();
        try {
            $productData = $request->except('image');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/products', $filename, 'public');
                $productData['image'] = 'storage/uploads/products/' . $filename;
            }

            $product = product::create($productData);

            return response()->json([
                'Message' => 'Product Creat succcessfully',
                'Data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'succcess' => false,
                'Message' => $e->getMessage(),
            ]);
        }
    }
    public function update(Request $request, $id)
    {
     $request->validate([
                'category_id' => 'required|integer',
                'name'        => 'required|string|max:255',
                'description' => 'required|string|min:20|max:255',
                'price'       => 'required|numeric',
                'stock'       => 'required|integer',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'status'      => 'required|in:active,draft',
            ]);
        try {
            $product = product::findOrFail($id);

            $productData = $request->all();
            if (!$product) {
                return response()->json([
                    'Message' => 'Product You want to update is Not Found ',
                ]);
            }
            if ($request->hasFile('image')) {
                if ($product->image) {

                    $oldImagePath = str_replace('storage/', '', $product->image);
                    Storage::disk('public')->delete($oldImagePath);
                }
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/products', $filename, 'public');

                $productData['image'] = 'storage/uploads/products/' . $filename;
            }

            $product->update($productData);

            return response()->json([
                'Messag' => 'Product Update succcessfully ',
                'data' =>  $product
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'Message' => $e->getMessage()
            ]);
        }
    }
    public function delete($id){

       $product = product::find($id);

    if ($product->image) {
            $imagePath = str_replace('storage/', '', $product->image);
            
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        $product->delete();
        return response()->json([
            'Message' => 'Product Delete Successfully',
            'Data' => $product,
        ]);
    }
}
