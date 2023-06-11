<?php


namespace App\Http\Services\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SliderService
{
    public function insert($req)
    {
        try {
            #$req->except('_token');
            Slider::create($req->input());
            Session::flash('success', 'Thêm Slider mới thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider thất bại!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }
    public function get()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }
    public function update($req, $slider)
    {
        try
        {
            $slider->fill($req->input());
            $slider->save();
            Session::flash('success', 'Cập nhật Slider thành công');
        }catch(\Exception $err)
        {
            Session::flash('error', 'Cập nhật Slider thất bại!');
            Log::info($err->getMessage());
            return false;
        }
        return true;

    }

    public function destroy($req)
    {
        $slider = Slider::where('id', $req->input('id'))->first();
        if($slider)
        {
            $path = str_replace('storage', 'public', $slider->thumb);
            Storage::delete($path);
            $slider->delete();
            return true;
        }
        return false;
    }
    public function show()
    {
        return Slider::where('active', 1)->orderByDesc('sort_by')->get();
    }
}