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
                    <td>{!! $purchas->name !!}</td>
                    <td>{!! $purchas->owed !!}</td>
                    <td>{!! $purchas->total_tickets !!}</td>
                    <td>{!! $purchas->total_tickets !!}</td>
                    <td>{!! $purchas->category !!}</td>
                    <td>
                        <input type="date" class="form-control">
                    </td>
                    <td>
                        <input type="file" class="form-control">
                    </td>
                    <td>
                        <button class="btn btn-success"><i class="bx bx-send"></i></button>
                    </td>
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