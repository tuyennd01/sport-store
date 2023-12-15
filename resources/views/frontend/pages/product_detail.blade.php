@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{$product_detail->summary}}">
    <meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:image" content="{{$product_detail->photo}}">
    <meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','DT-SHOP  || PRODUCT DETAIL')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Chi tiết sản phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="row">
									<div class="col-lg-6 col-12">
										<!-- Product Slider -->
										<div class="product-gallery">
											<!-- Images slider -->
											<div class="flexslider-thumbnails">
												<ul class="slides">
													@php
														$photo=explode(',',$product_detail->photo);
													// dd($photo);
													@endphp
													@foreach($photo as $data)
														<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
															<img src="{{$data}}" alt="{{$data}}">
														</li>
													@endforeach
												</ul>
											</div>
											<!-- End Images slider -->
										</div>
										<!-- End Product slider -->
									</div>
									<div class="col-lg-6 col-12">
										<div class="product-des">
											<!-- Description -->
											<div class="short">
												<h4>{{$product_detail->title}}</h4>
												<div class="rating-main">
													<ul class="rating">
														@php
															$rate=ceil($product_detail->getReview->avg('rate'))
														@endphp
															@for($i=1; $i<=5; $i++)
																@if($rate>=$i)
																	<li><i class="fa fa-star"></i></li>
																@else
																	<li><i class="fa fa-star-o"></i></li>
																@endif
															@endfor
													</ul>
													<a href="#" class="total-review">({{$product_detail['getReview']->count()}}) Bình luận</a>
                                                </div>
                                                @php
                                                    $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                                @endphp
												<p class="price"><span class="discount">{{number_format($after_discount)}} VND</span><s>{{number_format($product_detail->price)}} VND</s> </p>
												<p class="description">{!!($product_detail->summary)!!}</p>
											</div>
											<!--/ End Description -->
											<!-- Color -->
											{{-- <div class="color">
												<h4>Available Options <span>Color</span></h4>
												<ul>
													<li><a href="#" class="one"><i class="ti-check"></i></a></li>
													<li><a href="#" class="two"><i class="ti-check"></i></a></li>
													<li><a href="#" class="three"><i class="ti-check"></i></a></li>
													<li><a href="#" class="four"><i class="ti-check"></i></a></li>
												</ul>
											</div> --}}
											<!--/ End Color -->
											<!-- Size -->
											<!--/ End Size -->
											<!-- Product Buy -->
											<div class="product-buy">
												<form action="{{route('single-add-to-cart')}}" method="POST">
													@csrf
                                                    <div class="size mt-4">
                                                        <h4>Kích cỡ</h4>
                                                        @php
                                                            $sizes = json_decode($product_detail->product_sizes, true);
                                                        @endphp
                                                        <input type="hidden" name="size" id="selectedSize" value="">

                                                        <ul>
                                                            @foreach ($sizes as $size)
                                                                <li>
                                                                    <button type="button" class="size-link btn btn-secondary" data-size="{{ json_encode($size) }}" data-quantity="{{ $size['stock'] }}">{{ $size['size'] }}</button>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <br>
													<div class="quantity">
														<div class="input-group flex flex-column">
															<input type="hidden" name="slug" value="{{$product_detail->slug}}">
															<input type="number" name="quantity" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
														</div>
													<!--/ End Input Order -->
													</div>
													<div class="add-to-cart mt-4">
														<button type="submit" class="btn">Thêm vào giỏ</button>
														<a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a>
													</div>
                                                    <div id="quantityContainer" class="mt-4"></div>
												</form>

                                    <p class="cat">Danh mục :<a
                                            href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>
                                    </p>
                                    @if($product_detail->sub_cat_info)
                                        <p class="cat mt-1">Danh mục phụ:<a
                                                href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>
                                        </p>
                                    @endif
                                </div>
                                <!--/ End Product Buy -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <!-- Tab Nav -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#description" role="tab">Mô tả</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews"
                                                                role="tab">Reviews</a></li>
                                    </ul>
                                    <!--/ End Tab Nav -->
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Description Tab -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <p>{!! ($product_detail->description) !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Description Tab -->
                                    <!-- Reviews Tab -->
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12">

                                                    <!-- Review -->
                                                    <div class="comment-review">
                                                        <div class="add-review">
                                                            <h5>Thêm A Bình luận</h5>
                                                        </div>
                                                        <h4>Đánh giá của bạn <span class="text-danger">*</span></h4>
                                                        <div class="review-inner">
                                                            <!-- Form -->
                                                            @auth
                                                                <form class="form" method="post"
                                                                      action="{{route('review.store',$product_detail->slug)}}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-5"
                                                                                            type="radio" name="rate"
                                                                                            value="5">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-5"
                                                                                            title="5 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-4"
                                                                                            type="radio" name="rate"
                                                                                            value="4">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-4"
                                                                                            title="4 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-3"
                                                                                            type="radio" name="rate"
                                                                                            value="3">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-3"
                                                                                            title="3 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-2"
                                                                                            type="radio" name="rate"
                                                                                            value="2">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-2"
                                                                                            title="2 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-1"
                                                                                            type="radio" name="rate"
                                                                                            value="1">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-1"
                                                                                            title="1 out of 5 stars"></label>
                                                                                        @error('rate')
                                                                                        <span
                                                                                            class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <label>Để lại bình luận</label>
                                                                                <textarea name="review" rows="6"
                                                                                          placeholder=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group button5">
                                                                                <button type="submit" class="btn">Xác
                                                                                    nhận
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p class="text-center p-5">
                                                                    You need to <a href="{{route('login.form')}}"
                                                                                   style="color:rgb(54, 54, 204)">Login</a>
                                                                    OR <a style="color:blue"
                                                                          href="{{route('register.form')}}">Register</a>

                                                                </p>
                                                                <!--/ End Form -->
                                                            @endauth
                                                        </div>
                                                    </div>

                                                    <div class="ratting-main">
                                                        <div class="avg-ratting">
                                                            {{-- @php
                                                                $rate=0;
                                                                foreach($product_detail->rate as $key=>$rate){
                                                                    $rate +=$rate
                                                                }
                                                            @endphp --}}
                                                            <h4>{{ceil($product_detail->getReview->avg('rate'))}} <span>(Overall)</span>
                                                            </h4>
                                                            <span>Based on {{$product_detail->getReview->count()}} Comments</span>
                                                        </div>
                                                        @foreach($product_detail['getReview'] as $data)
                                                            <!-- Single Rating -->
                                                            <div class="single-rating">
                                                                <div class="rating-author">
                                                                    @if($data->user_info['photo'])
                                                                        <img src="{{$data->user_info['photo']}}"
                                                                             alt="{{$data->user_info['photo']}}">
                                                                    @else
                                                                        <img src="{{asset('backend/img/avatar.png')}}"
                                                                             alt="Profile.jpg">
                                                                    @endif
                                                                </div>
                                                                <div class="rating-des">
                                                                    <h6>{{$data->user_info['name']}}</h6>
                                                                    <div class="ratings">

                                                                        <ul class="rating">
                                                                            @for($i=1; $i<=5; $i++)
                                                                                @if($data->rate>=$i)
                                                                                    <li><i class="fa fa-star"></i></li>
                                                                                @else
                                                                                    <li><i class="fa fa-star-o"></i>
                                                                                    </li>
                                                                                @endif
                                                                            @endfor
                                                                        </ul>
                                                                        <div class="rate-count">
                                                                            (<span>{{$data->rate}}</span>)
                                                                        </div>
                                                                    </div>
                                                                    <p>{{$data->review}}</p>
                                                                </div>
                                                            </div>
                                                            <!--/ End Single Rating -->
                                                        @endforeach
                                                    </div>

                                                    <!--/ End Review -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Reviews Tab -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Shop Single -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- {{$product_detail->rel_prods}} --}}
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_detail->rel_prods as $data)
                            @if($data->id !==$product_detail->id)
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$data->slug)}}">
                                            @php
                                                $photo=explode(',',$data->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <span class="price-dec">{{$data->discount}} % Off</span>
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#modelExample" title="Quick View"
                                                   href="#"><i class=" ti-eye"></i><span>Xem Nhanh</span></a>
                                                <a title="Wishlist" href="#"><i
                                                        class=" ti-heart "></i><span>Yêu thích</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Thêm vào giỏ" href="#">Thêm vào giỏ</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$data->slug)}}">{{$data->title}}</a></h3>
                                        <div class="product-price">
                                            @php
                                                $after_discount=($data->price-(($data->discount*$data->price)/100));
                                            @endphp
                                            <span class="old">{{number_format($data->price)}} VND</span>
                                            <span>{{number_format($after_discount)}} VND</span>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Product -->

                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('styles')
    <style>
        /* Rating */
        .rating_box {
            display: inline-flex;
        }

        .star-rating {
            font-size: 0;
            padding-left: 10px;
            padding-right: 10px;
        }

        .star-rating__wrap {
            display: inline-block;
            font-size: 1rem;
        }

        .star-rating__wrap:after {
            content: "";
            display: table;
            clear: both;
        }

        .star-rating__ico {
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #4e73df;
            font-size: 16px;
            margin-top: 5px;
        }

        .star-rating__ico:last-child {
            padding-left: 0;
        }

        .star-rating__input {
            display: none;
        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover ~ .star-rating__ico:before,
        .star-rating__input:checked ~ .star-rating__ico:before {
            content: "\F005";
        }

    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.size-link').click(function (e) {
                e.preventDefault();

                var sizeLink = $(this);

                if (sizeLink.hasClass('bg-danger')) {
                    // If it's already selected, remove the selection
                    sizeLink.removeClass('bg-danger');
                    $('#quantityContainer').html(''); // Clear the quantity display
                } else {
                    // If it's not selected, remove the 'selected' class from all size links
                    $('.size-link').removeClass('bg-danger');

                    // Add the 'selected' class to the clicked size link
                    sizeLink.addClass('bg-danger');

                    var sizeData = $(this).data('size');
                    var quantity = $(this).data('quantity');

                    $('#selectedSize').val(sizeData['size']);

                    // Display the quantity for the selected size
                    $('#quantityContainer').html('<p>Trong kho còn: ' + quantity + '</p>');
                }
            });
        });
    </script>


@endpush
