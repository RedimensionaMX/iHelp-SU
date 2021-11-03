<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {
	public function index()	{
    //Búsqueda de usuario registrado en el sistema
		if ($this->session->userdata('nivel')==1) {
      $this->load->model('Reportesmodel');
      $listareportes = $this->Reportesmodel->GetListaReportes();
      $data['listareportes'] = $listareportes;
      $this->load->view('inicio/top1');
      $this->load->view('reportes/reportesindex',$data);
      $this->load->view('inicio/bottom1');
		}
  }

	public function accesoriosdiafranquicias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "CO1";
      $sucursales_seleccionadas[1] = "CS1";
      $sucursales_seleccionadas[2] = "PC1";
      $sucursales_seleccionadas[3] = "PR1";
      $sucursales_seleccionadas[4] = "VM1";
      $sucursales_seleccionadas[5] = "VM2";
      $sucursales_seleccionadas[6] = "VR1";
      $sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosdiafranquiciasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "CO1";
      $sucursales_seleccionadas[1] = "CS1";
      $sucursales_seleccionadas[2] = "PC1";
      $sucursales_seleccionadas[3] = "PR1";
      $sucursales_seleccionadas[4] = "VM1";
      $sucursales_seleccionadas[5] = "VM2";
      $sucursales_seleccionadas[6] = "VR1";
      $sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_dia_resumen($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosdiapropias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "TX1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosdiapropiasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "TX1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_dia_resumen($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      // $this->load->view("reportes/accesoriosrecibidosgrafico",$data);
      $this->load->view("reportes/cierredemesvariosprueba",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosmesfranquicias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "CO1";
      $sucursales_seleccionadas[1] = "CS1";
      $sucursales_seleccionadas[2] = "PA1";
      $sucursales_seleccionadas[3] = "PR1";
      $sucursales_seleccionadas[4] = "VM1";
      $sucursales_seleccionadas[5] = "VM2";
      $sucursales_seleccionadas[6] = "VR1";
      $sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_mes($sucursales_seleccionadas, $anio, $mes);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosmesfranquiciasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "CO1";
      $sucursales_seleccionadas[1] = "CS1";
      $sucursales_seleccionadas[2] = "PC1";
      $sucursales_seleccionadas[3] = "PR1";
      $sucursales_seleccionadas[4] = "VM1";
      $sucursales_seleccionadas[5] = "VM2";
      $sucursales_seleccionadas[6] = "VR1";
      $sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_mes_resumen($sucursales_seleccionadas, $anio, $mes);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
      $this->load->view('inicio/bottom1');
    }
  }

	public function accesoriosmespropias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "TX1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_mes($sucursales_seleccionadas, $anio, $mes);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosmespropiasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "TX1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_mes_resumen($sucursales_seleccionadas, $anio, $mes);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function accesoriosPorSucursalPorMes() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = [];
      $j = 0;
      for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) {
        if($this->input->post($sucursales_keys[$i]) == true){ //Pregunta si el item con id o name esta activado
          $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
          $j++;
        }
      }
      if(empty($sucursales_seleccionadas)){
        $data['cierredemes'] = $sucursales_seleccionadas;
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsucursalesaccesorios');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      } else {
        $data['cierredemes'] = $this->Equiposmodel->get_accesorios_sucursales_mes($sucursales_seleccionadas, $this->input->post("anios"), $this->input->post("mes"));
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsucursalesaccesorios');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

	public function accesoriosVariables() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = [];
      $j = 0;
      for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) {
        if($this->input->post($sucursales_keys[$i]) == true){ //Pregunta si el item con id o name esta activado
          $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
          $j++;
        }
      }
      if(empty($sucursales_seleccionadas)){
        $data['cierredemes'] = $sucursales_seleccionadas;
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxaccesorios');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      } else {
        $data['cierredemes'] = $this->Equiposmodel->get_accesorios_varios($sucursales_seleccionadas, $this->input->post("anios"), $this->input->post("mes"));
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxaccesorios');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function cierredemes() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      if ($this->uri->segment(3,'')=='') {
        redirect('/reportes/cierredemes/' . date("Y") . "/" . date("n") . "/XA1");
      }
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion($this->uri->segment(5),$this->uri->segment(3),$this->uri->segment(4));
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesculiacan() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['CS1'];
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesculiacanprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['CS1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
      //$mes='08';
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_pruebaMes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesframboyanes() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['VF1'];
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesframboyanesprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VF1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
      //$mes='08';
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_pruebaMes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }

  public function cierredemespozarica() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemespozaricaprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['PR1', 'TX1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_pruebaMes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesriviera() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['VR1'];
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesrivieraprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VR1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
      //$mes='08';
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_pruebaMes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesvarios() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = [];
      $j = 0;
      for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) {
        if($this->input->post($sucursales_keys[$i]) == true){ //Pregunta si el item con id o name esta activado
          $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
          $j++;
        }
      }
      if(empty($sucursales_seleccionadas)){
        $data['cierredemes'] = $sucursales_seleccionadas;
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsucursales');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      } else {
        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $this->input->post("anios"), $this->input->post("mes"));
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsucursales');
        $this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function cierredemesvillahermosa() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemes",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function cierredemesvillahermosaprueba() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Búsqueda de usuario registrado en el sistema
		if ($this->session->userdata('nivel')==0) {
			//Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VM1', 'VM2'];
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
      $dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_pruebaMes($sucursales_seleccionadas, $anio, $mes, $dia);
			//Carga de las vistas
			$this->load->view('inicio/top1');
			//Carga de la vista y paso de datos (Vista, Datos)
			$this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function comunicadosfranquicias(){
    $this->load->model("Comunicacionesmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
    $usuario = $this->uri->segment(3,'4');
    $usuarios = ['hefziba','Jaqueline','marianaRdgz','ccastillejos',''];
    $registro['comunicados'] = $this->Comunicacionesmodel->get_comunicados_sucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['hefziba', 'ivonnemtz','Jaqueline','marianaRdgz','ccastillejos'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('comunicaciones/comunicados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function comunicadospropias(){
    $this->load->model("Comunicacionesmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = ['XA1', 'XC1', 'XU1', 'VA1', 'CZ2', 'CL1', 'OZ1', 'TX1'];
    $usuario = $this->uri->segment(3,'10');
    $usuarios = ['aarmas', 'abiojeda', 'anapaty', 'angelicaver', 'evacabrera', 'jacoborod', 'ivonnemtz', 'paulaortiz','victorelizondo','dianasanchez',''];
    $registro['comunicados'] = $this->Comunicacionesmodel->get_comunicados_sucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['aarmas', 'abiojeda', 'anapaty', 'angelicaver', 'evacabrera', 'jacoborod', 'ivonnemtz', 'paulaortiz','victorelizondo','dianasanchez'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('comunicaciones/comunicados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function detallereporte() {
		$this->load->model('Reportesmodel');
		$result = array();
		$reporte = $_REQUEST['reporte'];
		$result['elementos'] = $this->Reportesmodel->getReporte($reporte);
		$result['tipos'] = $this->Reportesmodel->tiposDropdown();
    $this->load->view('inicio/top1');
		$this->load->view('reportes/detallereporte',$result);
		$this->load->view('inicio/bottom1');
	}

  public function devolucionesPendientesFranquicias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'TX1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosDevoluciones(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosDevoluciones($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function devolucionesPendientesPropias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'VA1', 'XA1', 'XC1', 'XU1','TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosDevoluciones(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosDevoluciones($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function equiposdiaculiacan() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
		if ($this->session->userdata('nivel')==1) {
      //Población de arreglo para sucursales a evaluar
			$sucursales_seleccionadas = ['CS1'];
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado mediante consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiaculiacanprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['CS1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_prueba($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function equiposdiaframboyanes() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
		if ($this->session->userdata('nivel')==1) {
      //Población de arreglo para sucursales a evaluar
			$sucursales_seleccionadas = ['VF1'];
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado mediante consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiaframboyanesprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VF1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_prueba($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

	public function equiposdiafranquicias() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
			//Población del arreglo
			$sucursales_seleccionadas[0] = "CO1";
			$sucursales_seleccionadas[1] = "CS1";
			$sucursales_seleccionadas[2] = "PC1";
			$sucursales_seleccionadas[3] = "PR1";
			$sucursales_seleccionadas[4] = "VM1";
			$sucursales_seleccionadas[5] = "VM2";
			$sucursales_seleccionadas[6] = "VR1";
			$sucursales_seleccionadas[7] = "VF1";
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
			//Carga de las vistas
			$this->load->view('inicio/top1');
			//Carga de la vista y paso de datos (Vista, Datos)
			$this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiapozarica() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
			$sucursales_seleccionadas = ['PR1', 'TX1'];
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado a través de consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y envío de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiapozaricaprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['PR1', 'TX1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_prueba($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function equiposdiapropias() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
			//Población del arreglo
			$sucursales_seleccionadas[0] = "XA1";
			$sucursales_seleccionadas[1] = "XC1";
			$sucursales_seleccionadas[2] = "XU1";
			$sucursales_seleccionadas[3] = "VA1";
			$sucursales_seleccionadas[4] = "CZ1";
			$sucursales_seleccionadas[5] = "CL1";
			$sucursales_seleccionadas[6] = "OZ1";
			$sucursales_seleccionadas[7] = "TX1";
			$sucursales_seleccionadas[8] = "PR1";
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
			//Carga de las vistas
			$this->load->view('inicio/top1');
			//Carga de la vista y paso de datos (Vista, Datos)
			$this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiariviera() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
		if ($this->session->userdata('nivel')==1) {
      //Población de arreglo para sucursales a evaluar
			$sucursales_seleccionadas = ['VR1'];
			//Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado mediante consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
			$this->load->view('inicio/bottom1');
		}
  }

  public function equiposdiarivieraprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VR1'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_prueba($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

	public function equiposdiavillahermosa() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Población del arreglo
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function equiposdiavillahermosaprueba() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = ['VM1', 'VM2'];
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_registrosmes_administracion_varios_dia_prueba($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function equiposEsperaRefaccionFranquicias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosEsperaRefaccion(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosEsperaRefaccion($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function equiposEsperaRefaccionPropias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'VA1', 'XA1', 'XC1', 'XU1','TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosEsperaRefaccion(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosEsperaRefaccion($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

	public function equiposLaboratorioFranquicias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosLaboratorio(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosLaboratorio($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
		}
	}

  public function equiposLaboratorioPropias() {
		//Carga de modelo
		$this->load->model("equipos/Equiposmodel");
		//Carga de la librería de paginación para los resultados
		$this->load->library('pagination');
		//Solo si el usuario se encuentra logueado
		if ($this->session->userdata('nivel')==1) {
		  //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'VA1', 'XA1', 'XC1', 'XU1','TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_registrosLaboratorio(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosLaboratorio($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
		}
	}

  public function equipospordia() {
    $this->load->model("Equiposmodel");
    $equipos_recibidos = $this->Equiposmodel->get_equipos_where_str("where fecha_recibido='" . $_POST['fecha'] . "' order by num_orden ");
    $equipos_entregados = $this->Equiposmodel->get_equipos_where_str("where fecha_de_entrega='" . $_POST['fecha'] . "'  order by num_orden ");
    $data['equipos'] = array_merge($equipos_recibidos,$equipos_entregados);
    $this->load->view('inicio/top1');
		$this->load->view('reportes/equipospordia',$data);
		$this->load->view('inicio/bottom1');
  }

  public function equipospordiaprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
      $sucursales_seleccionadas = [];
      //Población del arreglo
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "CP1";
      //Obtención de la fecha actual en sistema
      $anio = date("Y");
      $mes = 	date("m");
      $dia = 	date("d");
      //Búsqueda de resultado en la consulta
      $data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
	}

  public function equiposreparadosfranquiciasac(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1'.'VF1'];
    $usuario = $this->uri->segment(3,'4');
    $usuarios = ['hefziba','Jaqueline','marianaRdgz','ccastillejos',''];
		$registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparadossucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['hefziba','Jaqueline','marianaRdgz','ccastillejos'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposreparadosfranquiciasat(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
    $usuario = $this->uri->segment(3,'6');
    $usuarios = ['andresM', 'angeln', 'gibrang', 'miguelmontoya','alejandrovasconcelos','StingC',''];
    $registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparadossucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['andresM', 'angeln', 'gibrang', 'miguelmontoya','alejandrovasconcelos','StingC'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposreparadospordia(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $usuario = $this->uri->segment(3,'');
    $registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparados($this->uri->segment(3));
    $registro['usuarios'] = $this->Registroaccionesmodel->get_usuarios_dropdown();
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
		$registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposreparadospropias(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = [];
    $sucursales_seleccionadas[0] = "XA1";
    $sucursales_seleccionadas[1] = "XC1";
    $sucursales_seleccionadas[2] = "XU1";
    $sucursales_seleccionadas[3] = "VA1";
    $sucursales_seleccionadas[4] = "CZ1";
    $sucursales_seleccionadas[5] = "CL1";
    $sucursales_seleccionadas[6] = "OZ1";
    $sucursales_seleccionadas[7] = "CP1";
    $usuario = $this->uri->segment(3,'');
    $registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparadossucursales($usuario,$sucursales_seleccionadas);
    $registro['usuarios'] = $this->Registroaccionesmodel->get_usuarios_dropdown($sucursales_seleccionadas);
    $registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposreparadospropiasac(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = [];
    $sucursales_seleccionadas[0] = "XA1";
    $sucursales_seleccionadas[1] = "XC1";
    $sucursales_seleccionadas[2] = "XU1";
    $sucursales_seleccionadas[3] = "VA1";
    $sucursales_seleccionadas[4] = "CZ1";
    $sucursales_seleccionadas[5] = "CL1";
    $sucursales_seleccionadas[6] = "OZ1";
    $sucursales_seleccionadas[7] = "TX1";
    $usuario = $this->uri->segment(3,'9');
    $usuarios = ['aarmas', 'abiojeda', 'anapaty', 'angelicaver', 'evacabrera', 'jacoborod', 'ivonnemtz', 'paulaortiz','albanyacosta',''];
		$registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparadossucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['aarmas', 'abiojeda', 'anapaty', 'angelicaver', 'evacabrera', 'jacoborod', 'ivonnemtz', 'paulaortiz','albanyacosta'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment($usuarios[$usuario],'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposReajuste(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = [];
    $usuario = $this->uri->segment(3,'8');
    $usuarios = ['XA1', 'XC1', 'XU1', 'VA1', 'CZ1', 'CL1', 'OZ1', 'TX1', ''];
		$registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreajustesucursalespropias($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['XA1', 'XC1', 'XU1', 'VA1', 'CZ1', 'CL1', 'OZ1', 'TX1'];
		$registro['usuarios']['NE'] = "Seleccionar sucursal";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reajuste',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposReajusteFr(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'TX1', 'VM1', 'VM2', 'VR1','VF1'];
    $usuario = $this->uri->segment(3,'9');
    $usuarios = ['CO1','CS1', 'PC1', 'PR1', 'TX1', 'VM1', 'VM2', 'VR1','VF1',''];
		$registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreajustesucursalesfranquicias($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['CO1','CS1', 'PC1', 'PR1', 'TX1', 'VM1', 'VM2', 'VR1','VF1'];
		$registro['usuarios']['NE'] = "Seleccionar sucursal";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reajuste',$registro);
    $this->load->view('inicio/bottom1');
  }

  public function equiposreparadospropiasat(){
    $this->load->model("Bitacorasmodel");
    $this->load->model("Registroaccionesmodel");
    $sucursales_seleccionadas = [];
    $sucursales_seleccionadas[0] = "XA1";
    $sucursales_seleccionadas[1] = "XC1";
    $sucursales_seleccionadas[2] = "XU1";
    $sucursales_seleccionadas[3] = "VA1";
    $sucursales_seleccionadas[4] = "CZ1";
    $sucursales_seleccionadas[5] = "CL1";
    $sucursales_seleccionadas[6] = "OZ1";
    $sucursales_seleccionadas[7] = "TX1";
    $usuario = $this->uri->segment(3,'10');
    $usuarios = ['alonsoramos', 'armandoh', 'epifaniox', 'jonnareyes', 'marcosruiz', 'marioivan', 'yaquiperez','marcobueno','ricardorojo','ivonnemtz',''];
    $registro['bitacoras'] = $this->Bitacorasmodel->get_equiposreparadossucursales($usuarios[$usuario],$sucursales_seleccionadas,$usuarios);
    $registro['usuarios'] = ['alonsoramos', 'armandoh', 'epifaniox', 'jonnareyes', 'marcosruiz', 'marioivan', 'yaquiperez','marcobueno','ricardorojo','ivonnemtz'];
		$registro['usuarios']['NE'] = "Seleccionar usuarios";
    $registro['usuario'] = $this->uri->segment(3,'NE');
    $this->load->view('inicio/top1');
    $this->load->view('equipos/reparados',$registro);
    $this->load->view('inicio/bottom1');
  }

  function exportarcierredemes() {
    ini_set('memory_limit','32M');
    $this->load->helper("exportacion");
    $this->load->model("equipos/Equiposmodel");
    $tabla = $this->Equiposmodel->get_cierre_de_mes_administracion($this->uri->segment(5),$this->uri->segment(3),$this->uri->segment(4));
    $xls = exporta_excel($tabla);
    $this->output->set_content_type('application/vnd.ms-excel');
    $this->output->set_header("Content-Disposition: attachment; filename=cierredemes_" . $this->uri->segment(5) . "-" . $this->uri->segment(4) . "_" . $this->uri->segment(5) .".xls");
    $this->output->set_output($xls);
  }

  public function exportarequipos() {
		$data = array();
		$this->load->view('inicio/top1');
		$this->load->view('reportes/equipospormes',$data);
		$this->load->view('inicio/bottom1');
  }

	public function guardarreporte() {
		print_r($_POST);
	}

	public function ordenesentregadasporfecha(){
    $data['titulo'] = "Ordenes entregadas por fecha";
    if ($this->input->post('fechaini')) {
      $sql =  "select equipos.id,equipos.num_orden,clientes.nombre,bitacoras.fecha,equipos.tipo from equipos ";
      $sql .= "inner join bitacoras ";
      $sql .= "on equipos.estatus_id=bitacoras.estatus_id ";
      $sql .= "and equipos.id=bitacoras.equipo_id ";
      $sql .= "inner join clientes ";
      $sql .= "on equipos.cliente_id=clientes.id ";
      $sql .= "where bitacoras.estatus='Entregado' ";
      $sql .= "and bitacoras.fecha between '" . $this->input->post('fechaini') . "' and '" . $this->input->post('fechafin') . "' ";
      $arr = ( $this->db->query($sql));
      $data['result'] = ($arr->result_array());
    } else $data['result'] = "";
		$this->load->view('inicio/top1');
		$this->load->view('reportes/ordenesentregadasporfecha',$data);
		$this->load->view('inicio/bottom1');
	}

	public function piezaspendientes() {
    $sql  = "select equipos.id,equipos.num_orden,equipos.tipo,piezas.pieza_id, ";
    $sql .= "catpiezas.descripcion,clientes.nombre,piezas.fecha from equipos ";
    $sql .= "inner join piezas on piezas.equipo_id=equipos.id ";
    $sql .= "inner join catpiezas on piezas.pieza_id=catpiezas.id ";
    $sql .= "inner join clientes on clientes.id=equipos.cliente_id ";
    $sql .= "where equipos.situacion='A' and piezas.surtida='N'";
    $sql .= "order by piezas.fecha ";
    $arr = ( $this->db->query($sql));
    $data['result'] = ($arr->result_array());
    $this->load->view('inicio/top1');
		$this->load->view('reportes/piezaspendientes',$data);
		$this->load->view('inicio/bottom1');
	}

	//---------------------------------------------------------
// RECIBIDOS DEL DIA
//---------------------------------------------------------

  public function recibidosdiaculiacan() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CS1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/recibidosdiagestionadas",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiaculiacanprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CS1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiafranquicias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiafranquiciasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1', 'CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiapozarica() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      if(empty($sucursales_seleccionadas)){
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/recibidosdiafranquicias",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, datos)
        $this->load->view("reportes/recibidosdiapozarica",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiapozaricaprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiapropias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'PR1', 'TX1', 'VA1', 'XA1', 'XC1', 'XU1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiapropiasresumen() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'PR1', 'TX1', 'VA1', 'XA1', 'XC1', 'XU1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        $data['titulo'] = "Equipos recibidos hoy";
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        //$this->load->view("reportes/equiposrecibidospruebagraficos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiaframboyanes() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/recibidosdiagestionadas",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiaframboyanesprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiariviera() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VR1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/recibidosdiagestionadas",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiarivieraprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VR1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiavillahermosa() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/recibidosdiavillahermosa",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, datos)
        $this->load->view("reportes/recibidosdiavillahermosa",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosdiavillahermosaprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Busqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_recibidosdiaresumen($sucursales_seleccionadas);
        //Carga de las vistas
        //print_r($data['result']);
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

//---------------------------------------------------------
// RECIBIDOS DEL MES
//---------------------------------------------------------

  public function recibidosmesfranquicias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        //$this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        //$this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesfranquiciasprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CO1','CS1', 'PC1', 'PR1', 'VM1', 'VM2', 'VR1','VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmespropias() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'PR1', 'TX1', 'VA1', 'XA1', 'XC1', 'XU1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        //$this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        //$this->load->view("reportes/cierredemesvarios",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

	public function recibidosmespropiasprueba() {
    $this->load->model("equipos/Equiposmodel");
    $this->load->library('pagination');
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'PR1', 'TX1', 'VA1', 'XA1', 'XC1', 'XU1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesgrafico() {
    $this->load->model("equipos/Equiposmodel");
    $this->load->library('pagination');
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'TX1', 'VA1', 'XA1', 'XC1', 'XU1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data);
        $this->load->view('inicio/topprueba',$data);
        $this->load->view("reportes/equiposrecibidospruebagraficos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesculiacan() {
    //carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['CS1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y envío de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesculiacanprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['CS1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesframboyanes() {
    //carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y envío de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesframboyanesprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VF1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmespozarica() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmespozaricaprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesriviera() {
    //carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = ['VR1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y envío de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesrivieraprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VR1'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesvillahermosa() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultado en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y envío de datos (Vista, Datos)
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function recibidosmesvillahermosaprueba() {
    //Carga de modelo
    $this->load->model("equipos/Equiposmodel");
    //Carga de la librería de paginación para los resultados
    $this->load->library('pagination');
    //Solo si el usuario se encuentra logueado
    if ($this->session->userdata('nivel')==1) {
      //Variables de la sucursal por consultar
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      if(empty($sucursales_seleccionadas)){
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        $this->load->view("reportes/equiposrecibidos",$data);
        $this->load->view('inicio/bottom1');
      }else{
        //Búsqueda de resultados en la consulta
        $data['result'] = $this->Equiposmodel->get_registrosmesprueba($sucursales_seleccionadas);
        //print_r($data['result']);
        //Carga de las vistas
        $this->load->view('inicio/top1');
        //Carga de la vista y paso de datps (Vista, Datos)
        $this->load->view("reportes/equiposrecibidosprueba",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function reporteequipospordia() {
		$this->load->view('inicio/top1');
		$this->load->view('reportes/equipospordia');
		$this->load->view('inicio/bottom1');
	}

	public function supervision() {
    $this->load->model("equipos/Equiposmodel");
    $this->load->library('pagination');
    if ($this->session->userdata('nivel')==1) {
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
        $this->load->view('reportes/checkboxsupervision');
        $this->load->view("reportes/supervision",$data);
        $this->load->view('inicio/bottom1');
      } else {
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales($sucursales_seleccionadas);
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsupervision');
        $this->load->view("reportes/supervision",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function supervisionactivas() {
    $this->load->model("equipos/Equiposmodel");
    $this->load->library('pagination');
    if ($this->session->userdata('nivel')==1) {
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
        $this->load->view('reportes/checkboxsupervisionactivas');
        $this->load->view("reportes/supervision",$data);
        $this->load->view('inicio/bottom1');
      } else {
        $data['result'] = $this->Equiposmodel->get_supervision_sucursales_activas($sucursales_seleccionadas);
        $this->load->view('inicio/top1');
        $this->load->view('reportes/checkboxsupervisionactivas');
        $this->load->view("reportes/supervision",$data);
        $this->load->view('inicio/bottom1');
      }
    }
  }

  public function supervisionss() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $this->load->model('Calendariomodel');
      $this->load->library('pagination');
      $sucursal_id = $this->session->sucursal_id;
      $qry = "select ";
      $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO";
      $qry .= " FROM ";
      $qry .= "EQUIPOS T1 INNER JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID";
      $qry .= " WHERE ";
      $qry .= "T1.SUCURSAL_ID = 'XA1' AND T1.ESTATUS <> 'Entregado' AND T1.ESTATUS <> 'Abandonado' AND T1.ESTATUS <> 'Donado a reciclaje' AND T1.ESTATUS <> 'Garant' AND T1.ESTATUS <> 'Donado'";
      $qry .= " GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";
      $arr = $this->db->query($qry);
      $data['result'] = $arr->result_array();
      $data['titulo'] = "Calendario de operaciones";
      $data['urlregresar'] = "/index.php/inicio/proceso";
      $this->load->view('inicio/top1');
      $this->load->view('reportes/checkboxsucursales');
      $this->load->view('equipos/supervision',$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function validarcheckbox(){
    print_r("bien");
    $sucursales_keys = array_keys(sucursales_nombres_dd());
    $sucursales_seleccionadas = [];
    if(empty($sucursales_seleccionadas)){
      print_r("Esta vacio");
    }
    $j = 0;
    for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) {
      if($this->input->post($sucursales_keys[$i]) == true){
        $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
        $j++;
      }
    }
    $valor = $this->input->post("anios");
    print_r($valor);
    print_r($sucursales_seleccionadas);
  }

  public function ventasdiafranquiciasresumen() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");

    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
		  //Población del arreglo
			$sucursales_seleccionadas[0] = "CO1";
			$sucursales_seleccionadas[1] = "CS1";
			$sucursales_seleccionadas[2] = "PC1";
			$sucursales_seleccionadas[3] = "PR1";
			$sucursales_seleccionadas[4] = "VM1";
			$sucursales_seleccionadas[5] = "VM2";
			$sucursales_seleccionadas[6] = "VR1";
			$sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia_resumen($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function ventasdiapropiasresumen() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");

    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
		  //Población del arreglo
			$sucursales_seleccionadas[0] = "XA1";
			$sucursales_seleccionadas[1] = "XC1";
			$sucursales_seleccionadas[2] = "XU1";
			$sucursales_seleccionadas[3] = "VA1";
			$sucursales_seleccionadas[4] = "CZ1";
			$sucursales_seleccionadas[5] = "CL1";
			$sucursales_seleccionadas[6] = "OZ1";
			$sucursales_seleccionadas[7] = "TX1";
			$sucursales_seleccionadas[8] = "PR1";
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_dia_resumen($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
    $data['titulo'] = "Ventas del día";
      // $this->load->view("reportes/accesoriosrecibidosgrafico",$data);
			$this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
		}
	}

  public function ventasmesfranquicias() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = [];
      $sucursales_seleccionadas[0] = "CO1";
      $sucursales_seleccionadas[1] = "CS1";
      $sucursales_seleccionadas[2] = "PC1";
      $sucursales_seleccionadas[3] = "PR1";
      $sucursales_seleccionadas[4] = "VM1";
      $sucursales_seleccionadas[5] = "VM2";
      $sucursales_seleccionadas[6] = "VR1";
      $sucursales_seleccionadas[7] = "VF1";
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      // $mes = '010';
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function ventasmesfranquiciasresumen() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
		  //Población del arreglo
			$sucursales_seleccionadas[0] = "CO1";
			$sucursales_seleccionadas[1] = "CS1";
			$sucursales_seleccionadas[2] = "PC1";
			$sucursales_seleccionadas[3] = "PR1";
			$sucursales_seleccionadas[4] = "VM1";
			$sucursales_seleccionadas[5] = "VM2";
			$sucursales_seleccionadas[6] = "VR1";
			$sucursales_seleccionadas[7] = "VF1";
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
      //$mes='08';
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_mes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }

  public function ventasmespropias() {
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {
      $sucursales_seleccionadas = [];
      $sucursales_seleccionadas[0] = "XA1";
      $sucursales_seleccionadas[1] = "XC1";
      $sucursales_seleccionadas[2] = "XU1";
      $sucursales_seleccionadas[3] = "VA1";
      $sucursales_seleccionadas[4] = "CZ1";
      $sucursales_seleccionadas[5] = "CL1";
      $sucursales_seleccionadas[6] = "OZ1";
      $sucursales_seleccionadas[7] = "TX1";
      $sucursales_seleccionadas[8] = "PR1";
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1');
      $this->load->view("reportes/cierredemesvarios",$data);
      $this->load->view('inicio/bottom1');
    }
  }

  public function ventasmespropiasresumen() {
    //Carga de modelo
		$this->load->model("equipos/Equiposmodel");
    //Búsqueda de usuario registrado en el sistema
    if ($this->session->userdata('nivel')==1) {
      //Creación de arreglo para almacenar variables de sucursales
			$sucursales_seleccionadas = [];
		  //Población del arreglo
			$sucursales_seleccionadas[0] = "XA1";
			$sucursales_seleccionadas[1] = "XC1";
			$sucursales_seleccionadas[2] = "XU1";
			$sucursales_seleccionadas[3] = "VA1";
			$sucursales_seleccionadas[4] = "CZ1";
			$sucursales_seleccionadas[5] = "CL1";
			$sucursales_seleccionadas[6] = "OZ1";
			$sucursales_seleccionadas[7] = "TX1";
			$sucursales_seleccionadas[8] = "PR1";
      //Obtención de la fecha actual en sistema
			$anio = date("Y");
      $mes = 	date("m");
      //$mes='08';
			$dia = 	date("d");
			//Búsqueda de resultado en la consulta
			$data['cierredemes'] = $this->Equiposmodel->get_ventas_sucursales_mes($sucursales_seleccionadas, $anio, $mes, $dia);
      //Carga de las vistas
      //print_r($data['cierredemes']);
      $this->load->view('inicio/top1');
      //Carga de la vista y paso de datos (Vista, Datos)
      $this->load->view("reportes/cierredemesvariosprueba",$data);
			$this->load->view('inicio/bottom1');
    }
  }
}