<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table            = 'products';
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
        if(isset($data['id'])){
            $data['data']->plans = $this->builder('plans')
                ->where(['product_id' => $data['id']])
                ->orderBy('position', 'ASC')
                ->get()->getResult();

            $data['data']->harvests = $this->builder('harvests')
                ->where(['product_id' => $data['id']])
                ->orderBy('position', 'ASC')
                ->get()->getResult();
        }else{
            foreach($data as $banner) {
                if(isset($banner->id)){
                    $banner->plans = $this->builder('plans')
                        ->where(['product_id' => $banner->id])
                            ->orderBy('position', 'ASC')
                            ->get()->getResult();

                    $banner->harvests = $this->builder('harvests')
                        ->where(['product_id' => $banner->id])
                            ->orderBy('position', 'ASC')
                            ->get()->getResult();
                }
            }
        }
        return $data;
    }
}
