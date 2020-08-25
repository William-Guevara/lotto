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
            ->where('orders.cust_id', $user->id) //714)
            ->where('orders.response_code', 1)
            ->orderby('completion_timestamp', 'desc')
            ->get();

        $images = DB::table('orders')
            ->join('users', 'users.user_id', '=', 'orders.cust_id')
            ->join('order_products', 'order_products.order_id', '=', 'orders.order_id')
            ->join('ticket_images', 'ticket_images.purchased_product_id', '=', 'order_products.purchased_product_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->select(
                'category',
                DB::raw('CONCAT(users.fname, " ",users.lname) as name'),
                'users.user_id as user_id',
                'image_id',
                'drawing_date',
                'src_image',
                'num_tickets',
                'current_ticket',
                'tickets_received',
                DB::raw('(total_games_tp * quantity) as promised'),
                'orders.order_id'
            )
            ->where('user_id', $user->user_id)
            ->get();

        return view('my_account')->with(['user' => $user_data, 'purchases' => $purchases, 'images' => $images]);
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
