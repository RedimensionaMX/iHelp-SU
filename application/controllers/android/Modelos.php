<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelos extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

    public function index(){
		$this->load->model("android/Modelosmodel");
        $this->load->library('pagination');
        $lim = $this->uri->segment(4,'0');
        //print_r($lim);
		//$arr = ( $this->db->query('select * from tipos limit ' . $lim . ',100'));
		//$tipos = $this->Tiposclasesequiposmodel->get_tipos_where_str("",$lim,100);
		if ($this->uri->segment(4,'')=='')
			$tipos = $this->Modelosmodel->get_tipos();
		else
			$tipos = $this->Modelosmodel->get_tipos_de_clase($this->uri->segment(4),$this->uri->segment(5));
	    //$data['result'] = ($arr->result_array());
	    $data['result'] = $tipos;
	    $data['clases'] = $this->Modelosmodel->get_clases_dropdown();
	    $data['clases']['NE'] = "Seleccionar clase para ver sus tipos";
		$data['clase'] = $this->uri->segment(3,'NE');
		$this->load->view('inicio/top1');
		$this->load->view('modelos/modelosindex',$data);
		$this->load->view('inicio/bottom1');
	}

	public function sincronizar() {
		$this->load->model("Tiposclasesequiposmodel");
		$this->Tiposclasesequiposmodel->sincronizar_bds();
	}

	public function subtiposjson()
	{		
        
		
		$arr =  $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'");
	    $data['result'] = ($arr->result_array());
		



		 $this->load->view('tipos/subtiposjson',$data); 
	 
		
	}	
	
	public function imagenjson()
	{
		// regresa un JSON con el nombre del archivo de imagen
		// OJO! SIN VIEW!
		$arr =  $this->db->query("select imagen from tipos where tipo='" . $this->uri->segment(3,'0')  . "'");
        echo "{ \n";

		if ($arr->num_rows>0) {
	    $data = ($arr->result_array());
		
        //print_r($result);
            echo '"imagen" : "' . $data[0]['imagen'] . '"';
        }
		else echo '"imagen" : "sin_imagen.png"';
        echo "\n}";

		
	}
	
	public function agregar() {
       	/* $arr = ( $this->db->query('select * from equipos where id=1'));
		$data = ($arr->result_array());
		$registro = $data[0];	*/
		$this->load->model("Tiposclasesequiposmodel");
		$this->load->model("android/Equiposmodel");
		$registro = $this->Tiposclasesequiposmodel->get_campos_tipos();
		$registro['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();


		$this->load->model("Tiposclasesequiposmodel");
		$this->load->model("android/Equiposmodel");
		// $registro['category'] = $this->Equiposmodel->get_category()->result();
        // print_r($registro['category']);
		$data['category'] = $this->Equiposmodel->get_category()->result();
        $data['tipo'] = "";
		$q = $this->db->query("select id from correlacion_android order by id desc");
    	$aq = $q->result_array();
		//print_r($aq);
		$data['id'] = $aq[0]['id']+1;

        // $arr2 = $this->db->query("select * from tipos where tipo ='".$valor."'");
        // $arr3 = $this->db->query("select * from tipos where tipo !='".$valor."' order by tipo asc");

		// $marca = $this->db->query("select distinct marca from correlacion_android where marca ='".$valor2."'");
        // $marcas = $this->db->query("select distinct marca from correlacion_android where marca !='".$valor2."' order by marca asc");
        
        // $tipoAndroid = $this->db->query("select distinct tipo from correlacion_android where tipo ='".$valor3."'");
        // $tiposAndroid = $this->db->query("select distinct tipo from correlacion_android where tipo !='".$valor3."' order by tipo asc");
        
		// $data2 = $arr2->result_array();
        // $data3 = $arr3->result_array();
        // $arrayMarca = $marca->result_array();
        // $arrayMarcas = $marcas->result_array();
		// $arrayTipo = $tipoAndroid->result_array();
        // $arrayTipos = $tiposAndroid->result_array();
        
        //$registro['category'] = array_merge($data2,$data3);
        
		// $registro['category'] = $ti
        // $registro['marcas'] = array_merge($arrayMarca,$arrayMarcas);
        // $registro['tiposAndroid'] = array_merge($arrayTipo,$arrayTipos);
		// print_r($registro['category']);

		//$registro['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();
		//$registro['subtipos'] = $data;			
		$arr2 = $this->db->query("select * from tipos");
        $data['category2'] = $arr2->result_array();
        
		

		
		$this->load->view('inicio/top1');
		$this->load->view('modelos/detallemodelo',$data); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		$this->load->model("Tiposclasesequiposmodel");
		$this->load->model("android/Equiposmodel");
		$tipo = $this->uri->segment(4);
		$tipo = str_replace("%20", " ", $tipo);
        //print_r($tipo);
        $arr =  $this->db->query("select * from correlacion_android where modelo='" . $tipo . "'");
	    $data = ($arr->result_array());
        //print_r($data[0]['clase']);
		$registro = array();
		$registro = $data[0];
        $valor = $data[0]['clase'];
        $valor2 = $data[0]['marca'];
        $valor3 = $data[0]['tipo'];
        $arr =  $this->db->query("select * from subtipos where tipo='" . $tipo . "'");
	    $data = ($arr->result_array());
        // $registro['category'] = $this->Equiposmodel->get_category()->result();
        // print_r($registro['category']);
        $arr2 = $this->db->query("select * from tipos where tipo ='".$valor."'");
        $arr3 = $this->db->query("select * from tipos where tipo !='".$valor."' order by tipo asc");

		$marca = $this->db->query("select distinct marca from correlacion_android where marca ='".$valor2."'");
        $marcas = $this->db->query("select distinct marca from correlacion_android where marca !='".$valor2."' order by marca asc");
        
        $tipoAndroid = $this->db->query("select distinct tipo from correlacion_android where tipo ='".$valor3."'");
        $tiposAndroid = $this->db->query("select distinct tipo from correlacion_android where tipo !='".$valor3."' order by tipo asc");
        
		$data2 = $arr2->result_array();
        $data3 = $arr3->result_array();
        $arrayMarca = $marca->result_array();
        $arrayMarcas = $marcas->result_array();
		$arrayTipo = $tipoAndroid->result_array();
        $arrayTipos = $tiposAndroid->result_array();
        
        $registro['category'] = array_merge($data2,$data3);
        $registro['marcas'] = array_merge($arrayMarca,$arrayMarcas);
        $registro['tiposAndroid'] = array_merge($arrayTipo,$arrayTipos);
		//print_r($registro['category']);

		$registro['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();
		$registro['subtipos'] = $data;			
		$this->load->view('inicio/top1');
		$this->load->view('modelos/detallemodelo',$registro); 
		$this->load->view('inicio/bottom1');		
	}	
	
	
	
	public function guardar() {
     	$this->load->model("Tiposclasesequiposmodel");
		$tipo = $this->uri->segment(3);
		$data = array(
			'tipo' => $_POST['tipo']
		);
		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   $this->db->insert('tipos',$_POST);
     	


		   redirect('/tipos/'); 
		}
		else {
	     $this->db->where('tipo', $tipo);
		 $this->db->update('tipos', $_POST);
		 $this->db->where('tipo', $tipo);
		 $this->db->update('subtipos', $data);
		 redirect('/tipos/modificar/' . $_POST["tipo"]); 
		}
		
	}	
	
public function eliminar() {
     	$this->load->model("Tiposclasesequiposmodel");

     $arr = ( $this->db->query("select * from equipos where tipo='" . $this->uri->segment(3) . "'"));
     if ($arr->num_rows==0) {
     	$this->db->query("delete from tipos where tipo='" . $this->uri->segment(3) . "'");
		$this->db->query("delete from subtipos where tipo='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "tipos",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);	

// sincronizar bases de da tos
     	   $this->Tiposclasesequiposmodel->sincronizar_bds();
		 
		 redirect('/tipos/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el tipo. Existen equipos registrados de este tipo.",
	 	  "url"=>"/index.php/inicio/administracion");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
	 }
	}	




	public function get_sub_category(){
		$this->load->model('android/Equiposmodel');
        $category_id = $this->input->post('TIPO',TRUE);
        $data = $this->Equiposmodel->get_sub_category($_POST['TIPO'])->result();
        echo json_encode($data);
    }

	public function get_sub_category2(){
		$this->load->model('android/Equiposmodel');
        $category_id = $this->input->post('TIPO',TRUE);
        $data = $this->Equiposmodel->get_sub_category2($_POST['MARCA'],$_POST['TIPO'])->result();
        echo json_encode($data);
    }

	public function get_sub_category3(){
		$this->load->model('android/Equiposmodel');
        $category_id = $this->input->post('TIPO',TRUE);
        $data = $this->Equiposmodel->get_sub_category3($_POST['MODELO'],$_POST['MARCA'],$_POST['TIPO'])->result();
        echo json_encode($data);
    }
	
	
	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */