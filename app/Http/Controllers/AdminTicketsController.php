<?php

namespace App\Http\Controllers;

use App\Models\Ticket_Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowPurchases(Request $request)
    {
        $user = Auth::user();

        $data = DB::table('order_products')
            ->join('orders', 'orders.order_id', '=', 'order_products.order_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->join('users', 'users.user_id', '=', 'orders.cust_id')
            ->select(
                DB::raw(
                    "CONCAT(users.fname,' ', users.lname) as name"),
                'quantity as total_tickets',
                DB::raw('(quantity*total_games_tp) as promised'),
                DB::raw('((quantity*total_games_tp) - (tickets_received)) as owed'),
                'users.user_id',
                'purchased_product_id',
                'products.category'
            )
            ->whereRaw('tickets_received < (quantity*total_games_tp)')
            ->where('orders.response_code', 1)
            ->orderBy('users.fname', 'asc')
            ->get();

        return view('adminTickets')->with(['purchases' => $data]);
        return $data;

        $data = $md->getData(
            "CONCAT(users.fname,' ',users.lname) as 'name',
               quantity as 'total_tickets',
               ((quantity*total_games_tp) - (tickets_received)) as 'owed',
               users.user_id as 'user_id',
               purchased_product_id",

            "orders,
               order_products,
               products,
               users",

            "orders.order_id = order_products.order_id
            AND
                order_products.product_id = products.product_id
            AND
                orders.cust_id = users.user_id
            AND
                (tickets_received<(quantity*total_games_tp))
            AND
                orders.response_code=1
            AND
                initialized=1 {$where_end}",
            "ORDER BY
             users.fname asc", $searchable);

    }

    public function AddTicket(Request $request)
    {

        $num = $request->input('num');
        $category = $request->input('category');
        $date = $request->input('date');
        $user_id = $request->input('user_id');
        $purchased_product_id = $request->input('purchased_product_id');

        //ORDEN DE COMPRA

        if ($_FILES['file_']['name'] != "") {
            //verificamos que el tamaño del archivo no supere el permitido

            $sizes = $_FILES['file_']['size'];
            $file_name = $_FILES['file_']['name'];
            $file_type = $_FILES['file_']['type'];
            $temp_file = $_FILES['file_']['tmp_name'];
            $archivo_binario = (file_get_contents($temp_file));
            $hoy = date("Y-m-d");

            $ticket = new Ticket_Images;
            $ticket->image_type = $file_type;
            $ticket->image = $archivo_binario;
            $ticket->image_size = 'width="317" height="564"';
            $ticket->drawing_date = $hoy;
            $ticket->purchased_product_id = $purchased_product_id;
            $ticket->num_tickets = $num;
            $ticket->current_ticket = 1;
            $ticket->save();

            return redirect()->route('adminTickets');

            return $ticket;

            /*
        $data = DB::table('ticket_images')
        ->insert([
        'image_type' => $file_type,
        'image' => $archivo_binario,
        'image_size' => 'width="317" height="564"',
        'drawing_date' => '2021-09-06',
        'purchased_product_id' => $purchased_product_id,
        'num_tickets' => $num,
        'current_ticket' => 1]);
         */

        }
        return response()->json(['message' => 'Not file']);
    }
    //Ver tiketes
    public function ViewTicket(Request $request)
    {
        $data = DB::table('ticket_images')
            ->select('*')
            ->where('drawing_date', '=', '2021-09-06')
        //->orderby('image_id', 'desc')
            ->get();
        return view('adminViewTickets')->with(['images' => $data]);

    }
}
