<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prospectos extends CI_Controller {
	public function index(){
		$this->load->model('Prospectosmodel');
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
			$data["fecha_recibido"] = fecha_actual_mysql();
			$data['prospectos'] = $this->Prospectosmodel->get_prospectos($this->uri->segment(3),$this->uri->segment(4));
			$this->load->view('inicio/top1');
			$this->load->view('prospectos/checkboxsucursales');
			$this->load->view("prospectos/prospectosindex",$data);
			$this->load->view('inicio/bottom1');
		} else {
			$data['prospectos'] = $this->Prospectosmodel->get_prospectos_filtro($sucursales_seleccionadas, $this->input->post("anios")."", $this->input->post("mes"));
			$data["fecha_recibido"] = fecha_actual_mysql();
			$this->load->view('inicio/top1');
			$this->load->view('prospectos/checkboxsucursales');
			$this->load->view("prospectos/prospectosindex",$data);
			$this->load->view('inicio/bottom1');
		}
		// if (count($_POST)>0) {
		// 	if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!=""))  {
		// 		$wh .= " and (p.nombre like '%" . $_POST['busca_nombre'] . "%')";
		// 		$busca_nombre = $_POST['busca_nombre'];
		// 	}
		// 	$data['busca_nombre'] = $busca_nombre;
		// 	$lim = 0;
		// 	$pgnum = 10000;
		// 	$data['buscando'] = TRUE;
		// } else {
		// 	$this->load->library('pagination');
		// 	$config['base_url'] = '/index.php/prospectos/index';
		// 	$config['total_rows'] = $this->Prospectosmodel->get_num_prospectos();
		// 	$config['num_links'] = 7;
		// 	$config['per_page'] = 20;
		// 	$config['first_link'] = 'Primero';
		// 	$config['last_link'] = 'Ultimo';
		// 	$data['busca_nombre'] = $busca_nombre;
		// 	$this->pagination->initialize($config);
		// 	$lim = $this->uri->segment(3,'0');
		// 	$pgnum = 20;
		// 	$data['buscando'] = FALSE;
		// }
        // $data['result'] = $this->Prospectosmodel->get_prospectos_where_str($wh,$lim,$pgnum);
        // $data["fecha_recibido"] = fecha_actual_mysql();
		// $this->load->view('inicio/top1');
		// $this->load->view('prospectos/checkboxsucursales');
		// $this->load->view('prospectos/prospectosindex',$data);
		// $this->load->view('inicio/bottom1');
	}

	public function nuevo() {
		$this->load->model('Clientesmodel');
		$this->load->model('Prospectosmodel');
		$tip1 = $this->Prospectosmodel->get_tipos_dropdown();
		$tipant = array(""=>"Selecciona el tipo");
		$tip = array_merge($tipant,$tip1);
		$registro = $this->Prospectosmodel->get_campos();
        $query = $this->db->query("select * from SUCURSALES");
        $registro['sucursal'] = $query->result_array();
		$registro['equipo_id'] = $this->Prospectosmodel->get_tipos()->result();
		$registro['desdeequipo'] = "N";
        $registro["fecha_recibido"] = fecha_actual_mysql();
		$this->load->view('inicio/top1');
		$this->load->view('prospectos/detallecliente',$registro);
		$this->load->view('inicio/bottom1');
	}

	public function agregardesdeequipos() {
		$this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_campos();
		$registro['desdeequipo'] = "S";
		$this->load->view('top_single');
		$this->load->view('clientes/detallecliente',$registro);
		$this->load->view('inicio/bottom_single1');
	}

	public function buscar(){
		$this->load->view('inicio/top_single1');
	    $this->load->view('clientes/buscar');
		$this->load->view('inicio/bottom_single1');
	}

	public function cerrarresultados() {
		$this->load->view('inicio/top_single1');
	    $this->load->view('clientes/cerrarresultados');
		$this->load->view('inicio/bottom_single1');
	}

	public function clientesjson(){
		$arr =  $this->db->query("select * from clientes order by nombre");
	    $data['result'] = ($arr->result_array());
		$this->load->view('clientes/clientesjson',$data);
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
	}

	public function eliminar() {
		$this->db->query('delete from prospectos where id=' . $this->uri->segment(3));
		// REGISTRO DE ACCIONES
		$registroacc = array(
			"usuario" => $this->session->userdata('usuario'),
			"usuario_id" => $this->session->userdata('usuario_id'),
			"fecha_hora" => date ("Y-m-d H:i:s"),
			"accion"  => "ELIMINADO",
			"tabla"   => "prospectos",
			"detalle" => "ID: " . $this->uri->segment(3)
		);
		$this->db->insert('registroacciones',$registroacc);
		redirect('/prospectos/');
	}

	public function enviarcorreo() {
        $arr = ( $this->db->query('select * from clientes where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array()); 
		$registro = $data[0];
		$registro["desdeequipo"] = "N";
		$this->load->view('inicio/top1');
		$this->load->view('clientes/correoacliente',$registro);
		$this->load->view('inicio/bottom1');
	}

	public function guardar() {
		$this->load->model("Prospectosmodel");
        unset($_POST['submit']);
		unset($_POST['enviardatos']);
		$accion = $_POST['accion'];
		$desdeequipo = $_POST['desdeequipo'];
        unset($_POST['accion']);
		unset($_POST['desdeequipo']);
		if ($accion=="i") {
			$query = $this->db->query("select first 1 id from prospectos order by id desc");
			$ultimoID = $query->result_array();
			$query = $this->db->query("select id from sucursales where sucursal_id = '".$_POST['sucursal_id']."'");
			$sucursal = $query->result_array();
			$_POST['sucursal_id'] = $sucursal[0]['id'];
			if (empty($ultimoID)){
				$ultimoID[0]['id']=0;
			}
			if($ultimoID[0]['id']>=1){
				$ultimoID[0]['id'] = $ultimoID[0]['id'] +1;
			} else {
				$ultimoID[0]['id'] = 1;
			}
			$_POST['id'] = $ultimoID[0]['id'];
			$this->db->insert('prospectos',$_POST);
			$lastid = $this->db->insert_id();
			$_POST['id'] = $lastid;
			$registroacc = array(
				"usuario" => $this->session->userdata('usuario'),
				"usuario_id" => $this->session->userdata('usuario_id'),
				"fecha_hora" => date ("Y-m-d H:i:s"),
				"accion"  => "NUEVO",
				"tabla"   => "prospectos",
				"detalle" => $lastid . " " . $_POST['nombre']);
			$this->db->insert('registroacciones',$registroacc);
			redirect('/prospectos/');
		}
		else { // ELSE DE ACCION
			$query = $this->db->query("select id from sucursales where sucursal_id = '".$_POST['sucursal_id']."'");
			$sucursal = $query->result_array();
			$_POST['sucursal_id'] = $sucursal[0]['id'];
			$this->Prospectosmodel->guardar($_POST);
		    if ($_POST['tipoventana']=="frame") {
        		$this->load->view('inicio/top_single1');
				$this->load->view('clientes/cerrartop');
				$this->load->view('inicio/bottom_single1');
		    }
		    else
		    	redirect('/prospectos/');
		}
	}

	public function modificar() {
        $this->load->model('Prospectosmodel');
		$registro = $this->Prospectosmodel->get_detalle($this->uri->segment(3));
        $arr2 = $this->db->query("select * from TIPOS where CLASE ='".$registro['equipo_id']."'");
		$arr3 = $this->db->query("select * from TIPOS where CLASE !='".$registro['equipo_id']."' order by clase asc");
		$data2 = $arr2->result_array();
		$data3 = $arr3->result_array();
		$arr4 = $this->db->query("select * from catservicios where descripcion='".$registro['reparacion_id']."' and clase='" . $registro['equipo_id'] . "'");
		$arr5 = $this->db->query("select * from catservicios where descripcion!='".$registro['reparacion_id']."' and clase='" . $registro['equipo_id'] . "'");
		$data4 = $arr4->result_array();
		$data5 = $arr5->result_array();
		$registro['reparacion_id'] = array_merge($data4,$data5);
		$arr6 = $this->db->query("select * from sucursales where id='".$registro['sucursal_id']."'");
		$arr7 = $this->db->query("select * from sucursales where id!='".$registro['sucursal_id']."'");
		$data6 = $arr6->result_array();
		$data7 = $arr7->result_array();
		$registro['sucursal'] = array_merge($data6,$data7);
		$registro['equipo_id'] = array_merge($data2,$data3);
        $registro['fecha_recibido'] = $registro['fecha'];
        $registro['A']="A";
        $this->load->view('inicio/top1');
		$this->load->view('prospectos/detallecliente',$registro);
		$this->load->view('inicio/bottom1');
	}

	public function modificarframe() {
        $this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_detalle($this->uri->segment(3));
		$registro['esta_sucursal'] = $this->session->sucursal_id;
		$this->load->view('inicio/top_single1');
		$this->load->view('clientes/detallecliente',$registro);
		$this->load->view('inicio/bottom_single1');
	}

	public function nombreclientejson(){
		$arr =  $this->db->query("select * from clientes where id=" . $this->uri->segment(3,'0'));
	    $data['result'] = ($arr->result_array());
		$datacli['result'] = $data['result'][0];
		$this->load->view('clientes/nombreclientejson',$datacli);
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

	public function resultados() {
		$this->load->model("Clientesmodel");
        $wh = " where (nombre<>'') ";
		$pendientes = "S";
		$busca_nombre = "";
		$data['busca_nombre'] = $busca_nombre;
		$data['result'] = $this->Clientesmodel->resultados($_POST);
		$this->load->view('inicio/top_single1');
		$this->load->view('clientes/resultados',$data);
		$this->load->view('inicio/bottom_single1');
	}

	public function get_reparaciones(){
		$this->load->model('Prospectosmodel');
        $data = $this->Prospectosmodel->get_reparaciones($_POST['TIPO'])->result();
		//print_r($data);
        echo json_encode($data); 
    }
}