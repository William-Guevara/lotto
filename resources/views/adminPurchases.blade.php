@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">{!! $category !!}</h2>
    </div>
    <div class="container">
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Promised</th>
                    <th>Owed</th>
                    <th>Next Purchase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchas)
                <tr>
                    <td>{!! $purchas->name !!}</td>
                    <td>{!! $purchas->promised !!}</td>
                    <td>{!! $purchas->owed !!}</td>
                    <td>{!! $purchas->total_tickets !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/tables.js') }}"></script>

@endsection