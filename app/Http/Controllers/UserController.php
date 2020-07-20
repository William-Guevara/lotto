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
        //->join('city', 'city.id', '=', 'ciudad')
            ->select('user_id', 'email', 'fname', 'lname')
//            ->orderBy('fname like [a-Z][a-Z]% END')
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

        return response()->json(['message' => 'No se registro ningun cambio'], 400);
    }
}
