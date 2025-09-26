<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitProductive extends Model
{
    protected $table            = 'unit_productives';
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
        
        log_message("info", "Despues de encontrar unidad productiva: ". json_encode($data));
        if(isset($data['data']->id)){
            $data['data']->price_ages = $this->builder('price_ages')
                ->where([
                    'unit_productive_id' => $data['data']->id
                ])->get()->getResult();
        }else{
            if(!empty($data['data'])){
                foreach($data['data'] as $unidad_produciva){
                    log_message("info", "Encontrar detalle: ". json_encode($unidad_produciva));

                    if(isset($unidad_produciva->id)){
                        $unidad_produciva->price_ages = $this->builder('price_ages')
                            ->where([
                                'unit_productive_id' => $unidad_produciva->id
                            ])->get()->getResult();
                    }
                }
            }
        }
        return $data;
    }
}
