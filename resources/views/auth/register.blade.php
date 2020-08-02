@extends('start')

@section('content')
<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Register</h2>
    </div>
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Email') !!}</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Password')
                    !!}</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{!!
                    trans('messages.ConfirmPassword') !!}</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-md-4 col-form-label text-md-right">{!! trans('messages.FirstName')
                    !!}</label>
                <div class="col-md-6">
                    <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname"
                        value="{{ old('fname') }}" required autocomplete="fname" autofocus>
                    @error('fname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-md-4 col-form-label text-md-right">{!! trans('messages.LastName')
                    !!}</label>
                <div class="col-md-6">
                    <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname"
                        value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                    @error('lname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Address')
                    !!}</label>
                <div class="col-md-6">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">{!! trans('messages.City') !!}</label>
                <div class="col-md-6">
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                        value="{{ old('city') }}" required autocomplete="city" autofocus>

                    @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-md-4 col-form-label text-md-right">{!! trans('messages.State') !!}</label>
                <div class="col-md-6">
                    <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                        value="{{ old('state') }}" required autocomplete="state" autofocus>

                    @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="zip_code" class="col-md-4 col-form-label text-md-right">{!! trans('messages.ZipCode')
                    !!}</label>
                <div class="col-md-6">
                    <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror"
                        name="zip_code" value="{{ old('zip_code') }}" required autocomplete="zip_code" autofocus>

                    @error('zip_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="country" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Country')
                    !!}</label>
                <div class="col-md-6">
                    <input type="hidden" class="form-control" id="id_country" name="country" autocomplete="off">
                    <input id="country" type="text"
                        class="typeahead_country form-control @error('country') is-invalid @enderror"
                        value="{{ old('country') }}" required autocomplete="country" autofocus>
                    @error('country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Phone') !!}</label>
                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        value="{{ old('phone') }}" autocomplete="phone" autofocus>

                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="fax" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Fax') !!}</label>
                <div class="col-md-6">
                    <input id="fax" type="text" class="form-control @error('fax') is-invalid @enderror" name="fax"
                        value="{{ old('fax') }}" autocomplete="fax" autofocus>

                    @error('fax')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Gender')
                    !!}</label>
                <div class="col-md-6">
                    <select id="gender" type="text" class="form-control @error('gender') is-invalid @enderror"
                        name="gender" value="{{ old('gender') }}" autocomplete="gender" autofocus>

                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>

                    @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="newsletter" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Newsletter')
                    !!}</label>
                <div class="col-md-6">
                    <select id="newsletter" type="text" class="form-control @error('newsletter') is-invalid @enderror"
                        name="newsletter" value="{{ old('newsletter') }}" autocomplete="newsletter" autofocus>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    @error('newsletter')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="language" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Lenguage')
                    !!}</label>
                <div class="col-md-6">
                    <select id="language" type="text" class="form-control @error('language') is-invalid @enderror"
                        name="language" value="{{ old('language') }}" required autocomplete="language" autofocus>
                        <option value="es">Espanol</option>
                        <option value="en">English</option>
                    </select>
                    @error('language')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {!! trans('messages.Register') !!}
                    </button>
                </div>
            </div>

        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
var routCountry = "country_typea";
$(".typeahead_country").typeahead({
    highlight: true,
    minLength: 1,
}, {
    name: "country",
    display: "country_name",
    limit: 35,
    source: function(query, syncResults, asyncResults) {
        return $.get(
            routCountry, {
                query: query,
            },
            function(data) {
                return asyncResults(data);
            }
        );
    },
});
$(".typeahead_country").bind("typeahead:select", function(ev, data) {
    $("#id_country").val(data.country_id);
});
</script>

@endsection