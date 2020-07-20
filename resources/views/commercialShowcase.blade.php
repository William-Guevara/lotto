@extends('start')

@section('content')
<!--
<script>
    var session = {!!json_encode(Session::get('cart')) !!};
</script>
-->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            {{-- Menu del contenido --}}
            <div class="page-header">
                <h4 class="page-title">Oportunidades Comerciales</h4>
                <div class="btn-group btn-group-page-header ml-auto">
                    <button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="modal" data-target="#modalShopping" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-shopping-cart" style="font-size:25px" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="arrow"></div>
                        <a class="dropdown-item" data-toggle="modal" data-target="#modalDetail"></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">...</a>
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            {{-- Final menu contenido  --}}
        </div>

        {{--Modal Detalle de carrito Carrito --}}
        <div class="modal fade" id="modalDetailTransac" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-1" style="z-index: 1200">
            <div class="modal-dialog  modal-left">
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h1 class="modal-title">
                            <span class="fw-mediumbold">
                                Detalle de tranferencia
                            </span>
                        </h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{--Tabla en modal Store asignados--}}
                    <div id="table" style="width: 100%" class="table-responsive">
                        <table id="tableDetailCart" style="width: 100%" class="display table table-striped table-hover">
                            <colgroup>
                                <col style="width: 25%">
                                <col style="width: 12%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Nombre del producto</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    {{--Fin Tabla en modal--}}
                    <div class="modal-footer no-bd">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        {{--FIN Modal Detalle de carrito Carrito --}}


        {{--Modal Carrito --}}
        <div class="modal fade" id="modalShopping" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg modal-center">
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h1 class="modal-title">
                            <span class="fw-mediumbold">
                                Productos seleccionados
                            </span>
                        </h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--Campos Individuales--}}

                    {{--Tabla en modal Productos a tranferir--}}
                    <div id="table" style="width: 100%" class="table-responsive">
                        <table id="tableCart" style="width: 100%" class="display table table-striped table-hover">
                            <colgroup>
                                <col style="width: 25%">
                                <col style="width: 12%">
                                <col style="width: 10%">
                                <col style="width: 8%">
                                <col style="width: 10%">
                                <col style="width: 15%">
                                <col style="width: 8%">
                                <col style="width: 8%">
                                <col style="width: 5%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Nombre del producto</th>
                                    <th>Codigo interno</th>
                                    <th>expiracion registro</th>
                                    <th>Tipo transaccion</th>
                                    <th>Costo unidad</th>
                                    <th>Cantidad disponible</th>
                                    <th>Cantidad Solicitada</th>
                                    <th>Total</th>
                                    <th style="visibility:hidden"></th>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin Modal Carrito --}}

        {{--Modal Detalle de oportunidad--}}
        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h3 class="modal-title">
                            <span class="clear fw-mediumbold">
                                Detalle del producto
                            </span>
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default" style="overflow: visible">
                                    <label>Nombre Producto</label>
                                    <textarea id="productName" rows="3" class="form-control textarea" spellcheck="false" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Codigo interno</label>
                                    <input id="internal" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Registro Sanitario</label>
                                    <input id="sanitary" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Estado del Registro</label>
                                    <input id="registration_status" name="registration_status" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Vencimiento del Registro</label>
                                    <input id="expiration_register" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Numero Registro - CUM</label>
                                    <input id="cum" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Estado Cum</label>
                                    <input id="cum_status" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Lote</label>
                                    <input id="batch" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Fecha de vencimiento</label>
                                    <input id="expiration" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Descripción</label>
                                    <input id="content_unit" type="text" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Cantidad disponible</label>
                                    <input id="setAvailable" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Precio por unidad</label>
                                    <input id="price" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Cantidad a solicitar</label>
                                    <input id="Quantity" class="form-control intLimitTextBox campos">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer no-bd">
                        <button type="button" id="transferModal" class="btn btn-warning">Solicitar transferencia</button>
                        <button type="input" id="AddShoppingTable" class="btn btn-success">Comprar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin Modal--}}

        {{--Modal Click Tranferencia --}}
        <div class="modal fade" id="modalTransfer" aria-hidden="true" aria-labelledby="modal-title" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg modal-center">
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h1 class="modal-title">
                            <span class="fw-mediumbold">
                                Selecciona los productos que deseas intercambiar
                            </span>
                        </h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--Campos Individuales--}}

                    {{--Tabla en modal Productos a tranferir--}}
                    <div id="table" style="width: 100%" class="table-responsive">
                        <table id="tableTransfer" style="width: 100%" class="display table table-striped table-hover">
                            <colgroup>
                                <col style="width: 25%">
                                <col style="width: 15%">
                                <col style="width: 8%">
                                <col style="width: 8%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                                <col style="width: 10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Nombre del producto</th>
                                    <th>Codigo Interno</th>
                                    <th>Fecha de vencimiento</th>
                                    <th>Codigo invima</th>
                                    <th>Lote</th>
                                    <th>Cantidad disponible</th>
                                    <th>Seleccionar</th>
                                    <th>Cantidad</th>
                                    <th hidden>id</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    {{--Fin Tabla en modal--}}
                    <div class="modal-footer no-bd">
                        <button type="button" id="btnTransaction" class="btn btn-success">Enviar Propuesta</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin Modal tranferencia --}}


        {{--Datos cargado por medio de CommecialController--}}
        <div class="container">
            <hr>
            <div class="row">
                @foreach($products as $product)
                @if($product->name == null || $product->name == " " )
                <div data-toggle="modal" data-target="#modalDetail" class="col-xl-3 col-md-6 mb-4 clear">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div style="text-align: center;" class="col-12">
                                        <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
                                        <hr style="width:10px">
                                    </div>
                                    <label>Cantidad diponible</label>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div data-portfolio="{!! $product->portfolio !!}" data-available="{!! $product->available !!}" data-batch="{!! $product->batch !!}" data-expiration="{!! $product->expiration_date !!}" data-toggle="modal" data-target="#modalDetail" class="col-xl-3 col-md-6 mb-4 clear">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div style="text-align: center;" class="col-12">
                                        <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
                                        <hr style="width:10px">
                                    </div>
                                    <div style="height:55px" class="text font-weight-bold text-primary  mb-1">{!! $product->name !!}</div>
                                    <hr>
                                    @if($product->internal != null)
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Codigo Interno : {!! $product->internal !!}</div>
                                    <hr>
                                    @else

                                    @endif
                                    <label>Costo Catalogo Propio</label>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${!! money_format('%n', round($product->internal_price, 0)) !!}</div>
                                    <label>Costo Publicado</label>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${!! money_format('%n', round($product->external_price, 0)) !!}</div>
                                    <hr>
                                    <label>Cantidad diponible</label>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{!! $product->available !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        {{--fin Tabla Carga datos--}}
    </div>
</div>
@endsection

@section('scripts')

{{--Agregar envio carrito  --}}
<script>
    $(function(event) {
        $('#btnSendCart').on("click", function() {
            $.ajax({
                type: "GET",
                url: 'checkout',
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                }),
                async: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    swal('Su transaccion ha procesada correctamente, por favor verifique su correo regularmente para recibir novedades', {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                    modalDataTableCart.ajax.url('Carrito').load();
                },
                failure: function(response) {

                },
                error: function(response) {

                },
                timeout: 1000
            });
        });
    });
