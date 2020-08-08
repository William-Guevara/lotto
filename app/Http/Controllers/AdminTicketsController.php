<?php

namespace App\Http\Controllers;

use App\Mail\MessageAddTicket;
use App\Models\Ticket_Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class AdminTicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ShowPurchases(Request $request)
    {
        $user = Auth::user();

        $data = DB::table('order_products')
            ->join('orders', 'orders.order_id', '=', 'order_products.order_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->join('users', 'users.user_id', '=', 'orders.cust_id')
            ->select(
                DB::raw(
                    "CONCAT(users.fname,' ', users.lname) as name"),
                'quantity as total_tickets',
                DB::raw('(quantity*total_games_tp) as promised'),
                DB::raw('((quantity*total_games_tp) - (tickets_received)) as owed'),
                'users.user_id',
                'purchased_product_id',
                'products.category'
            )
            ->whereRaw('tickets_received < (quantity*total_games_tp)')
            ->where('orders.response_code', 1)
            ->orderBy('users.fname', 'asc')
            ->get();

        return view('adminTickets')->with(['purchases' => $data]);

    }

    public function AddTicket(Request $request)
    {
        $num = $request->input('num');
        $category = $request->input('category');
        $date = $request->input('date');
        $user_id = $request->input('user_id');
        $purchased_product_id = $request->input('purchased_product_id');
        //$hoy = date("Y-m-d");

        $sql = DB::table('ticket_images')
            ->where('drawing_date', $date)
            ->where('purchased_product_id', $purchased_product_id)
            ->exists();
        if ($sql) {
            $error = 'Already added data';
            return view('error')->with(['error' => $error]);
        }
        $query = DB::table('orders')
            ->join('order_products', 'order_products.order_id', '=', 'orders.order_id')
            ->join('products', 'products.product_id', '=', 'order_products.product_id')
            ->join('users', 'users.user_id', '=', 'orders.cust_id')
            ->select('purchased_product_id', 'cust_id as user_id', 'tickets_received', DB::raw('(quantity*total_games_tp) as promised'), 'quantity', 'total_games_tp', 'expiration_email', 'category', 'fname', 'lname', 'language', 'users.email as email', 'users.email2 as email2', DB::raw('DATE_FORMAT(completion_timestamp,"%m %e %Y") as date'), 'orders.order_id as order_id')
            ->whereRaw('(tickets_received<(quantity*total_games_tp))')
            ->where('products.category', $category)
            ->where('purchased_product_id', $purchased_product_id)
            ->first();

        $needed = min($query->quantity, ($query->promised - $query->tickets_received));
        $change = min($needed, $query->purchased_product_id);

        $rel = DB::table('order_products')
            ->select('tickets_received')
            ->where('purchased_product_id', $query->purchased_product_id)
            ->first();
        $total_add = $rel->tickets_received + $change;

        $varss = DB::table('order_products')
            ->where('purchased_product_id', $query->purchased_product_id)
            ->update(['tickets_received' => $total_add]);

        DB::table('ticket_images')
            ->join('order_products', 'order_products.purchased_product_id', 'ticket_images.purchased_product_id')
            ->where('ticket_images.purchased_product_id', '=', 'order_products.purchased_product_id')
            ->where('ticket_images.purchased_product_id', $query->purchased_product_id)
            ->where('ticket_images.drawing_date', $date)
            ->update(['ticket_images.current_ticket' => 'order_products.tickets_received']);

        //ORDEN DE COMPRA
        if ($_FILES['file_']['name'] != "") {
            //verificamos que el tamaño del archivo no supere el permitido

            $sizes = $_FILES['file_']['size'];
            $file_name = $_FILES['file_']['name'];
            $file_type = $_FILES['file_']['type'];
            $temp_file = $_FILES['file_']['tmp_name'];
            $archivo_binario = (file_get_contents($temp_file));

            $ticket = new Ticket_Images;
            $ticket->image_type = $file_type;
            $ticket->image = null;
            $ticket->src_image = null;
            $ticket->image_size = null;
            $ticket->drawing_date = $date;
            $ticket->purchased_product_id = $purchased_product_id;
            $ticket->num_tickets = $num;
            $ticket->current_ticket = 1;
            $ticket->save();
            if ($file_type == "image/jpeg") {
                $file_type = 'jpeg';
            } else
            if ($file_type == "image/jpg") {
                $file_type = 'jpg';
            } else
            if ($file_type == "image/JPG") {
                $file_type = 'JPG';
            } else
            if ($file_type == "image/pjpeg") {
                $file_type = 'pjpeg';
            } else
            if ($file_type == "image/x-png") {
                $file_type = 'png';
            } else
            if ($file_type == "image/png") {
                $file_type = 'png';
            }
            //actualizamos con la ruta utilizando el id como nombre de imagen
            $update = Ticket_Images::find($ticket->image_id);
            $update->src_image = 'images_tickets/' . $ticket->image_id . '.' . $file_type;
            $update->save();

            $file = Input::file('file_');
            $file->move(public_path() . '/images_tickets/', $ticket->image_id . '.' . $file_type);

            $msg = [
                'category' => $category,
                'order_id' => $purchased_product_id,
                'promised' => $query->promised,
                'received' => $total_add,
            ];
            Mail::to($query->email)->bcc('info@loteriasmillonarias.com')->send(new MessageAddTicket($msg));

            return redirect()->route('adminTickets');
        }
        return response()->json(['message' => 'Not file']);
    }

    //Ver tiketes initial
    public function ViewTicket(Request $request)
    {
        $data = 0;
        $validate = 0;
        return view('adminViewTickets')->with(['images' => $data, 'validate' => $validate]);
    }
    //Ver tiketes
    public function ViewTicketLoad(Request $request, $category, $drawing)
    {
        $validate = 1;
        if ($category == 'not') {
            $data = DB::table('orders')
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
                ->where('ticket_images.drawing_date', $drawing)
                ->get();

            return view('adminViewTickets')->with(['images' => $data, 'validate' => $validate]);
        }
        $data = DB::table('orders')
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
            ->where('products.category', $category)
            ->where('ticket_images.drawing_date', $drawing)
            ->get();

        return view('adminViewTickets')->with(['images' => $data, 'validate' => $validate]);

    }

}
