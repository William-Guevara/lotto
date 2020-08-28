@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Purchases</h2>
        <p data-aos="fade-up">This section allows you to view and search through user purchases</p>
    </div>
    <div class="container">
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Reponse</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Amount</th>
                    <th>completion timestamp</th>
                    <th>Accioes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchas)
                <tr>
                    <td>{!! $purchas->order_id !!}</td>
                    <td>{!! $purchas->response_code !!}</td>
                    <td>{!! $purchas->first_name !!}</td>
                    <td>{!! $purchas->last_name !!}</td>
                    <td>${!! $purchas->amount !!}</td>
                    <td>{!! $purchas->completion_timestamp !!}</td>
                    <td>
                         <button data-order_id="1" data-tooltip="tooltip" title="Purchases detail" data-toggle="modal"
                            data-target="#purchasesDetail" class="btn-primary clear">
                            <i class="bx bx-search"></i>
                        </button>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</section>

{{--Fin Modal Admin Create Update --}}
<div class="modal fade" id="purchasesDetail" aria-hidden="true" aria-labelledby="modal-title" role="dialog"
    tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="detail">
                <div class="container">
                    <div class="section-title">
                        <h2 id="tittle_modal" data-aos="fade-up">Detail Puechases</h2>
                        <input type="hidden" class="campos" id="option_select">
                        <input type="hidden" class="campos" id="product_id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Order ID</label>
                                    <input type="text" class="form-control campos" placeholder="order_id"
                                        id="order_id" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control campos" placeholder="date" id="date" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Response Code</label>
                                    <input type="text" class="form-control campos" placeholder="response_code"
                                        id="response_code" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Auth Code</label>
                                    <input type="text" class="form-control campos" placeholder="description_es"
                                        id="description_es" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>AVS Code</label>
                                    <input type="text" min="0" class="form-control campos" placeholder="avs_code"
                                        id="avs_code" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Transaction ID</label>
                                    <input type="text" min="0" class="form-control campos" placeholder="transaction_id"
                                        id="transaction_id" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Invoice Number</label>
                                    <input type="text" class="form-control campos" placeholder="invoice_number"
                                        id="invoice_number" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Description</label>
                                    <input type="text" nim="0" step="0.01" class="form-control campos"
                                        placeholder="description" id="description" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Amount</label>
                                    <input type="text" nim="0" step="0.01" class="form-control campos"
                                        placeholder="amount" id="amount" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Method</label>
                                    <input type="text" nim="0" step="0.01" class="form-control campos"
                                        placeholder="method" id="method" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Type</label>
                                    <input type="text" nim="0" step="0.01" class="form-control campos"
                                        placeholder="type" id="type" />
                                </div>
                                
                            </div>
                            <div id="url_user">
                            </div>
                        </div>                        
                    </div>
                    <section id="products">
                        <div class="container">
                            <div class="section-title">
                                <h2 data-aos="fade-up">Products in Order</h2>
                                <input type="hidden" class="campos" id="order_id">
                                <input type="hidden" class="_token" value="{{ csrf_token() }}">
                            </div>
                            <div id="table" style="width: 100%" class="table-responsive">

                                <table id="table_products" style="width: 100%"
                                    class="display table table-striped table-hover">
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
                    <div class="text-center">
                        <button class="btn btn-danger" data-dismiss="modal" type="button">Closed</button>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
{{--Fin Modal Admin Create Update --}}

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/purchases.js') }}"></script>
<script>
function getModalProducts(id) {
    var url = "{{ route('DetailProducts', ':id') }}";
    url = url.replace(':id', id)
    return url;
}
</script>
@endsection