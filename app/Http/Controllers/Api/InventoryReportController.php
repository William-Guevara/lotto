<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Application_User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
//uso para cargar la libreria del controlador por ser una carpeta diferencte a las establecidas por laravel
use App\Http\Controllers\Controller as Controller;
use App\Models\Inventory_Report;
use App\Models\Inventory_Report_Unit;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;


class InventoryReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /* 
    | BUSCAR AREAS DE PROCESOS(PROCESS_AREA)
    |--------------------------------------------------------------------------
    */
    public function SearchArea(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $facility = $user->facility;

        //Seleccionamos los datos a enviar que corresponden al usuario indicado
        $process = DB::table('facility')
            ->leftjoin('process_area', 'process_area.facility', '=', 'facility.id')
            ->leftjoin('store', 'store.process_area', '=', 'process_area.id')
            ->select('process_area.name', 'process_area.id as process_area')
            ->where('facility.id', $facility)
            ->where('facility.is_active', 0)
            ->groupBy('process_area.name', 'process_area.id')
            ->get();

        return response()->json($process);
    }
    /*
    | BUSCAR CONTENEDORES (STORE)
    |--------------------------------------------------------------------------
    */
    public function SearchAreaContent($process_area, Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        //Validacion de los store asignados a el area de proceso indicado
        $store = DB::table('store')
            ->select('store.name', 'store.id as store')
            ->where('process_area', '=', $process_area)
            ->where('is_active', 0)
            ->get();

        return response()->json($store);
    }
    /*
    | VALIDACION DE REPORTE
    |--------------------------------------------------------------------------
    */
    public function InventoryReportValidate(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        //se recibira epc por epc y se enviara la informacion del producto uno por uno.
        $epc = $request->input('epc_code');

        $exist = DB::table('pharmaceutical_unit')
            ->leftjoin('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->where('epc_code', '=', $epc)
            ->exists();

        if ($exist == false) {
            return response()->json(['Tag no asociado a ningun producto' => $epc]);
        }

        $sql = DB::table('tag')
            ->leftjoin('pharmaceutical_unit', 'pharmaceutical_unit.tag', '=', 'tag.id')
            ->leftjoin('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->leftJoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
            ->select('product.name', 'customer_portfolio.internal_product_id')
            ->where('epc_code', '=', $epc)
            ->where('unit_status', '=', 0)
            ->where('tag_status', '=', 1)
            ->groupBy('product.name', 'customer_portfolio.internal_product_id')
            ->first();

        return response()->json($sql);
    }

    /*
    | REPORTE DE INVENTARIO INICIAL
    |--------------------------------------------------------------------------
    |
    */
    public function InventoryReportOne(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        //Recibimos los datos
        $epc = $request->input("inventoryEpc");
        $store = $request->input("store");
        $started = $request->input("start");
        $finished = $request->input("finish");

        //buscamos el process_area al cual esta asociado el store indicado para agregar a inventory_report_unit
        $process_area = DB::table('store')->select('process_area')->where('id', $store)->first();

        $date = new \DateTime();
        $date->modify('-5 hours');
        $date = $date->format("Y-m-d H:i:s");

        //Creamos un reporte de inventario 
        $report = new Inventory_Report;
        $report->report_status = 2;
        $report->creator = $user->id;
        $report->process_area = $process_area->process_area;
        $report->created  = $date;
        $report->started  = $started;
        $report->report_type = 0; //"0": para reporte inicial Reporte inicial 
        $report->finished  = $finished;
        $report->save();


        //buscamos los datos de las unidades farmaceuticas y tags con los epc_code recibidos
        $puList = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('tag.id as tag', 'pharmaceutical_unit.id', 'pharmaceutical_unit.unit_status')
            ->whereIn('tag.epc_code', $epc)
            ->whereNull('pharmaceutical_unit.store')
            ->get();

        $puSet = [];
        $unitSet = [];
        foreach ($puList as $pu) {
            $unit = new Inventory_Report_Unit;
            $unit->inventory_report = $report->id;
            $unit->pharmaceutical_unit = $pu->id;
            $unit->unit_status = $pu->unit_status;
            $unit->process_area = $process_area->process_area;
            $unit->search_result = 1;
            $unitSet[] = $unit->attributesToArray();
            $puSet[] = $pu->id;
        }
        Inventory_Report_Unit::insert($unitSet);

        $puData = json_decode(json_encode($puSet), true);

        // Actualizamos el resultado del inventario para los tags encontrados que tengan una unidad farmacéutica asociada (por la construcción de la consulta, aquí no genera efectos sobre los excedentes ni los que no están registrados)
        DB::table('pharmaceutical_unit')
            ->whereIn('id', $puData)
            ->update(['process_area' => $process_area->process_area, 'store' => $store]);

        //verificamos que la informacion haya sido agregada a la DB y devolvemos la consulta
        $sql = DB::table('tag')
            ->join('pharmaceutical_unit', 'pharmaceutical_unit.tag', '=', 'tag.id')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->leftjoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
            ->join('store', 'store.id', '=', 'pharmaceutical_unit.store')
            ->select('customer_portfolio.internal_product_id', 'product.name as product', 'tag.epc_code', 'store.name as store')
            ->whereIn('pharmaceutical_unit.id', $puData)
            ->get();

        return response()->json($sql);
    }

    /*
    | REPORTE DE INVENTARIO PERIODICO
    |--------------------------------------------------------------------------
    |
    */
    public function InventoryReportRegular(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $process_area = $request->input("process_area");
        $epc = $request->input("inventoryEpc");
        $started = $request->input("start");
        $finished = $request->input("finish");

        $date = new \DateTime();
        $date->modify('-5 hours');
        $date = $date->format("Y-m-d H:i:s");

        //Creamos un reporte de inventario 
        $report = new Inventory_Report;
        $report->report_status = 0;
        $report->creator = $user->id;
        $report->process_area = $process_area;
        $report->created  = $date;
        $report->started  = $started;
        $report->report_type = 1; //"1": para reporte Reporte Periodico
        $report->finished  = $finished;
        $report->save();

        //Buscamos todas pharmaceutical_unit etiquetados dentro del process_area seleccionado incluyendo inactivos (requerimiento de usuario)
        $puList =  DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id', 'unit_status', 'tag.epc_code', 'tag.tag_status')
            ->where('process_area', '=', $process_area)
            ->get();

        // Insertamos dentro de la tabla inventory_report_unit todas las unidades farmacéuticas del área de proceso
        $unitSet = [];
        $found = [];
        foreach ($puList as $pu) {
            $unit = new Inventory_Report_Unit;
            $unit->inventory_report = $report->id;
            $unit->pharmaceutical_unit = $pu->id;
            $unit->unit_status = $pu->unit_status;
            $unit->process_area = $process_area;
            $unit->search_result = 0;
            $unitSet[] = $unit->attributesToArray();
            $found[] = $pu->epc_code;
        }
        Inventory_Report_Unit::insert($unitSet);

        // Buscamos las unidades farmacéuticas asociadas a los tags encontrados durante el proceso de inventario
        $puSet = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id')
            ->whereIn('tag.epc_code', $epc)
            ->where('pharmaceutical_unit.process_area', '=', $process_area)
            ->get();

        $puData = json_decode(json_encode($puSet), true);

        // Actualizamos el resultado del inventario para los tags encontrados que tengan una unidad farmacéutica asociada (por la construcción de la consulta, aquí no genera efectos sobre los excedentes ni los que no están registrados)
        DB::table('inventory_report_unit')
            ->where('inventory_report', '=', $report->id)
            ->whereIn('pharmaceutical_unit', $puData)
            ->update(['search_result' => 1]);

        // Actualizamos la ubicación más reciente de la unidad farmacéutica
        DB::table('pharmaceutical_unit')
            ->whereIn('id', $puData)
            ->update(['process_area' => $process_area]);

        // Productos faltantes = Información de productos activos que no se encontraron durante el proceso de inventario
        $missing = DB::table('inventory_report_unit')
            ->join('pharmaceutical_unit', 'inventory_report_unit.pharmaceutical_unit', '=', 'pharmaceutical_unit.id')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->leftjoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
            ->select('customer_portfolio.internal_product_id', 'product.name', 'pharmaceutical_unit.id')
            ->where('customer_portfolio.customer', $user->permission->customer)
            ->where('inventory_report_unit.inventory_report', $report->id)
            ->where('inventory_report_unit.unit_status', 0)
            ->where('inventory_report_unit.search_result', 0)
            ->get();

        // Productos excedentes = Productos encontrados pero que no pertenecen al área de proceso
        // Buscamos todas pharmaceutical_unit etiquetados con los tags encontrados, pero que no pertenezcan al área de proceso
        $surplusesList =  DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('process_area', 'process_area.id', '=', 'pharmaceutical_unit.process_area')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->leftjoin('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
            ->select('pharmaceutical_unit.id', 'pharmaceutical_unit.unit_status', 'process_area.id as process_area_id', 'product.name', 'customer_portfolio.internal_product_id', 'process_area.name as process_area_name')
            ->where('customer_portfolio.customer', $user->permission->customer)
            ->where('process_area', '<>', $process_area)
            ->whereIn('tag.epc_code', $epc)
            ->get();

        // Actualizamos el resultado del inventario para los tags encontrados que tengan una unidad farmacéutica asociada y que no estén en el process area seleccionado
        $unitSet = [];
        $surpluses = [];
        foreach ($surplusesList as $pu) {
            $surplus = ['name' => $pu->name, 'internal_product_id' => $pu->internal_product_id, 'process_area' => $pu->process_area_name];
            $unit = new Inventory_Report_Unit;
            $unit->inventory_report = $report->id;
            $unit->pharmaceutical_unit = $pu->id;
            $unit->unit_status = $pu->unit_status;
            $unit->process_area = $pu->process_area_id;
            $unit->search_result = 1;
            $unitSet[] = $unit->attributesToArray();
            $surpluses[] = $surplus;
        }
        Inventory_Report_Unit::insert($unitSet);

        //Verificamos la cantidad encontrada por area de proceso indicada y que se encuentre activa 
        $total = DB::table('pharmaceutical_unit')->select(DB::raw('count(*) as count'))->where('process_area', $process_area)->where('unit_status', '=', 0)->first();

        // Tags no registrados
        // Buscamos tags registrados
        $tagSet = DB::table('tag')
            ->select('epc_code')
            ->whereIn('tag.epc_code', $epc)
            ->get();
        // Hallar diferencia entre $epc y $tagSet

        $registered = [];
        foreach ($tagSet as $tag) {
            $registered[] = $tag->epc_code;
        }

        //verificamos si hay tags faltantes en el process indicado
        $difference = array_diff($epc, $registered);

        return response()->json(["missing_products" => $missing, "surpluses" => $surpluses, "quantity_Area" => $total->count,]);
        // 'unregistered_tags' => $difference,
    }
}
