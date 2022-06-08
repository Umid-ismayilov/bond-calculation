<?php

namespace Database\Seeders;

use App\Models\Bond;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $data =
            [
                [
                    "user_id"   =>rand(1,100),
                    "bond_id"   =>1,
                    "quantity"  =>1,
                    "order_date"=>date('Y-m-d'),
                    "created_at"=>now(),
                ],
                [
                    "user_id"   =>rand(1,100),
                    "bond_id"   =>2,
                    "quantity"  =>3,
                    "order_date"=>date('Y-m-d'),
                    "created_at"=>now(),
                ],
                [
                    "user_id"   =>rand(1,100),
                    "bond_id"   =>3,
                    "quantity"  =>5,
                    "order_date"=>date('Y-m-d'),
                    "created_at"=>now(),
                ]
            ];
        Order::insert($data);
    }
}
