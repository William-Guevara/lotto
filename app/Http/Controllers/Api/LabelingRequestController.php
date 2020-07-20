<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Application_User;
use App\Models\Drug;
use App\Models\Facility;
use App\Models\Labeling_Request_Summary;
use App\Models\Labeling_Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
//uso para cargar la libreria del controlador por ser una carpeta diferencte a las establecidas por laravel
use App\Http\Controllers\Controller as Controller;
use App\Models\Pharmaceutical_Unit;
use App\Models\Pharmaceutical_Unit_Location;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LabelingRequestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /*
    | LISTAR ORDENES DE ETIQUETADO 
    |--------------------------------------------------------------------------
    |Se cargaran las ordenes de etiquetado que cuenten con productos sin etiquetar
    |
    */
    public function labelingRequestList(Request $request)
    {
        //tomamos el rol  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $facility = $user->facility;
        $process = $request->input('process');
        switch ($process) {
            case 0:
                //Carga Ordenes de etiquetado pendientes para el usuario y que aun tienen productos para etiquetar
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('facility', 'facility.id', '=', 'labeling_request.facility')
                    ->join('application_user', 'application_user.id', '=', 'labeling_request.creator')
                    ->select('labeling_request.id', 'labeling_request.order_status', 'facility.name as facility', 'application_user.name as creator', 'labeling_request.created', 'application_user.name as executor',  'labeling_request.started', 'labeling_request.finished', DB::raw('count(*) as quantity'))
                    ->where('pharmaceutical_unit.tag', '=', null)
                    ->where('labeling_request.executor', '=', $user->id)
                    ->where('labeling_request.order_status', '=', 0)
                    ->groupBy('labeling_request.id', 'labeling_request.order_status', 'facility', 'creator', 'labeling_request.created', 'executor',  'labeling_request.started', 'labeling_request.finished')
                    ->having('quantity', '>', 0)
                    ->orderBy('labeling_request.created', 'desc')
                    ->get();

                return response()->json($sql);
                break;

                //Ordenes de etiquetado terminadas
            case 1:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    //->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('facility', 'facility.id', '=', 'labeling_request.facility')
                    ->join('application_user AS creator', 'creator.id', '=', 'labeling_request.creator')
                    ->join('application_user AS executor', 'executor.id', '=', 'labeling_request.creator')
                    ->join('role_permission', 'role_permission.id', '=', 'application_user.role')
                    ->join('customer', 'customer.id', '=', 'role_permission.customer')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select('labeling_request.id', 'labeling_request.order_status', 'facility.name as facility', 'creator.name as creator', 'labeling_request.created', 'executor.name as executor',  'labeling_request.started', 'labeling_request.finished')
                    ->where('pharmaceutical_unit.tag', '=', null)
                    ->where('labeling_request.order_status', '=', 2)
                    //->where('pharmaceutical_unit.tag', '=', null)
                    ->groupBy('labeling_request.id')
                    ->orderBy('labeling_request.created', 'desc')
                    ->get();

                return response()->json($sql);
                break;

                //Ordenes de etiquetado existentes
            case 2:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    //->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('facility', 'facility.id', '=', 'labeling_request.facility')
                    ->join('application_user AS creator', 'creator.id', '=', 'labeling_request.creator')
                    ->join('application_user AS executor', 'executor.id', '=', 'labeling_request.creator')
                    ->join('role_permission', 'role_permission.id', '=', 'application_user.role')
                    ->join('customer', 'customer.id', '=', 'role_permission.customer')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select('labeling_request.id', 'labeling_request.order_status', 'facility.name as facility', 'creator.name as creator', 'labeling_request.created', 'executor.name as executor',  'labeling_request.started', 'labeling_request.finished')
                    ->groupBy('labeling_request.id')
                    ->orderBy('labeling_request.id', 'desc')
                    ->get();

                return response()->json($sql);
                break;
        }
    }
    /*
    | LISTAR PRODUCTOS DE LA ORDEN DE ETIQUETADO SELECCIONADA
    |--------------------------------------------------------------------------
    |Se mostraran los productos de una orden de etiquetado especifica con su cantidad
    | para seleccionar e iniciar a etiquetar
    */
    public function labelingRequestProductCount(Request $request, $labeling_request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;
        $customer = $user->permission->customer;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $process =  $request->input('process');

        switch ($process) {

                //Orden de etiquetado con productos pendientes por etiquetar
            case 0:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->select(DB::raw('pharmaceutical_unit.product, customer_portfolio.internal_product_id, product.name,sanitary_registration.invima_code, product.cum_sequence, pharmaceutical_unit.batch,pharmaceutical_unit.expiration_date,  count(*) as product_count'))
                    //->where('pharmaceutical_unit.tag', '=', null)
                    ->where('pharmaceutical_unit.labeling_request', '=', $labeling_request)
                    ->where('pharmaceutical_unit.tag', '=', null)
                    ->where('customer_portfolio.customer', '=', $customer)
                    ->groupBy('pharmaceutical_unit.product', 'customer_portfolio.internal_product_id', 'product.name', 'sanitary_registration.invima_code', 'product.cum_sequence', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->get();

                return response()->json($sql);
                break;

                //Ordenes de etiquetado con la cantidad de productos etiquetados en ella 
            case 1:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->leftjoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select(DB::raw('pharmaceutical_unit.product, product.name,sanitary_registration.invima_code, product.cum_sequence, pharmaceutical_unit.batch,pharmaceutical_unit.expiration_date,  count(*) as product_count'))
                    //->where('pharmaceutical_unit.tag', '=', null)
                    ->where('pharmaceutical_unit.tag', '!=', null)
                    ->where('pharmaceutical_unit.labeling_request', '=', $labeling_request)
                    ->groupBy('pharmaceutical_unit.product', 'customer_portfolio.internal_product_id', 'product.name', 'sanitary_registration.invima_code', 'product.cum_sequence', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->get();
                return response()->json($sql);
                break;

                //Ordenes de etiquetado con la cantidad total de productos (Etiquetados + faltantes por etiquetar)
            case 2:
                //orden de etiquetado especifica    
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->leftjoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select(DB::raw('pharmaceutical_unit.product,customer_portfolio.internal_product_id, product.name,sanitary_registration.invima_code, product.cum_sequence, pharmaceutical_unit.batch,pharmaceutical_unit.expiration_date,  count(*) as product_count'))
                    //->where('pharmaceutical_unit.tag', '=', null)
                    ->where('pharmaceutical_unit.tag', '=', null)
                    ->where('pharmaceutical_unit.labeling_request', '=', $labeling_request)
                    ->groupBy('pharmaceutical_unit.product', 'customer_portfolio.internal_product_id', 'product.name', 'sanitary_registration.invima_code', 'product.cum_sequence', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->get();
                return response()->json($sql);
                break;
        }
    }
    /*
    | LISTAR PRODUCTO SELECCIONADO
    |--------------------------------------------------------------------------
    |En este caso se mostrara el listado con la cantidad de productos de la misma referencia
    |dependiendo de la cantidad de producto a escanear.
    |Switch creado con el fin de auditar mas adelante los datos indicados de las ordenes 
    |de etiquetado comprobando su historial(1 = productos etiquetados,0 = pendientes por etiquetar, 2 = todos )
    */
    //Muestra el listado de los productos 
    public function labelingRequestProductList(Request $request, $labeling_request, $pharmaceutical_unit)
    {


        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $process =  $request->input('process');

        switch ($process) {

                //mostrar los pharmaceutical unit pendientes por etiquetar
            case 0:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select('pharmaceutical_unit.id as pharmaceutical_unit', 'product.name', 'sanitary_registration.invima_code', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->where('pharmaceutical_unit.tag', '=', null)
                    ->where('pharmaceutical_unit.product', '=', $pharmaceutical_unit)
                    ->where('labeling_request.id', '=', $labeling_request)
                    ->get();
                return response()->json($sql);
                break;

                //mostrar los pharmaceutical unit etiquetados
            case 1:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->leftJoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
                    ->select('pharmaceutical_unit.id as pharmaceutical_unit', 'product.name', 'sanitary_registration.invima_code', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->where('pharmaceutical_unit.tag', '!=', null)
                    ->where('pharmaceutical_unit.product', '=', $pharmaceutical_unit)
                    ->where('labeling_request.id', '=', $labeling_request)
                    ->get();
                return response()->json($sql);
                break;

                //mostrar todos los pharmaceutical unit 
            case 2:
                $sql = DB::table('labeling_request')
                    ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                    ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
                    ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
                    ->select('pharmaceutical_unit.id as pharmaceutical_unit', 'product.name', 'sanitary_registration.invima_code', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date')
                    ->where('pharmaceutical_unit.product', '=', $pharmaceutical_unit)
                    ->where('labeling_request.id', '=', $labeling_request)
                    ->get();
                return response()->json($sql);
                break;
        }
    }

    /*
    | AGREGAR RELACION PRODUCTOS, TAG Y STORE
    |--------------------------------------------------------------------------
    |Verificamos los datos recibidos para rellenar la tabla pharmaceutical_unit_location 
    |en la cual se asigna la relacion de producto y tag con su respectiva ubicación 
    */
    public function RequestProductTag(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;
        $facility = $user->facility;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        //Cargamos los datos recibidos en la variable 
        $tagList = $request->input("unitTagList");

        $date = new \DateTime(); //hora estandarizada
        $date->modify('-5 hours');
        $date = $date->format("Y-m-d H:i:s");

        foreach ($tagList as $tag) {

            //procesamos los datos y repartimos los campos 
            $pu = $tag["pharmaceutical_unit"];
            $epc = $tag["epc_code"];

            //Buscamos la orden de etiquetado al cual pertenecen las unidades farmaceuticas
            $sql = DB::table('labeling_request')
                ->join('pharmaceutical_unit', 'pharmaceutical_unit.labeling_request', '=', 'labeling_request.id')
                ->select('labeling_request.id')
                ->where('pharmaceutical_unit.id', '=', $pu)
                ->get();

            $idTag = DB::table('tag')
                ->select('id')
                ->where('epc_code', '=', $epc)
                ->get();

            $pharma = Pharmaceutical_Unit::find($pu);
            $pharma->tag = $idTag[0]->id;
            $pharma->unit_status = 0;
            $pharma->save();

            //Cargamos la fecha de inicio de la orden de etiquetado
            $labeling_request =  Labeling_Request::find($sql[0]->id);
            if ($labeling_request->started == null) {
                $labeling_request->started = $date;
                $labeling_request->order_status = 1;
                $labeling_request->save();
            }

            //Validamos si en la orden de etiquetado quedan mas pharmaceutical_unit por scanear 
            $productCount = DB::table('pharmaceutical_unit')
                ->select(DB::raw('count(*) as cantidad'))
                ->where('pharmaceutical_unit.labeling_request', $sql[0]->id)
                ->where('pharmaceutical_unit.tag', null)
                ->get();

            if ($productCount[0]->cantidad == 0) {
                $labeling_request =  Labeling_Request::find($sql[0]->id);
                $labeling_request->finished = $date;
                $labeling_request->order_status = 2;
                $labeling_request->save();
            }
        }
        return response()->json(['code' => 200, 'message' => 'Los tag han sido asociados correctamente']);
    }

    /*
    | CERRAR ORDEN DE ETIQUETADO ESPESIFICA
    |--------------------------------------------------------------------------
    |Se dara por terminada la orden en cualquier momento, agregando su fecha fin y 
    |cmbiando su estado de (Pendiente o En Curso)  a Ejecutada
    */
    public function CloseOrder(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;
        $facility = $user->facility;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $id = $request->input('labeling_request');
        $comment = $request->input('comment');

        $date = new \DateTime();
        $date->modify('-5 hours');
        $date = $date->format("Y-m-d H:i:s");

        //Cerrar orden de etiquetado en cualquier momento 
        $labeling_request =  Labeling_Request::find($id);
        $labeling_request->finished = $date;
        $labeling_request->order_status = 3;
        $labeling_request->comment = $comment;
        $labeling_request->save();
    }
}
