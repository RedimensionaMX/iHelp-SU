<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subtipos extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	/*public function index()
	{		
		$arr = ( $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'"));
		print_r($arr);
		$data['result'] = ($arr->result_array());
		$data['tipo'] = $this->uri->segment(3,'0');
		$this->load->view('inicio/top1'); 
		$this->load->view('subtipos/subtiposindex',$data); 
		$this->load->view('inicio/bottom1');
	}*/

	public function index(){
		//Carga del modelo
		$this->load->model('Subtiposmodel');
        $wh = " where (1=1)";
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Obtención de segmento adicional en la url
		$lim = $this->uri->segment(3,'2');
		$var = $this->uri->segment(4,'');
		if($lim == 1 || $lim == 0){
			//echo "PRUEBA";
			$busqueda = str_replace("%20", " ", $var);
			$wh = " where tipo = '".$busqueda."'";
			$lim = 0;
		}else{
			//echo "LIM VACIO";
			/*if ($var!=''){
				$busqueda = str_replace("%20", " ", $var);
				$wh = " where (1=1) AND tipo IN(";
				$tipo = $this->Subtiposmodel->get_tipo($busqueda);
				foreach ($tipo as $key) {
					# code...
					$wh .= "'".$key."',";
					//print_r($wh);
				}
				$wh.="'0')";
				//$wh = " where tipo = '" .$tipo. "'";
			}*/
		}
		$data['tipos'] = $this->Subtiposmodel->get_tipos_dropdown();
		$data['tipos']['NE'] = "Seleccionar tipo para ver sus subtipos";
		$data['tipo'] = $this->uri->segment(4,'');
			
		//Filtrado de resultados
		$data['result'] = $this->Subtiposmodel->get_subtipos_where_str($wh,$lim,"20");
		//print_r($data);
		$config['base_url'] = '/index.php/subtipos/index';
		//Búsqueda total en la tabla de clientes
		$arrtot = ( $this->db->query('select count(*) from subtipos' . $wh . ''));
		//Obtención de array
		$datas = $arrtot->result_array();
		//Declaración del total de filas por enlistar
		$config['total_rows'] = $datas[0]['count'];
		//Resultados por página
		$config['per_page'] = 20; 
		$this->pagination->initialize($config); 
		//Carga de las vistas
		$this->load->view('inicio/top1');
		//Carga de la vista y envío de datos (Vista, Datos) 
		$this->load->view('subtipos/subtiposindex',$data);
		$this->load->view('inicio/bottom1'); 
	}
	
	public function subtiposjson(){			
		$arr =  $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'");
	    $data['result'] = ($arr->result_array());
		$this->load->view('tipos/subtiposjson',$data); 	
	}
	
	public function agregar() {
		$tipo = $this->uri->segment(3,"");
		$tipo = str_replace("%20", " ", $tipo);
		
		$this->load->model('Subtiposmodel');
     	$registro = array(
			"id" => "",
			"tipo"=>  $tipo,
			"capacidad"=>""
		);
		//$id = $this->Subtiposmodel->last_id();
		
		//$arrt = ( $this->db->query('select * from subtipos order by tipo'));
		$arrt = ( $this->db->query('select distinct clase from tipos order by clase'));
		$tipos = ($arrt->result_array());		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["clase"]] = $tipo["clase"];
		}	
		$registro['tipos'] = $tip;
		
		$this->load->view('inicio/top1');
		$this->load->view('subtipos/detallesubtipo',$registro); 
		$this->load->view('inicio/bottom1');
	}

	public function agregar22() {
		$registro = array(
			"id"=>"",			
			"clave_proveedor"=>"",
			"nombre_proveedor"=>"",
		);	
		$this->load->view('inicio/top1');
		$this->load->view('proveedores/detalleproveedor',$registro); 
		$this->load->view('inicio/bottom1');
	}
	
	public function modificar() {
		$this->load->model('Subtiposmodel');
			$registro = $this->Subtiposmodel->get_detalle($this->uri->segment(3));
			$this->load->view('inicio/top1');
			$this->load->view('subtipos/detallesubtipo',$registro); 
			$this->load->view('inicio/bottom1');		
		

		//$arr =  $this->db->query("select * from subtipos where id='" . $this->uri->segment(3) . "'");
		//$data = ($arr->result_array());
		//$registro = array();
		//$registro = $data[0];
		//$this->load->view('inicio/top1');
		//$this->load->view('subtipos/detallesubtipo',$registro); 
		//$this->load->view('inicio/bottom1');
	}
	
	public function guardar2() {
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		if ($accion=="i") {
		   $this->db->insert('subtipos',$_POST);
		   redirect('/subtipos/');
//		   redirect('/subtipos/modificar/' . $_POST['id']); 
		} else {
			unset($_POST['tipo']);
	     	$this->db->where('id', $_POST["id"]);
		 	$this->db->update('subtipos', $_POST);
			redirect('/subtipos/modificar/' . $_POST["id"]); 
		}
	}

	public function guardar3(){
		$this->load->model("Subtiposmodel");
		//unset($_POST['accion']);
	   	$this->Subtiposmodel->guardar($_POST);
	   	redirect("subtipos");
	}

	public function guardar() {
		$this->load->model("Subtiposmodel");
		unset($_POST['submit']);
		$accion = $_POST['accion'];
		echo $accion;
		if($accion ==0){
			//echo "LLEGASTE";
			//$tipo = $this->Subtiposmodel->get_tipo2($tipo);
			//echo $tipo;
			$actualizacion = array(
				'id' => $_POST["id"],
				'capacidad' => $_POST["capacidad"]
			);
		}else{
			
			$tipo = $_POST["tipo"];
			echo $tipo;
			//$tipo = $this->Subtiposmodel->get_tipo($tipo);
			$insercion = array(
				'tipo' => $tipo,
				'capacidad' => $_POST["capacidad"]
			);
			//echo $tipo;
		}
		unset($_POST['accion']);

	   	if ($accion==1) {
			//echo "INSERCION";
			$this->db->insert('subtipos',$insercion);
		  	redirect('/subtipos/'); 
	   	} else {
			//echo "ACTUALIZACION";
			$this->db->where('id', $_POST["id"]);
		 	$this->db->update('subtipos', $actualizacion);
			//echo $actualizacion;
			redirect('/subtipos/modificar/' . $_POST["id"]);
		}
   	}
	
	public function eliminar() {
		$this->load->model("Subtiposmodel");
		$id = $this->uri->segment(3);
		$id = str_replace("%20", " ", $id);
		//$capacidad = $this->uri->segment(4);
		//$capacidad = str_replace("%20", " ", $capacidad);
		//print_r($subtipo['id']);
		$data = $this->Subtiposmodel->get_subtipos_where($id);
		//print_r($data['id']);
		//print_r($capacidad);
		$arr = ( $this->db->query("select * from equipos where tipo='" . $data['tipo'] . "' and capacidad='" . $data['capacidad'] . "'"));
     	if ($arr->num_rows==0) {
			$this->db->query("delete from subtipos where tipo='" . $data['tipo'] . "' and capacidad='" . $data['capacidad'] . "'");
			// REGISTRO DE ACCIONES
			$registroacc = array(
				"usuario" => $this->session->userdata('usuario'),
				"usuario_id" => $this->session->userdata('usuario_id'),
				"fecha_hora" => date ("Y-m-d H:i:s"),
				"accion"  => "ELIMINADO",
				"tabla"   => "subtipos",
				"detalle" => "ID: " . $id);
			$this->db->insert('registroacciones',$registroacc);		 
			redirect('/subtipos/'); 
     	} else {
	 		$data=array("mensaje"=>"No se puede eliminar el subtipo. Existen equipos registrados de esta capacidad.",
	 	  	"url"=>"/index.php/inicio/administracion");
			$this->load->view('inicio/top_single1');
			$this->load->view('comun/mensaje',$data);
			$this->load->view('inicio/bottom1');
	 	}
		/*$arr = ( $this->db->query("select * from equipos where tipo='" . $this->uri->segment(3) . "' and capacidad='" . $this->uri->segment(4) . "'"));
     	if ($arr->num_rows==0) {
			$this->db->query("delete from subtipos where tipo='" . $this->uri->segment(3) . "' and capacidad='" . $this->uri->segment(4) . "'");
           	// REGISTRO DE ACCIONES
			$registroacc = array(
				"usuario" => $this->session->userdata('usuario'),
				"usuario_id" => $this->session->userdata('usuario_id'),
				"fecha_hora" => date ("Y-m-d H:i:s"),
				"accion"  => "ELIMINADO",
				"tabla"   => "subtipos",
				"detalle" => "ID: " . $this->uri->segment(3));
			$this->db->insert('registroacciones',$registroacc);		 
			redirect('/subtipos/'); 
     	} else {
	 		$data=array("mensaje"=>"No se puede eliminar el subtipo. Existen equipos registrados de esta capacidad.",
	 	  	"url"=>"/index.php/inicio/administracion");
			$this->load->view('inicio/top_single1');
			$this->load->view('comun/mensaje',$data);
			$this->load->view('inicio/bottom1');
	 	}*/
	}		
	
	public function agregaraequipo() {
    	$arr = ( $this->db->query('select * from catpiezas'));
	    $data['result'] = ($arr->result_array());
	    $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}	
		$data['tipos'] = $tip;		
	    $this->load->view('top_single');
		$this->load->view('piezas/agregarpiezaaequipo',$data); //,$registro $this->load->view('inicio/bottom1');	
	}	
	
	public function guardaraequipo() {
		unset($_POST['submit']);
		unset($_POST['tipo']);
		$accion = $_POST['accion'];
		$nvaousada = $_POST['nuevaousada'];
        unset($_POST['accion']);
		unset($_POST['nuevaousada']);
		$arr = ( $this->db->query("select * from catpiezas where id='" . $_POST['pieza_id'] . "'"));
	    $res = ($arr->result_array());
		$_POST['descripcion'] = $res[0]['descripcion'];
		if ($accion=="i") {
			$this->db->insert('piezas',$_POST);
		   	// Actualizar inventarios
		   	if ($nvaousada=="N") {
			   $query = "update catpiezas set cant_nuevas = cant_nuevas-1 where id='" . $_POST['pieza_id'] . "'" ;
               $r     = $this->db->query($query);
		   	} else {
			   $query = "update catpiezas set cant_usadas = cant_usadas-1 where id='" . $_POST['pieza_id'] . "'" ;
               $r = $this->db->query($query);
		   	}
		   	$this->load->view('top_single');
		  	$this->load->view('comun/cerrartop'); $this->load->view('inicio/bottom1');
		} else {
	    	$this->db->where('id', $_POST["id"]);
			$this->db->update('piezas', $_POST);
			redirect('/piezas/' . $_POST["id"]); 
		}
	}
}