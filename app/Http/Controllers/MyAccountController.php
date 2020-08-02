<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowDetail()
    {
        $user = Auth::user();

        $user_data = DB::table('users')
        //->join('city', 'city.id', '=', 'ciudad')
            ->select('*')
            ->where('user_id', $user->user_id)
            ->first()
        ;

        $purchases = DB::table('orders')
            ->join('order_products', 'order_products.order_id', '=', 'orders.order_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->select(
                'orders.order_id',
                'products.name_es',
                'products.name_en',
                'quantity',
                'tickets_received',
                'completion_timestamp',
                DB::raw('((quantity*total_games_tp) - (tickets_received)) as owed')

            )
            ->where('orders.cust_id', 714) //$user->id)
            ->where('orders.response_code', 1)
            ->orderby('completion_timestamp', 'desc')
            ->get();

        return view('my_account')->with(['user' => $user_data, 'purchases' => $purchases]);

        $md->getData(
            "orders.order_id as 'order_id',
            products.name_" . (($lang == "en") ? "en" : "es") . " as 'name_" . (($lang == "en") ? "en" : "es") . "',
             `quantity`,
            `tickets_received`,
            ((quantity*total_games_tp) - (tickets_received)) as 'owed'",

            "orders,
            order_products,
            products",

            "orders.response_code='1'
            AND
                orders.order_id=order_products.order_id
            AND
                order_products.product_id=products.product_id
            AND
                orders.cust_id='{$userID}'",
            "ORDER BY completion_timestamp desc");

    }

    public function updatePass(Request $request)
    {
        // Validar los datos
        $this->validate($request, [
            'password' => ['required', 'string', 'confirmed'],
        ]);

        // Note la regla de validación "confirmed", que solicitará que usted agregue un campo extra llamado password_confirm

        $user = Auth::user(); // Obtenga la instancia del usuario en sesión
        $password = Hash::make($request->password);
        $user->password = $password; // Rellene el usuario con el nuevo password ya encriptado
        $user->save(); // Guarde el usuario

        // Por ultimo, redirigir al usuario, por ejemplo al formulario anterior, con un mensaje de que el password fue actualizado
        return redirect()->back()->withSuccess('Password actualizado');
    }
}
