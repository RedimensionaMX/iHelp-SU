<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Precios extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->output->enable_profiler(FALSE);
    }

    public function index(){
        $this->load->model('Serviciosmodel');
        $this->load->model('Preciosmodel');		
		$busca_nombre = "";
        $wh = "";
        $lim = $this->uri->segment(3,'2');
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			$wh = " where (1=1) ";
			if ((isset($_POST['clase'])) && ($_POST['clase']!="")) {
				$wh .= " and ((clase='" . $_POST['clase'] . "') or (clase like '%" . $_POST['clase'] . " %'))";				 
			}	  
			//$arr = ( $this->db->query('select * from catservicios ' . $wh /*. ' limit ' . $lim . ',20'*/));
		    //$data['result'] = ($arr->result_array());
		    //echo $where; die();
		    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
	        /*$arrt = ( $this->db->query('select * from clases order by clase'));
	        $clases = ($arrt->result_array());*/	
	        $clases = $this->Preciosmodel->get();
			$cla = array(""=>"Seleccionar dispositivo");
			foreach ($clases as $clase) {
				$cla[$clase["clase"]] = $clase["descripcion"];
			}	
	        $data['clases'] = $cla;
			$data['clase'] = (isset($_POST['clase']) ? $_POST['clase'] : "");
			$this->load->view('inicio/top1'); 
			$this->load->view('precios/preciosindex',$data); 
			$this->load->view('inicio/bottom1'); 
  	    } else {
			if ($lim != "") { 
				$wh = " where (1=1) ";
				$wh .= " and ((clase='" . $lim . "') or (clase like '%" . $lim . " %'))";	  
				//$arr = ( $this->db->query('select * from catservicios ' . $wh /*. ' limit ' . $lim . ',20'*/));
			    //$data['result'] = ($arr->result_array());
			    //echo $where; die();
			    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
		        /*$arrt = ( $this->db->query('select * from clases order by clase'));
		        $clases = ($arrt->result_array());*/	
		        $clases = $this->Preciosmodel->get();
				$cla = array(""=>"Seleccionar dispositivo");
				foreach ($clases as $clase) {
					$cla[$clase["clase"]] = $clase["descripcion"];
				}	
		        $data['clases'] = $cla;
				$data['clase'] = $lim;
				$this->load->view('inicio/top1'); 
				$this->load->view('precios/preciosindex',$data); 
				$this->load->view('inicio/bottom1'); 
	  	    } else {
		    	$registro = array();
	        	$clases = $this->Preciosmodel->get();
				$cla = array(""=>"Seleccionar dispositivo");
				foreach ($clases as $clase) {
					$cla[$clase["clase"]] = $clase["descripcion"];
				}	
				$registro['clases'] = $cla;	
				//print_r(count($registro['clases']));
			    $this->load->view('inicio/top1'); 
				$this->load->view('servicios/seleccionarclase',$registro); 
				$this->load->view('inicio/bottom1');
			}
		}
	}

	public function index2()
	{
        $this->load->model('Serviciosmodel');
        $this->load->model('Clasesmodel');		
		$busca_nombre = "";
        $wh = "";
        $lim = $this->uri->segment(3,'2');
		echo $lim;
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			$wh = " where (1=1) ";
			if ((isset($_POST['busca_descripcion'])) && ($_POST['busca_descripcion']!="")) 
				$wh .= " and (descripcion like '" . $_POST['busca_descripcion'] . "%')";	
			if ((isset($_POST['clase'])) && ($_POST['clase']!="")) {
				$wh .= " and ((clase='" . $_POST['clase'] . "') or (clase like '%" . $_POST['clase'] . " %'))";				 
			}	  
			//$arr = ( $this->db->query('select * from catservicios ' . $wh /*. ' limit ' . $lim . ',20'*/));
		    //$data['result'] = ($arr->result_array());
		    //echo $where; die();
		    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
	        /*$arrt = ( $this->db->query('select * from clases order by clase'));
	        $clases = ($arrt->result_array());*/	
	        $clases = $this->Clasesmodel->get();
			$cla = array(""=>"Seleccionar clase");
			foreach ($clases as $clase) {
				$cla[$clase["clase"]] = $clase["descripcion"];
			}	
	        $data['clases'] = $cla;
			$data['clase'] = (isset($_POST['clase']) ? $_POST['clase'] : "");
			$this->load->view('inicio/top1'); 
			$this->load->view('servicios/serviciosindex',$data); 
			$this->load->view('inicio/bottom1'); 
  	    } else {
	    	$registro = array();
        	$clases = $this->Clasesmodel->get();
			$cla = array(""=>"Seleccionar clase");
			foreach ($clases as $clase) {
				$cla[$clase["clase"]] = $clase["descripcion"];
			}	
			$registro['clases'] = $cla;	
			//print_r(count($registro['clases']));
		    $this->load->view('inicio/top1'); 
			$this->load->view('servicios/seleccionarclase',$registro); 
			$this->load->view('inicio/bottom1');
		}
	}
	
	public function agregar() {
		 $r = array("mensaje"=>"Esta funci&oacute;n ahora se realiza desde el m&oacute;dulo de cat&aacute;logos.",
		 	  "url"=>"/index.php/servicios");
         $this->load->view('inicio/top1'); 
		 $this->load->view('comun/mensaje',$r); 
		 $this->load->view('inicio/bottom1'); 		
	}
	
	public function modificar() {
		 $r = array("mensaje"=>"Esta funci&oacute;n ahora se realiza desde el m&oacute;dulo de cat&aacute;logos.",
		 	  "url"=>"/index.php/servicios");
         $this->load->view('inicio/top1'); 
		 $this->load->view('comun/mensaje',$r); 
		 $this->load->view('inicio/bottom1');         
	}	
	
	
	
	public function guardar() {
		 $r = array("mensaje"=>"Esta funci&oacute;n ahora se realiza desde el m&oacute;dulo de cat&aacute;logos.",
		 	  "url"=>"/index.php/servicios");
         $this->load->view('inicio/top1'); 
		 $this->load->view('comun/mensaje',$r); 
		 $this->load->view('inicio/bottom1'); 
	}	



public function eliminar() {
		 $r = array("mensaje"=>"Esta funci&oacute;n ahora se realiza desde el m&oacute;dulo de cat&aacute;logos.",
		 	  "url"=>"/index.php/servicios");
         $this->load->view('inicio/top1'); 
		 $this->load->view('comun/mensaje',$r); 
		 $this->load->view('inicio/bottom1'); 
	   
	}

	
	
	public function detalleserviciojson()
	{		
		if ($this->uri->segment(3,'')!="")
			  $wh = " where id='" . $this->uri->segment(3,'') . "'";
	    else  $wh = "";

	    $this->load->model("Serviciosmodel");
	    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
		//$arr =  $this->db->query("select * from catservicios" . $wh);
	    //$data['result'] = ($arr->result_array());
        // print_r($data['result']); die();
		$this->load->view('servicios/detalleserviciojson',$data); 
	}
	



	
}
