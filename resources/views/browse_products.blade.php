@extends('start')

@section('content')


<section id="services" class="services">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>{!! $category !!}</h2>
        </div>

        <div class="row">
            @foreach($purchases as $purchas)
            <div class="col-lg-6 col-md-8" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-box">
                    <div class="icon">
                        <img alt="" src="{{ asset('images/administrative-panel/purchases.png') }}" />
                    </div>
                    <h5 class="title">
                        {!! $purchas->name_en !!}
                    </h5>
                    <p class="description">{!! $purchas->description_en !!}</p>
                    <h5 class="title">
                        ${!! $purchas->price !!}
                        <button class="btn btn-sm btn-success">Add Cart</button>

                    </h5>
                </div>
            </div>
            @endforeach
        </div>

</section>


@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/browse_products.js') }}"></script>

@endsection