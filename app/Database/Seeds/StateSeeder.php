<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\State;

class StateSeeder extends Seeder
{
    public function run()
    {
        $states = [
            array('name' => 'Activo','option_state' => 'Activar','icon' => 'ri-check-double-line','background' => 'green lighten-5','font' => 'text-green text-darken-5','code' => 'Default'),
            array('name' => 'Inactivo','option_state' => 'Inactivar','icon' => 'ri-close-circle-line','background' => 'orange lighten-5','font' => 'text-orange text-darken-5','code' => 'Default'),
            array('name' => 'Sin cargar','option_state' => NULL,'icon' => 'ri-information-line','background' => 'deep-orange lighten-5','font' => 'text-deep-orange text-darken-5','code' => 'Proyect'),
            array('name' => 'Cargado','option_state' => NULL,'icon' => 'ri-folder-check-line','background' => 'indigo lighten-5','font' => 'text-indigo text-darken-5','code' => 'Proyect'),
            array('name' => 'Finalizado','option_state' => NULL,'icon' => 'ri-calendar-check-fill','background' => 'green lighten-5','font' => 'text-green text-darken-5','code' => 'Proyect'),
            array('name' => 'Rechazado','option_state' => NULL,'icon' => 'ri-close-circle-line','background' => 'pink lighten-5','font' => 'text-pink text-darken-5','code' => 'Proyect'),
            array('name' => 'Cargado','option_state' => NULL,'icon' => NULL,'background' => 'indigo lighten-5','font' => 'text-indigo text-darken-5','code' => 'Load'),
            array('name' => 'Rechazado','option_state' => 'Rechazar','icon' => NULL,'background' => 'pink lighten-5','font' => 'text-pink text-darken-5','code' => 'Load'),
            array('name' => 'Pendiente','option_state' => 'Pendientes','icon' => 'ri-file-info-line','background' => 'orange lighten-5','font' => 'text-orange text-darken-5','code' => 'Sale'),
            array('name' => 'Pago','option_state' => NULL,'icon' => 'ri-money-dollar-circle-line','background' => 'green lighten-5','font' => 'text-green text-darken-5','code' => 'Sale'),
            array('name' => 'Rechazado','option_state' => 'Rechazar','icon' => 'ri-file-close-line','background' => 'pink lighten-5','font' => 'text-pink text-darken-5','code' => 'Sale'),
            array('name' => 'Aceptado','option_state' => NULL,'icon' => 'ri-money-dollar-circle-fill','background' => 'green darken-5','font' => 'text-white','code' => 'Payments'),
            array('name' => 'Rechazado','option_state' => 'Rechazar','icon' => 'ri-delete-back-2-line','background' => 'pink darken-5','font' => 'text-white','code' => 'Payments'),
            array('name' => 'Recolectado','option_state' => NULL,'icon' => 'ri-box-3-line','background' => 'blue darken-5','font' => 'text-white','code' => 'Harvest'),
            array('name' => 'Utilidades','option_state' => NULL,'icon' => 'ri-wallet-3-fill','background' => 'green darken-5','font' => 'text-white','code' => 'Harvest'),
            array('name' => 'Rechazado','option_state' => 'Rechazar','icon' => 'ri-close-circle-fill','background' => 'pink darken-5','font' => 'text-white','code' => 'Harvest'),
            array('name' => 'Pendiente','option_state' => NULL,'icon' => 'ri-information-2-fill','background' => 'orange lighten-5','font' => 'text-orange text-darken-5','code' => 'Utilities'),
            array('name' => 'Pago','option_state' => NULL,'icon' => 'ri-wallet-fill','background' => 'green lighten-5','font' => 'text-green text-darken-5','code' => 'Utilities'),
            array('name' => 'Rechazado','option_state' => 'Rechazar','icon' => 'ri-close-circle-line','background' => 'pink lighten-5','font' => 'text-pink text-darken-5','code' => 'Utilities')
          ];

        $s_model = new State();
        foreach ($states as $key => $state) {
            $s_model->save($state);
        }
    }
}
