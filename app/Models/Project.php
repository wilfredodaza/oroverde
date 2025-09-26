<?php

namespace App\Models;

use CodeIgniter\Model;

class Project extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'state_id',
        'name',
        'date',
        'percentage_profit',
        'farm',
        'ubication',
        'project_years'
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
        
        log_message("info", "Despues de encontrar movimientos: ". json_encode($data));
        if(isset($data['data']->id)){
            $data['data']->state = $this->builder('states')
                ->where([
                    'id' => $data['data']->state_id
                ])->get()->getResult()[0];

            $currentYear = date('Y');

            $data['data']->movements = $this->builder('movements')
                ->where('project_id', $data['data']->id)
                // ->groupStart()
                //     ->where('type_movement_id', 1)
                //     ->orGroupStart()
                //         ->where('type_movement_id', 4)
                //         ->where('YEAR(date)', $currentYear)
                //     ->groupEnd()
                // ->groupEnd()
                ->get()
                ->getResult();

            foreach ($data['data']->movements as $key => $movement) {
                $movement->details = $this->builder('movement_details')
                    ->where([
                        'movement_id' => $movement->id
                    ])->get()->getResult();

                $movement->state = $this->builder('states')
                    ->where([
                        'id' => $movement->state_id
                    ])->get()->getResult()[0];     

                $movement->type_movement = $this->builder('type_movements')
                    ->where([
                        'id' => $movement->type_movement_id
                    ])->get()->getResult()[0];
            }
        }else{
            if(!empty($data['data'])){
                foreach($data['data'] as $project){
                    if(isset($project->id)){
                        $project->state = $this->builder('states')
                            ->where([
                                'id' => $project->state_id
                            ])->get()->getResult()[0];

                        $project->movements = $this->builder('movements')
                            ->where([
                                'project_id' => $project->id
                            ])->get()->getResult();

                        foreach ($project->movements as $key => $movement) {
                            $movement->details = $this->builder('movement_details')
                                ->where([
                                    'movement_id' => $movement->id
                                ])->get()->getResult();
                        }
                    }
                }
            }
        }
        return $data;
    }
}
