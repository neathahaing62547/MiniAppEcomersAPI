<?php

namespace App\Http\Controllers;

use App\Models\announcements;
use App\Models\auth_user;
use App\Models\NoftificationController;
use App\Notifications\InformationforUser;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoftificationControllerController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:200',
            'message' => 'required|min:10|max:350',
        ]);
        $notification = announcements::create([
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'draft',
        ]);
        return response()->json([
            'message' => 'Notification created',
            'data' => $notification
        ]);
    }
    public function sent($id) {

        $notification = announcements::find($id);

          if(!$notification){
             return response()->json([
                'Message' => 'Your Message you want to sent to user is not found'
             ]);
          }
        $user = auth_user::where('role' , 'user')
        ->all();
         
        foreach( $user as $user ){
           Notification::route('mail' , $user->email)->notify(
            new InformationforUser(
               $notification->title,
               $notification->message 
            )
           );
        }
           return response()->json([
            'Message' => 'Sent Successfully',
           ]);            
    }
    public function  delete($id) {
           $notification = announcements::find($id);

          if(!$notification){
             return response()->json([
                'Message' => 'Your Message you want to delete  is not found'
             ]);
          }
          $notification->delete();
          return response()->json([
            'Message' => 'Message Delete Successfully',
            'Data' => $notification
          ]);
    }
}
