<?php

namespace App\Http\Controllers;

use App\Mail\MessageResult;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowResults()
    {
        $user = Auth::user();

        $data = DB::table('results')
            ->select('*')
            ->get();

        return view('results')->with('results', $data);

    }

    //Serach info
    public function SearchInfo($id, Request $request)
    {
        $result = DB::table('results')
            ->select('*'
            )
            ->where('drawing_id', $id)
            ->first();

        return response()->json($result);
    }

    //Delete user
    public function DeleteResults($id, Request $request)
    {
        DB::table('results')->where('drawing_id', $id)->delete();

        return response()->json(['message' => 'Delete result']);
    }

    //update or create user
    public function ResultsControl(Request $request)
    {
        //Actualizar el registro del producto
        $option_select = $request->input('option');
        $drawing_id = $request->input('drawing_id');

        $category = $request->input('category');
        $drawing_date = $request->input('drawing_date');
        $numbers = $request->input('numbers');
        $jackpot = $request->input('jackpot');

        if ($option_select == 'create') {
            DB::table('results')
                ->insert([
                    'category' => $category,
                    'drawing_date' => $drawing_date,
                    'numbers' => $numbers,
                    'jackpot' => $jackpot,
                ]);
            return response()->json(['message' => 'Result created']);
        }
        if ($option_select == 'update') {
            DB::table('results')
                ->where('drawing_id', $drawing_id)
                ->update([
                    'category' => $category,
                    'drawing_date' => $drawing_date,
                    'numbers' => $numbers,
                    'jackpot' => $jackpot,
                ]);
            return response()->json(['message' => 'Result Updated']);
        }

        return response()->json(['message' => 'No se registro ningun cambio'], 400);
    }

    //muestra resultados
    public function ShowMail(Request $request)
    {
        $user = Auth::user();

        $dist = DB::table('results')
            ->select(DB::raw('distinct(category) as category'))
            ->groupby('category')
            ->get();

        $count = 0;
        $obj_ = [];

        foreach ($dist as $di) {
            $data = DB::table('results')
                ->select('*')
                ->where('category', $di->category)
                ->orderby('drawing_date', 'desc')
                ->first();

            $obj_[$count] = $data;
            $count++;
        }

        return view('view_result_mail')->with('results', $obj_);
    }

    public function SendMail()
    {
        $dist = DB::table('results')
            ->select(DB::raw('distinct(category) as category'))
            ->groupby('category')
            ->get();

        $count = 0;
        $mail = [];

        foreach ($dist as $di) {
            $data = DB::table('results')
                ->select('*')
                ->where('category', $di->category)
                ->orderby('drawing_date', 'desc')
                ->first();

            $mail[$count] = $data;
            $count++;
        }


        $users = DB::table('users')
            ->select('*')
            ->get();
       
        $msg =  $mail;

        foreach ($users as $ema) {
            Mail::to($ema->email)->send(new MessageResult($msg));
        }
        /*Mail::to('wikoguevara@gmail.com')->send(new MessageResult($msg));*/

        return response()->json(['message' => 'Email sent'], 200);
    }
}
