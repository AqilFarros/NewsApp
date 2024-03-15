<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

                return redirect()->route('profile.index')->with('success', 'Your Password Successfully Changed');
            } else {
                return redirect()->back()->with('error', 'Password and Confirm Password is not match');
            }
        } else {
            return redirect()->back()->with('error', 'Current Password Is Wrong');
        }
    }

    public function allUser()
    {
        $title = 'All User';

        $user = User::where('role', 'user')->get();

        return view('home.user.index', compact('title', 'user'));
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('123456');
        $user->save();

        return redirect()->back()->with('success', 'Password Has Been Reset');
    }

    public function createProfile()
    {
        $title = 'Create Profile';

        return view('home.profile.create', compact('title'));
    }

    public function storeProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/profile', $image->getClientOriginalName());

        $user = auth()->user();

        $user->profile()->create([
            'first_name' => $request->first_name,
            'image' => $image->getClientOriginalName()
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile Has Been Created');
    }

    public function editProfile()
    {
        $title = 'Edit Profile';
        $user = auth()->user();

        return view('home.profile.edit', compact('title', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        if ($request->file('image') == '') {
            $user->profile->update([
                'first_name' => $request->first_name
            ]);
        } else {
            Storage::delete('public/profile/' . basename($user->profile->image));

            $image = $request->file('image');
            $image->storeAs('public/profile', $image->getClientOriginalName());

            $user->profile->update([
                'first_name' => $request->first_name,
                'image' => $image->getClientOriginalName()
            ]);
        }

        return redirect()->route('profile.index')->with('success', 'Profile Has Been Updated');
    }
}
