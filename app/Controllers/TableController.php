<?php


namespace App\Controllers;


use App\Traits\Grocery;
use App\Models\Menu;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\ConfigPage;
use App\Models\Banner;
use App\Models\UnitProductive;
use App\Models\PriceAge;
use App\Models\Password;

class TableController extends BaseController
{
    use Grocery;

    private $crud;

    public function __construct()
    {
        $this->crud = $this->_getGroceryCrudEnterprise();
        // $this->crud->setSkin('bootstrap-v3');
        $this->crud->setLanguage('Spanish');
    }

    public function index($data)
    {
        $menu = new Menu();
        $component = $menu->where(['url' => $data, 'component' => 'table'])->first();



        if($component) {
            $this->crud->setTable($component->table);
            switch ($component->url) {
                case 'usuarios':
                    $this->crud->setActionButton('Algo mas que aqeullo', 'fa fa-bars', function ($row) {
                        return base_url(['table', 'info_creditos', $row->id]);
                    }, false);
                    
                    $this->crud->setFieldUpload('photo', 'assets/upload/images', '/assets/upload/images');
                    $this->crud->setRelation('role_id', 'roles', 'name');
                    $this->crud->displayAs([
                        'name'  => 'Nombre',
                        'photo' => 'Foto'
                    ]);
                    break;
                case 'users':
                    $this->crud->where(['role_id > ?' => 1]);
                    $this->crud->unsetDelete();
                    $this->crud->setFieldUpload('photo', 'assets/upload/images', '/assets/upload/images');
                    $this->crud->setRelation('role_id', 'roles', 'name', ['id > ?' => 1]);
                    $this->crud->displayAs([
                        'name'  => 'Nombre',
                        'photo' => 'Foto',
                        'username'  => 'Usuario',
                        'status'    => 'Estado',
                        'role_id'   => 'Rol'
                    ]);
                    $this->crud->unsetEditFields(['role_id', 'usuario']);
                    $this->crud->uniqueFields(['email', 'username']);
                    $this->crud->setActionButton('Avatar', 'fa fa-lock', function ($row) {
                        return base_url(['table', 'users', $row->id]);
                    }, false);
                    break;
                case 'menus':
                    $this->crud->setTexteditor(['description']);
                    break;
                case 'config_page':
                    $this->crud->displayAs([
                        'meta_description'  => 'Descripción',
                        'meta_keywords'     => 'Palabras claves',
                        'name_app'          => 'Titulo'
                    ]);
                    $c_model = new ConfigPage();
                    $config = $c_model->countAllResults();
                    if($config > 0){
                        $this->crud->unsetAdd();
                        $this->crud->unsetDelete();
                    }
                    break;
                case 'products':
                    $this->crud->displayAs([
                        'name'              => 'Nombre',
                        'description'       => 'Descripción',
                        'price'             => 'Precio',
                        'stock'             => 'Stock',
                        'sales_percentage'  => "% Venta",
                        'individual_value'  => 'Valor individual',
                        'ipc'               => 'Inflación Promedio',
                        'status'            => 'Estado'
                    ]);
                    $this->crud->unsetDelete();
                    $columns = [
                        'name', 'description', 'price', 'stock','sales_percentage',
                        'individual_value', 'ipc', 'status'];
                    $this->crud->columns($columns);
                    $this->crud->editFields($columns);
                    $this->crud->addFields($columns);
                    $this->crud->setTexteditor(['description']);
                    $this->crud->callbackBeforeInsert(function ($stateParameters){
                        $stateParameters->data['created_at'] = date('Y-m-d H:i:s');
                        $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                        return $stateParameters;
                    });
                    $this->crud->callbackBeforeUpdate(function ($stateParameters){
                        $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                        return $stateParameters;
                    });

                    $this->crud->setActionButton('Planes', 'fa fa-bars', function ($row) {
                        return base_url(['table', 'plans', $row->id]);
                    }, false);

                    $this->crud->setActionButton('Cosechas', 'fa fa-envira', function ($row) {
                        return base_url(['table', 'harvests', $row->id]);
                    }, false);

                    $this->crud->callbackColumn('price', function($value, $row){
                        return "$" . number_format($value, 0, ".", ",");
                    });

                    $this->crud->callbackColumn('sales_percentage', function($value, $row){
                        return "$value %";
                    });

                    $this->crud->callbackColumn('individual_value', function($value, $row){
                        return "$" . number_format($value, 0, ".", ",");
                    });

                    $this->crud->callbackColumn('ipc', function($value, $row){
                        return "$value %";
                    });

                    break;
                default:
                    break;   
            }

            switch ($component->url) {
                case 'folders': // Proyectos
                    $this->crud->displayAs([
                        'state_id'          => 'Estado',
                        'name'              => 'Proyecto',
                        'date'              => 'Fecha Sembrado',
                        'percentage_profit' => '% Utilidad',
                        'farm'              => 'Finca',
                        'ubication'         => 'Ubicación',
                        'created_at'        => 'Creado'
                    ]);

                    $this->crud->setRelation('state_id', 'states', 'name', ['code' => 'Proyect']);

                    $columns = ['state_id', 'name', 'date', 'percentage_profit', 'farm', 'ubication', 'created_at'];
                    $this->crud->columns($columns);
                    if (($key = array_search('created_at', $columns)) !== false) {
                        unset($columns[$key]);
                    }
                    if (($key = array_search('state_id', $columns)) !== false) {
                        unset($columns[$key]);
                    }
                    $this->crud->addFields($columns);
                    $this->crud->editFields($columns);

                    $this->crud->callbackBeforeInsert(function ($stateParameters) {
                        $stateParameters->data['created_at']    = date('Y-m-d h:i:s');
                        $stateParameters->data['updated_at']    = date('Y-m-d h:i:s');
                        $stateParameters->data['state_id']      = 3;
                        return $stateParameters;
                    });
                    $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                        $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                        return $stateParameters;
                    });

                    break;
                case 'unit_productives':
                    $this->crud->displayAs([
                        'state_id'          => 'Estado',
                        'unit_age_id'       => 'Unidad de edad',
                        'name'              => 'Nombre',
                        'code'              => 'Codigo',
                        'created_at'        => 'Creado'
                    ]);

                    $this->crud->setRelation('state_id', 'states', 'name', ['code' => 'Default']);
                    $this->crud->setRelation('unit_age_id', 'unit_ages', 'name');

                    $columns = ['state_id', 'unit_age_id', 'name', 'code', 'created_at'];
                    $this->crud->columns($columns);
                    if (($key = array_search('created_at', $columns)) !== false) {
                        unset($columns[$key]);
                    }
                    $this->crud->addFields($columns);
                    $this->crud->editFields($columns);

                    $this->crud->setActionButton('Valores Edad', 'fa fa-money', function ($row) {
                        return base_url(['table', 'price_ages', $row->id]);
                    }, false);

                    $this->crud->callbackBeforeInsert(function ($stateParameters) {
                        $stateParameters->data['created_at'] = date('Y-m-d h:i:s');
                        $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                        return $stateParameters;
                    });
                    $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                        $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                        return $stateParameters;
                    });

                    $this->crud->callbackAfterInsert(function ($stateParameters){
                        $pa_model = new PriceAge();
                        $pa_model->save([
                            'unit_productive_id'    => $stateParameters->insertId,
                            'age'                   => 0,
                            'value'                 => 0
                        ]);
                        return $stateParameters;
                    });
                    break;
                case 'clientes':
                    $this->crud->displayAs([
                        'state_id'          => 'Estado',
                        'type_document_id'  => 'Tipo de documento',
                        'name'              => 'Nombre',
                        'number_document'   => '# Documento',
                        'issued'            => 'Expedido',
                        'created_at'        => 'Creado'
                    ]);

                    $this->crud->setRelation('state_id', 'states', 'name', ['code' => 'Default']);
                    $this->crud->setRelation('type_document_id', 'type_documents', '{name} - {abbreviation}');

                    $columns = ['state_id', 'type_document_id', 'name', 'number_document', 'issued', 'created_at'];
                    $this->crud->columns($columns);
                    if (($key = array_search('created_at', $columns)) !== false) {
                        unset($columns[$key]);
                    }
                    $this->crud->addFields($columns);
                    $this->crud->editFields($columns);

                    $this->crud->setActionButton('Beneficiarios', 'fa fa-users', function ($row) {
                        return base_url(['table', 'beneficiaries', $row->id]);
                    }, false);

                    $this->crud->setActionButton('Cuentas', 'fa fa-university', function ($row) {
                        return base_url(['table', 'bank_accounts', $row->id]);
                    }, false);

                    $this->crud->callbackBeforeInsert(function ($stateParameters) {
                        $stateParameters->data['created_at'] = date('Y-m-d h:i:s');
                        $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                        return $stateParameters;
                    });
                    $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                        $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                        return $stateParameters;
                    });
                    break;
                
                default:
                    # code...
                    break;
            }

            $output = $this->crud->render();
            if (isset($output->isJSONResponse) && $output->isJSONResponse) {
                header('Content-Type: application/json; charset=utf-8');
                echo $output->output;
                exit;
            }

            $this->viewTable($output, $component->title, $component->description);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function detail($table, $reference){
        switch ($table) {
            case 'enlaces':
            case 'indicadores':
            case 'pasos':
            case 'events':
            case 'detail_why':
            case 'video_why':
            case 'archivos':
            case 'preguntas':
                $this->crud->setTable("banners_details");
                $component = (object) ["title" => '', "description" => ""];
                $type = $table;
                $table = 'banner_detail';
                break;
            case 'plans':
                $this->crud->setTable('plans');
                $component = (object) ["title" => '', "description" => ""];
                break;
            case 'harvests':
                $this->crud->setTable('harvests');
                $component = (object) ["title" => '', "description" => ""];
                break;

            // Table Sistemas
            case 'price_ages':
                $this->crud->setTable('price_ages');
                $up_model = new UnitProductive();
                $unit_productive = $up_model
                    ->select([
                        'unit_productives.*',
                        'ua.name as unit_age_name'
                    ])
                    ->join('unit_ages as ua', 'ua.id = unit_productives.unit_age_id', 'left')
                    ->find($reference);
                $component = (object) ["title" => "{$unit_productive->name} - {$unit_productive->unit_age_name}", "description" => ""];
                break;

            case 'beneficiaries':
                $this->crud->setTable('beneficiaries');
                $component = (object) ["title" => '', "description" => ""];
                break;

            case 'users':
                $this->crud->setTable('passwords');
                $this->crud->where(['user_id' => $reference]);
                $component = (object) ['title' => '', 'description' =>''];
                break;

            case 'bank_accounts':
                $this->crud->setTable('banks_accounts');
                $this->crud->where(['customer_id' => $reference]);
                $component = (object) ['title' => '', 'description' =>''];
                break;

            default:
                $menu = new Menu();
                $component = $menu->where(['url' => $table, 'component' => 'table'])->first();
                $this->crud->setTable($component->table);
                break;
        }
        
        switch ($table) {
            case 'banner_home':
            case 'banner_about':
            case 'banner_knowthebusiness':
            case 'banner_simulador':
            case 'banner_product':
            case 'how_works':
            case 'medios':
            case 'detail_about':
            case 'why':
            case 'knowthebusiness_details':
            case 'knowthebusiness_video':
            case 'knowthebusiness_files':
            case 'faq':
                $this->crud->where(['reference' => $reference, 'type' => $table]);
                $this->crud->callbackBeforeInsert(function ($stateParameters) use($reference, $table) {
                    $stateParameters->data['reference'] = $reference;
                    $stateParameters->data['type'] = $table;
                    return $stateParameters;
                });
                $b_model = new Banner();
                $banner_total = $b_model->where(['reference' => $reference, 'type' => $table])->countAllResults();
                switch ($table) {
                    case 'banner_home':
                        $columns = ['title', 'image'];
                        $this->crud->setActionButton('Enlaces', 'fa fa-link', function ($row) use($table) {
                            return base_url(['table',"enlaces", $row->id]);
                        });
                        $this->crud->setActionButton('Indicadores', 'fa fa-bar-chart', function ($row) use($table) {
                            return base_url(['table',"indicadores", $row->id]);
                        });
                        break;
                    case 'medios':
                        $columns = ['title', 'sub_title'];
                        $this->crud->setActionButton('Medios', 'fa fa-newspaper-o', function ($row) use($table) {
                            return base_url(['table',"events", $row->id]);
                        });
                        break;
                    case 'banner_about':
                    case 'banner_simulador':
                        $columns = ['title', 'sub_title', 'image'];
                        break;
                    case 'detail_about':
                        $columns = ['title', 'sub_title', 'description', 'image'];
                        break;
                    case 'why':
                        $columns = ['title', 'sub_title'];
                        $this->crud->setActionButton('Enlaces', 'fa fa-link', function ($row) use($table) {
                            return base_url(['table',"enlaces", $row->id]);
                        });
                        $this->crud->setActionButton('Detalles', 'fa fa-list-alt', function ($row) use($table) {
                            return base_url(['table',"detail_why", $row->id]);
                        });
                        $this->crud->setActionButton('Videos', 'fa fa-file-video-o', function ($row) use($table) {
                            return base_url(['table',"video_why", $row->id]);
                        });
                        break;
                    case 'banner_knowthebusiness':
                        $columns = ['title', 'sub_title', 'image'];
                        break;
                    case 'banner_product':
                        $columns = ['title', 'sub_title', 'description'];
                        break;
                    case 'knowthebusiness_details':
                        $columns = ['title', 'sub_title', 'description', 'image'];
                        break;
                    case 'knowthebusiness_video':
                        $columns = ['title', 'image'];
                        break;
                    case 'knowthebusiness_files':
                        $columns = ['title'];
                        $this->crud->setActionButton('Enlaces', 'fa fa-files-o', function ($row) use($table) {
                            return base_url(['table',"archivos", $row->id]);
                        });
                        break;
                    case 'faq':
                        $columns = ['title', 'image'];
                        $this->crud->setActionButton('Preguntas', 'fa fa-question-circle-o', function ($row) use($table) {
                            return base_url(['table',"preguntas", $row->id]);
                        });
                        break;
                    default:
                        $columns = ['title', 'sub_title', 'image'];
                        $this->crud->setActionButton('Pasos', 'fa fa-list-ul', function ($row) use($table) {
                            return base_url(['table',"pasos", $row->id]);
                        });
                        $this->crud->setActionButton('Enlaces', 'fa fa-link', function ($row) use($table) {
                            return base_url(['table',"enlaces", $row->id]);
                        });
                        break;
                }
                $this->crud->setTexteditor(['title', 'sub_title', 'description']);
                $this->crud->columns($columns);
                $this->crud->editFields($columns);
                $this->crud->addFields($columns);

                switch($table){
                    case 'knowthebusiness_details':
                        break;
                    case 'knowthebusiness_video':
                        if($banner_total > 0){
                            $this->crud->unsetAdd();
                            $this->crud->unsetDelete();
                        }
                        $this->crud->displayAs([
                            'title'     => 'Titulo',
                            'sub_title' => 'Sub Titulo',
                            'image'     => 'url'
                        ]);
                        break;
                    default:
                        if($banner_total > 0){
                            $this->crud->unsetAdd();
                            $this->crud->unsetDelete();
                        }
                        $this->crud->displayAs([
                            'title'     => 'Titulo',
                            'sub_title' => 'Sub Titulo',
                            'image'     => 'Imagen'
                        ]);
                        $this->crud->setFieldUpload('image', 'master/img/pages/home', '/master/img/pages/home');
                        break;
                }


                break;
            case 'banner_detail':
                $b_model = new Banner();
                $banner = $b_model->find($reference);
                $this->crud->where(['reference' => $reference, 'type' => $type]);
                switch ($banner->type) {
                    case 'banner_home':
                    case 'banner_about':
                    case 'how_works':
                    case 'medios':
                    case 'why':
                    case 'knowthebusiness_files':
                    case 'faq':
                        switch ($type) {
                            case 'enlaces':
                                $component->title = "Enlaces";
                                $columns = ['orden', 'title', 'url'];
                                break;
                            case 'indicadores':
                                $component->title = "Indicadores";
                                $columns = ['orden', 'title', 'sub_title'];
                                break;
                            case 'pasos':
                                $component->title = "Pasos";
                                $columns = ['orden', 'title', 'description', 'file'];
                                $this->crud->setFieldUpload('file', 'master/img/pages/details', '/master/img/pages/details');
                                break;
                            case 'events':
                                $component->title = "Medios Detallados";
                                $columns = ['orden', 'file', 'url'];
                                $this->crud->setFieldUpload('file', 'master/img/pages/details', '/master/img/pages/details');
                                $this->crud->where(['type' => $type]);
                                break;
                            case 'detail_why':
                                $component->title = "Detalles";
                                $columns = ['orden', 'title', 'description', 'icon'];
                                break;
                            case 'video_why':
                                $component->title = "Videos";
                                $columns = ['url'];
                                break;
                            case 'archivos':
                                $component->title = "Archivos";
                                $columns = ['orden', 'title', 'file'];
                                $this->crud->setFieldUpload('file', 'master/img/pages/details', '/master/img/pages/details');
                                break;
                            case 'preguntas':
                                $component->title = "Preguntas y respuestas";
                                $columns = ['orden', 'title', 'description'];
                                break;
                        }
                        break;
                }

                if (in_array('orden', $columns)) {
                    $this->crud->requiredFields(['orden']);
                }                

                $this->crud->columns($columns);
                $this->crud->editFields($columns);
                $this->crud->addFields($columns);
                $this->crud->setTexteditor(['description']);
                $this->crud->callbackBeforeInsert(function ($stateParameters) use($reference, $type) {
                    $stateParameters->data['reference'] = $reference;
                    $stateParameters->data['type'] = $type;
                    return $stateParameters;
                });
                break;
            case 'plans':
                $this->crud->displayAs([
                    'description'   => 'Descripción',
                    'discount'      => 'Descuento',
                    'stock'         => 'Stock'
                ]);
                $columns = ['description', 'discount', 'stock', 'image'];
                $this->crud->columns($columns);
                $this->crud->editFields($columns);
                $this->crud->addFields($columns);
                $this->crud->setTexteditor(['description']);
                $this->crud->setFieldUpload('image', 'master/img/pages/plans', '/master/img/pages/plans');
                $this->crud->callbackBeforeInsert(function ($stateParameters) use($reference){
                    $stateParameters->data['product_id'] = $reference;
                    $stateParameters->data['created_at'] = date('Y-m-d H:i:s');
                    $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                    return $stateParameters;
                });
                $this->crud->callbackBeforeUpdate(function ($stateParameters){
                    $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                    return $stateParameters;
                });
                break;
            case 'harvests':
                $this->crud->displayAs([
                    'year'          => 'Año',
                    'production'    => 'Producción Estimada',
                    'position'      => 'Posición',
                    'status'        => 'Estado'
                ]);
                $columns = ['year', 'production', 'position', 'status'];
                $this->crud->columns($columns);
                $this->crud->editFields($columns);
                $this->crud->addFields($columns);

                $this->crud->callbackBeforeInsert(function ($stateParameters) use($reference){
                    $stateParameters->data['product_id'] = $reference;
                    $stateParameters->data['created_at'] = date('Y-m-d H:i:s');
                    $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                    return $stateParameters;
                });
                $this->crud->callbackBeforeUpdate(function ($stateParameters){
                    $stateParameters->data['updated_at'] = date('Y-m-d H:i:s');
                    return $stateParameters;
                });

                $this->crud->requiredFields(['year', 'production', 'position']);
                break;

            // Table config sistem

            case 'users':
                $this->crud->unsetDelete();
                $this->crud->unsetEdit();
                $this->crud->unsetColumns(['password', 'user_id', 'updated_at']);
                $this->crud->fieldType('password', 'password');
                $this->crud->addFields(['password']);
                $this->crud->callbackBeforeInsert(function ($info) use($reference){
                    $info->data['created_at']   = date('Y-m-d H:i:s');
                    $info->data['updated_at']   = date('Y-m-d H:i:s');
                    $info->data['user_id']      = $reference;
                    $info->data['temporary']    = 'Si';
                    $info->data['password']     = password_hash($info->data['password'], PASSWORD_DEFAULT);
                    $p_model = new Password();
                    $passwords = $p_model->where(['user_id' => $reference, 'status' => 'active'])->findAll();
                    foreach ($passwords as $key => $password) {
                        $p_model->save([
                            'id'        => $password->id,
                            'status'    => 'inactive'
                        ]);
                    }
                    return $info;
                });

                $this->crud->displayAs([
                    'attempts'      => 'N° Intentos',
                    'status'        => 'Estado',
                    'created_at'    => 'Fecha de creación',
                    'password'      => 'Contraseña',
                    'temporary'     => 'Temporal'
                ]);
                break;

            case 'price_ages':
                $this->crud->displayAs([
                    'age'           => 'Edad',
                    'value'         => 'Valor',
                    'created_at'    => 'Creado'
                ]);

                $this->crud->where(['unit_productive_id' => $reference]);

                $columns = ['age', 'value', 'created_at'];
                $this->crud->columns($columns);
                if (($key = array_search('created_at', $columns)) !== false) {
                    unset($columns[$key]);
                }
                $this->crud->addFields($columns);
                $this->crud->editFields($columns);

                $this->crud->callbackColumn('value', function($value, $row){
                    return "$ " . number_format($value, 2, ".", ",");
                });

                $this->crud->callbackBeforeInsert(function ($stateParameters) use ($reference) {
                    $stateParameters->data['created_at'] = date('Y-m-d h:i:s');
                    $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                    $stateParameters->data['unit_productive_id'] = $reference;
                    return $stateParameters;
                });
                $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                    $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                    return $stateParameters;
                });
                break;
            case 'beneficiaries':
                $this->crud->displayAs([
                    'state_id'          => 'Estado',
                    'type_document_id'  => 'Tipo de documento',
                    'name'              => 'Nombre',
                    'number_document'   => '# Documento',
                    'created_at'        => 'Creado'
                ]);

                $this->crud->setRelation('state_id', 'states', 'name', ['code' => 'Default']);
                $this->crud->setRelation('type_document_id', 'type_documents', '{name} - {abbreviation}');

                $columns = ['state_id', 'type_document_id', 'name', 'number_document', 'created_at'];

                $this->crud->where(['customer_id' => $reference]);

                // $columns = ['age', 'value', 'created_at'];
                $this->crud->columns($columns);
                if (($key = array_search('created_at', $columns)) !== false) {
                    unset($columns[$key]);
                }
                $this->crud->addFields($columns);
                $this->crud->editFields($columns);

                $this->crud->callbackBeforeInsert(function ($stateParameters) use ($reference) {
                    $stateParameters->data['created_at'] = date('Y-m-d h:i:s');
                    $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                    $stateParameters->data['customer_id'] = $reference;
                    return $stateParameters;
                });
                $this->crud->callbackBeforeUpdate(function ($stateParameters) {
                    $stateParameters->data['updated_at'] = date('Y-m-d h:i:s');
                    return $stateParameters;
                });
                break;
            case 'bank_accounts':
                $this->crud->displayAs([
                    'state_id'              => 'Estado',
                    'bank_id'               => 'Banco',
                    'bank_account_type_id'  => 'Tipo de cuenta',
                    'name'                  => 'Cuenta',
                    'number_account'        => '# Cuenta',
                ]);
                
                $columns = [
                    'state_id',
                    'bank_id',
                    'bank_account_type_id',
                    'name',
                    'number_account',
                ];

                $this->crud->setRelation('state_id', 'states', 'name', ['code' => 'Default']);
                $this->crud->setRelation('bank_id', 'banks', 'name');
                $this->crud->setRelation('bank_account_type_id', 'bank_account_types', '{name} - {code}');

                $this->crud->addFields($columns);
                $this->crud->editFields($columns);
                $this->crud->columns($columns);

                $this->crud->callbackBeforeInsert(function ($stateParameters) use ($reference) {
                    $stateParameters->data['customer_id'] = $reference;
                    return $stateParameters;
                });

                break;
        }

        $output = $this->crud->render();
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $this->viewTable($output, $component->title, $component->description);

    }
}
