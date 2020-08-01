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
Route::get('lang/{lang}', 'LanguageController@swap')->name('lang.swap');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Rutas topbar
//Rutas topbar
Route::get('/', function () {
    $user = Auth::user();

    $data = DB::table('results')
        ->select('*')
        ->orderby('drawing_id', 'DESC')
        ->limit(7)
        ->get();

    return view('index')->with(["user" => $user, 'results' => $data]);
})->name('inicio'); // Vista de inicio
Route::get('index', function () {
    $user = Auth::user();

    $data = DB::table('results')
        ->select('*')
        ->orderby('drawing_id', 'DESC')
        ->limit(7)
        ->get();

    return view('index')->with(["user" => $user, 'results' => $data]);
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
//vistas agregar tiketes al usuario
Route::get('adminTickets', 'AdminTicketsController@ShowPurchases')->name('adminTickets'); //Vista para agregar ticketes
Route::post('admin/AddTicket', 'AdminTicketsController@AddTicket')->name('AddTicket');
Route::get('admin/ViewTicket', 'AdminTicketsController@ViewTicket')->name('ViewTickets');
Route::get('admin/ViewTicket/{category}/{drawing_date}', 'AdminTicketsController@ViewTicketLoad')->name('ViewTicketLoad');



//vistas Loterias cliente cart
Route::get('browseProducts/{category}', 'BrowseProductsController@ShowBrowseProduct')->name('browseProducts'); //Vista de compras
Route::post('addToCart', 'BrowseProductsController@guardarProducto')->name('addToCart'); //Guardar cookie
Route::get('Carrito', 'BrowseProductsController@ShowCart')->name('Carrito'); //Agregar datos a modal Carrito
Route::post('DeleteToCart', 'BrowseProductsController@DeleteToCart')->name('DeleteToCart'); //Eliminar un elemento del carro
Route::post('BorrarCarrito', 'BrowseProductsController@clearCart')->name('BorrarCarrito'); //Eliminar los datos del carrito
Route::get('checkout', 'BrowseProductsController@checkout'); //Generar compra o transaccion

//Correos electronicos 
Route::get('adminMailTemplate', 'AdminMailController@ShowTemplates')->name('adminMailTemplate'); //Vista de los templates del email
Route::post('adminMailTemplate/{id}', 'AdminMailController@SearchInfo'); //Carga la informacion del producto seleccionado
Route::get('adminMailTemplate/{id}/delete', 'AdminMailController@DeleteadminMailTemplate'); //Eliminar producto
Route::post('adminMailTemplate/control', 'AdminMailController@ProductControl')->name('adminMailTemplate_control'); //Actualiza o crea un producto

//Correos electronicos 
Route::get('edithHome', 'EdithHomeController@ShowTemplates')->name('EdithHome'); //Vista de los templates del email



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
