<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSettingController extends Controller
{
    public function edit()
    {
        return view('accountSetting.edit');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required|min:3|max:255|string',
            'last_name' => 'required|min:3|max:255|string',
        ]);

        $id = Auth::id();
        $user = User::find($id);
        $user->update($attributes);

        return back()->with('status', 'Successfully Updated');
    }
}
