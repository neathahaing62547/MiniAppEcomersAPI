<?php

namespace App\Http\Controllers;
use App\Models\order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
     public function show() {
        
         $order = order::with('payment')->get();

          if($order->isEmpty()){
               return response()->json([
                'Message' => 'all report is Empty'
               ]);   
          }
          return response()->json([
            'Message' => 'Show All report ',
            'Data' => $order
          ]);       
     }
     public function showreportstaff() {

          $starttoday = Carbon::today()->startOfDay();
             $endtoday = Carbon::today()->endOfDay();
           
          $order = order::whereBetween('created_at' , [$starttoday , $endtoday])       
                   ->with('payment')
                   ->get();

             if($order->isEmpty()){
                 return response()->json([
                    'Message' => 'Report  is empty'
                 ]);
             }
             return response()->json([
                    'Message' => 'Report for today',
                    'Data' => $order
                 ]);
     }
        public function   adminfillterreport(Request $request) {
             
        $start = $request->query('startdate');
        $end = $request->query('enddate');
           
             $fillter = order::whereBetween('created_at' , [$start , $end])
                         ->with('payment')
                         ->get();
            
            if($fillter->isEmpty()){
                 return response()->json([
                    'Message' => 'report fillter by date is not found '
                 ])  ;
            }
            return response()->json([
                'Message' => 'report fillter by date is found,',
                'Data' => $fillter
            ]);          
     }
}
