<?php

namespace App\Services;
use App\Models\Bond;
use Carbon\Carbon;
class CalculationServices
{
    private $orderd_date = null;
    public function getBondDates($bond)
    {
        $emission_date = new Carbon($bond->emission_date,'Asia/Baku');
        $turnover_date = new Carbon($bond->turnover_date,'Asia/Baku');
        $diff     = $turnover_date->diffInDays($emission_date);
        return $this->calculation($bond,$diff,$emission_date,$turnover_date,false,null);
    }

    public function getOrderPayments($order){
        $bond = Bond::find($order->bond_id);
//        $emission_date = new Carbon($bond->emission_date,'Asia/Baku');
        $turnover_date = new Carbon($bond->turnover_date,'Asia/Baku');
        $order_date    = new Carbon($order->order_date,'Asia/Baku');
        $datas = [];
        $diff     = $turnover_date->diffInDays($order_date);
        return $this->calculation($bond,$diff,$order_date,$turnover_date,true,$order);
    }

    private function calculation($bond,$diff,$start_date,$end_date,$amount=false,$order=null)
    {
        $this->orderd_date = $start_date;
        $datas = [];
        $interval = 1;
        $coupon_pay_interval = $bond->coupon_pay_interval;
        $periodic_days       = $this->periodicDays($bond);
        $i        = 0;

        while($interval < $diff) {
            $interval = $interval+$periodic_days;
            if($interval < $diff){
                    $newDay= $start_date->addDay($periodic_days);
//                  $datas[]['date'] = $this->weekOfDays($newDay)->isoFormat('dddd'); həftənin hansı günlərinə düşür
                    $datas[$i]['date']  = $this->weekOfDays($newDay)->format('Y-m-d');
                if($amount){
                    $datas[$i]['amount'] = $this->calculationAmount($bond,$order,$i,$datas);
                }

            }

            /** Tədavül tarixini tamam olduqda əgər müştəriyə son kupon ödənişi edilməyibsə
             * Müştəriyə qoyduqu sərmayəni və son ayının Kuponların ödən eyni vaxta ödənilir
             */

            elseif ($interval >= $diff && $coupon_pay_interval>0){
                $datas[$i]['date'] = $end_date->format('Y-m-d');
                if($amount){
                    $datas[$i]['amount'] = $this->calculationAmount($bond,$order,$i,$datas);
                }
            }
            $coupon_pay_interval--;
            $i++;
        }
     return $datas;
    }

    private function weekOfDays($day){

        $weekOfDay = $day->isoFormat('dddd');
        switch ($weekOfDay) {
            case 'Saturday':
                return $day->addDay(2); // Şənbə günüdürsə 2 gün sonra
            case 'Sunday':
                return $day->addDay(1); // Bazar günüdürsə 1 gün sonra
            default :
                return  $day;
        };
    }

    private function periodicDays($bond){

        switch ($bond->percent_calculating_period) {
            case 360:
                return 12 / $bond->coupon_pay_interval * 30;
            case 364:
                return 364 / $bond->coupon_pay_interval;
            case 365:
                return 12 / $bond->coupon_pay_interval * 30; //Ay olduqu üçün 30 vururam
        };
    }

    private function calculationAmount($bond,$order,$i,$datas){

        if($i==0) { // Birinci ödənişidirsə ... daha qısa yazmaq olardı amma men özüm uzun yazdım ki başa düşülən olsun
            $past_date  = new Carbon($order->order_date,'Asia/Baku'); // ““Sifariş tarixi””
            $pay_date   = new Carbon($datas[$i]['date'],'Asia/Baku'); // Növbəti faiz ödəniş günü
            $past_day   = $pay_date->diffInDays($past_date); // “Keçmiş gün sayı”
//                            $past_day = $periodic_days; //“Əslində birinci dəfə Keçmiş gün sayı ele $periodic_days beraber olur amma daha aydin olsun deye yuxarida yeniden hesabladim”
        }else{
            $past_date  = new Carbon($datas[$i-1]['date'],'Asia/Baku'); // “Öncəki faiz hesablama tarixi”
            $pay_date   = new Carbon($datas[$i]['date'],'Asia/Baku'); // Növbəti faiz ödəniş günü
            $past_day   = $pay_date->diffInDays($past_date); // “Keçmiş gün sayı”
        }

        $nominal_price  = $bond->nominal_price;
        $coupon_percent = $bond->coupon_percent;
        $percent_calculating_period = $bond->percent_calculating_period;
        $quantity       = $order->quantity;
        $total_percent = ($nominal_price/100*$coupon_percent)/$percent_calculating_period*$past_day*$quantity;
        return round($total_percent,3);

//        “Keçmiş gün sayı” = (07.02.2021 - 14.01.2021) = 24 gün.
//        Yığılmış faizlər = (Nominal Qiymət / 100 * Kupon faizi) / Faizlərin hesablanma
//        periodu * Keçmiş gün sayı * Sifariş sayı;

    }

}
