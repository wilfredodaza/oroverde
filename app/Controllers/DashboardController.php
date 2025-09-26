<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

use App\Models\Project;
use App\Models\State;
use App\Models\TypeMovement;
use App\Models\Movement;

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

}
