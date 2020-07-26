{{--Modal Carrito --}}
<div class="modal fade" id="modalShopping" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="services" class="services">
                <div class="container">
                    <div class="section-title" data-aos="fade-up">
                        <h2>Cart</h2>
                    </div>
                    {{--Campos Individuales--}}

                    {{--Tabla en modal Productos a tranferir--}}
                    <div id="table" style="width: 100%" class="table-responsive">
                        <table id="tableCart" style="width: 100%" class="display table table-striped table-hover">
                            <colgroup>
                                <col style="width: 50%">
                                <col style="width: 15%">
                                <col style="width: 10%">
                                <col style="width: 15%">
                                <col style="width: 10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    {{--Fin Tabla en modal--}}
                    <div class="modal-footer no-bd">
                        <button type="button" id="btnSendCart" class="btn btn-success">Realizar transaccion</button>
                        <button type="button" id="btnClearCart" class="btn btn-danger">Borrar carrito</button>
                    </div>
                </div>
        </div>
        </section>
    </div>
</div>
{{--Fin Modal Carrito --}}

{{--Modal Panel --}}
<div class="modal fade" id="modalPanel" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">

            <section id="services" class="services">
                <div class="container">
                    <div class="section-title" data-aos="fade-up">
                        <h2>Admin Panel</h2>
                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-6" data-aos="fade-up">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/users.png') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('users') }}">Users</a></h4>
                                <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas
                                    molestias excepturi sint occaecati cupiditate non provident</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/products.png') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('products') }}">Products</a></h4>
                                <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas
                                    molestias excepturi sint occaecati cupiditate non provident</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/purchases.png') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('purchases') }}">Purchases</a></h4>
                                <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                    aliquip ex ea commodo consequat tarad limino ata</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/lottery_tickets.jpg') }}" />
                                </div>
                                <h4 class="title"><a href="">Add tickets</a></h4>
                                <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/lottery_tickets.jpg') }}" />
                                </div>
                                <h4 class="title"><a href="">View tickets</a></h4>
                                <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa
                                    qui officia deserunt mollit anim id est laborum</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/lottery_balls.jpg') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('results') }}">Lotery Results</a></h4>
                                <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                    blanditiis praesentium voluptatum deleniti atque</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/Florida-Lotto.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Florida Lotto">Tickets Florida Lotto</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/New-York-Lotto.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="New York Lotto">Tickets New York Lotto</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/California-Lotto.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="California Lotto">California Lotto</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/Power-Ball.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Power Ball">Tickets Power Ball Lotto</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/Euro-Millions.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Euro Millones">Tickets Euro Millions</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/Mega-Millions.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Mega Millions">Tickets Mega Millions</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/enal.png') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Super Enalotto">Tickets Super Enaloto</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/eurojackpot.jpg') }}" />
                                </div>
                                <h4 class="title"><a class="lotto_category" style="cursor:pointer"
                                        data-category="Euro Jackpot">Tickets Euro Jackpot</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/mail.png') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('adminMailTemplate') }}">Mail</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                            <div class="icon-box">
                                <div class="icon">
                                    <img alt="" src="{{ asset('images/administrative-panel/home.png') }}" />
                                </div>
                                <h4 class="title"><a href="{{ route('EdithHome') }}">Edith Homepage</a></h4>
                                <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam
                                    libero tempore, cum soluta nobis est eligendi</p>
                            </div>
                        </div>

                    </div>

                </div>
            </section><!-- End Services Section -->

        </div>
    </div>
</div>
{{--Fin Modal Panel --}}

{{--Modal register --}}
<div class="modal fade" id="modalUserAdmin" aria-hidden="true" aria-labelledby="modal-title" role="dialog"
    tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="editser">
                <div class="container">
                    <div class="section-title">
                        <h2 id="tittle_modal" data-aos="fade-up"></h2>
                        <input type="hidden" class="campos" id="option_select">
                        <input type="hidden" class="campos" id="user_id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control campos" name="email" placeholder="Email" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email2</label>
                                    <input type="text" class="form-control campos" name="email2" placeholder="Email2" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Password</label>
                                    <input type="text" class="form-control campos" name="password"
                                        placeholder="Password" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>FirstName</label>
                                    <input type="text" class="form-control campos" name="fname"
                                        placeholder="First Name" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>LastName</label>
                                    <input type="text" class="form-control campos" name="lname"
                                        placeholder="Last Name" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control campos" name="address"
                                        placeholder="Address" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control campos" name="city" placeholder="City" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control campos" name="state" placeholder="State" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>ZipCode</label>
                                    <input type="text" class="form-control campos" name="zip_code"
                                        placeholder="Zip Code" value="0000" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <input type="hidden" class="campos" name="country">
                                    <input type="text" class="form-control typeahead_country campos" autocomplete="off">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control campos" name="phone" placeholder="Phone" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control campos" name="fax" placeholder="Fax" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Gender</label>
                                    <select class="form-control campos" name="gender">
                                        <option value="m">M</option>
                                        <option value="f">F</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Credits</label>
                                    <input type="number" nim="0" step="0.01" class="form-control campos" name="credits"
                                        placeholder="Credits" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Newsletter</label>
                                    <select class="form-control campos" name="newsletter">
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Lenguage</label>
                                    <select class="form-control campos" name="language">
                                        <option value="es">Espanol</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Level</label>
                                    <select class="form-control campos" name="level">
                                        <option value="1" selectd>Normal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="btn_send" type="button">Send</button>
                        <button class="btn btn-danger" data-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </section><!-- End Services Section -->

        </div>
    </div>
</div>
{{--Fin Modal register user --}}

{{--Modal login --}}
<div class="modal fade" id="modalLogin" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">

            <section id="login" class="login">
                <div class="container">
                    <div class="section-title" data-aos="fade-up">
                        <h2>User login</h2>
                    </div>

                    <form id="form-login" method="POST" action="{{ route('login') }}">
                        @csrf
                        <!--Correo electronico-->
                        <div class="form-group ">
                            <input id="email" type="email" placeholder="Correo asignado"
                                class="form-control input-border-bottom @error('email') is-invalid @enderror"
                                name="email" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <!--Constraseña-->
                        <div class="form-group">
                            <input id="password" type="password" placeholder="Contraseña"
                                class="form-control input-border-bottom @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="show-password">
                                <i class="flaticon-interface"></i>
                            </div>
                        </div>
                        <!--Boton de envio formulario login -->
                        <div class="form-action mb-3">
                            <button type="submit" class="btn btn-primary btn-rounded btn-login">
                                {{ __('Ingresar') }}
                            </button>

                            @if (Route::has('password.request'))
                            <a class="btn btn-link">
                                {{--href="{{ route('password.request') }}"--}}
                                {{ __('Olvidaste tu contraseña?') }}
                            </a>
                            @endif

                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
{{--Fin Modal Login --}}