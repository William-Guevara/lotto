<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrowseProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowBrowseProduct(Request $request, $category)
    {
        $user = Auth::user();

        $data = DB::table('products')
            ->select(
                '*'
            )
            ->where('category', $category)
            ->get();

        return view('browse_products')->with(['purchases' => $data, 'category' => $category]);

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
        $detaill = $request->input('detail');
        $portfolioId = $request->input('portfolioId');
        $productName = $request->input('productName');
        $internal = $request->input('internal');
        $expiration = $request->input('expirationRegister');
        $available = $request->input('available');
        $price = $request->input('price');
        $total = $request->input('total');
        $quantity = $request->input('quantity');
        $batch = $request->input('batch');
        $expiration_date = $request->input('expiration_date');
        $transactionClass = $request->input('transactionClass'); //0 = Tranferencia; 1 = Compra;

        $portfolio = Customer_Portfolio::find($portfolioId);


        if (!$portfolio) {

            abort(404);
        }
        $cart = session()->get('cart');
        $i = 0;
        if (!$cart) {

            if ($detaill != 0) {
                $detail = array();
                foreach ($detaill as $item) {
                    $detail[$i] = [
                        "portfolio" => $item['portfolio'],
                        "quantity" => $item['quantity'],
                        "batch" => $item['batch'],
                        "expiration_date" => $item['expiration_date']
                    ];
                    $i++;
                }

                $cart = [
                    $portfolioId => [
                        "portfolioId" => $portfolio->id,
                        "productName" => $productName,
                        "internal" => $internal,
                        "expiration" => $expiration,
                        "available" => $available,
                        "price" => $price,
                        "quantity" => $quantity,
                        "batch" => $batch,
                        "expiration_date" => $expiration_date,
                        "total" => $total,
                        "transactionClass" => $transactionClass,
                        "detail" => $detail
                    ]
                ];
            } else {
                $cart = [
                    $portfolioId => [
                        "portfolioId" => $portfolio->id,
                        "productName" => $productName,
                        "internal" => $internal,
                        "expiration" => $expiration,
                        "available" => $available,
                        "price" => $price,
                        "quantity" => $quantity, "batch" => $batch,
                        "expiration_date" => $expiration_date,
                        "total" => $total,
                        "transactionClass" => $transactionClass,
                        "detail" => $detaill
                    ]
                ];
            }

            //return response()->json([$cart[$portfolioId]['detail']]);
            session()->put('cart', $cart);
            return response()->json(['message' => 'El producto ha sido agregado con exito a tu carrito de compras!. Unidades: ', 'cantidad' => $cart[$portfolioId]['quantity']]);
        }

        // if cart not empty then check if this portfolio exist then increment quantity
        if (isset($cart[$portfolioId])) {

            if ($cart[$portfolioId]['transactionClass'] == $transactionClass) {
                $cart[$portfolioId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                //  return response()->json([session()->get('cart')]);
                return response()->json(['message' => 'El producto ha sido actualizado en tu carrito!. Unidades: ', 'cantidad' => $cart[$portfolioId]['quantity']]);
            } else {
                if ($transactionClass == 1) {
                    return response()->json(['message' => 'El producto ya se encuentra en tu carrito de compras!. Unidades:  ', 'cantidad' => $cart[$portfolioId]['quantity']]);
                } else
                    return response()->json(['message' => 'El producto ya se encuentra en tu carrito de transacciones']);
            }
        }
        return response()->json(['message' => 'Tu carrito se encuentra lleno. No podrás agregar este producto ', 'cantidad' => 0]);

        // if item not exist in cart then add to cart with quantity = 1

        if ($detaill != 0) {
            $detail = array();
            foreach ($detaill as $item) {
                $detail[$i] = [
                    "portfolio" => $item['portfolio'],
                    "quantity" => $item['quantity'],
                    "batch" => $item['batch'],
                    "expiration_date" => $item['expiration_date']
                ];
                $i++;
            }

            // Función correcta:
            $cart[$portfolioId] = [
                "portfolioId" => $portfolio->id,
                "productName" => $productName,
                "internal" => $internal,
                "expiration" => $expiration,
                "available" => $available,
                "price" => $price,
                "quantity" => $quantity,
                "batch" => $batch,
                "expiration_date" => $expiration_date,
                "total" => $total,
                "transactionClass" => $transactionClass,
                "detail" => $detail
            ];
        } else {
            // Función correcta:
            $cart[$portfolioId] = [
                "portfolioId" => $portfolio->id,
                "productName" => $productName,
                "internal" => $internal,
                "expiration" => $expiration,
                "available" => $available,
                "price" => $price,
                "quantity" => $quantity,
                "batch" => $batch,
                "expiration_date" => $expiration_date,
                "total" => $total,
                "transactionClass" => $transactionClass,
                "detail" => $detaill
            ];
        }

        session()->put('cart', $cart);
        //return response()->json([session()->get('cart')]);

        return response()->json(['message' => 'El producto ha sido agregado con exito a tu carrito de compras!. Unidades: ', 'cantidad' => $cart[$portfolioId]['quantity']]);
    }

    public function ShowCart()
    {
        $cart = session()->get('cart');
        if ($cart)

            return response()->json(array_values($cart));
        else
            return response()->json([]);
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
        Product_Transfer_Detail::insert($allTransaction);
        DB::commit();
        //id customer
        $customer = DB::table('product_transfer')->select('current_owner')->where('product_transfer.id', $transaction->id)->first();

        //Info a enviar al blade del email
        $transactionApplicant = DB::table('product_transfer')
            // Producto que se solicitó
            ->join('customer_portfolio', 'customer_portfolio.id', '=', 'product_transfer.product')
            ->join('product', 'product.id', '=', 'customer_portfolio.product')
            // Producto propuesto para intercambio
            ->join('product_transfer_detail', 'product_transfer_detail.product_transfer', '=', 'product_transfer.id')
            ->join('customer_portfolio AS external', 'external.id', '=', 'product_transfer_detail.proposed_product')
            ->join('product AS exchanged', 'exchanged.id', '=', 'external.product')
            ->join('application_user', 'application_user.id', 'product_transfer.applicant')
            ->join('facility', 'facility.id', 'application_user.facility')
            ->select(
                'exchanged.name as comprado',
                'product.name as ofrecido',
                'facility.name as facility',
                'application_user.name as attendant',
                'product_transfer.quantity',
                'product_transfer.batch',
                'product_transfer.expiration_date',
                DB::raw('CASE WHEN product_transfer.transfer_type = 1 THEN \'Compra\' 
                                WHEN product_transfer.transfer_type = 0 THEN \'Tranferencia\' END as transfer_type'),
                DB::raw('CASE WHEN product_transfer.transfer_status = 0 THEN \'Pendiente\' 
                                WHEN product_transfer.transfer_status = 1 THEN \'Aceptada\'
                                WHEN product_transfer.transfer_status = 2 THEN \'Rechazada\' 
                                WHEN product_transfer.transfer_status = 3 THEN \'Cancelada\' END as transfer_status')
            )
            ->where('product_transfer.id', $transaction->id)
            ->where('product_transfer.current_owner', $customer->current_owner)
            ->first();

        //email del cliente que tiene el producto en catalogo comercial
        $mailClient = DB::table('application_user')
            ->join('role_permission', 'role_permission.id', '=', 'application_user.role')
            ->select('email')
            ->distinct()
            ->where('customer', '=', $customerId->customer)
            ->where('code', "=", 'ADMINISTRADOR')->pluck('email');

        //correo del interesado en realizar la transacción
        $mailInterested =  $user->email;

        //correo cliente
        $message1 = (new TransactionRequestClient($transactionApplicant))
            ->onQueue('fitic-mail');
        Mail::to($mailClient)
            ->queue($message1);


        //correo interesado en producto
        $message2 = (new TransactionRequestInterested($transactionApplicant))
            ->onQueue('fitic-mail');
        Mail::to($mailInterested)
            ->queue($message2);


        session()->forget('cart');

        return response()->json(['message' => 'Se han enviado tus propuestas ']);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['message' => 'Se a vaciado tu carrito de compras']);
    }
}
