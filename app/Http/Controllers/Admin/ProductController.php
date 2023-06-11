<?php

namespace App\Http\Controllers\Admin;
use App\Http\Services\Product\ProductAdminService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function getAddProduct($id = '', $slug = '')
    {   
        return view('admin.products.add', [
            'title' => 'Thêm sản phẩm mới',
            'menus' => $this->productService->getMenu()
        ]);
    }

    public function postAddProduct(ProductRequest $req)
    {
        $this->productService->insert($req);
        return redirect()->back();
    }

    public function getListProduct()
    {
        return view('admin.products.list',[
            'title' => 'Danh Sách Sản Phẩm',
            'products' =>$this->productService->get()
        ]);
    }
    public function getEditProduct(Product $product)
    {
        return view('admin.products.edit',[
            'title' => 'Chỉnh Sửa Sản Phẩm: '.$product->name,
            'product' => $product,
            'menus' => $this->productService->getMenu()
        ]);
    }
    public function postEditProduct(Request $req, Product $product)
    {
        $result = $this->productService->update($req, $product);
        if($result == true)
        {
            return redirect('/admin/products/list');
        }
        return redirect()->back();
    }

    public function getDelete(Request $req): JsonResponse
    {
        $result = $this->productService->delete($req);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa sản phẩm thành công!'
            ]);
        }
        return response()->json([
            'error' => true,
        ]);
    }
}
