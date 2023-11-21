<header class="header shop">
    <div class="middle-inner">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach"
                                                         alt="logo"></a>
                    </div>
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Tìm Kiếm Tại Đây..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="right-bar">
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                            @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                            @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span
                                    class="total-count icon-wishlist">{{Helper::wishlistCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Sản phẩm</span>
                                        <a href="{{route('wishlist')}}">Xem</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach(Helper::getAllProductFromWishlist() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('wishlist-delete',$data->id)}}" class="remove"
                                                   title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                  alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                       target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span
                                                        class="amount">{{number_format($data->price)}} VND</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="single-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Sản phẩm</span>
                                        <a href="{{route('cart')}}">Xem giỏ hàng</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('cart-delete',$data->id)}}" class="remove"
                                                   title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                  alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                       target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span
                                                        class="amount">{{number_format($data->price)}} VND</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span
                                                class="total-amount">{{number_format(Helper::totalCartPrice())}} VND</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="single-bar shopping">
                            <div class="right-content">
                                <ul class="list-main">
                                    @auth
                                        @if(Auth::user()->role=='admin')
                                            <li><i class="ti-user"></i> <a href="{{route('admin')}}" target="_blank">Quản
                                                    lý</a></li>
                                        @else
                                            <li><i class="ti-user"></i> <a href="{{route('user')}}" target="_blank">Quản
                                                    lý</a></li>
                                        @endif
                                        <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Đăng
                                                xuất</a></li>

                                    @else
                                        <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Đăng nhập
                                                /</a> <a href="{{route('register.form')}}">Đăng kí</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a
                                                    href="{{route('home')}}">Trang chủ</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a
                                                    href="{{route('about-us')}}">Giới thiệu</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif">
                                                <a href="{{route('product-grids')}}">Sản phẩm</a><span
                                                    class="new">Mới</span></li>
                                            {{Helper::getHeaderCategory()}}
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a
                                                    href="{{route('blog')}}">Bài viết</a></li>

                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a
                                                    href="{{route('contact')}}">Liên hệ</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
