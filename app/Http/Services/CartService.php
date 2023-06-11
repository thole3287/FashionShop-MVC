<?php

namespace App\Http\Services;

use App\Jobs\SendMail;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if($qty <=0 || $product_id <=0 )
        {
            Session::flash('error', 'Số lượng hoặc sản phẩm không chính xác');
            return false;
        }
        // Session::forget('carts');

        $carts = Session::get('carts');
        if(is_null($carts))
        {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }
        $exists = Arr::exists($carts, $product_id); ///check id trùng
        // dd($exists);
        if($exists)
        {
            // $qtyNew = $carts[$product_id] + $qty; //cộng
            // $carts[$product_id] =  $qtyNew; //update lại cái mảng
            // Session::put('carts',  $carts);
            $carts[$product_id] = $carts[$product_id] + $qty;
            // dd($carts);
            Session::put('carts', $carts);
            // return true;
            // Session::put('carts',  [
            //     $product_id => $qtyNew
            // ]);

            return true;

        }

        // dd($carts);
        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        // // return true;
        // Session::put('carts', [
        //     $product_id => $qty
        // ]);
        return true;

    }
    public function getProduct()
    {
        $carts = Session::get('carts');
        if(is_null($carts))
        {
            return [];
        }
        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                        ->where('active', 1)
                        ->whereIn('id', $productId)
                        ->get();
        // dd($productId);
    }
    public function removeProduct($productId)
    {
        $carts = Session::get('carts');
        unset($carts[$productId]);
        Session::put('carts', $carts);
    }

    public function updateProduct($productId, $qty)
    {
        $carts = Session::get('carts');
        $carts[$productId] = $qty;
        Session::put('carts', $carts);
    }



    public function update($request)
    {
        // Session::put('carts', $request->input('num_product'));
        // return true;
        $carts = $request->input('num_product');
        foreach($carts as $productId => $qty) {
            if ($qty == 0) {
                $this->removeProduct($productId); // call a function to remove the product
            } else {
                $this->updateProduct($productId, $qty); // call a function to update the product quantity
            }
        }
        return true;
    }

    public function addCart($request)
    {
        try {
            //dùng transaction để rollback về tránh ghi thừa csdl
            DB::beginTransaction();
            $carts = Session::get('carts');
            if(is_null($carts))
            {
                return false;
            }

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content')
            ]);

            $this->inforProductCart($carts, $customer->id);
            //ko lỗi nó sẽ commit
            DB::commit();
            
            Session::flash('success' , 'Đặt hàng thành công');
            #queue
            SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
            Session::forget('carts');//delete session
            
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error' , 'Đặt hàng thất bại, Vui lòng thử lại');
            return false;
        }
        return true;
    }
    protected function inforProductCart($carts, $customer_id) {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
                        ->where('active', 1)
                        ->whereIn('id', $productId)
                        ->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'quantity' => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
    
            ];
        }
        return Cart::insert($data);
    }
}