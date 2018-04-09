<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Exception;

class UserController extends DashboardController
{
    public function showUser(Request $request)
    {
    	return view('dashboard.user-edit', ['info' => $request->input('info'), 'user' => Auth::user()]);
    }

    public function editUser(Request $request)
    {
    	// try {
     //        $user = User::find($request->input('user-id'));
     //    	$user->picture_url = User::find($request->input('user-id'));
     //    	$user->save();
     //    }
     //    catch(Exception $e) {
     //        return view('dashboard.user-edit', ['info' => $e->getMessage(), 'user' => Auth::user()]);
     //    }
        return redirect()->action('Dashboard\UserController@showUser');
    }
}
