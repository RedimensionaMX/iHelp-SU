<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Egresos extends CI_Controller {
    public function __construct(){
		parent::__construct();
	}

	private function _cambiaf_a_normal($fecha){
		//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
		preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
		$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
		return $lafecha;
	}

	public function index(){
		$this->load->model("Egresosmodel");
		$sucursales_keys = array_keys(sucursales_nombres_dd());
		$sucursales_seleccionadas = [];
		$j = 0;
		for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) {
			if($this->input->post($sucursales_keys[$i]) == true){
				$sucursales_seleccionadas[$j] = $sucursales_keys[$i];
				$j++;
			}
		}
		if(empty($sucursales_seleccionadas)){
			$data['result'] = $sucursales_seleccionadas;
			$this->load->view('inicio/top1');
			$this->load->view('egresos/checkboxsucursales');
			$data['egresos'] = $this->Egresosmodel->get_egresos($this->uri->segment(3),$this->uri->segment(4));
			$this->load->view("egresos/index",$data);
			$this->load->view('inicio/bottom1');
		} else {
			$data['egresos'] = $this->Egresosmodel->get_egresos_prueba($sucursales_seleccionadas, $this->input->post("anios")."", $this->input->post("mes"));
			$this->load->view('inicio/top1');
			$this->load->view('egresos/checkboxsucursales');
			$this->load->view("egresos/index",$data);
			$this->load->view('inicio/bottom1');
		}
	}

	public function index2(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('egresos/agregaregresos2');
		}else{
			$this->load->view('egresos/index');
		}
    }

	public function cierredemes() {
		$this->load->model("equipos/Equiposmodel");
		if ($this->uri->segment(3,'')=='') {
			redirect('/reportes/cierredemes/' . date("Y") . "/" . date("n"));
		}
		$data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes($this->uri->segment(3),$this->uri->segment(4));
		$this->load->view('inicio/top1');
		$this->load->view("reportes/cierredemes",$data);
		$this->load->view('inicio/bottom1');
    }

	public function eliminar() {
		$this->load->model("Egresosmodel");
		$this->Egresosmodel->eliminar($this->uri->segment(3));
		redirect('/egresos/index/');
	}

	public function guardarnuevoegreso() {
        $this->load->model('Egresosmodel');
        $query = $this->db->query("select * from SUCURSALES where SUCURSAL_ID ='".$this->session->sucursal_id."'");
        $sucursal = $query->result_array();
        $query = $this->db->query("select first 1 id from egresos order by id desc");
        $ultimoID = $query->result_array();
        print_r($ultimoID);
        if($ultimoID[0]['id']>=1){
            $ultimoID[0]['id'] = $ultimoID[0]['id'] +1;
        } else {
            $ultimoID[0]['id'] = 1;
        }
        print_r($ultimoID[0]['id']);
        $_POST['id'] = $ultimoID[0]['id'];
        $ultimo_eq_id = $this->Egresosmodel->insertarEgreso($_POST);
        redirect('/egresos/index');
	}

	public function modificar() {
        $this->load->model('Egresosmodel');
        $registro = $this->Egresosmodel->get_detalle2($this->uri->segment(3));
		$egresosTipo = $this->db->query("select id,nombre from EGRESOS_TIPO where nombre ='".$registro['tipo_egreso']."'");
		$egresosTipo2 = $this->db->query("select id,nombre from EGRESOS_TIPO where nombre !='".$registro['tipo_egreso']."'");
		$egresosTipo = $egresosTipo->result_array();
		$egresosTipo2 = $egresosTipo2->result_array();
		$registro['tipos'] = array_merge($egresosTipo,$egresosTipo2);
		$egresosCategoria = $this->db->query("select e.id,e.nombre,e.egresos_tipo_id,et.id from EGRESOS_CATEGORIA e inner join egresos_tipo et on et.id=e.egresos_tipo_id where e.nombre ='".$registro['categoria']."' and et.id='".$registro['tipos'][0]['id']."'");
		$egresosCategoria2 = $this->db->query("select e.id,e.nombre,e.egresos_tipo_id,et.id from EGRESOS_CATEGORIA e inner join egresos_tipo et on et.id=e.egresos_tipo_id where e.nombre !='".$registro['categoria']."' and et.id='".$registro['tipos'][0]['id']."'");
		$egresosCategoria = $egresosCategoria->result_array();
		$egresosCategoria2 = $egresosCategoria2->result_array();
		$registro['categorias'] = array_merge($egresosCategoria,$egresosCategoria2);
		$egresosSubcategoria = $this->db->query("select e.id,e.nombre,e.categoriaegreso_id from EGRESOS_SUBCATEGORIA e inner join egresos_categoria ec on ec.id=e.categoriaegreso_id where e.nombre ='".$registro['subcategoria']."' and ec.id='".$registro['categorias'][0]['id']."'");
		$egresosSubcategoria2 = $this->db->query("select e.id,e.nombre,e.categoriaegreso_id from EGRESOS_SUBCATEGORIA e inner join egresos_categoria ec on ec.id=e.categoriaegreso_id where e.nombre !='".$registro['subcategoria']."' and ec.id='".$registro['categorias'][0]['id']."'");
		$egresosSubcategoria = $egresosSubcategoria->result_array();
		$egresosSubcategoria2 = $egresosSubcategoria2->result_array();
		$registro['subcategorias'] = array_merge($egresosSubcategoria,$egresosSubcategoria2);
		$sucursalAplicacion = $this->db->query("select * from sucursales where id = ".$registro['id_02']."");
		$sucursalAplicacion2 = $this->db->query("select * from sucursales where id != ".$registro['id_02']."");
		$sucursalAplicacion = $sucursalAplicacion->result_array();
		$sucursalAplicacion2 = $sucursalAplicacion2->result_array();
		$registro['sucursalAplicacion'] = array_merge($sucursalAplicacion,$sucursalAplicacion2);
		$sucursalEgreso = $this->db->query("select * from sucursales where id = ".$registro['id_01']."");
		$sucursalEgreso2 = $this->db->query("select * from sucursales where id != ".$registro['id_01']."");
		$sucursalEgreso = $sucursalEgreso->result_array();
		$sucursalEgreso2 = $sucursalEgreso2->result_array();
		$registro['sucursalEgreso'] = array_merge($sucursalEgreso,$sucursalEgreso2);
		$usuarioSolicita = $this->db->query("select distinct usuario,nombre from usuarios where usuario = '".$registro['usuario_id_solicita']."' order by nombre");
		$usuarioSolicita2 = $this->db->query("select distinct usuario,nombre from usuarios where usuario != '".$registro['usuario_id_solicita']."' order by nombre");
		$usuarioSolicita = $usuarioSolicita->result_array();
		$usuarioSolicita2 = $usuarioSolicita2->result_array();
		$registro['usuario_id_solicita'] = array_merge($usuarioSolicita,$usuarioSolicita2);
		$usuarioAutoriza = $this->db->query("select distinct usuario,nombre from usuarios where usuario = '".$registro['usuario_id_autoriza']."' order by nombre");
		$usuarioAutoriza2 = $this->db->query("select distinct usuario,nombre from usuarios where usuario != '".$registro['usuario_id_autoriza']."' order by nombre");
		$usuarioAutoriza = $usuarioAutoriza->result_array();
		$usuarioAutoriza2 = $usuarioAutoriza2->result_array();
		$registro['usuario_id_autoriza'] = array_merge($usuarioAutoriza,$usuarioAutoriza2);
		$registro['usuarios'] = $this->Egresosmodel->obtenerUsuarios();
		$this->load->view('inicio/top1');
		$this->load->view('egresos/editaregreso',$registro);
		$this->load->view('inicio/bottom1');
	}

    public function modificarEgreso(){
		$this->load->model('Egresosmodel');
        $data = $this->Egresosmodel->guardar_modificaciones($_POST);
        redirect('/egresos/index');
    }

    public function nuevo() {
		$this->load->model('Egresosmodel');
		$data["fecha_recibido"] = fecha_actual_mysql();
		$data['tipos'] = $this->Egresosmodel->obtenerTipos()->result();
		$data['usuarios'] = $this->Egresosmodel->obtenerUsuarioSolicitante($this->session->usuario);
		$arr2 = $this->db->query("select * from SUCURSALES order by id asc");
		$arr3 = $this->db->query("select * from SUCURSALES where SUCURSAL_ID !='".$this->session->sucursal_id."' order by id asc");
		$data2 = $arr2->result_array();
		$data3 = $arr3->result_array();
		$data['sucursales'] = $data2;
		$data['sucursal_id_egreso'] = $data['sucursales'][0]['id'];
		$this->load->view('inicio/top1');
		$this->load->view('egresos/agregaregreso',$data);
		$this->load->view('inicio/bottom1');
	}

	public function obtenerCategorias(){
		$this->load->model('Egresosmodel');
        $data = $this->Egresosmodel->obtenerCategorias($_POST['ID'])->result();
        echo json_encode($data);
    }

	public function obtenerSubCategorias(){
		$this->load->model('Egresosmodel');
        $data = $this->Egresosmodel->obtenerSubCategorias($_POST['ID'])->result();
        echo json_encode($data);
    }
}