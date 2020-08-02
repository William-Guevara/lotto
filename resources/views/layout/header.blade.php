<!-- ======= Header ======= -->
<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1><a href="{{ route('inicio') }}"><img src="{{ asset('images/logo.png') }}"
                        alt="Loterías Millonarias" /></a></h1>
            @if(auth()->check())
            <p style="background-color: white; border-radius: 5px 5px;">Hi {{ auth()->user()->fname }}
                {{ auth()->user()->lname }} </p>
            @endif
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="{{ Route::current()->getName() == 'inicio' ? 'active' : '' }}"><a
                        href="{{ route('inicio') }}">{!! trans('messages.home') !!}</a></li>
                @if( Route::current()->getName() == 'inicio')
                <li><a href="#about">{!! trans('messages.about') !!}</a></li>
                <li><a href="#faq">{!! trans('messages.faq') !!}</a></li>
                <li><a href="#contact">{!! trans('messages.contact') !!}</a></li>
                @endif
                <li class="drop-down"><a style="cursor:pointer">{!! trans('messages.lotteries') !!}</a>
                    <ul>
                        <li><a style="cursor:pointer" class="lotto_category_client"
                                data-category="Florida Lotto">Florida Lotto</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="New York Lotto">New
                                York Lotto</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Mega Millions">Mega
                                Millions</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Power ball">Power
                                ball</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="Euro Millones">Euro
                                Millones</a></li>
                        <li><a style="cursor:pointer" class="lotto_category_client" data-category="California Lotto">California Lotto</a></li>
                    </ul>
                </li>
                @if(auth()->check() == false)
                <li><a style="color: red" href="{{ route('login') }}">{!! trans('messages.login') !!}</a></li>
                <li><a style="color: red" href="{{ route('register') }}">{!! trans('messages.register') !!}</a></li>
                @else
                <li><a style="color: red" href="{{ route('logout') }}">{!! trans('messages.logout') !!}</a></li>
                @endif
                @if(auth()->user())
                @if(auth()->user()->level == 10)
                <li><a data-toggle="modal" data-target="#modalPanel" style="color:red; cursor:pointer">
                        {!! trans('messages.adminPanel') !!}</a></li>
                @endif
                @endif
                <li><a data-toggle="modal" data-target="#modalShopping" style="cursor:pointer">
                        <i class="bx bxs-cart" style="font-size:25px" aria-hidden="true"></i>
                    </a>
                <li>
                    @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <div class="top-right links">
                        @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                        <a href="{!! route('lang.swap', $lang) !!}">
                            {!! $lang !!} <small>{!! $lang !!}</small>
                        </a>
                        @else
                        @endif
                        @endforeach
                        {{--<img src="{{ asset('images/spain.png') }}" alt="Español" />
                        <img src="{{ asset('images/usa.png') }}" alt="English" />--}}
                    </div>
                    @endif

            </ul>
        </nav>
    </div>

</header>