@extends('start')

@section('content')
<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Email Results</h2>
        <p data-aos="fade-up">Latest Results:</p>
    </div>
    <div class="container">
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th></th>
                    <th> </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>{!! $result->category !!}</td>
                    <td>{!! $result->drawing_date !!}</td>
                    <td>{!! $result->numbers !!}</td>
                    <td>{!! $result->jackpot !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</br>
        <a href="{{ route('send_mail') }}" target="_blank">Click here to send results emails
        </a>
    </div>

</section>

@endsection

@section('scripts')

@endsection