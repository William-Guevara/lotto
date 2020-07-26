<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ContactUsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index()
    {
        return view('contact_us');
    }

    public function AddMenssage(Request $request)
    {
        $user = Auth::user();

        if($user == '' ){
            $user = null;
        }
        $full_name = $request->input('full_name');
        $email = $request->input('email');
        $message = $request->input('message');
        $IP = $request->input('IP');

        DB::table('message')
            ->insert([
                'full_name'  =>  $full_name,
                'email'  =>  $email,
                'message'  =>  $message,
                'IP' => $IP,
                'answered' => 0
                ]);
        
        return response()->json(['message'=>'Mensaje agregado'],200);

    }
}
