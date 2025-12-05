<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use App\Models\Project;
use App\Models\State;
use App\Models\TypeMovement;
use App\Models\Movement;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\TypeDocument;

class DashboardController extends BaseController
{
    use ResponseTrait;

	private $p_model;
	private $s_model;
	private $m_model;
	private $tm_model;

	public function __construct(){
		$this->p_model = new Project();
		$this->s_model = new State();
		$this->m_model = new Movement();
		$this->tm_model = new TypeMovement();
	}

	public function index()
	{

		$fechaEspecifica = new \DateTime(session('user')->password->created_at);
		$fechaActual = new \DateTime('now');
		$diferencia = $fechaEspecifica->diff($fechaActual);
		$stateMapping = [
			"1" => ["7"],           // Carga Inicial
			"2" => ["9", "10"],     // Ventas
			"3" => ["12"],          // Pagos
			"4" => ["14", "15"],    // Compras
			"5" => ["17", "18"]     // Utilidades
		];
		if(in_array(session('user')->role_id, ["1", "2"])){
			$type_movements	= $this->tm_model->findAll();
			$projects  		= $this->p_model->findAll();
			$states    		= $this->s_model->where(['code' => 'Proyect'])->findAll();
			

			// return $this->respond($type_movements_chunks);

			return  view('pages/home_admin', [
				'day' 				=> (90 - $diferencia->days),
				'projects'			=> $projects,
				'states'			=> $states,
				'type_movements'	=> $type_movements,
				'stateMapping'		=> $stateMapping
			]);
		}

		$type_movements	= $this->tm_model->whereNotIn('id', ["1", 4])->findAll();

		$movements = $this->m_model
		->select([
			'movements.*',
			'IFNULL(SUM(m.value), 0) as total_x_payable',
			'IFNULL(m.type_movement_id, null) as type_movement_reference_id'
		])
		->where(['movements.customer_id' => session('user')->customer_id])
		->join('movements m', 'm.movement_id = movements.id and m.state_id != 13', 'left')
		->groupBy('movements.id, m.type_movement_id')
		->findAll();

		// return $this->respond([$type_movements, $movements]);

		// var_dump($diferencia); die;

	  	return  view('pages/home_customer', [
			'day' 				=> (90 - $diferencia->days),
			'movements'			=> $movements,
			'type_movements'	=> $type_movements,
			'stateMapping'		=> $stateMapping
		]);
	}

	public function about()
	{
		return view('pages/about');
	}

	public function perfile(){
		$r_model = new Role();
		$td_model = new TypeDocument();

		$roles = $r_model->findAll();
		$type_documents = $td_model->findAll();
		
		return view('pages/perfile', [
			'roles' 			=> $roles,
			'type_documents'	=> $type_documents
		]);
	}

	public function perfileUpdate(){
		try{
			$data = $this->request->getJson();
			$validation = \Config\Services::validation();
			$id = session('user')->id;

			$rules = [
				'name'      => 'required|min_length[3]|max_length[50]',
				'username'  => "required|alpha_numeric|min_length[4]|is_unique[users.username,id,{$id}]",
				'email'     => "required|valid_email|is_unique[users.email,id,{$id}]"
			];

			$messages = [
				'email' => [
					'is_unique' => 'El correo electrónico ya está registrado por otro usuario.'
				],
				'username' => [
					'is_unique' => 'El nombre de usuario ya está en uso.'
				]
			];

			if (!$validation->setRules($rules, $messages)->run((array) $data)) {
				return $this->respond([
					'status' 	=> 'error',
					'title'		=> 'Validación fallida '. $id,
					'errors' 	=> $validation->getErrors()
				], 200);
			}

			$user = [
				'id'		=> $id,
				'name'		=> $data->name,
				'username'	=> $data->username,
				'email'		=> $data->email
			];

			if($id == 1){
				$user['role_id'] = $data->role;
			}

			$u_model = new User();
			$u_model->save($user);
			if(!empty(session('user')->customer_id)){
				$c_model = new Customer();
				$c_model->save([
					'id'	=> session('user')->customer_id,
					'name'	=> $data->name
				]);
			}

			$info = $u_model
				->select(['users.*', 'roles.name as role_name'])
                ->join('roles', 'roles.id = users.role_id')
			->find($id);
			$info->password = $u_model->getPassword($id);
			$session = session();
			$session->set('user', $info);

			return $this->respond([
				'status' => 'success',
				'message' => 'Datos de perfil actualizados correctamente.'
			], 200);

		}catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
	}

	public function customerUpdate(){
		try{
			$data = $this->request->getJson();
			$validation = \Config\Services::validation();
			$id = session('user')->customer_id;

			$rules = [
				'issued'     	=> 'required',
				'number'  		=> "required|numeric|min_length[4]|is_unique[customers.number_document,id,{$id}]",
				'type_document'	=> "required"
			];

			$messages = [
				'number' => [
					'required' => 'El número de documento es obligatorio.',
					'min_length' => 'El número minimo es de 4 caracteres.',
					'is_unique' => 'El número de documento ya esta en uso.'
				],
				'type_document' => [
					'required' => 'El tipo de documento es obligatorio.'
				],
				'issued' => [
					'required'	=> 'La fecha de expedición es obligatoria.',
				]
			];

			if (!$validation->setRules($rules, $messages)->run((array) $data)) {
				return $this->respond([
					'status' 	=> 'error',
					'title'		=> 'Validación fallida',
					'errors' 	=> $validation->getErrors()
				], 200);
			}

			$customer = [
				'id'				=> $id,
				'issued'			=> $data->issued,
				'number_document'	=> $data->number,
				'type_document_id'	=> $data->type_document
			];

			$c_model = new Customer();
			$c_model->save($customer);

			
			$id = session('user')->id;

			$u_model = new User();
			$info = $u_model
				->select(['users.*', 'roles.name as role_name'])
                ->join('roles', 'roles.id = users.role_id')
			->find($id);
			$info->password = $u_model->getPassword($id);
			$session = session();
			$session->set('user', $info);

			return $this->respond([
				'status' => 'success',
				'message' => 'Datos de perfil actualizados correctamente.'
			], 200);

		}catch(\Exception $e){
			return $this->respond(['title' => 'Error en el servidor', 'error' => $e->getMessage()], 500);
		}
	}

}
