@extends('start')

@section('head')

<link rel="stylesheet" href="{{ asset('sceditor-2.1.3/minified/themes/default.min.css') }}" id="theme-style" />

@endsection

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Emails</h2>
        <p data-aos="fade-up">This section allows you to view mail templates.</p>
    </div>
    <div class="container">
        <button data-option="create" data-tooltip="tooltip" title="Add user" data-toggle="modal"
            data-target="#modalAdminTemplate" class="btn-info clear">
            <i class="bx bxs-add-to-queue"></i>
        </button>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>subject</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                    <td>{!! $template->id !!}</td>
                    <td>{!! $template->name !!}</td>
                    <td>{!! $template->subject !!}</td>
                    <td>
                        <div class="row">
                            <button data-template="{!! $template->id !!}" data-option="update" data-tooltip="tooltip"
                                title="Edit template" data-toggle="modal" data-target="#modalAdminTemplate"
                                class="btn-primary clear">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button data-template="{!! $template->id !!}" class="btn-danger btn_delete">
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
<div class="modal fade" id="modalAdminTemplate" aria-hidden="true" aria-labelledby="modal-title" role="dialog"
    tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="editser">
                <div class="container">
                    <div class="section-title">
                        <h2 id="tittle_modal" data-aos="fade-up"></h2>
                        <input type="hidden" class="campos" id="option_select">
                        <input type="hidden" class="campos" id="id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control campos" id="name" placeholder="Name" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control campos" id="subject"
                                        placeholder="Subject"/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Content</label>
                                    <div>
                                        <textarea id="content_" class="campos"></textarea>
                                    </div>
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
<script src="{{ asset('js/js_blade/admin_mail_templates.js') }}"></script>
<script src="{{ asset('js/js_blade/tables.js') }}"></script>

<script src="{{ asset('sceditor-2.1.3/minified/sceditor.min.js') }}"></script>
<script src="{{ asset('sceditor-2.1.3/minified/icons/monocons.js') }}"></script>
<script src="{{ asset('sceditor-2.1.3/minified/formats/bbcode.js') }}"></script>

<script>
//Agregado aqui para el control del formulario de registro y que es el mismo que el de actualizar
function getControl() {
    var url = "{{ route('products_control') }}";
    return url;
}
</script>

@endsection