<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Hash;
class UserController extends Controller
{
   public function updateUser(Request $request,$id)
    {
         $this->validate($request,[
            
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile'=>'required',
            'type'=>'required'
        ]);
        $user = \App\User::find($id);
        $password = $request['password'];
        $password_confirmation = $request['password_confirmation'];
        if($request->has('password') && $request->has('password_confirmation'))
        {
            if($password!=$password_confirmation)
            {
                return back()->withErrors(["password"=>"password do not match"]);
            }
            $user->password=Hash::make($password);
        }

            $email=$request['email'];
            $type=$request['type'];
            $user->mobile=$request['mobile'];
            $user->email=$email;
            $user->type=$type;
            $user->name=$request['name'];
            $user->save();

            return redirect('/users');
    }
}
