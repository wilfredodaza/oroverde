<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeMovement extends Model
{
    protected $table            = 'type_movements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'state_id',
        'name',
        'abbreviation',
        'color',
        'code',
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ["functionAfterFind"];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function functionAfterFind(array $data){
        
        log_message("info", "Despues de encontrar tipos movimientos: ". json_encode($data));
        if(isset($data["data"]->id)){
            $data['data']->states = $this->builder('states')
                ->like('code', $data['data']->abbreviation)->get()->getResult();
        }else{
            if(!empty($data['data'])){
                foreach($data['data'] as $type_movement){
                    if(isset($type_movement->id)){
                        $type_movement->states = $this->builder('states')
                            ->where([
                                'code' => $type_movement->abbreviation
                            ])->get()->getResult();
                    }
                }
            }
        }
        return $data;
    }
}
