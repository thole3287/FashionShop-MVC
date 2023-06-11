<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    

    public function getIndex()
    {
        return view('admin.home', [
            'title' => 'Trang quản trị Admin'
        ]);
    }
}
