<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrowseProductsController extends Controller
{
    /*public function __construct()
    {
    $this->middleware('auth');
    }*/

    public function ShowBrowseProduct(Request $request, $category)
    {
        $user = Auth::user();

        $data = DB::table('products')
            ->select(
                '*'
            )
            ->where('category', $category)
            ->get();

        return view('browse_products')->with(['purchases' => $data, 'category' => $category, 'url' => $url]);

    }

    public function searchProduct($id, Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            $quantity = "";
        } else {
            if (isset($cart[$id])) {
                $quantity = $cart[$id]['quantity'];
            } else {
                $quantity = "";
            }
        }
        return response()->json(["quantity" => $quantity]);
    }

    public function guardarProducto(Request $request)
    {

        $product_id = $request->input('product_id');
        $productName = $request->input('productName');
        $description = $request->input('description');
        $price = $request->input('productPrice');
        $quantity = $request->input('quantity');
        $total = $request->input('total'); //Deberia ser una opreacion interna del carro

        $cart = session()->get('cart');
        if (!$cart) {
            $cart = [
                $product_id => [
                    "product_id" => $product_id,
                    "productName" => $productName,
                    "description" => $description,
                    "price" => $price,
                    "quantity" => $quantity,
                    "total" => $total,
                ],
            ];
            session()->put('cart', $cart);
        }
        // if cart not empty then check if this portfolio exist then increment quantity
        if (isset($cart[$product_id])) {

            $cart[$product_id]['quantity'] = $quantity;
            $cart[$product_id]['total'] = $cart[$product_id]['price'] * $quantity;
            session()->put('cart', $cart);
            //  return response()->json([session()->get('cart')]);
            return response()->json(['message' => 'El producto ha sido actualizado en tu carrito!. Unidades: ', 'cantidad' => $cart[$product_id]['quantity']]);
        }

        $cart[$product_id] = [
                "product_id" => $product_id,
                "productName" => $productName,
                "description" => $description,
                "price" => $price,
                "quantity" => $quantity,
                "total" => $total,
        ];
        session()->put('cart', $cart);

        return response()->json($cart);

        return response()->json(['message' => 'Add Cart']);
    }

    public function ShowCart()
    {
        $cart = session()->get('cart');
        if ($cart) {
            return response()->json(array_values($cart));
        } else {
            return response()->json([]);
        }

    }

    public function ShowDetailCart($id, Request $request)
    {
        $cart = session()->get('cart');
        $quantity = $cart[$id]['detail'];

        return response()->json(array_values($cart));
    }
    //ENVIO CARRITO DE COMPRAS
    public function checkout()
    {
        $user = Auth::user();
        $role = $user->permission->code;

        if ($role != 'ADMINISTRADOR') {
            return;
        }

        DB::beginTransaction();
        $cart = session()->get('cart');
        $customerId = null;

        $transaction = new Product_Transfer;
        $transactionDetail = new Product_Transfer_Detail;
        $allTransaction = [];
        //Pruebas comn solo un producto para verificar funcionalidad
        foreach ($cart as $portfolio) {
            $customerId = DB::table('customer_portfolio')->select('customer')->where('id', '=', $portfolio['portfolioId'])->first();
            $transaction->transfer_type = $portfolio['transactionClass'];
            $transaction->transfer_code = $this->uuid();
            $transaction->current_owner = $customerId->customer;
            $transaction->interested = $user->facility;
            $transaction->applicant = $user->id;
            $transaction->product = $portfolio['portfolioId'];
            $transaction->price = $portfolio['price'];
            $transaction->quantity = $portfolio['quantity'];
            $transaction->batch = $portfolio['batch'];
            $transaction->expiration_date = $portfolio['expiration_date'];
            $transaction->save();
            if ($portfolio['transactionClass'] == 0) {
                $contador = count($portfolio['detail']);

                for ($i = 0; $i < $contador; $i++) {
                    $transactionDetail->product_transfer = $transaction->id;
                    $transactionDetail->proposed_product = $portfolio['detail'][$i]['portfolio'];
                    $transactionDetail->quantity = $portfolio['detail'][$i]['quantity'];
                    $transactionDetail->batch = $portfolio['detail'][$i]['batch'];
                    $transactionDetail->expiration_date = $portfolio['detail'][$i]['expiration_date'];
                    $allTransaction[] = $transactionDetail->attributesToArray();
                }
            }
        }

        session()->forget('cart');

        return response()->json(['message' => 'Se han enviado tus propuestas ']);
    }


    public function DeleteToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $cart = session()->get('cart');
        unset($cart[$product_id]);
        session()->put('cart', $cart);

        return response()->json(['message' => 'Item removed'],200);
    }

    public function clearCart()
    {
        session()->forget('cart');
       //session()->flush('cart');

        return response()->json(['message' => 'Cart deleted'],200);
    }
    
}
