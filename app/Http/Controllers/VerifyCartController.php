<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //ver carrito de compras en blade
    public function ShowCart()
    {
        $user_data = Auth::user();
        $cart = session()->get('cart');
        $data_external = [];
        //return $cart;
        if ($cart) {
            $total = 0;
            $description_cart = ' ';
            foreach ($cart as $car) {
                $total = $total + $car['total'];
                $description_cart .= "Cantidad:" . $car['quantity'] . ":" . $car['productName'] . "||";
            }

            //authorize.net settings
            $loginID = "3r3pPM55";
            $transactionKey = "78tegTL93742KSxu";

            $description = "LoteriasMillonarias.com:" . $description_cart;
            $testMode = "true";
            // By default, this sample code is designed to post to our test server for
            // developer accounts: https://test.authorize.net/gateway/transact.dll
            // for real accounts (even in test mode), please make sure that you are
            // posting to: https://secure.authorize.net/gateway/transact.dll
            //real link = https://secure.authorize.net/gateway/transact.dll
            $url = "https://test.authorize.net/gateway/transact.dll";
            // an invoice is generated using the date and time
            $invoice = $user_data->user_id . "T" . date('Ymd H:i:s');
            // a sequence number is randomly generated
            $sequence = rand(1, 1000);
            // a timestamp is generated
            $timeStamp = time();

            //Calculate Amount
            $credits = $user_data->credits;

            $credits_payment = min($total, $credits);
            if ($credits_payment >= $total) {
                $money_payment = 0;
                $url = "receipt_credits.php";
            } else {
                $money_payment = $total - $credits_payment;
            }

            $amount = (float) $money_payment;

            // The following lines generate the SIM fingerprint. PHP versions 5.1.2 and
            // newer have the necessary hmac function built in. For older versions, it
            // will try to use the mhash library.
            if (phpversion() >= '5.1.2') {
                $fingerprint = hash_hmac("md5", $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^",
                    $transactionKey);
            } else { $fingerprint = bin2hex(mhash(MHASH_MD5, $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^",
                $transactionKey));
            }

            $data_external = [
                'total' => $total,
                'credits' => $credits,
                'credits_payment' => $credits_payment,
                'money_payment' => $money_payment,
                'url' => $url,
                'loginID' => $loginID,
                'sequence' => $sequence,
                'timeStamp' => $timeStamp,
                'fingerprint' => $fingerprint,
                'testMode' => $testMode,
                'PAYMENT_FORM' => 'PAYMENT_FORM',
                'amount' => $amount,
                'description' => $description,
                'invoice' => $invoice,
                'description' => $description,
                'credits_payment' => $credits_payment,
            ];
            //return $data_external;
            return view('verify_cart')->with(['cart' => $cart, 'data_external' => $data_external, 'user_data' => $user_data]);
            return response()->json(array_values($cart));

        } else {
            response()->json([]);
            return view('verify_cart')->with(['cart' => $cart]);
        }

    }

    public function verifyTransaction(Request $request)
    {

        $flg = $request->input('flg');
        //$flg = "su";

        $error = "not";
        $response_code = 0;
        //$response_code = 1;
        $data_success = 0;
        $success = false;
        if (isset($flg)) {
            if ($flg == "su") {
                $success = true;
                session()->forget('cart');
            } else if ($flg == "error") {
                $error = "Error: Por favor, contactenos para completar su orden. <br />";
                return view('verify_transaction')->with(['error' => $error, 'response_code' => $response_code, 'data_success' => $data_success]);
            } else if ($flg == "error_duplicate") {
                $error = "Error: Esta orden existe en nuestra base de datos.  Es posible que usted fue a esta pagina mas de una vez.  Por favor contactenos si su orden no esta correcta en su cuenta.";
                return view('verify_transaction')->with(['error' => $error, 'response_code' => $response_code, 'data_success' => $data_success]);
            } else if ($flg == "error_gateway") {
                $error = "Error: Por favor, contactenos para completar su orden.<br />";
                return view('verify_transaction')->with(['error' => $error, 'response_code' => $response_code, 'data_success' => $data_success]);
            }

        }

        if ($success) {
            $response_code = $request->input('response_code');
            switch ($response_code) {
                case "1":
                case "4":
                    $invoice_num = $request->input('invoice_num');
                    $amount = $request->input('amount');
                    $credits = $request->input('credits');
                    $date = date("Y-m-d");

                    $data_success = [
                        'invoice_num' => $invoice_num,
                        'amount' => $amount,
                        'credits' => $credits,
                        'date' => $date
                    ];
                    break;
            }
        }

        return view('verify_transaction')->with(['error' => $error, 'response_code' => $response_code, 'data_success' => $data_success]);
    }

    public function clearCart()
    {
        session()->forget('cart');
        //session()->flush('cart');

        return response()->json(['message' => 'Cart deleted'], 200);
    }

}
