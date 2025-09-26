<?php

namespace App\Models;

use CodeIgniter\Model;

class Movement extends Model
{
    protected $table            = 'movements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_movement_id',
        'state_id',
        'user_id',
        'customer_id',
        'project_id',
        'movement_id',
        'payment_method_id',
        'percentage_discount',
        'payable_amount',
        'resolution',
        'value',
        'date',
        'support',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["functionBeforeInsert"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ["functionAfterFind"];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function functionBeforeInsert(array $data){

        $movement = $this->where([
            // 'farm_id'           => $data['data']['farm_id'],
            'type_movement_id'  => $data['data']['type_movement_id']
        ])->orderBy('id', 'DESC')->get()->getResult();

        $data['data']['resolution'] = empty($movement) ? 1 : (int) $movement[0]->resolution + 1;
        
        return $data;
    }

    protected function functionAfterFind(array $data){
        
        log_message("info", "Despues de encontrar movimientos: ". json_encode($data));
        if(isset($data['data']->id)){
            $data['data']->state = $this->builder('states')
                ->where([
                    'id' => $data['data']->state_id
                ])->get()->getResult()[0];

            $data['data']->type_movement = $this->builder('type_movements')
                        ->where([
                            'id' => $data['data']->type_movement_id
                        ])->get()->getResult()[0];

            $customer = $this->builder('customers')
                ->select([
                    'customers.*',
                    'td.name as type_document_name',
                    'td.abbreviation as type_document_abr',
                ])
                ->join('type_documents td', 'td.id = customers.type_document_id', 'left')
                ->where([
                    'customers.id' => $data['data']->customer_id
                ])->get()->getResult();
            $data['data']->customer = !empty($customer) ? $customer[0] : [];

            $detail = $this->builder('movement_details')
                ->select([
                    'movement_details.*',
                    'up.name as unit_productive',
                ])
                ->join('unit_productives up', 'up.id = movement_details.unit_productive_id', 'left')
                ->where([
                    'movement_id' => $data['data']->id
                ])->get()->getResult();

            $data['data']->type_movement = $this->builder('type_movements')
                ->where([
                    'id' => $data['data']->type_movement_id
                ])->get()->getResult()[0];

            $data['data']->detail = !empty($detail) ? $detail[0] : [];
            
            $data['data']->beneficiarios = $this->builder('beneficiaries_movements')
                    ->where([
                        'movement_id' => $data['data']->id
                    ])->get()->getResult();
        }else{
            if(!empty($data['data'])){
                foreach($data['data'] as $movement){

                    switch ($movement->type_movement_id) {
                        case '4':
                            $movement->utilities = $this->where([
                                'type_movement_id'  => 5,
                                'movement_id'       => $movement->id,
                                'state_id'          => 16
                            ])->get()->getResult();
                            break;
                        
                        default:
                            # code...
                            break;
                    }

                    if(isset($movement->id)){
                        $customer = $this->builder('customers')
                            ->where([
                                'id' => $movement->customer_id
                            ])->get()->getResult();

                        // $resolution = $this->builder('movements')
                        //     ->where([
                        //         'id' => $movement->movement_id
                        //     ])->get()->getResult();

                        $movement->customer = !empty($customer) ? $customer[0] : [];

                        $movement->state = $this->builder('states')
                            ->where([
                                'id' => $movement->state_id
                            ])->get()->getResult()[0];

                        $movement->type_movement = $this->builder('type_movements')
                            ->where([
                                'id' => $movement->type_movement_id
                            ])->get()->getResult()[0];

                        $movement->project = $this->builder('projects')
                            ->where([
                                'id' => $movement->project_id
                            ])->get()->getResult()[0];

                        $payment_method = $this->builder('payment_methods')
                            ->where([
                                'id' => $movement->payment_method_id
                            ])->get()->getResult();

                        $movement->payment_method = $payment_method ? $payment_method[0] : null;

                        $detail = $this->builder('movement_details')
                            ->select([
                                'movement_details.*',
                                'up.name as unit_productive',
                            ])
                            ->join('unit_productives up', 'up.id = movement_details.unit_productive_id', 'left')
                            ->where([
                                'movement_id' => $movement->id
                            ])->get()->getResult();

                        $movement->detail = !empty($detail) ? $detail[0] : [];

                        $movement->beneficiarios = $this->builder('beneficiaries_movements')
                                ->where([
                                    'movement_id' => $movement->id
                                ])->get()->getResult();

                        
                    }
                }
            }
        }
        return $data;
    }
}
