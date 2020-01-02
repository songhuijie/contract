<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Http\Controllers\Controller;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {

        $user = Auth::guard('admin')->user();
        if ($user) return redirect('/admin/index');
        return view('admin.login.login');
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $service = new AdminService();
        $re = $service->login($request->username, $request->password, (bool)$request->remember);
        if ($re) {
            return ajaxSuccess();
        } else {
            return ajaxError($service->getError(), $service->getHttpCode());
        }
    }

    public function logOut()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

}