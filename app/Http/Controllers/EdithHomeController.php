<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EdithHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowTemplates()
    {
        $user = Auth::user();

        $data = DB::table('newsletter_templates')
            ->select('*')
            ->get();

        return view('edith_home')->with('templates', $data);

    }

    //Serach info
    public function SearchInfo($id, Request $request)
    {
        $product = DB::table('newsletter_templates')
            ->select('*'
            )
            ->where('id', $id)
            ->first();

        return response()->json($product);
    }

    //Delete user
    public function DeleteProducts($id, Request $request)
    {
        DB::table('products')->where('product_id', $id)->update(['display' => 0]);

        return response()->json(['message' => 'Product disabled: Hide on store']);
    }

    //update or create user
    public function ProductControl(Request $request)
    {
        //Actualizar el registro del producto
        $option_select = $request->input('option');
        $product_id = $request->input('product_id');

        $name_en = $request->input('name_en');
        $description_en = $request->input('description_en');
        $name_es = $request->input('name_es');
        $description_es = $request->input('description_es');
        $duration_months = $request->input('duration_months');
        $total_games = $request->input('total_games');
        $category = $request->input('category');
        $price = $request->input('price');
        $display = $request->input('display');

        if ($option_select == 'create') {
            DB::table('products')
                ->insert([
                    'name_en' => $name_en,
                    'description_en' => $description_en,
                    'name_es' => $name_es,
                    'description_es' => $description_es,
                    'duration_months' => $duration_months,
                    'total_games' => $total_games,
                    'category' => $category,
                    'price' => $price,
                    'display' => $display,
                ]);
            return response()->json(['message' => 'Product created']);
        }
        if ($option_select == 'update') {
            DB::table('products')
                ->where('product_id', $product_id)
                ->update([
                    'name_en' => $name_en,
                    'description_en' => $description_en,
                    'name_es' => $name_es,
                    'description_es' => $description_es,
                    'duration_months' => $duration_months,
                    'total_games' => $total_games,
                    'category' => $category,
                    'price' => $price,
                    'display' => $display,
                ]);
            return response()->json(['message' => 'Product Updated']);
        }

        return response()->json(['message' => 'No se registro ningun cambio'], 400);
    }
}
