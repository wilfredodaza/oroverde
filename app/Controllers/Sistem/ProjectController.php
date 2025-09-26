<?php

namespace App\Controllers\Sistem;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\API\ResponseTrait;

use App\Models\Project;
use App\Models\State;
use App\Models\Customer;
use App\Models\UnitProductive;
use App\Models\PaymentMethod;

class ProjectController extends BaseController
{
    use ResponseTrait;

    protected $dataTable;
    protected $p_model;
    protected $s_model;
    protected $c_model;
    protected $pm_model;
    protected $up_model;

    public function __construct(){
        $this->dataTable    = (object) [
            'draw'      => $_GET['draw'] ?? 1,
            'length'    => $length = $_GET['length'] ?? 10,
            'start'     => $start = $_GET['start'] ?? 1,
            'page'      => $_GET['page'] ?? ceil(($start - 1) / $length + 1)
        ];
        $this->columns = $_GET['columns'] ?? [];

        $this->p_model      = new Project();
        $this->s_model      = new State();
        $this->c_model      = new Customer();
        $this->up_model     = new UnitProductive();
        $this->pm_model     = new PaymentMethod();
        $this->c_model->where(['state_id' => 1]);
        $this->up_model->where(['state_id' => 1]);
    }

    public function index(){
        $states_project = $this->s_model->where(['code' => 'Proyect'])->findAll();
        $states_load = $this->s_model->where(['code' => 'Load'])->findAll();
        $customers = $this->c_model->findAll();
        $unit_productives = $this->up_model->findAll();
        $unit_productives = array_filter($unit_productives, function($unit_productive) {
            foreach ($unit_productive->price_ages as $price_age) {
                if ((int) $price_age->age === 0 && (int) $price_age->value === 0) {
                    return false; // Eliminar si cumple
                }
            }
            return true; // Mantener este item
        });
        $payment_methods = $this->pm_model->findAll();

        $data = (object)[
            'title'         => "Proyectos",
            'button'        => "Agregar Proyecto",
            'form_filter'   => [],
            'form_cruds'    => [
                (object) [
                    'id'        => 'save-crud',
                    'url'       => 'dashboard/projects/save',
                    'inputs'    => [
                        (object) ["name" => "nombre", "required" => true, "title" => "Proyecto", "value" => "", "type" => "text"],
                        (object) ["name" => "fecha", "required" => true, "title" => "Fecha Inicio", "value" => "", "type" => "date"],
                        (object) ["name" => "utilidad", "required" => true, "title" => "% Utilidad", "value" => "", "type" => "number", 'placeholder' => "0.00"],
                        (object) ["name" => "finca", "required" => true, "title" => "Finca", "value" => "", "type" => "text"],
                        (object) ["name" => "year_project", "required" => true, "title" => "Años de vigencia", "value" => "", "type" => "number", 'placeholder' => "20"],
                        (object) ["name" => "ubicacion", "required" => false, "title" => "Ubicación", "value" => "", "type" => "text"],
                        (object) ["name" => "estado", "required" => false, "title" => "", "value" => $states_project[0]->id, "type" => "hidden"],
                        (object) ["name" => "proyecto", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                        ]
                    ],
                (object) [
                    'id'        => 'save-movement',
                    'url'       => 'dashboard/movements/save',
                    'inputs'    => [
                        (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "1", "type" => "hidden"],
                        (object) ["name" => "payment_method", "required" => true, "title" => "Metodo de Pago", "value" => "", "type" => "select", "options" => $payment_methods],
                        (object) ["name" => "state", "required" => false, "title" => "", "value" => $states_load[0]->id, "type" => "hidden"],
                        
                        // (object) ["name" => "customer", "required" => true, "title" => "Cliente", "value" => "", "type" => "select", "options" => $customers, "onchange" => "changeCustomer(this.value)"],
                        // (object) ["name" => "beneficiaries", "required" => true, "title" => "Beneficiarios", "value" => "", "type" => "select_multiple", "options" => []],
                        (object) ["name" => "project", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                        
                        (object) ["name" => "fecha", "required" => true, "title" => "Fecha Sembrado", "value" => "", "type" => "date"],
                        (object) ["name" => "unit_productive", "required" => true, "title" => "Unidad Productiva", "value" => "", "type" => "select", "options" => $unit_productives],
                        (object) ["name" => "cantidad", "required" => true, "title" => "Cantidad", "value" => "", "type" => "number", 'placeholder' => ""],
                    ]
                ],
            ]
        ];
        return view('projects/index', [
            'data'  => $data
        ]);
    }

    public function data(){
        $return = (object) [
            'data'              => [],
            'draw'              => $this->dataTable->draw,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'post'              => $this->dataTable,
        ];
        $count_data = $this->p_model->countAllResults(false);
        $this->p_model->orderBy('id', 'DESC');
        $data = $this->dataTable->length == -1 ? $this->p_model->findAll() : $this->p_model->paginate($this->dataTable->length, 'dataTable', $this->dataTable->page);
        $return->data = $data;
        $return->recordsTotal = $count_data;
        $return->recordsFiltered = $count_data;
        return $this->respond($return);
    }

    public function save(){
        try{
            $data = $this->request->getJson();
            
            $project = [
                'name'              => $data->nombre,
                'date'              => $data->fecha,
                'percentage_profit' => $data->utilidad,
                'farm'              => $data->finca,
                'ubication'         => $data->ubicacion,
                'state_id'          => $data->estado,
                'project_years'     => $data->year_project
            ];

            if(isset($data->proyecto) && !empty($data->proyecto)){
                $project['id']  = $data->proyecto;
            }

            $this->p_model->save($project);

            return $this->respond([
                'data'  => $data
            ]);

        }catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }

    public function kardex($id_project){
        $project = $this->p_model->find($id_project);

        $rules = [
            1 => [7],   // para type 1 aceptar estados 7 y 8
            2 => [9, 10],   // para type 2 aceptar estados 5 y 6
            // 3 => [9, 10],  // para type 3 aceptar estados 9 y 10
        ];

        $project->movements = array_values(array_filter($project->movements, function ($movement) use ($rules) {
            return isset($rules[$movement->type_movement_id]) 
                && in_array($movement->state_id, $rules[$movement->type_movement_id]);
        }));

        $kardex = 0;
        foreach ($project->movements as $key => $movement) {
            $movement->total = 0;
            foreach ($movement->details as $key => $detail) {
                switch ($movement->type_movement_id) {
                    case '1':
                        $movement->total += (int) $detail->quantity;
                        $kardex += (int) $detail->quantity;
                        break;
                    case '2':
                        $movement->total += (int) $detail->quantity;
                        $kardex -= (int) $detail->quantity;
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            $movement->kardex = $kardex;
        }
        
        return view('projects/kardex', [
            'project'   => $project 
        ]);
    }

    public function indicadores(){
        try {
            $projects = $this->p_model->findAll();
            $states = $this->s_model->where(['code' => 'Proyect'])->findAll();

            return $this->respond([
                "data"      => $projects,
                "states"    => $states,
                "type"      => "projects"
            ]);
        } catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }
}
