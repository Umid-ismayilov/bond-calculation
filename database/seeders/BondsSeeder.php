<?php

namespace Database\Seeders;

use App\Models\Bond;
use Illuminate\Database\Seeder;

class BondsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $data =
            [
                [
                    "name"=>'SOCAR ISTIQRAZ',
                    "nominal_price"=>1000,
                    "coupon_pay_interval"=>4,
                    "percent_calculating_period"=>360,
                    "coupon_percent"=>5.10,
                    "currency"=>'AZN',
                    "emission_date"=>"2022-06-06",
                    "turnover_date"=>"2024-06-06",
                    "created_at"=>now(),
                ],
                [
                    "name"=>'ADSIZ ISTIQRAZ',
                    "nominal_price"=>2000,
                    "currency"=>'AZN',
                    "coupon_pay_interval"=>2,
                    "percent_calculating_period"=>364,
                    "coupon_percent"=>6,
                    "emission_date"=>"2022-01-01",
                    "turnover_date"=>"2024-01-01",
                    "created_at"=>now(),
                ],
                [
                    "name"=>'AZ ISTIQRAZ',
                    "nominal_price"=>1000,
                    "currency"=>'AZN',
                    "coupon_pay_interval"=>4,
                    "percent_calculating_period"=>364,
                    "coupon_percent"=>8,
                    "emission_date"=>"2022-01-01",
                    "turnover_date"=>"2027-01-01",
                    "created_at"=>now(),
                ]
            ];
        Bond::insert($data);

    }
}
