<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\User;
use App\Models\cartitems;
use App\Models\auth_user;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   public function AddToCart(Request $request)
   {
      $request->validate([
         'product_id' => 'required|exists:products,id',
         'quantity' => 'required|integer|min:1'
      ]);

         $userID = Auth::id();

        $cart =  cart::firstOrCreate([
            'user_id' => $userID
          ]);

         $cartitem = cartitems::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->first();

                if ($cartitem) {
                      $cartitem->quantity +=  $request->quantity;
                      $cartitem->save();
         
               return response()->json([
               'Message' => 'Your product Already in carts just quanitity  Update Quantity in cart',
               'Data' => $cartitem
         ]);

             } else {  
         $add = cartitems::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            ]);
          }
            return response()->json([
             'Message' => 'Product Add to cart successfully',
             'Data' => $add
          ]);
   }
   public function getcart_item(){
       
    $userID = Auth::id();
         
         $cart = cart::where('user_id', $userID)
                ->with('cart_items.product')
                ->first();
                
         if(!$cart  || $cart->cart_items->isEmpty() ) {
              return response()->json([
               'Message' => 'Product in carts is empty',
               'Data' => []
              ]) ;
              }
              else{
                  return response()->json([
                    'Message' => 'All Product in cart ',
                    'Data' => $cart,
                  ]);
              }
   }
   public function removefromcart($id) {
       
        $cartitem = cartitems::find($id);              
            if(!$cartitem ){
                return response()->json([
                  'Message' => 'product You want to delete is not Found',
                ]);     
            }
         $cartitem->delete();

           return response()->json([
            'Message' => 'Product Delete Seccsessfully',
            'Data' => $cartitem
           ]);        
   }
       
}
