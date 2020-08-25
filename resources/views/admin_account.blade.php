@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div data-aos="fade-up" class="container">
        <div class="section-title">
            <h2>Acount User</h2>
        </div>
        <form method="POST" action="{{ route('user_control') }}">
            <input type="hidden" name="option" value="update_admin">
            <input type="hidden" name="user_id" value="{!! $user->user_id !!}">
            <div class="form-group row">
                @csrf
                <div class="form-group col-md-6 row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Email')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{!! $user->email !!}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="fname" class="col-md-4 col-form-label text-md-right">{!! trans('messages.FirstName')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                            name="fname" value="{!! $user->fname !!}" required autocomplete="fname" autofocus>
                        @error('fname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="lname" class="col-md-4 col-form-label text-md-right">{!! trans('messages.LastName')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                            name="lname" value="{!! $user->lname !!}" required autocomplete="lname" autofocus>

                        @error('lname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="address" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Address')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{!! $user->address !!}" required autocomplete="address" autofocus>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="city" class="col-md-4 col-form-label text-md-right">{!! trans('messages.City')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                            name="city" value="{!! $user->city !!}" required autocomplete="city" autofocus>

                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="state" class="col-md-4 col-form-label text-md-right">{!! trans('messages.State')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror"
                            name="state" value="{!! $user->state !!}" required autocomplete="state" autofocus>

                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="zip_code" class="col-md-4 col-form-label text-md-right">{!!
                        trans('messages.ZipCode')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror"
                            name="zip_code" value="{!! $user->zip_code !!}" required autocomplete="zip_code" autofocus>

                        @error('zip_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-6 row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Phone')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{!! $user->phone !!}" autocomplete="phone" autofocus>

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="fax" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Fax')
                        !!}</label>
                    <div class="col-md-6">
                        <input id="fax" type="text" class="form-control @error('fax') is-invalid @enderror" name="fax"
                            value="{!! $user->fax !!}" autocomplete="fax" autofocus>

                        @error('fax')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="gender" class="col-md-4 col-form-label text-md-right">{!! trans('messages.Gender')
                        !!}</label>
                    <div class="col-md-6">
                        <select id="gender" type="text" class="form-control @error('gender') is-invalid @enderror"
                            name="gender" value="{!! $user->gender !!}" autocomplete="gender" autofocus>

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
                <div class="form-group col-md-6 row">
                    <label for="credits" class="col-md-4 col-form-label text-md-right">Credits</label>
                    <div class="col-md-6">
                        <input type="number" min="0"  step="0.01" id="credits" type="text" class="form-control @error('credits') is-invalid @enderror"
                            name="credits" value="{!! $user->credits !!}" required autocomplete="credits" autofocus>
                        @error('credits')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 row">
                    <label for="newsletter" class="col-md-4 col-form-label text-md-right">{!!
                        trans('messages.Newsletter')
                        !!}</label>
                    <div class="col-md-6">
                        <select id="newsletter" type="text"
                            class="form-control @error('newsletter') is-invalid @enderror" name="newsletter"
                            value="{!! $user->newsletter !!}" autocomplete="newsletter" autofocus>
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
                <div class="form-group col-md-6 row">
                    <label for="language" class="col-md-4 col-form-label text-md-right">{!!
                        trans('messages.Lenguage')
                        !!}</label>
                    <div class="col-md-6">
                        <select id="language" type="text" class="form-control @error('language') is-invalid @enderror"
                            name="language" value="{!! $user->language !!}" required autocomplete="language" autofocus>
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
                <div class="form-group col-md-6 row">
                    <label for="level" class="col-md-4 col-form-label text-md-right">Level</label>
                    <div class="col-md-6">
                        <select id="level" type="text" class="form-control @error('level') is-invalid @enderror"
                            name="level" value="{!! $user->level !!}" required autocomplete="level" autofocus>
                            <option value="1">Normal</option>
                            <option value="10">Admin</option>
                        </select>
                        @error('level')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-6  row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {!! trans('messages.update') !!}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section data-aos="fade-up" id="seccion_pass" class="seccion_table section-bg">
    <div data-aos="fade-up" class="container">
        <div class="section-title">
            <h2>{!! trans('messages.purchases') !!}</h2>
        </div>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Received</th>
                    <th>Owed</th>
                    <th>Date</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $result)
                <tr>
                    <td>{!! $result->order_id !!}</td>
                    <td>{!! $result->name_en !!}</td>
                    <td>{!! $result->quantity !!}</td>
                    <td>{!! $result->tickets_received !!}</td>
                    <td>{!! $result->owed !!}</td>
                    <td>{!! $result->completion_timestamp !!}</td>
                    <td>
                        <div class="row">
                            <button data-order_id="{!! $result->order_id !!}" data-toggle="modal"
                                data-target="#AdminTickets" class="btn-info">
                                <i class="bx bx-list-plus"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{-- Modal Admin Tickets --}}
<div class="modal fade section-bg" id="AdminTickets" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="products">
                <div class="container">
                    <div class="section-title">
                        <h2 data-aos="fade-up">Products in Order</h2>
                        <input type="hidden" class="campos" id="order_id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control campos" id="quantity"
                                        placeholder="Quantity" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <button class="btn btn-success" id="btn_send_tickets" type="button">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="table" style="width: 100%" class="table-responsive">

                        <table id="table_products" style="width: 100%" class="display table table-striped table-hover">
                            <colgroup>
                                <col style="width: 50">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 20%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Ticket Sold</th>
                                    <th>Delivered</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
{{--Fin Modal Admin tickets --}}

<section data-aos="fade-up" id="seccion_images">
    <div data-aos="fade-up" class="container">
        <div class="section-title">
            <h2>{!! trans('messages.images') !!}</h2>
        </div>
        <div class="row">
            @foreach($images as $ima)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up">
                <article class="member">
                    <div class="member-img">
                        <img src="{{ asset($ima->src_image)  }}" alt="{!! $ima->src_image !!}" class="img-fluid">
                    </div>
                    <div class="member-info">
                        <h4>{!! $ima->name !!}</h4>
                        <span>Date: {!! $ima->drawing_date !!}</span></br>
                        <span>Number of tickets: {!! $ima->num_tickets !!}</span></br>
                        <span>Order ID: {!! $ima->order_id !!}</span></br>
                        <span>Uploaded {!! $ima->current_ticket !!} of {!! $ima->promised !!}</span></br>
                    </div>
                </article><!-- End blog entry -->
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/adminAccount.js') }}"></script>

<script>
//Agregado aqui para el control del formulario de registro y que es el mismo que el de actualizar
function getControl() {
    var url = "{{ route('results_control') }}";
    return url;
}

function getModalProducts(id) {
    var url = "{{ route('DetailProducts', ':id') }}";
    url = url.replace(':id', id)
    return url;
}

function getAddTickets() {
    var url = "{{ route('AddTickets') }}";
    return url;
}
</script>


@endsection