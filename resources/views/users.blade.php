@extends('start')
<!--#c62020
 #ff5821-->
@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Users</h2>
        <p data-aos="fade-up">This section allows you to view and search through the membership records</p>
    </div>
    <div class="container">
        <button data-option="create" data-tooltip="tooltip" title="Add user" data-toggle="modal"
            data-target="#modalUserAdmin" class="btn-info clear">
            <i class="bx bx-user-plus"></i>
        </button>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Primer nombre</th>
                    <th>Segundo nombre</th>
                    <th>Correo electronico</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{!! $user->fname !!}</td>
                    <td>{!! $user->lname !!}</td>
                    <td>{!! $user->email !!}</td>
                    <td>
                        <div class="row">
                            <button data-user="{!! $user->user_id !!}" class="btn-danger btn_delete">
                                <i class="bx bx-minus"></i>
                            </button>
                            <button data-user="{!! $user->user_id !!}" class="btn-success btn_detail">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/users.js') }}"></script>
<script src="{{ asset('js/js_blade/tables.js') }}"></script>

<script>
    //Agregado aqui para el control del formulario de registro y que es el mismo que el de actualizar
    function getControl() {
        var url = "{{ route('user_control') }}";
        return url;
    }

    function getUserAcount(id) {
        var url = "{{ route('userDetail', ':id' ) }}";
        url = url.replace(':id',id)
        return url;
    }
</script>


@endsection