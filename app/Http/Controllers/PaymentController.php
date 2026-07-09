<?php

namespace App\Http\Controllers;

use App\Models\auth_user;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\order;
use App\Models\cart;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $order = order::with('payment')->get();

            if(!$order){
                 return response()->json([
                    'Message' => 'user Dont hav e Order '
                 ]);
            }
        return response()->json([
            'payment' => true ,
            'Message' => 'Payment Successfully',
            'data' => $order
        ]);
    }
    public function delete($id) {
         $payment = payment::findOrFail($id);

              if(!$payment) {
                 return response()->json([
                    'Messaage' => 'payment you to delete is not found '
                 ]);
              }
            $payment->delete();

            return response()->json([
                'Message' => 'deleet Payment Successfully',
                'Data' => $payment
            ]);
    }
    public function getdetailpayment(Request $request) {
            
      $UserID = $request->user()->id;

                $payment = \App\Models\auth_user::with('order.payment')->find($UserID);
              
                 if(!$payment){
                     return response()->json([
                        'Message' => 'you dony have order'
                     ]);
                 }
            return response()->json([
                'Message' => 'Payment successfully',
                'Data' => $payment
            ]);
    }
}
