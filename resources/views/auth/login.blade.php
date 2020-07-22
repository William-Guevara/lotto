@extends('start')

@section('content')
<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">{!! trans('messages.loginTittle') !!}</h2>
    </div>
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form id="form-login" method="POST" action="{{ route('login') }}">
            @csrf
            <!--Correo electronico-->
            <div class="form-group row">

                <label for="email" class="col-md-4 col-form-label text-md-right">{!! trans('messages.loginEmail') !!}</label>

                <div class="col-md-4">

                    <input id="email" type="email" placeholder="Correo asignado"
                        class="form-control input-border-bottom @error('email') is-invalid @enderror" name="email"
                        required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>

            </div>
            <!--Constraseña-->
            <div class="form-group row">

                <label for="password" class="col-md-4 col-form-label text-md-right">{!! trans('messages.loginPassword') !!}</label>

                <div class="col-md-4">
                    <input id="password" type="password" placeholder="Contraseña"
                        class="form-control input-border-bottom @error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="show-password">
                        <i class="flaticon-interface"></i>
                    </div>

                </div>

            </div>

            <!--Boton de envio formulario login -->
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">
                        {{ __('Ingresar') }}
                    </button>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                    @endif

                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')

@endsection