@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Search to category</h2>
    </div>
    <div class="container">
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Owed</th>
                    <th>Needed</th>
                    <th>#</th>
                    <th>Categotry</th>
                    <th>Date</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchas)
                <tr>
                    <form action="{{ route('AddTicket') }}" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <td>{!! $purchas->name !!}</td>
                        <td>{!! $purchas->owed !!}</td>
                        <td>{!! $purchas->total_tickets !!}</td>
                        <td><input name="num" class="input_quantity" type="num" min="1" value="{!! $purchas->total_tickets !!}"></td>
                        <td>
                            <input name="category" type="text" value="{!! $purchas->category !!}"></td>
                        <td>
                            <input name="date" type="date" class="form-control">
                        </td>
                        <td>
                            <input name="file_" type="file" class="form-control">
                        </td>
                        <td>
                            <input name="user_id" value="{!! $purchas->user_id !!}">
                            <input name="purchased_product_id" value="{!! $purchas->purchased_product_id !!}">
                            <input class="btn btn-success" type="submit" value="Enviar">
                        </td>
                    </form>
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