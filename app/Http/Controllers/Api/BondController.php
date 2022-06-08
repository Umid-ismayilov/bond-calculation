<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Order;
use App\Services\CalculationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BondController extends Controller
{

    public function getPayDate(Bond $bond)
    {
        $calculation = new CalculationServices();
        $dates =  $calculation->getBondDates($bond);
        return response()->json($dates,200);
    }

    public function createBondOrder(Request $request,Bond $bond)
    {
        $validator = Validator::make($request->all(), [
            'quantity'   => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg'=>$validator->errors()],422);
        }
        if($bond && $bond->emission_date<=now() && $bond->turnover_date>now()){
            $order = new Order();
            $order->quantity    = $request->quantity;
            $order->user_id     = 1;
            $order->bond_id     = $bond->id;
            $order->order_date  = date('Y-m-d');
            $order->save();
            return response()->json(['msg'=>'Uğurla əlavə edildi'],200);
        }
        return response()->json(['msg'=>'İstiqrazin tapılmadı'],404);

    }

    public function getOrderPayments(Order $order)
    {
        $calculation = new CalculationServices();
        $dates =  $calculation->getOrderPayments($order);
        return response()->json($dates,200);
    }



}
