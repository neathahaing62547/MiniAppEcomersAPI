<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Models\auth_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthControlller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
     public function ShowUser(Request $request)
     {
          if ($request->user()->role == 'admin') {

               $data = auth_user::latest('id')->get();

               if ($data->isEmpty()) {
                    return response()->json([
                         'Message' => 'Dont Have Data User (Admin)',
                    ]);
               }
               return response()->json([
                    'Message' => 'Show All user (admin) ',
                    'Data' => $data,
               ]);
          }
          if ($request->user()->role == 'staff') {

               $data = auth_user::whereIn('role', ['staff', 'user'])
                    ->latest('id')
                    ->get();

               if ($data->isEmpty()) {
                    return response()->json([
                         'Message' => 'Dont Have Data User (staff)',
                    ]);
               }
               return response()->json([
                    'Message' => 'Show All user ',
                    'Data' => $data,
               ]);
          }
          return response()->json([
               'message' => 'Unauthorized role'
          ], 403);
     }
     public function DeleteUser(Request $request, $id)
     {

          if ((int)$request->user()->id == (int)$id) {
               return response()->json([
                    'Message' => 'You cannot delete Your selft'
               ], 400);
          }

          if ($request->user()->role !== 'user') {
               return response()->json([
                    'Message' => 'This action is blocked for Admin ',
               ]);
          } 
          try{
           $del = auth_user::find($id);
               $del->delete();
               return  response()->json([
                    'Message' => 'user delete is done ',
               ]);
          
           }catch(ModelNotFoundException $e){
                 return  response()->json([
                    'Message' => 'Data User You want to delete Not found ',
               ]);
           }
     }
     public function UpdateUser(Request $request, $id)
     {
         try {
              $user = auth_user::findOrFail($id);
       $validator = $request->validate([
               'name' =>  'required|min:5|max:50|string',
               'email' => 'required|email|unique:user',
               'role' => 'required|in:admin,staff,user',
          ]);

          $user->update($validator);

          return response()->json([
               'success' => true,
               'Message ' => 'Your Usr is update is Done',
               'Data' => $user
          ]);
         }catch(ModelNotFoundException $e) {
              return response()->json([
               'success' => false,
               'Message ' => 'Your User You want to update Not Found',
             ], 404);
         }
     }
     public function CreateStaff(Request $request)
     {
          if ($request->user()->role !== 'admin') {
               return response()->json([
                    'Message' => 'You Can not add user This action for admin only ',
               ]);
          } else {
               $validator = $request->validate([

                   'name' =>  'required|min:5|max:50',
                    'email' => 'required|email|unique:user',
                    'password' => 'required|min:6|max:12',
               ]);

               $newuser = auth_user::create([
                    'name' =>  $validator['name'],
                    'email' => $validator['email'],
                    'password' => Hash::make($validator['password']),
                    'role' => 'staff',
               ]);

               return response()->json([
                    'Message' => 'Staff creat Done !!!!',
                    'Data' => $newuser,
               ], 201);
          }
     }
     public function SearchUser(Request $request)
     {
          $search = $request->query('search');

          $request->validate([
               'search' => 'required',
          ]);

          $qury = \App\Models\auth_user::where('name', 'LIKE',  '%' . $search . '%')
               ->orWhere('name', 'LIKE', '%' . $search . '%')
               ->orWhere('email', 'LIKE', '%' . $search . '%')
               ->orWhere('role', 'LIKE', '%' . $search . '%')
               ->get();

          if ($qury->isEmpty()) {
               return response()->json([
                    'Message' => 'Data Not Found '
               ]);
          }
          return response()->json([
               'Secccess' => true,
               'message' => 'Search results retrieved successfully.',
               'Data' => $qury,
          ]);
     }
}
