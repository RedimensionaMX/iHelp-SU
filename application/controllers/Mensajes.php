<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->output->enable_profiler(FALSE);
    }
	 
	public function index(){		
		$this->load->model("Mensajesmodel");
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		$mensajes = $this->Mensajesmodel->get_mensajes_de_usuario($lim,15);
	    $data['mensajes'] = $mensajes;
		$config['base_url'] = '/index.php/mensajes/index';
        $config['total_rows'] = $this->Mensajesmodel->get_cnt_where_str(""); 
        $config['per_page'] = 15; 
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top1'); 
		$this->load->view('mensajes/mensajesindex',$data); 
		$this->load->view('inicio/bottom1'); 				
	}

	public function  mensajesrecientes() {
		$this->load->model("Mensajesmodel");
		$data['mensajes'] = $this->Mensajesmodel->get_mensajes_de_usuario(0,10);
		$this->load->view("mensajes/divmensajes",$data);
	}
	
	public function vermensaje() {
		$this->load->model("Mensajesmodel");
		$registro = $this->Mensajesmodel->get_detalle($this->uri->segment(3));
		if ($registro['usuario_destinatario_id']<>0)
		   $this->Mensajesmodel->set_leido($this->uri->segment(3));
		$this->load->view('inicio/top1');
		$this->load->view('mensajes/vermensaje',$registro); 
		$this->load->view('inicio/bottom1');
	}
	
	public function agregar() {
    	$this->load->model("Mensajesmodel");
		$sessionid = $this->session->userdata('usuario_id');
		$arr = ( $this->db->query('select * from USUARIOS where nivel>0 and id<>' . $sessionid . " order by nombre "));
		$result = ($arr->result_array());
	    $usuarios = array();
	    $usuarios[0] = "A todos";
	    foreach ($result as $k=>$v) {
	    	$usuarios[$v['id']] = $v['nombre'];
	    }
		$registro = $this->Mensajesmodel->get_campos();
		$registro['usuarios'] = $usuarios;
		$this->load->view('inicio/top1');
		$this->load->view('mensajes/detallemensaje',$registro); 
		$this->load->view('inicio/bottom1');
	}
	
	public function guardar() {
        unset($_POST['enviar']);
        $p = $this->input->post();
        $p['fecha'] = date("Y-m-d");
        $p['hora']  = date("h:i:s");
        $p['usuario_id'] = $this->session->userdata('usuario_id');
		$this->db->insert('mensajes',$p);
		redirect('/inicio/iniciar'); 		
	}
	
	public function eliminar() {
    	$this->db->delete("mensajes",array("id"=>$this->uri->segment(3)));
     	redirect("mensajes/index");
	}
}