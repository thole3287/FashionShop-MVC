<?php
 
namespace App\Http\View\Composers;
use Illuminate\View\View;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartComposer
{
    
    protected $users;
 
    public function __construct()
    {
        
    }
 
    public function compose(View $view)
    {
        // $qty = (int)$request->input('num_product');
        // $product_id = (int)$request->input('product_id');

        $carts = Session::get('carts');
        // dd($carts);
        if(is_null($carts))
        {
            return [];
        }
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                        ->where('active', 1)
                        ->whereIn('id', $productId)
                        ->get();

        $view->with('products', $products);
        

    //     $carts = Session::get('carts');

    // if (is_null($carts)) {
    //     $productQuantities = [];
    // } else {
    //     $productId = array_keys($carts);
    //     $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
    //         ->where('active', 1)
    //         ->whereIn('id', $productId)
    //         ->get();

    //     $productQuantities = [];

    //     foreach ($products as $product) {
    //         $productId = $product->id;
    //         $productQuantities[$productId] = isset($carts[$productId]['quantity']) ? $carts[$productId]['quantity'] : 0;
    //     }
    // }

    // $view->with('products', $products);
    // $view->with('productQuantities', $productQuantities);
    // $carts = Session::get('carts');
    // if (is_null($carts)) {
    //     $carts = [];
    // }
    // dd( $carts);

    // $productId = array_keys($carts);

    // if (count($productId) > 0) {
    //     $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
    //                     ->where('active', 1)
    //                     ->whereIn('id', $productId)
    //                     ->get();

    //     foreach ($products as $product) {
    //         $productId = $product->id;
    //         $product->quantity = isset($carts[$productId]['quantity']) ? (int) $carts[$productId]['quantity'] : 0;
    //     }
    // } else {
    //     $products = [];
    // }

    // $view->with('products', $products);
    // $carts = Session::get('carts');
    // if (is_null($carts)) {
    //     $carts = [];
    // }
    // // dd($carts); // <-- move this line here

    // $productId = array_keys($carts);

    // if (count($productId) > 0) {
    //     $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
    //                     ->where('active', 1)
    //                     ->whereIn('id', $productId)
    //                     ->get();

    //     foreach ($products as $product) {
    //         $productId = $product->id;
    //         $product->quantity = array_key_exists($productId, $carts) ? (int) $carts[$productId]['quantity'] : 0; // <-- use array_key_exists
    //     }
    // } else {
    //     $products = [];
    // }

    // $view->with('products', $products);
    }
}