<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ["functionAfterFind"];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function functionAfterFind(array $data){
        
        log_message("info", "Despues de encontrar movimientos: ". json_encode($data));
        if(isset($data['id'])){
            $data['data']->beneficiaries = $this->builder('beneficiaries')
                ->where([
                    'customer_id'   => $data['id'],
                    'state_id'      => 1
                ])->get()->getResult();
        }else{
            if(!empty($data['data'])){
                foreach($data['data'] as $customer){
                    if(isset($customer->id)){
                        $customer->beneficiaries = $this->builder('beneficiaries')
                            ->where([
                                'customer_id'   => $customer->id,
                                'state_id'      => 1
                            ])->get()->getResult();
                    }
                }
            }
        }
        return $data;
    }
}
