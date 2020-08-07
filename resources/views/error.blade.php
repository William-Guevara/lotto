@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data section-bg">
    <div class="section-title">
        <h2 data-aos="fade-up">Error</h2>
    </div>
    <div class="container">
        <p class="description" style="color: red">{!! $error !!}</p>
    </div>
</section>

@endsection

@section('scripts')

@endsection