<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function getAddSlider() //create
    {
        return view('admin.slider.add', [
            'title' => 'Thêm Slider mới',
        ]);
    }
    public function postAddSlider(Request $req) //store
    {
        $this->validate($req, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required'
        ]);
        $this->slider->insert($req);
        return redirect('/admin/sliders/list');
    }
    public function getListSlider()
    {
        return view('admin.slider.list', [
            'title' => 'Danh sách Slider',
            'sliders' => $this->slider->get()
        ]);
    }
    public function getEditSlider(Slider $slider)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider'=> $slider
        ]);
    }
    public function postEditSlider(Request $req, Slider $slider)
    {
        $this->validate($req, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required'
        ]);
        $result = $this->slider->update($req, $slider);
        if ($result) {
            return redirect('/admin/sliders/list');
        }
        return redirect()->back();
        
    }

    public function getDelete(Request $req)
    {
        $result = $this->slider->destroy($req);
        if($result)
        {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Slider'
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }


}
