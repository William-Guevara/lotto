<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowUser()
    {
        $user = Auth::user();

        $data = DB::table('users')
            ->select('user_id', 'email', 'fname', 'lname')
            ->where('active', 1)
            ->get();

        return view('users')->with('users', $data);

    }

    //Serach info
    public function SearchInfo($id, Request $request)
    {
        $users = DB::table('users')
            ->join('countries', 'countries.country_id', '=', 'users.country')
            ->select('*', 'countries.country_name')
            ->where('user_id', $id)
            ->first();

        return response()->json($users);
    }

    //Delete user
    public function DeleteUser($id, Request $request)
    {
        DB::table('users')->where('user_id', $id)->delete();

        return response()->json(['message' => 'User delete']);
    }

    //update or create user from myAcount
    public function UserControl(Request $request)
    {
        //Actualizar el registro del producto
        $option_select = $request->input('option');
        $user_id = $request->input('user_id');

        $Email = $request->input('email');
        $Email2 = $request->input('email2');
        $Password = $request->input('password');
        $FirstName = $request->input('fname');
        $LastName = $request->input('lname');
        $Address = $request->input('address');
        $City = $request->input('city');
        $State = $request->input('state');
        $ZipCode = $request->input('zip_code');
        if ($ZipCode == "") {
            $ZipCode = 0000;
        }
        $Country = $request->input('country');
        $Phone = $request->input('phone');
        $Fax = $request->input('fax');
        $Gender = $request->input('gender');
        $Credits = $request->input('credits');
        $Newsletter = $request->input('newsletter');
        $Language = $request->input('language');
        $Level = $request->input('level');

        if ($option_select == 'create') {
            DB::table('users')
                ->insert([
                    'email' => $Email,
                    'email2' => $Email2,
                    'password' => $Password,
                    'fname' => $FirstName,
                    'lname' => $LastName,
                    'address' => $Address,
                    'city' => $City,
                    'state' => $State,
                    'zip_code' => $ZipCode,
                    'country' => $Country,
                    'phone' => $Phone,
                    'fax' => $Fax,
                    'gender' => $Gender,
                    'credits' => $Credits,
                    'newsletter' => $Newsletter,
                    'language' => $Language,
                    'level' => $Level,
                    'active' => 1,
                ]);
            return response()->json(['message' => 'Created']);
        } else if ($option_select == 'update_admin') {
            DB::table('users')
                ->where('user_id', $user_id)
                ->update([
                    'email' => $Email,
                    'email2' => $Email2,
                    'fname' => $FirstName,
                    'lname' => $LastName,
                    'address' => $Address,
                    'city' => $City,
                    'state' => $State,
                    'zip_code' => $ZipCode,
                    'country' => $Country,
                    'phone' => $Phone,
                    'fax' => $Fax,
                    'gender' => $Gender,
                    'credits' => $Credits,
                    'newsletter' => $Newsletter,
                    'language' => $Language,
                    'level' => $Level,
                    'active' => 1,
                ]);
            return redirect()->back();
        } else if ($option_select == 'update_client') {
            $user = Auth::user();

            DB::table('users')
                ->where('user_id', $user->user_id)
                ->update([
                    'email' => $Email,
                    'email2' => $Email2,
                    'fname' => $FirstName,
                    'lname' => $LastName,
                    'address' => $Address,
                    'city' => $City,
                    'state' => $State,
                    'zip_code' => $ZipCode,
                    'phone' => $Phone,
                    'fax' => $Fax,
                    'gender' => $Gender,
                    'newsletter' => $Newsletter,
                    'language' => $Language,
                ]);
            return redirect()->route('myAccount');
        }

        return response()->json(['message' => 'No se registro ningun cambio'], 400);
    }

    //detail user edit
    public function UserDetail($id)
    {

        $user = Auth::user();

        $user_data = DB::table('users')
            ->select('*')
            ->where('user_id', $id)
            ->first();

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
            ->where('orders.cust_id', $id) //714)
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
            ->where('user_id', $id)
            ->where('orders.response_code', 1)
            ->orderBy('drawing_date', 'desc')
            ->get();

        return view('admin_account')->with(['user' => $user_data, 'purchases' => $purchases, 'images' => $images]);

    }

    //Detalle de productos para un usuario seleccionado desde un usuario administrador
    public function DetailProducts($id)
    {
        $orders = DB::table('orders')
            ->join('order_products', 'order_products.order_id', '=', 'orders.order_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->select(
                'products.name_en as product_name',
                'quantity',
                DB::raw('(quantity*total_games_tp) as promised'),
                'tickets_received',
                'completion_timestamp'
            )
            ->where('orders.response_code', 1)
            ->where('orders.order_id', $id)
            ->get();

        return $orders;
    }

    public function AddTickets(Request $request)
    {
        $order_id = $request->input('order_id');
        $quantity = $request->input('quantity');

        $orders = DB::table('order_products')
            ->select('purchased_product_id', 'total_games_tp')
            ->where('order_id', $order_id)
            ->get();

        foreach ($orders as $order) {

            $total = $order->total_games_tp;
            $total = $total + $quantity;
            $order_ = $order->purchased_product_id;

            DB::table('order_products')
                ->where('purchased_product_id', $order_)
                ->update(['total_games_tp' => $total]);
        }
        return response()->json(['message' => 'Updated']);

    }
}
