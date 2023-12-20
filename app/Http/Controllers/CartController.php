<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;

class CartController extends Controller
{
    protected $product = null;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Không có sản phẩm này');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error', 'Không có sản phẩm này');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $already_cart->save();

        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
        request()->session()->flash('success', 'Sản phẩm được thêm vào giỏ hàng thành công');
        return back();
    }

    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'quantity' => 'required',
            'size' => 'required'
        ]);
        // dd($request->quant[1]);


        $product = Product::where('slug', $request->slug)->first();
        $productSize = ProductSize::where('product_id', $product->id)->where('size', $request->size)->first();

        if ($productSize->stock < $request->quantity) {
            return back()->with('error', 'Hết hàng, bạn có thể thêm sản phẩm khác.');
        }
        if (($request->quantity < 1) || empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('size', $productSize->size)->where('order_id', null)->where('product_id', $product->id)->first();


        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quantity;
            $already_cart->amount = ($product->price * $request->quantity) + $already_cart->amount;

            if ($productSize->stock < $already_cart->quantity || $productSize->stock <= 0) return back()->with('error', 'Hàng tồn kho không đủ!.');

            $already_cart->save();

        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quantity;
            $cart->size = $productSize->size;
            $cart->amount = ($product->price * $request->quantity);
            if ($productSize->stock < $cart->quantity || $productSize->stock <= 0) return back()->with('error', 'Hàng tồn kho không đ`11ủ!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success', 'Sản phẩm được thêm vào giỏ hàng thành công');
        return back();
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success', 'Đã xóa giỏ hàng thành công');
            return back();
        }
        request()->session()->flash('error', 'Error please try again');
        return back();
    }

    public function cartUpdate(Request $request)
    {
        $productSize = ProductSize::where('product_id', $request->product_id)->where('size', $request->size)->first();

        if ($request->quant) {
            $error = array();
            $success = '';
            foreach ($request->quant as $index => $quant) {
                $id = $request->qty_id[$index];
                $cart = Cart::find($id);
                if ($quant > 0 && $cart) {
                    if ($productSize->stock < $quant) {
                        request()->session()->flash('error', 'Kho đã hết hàng');
                        return back();
                    }
                    $cart->quantity = ($productSize->stock > $quant) ? $quant : $productSize->stock;

                    if ($productSize->stock <= 0) continue;
                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cập nhật giỏ hàng thành công!';
                } else {
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Cart Invalid!');
        }
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );

    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request)
    {
        // $cart=session('cart');
        // $cart_index=\Str::random(10);
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }
        return view('frontend.pages.checkout');
    }
}
