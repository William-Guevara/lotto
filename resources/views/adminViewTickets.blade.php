@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">View Tickets</h2>
    </div>
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
            <div class="col-xl-9 col-lg-12 mt-4">
                <div class="form-row">
                    <div class="col-md-5 form-group">
                        <label>Select Lottery</label>
                        <select class="form-control category">
                            <option value="Florida Lotto">Florida Lotto</option>
                            <option value="New York">New York Lotto</option>
                            <option value="Mega Millions">Mega Millions</option>
                            <option value="Power ball">Power ball</option>
                            <option value="Euro Millones">Euro Millones</option>
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        <label>Select Lottery</label>
                        <input type="date" class="form-control date_">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Seach Tickets</label>
                        <input type="btn" class="btn btn-sm btn-success form-control btn_send_option" value="Send">
                    </div>
                </div>
            </div>
        </div>
        @if($images <> null || $images <> undefined)
                @foreach($images as $ima)
                <label>{!! $ima->image_id !!}</label>
                <label>{!! $ima->image_id !!}</label>
                <label>{!! $ima->image_id !!}</label>
                <label>{!! $ima->image_id !!}</label>
               
                @endforeach
        @endif
     
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/tables.js') }}"></script>

@endsection