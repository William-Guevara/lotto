<?php

namespace App\Http\Controllers;

use App\Mail\TransactionRequestClient;
use App\Mail\TransactionRequestInterested;
use App\Models\Customer;
use App\Models\Product_Transfer;
use App\Models\Customer_Portfolio;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;
use PhpParser\Node\Stmt\Return_;
use App\Models\Product_Transfer_Detail;

class CommercialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function findOpportunities()
    {
        $user = Auth::user();
        $role = $user->permission->code;
        $customer = $user->workplace->aContract->aCustomer->id;

        if ($role != 'ADMINISTRADOR') {
            return response()->json(['code' => 403, 'message' => 'No Autorizado'], 403);
        }

        $opportunities = DB::table('customer_portfolio')
            ->join('product', 'product.id', '=', 'customer_portfolio.product')
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->join('pharmaceutical_unit', 'pharmaceutical_unit.product', '=', 'product.id')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('labeling_request', 'labeling_request.id', '=', 'pharmaceutical_unit.labeling_request')
            ->join('facility', 'facility.id', '=', 'labeling_request.facility')
            ->join('contract', 'contract.id', '=', 'facility.contract')
            ->join('customer', function ($join) {
                $join->on('customer.id', '=', 'contract.customer');
                $join->on('customer.id', '=', 'customer_portfolio.customer');
            })
            ->select(
                'customer_portfolio.id as portfolio',
                'customer_portfolio.customer',
                'customer_portfolio.internal_product_id as external',
                'product.id AS product',
                'product.name',
                'product.record_number',
                'product.cum_sequence',
                'expiration_date',
                'batch',
                'price',
                DB::raw('COUNT(*) as available')
            )
            ->whereDate('sanitary_registration.expiration', '>', Carbon::today())
            ->whereDate('pharmaceutical_unit.expiration_date', '>', Carbon::today())
            ->where('sanitary_registration.registration_status', '=', 1)
            ->where('pharmaceutical_unit.unit_status', '=', 0)
            ->where('tag.tag_status', '=', 1)
            ->where('pharmaceutical_unit.tag', '<>', null)
            ->where('customer_portfolio.price', '<>',  null)
            ->where('customer.id', '<>',  $customer)
            ->groupBy('customer_portfolio.id', 'customer', 'product', 'product.name', 'product.record_number', 'product.cum_sequence', 'price', 'expiration_date', 'batch')
            ->orderBy('product');

        $data = DB::table('customer_portfolio')
            ->rightJoinSub($opportunities, 'opportunity', function ($join) use ($customer) {
                $join->on('opportunity.product', '=', 'customer_portfolio.product');
                $join->where('customer_portfolio.customer', '=', $customer);
            })
            ->select(
                'opportunity.portfolio',
                'opportunity.customer',
                'external',
                'customer_portfolio.internal_product_id as internal',
                'opportunity.product',
                'name',
                'record_number',
                'cum_sequence',
                'expiration_date',
                'batch',
                'opportunity.price AS external_price',
                'customer_portfolio.price AS internal_price',
                'available'
            )
            ->get();

        return view('commercialShowcase')->with(['user' => $user, 'products' => $data]);
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

    public function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    public function findAvailables()
    {

        $user = Auth::user();
        $role = $user->permission->code;
        $customer = $user->workplace->aContract->aCustomer->id;

        if ($role != 'ADMINISTRADOR') {
            return response()->json(['code' => 403, 'message' => 'No Autorizado'], 403);
        }
        DB::statement(DB::raw('SET @rownum = 0'));

        $available = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->join('labeling_request', 'labeling_request.id', '=', 'pharmaceutical_unit.labeling_request')
            ->join('facility', 'facility.id', '=', 'labeling_request.facility')
            ->join('contract', 'contract.id', '=', 'facility.contract')
            ->join('customer', 'customer.id', '=', 'contract.customer')
            ->join('customer_portfolio', function ($join) {
                $join->on('product.id', '=', 'customer_portfolio.product');
                $join->on('pharmaceutical_unit.product', '=', 'customer_portfolio.product');
                $join->on('customer.id', '=', 'customer_portfolio.customer');
            })
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->select(
                'product.name',
                'product.id',
                'customer_portfolio.id as portfolio',
                'customer_portfolio.internal_product_id',
                'pharmaceutical_unit.expiration_date',
                'sanitary_registration.invima_code',
                'pharmaceutical_unit.batch',
                DB::raw('COUNT(*) as available'),
                DB::raw("@rownum := @rownum + 1 as rownum")
            )
            ->whereDate('sanitary_registration.expiration', '>', Carbon::today())
            ->whereDate('pharmaceutical_unit.expiration_date', '>', Carbon::today())
            ->where('sanitary_registration.registration_status', '=', 1)
            ->where('pharmaceutical_unit.unit_status', '=', 0)
            ->where('tag.tag_status', '=', 1)
            ->where('pharmaceutical_unit.tag', '<>', null)
            ->where('customer_portfolio.customer', '=', $customer)
            ->groupBy('internal_product_id', 'customer_portfolio.id', 'product.id', 'name', 'invima_code', 'expiration_date', 'batch')
            ->get();

        return response()->json($available);
    }
    //completar informacion en modal detalle de transaccion
    public function autocompleteModaltransaction(Request $request)
    {

        $user = Auth::user();
        $role = $user->permission->code;

        $customer = $user->workplace->aContract->aCustomer->id;

        if ($role != 'ADMINISTRADOR') {
            return  response()->json([]);
        }

        $portfolio = $request->input('portfolio');

        $data = DB::table('product')
            ->join('customer_portfolio', 'customer_portfolio.product', '=', 'product.id')
            //->leftjoin('contract', 'contract.customer', '=', 'customer.id')
            //->leftjoin('facility', 'facility.contract', '=', 'contract.id')
            ->leftjoin('device', 'device.id', '=', 'product.id')
            ->leftjoin('drug', 'drug.id', '=', 'product.id')
            ->leftjoin('content_unit', 'content_unit.id', '=', 'drug.content_unit')
            ->leftjoin('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->select(
                "customer_portfolio.price",
                "product.name as productName",
                "customer_portfolio.internal_product_id as internal",
                "content_unit.description as content_unit",
                "product.record_number",
                "constraint_status",
                "sanitary_registration.invima_code as sanitary",
                "sanitary_registration.expiration as expiration_register",
                "customer_portfolio.internal_product_id as internal",
                "product.cum_sequence as cum",
                DB::raw('CASE WHEN product.cum_status = 1 THEN \'Inactivo\'
                WHEN product.cum_status = 0 THEN \'Activo\' END as cum_status'),
                DB::raw('CASE WHEN sanitary_registration.registration_status = 1 THEN \'Vigente\' 
            WHEN sanitary_registration.registration_status = 2 THEN \'En tramite de renovación\' 
            WHEN sanitary_registration.registration_status = 3 THEN \'Desistido\'
            WHEN sanitary_registration.registration_status = 4 THEN \'Perdida de fuerza ejecutiva\'
            WHEN sanitary_registration.registration_status = 5 THEN \'Temporalmente no comercial\'
            WHEN sanitary_registration.registration_status = 6 THEN \'Vencido\'
            WHEN sanitary_registration.registration_status = 7 THEN \'Negado\' END AS registration_status')
            )
            ->where("customer_portfolio.id", $portfolio)
            ->first();


        //avalible cantidad de unidades disponibles para agregar

        return response()->json($data);
    }


    //Rellena los datos en producto a tranferir NO SE USARA
    public function autocompleteProduct(Request $request)
    {
        $user = Auth::user();
        $role = $user->permission;
        $facility = $user->facility;
        $customer = $role->customer;

        $data = DB::table('customer_portfolio')
            ->join('customer', 'customer.id', '=', 'customer_portfolio.customer')
            ->join('contract', 'contract.customer', '=', 'customer.id')
            ->join('facility', 'facility.contract', '=', 'contract.id')
            ->join('product', 'product.id', '=', 'customer_portfolio.product')
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->select(
                "content_unit.description as content_unit",
                "product.record_number",
                "customer_portfolio.product",
                "product.name",
                "constraint_status",
                "sanitary_registration.invima_code as sanitary",
                "sanitary_registration.expiration as expiration_register",
                "customer_portfolio.internal_product_id as internal",
                "product.cum_sequence as cum",
                DB::raw('COUNT(*) as availableTranfer'),
                DB::raw('CASE WHEN product.cum_status = 1 THEN \'Inactivo\'
                WHEN product.cum_status = 0 THEN \'Activo\' END as cum_status'),
                DB::raw('CASE WHEN sanitary_registration.registration_status = 1 THEN \'Vigente\' 
            WHEN sanitary_registration.registration_status = 2 THEN \'En tramite de renovación\' 
            WHEN sanitary_registration.registration_status = 3 THEN \'Desistido\'
            WHEN sanitary_registration.registration_status = 4 THEN \'Perdida de fuerza ejecutiva\'
            WHEN sanitary_registration.registration_status = 5 THEN \'Temporalmente no comercial\'
            WHEN sanitary_registration.registration_status = 6 THEN \'Vencido\'
            WHEN sanitary_registration.registration_status = 7 THEN \'Negado\' END AS registration_status')
            )
            ->where('customer_portfolio.customer', '=', $customer)
            ->where('facility.id', $facility)
            ->where("product.name", "LIKE", "{$request->input('query')}%")
            ->groupBy("content_unit.description", "product.record_number", "customer_portfolio.product", "product.name", "constraint_status", "sanitary_registration.invima_code", "sanitary_registration.expiration", "customer_portfolio.internal_product_id", "product.cum_sequence")
            ->get();

        return $data;
    }
}
