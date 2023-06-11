<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use Illuminate\Http\JsonResponse;
use App\Models\Menu;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
    //\
    public function getCreate()
    {
        return view('admin.menu.add', [
            'title'=> 'Thêm Danh Mục Mới',
            'menus' => $this->menuService->getParent(),
        ]);
    }
    public function postCreate(CreateFormRequest $req)
    {
        $this->menuService->create($req);
       return redirect()->back();
    }
    public function getMenuList()
    {
        return view('admin.menu.list',[
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'menus' => $this->menuService->getAll()
        ]);
    }
    public function getDelete(Request $req): JsonResponse
    {
        $result = $this->menuService->destroy($req);
        if($result)
        {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }else{
            return response()->json([
                'error' => true,
            ]);
        }
       
       
    }
    public function getMenuEdit(Menu $menu)
    {
        
        return view('admin.menu.edit', [
            'title'=> 'Chỉnh Sử Danh Mục: '.$menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent(),
        ]);
    }
    public function postMenuEdit(Menu $menu, CreateFormRequest $req)
    {
        $this->menuService->update($req, $menu);
        return redirect('/admin/menus/list');
    }
}
