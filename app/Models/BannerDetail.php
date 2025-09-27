<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerDetail extends Model
{
    protected $table            = 'banners_details';
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
        if(isset($data['data']->id)){
            $data['data']->banner = $this->builder('banners')
            ->where(['id' => $data['data']->reference])
            ->get()->getResult()[0];
        }else{
            foreach($data as $banner) {
                if(isset($banner->id)){
                    $banner->details = $this->builder('banners_details')
                        ->where(['reference' => $banner->id])
                            ->orderBy('orden', 'ASC')
                            ->get()->getResult();
                }
            }
        }
        return $data;
    }
}
