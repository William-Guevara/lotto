<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowPurchases(Request $request, $category)
    {
        $user = Auth::user();

        $data = DB::table('order_products')
            ->join('orders', 'orders.order_id', '=', 'order_products.order_id')
            ->join('users', 'users.user_id', '=', 'orders.cust_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->select(
                DB::raw("CONCAT(users.fname,' ', users.lname) as name"),
                'quantity as total_tickets',
                DB::raw('(quantity*total_games_tp) as promised'),
                DB::raw('((quantity*total_games_tp) - (tickets_received)) as owed')
            )
            ->whereRaw('tickets_received < (quantity*total_games_tp)')
            ->where('orders.response_code', 1)
            ->where('products.category', $category)
            ->get();

        return view('adminPurchases')->with(['purchases' => $data, 'category' => $category]);

    }
}
