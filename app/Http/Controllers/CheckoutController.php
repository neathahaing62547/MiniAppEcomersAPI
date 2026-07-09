<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\order;
use App\Models\Payment;
use App\Models\orderitem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function  checkout(Request $request)
    {
        try {
            $request->validate([
                'payment_method' => 'required|string',
            ]);

            $UserID = $request->user()->id;

            $cart = cart::where('user_id', $UserID)
                ->with('cart_items.product')
                ->first();

            if (!$cart || $cart->cart_items->isEmpty()) {
                return response()->json([
                    'message' => 'Cart is empty.'
                ]);
            }
            $order = order::create([
                'user_id' => $UserID,
                'order_no' => 'XYID' . time() . '0YED',
                'total_price' => 0,
                'payment_method' => $request->payment_method,
                'status' => 'Pending',

            ]);
            $payment = Payment::create([
                'order_id'       => $order->id,
                'amount'         => 0,
                'payment_method' => $order->payment_method,
                'status'         => 'completed'
                ]);
                
                $total = 0;

            foreach ($cart->cart_items as $item) {

                $subtotal = $item->quantity * $item->product->price;

                orderitem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $order->update([
                'total_price' =>  $total,
            ]);
            $payment->update([
                'amount' => $total,
            ]);

            $cart->cart_items()->delete();

            return response()->json([
                'message' => 'Order created successfully.',
                  'Data' => [
                    'order' => $order , 
                    'Payment' => $payment
                  ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'Message' =>  'Error ' . $e->getMessage()
            ]);
        }
    }
}
