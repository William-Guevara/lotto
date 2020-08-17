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
            ->get();

        return view('users')->with('users', $data);

    }

    //Serach info
    public function SearchInfo($id, Request $request)
    {
        $users = DB::table('users')
            ->join('countries', 'countries.country_id', '=', 'users.country')
            ->select('*', 'countries.country_name'
            )
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

    //update or create user
    public function UserControl(Request $request)
    {
        //Actualizar el registro del producto
        $option_select = $request->input('option');
        $user_id = $request->input('user_id');

        $Email = $request->input('Email');
        $Email2 = $request->input('Email2');
        $Password = $request->input('Password');
        $FirstName = $request->input('FirstName');
        $LastName = $request->input('LastName');
        $Address = $request->input('Address');
        $City = $request->input('City');
        $State = $request->input('State');
        $ZipCode = $request->input('ZipCode');
        if ($ZipCode == "") {
            $ZipCode = 0000;
        }
        $Country = $request->input('Country');
        $Phone = $request->input('Phone');
        $Fax = $request->input('Fax');
        $Gender = $request->input('Gender');
        $Credits = $request->input('Credits');
        $Newsletter = $request->input('Newsletter');
        $Language = $request->input('Language');
        $Level = $request->input('Level');

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
                    'level' => 1,
                    'active' => 1,
                ]);
            return response()->json(['message' => 'Created']);
        }
        if ($option_select == 'update') {
            DB::table('users')
                ->where('user_id', $user_id)
                ->update([
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
            return response()->json(['message' => 'Updated']);
        }
        if ($option_select == 'update_client') {
            $user = Auth::user();
            $Email = $request->input('email');
            $Email2 = $request->input('email2');
            $FirstName = $request->input('fname');
            $LastName = $request->input('lname');
            $Address = $request->input('address');
            $City = $request->input('city');
            $State = $request->input('state');
            $ZipCode = $request->input('zip_code');
            if ($ZipCode == "") {
                $ZipCode = 0000;
            }
            $Phone = $request->input('phone');
            $Fax = $request->input('fax');
            $Gender = $request->input('gender');
            $Newsletter = $request->input('newsletter');
            $Language = $request->input('language');
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
    public function UserDetail($id){

        $user = Auth::user();

        $user_data = DB::table('users')
            ->select('*')
            ->where('user_id', 361)//$id)
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
            ->where('orders.cust_id', 361)//$id) //714)
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
            ->where('user_id', 361)//$id)
            ->get();

        return view('admin_account')->with(['user' => $user_data, 'purchases' => $purchases, 'images' => $images]);

    }
}
