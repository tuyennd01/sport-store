@extends('frontend.layouts.master')

@section('title','Thanh toán')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Thanh toán</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form" method="POST" action="{{route('cart.order')}}">
                    @csrf
                    <div class="row">

                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Thanh toán ở đây</h2>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Họ<span>*</span></label>
                                            <input type="text" name="first_name" placeholder="" value="{{old('first_name')}}" value="{{old('first_name')}}">
                                            @error('first_name')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Tên<span>*</span></label>
                                            <input type="text" name="last_name" placeholder="" value="{{old('lat_name')}}">
                                            @error('last_name')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Email<span>*</span></label>
                                            <input type="email" name="email" placeholder="" value="{{old('email')}}">
                                            @error('email')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Số điện thoại <span>*</span></label>
                                            <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                            @error('phone')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Quận, huyện, thành phố<span>*</span></label>
                                            <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                            @error('address1')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Địa chỉ cụ thể</label>
                                            <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                            @error('address2')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <!--/ End Form -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="order-details">
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Tổng đơn hàng</h2>
                                    <div class="content">
                                        <ul>
										    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>{{number_format(Helper::totalCartPrice())}} VND</span></li>
                                            <li class="shipping">
                                               Giá ship
                                                @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                                    <select name="shipping" class="nice-select">
                                                        <option value="">Chọn đơn vị giao hàng</option>
                                                        @foreach(Helper::shipping() as $shipping)
                                                        <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: {{$shipping->price}} VND</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <span>Free</span>
                                                @endif
                                            </li>

                                            @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{session('coupon')['value']}}">You Save<span>{{number_format(session('coupon')['value'])}} VND</span></li>
                                            @endif
                                            @php
                                                $total_amount=Helper::totalCartPrice();
                                                if(session('coupon')){
                                                    $total_amount=$total_amount-session('coupon')['value'];
                                                }
                                            @endphp
                                            @if(session('coupon'))
                                                <li class="last"  id="order_total_price">Tổng giá<span>{{number_format($total_amount)}} VND</span></li>
                                            @else
                                                <li class="last"  id="order_total_price">Tổng giá<span>{{number_format($total_amount)}} VND</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Phương thức thanh  toán</h2>
                                    <div class="content">
                                        <div class="checkbox">
                                            {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                            <form-group>
                                                <input name="payment_method"  type="radio" value="cod"> <label> Trả tiền khi nhận hàng</label><br>
                                                <input name="payment_method"  type="radio" value="vnpay"> <label> VNpay</label>
                                            </form-group>

                                        </div>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Phương thức thanh toán Widget -->

                                <!--/ End Phương thức thanh toán Widget -->
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            <button type="submit" class="btn">Thanh toán ngay</button>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Button Widget -->
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Services Area  -->
{{--    <section class="shop-services section home">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-md-6 col-12">--}}
{{--                    <!-- Start Single Service -->--}}
{{--                    <div class="single-service">--}}
{{--                        <i class="ti-rocket"></i>--}}
{{--                        <h4>Free shiping</h4>--}}
{{--                        <p>Orders over $100</p>--}}
{{--                    </div>--}}
{{--                    <!-- End Single Service -->--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-12">--}}
{{--                    <!-- Start Single Service -->--}}
{{--                    <div class="single-service">--}}
{{--                        <i class="ti-reload"></i>--}}
{{--                        <h4>Free Return</h4>--}}
{{--                        <p>Within 30 days returns</p>--}}
{{--                    </div>--}}
{{--                    <!-- End Single Service -->--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-12">--}}
{{--                    <!-- Start Single Service -->--}}
{{--                    <div class="single-service">--}}
{{--                        <i class="ti-lock"></i>--}}
{{--                        <h4>Sucure Payment</h4>--}}
{{--                        <p>100% secure payment</p>--}}
{{--                    </div>--}}
{{--                    <!-- End Single Service -->--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-md-6 col-12">--}}
{{--                    <!-- Start Single Service -->--}}
{{--                    <div class="single-service">--}}
{{--                        <i class="ti-tag"></i>--}}
{{--                        <h4>Best Peice</h4>--}}
{{--                        <p>Guaranteed Giá</p>--}}
{{--                    </div>--}}
{{--                    <!-- End Single Service -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- End Shop Services -->

    <!-- Start Shop Newsletter  -->
{{--    <section class="shop-newsletter section">--}}
{{--        <div class="container">--}}
{{--            <div class="inner-top">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-8 offset-lg-2 col-12">--}}
{{--                        <!-- Start Newsletter Inner -->--}}
{{--                        <div class="inner">--}}
{{--                            <h4>Newsletter</h4>--}}
{{--                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>--}}
{{--                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">--}}
{{--                                <input name="EMAIL" placeholder="Your email address" required="" type="email">--}}
{{--                                <button class="btn">Subscribe</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <!-- End Newsletter Inner -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- End Shop Newsletter -->
@endsection
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#4e73df !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

@endpush
