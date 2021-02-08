<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class SuscribtionController extends Controller
{
    public function test(){
        return "hello uya";
    }

    public function pago(Request $request){

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount'   => 1990,
                'currency' => 'usd'
            ));

            return response()->json([
                "status" => 201,
                "message" => "Cargo exitoso"
            ]);
        }catch (\Exception $e){
            return Response()->json([
                "status" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }
}
