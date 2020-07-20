@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Purchases</h2>
        <p data-aos="fade-up">This section allows you to view and search through user purchases</p>
    </div>
    <div class="container">
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Reponse</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Amount</th>
                    <th>completion timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchas)
                <tr>
                    <td>{!! $purchas->order_id !!}</td>
                    <td>{!! $purchas->response_code !!}</td>
                    <td>{!! $purchas->first_name !!}</td>
                    <td>{!! $purchas->last_name !!}</td>
                    <td>${!! $purchas->amount !!}</td>
                    <td>{!! $purchas->completion_timestamp !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/purchases.js') }}"></script>

@endsection