<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function getIndex()
    {
        return view('admin.users.login',['title' => 'Đăng nhập hệ thống']);
    }
    public function postStore(Request $req)
    {
        $val= $req->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:20'
            ],
            [
                'email.required' => "Vui lòng nhập địa chỉ mail",
                'email.email' => "Địa chỉ mail không đúng định dạng",
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
                'password.max' => 'Mật khẩu tối đa 20 ký tự'
            ]
            );
        $authentication = array('email' => $val['email'], 'password' => $val['password']);
        if (Auth::attempt($authentication)) {
            return redirect()->route('admin');
        } else {
            return redirect()->back()->with(['matb' => '0', 'noidung' => 'Đăng nhập thất bại']);
        }
    }
}
