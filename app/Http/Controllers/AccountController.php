<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AccountController extends Controller
{

    public function index()
    {
        return view('pages.account.index',[
            'users' => User::where('type', 'user')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success','User account created!');
    }

    public function updateProfile(Request $request)
    {
        User::whereId($request->id)->update(['name'=>$request->name,'email'=>$request->email]);
        return back()->with('success','Profile successfully updated!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ]);
        if($request->new_password != $request->new_password_confirmation){
            return redirect()->route('account.profile')->with("error", "Confirmation Password doesn't match!");
        }
        User::whereId($request->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->back()->with("success", "Password changed successfully!");
    }

    public function destroy(Request $request)
    {
        User::whereId($request->id)->delete();
        return back()->with('success','User deleted!');
    }
}
