<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller as Controller;
use App\Models\Customer_Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Models\Tag;
use App\Models\Pharmaceutical_Unit;
use App\Models\Process_Area;
use App\Models\Store;
use App\Models\Pharmaceutical_Unit_Location;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory_Outcome;


class ProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /*
    | BUSCAR PRODUCTO
    |--------------------------------------------------------------------------
    |Se recibira el (epc_code) del producto a consultar, validando su 
    |existencia y buscando (id) tag para enviar la información correspondiente
    */
    public function SearchProduct(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $epc = $request->input('epc_code');

        //Validamos la existencia del tag con el epc_indicado
        $exist = DB::table('tag')
            ->where('epc_code', $epc)
            ->exists();

        if ($exist == false) {
            return response()->json(['code' => 404, 'message' => 'Este tag no a sido creado']);
        }

        //Buscar el id de la unidad farmaceutica asociada con el epc recibido
        $idTag = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id')
            ->where('epc_code', '=', $epc)
            ->exists();

        if ($idTag == false) {
            return response()->json(['code' => 404, 'message' => 'Este tag no a sido asociado a ningun producto']);
        }

        //Buscar el id de la unidad farmaceutica asociada con el epc recibido
        $idFarma = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id')
            ->where('epc_code', '=', $epc)
            ->first();

        $Producto = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->join('facility', 'facility.id', '=', 'tag.owner')
            ->select('product.name', 'pharmaceutical_unit.id as pharmaceutical_unit', 'tag.epc_code', 'sanitary_registration.invima_code', 'product.cum_sequence', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date', 'facility.name as facility', 'tag.tag_status', 'pharmaceutical_unit.unit_status', 'pharmaceutical_unit.process_area')
            ->where('pharmaceutical_unit.id', '=', $idFarma->id)
            ->get();

        return response()->json($Producto);
    }
    /*
    | BUSCAR PRODUCTO POR SU SERIAL 
    |--------------------------------------------------------------------------
    |En caso de que la etiquesta del tag se encuentre averiada se validara la 
    |existencia del producto por medio de su serial
    */
    public function SearchSerial(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $serial = $request->input('label_serial');

        //Validamos la existencia del tag con el epc_indicado
        $exist = DB::table('tag')
            ->where('label_serial', $serial)
            ->exists();

        if ($exist == false) {
            return response()->json(['code' => 404, 'message' => 'Este tag no a sido creado']);
        }

        //Buscar el id de la unidad farmaceutica asociada con el epc recibido
        $idTag = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id')
            ->where('label_serial', '=', $serial)
            ->exists();

        if ($idTag == false) {
            return response()->json(['code' => 404, 'message' => 'Este tag no a sido asociado a ningun producto']);
        }

        //Buscar el id de la unidad farmaceutica asociada con el epc recibido
        $idFarma = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.id')
            ->where('label_serial', '=', $serial)
            ->first();


        //TODO: Verificar el left join ya que la consulta no muestra los productos q no se encuentren en inventory report
        $Producto = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->join('facility', 'facility.id', '=', 'tag.owner')
            ->select('product.name', 'pharmaceutical_unit.id as pharmaceutical_unit', 'tag.label_serial', 'sanitary_registration.invima_code', 'product.cum_sequence', 'pharmaceutical_unit.batch', 'pharmaceutical_unit.expiration_date', 'facility.name as facility', 'tag.tag_status', 'pharmaceutical_unit.unit_status', 'pharmaceutical_unit.process_area')
            ->where('pharmaceutical_unit.id', '=', $idFarma->id)
            ->get();

        return response()->json($Producto);
    }

    /*
    | CAMBIO O ACTUALIZACION DE TAG
    |--------------------------------------------------------------------------
    |Proceso en el cual se realizara una orden de etiquetado unitaria para 
    |cambiar el tag averiado o defectuoso por el nuevo tag
    */
    public function ChangeTag(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $pharma = $request->input("pharmaceutical_unit");
        $epc = $request->input("epc_code");

        //Validamos el pharmaceutical_unit y que el epc_code existan 
        $exist = DB::table('pharmaceutical_unit')
            ->where('id', $pharma)
            ->exists();
        $exist1 = DB::table('tag')
            ->where('epc_code', $epc)
            ->exists();
        if ($exist == false) {
            return response()->json(['code' => 400, 'Error' => 'Este producto no a sido credo']);
        }
        if ($exist1 == false) {
            return response()->json(['code' => 400, 'Error' => 'Este tag no a sido creado']);
        }

        //Validamos el id tag actual
        $idTag = DB::table('tag')->select('id')->where('epc_code', $epc)->first();

        //verificamos si el nuevo tag no pertenece a ninguna otra unidad farmaceutica
        $sqlTag = DB::table('pharmaceutical_unit')->where('tag', $idTag->id)->exists();
        if ($sqlTag == true) {
            return response()->json(['code' => 400, 'Error' => 'El tag ya fue asignado a otra unidad farmaceutica']);
        }

        try {
            DB::beginTransaction();
            $pharma = Pharmaceutical_Unit::find($pharma);
            $pharma->tag = $idTag->id;
            $pharma->save();
            //Auditoria de transaccion  
            $controller = new AuditTrailController;
            $controller->audittrail();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return response()->json(['code' => 200, 'message' => 'El tag a sido actualizado correctamente']);
    }


    /*
    | DESCARGAR PRODUCTO DE INVENTARIO
    |--------------------------------------------------------------------------
    |Se cambiara el estado del status, tanto de la unidad farmaceutica como del
    |tag a 0 indicado q el producto esta inactivo
    */
    public function DeleteProduct(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;
        $facility = $user->facility;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $id = $request->input('pharmaceutical_unit');
        $cause = $request->input("cause");

        //Validamos la existencia de la unidad farmaceutica indicada
        $exist = DB::table('pharmaceutical_unit')->where('id', $id)->exists();
        if ($exist == false) {
            return response()->json(['code' => 400, 'message' => 'producto no encontrado']);
        }
        //verificamos que el pharmaceutical_unit tenga un tag asociado
        $sql = DB::table('pharmaceutical_unit')->select('id', 'tag')->where('id', $id)->first();

        if ($sql->tag == null) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmaceutica no cuenta con tag asociado!']]);
        }

        //Cargamos la informacion necesaria para validar que el status del tag no este en 0 y pueda ser procesado
        $sqlTag = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->select('pharmaceutical_unit.tag', 'pharmaceutical_unit.unit_status as pharmaStatus', 'tag.tag_status as tagStatus')
            ->where('pharmaceutical_unit.id', $id)
            ->first();

        if ($sqlTag->pharmaStatus != 0 || $sqlTag->tagStatus != 1) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmaceutica ya se encuentra Descargada!']]);
        }

        try {
            DB::beginTransaction();
            $pharma = Pharmaceutical_Unit::find($id);
            $pharma->unit_status = $cause; //( 0:Activo, 1: Dispensado, 2:Remitido , 3: Mal estado, 4: Vencido)
            $pharma->save();

            //Auditoria de transaccion 
            $controller = new AuditTrailController;
            $controller->audittrail();

            $tag = Tag::find($sqlTag->tag);
            $tag->tag_status = 0; //(0: inactivo, 1: Activo)
            $tag->save();
            $controller->audittrail();

            $outcome = new Inventory_Outcome;
            $outcome->pharmaceutical_unit = $pharma->id;
            $outcome->cause = $cause; 
            $outcome->executor = $user->id; 
            $outcome->facility = $facility; 
            $outcome->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return response()->json(['code' => 200, ['message' => 'Producto descargado con exito!'],200]);
    }
    /*
    | DEVOLUCION Y REINTEGRO 
    |--------------------------------------------------------------------------
    |Se validara la existencia del producto y su estado tanto del tag como de 
    |la unidad farmaceutical, el estado tendra q estar en 0 y se cambiara a 1
    */
    public function Refund(Request $request)
    {
        //tomamos el roll  del usuario que realiza la peticion
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'OPERADOR') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $id = $request->input('pharmaceutical_unit');
        $process_area = $request->input("process_area");

        //Validamos la existencia de la unidad farmaceutica indicada
        $exist = DB::table('pharmaceutical_unit')->where('id', $id)->exists();

        if ($exist == false) {
            return response()->json(['code' => 404, 'message' => 'producto no encontrado']);
        }

        //verificamos que el pharmaceutical_unit tenga un tag asociado
        $sql = DB::table('pharmaceutical_unit')->select('id', 'tag')->where('id', $id)->first();
        if ($sql->tag == null) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmaceutica no cuenta con tag asociado!']]);
        }

        //Cargamos la informacion necesaria para validar que el status del tag no este en 0 y pueda ser procesado
        $sqlTag = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->leftjoin('process_area', 'process_area.id', '=', 'pharmaceutical_unit.process_area')
            ->select('tag.id', 'pharmaceutical_unit.unit_status as pharmaStatus', 'tag.tag_status as tagStatus', 'pharmaceutical_unit.process_area', 'process_area.name as process_name')
            ->where('pharmaceutical_unit.id', $id)
            ->first();

        //Validamos las posibles excepciones que juegan en contra del retorno del tag
        if ($sqlTag->pharmaStatus == 0 && $sqlTag->tagStatus == 1) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmaceutica ya fue reintegrada!']]);
        }
        if (is_null($sqlTag->process_area)) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmaceutica no a sido asignada a ningun area de proceso!']]);
        }
        if ($sqlTag->process_area != $process_area) {
            return response()->json(['code' => 400, ['message' => 'Esta unidad Farmacutica no pertenece a esta area de proceso, acercate al area: ', $sqlTag->process_name]]);
        }

        if ($sqlTag->process_area = $process_area) {
            try {
                DB::beginTransaction();
                $pharma = Pharmaceutical_Unit::find($id);
                $pharma->unit_status = 0;
                $pharma->save();
                //Auditoria de transaccion  
                //TODO::Vaidacion de usuario para el controlador de auditoria
                $controller = new AuditTrailController;
                $controller->audittrail();

                $tag = Tag::find($sqlTag->id);
                $tag->tag_status = 1;
                $tag->save();
                $controller->audittrail();
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
            return response()->json(['code' => 200, 'message' => 'El producto a sido reintegrado exitosamente!'], 200);
        }
    }
}
