<!-- Header -->
<header class="header-v4">
<!-- Header desktop -->
    <div class="container-menu-desktop">
    <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        Help & FAQs
                    </a>

                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        My Account
                    </a>

                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        EN
                    </a>

                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        USD
                    </a>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">
            <!-- Logo desktop -->
                <a href="{{route('frontend')}}" class="logo">
                    <img src="{{asset('template_asset/img/logo.png')}}" alt="IMG-LOGO">
                </a>
                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li>
                            <a href="{{route('frontend')}}">Home</a>
                        </li>

                        <li>
                            <a href="">Handphone</a>
                            <ul class="sub-menu" style="max-height: 500px;overflow-y: scroll;">
                                @foreach($menu_hp as $hp)
                                    <li><a href="#">{{$hp->i_merk}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li>
                            <a href="">Aksesoris</a>
                            <ul class="sub-menu" style="max-height: 500px;overflow-y: scroll;">
                                @foreach($menu_acces as $acces)
                                    <li><a href="index.html">{{$acces->i_merk}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li>
                            <a href="blog.html">Blog</a>
                        </li>

                        <li>
                            <a href="about.html">About</a>
                        </li>

                        <li>
                            <a href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <div id="notifDekstop" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="">
                        <a href="{{route('shoping_cart', csrf_token())}}" class="cl2 hov-cl1"><i class="zmdi zmdi-shopping-cart"></i></a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
    <!-- Logo moblie -->
        <div class="logo-mobile">
         <a href="{{route('frontend')}}"><img src="{{asset('template_asset/img/logo_small.png')}}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>
            <div id="notifMobile" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="">
                <a href="{{route('shoping_cart', csrf_token())}}" class="cl2 hov-cl1"><i class="zmdi zmdi-shopping-cart"></i></a>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        Help & FAQs
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        My Account
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        EN
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        USD
                    </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="{{route('frontend')}}">Home</a>
            </li>

            <li>
                <a href="">Handphone</a>
                <ul class="sub-menu-m" style="max-height: 300px;overflow-y: scroll;">
                    @foreach($menu_hp as $hp)
                    <li><a href="index.html">{{$hp->i_merk}}</a></li>
                    @endforeach
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="">Aksesoris</a>
                <ul class="sub-menu-m" style="max-height: 300px;overflow-y: scroll;">
                    @foreach($menu_acces as $acces)
                    <li><a href="index.html">{{$acces->i_merk}}</a></li>
                    @endforeach
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{asset('template_asset/frontend/images/icons/icon-close2.png')}}" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>