</script>
{{--Fin--}}

{{--Agregar datos a modal detalle --}}
<script>
    $(function(event) {
        $('#modalDetail').on('show.bs.modal', function(e) {
            var portfolio = $(e.relatedTarget).data('portfolio');
            var available = $(e.relatedTarget).data('available');
            var batch = $(e.relatedTarget).data('batch');
            var expiration = $(e.relatedTarget).data('expiration');
            $('#AddShoppingTable').off().on("click", function() {
                sendBuy(portfolio, available);
            });
            $('#btnTransaction').off().on("click", function() {
                sendTranfer(portfolio, available);
            });
            $.ajax({
                type: "POST",
                url: 'autocompleteModaltransaction/' + portfolio,
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    'portfolio': portfolio
                }),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    $(e.currentTarget).find('textarea[id="productName"]').val(response.productName);
                    $(e.currentTarget).find('input[id="internal"]').val(response.internal);
                    $(e.currentTarget).find('input[id="sanitary"]').val(response.sanitary);
                    $(e.currentTarget).find('input[id="batch"]').val(batch);
                    $(e.currentTarget).find('input[id="expiration"]').val(expiration);
                    $(e.currentTarget).find('input[id="registration_status"]').val(response.registration_status);
                    $(e.currentTarget).find('input[id="expiration_register"]').val(response.expiration_register);
                    $(e.currentTarget).find('input[id="cum"]').val(response.record_number + "-" + response.cum);
                    $(e.currentTarget).find('input[id="cum_status"]').val(response.cum_status);
                    $(e.currentTarget).find('input[id="price"]').val(response.price);
                    $(e.currentTarget).find('input[id="content_unit"]').val(response.content_unit);
                    $(e.currentTarget).find('input[id="setAvailable"]').val(available);
                },
                failure: function(response) {

                },
                error: function(response) {

                },
                timeout: 1000
            });
            $.ajax({
                type: "GET",
                url: 'Carrito/' + portfolio,
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    'portfolio': portfolio
                }),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    $(e.currentTarget).find('input[id="Quantity"]').val(response.quantity);
                },
                failure: function(response) {

                },
                error: function(response) {

                },
                timeout: 1000
            });
            $(".intLimitTextBox").inputFilter(function(value) {
                return /^\d*$/.test(value) && (value === "" || (parseInt(value) > 0 && parseInt(value) < 10000000));
            });
        });
    });
