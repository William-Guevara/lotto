@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Products</h2>
        <p data-aos="fade-up">This section allows you to view product information</p>
    </div>
    <div class="container">
        <button data-option="create" data-tooltip="tooltip" title="Add user" data-toggle="modal"
            data-target="#modalAdminProduct" class="btn-info clear">
            <i class="bx bxs-add-to-queue"></i>
        </button>
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{!! $product->product_id !!}</td>
                    <td>{!! $product->name_en !!}</td>
                    <td>{!! $product->price !!}</td>
                    <td>
                        <div class="row">
                            <button data-product="{!! $product->product_id !!}" data-option="update"
                                data-tooltip="tooltip" title="Edit product" data-toggle="modal"
                                data-target="#modalAdminProduct" class="btn-primary clear">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button data-product="{!! $product->product_id !!}" class="btn-danger btn_delete">
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
<div class="modal fade" id="modalAdminProduct" aria-hidden="true" aria-labelledby="modal-title" role="dialog"
    tabindex="-2">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <section id="editser">
                <div class="container">
                    <div class="section-title">
                        <h2 id="tittle_modal" data-aos="fade-up"></h2>
                        <input type="hidden" class="campos" id="option_select">
                        <input type="hidden" class="campos" id="product_id">
                        <input type="hidden" class="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-xl-9 col-lg-12 mt-4">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label>Name en</label>
                                    <input type="text" class="form-control campos" id="name_en" placeholder="Name en" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Description en</label>
                                    <input type="text" class="form-control campos" id="description_en"
                                        placeholder="description_en" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Name es</label>
                                    <input type="text" class="form-control campos" id="name_es" placeholder="name_es" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Description es</label>
                                    <input type="text" class="form-control campos" id="description_es"
                                        placeholder="description_es" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Duration months</label>
                                    <input type="number" min="0" class="form-control campos" id="duration_months"
                                        placeholder="duration_months" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Total Games</label>
                                    <input type="number" min="0" class="form-control campos" id="total_games"
                                        placeholder="total_games" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control campos" id="category"
                                        placeholder="category" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Price</label>
                                    <input type="number" nim="0" step="0.01" class="form-control campos" id="price"
                                        placeholder="price" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Display</label>
                                    <select class="form-control campos" id="display">
                                        <option value="1">Display on store</option>
                                        <option value="0">Hide on store</option>
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
            </section>

        </div>
    </div>
</div>
{{--Fin Modal Admin Create Update --}}

@endsection

@section('scripts')
<script src="{{ asset('js/js_blade/product.js') }}"></script>
<script src="{{ asset('js/js_blade/tables.js') }}"></script>

<script>
//Agregado aqui para el control del formulario de registro y que es el mismo que el de actualizar
function getControl() {
    var url = "{{ route('products_control') }}";
    return url;
}
</script>


@endsection