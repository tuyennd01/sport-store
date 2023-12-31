@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Chi tiết đơn hàng       <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm </th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Ảnh</th>
        </tr>
      </thead>
      <tbody>
      @php
          $index = 1;
      @endphp
        @foreach ($orderProduct as $item)
            <tr class="">
                <td>{{$index++}}</td>
                <td> {{$item['title']}}</td>
                <td> {{$item['size']}}</td>
                <td> {{$item['price']}}Đ</td>
                <td> {{$item['quantity']}}</td>
                <td>
                    @if($item['photo'])
                        @php
                            $photo=explode(',',$item['photo']);
                            // dd($photo);
                        @endphp
                        <img src="{{$photo[0]}}" class="img-fluid zoom" style="max-width:80px"
                             alt="{{$item['photo']}}">
                    @else
                        <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid"
                             style="max-width:80px" alt="avatar.png">
                    @endif
                </td>

            </tr>
            @endforeach
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
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
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
                        <td>Shipping </td>
                        <td> : {{isset($order->shipping->price) ?? $order->shipping->price}} Đ</td>
                    </tr>
                    <tr>
                      <td>Mã giảm giá</td>
                      <td> : {{number_format($order->coupon,2)}}Đ</td>
                    </tr>
                    <tr>
                        <td>Thành tiền</td>
                        <td> : {{number_format($order->total_amount,2)}}Đ</td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td> : @if($order->payment_method=='cod') Thanh toán khi nhận hng @else VNPay @endif</td>
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
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
