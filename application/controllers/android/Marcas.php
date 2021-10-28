<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marcas extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

    public function guardarMarca() {
		$this->load->model('android/Clasesmodel');
        $this->Clasesmodel->guardarMarca($_POST);
		redirect("android/tipos/index/".$_POST['tipo']);
	}

    public function modificar() {
        $this->load->model('android/Clasesmodel');
		$registro = $this->Clasesmodel->get_detalle($this->uri->segment(4),$this->uri->segment(5));
        //print_r($registro);
		$registro['clases'] = $registro;
        $this->load->view('inicio/top1');
		$this->load->view('marcas/detalle',$registro);
		$this->load->view('inicio/bottom1');
	}
}