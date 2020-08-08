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
                            <option value="not">Select Lotto</option>
                            <option value="Florida Lotto">Florida Lotto</option>
                            <option value="New York Lotto">New York Lotto</option>
                            <option value="Mega Millions">Mega Millions</option>
                            <option value="Power ball">Power ball</option>
                            <option value="Euro Millones">Euro Millones</option>
                            <option value="Euro Jackpot">Euro Jackpot</option>
                            <option value="California Lotto">California Lotto</option>
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        <label>Drawing Date</label>
                        <input type="date" id="drawing_date" class="form-control">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Seach Tickets</label>
                        <input type="input" class="btn btn-sm btn-success btn_send_option" value="Send">
                    </div>
                </div>
            </div>
        </div>
        @if($validate <> 0)
            <div class="row">
                @foreach($images as $ima)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up">
                    <article class="member">
                    
                        <div class="member-img">
                            <img src="{{ asset($ima->src_image)  }}" alt="{!! $ima->src_image !!}" class="img-fluid">
                        </div>
                        <div class="member-info">
                            <h4>{!! $ima->name !!}</h4>
                            <span>Date: {!! $ima->drawing_date !!}</span></br>
                            <span>Number of tickets: {!! $ima->num_tickets !!}</span></br>
                            <span>Order ID: {!! $ima->order_id !!}</span></br>
                            <span>Uploaded {!! $ima->current_ticket !!} of {!! $ima->promised !!}</span></br>
                        </div>

                    </article><!-- End blog entry -->
                </div>
                @endforeach
            </div>
            @endif
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/tables.js') }}"></script>
<script src="{{ asset('js/js_blade/adminViewTickets.js') }}"></script>

<script>
function getLoad(category, drawing_date) {
    var url = "{{ route('ViewTicketLoad', [':category', ':drawing_date']) }}";
    url = url.replace(':category', category);
    url = url.replace(':drawing_date', drawing_date);
    return url;
}
</script>

@endsection