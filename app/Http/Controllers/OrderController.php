<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = OrderService::getInstance()->listOrder();

        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required'
        ]);

        OrderService::getInstance()->storeOrder($request);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $orderProduct = Cart::join('products', 'products.id', 'carts.product_id')
            ->where('order_id', $id)
            ->select('products.*', 'carts.size', 'carts.quantity')
            ->get()
            ->toArray();
        // return $order;
        return view('backend.order.show')->with('order', $order)->with('orderProduct', $orderProduct);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);

        OrderService::getInstance()->updateOrder($request, $id);

        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderService::getInstance()->destroyOrder($id);

        return redirect()->route('order.index');
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('success', 'Đơn hàng của bạn đã được đặt. Vui lòng chờ.');
                return redirect()->route('home');

            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Đơn hàng của bạn đang được xử lý vui lòng đợi.');
                return redirect()->route('home');

            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Đơn hàng của bạn đã được giao thành công.');
                return redirect()->route('home');

            } else {
                request()->session()->flash('error', 'Đơn đặt hàng của bạn đã bị hủy. vui lòng thử lại');
                return redirect()->route('home');

            }
        } else {
            request()->session()->flash('error', 'Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }

    // Income chart
    public function incomeChart(Request $request)
    {
        return OrderService::getInstance()->incomeChart($request);
    }

    public function saveOrderVnpay(Request $request) {
        $order = $request->query('order_id');
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->get('product_id', 'quantity', 'size')->toArray();
        $listProduct = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order]);
        $listProduct = Cart::where('user_id', auth()->user()->id)->where('order_id', $order)->get();
        foreach($listProduct as $item) {
            $product = ProductSize::where('product_id', $item['product_id'])->where('size', $item['size'])->first();
            $product['stock'] = $product['stock'] - $item['quantity'];
            $product->save();
        }

        request()->session()->flash('success', 'Sản phẩm của bạn đã đặt hàng thành công');

        return redirect()->route('home');
    }
}
