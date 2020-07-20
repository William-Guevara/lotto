<?php

namespace App\Http\Controllers;

use App\Mail\ProductRequest;
use App\Models\Customer;
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

class ShowcaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function sendMail()
	{
		
        $user = Auth::user();
        $workplace = $user->workplace;
		
		Mail::to('webmaster.esenco@gmail.com')
			->send(new ProductRequest($workplace));
	}


    public function findAvailables()
    {

        $user = Auth::user();
        $role = $user->permission->code;
        $customer = $user->workplace->aContract->aCustomer->id;

        if ($role != 'ADMINISTRADOR') {
            return response()->json(['code' => 403, 'message' => 'No Autorizado'], 403);
        }

        $available = DB::table('pharmaceutical_unit')
            ->join('tag', 'tag.id', '=', 'pharmaceutical_unit.tag')
            ->join('product', 'product.id', '=', 'pharmaceutical_unit.product')
            ->join('customer_portfolio', 'product.id', '=', 'customer_portfolio.product')
            ->join('sanitary_registration', 'sanitary_registration.id', '=', 'product.sanitary_registration')
            ->select(
                'customer_portfolio.internal_product_id',
                'product.name',
                'sanitary_registration.invima_code',
                'pharmaceutical_unit.expiration_date',
                'pharmaceutical_unit.batch',
                DB::raw('COUNT(*) as available')
            )
            ->whereDate('sanitary_registration.expiration', '>', Carbon::today())
            ->whereDate('pharmaceutical_unit.expiration_date', '>', Carbon::today())
            ->where('sanitary_registration.registration_status', '=', 1)
            ->where('pharmaceutical_unit.unit_status', '=', 0)
            ->where('tag.tag_status', '=', 1)
            ->where('pharmaceutical_unit.tag', '<>', null)
            ->where('customer_portfolio.customer', '=', $customer)
            ->groupBy('internal_product_id', 'name', 'invima_code', 'expiration_date', 'batch')
            ->get();

            return response()->json($available);
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
				'facility.id AS facility',
				'facility.name AS facilityName',
                'product.id AS product',
                'product.name',
                'product.record_number',
                'product.cum_sequence',
                'expiration_date',
                'batch',
                'price',
                DB::raw('COUNT(*) as avaiable')
            )
            ->whereDate('sanitary_registration.expiration', '>', Carbon::today())
            ->whereDate('pharmaceutical_unit.expiration_date', '>', Carbon::today())
            ->where('sanitary_registration.registration_status', '=', 1)
            ->where('pharmaceutical_unit.unit_status', '=', 0)
            ->where('tag.tag_status', '=', 1)
            ->where('pharmaceutical_unit.tag', '<>', null)
            ->where('customer_portfolio.price', '<>',  null)
            ->where('customer.id', '<>',  $customer)
            ->groupBy('customer', 'customer_portfolio.id', 'facility', 'facilityName', 'product', 'product.name', 'product.record_number', 'product.cum_sequence', 'price', 'expiration_date', 'batch')
            ->orderBy('product');

        $data = DB::table('customer_portfolio')
            ->rightJoinSub($opportunities, 'opportunity', function ($join) {
                $join->on('opportunity.product', '=', 'customer_portfolio.product');
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
                'avaiable'
            )
            ->where('customer_portfolio.customer', '=',  $customer)
            ->get();

        //return view('commercialShowcase')->with(['user' => $user, 'products' => $data]);
        //return response()->json($opportunities->get());
        return response()->json($data);
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

        //return response()->json($sql);
        return response()->json($data);
    }
}
