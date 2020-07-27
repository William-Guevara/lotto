<?php

namespace App\Http\Controllers;

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
            //->where('products.category', '=','Euro Jackpot')
            ->orderBy('users.fname', 'asc')
            ->get();

            return view('adminTickets')->with(['purchases' => $data]);
            return $data;

           $data =  $md->getData(
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
             users.fname asc",$searchable);
            
        

    }
}
