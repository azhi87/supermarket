<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Hash;
class UserController extends Controller
{
    public function edit($id){

        $user=\App\User::find($id);
	    return view('auth.updateUser',compact('user'));
    }

    public function showUsers(){

        $users=\App\User::all();
	    return view('auth.showUsers',compact('users'));
    }

    public function toggleUser($id){
        $user=\App\User::find($id);
	    $user->toggleStatus();
	    return redirect('/users');
    }
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
