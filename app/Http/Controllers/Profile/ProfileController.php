<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $title = 'Profile';

        return view('home.profile.index', compact('title'));
    }

    public function changePassword()
    {
        $title = 'Change Password';

        return view('home.profile.change-password', compact('title'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);

        if ($currentPasswordStatus) {
            if ($request->password == $request->confirm_password) {
                $user = auth()->user();
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                return redirect()->back()->with('error', 'Password and Confirm Password is not match');
            }
        } else {
            return redirect()->back()->with('error', 'Current Password Is Wrong');
        }
    }
}
