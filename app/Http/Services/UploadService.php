<?php

namespace App\Http\Services;


class UploadService
{
    
    public function store($req)
    {
        if ($req->hasFile('file')) {
            try {
                $file = $req->file("file");
                $ext = $file->getClientOriginalExtension();
                if ($ext != "jpg" && $ext != "png" && $ext != "jpeg"  && $ext != "tiff"  && $ext != "webp")
                {
                    return redirect()->with("loi", "Bạn chỉ được chọn file hình có: .jpg, .png, .jpeg, .tiff, .webp");
                }
                $name = $req->file('file')->getClientOriginalName();
                // dd($name);
                $pathFull= 'uploads/'.date("Y/m/d");
                $req->file('file')->storeAs('/public/'.$pathFull, $name);
                return '/storage/'.$pathFull.'/'.$name;
            } catch (\Exception $error) {
                //throw $th;
                return false;
            }
            
        }
    }
}