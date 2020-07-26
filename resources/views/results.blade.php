@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Results</h2>
    </div>
    <div class="container">
        <button data-option="create" data-tooltip="tooltip" title="Add user" data-toggle="modal"
            data-target="#modalAdminResult" class="btn-info clear">
            <i class="bx bxs-add-to-queue"></i>
        </button>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Drawing Date</th>
                    <th>Numbers</th>
                    <th>Jackpot</th>
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
                    <td>
                        <div class="row">
                            <button data-result="{!! $result->drawing_id !!}" data-option="update"
                                data-tooltip="tooltip" title="Edit result" data-toggle="modal"
                                data-target="#modalAdminResult" class="btn-primary clear">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button data-result="{!! $result->drawing_id !!}" class="btn-danger btn_delete">
                                <i class="bx bx-minus "></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{--Fin Modal Admin Create Update --}}
<div class="modal fade" id="modalAdminResult" aria-hidden="true" aria-labelledby="modal-title" role="dialog"
    tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="editser">
                <div class="container">
                    <div class="section-title">
                        <h2 id="tittle_modal" data-aos="fade-up"></h2>
                        <a href="https://www.lotto.net/es/loto-florida/resultados" target="_blank">Result Florida Lotto,
                        </a>
                        <a href="https://www.lotto.net/es/loto-de-nueva-york/resultados" target="_blank">Result Euro
                            Millones, </a>
                        <a href="https://www.lotto.net/es/mega-millions/resultados" target="_blank">Result Mega
                            Millions, </a><br />
                        <a href="https://www.lotto.net/es/powerball/resultados" target="_blank">Result New York Lotto,
                        </a>
                        <a href="https://www.euromillones.com.es'" target="_blank">Result Power Ball</a>
                        {{--<a href="{!! $url !!}" target="_blank">{!! trans('messages.linkLotto') !!}</a>--}}
                        <input type="hidden" class="campos" id="option_select">
                        <input type="hidden" class="campos" id="drawing_id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Category</label>
                                    <select class="form-control campos" id="category">
                                        {{--<option value="California Lotto">California Lotto</option>--}}
                                        <option value="Euro Millones">Euro Millones</option>
                                        <option value="Florida Lotto">Florida Lotto</option>
                                        <option value="Mega Millions">Mega Millions</option>
                                        <option value="New York Lotto">New York Lotto</option>
                                        <option value="Power Ball">Power Ball</option>
                                        {{--<option value="Super Enalotto">Super Enalotto</option>--}}
                                        {{--<option value="Euro Jackpot">Euro Jackpot</option>--}}
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Drawing Date</label>
                                    <input type="date" class="form-control campos" id="drawing_date"
                                        placeholder="drawing_date" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Numbers</label>
                                    <input type="text" class="form-control campos" id="numbers" placeholder="numbers" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Jackpot</label>
                                    <input type="text" class="form-control campos" id="jackpot" placeholder="jackpot" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="btn_send" type="button">Send</button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
{{--Fin Modal Admin Create Update --}}

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/results.js') }}"></script>

<script>
//Agregado aqui para el control del formulario de registro y que es el mismo que el de actualizar
function getControl() {
    var url = "{{ route('results_control') }}";
    return url;
}
</script>


@endsection