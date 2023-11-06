<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.profile.index');
    }

    public function updateProfile(Request $request)
    {
        User::whereId(auth()->user()->id)->update(['name'=>$request->name,'email'=>$request->email]);
        return back()->with('success','Profile successfully updated!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ]);
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return redirect()->route('account.profile')->with("error", "Old Password doesn't match!");
        }
        if($request->new_password != $request->new_password_confirmation){
            return redirect()->route('account.profile')->with("error", "Confirmation Password doesn't match!");
        }
        User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('account.profile')->with("success", "Password changed successfully!");
    }
}