</script>
{{--Fin--}}


{{-- Inicio Multiselector moda tabla productos para tranferir  verificar id --}}
<script>
    var modalDataTableTransfer;
    var customer = 0;
    $(document).ready(function() {
        modalDataTableTransfer = $('#tableTransfer').DataTable({
            "ajax": {
                type: "GET",
                url: 'UnidadesDisponibles',
                dataSrc: '',
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            },

            columns: [{
                    data: "name"
                },
                {
                    data: "internal_product_id"
                },
                {
                    data: "expiration_date"
                },
                {
                    data: "invima_code"
                },
                {
                    data: "batch"
                },
                {
                    data: "available"
                },
                {
                    data: "rownum"
                },
                {
                    data: "rownum"
                },
                {
                    data: "portfolio"
                },
            ],
            "columnDefs": [{
                    "targets": [6],
                    "render": function(data, type, row) {
                        return '<td style="text-aligne:center"><input type="checkbox" data-portfolio="' + row.portfolio + '" id="checkbox' + data + '" class="selected campos"></td>';
                    }
                },
                {
                    "targets": [7],
                    "render": function(data, type, row) {
                        return '<td><input id="quantity' + data + '" class="campos intLimitTextBox"></td>';
                    }
                },
                {
                    "targets": [8],
                    "render": function(data, type, row) {
                        return '<td hidden>' + data + '</td>';
                    }
                }
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );

                            column
                                .search(val ? '^' + val + '$' : '',
                                    true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
{{-- Fin --}}

{{-- Inicio Multiselector Agregar contenido a tabla de modal transferencia --}}
<script>
    //$(document).ready(function() {
    function DataRow(_portfolio, _quantity, _batch, _expiration_date) {
        this.portfolio = _portfolio;
        this.quantity = _quantity;
        this.batch = _batch;
        this.expiration_date = _expiration_date;
    }

    function sendTranfer(portfolioId, available) {
        var quantity = $("#Quantity").val();
        if (quantity == null || quantity == "") {
            swal('Selecciona la cantidad a Transferir', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }
            });
            return;
        };
        //Verificamos que la cantidad a transar o comprar no sea mayor a la que cuenta el cliente
        if (quantity > available) {
            swal('La cantidad a solicitar no puede superar la cantidad disponible, ', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }
            });
            return;
        };

        //Arreglo guardar datos de tranferencia 
        var data = $('#tableTransfer').DataTable().rows().data().toArray();

        var detail = new Array();
        var j = 0;
        var cont = 0;
        for (var i = 0; i < data.length; i++) {
            var rowId = data[i].rownum;
            var checkboxId = "#checkbox" + rowId;
            var checkbox = $(checkboxId)[0];
            var quantity = "#quantity" + rowId;
            var inputNumber = $(quantity)[0];
            var quantity_ = parseInt(inputNumber.value);
            var portfolio = data[i].portfolio;
            var batch = data[i].batch;
            var expiration_date = data[i].expiration_date;
            //Verificamos que la cantidad a transar como propuesta no sea superior a la que cuenta en su catalogo propio
            var availablePortfolio = data[i].available;
            if (checkbox.checked == true) {
                if (isNaN(quantity_)) {
                    swal('Indica la cantidad que quieres intercambiar del producto seleccionado', {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }

                    });
                    return;
                } else
                if (availablePortfolio < quantity_) {
                    swal('No puedes ofrecer mas unidades de las que tienes en tu catalogo', {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }

                    });
                    return;
                } else {
                    var row = new DataRow(portfolio, quantity_, batch, expiration_date);
                    detail[j] = row;
                    j++;
                }
            }
        }
        if (j == 0) {
            swal('Selecciona algún producto para transferir', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }
            });
            return;
        }
        var batch = $("#batch").val();
        var expiration_date = $("#expiration").val();
        var customer = $("#CustomerId").val();
        var productName = $("#productName").val();
        var internal = $("#internal").val();
        var sanitary = $("#sanitary").val();
        var registration_status = $("#registration_status").val();
        var expiration_register = $("#expiration_register").val();
        var cum = $("#cum").val();
        var cum_status = $("#cum_status").val();
        var content_unit = $("#content_unit").val();
        var price = $("#price").val();
        var quantity = $("#Quantity").val();
        var total = price * quantity;

        $.ajax({
            type: "POST",
            url: 'guardarProducto',
            data: JSON.stringify({
                "_token": "{{ csrf_token() }}",
                "porfolio": portfolioId,
                "productName": productName,
                "internal": internal,
                "expirationRegister": expiration_register,
                "available": available,
                "price": price,
                "quantity": quantity,
                "batch": batch,
                "expiration_date": expiration_date,
                "total": total,
                "portfolioId": portfolioId,
                "detail": detail,
                "transactionClass": 0
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                validationError = false;
                swal(response.message + response.cantidad, {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    }
                });
                //minimisamos la modal despues de que enviamos la información
                $('#modalTransfer').modal('hide');
                $('#modalDetail').modal('hide');
            },
            failure: function(response) {
                alert(response);
            },
            timeout: 1000,
            async: false
        });
    }
