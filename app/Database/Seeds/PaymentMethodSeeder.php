<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $payment_methods = [
            ['name' => 'Contado', 'code' => 'Co'],
            ['name' => 'Crédito', 'code' => 'Cr'],
        ];
        $pm_model = new PaymentMethod();
        foreach ($payment_methods as $key => $payment_method) {
            $pm_model->save($payment_method);
        }
    }
}
