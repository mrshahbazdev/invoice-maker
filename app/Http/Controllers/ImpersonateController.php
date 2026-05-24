<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController
{
    public function leave(Request $request)
    {
        if ($request->session()->has('impersonated_by')) {
            $adminId = $request->session()->pull('impersonated_by');
            Auth::loginUsingId($adminId);
            return redirect()->route('admin.users.index');
        }

        return redirect()->route('dashboard');
    }
}