</script>
{{-- Fin --}}

{{-- Inicio Multiselector y Agregar Contenido de modal a tabla Compra--}}
<script>
    function sendBuy(portfolioId, available) {
        var quantity = $("#Quantity").val();
        //Verificamos que el campo quantity a comprar o transar contenga un valor 
        if (quantity == null || quantity == "") {
            swal('Selecciona la cantidad a comprar', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }

            });
            return;
        };

        //Verificamos que la cantidad a transar o comprar no sea mayor a la que cuenta el cliente
        if (quantity > available) {
            swal('Tu compra no puede superar la cantidad disponible, ', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }

            });
            return;
        };
        var detail = 0;
        var customer = $("#CustomerId").val();
        var productName = $("#productName").val();
        var internal = $("#internal").val();
        var sanitary = $("#sanitary").val();
        var registration_status = $("#registration_status").val();
        var expiration_register = $("#expiration_register").val();
        var cum = $("#cum").val();
        var batch = $("#batch").val();
        var expiration_date = $("#expiration").val();
        var cum_status = $("#cum_status").val();
        var content_unit = $("#content_unit").val();
        var price = $("#price").val();
        var quantity = $("#Quantity").val();
        var total = price * quantity;

        $.ajax({
            type: "POST",
            url: 'guardarProducto',
            data: JSON.stringify({
                "_token": "{{ csrf_token() }}",
                "porfolio": portfolioId,
                "productName": productName,
                "internal": internal,
                "expirationRegister": expiration_register,
                "available": available,
                "price": price,
                "quantity": quantity,
                "batch": batch,
                "expiration_date": expiration_date,
                "total": total,
                "portfolioId": portfolioId,
                "detail": detail,
                "transactionClass": 1
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                validationError = false;
                swal(response.message + response.cantidad, {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    }
                });
                $('#modalDetail').modal('hide');
            },
            failure: function(response) {
                alert(response);
            },
            timeout: 1000,
            async: false
        });
    }
</script>
{{-- Fin --}}

{{-- Accion Verificar cantidad para abrir modal transferencias --}}
<script>
    $(document).ready(function() {
        $('#transferModal').click(function() {
            var quantity = $("#Quantity").val();
            var available = $("#setAvailable").val();

            if (quantity == "") {
                swal('Selecciona la cantidad a transferir', {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    }
                });
                return;
            }
            //Verificamos que la cantidad a transferir
            if (quantity > available) {
                swal('Tu compra no puede superar la cantidad disponible, ', {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    }
                });
            } else {
                $("#modalTransfer").modal('show');

            }
        });
    });
</script>
{{-- Fin --}}

{{--Limpiar Campos --}}
<script>
    $(document).ready(function() {
        $('.clear').click(function() {
            $('.campos').val('');
        });
    });
</script>
{{--Fin Limpiar Campo--}}

{{-- Borrar carrito  --}}
<script>
    $(function(event) {
        $('#btnClearCart').on("click", function() {
            $.ajax({
                type: "POST",
                url: 'BorrarCarrito',
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                }),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    swal('Se ha vaciado su carrito', {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                },
                failure: function(response) {
                    swal('failure', {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                },
                error: function(response) {
                    swal('error', {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                },
                timeout: 1000
            });
            modalDataTableCart.ajax.url('Carrito').load();
        });
    });
</script>
{{--Fin--}}

{{--Modal Detalle transaccion en carrito --}}
<script>
    var modalDataTableDetailCart;
    var portfolio = 0;

    // $(document).ready(function() {
    $('#DetalleCarrito').off().on("click", function(e) {
        var porfolio = $(e.relatedTarget).data('porfolio');
        modalDataTableDetailCart = $('#tableDetailCart').DataTable({
            "ajax": {
                type: "GET",
                url: 'DetailExchange/' + portfolio,
                dataSrc: '',
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            },
            columns: [{
                    data: "productName"
                },
                {
                    data: "quantity"
                }
            ],
            "columnDefs": [{
                "targets": [0],
                "render": function(data, type, row) {
                    return '<td><textarea class="textarea">' + data + '</textarea></td>';
                }
            }],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );

                            column
                                .search(val ? '^' + val + '$' : '',
                                    true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d + '</option>')
                    });
                });
            }
        });
        // });
    });
