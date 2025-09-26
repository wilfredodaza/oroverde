<?php

namespace App\Controllers\Sistem;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\API\ResponseTrait;

use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\BeneficiariesMovement;
use App\Models\TypeMovement;
use App\Models\Project;
use App\Models\State;
use App\Models\Customer;
use App\Models\UnitProductive;
use App\Models\PaymentMethod;
use App\Models\Company;

use Mpdf\Mpdf;

class MovementsController extends BaseController
{

    use ResponseTrait;

    protected $dataTable;
    protected $c_model;
    protected $m_model;
    protected $p_model;
    protected $s_model;
    protected $md_model;
    protected $tm_model;
    protected $up_model;
    protected $pm_model;

    public function __construct(){
        $this->dataTable    = (object) [
            'draw'      => $_GET['draw'] ?? 1,
            'length'    => $length = $_GET['length'] ?? 10,
            'start'     => $start = $_GET['start'] ?? 1,
            'page'      => $_GET['page'] ?? ceil(($start - 1) / $length + 1)
        ];
        $this->columns = $_GET['columns'] ?? [];

        $this->m_model      = new Movement();
        $this->p_model      = new Project();
        $this->s_model      = new State();
        $this->c_model      = new Customer();
        $this->md_model     = new MovementDetail();
        $this->bm_model     = new BeneficiariesMovement();
        $this->tm_model     = new TypeMovement();
        $this->up_model     = new UnitProductive();
        $this->pm_model     = new PaymentMethod();
    }

