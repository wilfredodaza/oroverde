<?php

namespace App\Models;

use CodeIgniter\Model;

class Company extends Model
{
    protected $table            = 'companies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "type_document_id",
        "name",
        "number_nit",
        "dv",
        "origin",
        "business_number",
        "propierty",
        "issued",
        "ubication",
        "number_document",
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
        log_message("info", "Despues de encontrar company: ". json_encode($data));
        if(isset($data['id'])){
            $data['data']->type_document = $this->builder('type_documents')
                ->where([
                    'id' => $data['data']->type_document_id
                ])->get()->getResult()[0];
        }

        // var_dump($data); die;
        
        return $data;
    }
}