</script>
{{--Fin--}}

{{-- Inicio Tabla Cookie Carrito de compras --}}
<script>
    var modalDataTableCart;
    var customer = 0;
    $(document).ready(function() {
        modalDataTableCart = $('#tableCart').DataTable({
            "ajax": {
                type: "GET",
                url: 'Carrito',
                dataSrc: '',
                async: true,
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            },
            columns: [{
                    data: "productName"
                },
                {
                    data: "internal"
                },
                {
                    data: "expiration"
                },
                {
                    data: "transactionClass"
                },
                {
                    data: "price"
                },
                {
                    data: "available"
                },
                {
                    data: "quantity"
                },
                {
                    data: "total"
                },
                {
                    data: "portfolioId"
                },
            ],
            "columnDefs": [{
                    "targets": [0],
                    "render": function(data, type, row) {
                        return '<td><textarea class="textarea">' + data + '</textarea></td>';
                    }
                }, {
                    "targets": [3],
                    "render": function(data, type, row) {
                        if (data == 1) {
                            return '<td><label>Compra</label></td>';
                        } else
                            return '<td><label>Transferencia</label></td>';
                    }
                },
                {
                    "targets": [4],
                    "render": function(data, type, row) {
                        return '<td><label>$' + data + '</label></td>';
                    }
                },
                {
                    "targets": [6],
                    "render": function(data, type, row) {
                        return '<label style="font-size:10px">' + data + '</label>';
                    }
                },
                {
                    "targets": [7],
                    "render": function(data, type, row) {
                        return '<td><label>$' + data + '</label></td>';
                    }
                },
                {
                    "targets": [8],
                    "render": function(data, type, row) {
                        return '<td> <div class="form-button-action"><button id="EliminarCampo" style="padding:0" type="button" on data-toggle="tooltip" title="Eliminar" class="btn btn-link btn-danger"><i class="fas fa-cart-arrow-down"></i></button><button id="DetailCart"   data-porfolio=" ' + data + '" data-target="#modalDetailTransac" data-toggle="modal"  style="padding:0; margin-left: 15px" type="button" on data-toggle="tooltip" title="Detalle Transacción" class="btn btn-link btn-primary"><i class="fa fa-info"></i></button></div></td>';
                    }
                }
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );

                            column
                                .search(val ? '^' + val + '$' : '',
                                    true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d + '</option>')
                    });
                });
            }
        });
        $('#modalShopping').on('show.bs.modal', function(e) {
            modalDataTableCart.ajax.url('Carrito').load();
        });

        $('#DetailCart').off().on('show.bs.modal', function(e) {
            var porfolio = $(e.relatedTarget).data('porfolio');

            modalDataTableDetailCart = $('#tableDetailCart').DataTable({
                "ajax": {
                    type: "GET",
                    url: 'DetailExchange/' + portfolio,
                    dataSrc: '',
                    data: {},
                    contentType: "application/json; charset=utf-8",
                    dataType: "json"
                },
                columns: [{
                        data: "productName"
                    },
                    {
                        data: "quantity"
                    }
                ],
                "columnDefs": [{
                    "targets": [0],
                    "render": function(data, type, row) {
                        return '<td><textarea class="textarea">' + data + '</textarea></td>';
                    }
                }],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util
                                    .escapeRegex(
                                        $(this).val()
                                    );

                                column
                                    .search(val ? '^' + val + '$' : '',
                                        true, false)
                                    .draw();
                            });
                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d +
                                '">' + d + '</option>')
                        });
                    });
                }
            });
            //$("#modalDetailTransac").modal('show');
        });
    });
</script>
{{-- Fin --}}

{{-- Valores minimos y maximos en inputs--}}
<script>
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
        }
    }(jQuery));
    $(".intLimitTextBox").inputFilter(function(value) {
        return /^\d*$/.test(value) && (value === "" || (parseInt(value) > 0 && parseInt(value) < 10000000));
    });
</script>
{{--Fin Valores minimos --}}
@endsection
