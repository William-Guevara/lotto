<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Auth::routes();

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Ruta inicio despues del login
Route::get('/', 'HomeController@index')->name('inicio');

//Rutas topbar
Route::get('index', function () {
    $user = Auth::user();
    
    return view('index')->with(["user" => $user]);
})->name('inicio'); // Vista de inicio

Route::post('/contact_us/add', 'ContactUsController@AddMenssage')->name('addMenssage'); //Agregar mensaje
//Rutas de administrador
Route::get('/administrador', 'AdministratorController@ShowOptions')->name('panel_administracion'); //Panel administrativo: mostrar opciones

//Usuarios
Route::get('users', 'UserController@ShowUser')->name('users'); //Vista de usuarios
Route::get('users/{id}', 'UserController@SearchInfo'); //Carga la informacion del cliente seleccionado a las modales Actualizar cliente y Eliminar cliente
Route::get('users/{id}/delete', 'UserController@DeleteUser'); //Eliminar usuario
Route::post('users/control', 'UserController@UserControl')->name('user_control'); //Actualiza o crea un usuario

//Productos
Route::get('products', 'ProductController@ShowProducts')->name('products'); //Vista de productos
Route::get('products/{id}', 'ProductController@SearchInfo'); //Carga la informacion del producto seleccionado
Route::get('products/{id}/delete', 'ProductController@DeleteProducts'); //Eliminar producto
Route::post('products/control', 'ProductController@ProductControl')->name('products_control'); //Actualiza o crea un producto

//Resultados
Route::get('results', 'ResultsController@ShowResults')->name('results'); //Vista de productos
Route::get('results/{id}', 'ResultsController@SearchInfo'); //Carga la informacion del producto seleccionado
Route::get('results/{id}/delete', 'ResultsController@DeleteResults'); //Eliminar producto
Route::post('results/control', 'ResultsController@ResultsControl')->name('results_control'); //Actualiza o crea un producto

//Compras
Route::get('purchases', 'PurchasesController@ShowPurchases')->name('purchases'); //Vista de compras

//vistas Loterias administrador
Route::get('adminPurchase/{category}', 'AdminPurchasesController@ShowPurchases')->name('adminPurchase'); //Vista de compras

//vistas Loterias cliente cart
Route::get('browseProducts/{category}', 'BrowseProductsController@ShowBrowseProduct')->name('browseProducts'); //Vista de compras




//Typea country in user
Route::get('country_typea', function (Request $request) {
    $data = DB::table('countries')->select('country_id', 'country_name')->where("country_name", "LIKE", "%{$request->input('query')}%")->get();
    return $data;
})->name('country_typea'); //Cargar en pantalla las ciudades

//_______________________________________

//cerrar sesion
Route::get('/logout', function () {
    Auth::logout();
    session()->forget('cart');
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| PAGINAS WEB LOTTO
|--------------------------------------------------------------------------
| A continuacion se encuentran todas las rutas de la aplicacion web
|
 */

//CATALOGOS COMERCIALES
Route::get('PortafolioComercialMedicamentos', 'CommercialPortfolioController@ShowComercialPortfolioDrugs')->name('PortafolioComercialMedicamentos'); //Vista portafolio comercial de medicamentos
Route::get('autocompleteInfoProduct', 'CommercialPortfolioController@autocompleteInfoProduct')->name('autocompleteInfoProduct'); //Al tipear con el teclado se visualizan los productos que se pueden agregar al catalogo propio y al seleccionar un producto se agrega automaticamente la informacion fija del mismo
Route::post('Agregar', 'CommercialPortfolioController@Create'); //Agrega un producto al catalogo comercial

//RUTAS: CREACION DE USUARIOS
Route::get('Usuarios', 'UserController@ShowUser')->name('Usuarios'); //Vista de usuarios
Route::get('autocompleteModalUser/{id}', 'UserController@SearchInfo'); //Carga la informacion del cliente seleccionado a las modales Actualizar cliente y Eliminar cliente
Route::post('ActualizarUsuario', 'UserController@UserUpdate'); //Actualiza un usuario

//VITRINA:: muestra de productos a comercializar
//PRUEBA MÓDULO DE TRANSFERENCIAS
Route::get('OportunidadAbastecimientoTest', 'ShowcaseController@findOpportunities')->name('Oportunidades')->middleware('auth');
Route::get('OportunidadAbastecimiento', 'CommercialController@findOpportunities'); //Productos disponibles
Route::post('guardarProducto', 'CommercialController@guardarProducto'); //Guardar cookie
Route::post('autocompleteModaltransaction/{id}', 'CommercialController@autocompleteModaltransaction'); //Agregar datos a modal

Route::get('UnidadesDisponibles', 'CommercialController@findAvailables'); //Agregar datos a modal
Route::get('DisponiblesIntercambio', 'ShowcaseController@findAvailables')->name('DisponiblesIntercambio')->middleware('auth');

Route::get('Carrito', 'CommercialController@ShowCart'); //Agregar datos a modal Carrito
Route::get('Carrito/{portfolio}', 'CommercialController@searchProduct'); //Agregar Cantidad de productos q se nceuntran en carrito
Route::get('DetailExchange/{portfolio}', 'CommercialController@ShowDetailCart'); //muestra el detalle de los productos a trasferir que se enceuntran en el carrito
Route::get('checkout', 'CommercialController@checkout'); //Generar compra o transaccion
Route::post('BorrarCarrito', 'CommercialController@clearCart'); //Eliminar los datos del carrito
