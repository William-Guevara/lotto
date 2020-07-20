<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowPurchases()
    {
        $user = Auth::user();

        $data = DB::table('orders')
            ->select('order_id', 'response_code', 'amount', 'first_name', 'last_name', 'completion_timestamp')
            ->get();

        return view('purchases')->with('purchases', $data);

    }
}
