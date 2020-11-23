<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {
	public function index(){
		//Carga del modelo
		$this->load->model('Clientesmodel');
		//Creación de criterio de búsqueda
		$wh = " where (1=1) ";
		//Asignación de variable -> Nombre ingresado por el usuario
		$criterio = $this->uri->segment(3,'');
		//Asignación de variable -> Nombre/Correo ingresado por el usuario
		$busca_nombre = $this->uri->segment(4,'');
		//Asignación de variable -> Sucursal solicitada por el usuario
		$sucursal = $this->uri->segment(5,'');
		//Eliminación de posibles acentos
		$busqueda = str_replace("%20", " ", $busca_nombre);
		//CARGA SIN FILTROS
		if($criterio == "" OR $criterio >="20"){
			//Obtención de segmento adicional en la URL (Límite de búsqueda)
			$lim = $this->uri->segment(3,'0');
			//URL sobre la que se paginará
			$config['base_url'] = '/index.php/clientes/index/';
		}				
		if($busca_nombre !=""){
			if($busca_nombre <"=20"){
				//URL sobre la que se paginará
				$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/';
				//Paginación de búsqueda de clientes por sucursal
				if($criterio == "XC1" OR $criterio == "CD1" OR $criterio == "CQ1" OR $criterio == "CL1" OR $criterio == "CS1" OR $criterio == "CZ1" OR $criterio == "MG1" OR $criterio == "MI2" OR $criterio == "OZ1" OR $criterio == "PA1" OR $criterio == "PR1" OR $criterio == "TX1" OR $criterio == "VA1" OR $criterio == "VB1" OR $criterio == "VM1" OR $criterio == "VM2" OR $criterio == "XA1" OR $criterio == "XU1"){
					//Creación de criterio de búsqueda
					$wh = " where sucursal_id = '".$criterio."' ";
					//Obtención de segmento adicional en la URL (Límite de búsqueda)
					$lim = $this->uri->segment(4,'0');
				}else{
					//Obtención de segmento adicional en la URL (Límite de búsqueda)
					$lim = $this->uri->segment(3,'0');
				}
			}else{
				//Si realiza búsqueda por nombre
				if($criterio == 0){
					//Búsqueda por nombre sin sucursal
					if($sucursal ==""){
						//URL sobre la que se paginará
						$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/';
						//Creación de criterio de búsqueda
						$wh = " where UPPER(NOMBRE) like UPPER('%" . $busqueda . "%')";
						//Obtención de segmento adicional en la URL (Límite de búsqueda)
						$lim = $this->uri->segment(5,'0');
					}else{
						//Búsqueda por nombre con sucursal
						if($sucursal == "XC1" OR $sucursal == "CD1" OR $sucursal == "CQ1" OR $sucursal == "CL1" OR $sucursal == "CS1" OR $sucursal == "CZ1" OR $sucursal == "MG1" OR $sucursal == "MI2" OR $sucursal == "OZ1" OR $sucursal == "PA1" OR $sucursal == "PR1" OR $sucursal == "TX1" OR $sucursal == "VA1" OR $sucursal == "VB1" OR $sucursal == "VM1" OR $sucursal == "VM2" OR $sucursal == "XA1" OR $sucursal == "XU1"){
							//URL sobre la que se paginará
							$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/'.$sucursal.'/';
							//Creación de criterio de búsqueda
							$wh = " where UPPER(NOMBRE) like UPPER('%" . $busqueda . "%') and sucursal_id = '" .$sucursal."'";
							//Obtención de segmento adicional en la URL (Límite de búsqueda)
							$lim = $this->uri->segment(6,'0');
						}else{
						//Paginación de búsqueda por nombre sin sucursal
							//URL sobre la que se paginará
							$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/';
							//Creación de criterio de búsqueda
							$wh = " where UPPER(NOMBRE) like UPPER('%" . $busqueda . "%')";
							//Obtención de segmento adicional en la URL (Límite de búsqueda)
							$lim = $this->uri->segment(5,'0');
						}
					}
				}else{
				//Si realiza búsqueda por correo
					if($criterio == 1){
						if($sucursal ==""){
							//URL sobre la que se paginará
							$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/';
							//Creación de criterio de búsqueda
							$wh = " where UPPER(correo_electronico) like UPPER('%" . $busqueda . "%')";
							//Obtención de segmento adicional en la URL (Límite de búsqueda)
							$lim = $this->uri->segment(5,'0');
						}else{
							//Búsqueda por correo con sucursal
							if($sucursal == "XC1" OR $sucursal == "CD1" OR $sucursal == "CQ1" OR $sucursal == "CL1" OR $sucursal == "CS1" OR $sucursal == "CZ1" OR $sucursal == "MG1" OR $sucursal == "MI2" OR $sucursal == "OZ1" OR $sucursal == "PA1" OR $sucursal == "PR1" OR $sucursal == "TX1" OR $sucursal == "VA1" OR $sucursal == "VB1" OR $sucursal == "VM1" OR $sucursal == "VM2" OR $sucursal == "XA1" OR $sucursal == "XU1"){
								//URL sobre la que se paginará
								$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/'.$sucursal.'/';
								//Creación de criterio de búsqueda
								$wh = " where UPPER(correo_electronico) like UPPER('%" . $busqueda . "%') and sucursal_id = '" .$sucursal."'";
								//Obtención de segmento adicional en la URL (Límite de búsqueda)
								$lim = $this->uri->segment(6,'0');
							}else{
							//Paginación de búsqueda por correo sin sucursal
								//URL sobre la que se paginará
								$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/'.$busqueda.'/';
								//Creación de criterio de búsqueda
								$wh = " where UPPER(correo_electronico) like UPPER('%" . $busqueda . "%')";
								//Obtención de segmento adicional en la URL (Límite de búsqueda)
								$lim = $this->uri->segment(5,'0');
							}
						}
					}else{
						//Creación de criterio de búsqueda
						$wh = " where sucursal_id = '".$criterio."' ";
						//Obtención de segmento adicional en la URL (Límite de búsqueda)
						$lim = $this->uri->segment(5,'0');
					}
				}
			}
		}else{
		//PAGINACIÓN SIN FILTROS
			//URL sobre la que se paginará
			$config['base_url'] = '/index.php/clientes/index/' .$criterio.'/';
			if($criterio == "XC1" OR $criterio == "CD1" OR $criterio == "CQ1" OR $criterio == "CL1" OR $criterio == "CS1" OR $criterio == "CZ1" OR $criterio == "MG1" OR $criterio == "MI2" OR $criterio == "OZ1" OR $criterio == "PA1" OR $criterio == "PR1" OR $criterio == "TX1" OR $criterio == "VA1" OR $criterio == "VB1" OR $criterio == "VM1" OR $criterio == "VM2" OR $criterio == "XA1" OR $criterio == "XU1"){
				//Creación de criterio de búsqueda
				$wh = " where sucursal_id = '".$criterio."' ";
				//Obtención de segmento adicional en la URL (Límite de búsqueda)
				$lim = $this->uri->segment(4,'0');
			}else{
				//Obtención de segmento adicional en la URL (Límite de búsqueda)
				$lim = $this->uri->segment(3,'0');
			}
		}
		//Si existe búsqueda durante paginación
		if($this->input->post('busquedaNombre')){
			$nombre = $this->input->post('busquedaNombre');
			//Recursividad para iniciar paginación con criterio de búsqueda
			redirect('clientes/index/0/' . $this->input->post('busquedaNombre'));
		}else{
			if($this->input->post('busquedaCorreo')){
				$nombre = $this->input->post('busquedaCorreo');
				//Recursividad para iniciar paginación con criterio de búsqueda
				redirect('clientes/index/1/' . $this->input->post('busquedaCorreo'));
			}
		}
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Obtención de sucursales
		$data['sucursales'] = $this->Clientesmodel->get_sucursales_dropdown();
		$data['sucursal']['NE'] = "Selecciones una sucursal";
		$data['sucursal'] = $this->uri->segment(4,'NE');
		//Filtrado de resultados
		$data['result'] = $this->Clientesmodel->get_clientes_where_str($wh,$lim,20);
		//Búsqueda total en la tabla de clientes
		$arrtot = ( $this->db->query('select count(*) from clientes '. $wh . ''));
		//Obtención de array
		$datas = $arrtot->result_array();
		//Declaración del total de filas por enlistar
		$config['total_rows'] = $datas[0]['count'];
		//Resultados por página
		$config['per_page'] = 20; 
		//Inicialización y paso de variable para paginación
		$this->pagination->initialize($config); 
		//Carga de las vistas
		$this->load->view('inicio/top1');
		//Carga de la vista y envío de datos (Vista, Datos) 
		$this->load->view('clientes/clientesindex',$data);
		$this->load->view('inicio/bottom1'); 
	}
	
	public function clientesjson()
	{		
    	$arr =  $this->db->query("select * from clientes order by nombre");
	    $data['result'] = ($arr->result_array());
		$this->load->view('clientes/clientesjson',$data); 
	}

	public function nombreclientejson()
	{		
    	$arr =  $this->db->query("select * from clientes where id=" . $this->uri->segment(3,'0'));
	    $data['result'] = ($arr->result_array());
		$datacli['result'] = $data['result'][0];
		$this->load->view('clientes/nombreclientejson',$datacli); 
	}
	
	public function buscar() 
	{   
		$this->load->view('inicio/top_single1');
	    $this->load->view('clientes/buscar'); 
		$this->load->view('inicio/bottom_single1');
	}
	
	public function cerrarresultados() {
 		$this->load->view('inicio/top_single1');
	    $this->load->view('clientes/cerrarresultados'); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function resultados() {
        $wh = " where (1=1) ";
		$pendientes = "S";
		$busca_nombre = "";
		if (count($_POST)>0) { 
			$wh = " where (1=1) ";
			if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!=""))  {
				$wh .= " and (nombre like '" . $_POST['busca_nombre'] . "%')";				 
				$busca_nombre = $_POST['busca_nombre']; 		
			}  
		}	
		
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query('select * from clientes ' . $wh . ' limit ' . $lim . ',10'));
	    $data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/clientes/resultados';
		$arrtot = ( $this->db->query('select * from clientes'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 10; 
		$data['busca_nombre'] = $busca_nombre;
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top_single1'); 
		 $this->load->view('clientes/resultados',$data); 
		 $this->load->view('inicio/bottom_single1'); 	
	
	}
	
	public function agregar() {
		$this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_campos();
		$registro['desdeequipo'] = "N";
		//print_r ($registro);
		$this->load->view('inicio/top1');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}
	
	public function agregardesdeequipos() {
		$this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_campos();
		$registro['desdeequipo'] = "S";

        //$registro = array("id"=>"","nombre"=>"","telefono1"=>"","telefono2"=>"","direccion"=>"","correo_electronico"=>"","desdeequipo"=>"S");
		$this->load->view('top_single');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function modificar() {
        $this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_detalle($this->uri->segment(3));
		$this->load->view('inicio/top1');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}	
	
	public function enviarcorreo() {
        $arr = ( $this->db->query('select * from clientes where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array()); 
		$registro = $data[0];
		$registro["desdeequipo"] = "N";
		//print_r($registro); die(); 
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('clientes/correoacliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}	

	public function correoenviar() {
        $this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_detalle($_POST['id']);
		 
$this->load->library('email');

$this->email->from('hospitaldeipods@disisweb.com', 'Hospital de IPODS');
$this->email->to($registro['correo_electronico']);  

$this->email->subject('Hospital de iPods');
$this->email->message($_POST['mensaje']);	

$this->email->send();		
		redirect("/clientes/modificar/" . $_POST['id']);
	/*	$this->load->view('inicio/top1');
		$this->load->view('inicio/menuinterior');
		$this->load->view('clientes/correoacliente',$registro); 
		$this->load->view('inicio/bottom1');
	
	 */		
	}	
	
	
	public function eliminar() {
     $arr = ( $this->db->query('select * from equipos where cliente_id=' . $this->uri->segment(3)));
     if ($arr->num_rows==0) {
     	$this->db->query('delete from clientes where id=' . $this->uri->segment(3));
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "clientes",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/clientes/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el cliente. Existen equipos asignados.",
	 	  "url"=>"/index.php/clientes");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom_single1');
		 	
	 	
	 }
	   // $data = ($arr->result_array()); 
		//$registro = $data[0];
			
		
	}
	
	
	
	public function guardar() {
        unset($_POST['submit']);
		unset($_POST['enviardatos']);
		$accion = $_POST['accion'];
		$desdeequipo = $_POST['desdeequipo'];
        unset($_POST['accion']);
		unset($_POST['desdeequipo']);
		
		if ($accion=="i") {
			
			$_POST['telefono1'] =  $_POST['telefono1a'] . "-" . $_POST['telefono1b'] . "-" . $_POST['telefono1c'];
		    $_POST['telefono2'] =  $_POST['telefono2a'] . "-" . $_POST['telefono2b'] . "-" . $_POST['telefono2c'];			              
		    unset($_POST['telefono1a']);
			unset($_POST['telefono1b']);
			unset($_POST['telefono1c']);
			unset($_POST['telefono2a']);
			unset($_POST['telefono2b']);
			unset($_POST['telefono2c']);
		   
			
		   $this->db->insert('clientes',$_POST);
		   $lastid = $this->db->insert_id();
		   $_POST['id'] = $lastid;
          
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "NUEVO",
			                 "tabla"   => "clientes",
			                 "detalle" => $lastid . " " . $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);
			
		   if ($desdeequipo=="N")
		        redirect('/clientes/'); 
           else {
           	//print_r($_POST);
              $this->load->view('top_single');
		      $this->load->view('clientes/cerrartopactualizarselect',$_POST); 
		      $this->load->view('inicio/bottom_single1');				
		    }
		}
		else { // ELSE DE ACCION
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('clientes', $_POST);	
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "clientes",
			                 "detalle" => $_POST['id'] . " " . $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);
			
		    redirect('/clientes/modificar/' . $_POST['id']);			 
		 }
		
	}


   public function pdf() {
   	$this->load->library('Pdf');

$pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

$pdf->Image(dirname(__FILE__) . '/../libraries/imagenes/encabezadoHI.jpg', 5, 5, 200, 20, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
//$pdf->Image($file)
//$pdf->writeHTMLCell(200, 100, 100, 100,"HOLA");
//$pdf->writeHTML("ABCDEFG");
$html = '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=100, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
//$pdf->Write(50, 'Some sample text');
$pdf->Output('My-File-Name.pdf', 'I'); 
   }	
	
	
}

