<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Estados extends CI_Controller {
    
	
	/*
	|--------------------------------------------------------------------------
	| Carga inicial
	|--------------------------------------------------------------------------
	*/
	public function index()
	{		
    	$wh = "";	
		//Consulta a la BD
		$arr = ( $this->db->query('select * from estados order by id'));
		//Población del arreglo data con resultados de la búsqueda
		$data['result'] = ($arr->result_array());
		//Carga de las vistas
		$this->load->view('inicio/top1'); 
		//Carga de la vista y paso de datos (Vista, Datos)
		$this->load->view('estados/estadosindex',$data); 
		$this->load->view('inicio/bottom1');
	}

	/*
	|--------------------------------------------------------------------------
	| Modificación de datos
	|--------------------------------------------------------------------------
	*/
	public function modificar() {
        $this->load->model('Estadosmodel');
		$registro = $this->Estadosmodel->get_detalle($this->uri->segment(3));
		$this->load->view('inicio/top1');
		$this->load->view('estados/detalleestado',$registro); 
		$this->load->view('inicio/bottom1');		
	}

	/*
	|--------------------------------------------------------------------------
	| Nuevo estado
	|--------------------------------------------------------------------------
	*/
	public function agregar() {
		//Carga del modelo
		$this->load->model('Estadosmodel');
		//Obtención de datos
		$registro = $this->Estadosmodel->get_campos();
		$id = $this->Estadosmodel->last_id();
		$registro['accion'] = "N";
		$registro['id'] = $id;
		//Carga de las vistas
		$this->load->view('inicio/top1');
		//Carga de la vista y envío de datos (Vista, Datos)
		$this->load->view('estados/detalleestado',$registro); 
		$this->load->view('inicio/bottom1');
	}

	public function guardar() {
		$this->load->model("Estadosmodel");
		//unset($_POST['accion']);
	   	$this->Estadosmodel->guardar($_POST);
	   	redirect("estados");
	}

	/*
	|--------------------------------------------------------------------------
	| Eliminar estado
	|--------------------------------------------------------------------------
	*/
	public function eliminar() {
		$this->load->model("Estadosmodel");
		$this->Estadosmodel->eliminar($this->uri->segment(3));
	}
}