<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS APP MOVILE
|-------------------------------------------------------------------------- 
| A continuacion se encuentran todas las rutas de la aplicacion android
|
*/

//ingreso app
Route::get('/login', 'Api\ApiLoginController@login');
Route::get('/test', function () {
    return 'hola';
});

//ORDENES- DE ETIQUETADO
Route::post('/OrdenEtiquetado', 'Api\LabelingRequestController@labelingRequestList');//Listado de ordenes de etiquetado pendientes
Route::post('/OrdenEtiquetado/{labeling_request}/Productos', 'Api\LabelingRequestController@labelingRequestProductCount');//Listado de productos para una órden de etiquetado seleccionada
Route::post('/OrdenEtiquetado/{labeling_request}/Productos/{pharmaceutical_unit}', 'Api\LabelingRequestController@labelingRequestProductList');//Muestra el listado de los productos 

//ETIQUETADO- DE PRODUCTOS
Route::post('/OrdenEtiquetado/RelacionProductosTag', 'Api\LabelingRequestController@RequestProductTag');//Agregar la relacion de Pharmaceutical_Unit con Tag 
Route::post('/CerrarOrden', 'Api\LabelingRequestController@CloseOrder');//Cerrar orden de etiquetado con productos faltantes por etiquetar


//BUSCAR- UBICACIONES
Route::post('/AreaProceso', 'Api\InventoryReportController@SearchArea');//Buscar las areas de proceso (PROCESS_AREA)
Route::post('/AreaProceso/{process_area}/Contenedor', 'Api\InventoryReportController@SearchAreaContent');//Buscar ubicaciones finales (STORE)

//REPORTES- DE INVENTARIO
Route::post('/ValidacionReporte', 'Api\InventoryReportController@InventoryReportValidate');//Valida los epcs recibidos para retornar la informacion del producto
Route::post('/ReporteInventario', 'Api\InventoryReportController@InventoryReportOne');//asocia el epc_code con el process_area indicando su ubicacion inicial (process_area y store)
Route::post('/ReporteInventarioRegular', 'Api\InventoryReportController@InventoryReportRegular');//verifica la informacion de la ubicacion de los producto para determinar si hacen falta o no en su inventario

//BUSCAR- PRODUCTOS
Route::post('/BuscarProducto', 'Api\ProcessController@SearchProduct');//Buscar Producto por epc_code
Route::post('/BuscarSerial', 'Api\ProcessController@SearchSerial');//Buscar producto por label_serial

//INVENTARIO- 
Route::post('/DescargarProducto', 'Api\ProcessController@DeleteProduct');//Eliminar Producto (Cambiar de estado a INACTIVO)
Route::post('/Reintegro', 'Api\ProcessController@Refund');//Devolucion y reintegro (Cambiar de estado a ACTIVO)

//ACTUALIZAR- TAG
Route::post('/CambiarTag', 'Api\ProcessController@ChangeTag');//Cambio de etiqueta por daño


