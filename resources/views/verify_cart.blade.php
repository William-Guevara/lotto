@extends('start')

@section('content')

<section id="seccion_data" class="seccion_data">
    <div class="section-title">
        <h2 data-aos="fade-up">Verify cart</h2>
    </div>
    <div class="container">
        {{--Tabla en modal Productos a tranferir--}}
        <div id="table" style="width: 100%" class="table-responsive">
            <table id="tableCart" style="width: 100%" class="display table table-striped table-hover">
                <colgroup>
                    <col style="width: 30%">
                    <col style="width: 40%">
                    <col style="width: 10%">
                    <col style="width: 15%">
                    <col style="width: 10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        {{--Fin Tabla en modal--}}



        <p class="display_label" style="font-weight:bold;"><span>Total:</span> US ${!! $data_external['total'] !!}</p>

        @if ($user_data['credits'] > 0) {
        <p class="display_label" style="font-weight:bold;"><span>Credito en la cuenta:</span> US ${!!
            $data_external['credits'] !!}</p>
        <p class="display_label" style="font-weight:bold;"><span>Pago en creditos:</span> US ${!!
            $data_external['credits_payment'] !!}</p>
        <p class="display_label" style="font-weight:bold;"><span>Pago en dinero:</span> US ${!!
            $data_external['money_payment'] !!}</p>
        @endif


        <form name="forward_authorizenet" id="forward_authorizenet" action="{!! $data_external['url'] !!}"
            method="post">
            <input type='hidden' name='x_login' value="{!! $data_external['loginID'] !!}" />
            <input type='hidden' name='x_fp_sequence' value="{!! $data_external['sequence'] !!}" />
            <input type='hidden' name='x_fp_timestamp' value="{!! $data_external['timeStamp'] !!}" />
            <input type='hidden' name='x_fp_hash' value="{!! $data_external['fingerprint'] !!}" />
            <input type='hidden' name='x_test_request' value="{!! $data_external['testMode'] !!}" />
            <input type='hidden' name='x_show_form' value="{!! $data_external['PAYMENT_FORM'] !!}" />
            <input type='hidden' name='x_relay_response' value='TRUE' />
            <input type='hidden' name='x_relay_url' value='http://loteriasmillonarias.com/verifyTransaction' />

            <input type='hidden' name='x_amount' value="{!! $data_external['amount'] !!}" />
            <input type='hidden' name='x_description' value="{!! $data_external['description'] !!}" />
            <input type='hidden' name='x_invoice_num' value="{!! $data_external['invoice'] !!}" />
            <input type='hidden' name='vc_description'
                value=" {!! md5('LOTORENE' .$data_external['description']) !!}" />
            <input type='hidden' name='credits' value="{!! $data_external['credits_payment'] !!}" />
            <input type='hidden' name='vc_credits'
                value=" {!! md5('LOTORENE' . $data_external['credits_payment']) !!}" />
            <input type='hidden' name='x_cust_id' value="{!! $user_data->user_id !!}" />
            <input type='hidden' name='x_email' value="{!! $user_data->email !!}" />
            <input type='hidden' name='x_company' value="{!! $user_data->company !!}" />
            <input type='hidden' name='x_first_name' value="{!! $user_data->fname !!}" />
            <input type='hidden' name='x_last_name' value="{!! $user_data->lname !!}" />
            <input type='hidden' name='x_address' value="{!! $user_data->address !!}" />
            <input type='hidden' name='x_city' value="{!! $user_data->city !!}" />
            <input type='hidden' name='x_state' value="{!! $user_data->state !!}" />
            <input type='hidden' name='x_country' value="{!! $user_data->country !!}" />
            <input type='hidden' name='x_zip' value="{!! $user_data->zip_code !!}" />
            <input type='hidden' name='x_phone' value="{!! $user_data->phone !!}" />
            <input type='hidden' name='x_fax' value="{!! $user_data->fax !!}" />
            <input type='hidden' name='x_ship_to_first_name' value="{!! $user_data->fname !!}" />
            <input type='hidden' name='x_ship_to_last_name' value="{!! $user_data->lname !!}" />
            <input type='hidden' name='x_ship_to_address' value="{!! $user_data->address !!}" />
            <input type='hidden' name='x_ship_to_city' value="{!! $user_data->city !!}" />
            <input type='hidden' name='x_ship_to_state' value="{!! $user_data->state !!}" />
            <input type='hidden' name='x_ship_to_country' value="{!! $user_data->country !!}" />
            <input type='hidden' name='x_ship_to_zip' value="{!! $user_data->zip_code !!}" />

            @if ($user_data['credits_payment'] > $user_data['money_payment'])
            <div class="text-center">
                <p style="background-color:#9d1c17;color:white;text-align:center;">
                    Click below to complete the payment for these items using your account credits.
                </p>
                <label>
                    <input type="submit" name="button" id="button" class="btn btn-lg btn-success"
                        value="Complete Payment Using Credits" />
                </label>
                @else
                <label>
                    <input type="submit" name="button" id="button" class="btn btn-lg btn-success"
                        value="Continue To Secure Payment" />
                </label>
            </div>
            @endif
        </form>
    </div>
</section>

@endsection

@section('scripts')

@endsection