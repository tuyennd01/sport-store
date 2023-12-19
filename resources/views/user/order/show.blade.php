@extends('user.layouts.master')

@section('title','Order Detail')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Order <a href="{{route('order.pdf',$order->id)}}"
                                         class=" btn btn-sm btn-primary shadow-sm float-right"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
        </h5>
        <div class="card-body">
            @if($order)
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Người dùng</th>
                        <th>Email</th>
                        <th>Số lượng</th>
                        <th>Charge</th>
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->order_number}}</td>
                        <td>{{$order->first_name}} {{$order->last_name}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{isset($order->shipping->price) ?? $order->shipping->price}} VND</td>
                        <td>{{number_format($order->total_amount)}} vnd</td>
                        <td>
                            @if($order->status=='new')
                                <span class="badge badge-primary">{{$order->status}}</span>
                            @elseif($order->status=='process')
                                <span class="badge badge-warning">{{$order->status}}</span>
                            @elseif($order->status=='delivered')
                                <span class="badge badge-success">{{$order->status}}</span>
                            @else
                                <span class="badge badge-danger">{{$order->status}}</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px;
                                        width:30px;border-radius:50%
                                " data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                    class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>

                    </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">THÔNG TIN ĐƠN HÀNG</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Order Number</td>
                                            <td> : {{$order->order_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày ra đơn</td>
                                            <td> : {{$order->created_at->format('D d M, Y')}}
                                                at {{$order->created_at->format('g : i a')}} </td>
                                        </tr>
                                        <tr>
                                            <td>Số lượng</td>
                                            <td> : {{$order->quantity}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tình trạng đơn hàng</td>
                                            <td> : {{$order->status}}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
                                            @endphp
                                            <td>Shipping Charge</td>
                                            <td> :{{$order->shipping->price}} VND</td>
                                        </tr>
                                        <tr>
                                            <td>Thành tiền</td>
                                            <td> : $ {{number_format($order->total_amount,2)}}</td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td>oPhương thức thanh toán</td>
                                            <td> : @if($order->payment_method=='cod')
                                                    Cash on Delivery
                                                @else
                                                    Vnpay
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <td>Tình trạng thanh toán</td>
                                            <td>
                                                : {{$order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tình trạng thanh toán</td>
                                            <td> : {{$order->payment_status}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">THÔNG TIN GIAO HÀNG</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Tên</td>
                                            <td> : {{$order->first_name}} {{$order->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td> : {{$order->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại</td>
                                            <td> : {{$order->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Địa chỉ</td>
                                            <td> : {{$order->address1}}, {{$order->address2}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info, .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4, .shipping-info h4 {
            text-decoration: underline;
        }

    </style>
@endpush
