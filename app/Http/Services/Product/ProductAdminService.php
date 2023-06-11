<?php


namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductAdminService
{
    
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }


    protected function isValidPrice($req)
    {
        if($req->input('price') != 0 && $req->input('price_sale') !=0 && $req->input('price_sale') >= $req->input('price'))
        {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc!');
            return false;
        }

        if ($req->input('price_sale') !=0 && (int)$req->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc!');
            return false;
        }
        return true;
    }

    public function insert($req)
    {
        $isValidPrice = $this->isValidPrice($req);
        if($isValidPrice == false)
        {
            return false;
        }
        // dd($req->all());
        try {
            $req->except('_token');
            Product::create($req->all());
            Session::flash('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm sản phẩm thất bại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
       
    }
    public function get()
    {
        return Product::with('menu')->orderByDesc('id')->paginate(10);
    }
    public function update($req, $product)
    {
        $isValidPrice = $this->isValidPrice($req);
        if($isValidPrice === false)
        {
            return false;
        }

        try{
            $product->fill($req->input());
            $product->save();
            Session::flash('success', 'Cập nhật sản phẩm thành công!');
        }catch(\Exception $err)
        {
            Session::flash('error', 'Cập nhật sản phẩm thất bại!'); 
            Log::info($err->getMessage());
            return false;
        }
        return true;
      
    }
    public function delete($req)
    {
        $product = Product::where('id', $req->input('id'))->first();
        
        if($product)
        {
            $product->delete();
            return true;
        }
        return false;
    }

}