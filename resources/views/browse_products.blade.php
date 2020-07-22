@extends('start')

@section('content')


<section id="services" class="services">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>{!! $category !!}</h2>
            <a href="{!! $url !!}" target="_blank">{!! trans('messages.linkLotto') !!}</a>
        </div>

        <div class="row">
            @foreach($purchases as $purchas)
            <div class="col-lg-6 col-md-8" data-aos="fade-up" data-aos-delay="100">
                <input type="hidden" class="_token" value="{{ csrf_token() }}">
                <div class="icon-box">
                    <div class="icon">
                        <img alt="" src="{{ asset('images/administrative-panel/purchases.png') }}" />
                    </div>
                    <h5 class="title">
                        {!! $purchas->name_en !!}
                    </h5>
                    <p>{!! $purchas->description_en !!}</p>
                    <h5 class="title">
                        ${!! $purchas->price !!}
                        @if((substr($purchas->name_en, -7) == 'Drawing' || (substr($purchas->name_es, -14)) == 'Proximo Sorteo'))
                        <input type="number" min="5" class="quantity input_quantity {!! $purchas->product_id !!}">
                        @else
                        <input type="number" min="1" class="quantity input_quantity {!! $purchas->product_id !!}">
                        @endif
                        <button data-product_id="{!! $purchas->product_id !!}"
                            data-description_en="{!! $purchas->description_en !!}"
                            data-name_en="{!! $purchas->name_en !!}" data-price="{!! $purchas->price !!}"
                            class="btn btn-sm btn-success btnAddCart">Add Cart</button>
                    </h5>
                </div>
            </div>
            @endforeach
        </div>

</section>


@endsection

@section('scripts')

@endsection