    public function index($typeMovement)
    {
        $data = $this->tm_model
            ->select([
                'id', 'name as title', 'abbreviation'
            ])
            ->where(['abbreviation' => $typeMovement])->first();
        
        // return $this->respond($data);

        if(!empty($data)){
            // $data = (object)[
            //     'id'            => "",
            //     'title'         => "",
            //     'button'        => "",
            //     'form_filter'   => [],
            //     'form_crud'     => []
            // ];
    
            switch ($data->id) {
                case '1':
                    $states_load = $this->s_model->where(['code' => 'Load'])->findAll();
                    $customers = $this->c_model->findAll();
                    $unit_productives = $this->up_model->findAll();
                    $payment_methods = $this->pm_model->findAll();
                    $data->form_cruds = [
                        (object) [
                            'id'        => 'save-movement',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                // (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "1", "type" => "hidden"],
                                // (object) ["field" => "payment_method_id", "name" => "payment_method", "required" => true, "title" => "Metodo de Pago", "value" => "", "type" => "select", "options" => $payment_methods],
                                // (object) ["name" => "state", "required" => false, "title" => "", "value" => $states_load[0]->id, "type" => "hidden"],
                                
                                // (object) ["name" => "customer", "required" => true, "title" => "Cliente", "value" => "", "type" => "select", "options" => $customers, "onchange" => "changeCustomer(this.value)"],
                                // (object) ["name" => "beneficiaries", "required" => true, "title" => "Beneficiarios", "value" => "", "type" => "select_multiple", "options" => []],
                                // (object) ["field" => "project_id","name" => "project", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                                
                                // (object) ["field" => "date", "name" => "fecha", "required" => true, "title" => "Fecha Sembrado", "value" => "", "type" => "date"],
                                // (object) ["name" => "unit_productive", "required" => true, "title" => "Unidad Productiva", "value" => "", "type" => "select", "options" => $unit_productives],
                                (object) ["name" => "cantidad", "required" => true, "title" => "Cantidad", "value" => "", "type" => "number", 'placeholder' => ""]
                            ]
                        ]
                    ];
                    break;
                case '2':
                    $states = $this->s_model->where(['code' => 'Sale'])->findAll();
                    $states_payments = $this->s_model->where(['code' => 'Payments'])->findAll();
                    $customers = $this->c_model->findAll();
                    $unit_productives = $this->up_model->findAll();
                    $projects = $this->p_model->where([
                        'state_id'  => 4
                    ])->findAll();
                    $payment_methods = $this->pm_model->findAll();


                    $data->form_cruds = [
                        (object) [
                            'id'        => 'save-movement',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "2", "type" => "hidden"],
                                (object) ["name" => "unit_productive", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                                (object) ["name" => "state", "required" => false, "title" => "", "value" => "", "type" => "hidden", "options" => $states],
                                
                                (object) ["field" => "date", "name" => "fecha", "required" => true, "title" => "Fecha Compra", "value" => "", "type" => "date"],
                                
                                (object) ["field" => "customer_id", "name" => "customer", "required" => true, "title" => "Cliente", "value" => "", "type" => "select", "options" => $customers, "onchange" => "changeCustomer(this.value)"],
                                (object) ["field" => "beneficiarios", "name" => "beneficiaries", "required" => false, "title" => "Beneficiarios", "value" => "", "type" => "select_multiple", "options" => []],
                                (object) ["field" => "project_id", "name" => "project", "required" => true, "title" => "Proyecto", "value" => "", "type" => "select", "options" => $projects,  "onchange" => "changeProject(this.value)"],
                                
                                // (object) ["name" => "unit_productive", "required" => true, "title" => "Unidad Productiva", "value" => "", "type" => "select", "options" => []],
                                (object) ["name" => "cantidad", "required" => true, "title" => "Cantidad", "value" => "", "type" => "number", 'placeholder' => ""],
                                (object) ["field" => "percentage_discount", "name" => "discount", "required" => false, "title" => "% Descuento", "value" => "0", "type" => "number", 'placeholder' => ""],
                                (object) ["field" => "payment_method_id", "name" => "payment_method", "required" => true, "title" => "Metodo de Pago", "value" => "", "type" => "select", "options" => $payment_methods, "onchange" => "changeMethod(this.value)"],
                            ]
                        ],

                        (object) [ // Formulario Para Registrar Pago
                            'id'        => 'save-movement-payment',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "3", "type" => "hidden"],
                                (object) ["name" => "movement_reference", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                                (object) ["name" => "state", "required" => false, "title" => "", "value" => $states_payments[0]->id, "type" => "hidden", "options" => $states_payments],
                                (object) ["name" => "payment_method", "required" => false, "title" => "", "value" => $payment_methods[0]->id, "type" => "hidden"],
                                
                                (object) ["name" => "fecha", "required" => true, "title" => "Fecha Pago", "value" => "", "type" => "date"],
                                (object) ["name" => "valor", "required" => true, "title" => "Valor Pago", "value" => "", "type" => "number_float"],
                                (object) ["name" => "support", "required" => false, "title" => "Soporte", "value" => "", "type" => "input_file"],
                            ]
                        ]
                    ];
                    break;
                case '3':
                    $states_payments = $this->s_model->where(['code' => 'Payments'])->findAll();
                    $payment_methods = $this->pm_model->findAll();
                    $data->form_cruds = [
                        (object) [ // Formulario Para Registrar Pago
                            'id'        => 'save-movement',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "3", "type" => "hidden"],
                                (object) ["name" => "movement_reference", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                                (object) ["name" => "state", "required" => false, "title" => "", "value" => $states_payments[0]->id, "type" => "hidden", "options" => $states_payments],
                                (object) ["name" => "payment_method", "required" => false, "title" => "", "value" => $payment_methods[0]->id, "type" => "hidden"],
                                
                                (object) ["field" => "date", "name" => "fecha", "required" => true, "title" => "Fecha Pago", "value" => "", "type" => "date"],
                                (object) ["field" => "value", "name" => "valor", "required" => true, "title" => "Valor Pago", "value" => "", "type" => "number_float"],
                                (object) ["name" => "support", "required" => false, "title" => "Soporte", "value" => "", "type" => "input_file"],
                            ]
                        ]
                    ];
                    break;
                case '4':
                    $states = $this->s_model->like('code', $data->abbreviation)->findAll();
                    $projects = $this->p_model->where(['state_id' => 4])->findAll();
                    $projects = array_filter($projects, function($project) {
                        foreach ($project->movements as $movement) {
                            if ($movement->type_movement_id == 1 && $movement->state_id == 7) {
                                return true; // Mantener proyecto
                            }
                        }
                        return false; // Eliminar si no cumple
                    });

                    $data->form_cruds = [
                        (object) [
                            'id'        => 'save-movement',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "4", "type" => "hidden"],
                                (object) ["name" => "state", "required" => false, "title" => "", "value" => $states[0]->id, "type" => "hidden"],
                                
                                // (object) ["name" => "customer", "required" => true, "title" => "Cliente", "value" => "", "type" => "select", "options" => $customers, "onchange" => "changeCustomer(this.value)"],
                                // (object) ["name" => "beneficiaries", "required" => true, "title" => "Beneficiarios", "value" => "", "type" => "select_multiple", "options" => []],
                                (object) ["name" => "project", "required" => true, "title" => "Proyecto", "value" => "", "type" => "select", "options" => $projects],
                                
                                (object) ["name" => "fecha", "required" => true, "title" => "Fecha Cosecha", "value" => "", "type" => "date"],
                                (object) ["field" => "value", "name" => "valor", "required" => true, "title" => "Valor Cosecha", "value" => "", "type" => "number_float"],
                                (object) ["name" => "cantidad", "required" => true, "title" => "Cantidad", "value" => "", "type" => "number", 'placeholder' => ""],
                            ]
                        ]
                    ];
                    // return $this->respond($data);
                    break;
                case '5':
                    
                    // $states = $this->s_model->where(['code' => 'Utilities'])->findAll();
                    $states_payments = $this->s_model->where(['code' => 'Payments'])->findAll();
                    $payment_methods = $this->pm_model->findAll();
                    $data->form_cruds = [
                        (object) [ // Formulario Para Registrar Pago
                            'id'        => 'save-movement-payment',
                            'url'       => 'dashboard/movements/save',
                            'inputs'    => [
                                (object) ["name" => "type_movement", "required" => false, "title" => "", "value" => "3", "type" => "hidden"],
                                (object) ["name" => "movement_reference", "required" => false, "title" => "", "value" => "", "type" => "hidden"],
                                (object) ["name" => "state", "required" => false, "title" => "", "value" => $states_payments[0]->id, "type" => "hidden", "options" => $states_payments],
                                (object) ["name" => "payment_method", "required" => false, "title" => "", "value" => $payment_methods[0]->id, "type" => "hidden"],
                                
                                (object) ["name" => "fecha", "required" => true, "title" => "Fecha Pago", "value" => "", "type" => "date"],
                                (object) ["name" => "valor", "required" => true, "title" => "Valor Pago", "value" => "", "type" => "number_float"],
                                (object) ["name" => "support", "required" => false, "title" => "Soporte", "value" => "", "type" => "input_file"],
                            ]
                        ]
                    ];
                    break;
                
                default:
                    # code...
                    break;
            }
    
            return view('movements/index', [
                'data'  => $data
            ]);
        }
        return view('errors/html/error_404');
    }

    public function data($typeMovement){
        $return = (object) [
            'data'              => [],
            'draw'              => $this->dataTable->draw,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'post'              => $this->dataTable,
        ];
        $this->m_model->where([
            'movements.type_movement_id' => $typeMovement
        ])->orderBy('movements.id', 'DESC');

        switch ($typeMovement) {
            case '1': // Movimiento Cargue Inicial
            case '4': // Cargue de cosechas
                $count_data = $this->m_model->countAllResults(false);
                $data = $this->dataTable->length == -1 ? $this->m_model->findAll() : $this->m_model->paginate($this->dataTable->length, 'dataTable', $this->dataTable->page);
                $return->data = $data;
                $return->recordsTotal = $count_data;
                $return->recordsFiltered = $count_data;
                break;
            case '2': // Movimiento Venta
                $count_data = $this->m_model->countAllResults(false);
                $this->m_model->select([
                    'movements.*',
                    // 'IFNULL(SUM(m.value), 0) as total_',
                    '(movements.value - IFNULL(SUM(m.value), 0)) as total_x_payable'
                ])
                ->where([
                    // 'm.state_id' => 12
                ])
                    ->join('movements m', 'm.movement_id = movements.id and m.state_id != 13', 'left')
                    ->groupBy('movements.id');
                $data = $this->dataTable->length == -1 ? $this->m_model->findAll() : $this->m_model->paginate($this->dataTable->length, 'dataTable', $this->dataTable->page);
                $return->data = $data;
                $return->recordsTotal = $count_data;
                $return->recordsFiltered = $count_data;
                break;
            
            case '3': // Movimiento Pago / Abono
                $count_data = $this->m_model->countAllResults(false);
                $this->m_model->select([
                    'movements.*',
                    'm.resolution as resolution_reference',
                    'tm.name as type_movement_resolution_reference',
                ])
                // ->where([
                //     'm.value' => 12
                // ])3
                ->join('movements m', 'm.id = movements.movement_id', 'left')
                ->join('type_movements tm', 'tm.id = m.type_movement_id', 'left');
                $data = $this->dataTable->length == -1 ? $this->m_model->findAll() : $this->m_model->paginate($this->dataTable->length, 'dataTable', $this->dataTable->page);
                $return->data = $data;
                $return->recordsTotal = $count_data;
                $return->recordsFiltered = $count_data;
                break;
            
            case '5': // Utilidades
                if(session('user')->role_id != 1){
                    $this->m_model->where(['movements.customer_id' => session('user')->customer_id]);
                }

                $count_data = $this->m_model->countAllResults(false);
                $data = $this->dataTable->length == -1 ? $this->m_model->findAll() : $this->m_model->paginate($this->dataTable->length, 'dataTable', $this->dataTable->page);
                $return->data = $data;
                $return->recordsTotal = $count_data;
                $return->recordsFiltered = $count_data;
                break;
            
            default:
                # code...
                break;
        }
        return $this->respond($return);
    }

    public function save(){
        // try{
            $data = $this->request->getJson();
            if(!empty($data->support_file)){
                $fileData = base64_decode($data->support_file);
                $uploadPath = FCPATH . 'uploads/'; // => public/uploads/
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $newName = uniqid() . '_' . $data->support_name;
                $filePath = $uploadPath . $newName;
                file_put_contents($filePath, $fileData);
            }
            
            $movement = [
                'type_movement_id'  => $data->type_movement,
                'state_id'          => isset($data->state) && !empty($data->state) ? $data->state : null,
                'user_id'           => session('user')->id,
                'customer_id'       => isset($data->customer) && !empty($data->customer) ? $data->customer : null,
                'project_id'        => isset($data->project) && !empty($data->project) ? $data->project : null,
                'movement_id'       => isset($data->movement_reference) && !empty($data->movement_reference) ? $data->movement_reference : null,
                'payment_method_id' => isset($data->payment_method) && !empty($data->payment_method) ? $data->payment_method : 1,
                'percentage_discount'   => isset($data->discount) && !empty($data->discount) ? $data->discount : null,
                'value'             => isset($data->valor) && !empty($data->valor) ? $data->valor : 0,
                'date'              => isset($data->fecha) && !empty($data->fecha) ? $data->fecha : date('Y-m-d'),
                'support'           => isset($newName) ? $newName : null,
            ];

            switch ($data->type_movement) {
                case '1':
                    if($this->m_model->save($movement)){
                        
                        $movement_id = $this->m_model->insertID();

                        $movement_detail = [
                            'movement_id'           => $movement_id,
                            'state_id'              => 1,
                            'unit_productive_id'    => isset($data->unit_productive) && !empty($data->unit_productive) ? $data->unit_productive : null,
                            // 'unit_measurement_id'   => 2,
                            // 'value'                 => $data->seleccionado->value,
                            'quantity'              => $data->cantidad,
                        ];
                        
                        $unidad_productiva = $this->up_model->find($data->unit_productive);
                        $price = array_values(array_filter(
                            $unidad_productiva->price_ages,
                            fn($p) => $p->age == 0
                        ))[0] ?? null;

                        $movement_detail['unit_measurement_id'] = 2;
                        $movement_detail['value']               = $price->value;

                        $this->md_model->save($movement_detail);

                        $this->m_model->save([
                            'id'    => $movement_id,
                            'value' => (float) $data->cantidad * (float) $price->value,
                            'payable_amount' => (float) $data->cantidad * (float) $price->value,
                            'state_id'  => 7
                        ]);

                        $this->p_model->save([
                            'id' => $data->project,
                            'state_id' => 4
                        ]);
                    }
                    break;
                case '2':
                    if($this->m_model->save($movement)){
                        
                        $movement_id = $this->m_model->insertID();
        
                        $movement_detail = [
                            'movement_id'           => $movement_id,
                            'state_id'              => 1,
                            'unit_productive_id'    => isset($data->unit_productive) && !empty($data->unit_productive) ? $data->unit_productive : null,
                            // 'unit_measurement_id'   => 2,
                            // 'value'                 => $data->seleccionado->value,
                            'quantity'              => $data->cantidad,
                        ];

                        $project_load = $this->m_model->where([
                            'type_movement_id'  => 1,
                            'state_id'          => 7,
                            'project_id'        => $data->project
                        ])->first();

                        if(empty($project_load))
                            return $this->respond(['title' => 'Error de validación', 'error' => "No existe movimiento de cargue para el proyecto."], 500);

                        $unidad_productiva = $this->up_model
                            ->select([
                                'unit_productives.*',
                                'ua.name as unit_age',
                            ])
                            ->where([
                                'unit_productives.id' => $data->unit_productive
                            ])
                            ->join('unit_ages as ua', 'ua.id = unit_productives.unit_age_id', 'left')
                            ->first();

                        $data->unidad_productiva = $unidad_productiva;
                        $data->diferenciaPorUnidad = diferenciaPorUnidad($project_load->date, $data->fecha, $unidad_productiva->unit_age);
                        $seleccionado = seleccionarPriceAge($unidad_productiva, $project_load->date, $data->fecha);
                        $data->seleccionado = $seleccionado;
                        if(empty($data->seleccionado))
                            return $this->respond(['title' => 'Error de validación', 'error' => "No existe valor para la unidad productiva."], 500);
                        $movement_detail['unit_measurement_id'] = 2;
                        $movement_detail['value']               = $data->seleccionado->value;

                        $this->md_model->save($movement_detail);

                        $total = (float) $data->cantidad * (float) $data->seleccionado->value;
                        $payable_amount = $total;
                        if (!empty($data->discount)) {
                            $total -= $total * ((float) $data->discount / 100);
                        }

                        $this->m_model->save([
                            'id'                => $movement_id,
                            'value'             => $total,
                            'payable_amount'    => $payable_amount
                        ]);
                    }
                    break;
                case '3':
                    if(isset($data->movement_reference) && !empty($data->movement_reference)){
                        $movement_reference = $this->m_model->find($data->movement_reference);
                        $data->project = $movement_reference->project_id;
                    }
                    $movement['project_id'] = $data->project;
                    $movement['customer_id'] = isset($movement_reference->customer_id) && !empty($movement_reference->customer_id) ? $movement_reference->customer_id : null;
                    if($this->m_model->save($movement)){

                        switch ($movement_reference->type_movement_id) {
                            case '2':
                                $states = $this->s_model->where(['code' => 'Sale'])->findAll();
                                break;
                            case '5':
                                $states = $this->s_model->where(['code' => 'Utilities'])->findAll();
                                break;
                            
                            default:
                                # code...
                                break;
                        }

                        $movement_reference = $this->m_model
                            ->select([
                                'movements.*',
                                'movements.value as total_movement',
                                'IFNULL(SUM(m.value), 0) as total_payable'
                            ])
                            ->join('movements m', "m.movement_id = movements.id", 'left')
                            ->where([
                                'movements.id' => $data->movement_reference,
                                'm.state_id' => 12
                            ])
                            ->groupBy('movements.id')
                            ->first();

                        if($movement_reference->total_movement <= $movement_reference->total_payable){
                            $this->m_model->save([
                                'id'    => $movement_reference->id,
                                'state_id'  =>  $states[1]->id
                            ]);
                        }
                    }
                    break;
                case '4':
                    if($this->m_model->save($movement)){
                        $movement_id = $this->m_model->insertID();

                        $movement_detail = [
                            'movement_id'           => $movement_id,
                            'state_id'              => 1,
                            // 'unit_productive_id'    => isset($data->unit_productive) && !empty($data->unit_productive) ? $data->unit_productive : null,
                            // 'unit_measurement_id'   => 2,
                            // 'value'                 => $data->seleccionado->value,
                            'quantity'              => $data->cantidad,
                        ];

                        $project = $this->p_model->find($data->project);
                        $movement_load = null;
                        foreach ($project->movements as $movement) {
                            if ($movement->type_movement_id == 1 && $movement->state_id == 7) {
                                $movement_load = $movement;
                                break; // rompe en el primero que encuentre
                            }
                        }
    
                        $movement_detail['unit_productive_id'] = $movement_load->details[0]->unit_productive_id;
                        
                        $value_detail = (float) $data->valor / (int) $data->cantidad;
                        $movement_detail['value'] = $value_detail;
                        $movement_detail['unit_measurement_id'] = 1;
                        // return $this->respond([$movement_detail], 500);
                        $this->md_model->save($movement_detail);
                    }
                    break;
                case '5':

                    $project = $this->p_model->find($data->project);

                    $movement_load = $this->m_model->where([
                        'type_movement_id'  => 1,
                        'state_id !='       => 8
                    ])->first();

                    $movements_sales = $this->m_model->where([
                        'type_movement_id'  => 2,
                        'state_id !='       => 11,
                        'project_id'        => $data->project
                    ])->findAll();

                    $harvests = $this->m_model->whereIn('id', $data->harvest)->findAll();

                    $total_value = 0;
                    $total_quantity = 0;

                    foreach ($harvests as $key => $harvest) {
                        $total_value += (float) $harvest->value * ((float) $project->percentage_profit / 100);
                        $total_quantity += (int) $harvest->detail->quantity;
                    }

                    $value_individual = $total_value / $total_quantity;

                    foreach ($movements_sales as $key => $ms) {
                        $movement_save = [
                            'type_movement_id'  => $data->type_movement,
                            'state_id'          => 17,
                            'user_id'           => session('user')->id,
                            'customer_id'       => $ms->customer_id,
                            'project_id'        => isset($data->project) && !empty($data->project) ? $data->project : null,
                            // 'movement_id'       => isset($data->movement_reference) && !empty($data->movement_reference) ? $data->movement_reference : null,
                            // 'payment_method_id' => isset($data->payment_method) && !empty($data->payment_method) ? $data->payment_method : 1,
                            // 'percentage_discount'   => isset($data->discount) && !empty($data->discount) ? $data->discount : null,
                            'value'             => $value_individual * (float) $ms->detail->quantity,
                            'date'              => isset($data->fecha) && !empty($data->fecha) ? $data->fecha : date('Y-m-d'),
                            'support'           => isset($newName) ? $newName : null,
                        ];

                        if($this->m_model->save($movement_save)){
                            $movement_id = $this->m_model->insertID();
                            $movement_detail = [
                                'movement_id'           => $movement_id,
                                'state_id'              => 1,
                                'unit_productive_id'    => $ms->detail->unit_productive_id,
                                'unit_measurement_id'   => 1,
                                'value'                 => $value_individual,
                                'quantity'              => $ms->detail->quantity
                            ];
                            $this->md_model->save($movement_detail);
                        }
                    }

                    foreach ($data->harvest as $key => $harvest) {
                        $this->m_model->save([
                            'id'        => $harvest,
                            'state_id'  => 15
                        ]);
                    }

                    return $this->respond([
                        "movement_load" => $movement_load, "movements_sales" => $movements_sales, "harvest" => $harvest
                    ]);

                    foreach ($movements_sales as $key => $ms) {
                        
                    }
                    
                    $total_value = 0;
                    $total_quantity = 0;

                    foreach ($movements_harvest as $key => $movement) {
                        $total_value += (float) $movement->value;
                        $total_quantity += (int) $movement->detail->quantity;
                    }
                    $project = $this->p_model->find($data->project);

                    $value_porcentage = (float) $project->percentage_profit == 0 ? $total_value : $total_value * ((float) $project->percentage_profit / 100);
                    $value_unit = $value_porcentage / $movement_load->detail->quantity;

                    $data->total_value = $total_value;
                    $data->total_quantity = $total_quantity;
                    $data->value_porcentage = $value_porcentage;
                    $data->value_unit = $value_unit;

                    foreach ($movements_sales as $key => $movement) {
                        $movement_ = [
                            'type_movement_id'  => $data->type_movement,
                            'project_id'        => $data->project,
                            'state_id'          => 16,
                            'customer_id'       => $movement->customer_id,
                            'date'              => date('Y-m-d'),
                            'payment_method_id' => 1,
                            'value'             => (float) $value_unit * (int) $movement->detail->quantity,
                            'payable_amount'    => (float) $value_unit * (int) $movement->detail->quantity,
                            'user_id'           => session('user')->id
                        ];
                        if($this->m_model->save($movement_)){
                            $movement_id = $this->m_model->insertID();
                            $movement_detail = [
                                'movement_id'           => $movement_id,
                                'state_id'              => 1,
                                'unit_productive_id'    => $movement->detail->unit_productive_id,
                                'unit_measurement_id'   => 1,
                                'value'                 => $data->value_unit,
                                'quantity'              => $movement->detail->quantity
                            ];
                            $this->md_model->save($movement_detail);
                        }
                    }

                    $data->project = $project;
                    $data->movements_sales = $movements_sales;
                    $data->movements_harvest = $movements_harvest;
                    break;
                
                default:
        
                    
        
                    if($this->m_model->save($movement)){
                        $movement_id = $this->m_model->insertID();
        
                        $movement_detail = [
                            'movement_id'           => $movement_id,
                            'state_id'              => 1,
                            'unit_productive_id'    => isset($data->unit_productive) && !empty($data->unit_productive) ? $data->unit_productive : null,
                            // 'unit_measurement_id'   => 2,
                            // 'value'                 => $data->seleccionado->value,
                            'quantity'              => $data->cantidad,
                        ];
        
                        switch ($data->type_movement) {
                            case '1':
                                $proyecto = $this->p_model->find($data->project);
                                $unidad_productiva = $this->up_model->find($data->unit_productive);
                                $price = array_values(array_filter(
                                    $unidad_productiva->price_ages,
                                    fn($p) => $p->age == 0
                                ))[0] ?? null;
        
                                $movement_detail['unit_measurement_id'] = 2;
                                $movement_detail['value']               = $price->value;
        
                                $this->md_model->save($movement_detail);
        
                                $this->m_model->save([
                                    'id'    => $movement_id,
                                    'value' => (float) $data->cantidad * (float) $price->value,
                                    'payable_amount' => (float) $data->cantidad * (float) $price->value,
                                    'state_id'  => 7
                                ]);
        
                                $this->p_model->save([
                                    'id' => $data->project,
                                    'state_id' => 4
                                ]);
                                
                                break;
                            case '2':
                                
                                // $proyecto = $this->p_model->find($data->project);
                                $project_load = $this->m_model->where([
                                    'type_movement_id'  => 1,
                                    'state_id'          => 7,
                                    'project_id'        => $data->project
                                ])->first();

                                if(empty($project_load))
                                    return $this->respond(['title' => 'Error de validación', 'error' => "No existe movimiento de cargue para el proyecto."], 500);

                                $unidad_productiva = $this->up_model
                                    ->select([
                                        'unit_productives.*',
                                        'ua.name as unit_age',
                                    ])
                                    ->where([
                                        'unit_productives.id' => $data->unit_productive
                                    ])
                                    ->join('unit_ages as ua', 'ua.id = unit_productives.unit_age_id', 'left')
                                    ->first();

                                $data->unidad_productiva = $unidad_productiva;
                                $data->diferenciaPorUnidad = diferenciaPorUnidad($project_load->date, $data->fecha, $unidad_productiva->unit_age);
                                $seleccionado = seleccionarPriceAge($unidad_productiva, $project_load->date, $data->fecha);
                                $data->seleccionado = $seleccionado;
                                if(empty($data->seleccionado))
                                    return $this->respond(['title' => 'Error de validación', 'error' => "No existe valor para la unidad productiva."], 500);
        
                                $movement_detail['unit_measurement_id'] = 2;
                                $movement_detail['value']               = $data->seleccionado->value;
        
                                $this->md_model->save($movement_detail);
        
                                $total = (float) $data->cantidad * (float) $data->seleccionado->value;
                                $payable_amount = $total;
                                if (!empty($data->discount)) {
                                    $total -= $total * ((float) $data->discount / 100);
                                }
        
                                $this->m_model->save([
                                    'id'                => $movement_id,
                                    'value'             => $total,
                                    'payable_amount'    => $payable_amount
                                ]);
                                break;
                            case '3':
                                
                                break;
                            case '4':
                                $project = $this->p_model->find($data->project);
                                $movement_load = null;
                                foreach ($project->movements as $movement) {
                                    if ($movement->type_movement_id == 1 && $movement->state_id == 7) {
                                        $movement_load = $movement;
                                        break; // rompe en el primero que encuentre
                                    }
                                }
        
                                $movement_detail['unit_productive_id'] = $movement_load->details[0]->unit_productive_id;
                                
                                $value_detail = (float) $data->valor / (int) $data->cantidad;
                                $movement_detail['value'] = $value_detail;
                                $movement_detail['unit_measurement_id'] = 1;
                                $this->md_model->save($movement_detail);
        
        
                                break;
                            
                            default:
                                # code...
                                break;
                        }
        
                        if(isset($data->beneficiaries)){
                            foreach ($data->beneficiaries as $key => $beneficiary) {
                                $this->bm_model->save([
                                    'movement_id'       => $movement_id,
                                    'beneficiary_id'    => $beneficiary,
                                    'state_id'          => 1,
                                ]);
                            }
                        }
        
                    }
                    break;
            }

            return $this->respond($data);

        // }catch(\Exception $e){
		// 	return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		// }
    }

    public function update($id_movement){
        try{
            $data = $this->request->getJson();
            $movement = [
                'customer_id'           => isset($data->customer) && !empty($data->customer) ? $data->customer : null,
                'payment_method_id'     => isset($data->payment_method) && !empty($data->payment_method) ? $data->payment_method : null,
                'percentage_discount'   => isset($data->discount) && !empty($data->discount) ? $data->discount : 0,
                'value'                 => isset($data->valor) && !empty($data->valor) ? $data->valor : 0,
                'date'                  => isset($data->fecha) && !empty($data->fecha) ? $data->fecha : null,
            ];
            
            $movement = array_filter($movement, function($v) {
                return !is_null($v) && $v !== 0 && $v !== "0" && $v !== "0.00";
            });

            $save_movement = !empty($movement);
            if($save_movement){
                $movement['id'] = $id_movement;
                $this->m_model->save($movement);
            }

            $movimiento = $this->m_model->where(['id' => $id_movement])->first();
            $proyecto = $this->p_model->find($movimiento->project_id);

            switch ($movimiento->type_movement_id) {
                case '1':
                    $total = 0;
                    foreach ($data->details as $key => $detail) {
                        $detalle = $this->md_model->find($detail->id);
                        $movement_detail = [
                            'id'        => $detail->id,
                            'quantity'  => $detail->cantidad
                        ];
                        $this->md_model->save($movement_detail);
                        $total += (int) $detail->cantidad * (float) $detalle->value;
                    }
                    $this->m_model->save([
                        'id'                => $movimiento->id,
                        'value'             => $total,
                        'payable_amount'    => $total
                    ]);
                    break;
                
                case '4':
                    foreach ($data->details as $key => $detail) {
                        $movement_detail = [
                            'id'        => $detail->id,
                            'quantity'  => $detail->cantidad,
                            'value'     => (float) $data->valor / (int) $detail->cantidad
                        ];
                        $this->md_model->save($movement_detail);
                    }
                    break;
                
                
                default:
                    $total = 0;
    
                    foreach ($data->details as $key => $detail) {
                        $detalle = $this->md_model->find($detail->id);
                        $movement_detail = [
                            'id'        => $detail->id,
                            'quantity'  => $detail->cantidad
                        ];
    
                        if($movimiento->date != $data->fecha){
                            $unidad_productiva = $this->up_model
                                ->select([
                                    'unit_productives.*',
                                    'ua.name as unit_age',
                                ])
                                ->where([
                                    'unit_productives.id' => $detalle->unit_productive_id
                                ])
                                ->join('unit_ages as ua', 'ua.id = unit_productives.unit_age_id', 'left')
                                ->first();
    
                            $data->unidad_productiva = $unidad_productiva;
                            $data->diferenciaPorUnidad = diferenciaPorUnidad($proyecto->date, $data->fecha, $unidad_productiva->unit_age);
                            $seleccionado = seleccionarPriceAge($unidad_productiva, $proyecto->date, $data->fecha);
                            $data->seleccionado = $seleccionado;
    
                            $movement_detail['value'] = $data->seleccionado->value;
    
                        }else{
                            $movement_detail['value'] = $detalle->value;
                        }
    
                        $this->md_model->save($movement_detail);
    
                        $total += (float) $detail->cantidad * (float) $movement_detail['value'];
                    }
    
                    switch ($movimiento->type_movement_id) {
                        case '2':
                            # code...
                            $nuevos   = array_diff($data->beneficiaries, array_column($movimiento->beneficiarios, 'beneficiary_id'));
                            $eliminar = array_diff(array_column($movimiento->beneficiarios, 'beneficiary_id'), $data->beneficiaries);
            
                            // Insertar los nuevos
                            foreach ($nuevos as $beneficiary) {
                                $this->bm_model->save([
                                    'movement_id'       => $id_movement,
                                    'beneficiary_id'    => $beneficiary,
                                    'state_id'          => 1,
                                ]);
                            }
            
                            // Eliminar los que ya no están
                            foreach ($eliminar as $beneficiaryId) {
                                $this->bm_model
                                    ->where([
                                        'movement_id'    => $id_movement,
                                        'beneficiary_id' => $beneficiaryId
                                    ])
                                    ->delete();
                            }
                            $payable_amount = $total;
                            if (!empty($data->discount)) {
                                $total -= $total * ((float) $data->discount / 100);
                            }
            
                            $this->m_model->save([
                                'id'                => $id_movement,
                                'value'             => $total,
                                'payable_amount'    => $payable_amount
                            ]);
                            break;
                        case '3':
                            $movement_reference = $this->m_model
                                ->select([
                                    'movements.*',
                                    'movements.value as total_movement',
                                    'IFNULL(SUM(m.value), 0) as total_payable'
                                ])
                                ->join('movements m', 'm.movement_id = movements.id and m.state_id != 13', 'left')
                                ->where([
                                    'movements.id' => $movimiento->movement_id
                                ])
                                ->groupBy('movements.id')
                                ->first();
    
                            if($movement_reference->total_movement <= $movement_reference->total_payable){
                                $this->m_model->save([
                                    'id'    => $movement_reference->id,
                                    'state_id'  =>  10
                                ]);
                            }else{
                                $this->m_model->save([
                                    'id'    => $movement_reference->id,
                                    'state_id'  =>  9
                                ]);
                            }
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    break;
            }
            
            return $this->respond($data);
        }catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }

    public function decline($id_movement){
        try{
            $movement = $this->m_model->find($id_movement);
            $states = $this->s_model->like('code', $movement->type_movement->abbreviation)->findAll();
            $last_state = end($states);
            $this->m_model->save([
                'id'        => $id_movement,
                'state_id'  => $last_state->id
            ]);

            switch ($movement->type_movement->id) {
                case '3': 
                    $movement_reference = $this->m_model
                        ->select([
                            'movements.*',
                            'movements.value as total_movement',
                            'IFNULL(SUM(m.value), 0) as total_payable'
                        ])
                        ->join('movements m', 'm.movement_id = movements.id and m.state_id != 13', 'left')
                        ->where([
                            'movements.id' => $movement->movement_id
                        ])
                        ->groupBy('movements.id')
                        ->first();

                    if($movement_reference->total_movement <= $movement_reference->total_payable){
                        $this->m_model->save([
                            'id'    => $movement_reference->id,
                            'state_id'  =>  10
                        ]);
                    }else{
                        $this->m_model->save([
                            'id'    => $movement_reference->id,
                            'state_id'  =>  9
                        ]);
                    }

                    // $data->respond = $movement_reference;

                    break;
                
                default:
                    # code...
                    break;
            }
            
            // return $this->respond($movement_reference);
            return $this->respond([$movement, $states]);
        }catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }

    public function indicadores($typeMovement){
        try{

            $type_movement = $this->tm_model->find($typeMovement);
            $movements  = [];
            $states     = $this->s_model->like('code', $type_movement->abbreviation)->findAll();
            switch ($typeMovement) {
                case '2':
                    $movements = $this->m_model->select([
                        'movements.*',
                        // 'IFNULL(SUM(m.value), 0) as total_',
                        '(movements.value - IFNULL(SUM(m.value), 0)) as total_x_payable'
                    ])
                    ->where([
                        'movements.type_movement_id'  => $typeMovement
                    ])
                    ->join('movements m', 'm.movement_id = movements.id and m.state_id != 13', 'left')
                    ->groupBy('movements.id')->findAll();
                    break;
                case '3':
                    $movements = $this->m_model->select([
                        'movements.*',
                        'tm.name as type_movement_resolution_reference',
                    ])
                    ->where([
                        'movements.type_movement_id'  => $typeMovement,
                    ])
                    ->join('movements m', 'm.id = movements.movement_id', 'left')
                    ->join('type_movements tm', 'tm.id = m.type_movement_id', 'left')->findAll();
                    break;
                
                default:
                    $movements = $this->m_model
                    ->where([
                        'movements.type_movement_id'  => $typeMovement,
                    ])->findAll();
                    break;
            }
            
            return $this->respond([
                'data'      => $movements,
                'states'    => $states,
                "type"      => $type_movement->name,
                "type_m"    => $type_movement
            ]);
        }catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
    }

    public function contract($movement_id){
        $movement = $this->m_model->find($movement_id);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf = new Mpdf([
			'mode'          => 'utf-8',
			'format'        => 'Letter',
			"margin_left"   => 5,
			"margin_right"  => 5,
			"margin_top"    => 20,
			"margin_bottom" => 17,
			"margin_header" => 5
		]);

        $mpdf->SetHTMLHeader('
			<table width="100%">
				<tr>
					<td width="100%" align="center">Página <b>{PAGENO}</b> de <b>{nbpg}</b></td>
				</tr>
			</table>
        	<hr>
		');

        $c_model = new Company();

        $company = $c_model->find(1);

        // return $this->respond([$movement, $company]);
        $page = view('pdf/contract', [
            'movement'  => $movement,
            'company'   => $company,
            'title'     => "CONTRATO DE COMPRA Y VENTA DE FRUTOS O COSA FUTURA"
        ]);

        // print(FCPATH); die;
        $css = file_get_contents(FCPATH . 'pdf/contract.css');
        $inter = file_get_contents(FCPATH . 'pdf/inter.css');
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($inter, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($page);
        $mpdf->Output("contrato_{$movement->resolution}.pdf", 'I');
    }
}
