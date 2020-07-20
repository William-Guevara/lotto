<!-- ======= Header ======= -->
<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1><a href="{{ route('inicio') }}"><img src="{{ asset('images/logo.png') }}"
                        alt="Loterías Millonarias" /></a></h1>
        @if(auth()->check())
        <p>Hi ¡¡ {{ auth()->user()->fname }} {{ auth()->user()->lname }}  </p>
        @endif
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="{{ Route::current()->getName() == 'inicio' ? 'active' : '' }}"><a href="{{ route('inicio') }}">Home</a></li>
                @if( Route::current()->getName() == 'inicio')
                <li><a href="#about">How does it work?</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Contact Us</a></li>
                @endif
                <li class="drop-down"><a href="">lotteries</a>
                    <ul>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Florida Lotto">Florida Lotto</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="New York Lotto">New York Lotto</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Mega Millions">Mega Millions</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Power ball">Power ball</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Euro Millones">Euro Millones</a></li>
                    </ul>
                </li>
                @if(auth()->check() == false)
                <li><a style="color: red" href="{{ route('login') }}">Login</a></li>
                <li><a style="color: red" href="{{ route('register') }}">Register</a></li>
                @else
                <li><a style="color: red" href="{{ route('logout') }}">Logout</a></li>
                <li><a data-toggle="modal" data-target="#modalPanel" style="color:red; cursor:pointer">Admin Panel</a>
                </li>
                @endif
                <li><a data-toggle="modal" data-target="#modalShopping" style="cursor:pointer">
                        <i class="bx bxs-cart" style="font-size:25px" aria-hidden="true"></i>
                    </a>
                <li>
                    <!--<li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="blog.html">Blog</a></li>-->
            </ul>
        </nav><!-- .nav-menu -->
    </div>

</header><!-- End Header -->