@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Verify Transaction</h2>
    </div>
    <div class="container">
        @if($error <> "not")
            <p class="description" data-aos="fade-up">{!! $error !!}</p>
            @endif
            @if($response_code == 1 || $response_code == 4)
            <h2 class="title" data-aos="fade-up">Thank you for your payment.</h2>
            <p class="description" data-aos="fade-up">Your payment has been held for review. Please contact us in a few hours to verify the approval.</p>
            <p class="description" data-aos="fade-up"><span>Invoice Number: </span> {!! $data_success['invoice_num'] !!}</p>
            <p class="description" data-aos="fade-up"><span>Purchase Date: </span> {!! $data_success['date'] !!}</p>
            <p class="description" data-aos="fade-up"><span>Payment Amount: </span> {!! $data_success['amount'] !!}</p>
            <p class="description" data-aos="fade-up"><span>Payment Amount: </span> {!! $data_success['credits'] !!}</p>
            @elseif($response_code == 2)
            <h2 class="title" data-aos="fade-up">Payment was declined.</h2>
            <p class="description" data-aos="fade-up">Your payment was declined. Please contact us if you have any questions or try again using a different
                payment method. We appologize for any inconvenience.</p>
            @elseif($response_code == 3)
            <h2 class="title" data-aos="fade-up">There was an error processing your payment.</h2>
            <p class="description" data-aos="fade-up">Your payment was not successful due to an error. Please contact us if you have any questions or try your
                purchase again. We appologize for any inconvenience.</p>
            @endif
    </div>
</section>

@endsection

@section('scripts')

@endsection