<?php
namespace App\Http\Services\Menu;
use Illuminate\Support\Str;

use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Return_;

class MenuService
{
    public function create($req)
    {
       try {
            Menu::create([
                'name' => (string) $req->input('name'),
                'parent_id' => (int) $req->input('parent_id'),
                'description' => (string) $req->input('description'),
                'content' => (string) $req->input('content'),
                'active' => (string) $req->input('active'),                
            ]);
            Session::flash('success', 'Tạo Danh Mục Thành Công');
       } catch (\Exception $err) {
         Session::flash('error', $err->getMessage());
         return false;
       }
       return true;
    }
    //bang 0 lấy cha bằng 1 lấy tấc cả
    public function getParent()
    {
        return Menu::where('parent_id', 0)->get();
    }

    public function show()
    {
        return Menu::select('name', 'id')->where('parent_id', 0)->where('active', 1)->orderbyDesc('id')->get();
    }

    public function getAll()
    {
        return Menu::orderbyDesc('id')->paginate(20);
    }

    
    public function destroy($req)
    {
        $id = (int) $req->input('id');
        $menu = Menu::where('id',$id )->first();
        if($menu)
        {
            return Menu::where('id', $id )->orWhere('parent_id', $id)->delete();
        }
        return false;
    }
    public function update($req, $menu) : bool
    {
        if($req->input('parent_id') != $menu->id)
        {
            $menu->parent_id = (int) $req->input('parent_id');
        }
        $menu->name = (string) $req->input('name');
        $menu->description = (string) $req->input('description');
        $menu->content = (string) $req->input('content');
        $menu->active = (string) $req->input('active');
        $menu->save();
        Session::flash('success', 'Cập nhật Danh Mục thành công!!');
        return true;
    }
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $req)
    {
        
        $query = $menu->products()
                    ->select('id', 'name', 'price', 'price_sale', 'thumb')
                    ->where('active', 1);
        if($req->input('price'))
        {
            $query->orderBy('price', $req->input('price'));
        }
        return  $query->orderByDesc('id')->paginate(12)->withQueryString();
    }
}