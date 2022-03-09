<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function index(){
		$this->load->view('inicio');
	}

	public function administracion(){
		$this->load->view('inicio/top1');
		$this->load->view('inicio/menuprincipal');
		$this->load->view('inicio/administracion');
		$this->load->view('inicio/bottom1');
	}

	public function clientes(){
		$this->load->view('inicio/top1');
		$this->load->view('inicio/menuprincipal');
		$this->load->view('inicio/clientes');
		$this->load->view('inicio/bottom1');
	}

    public function fecha(){
		echo date("Y-m-d H:i:s");
	}

    public function iniciar(){
        //Carga del header
        $this->load->view('inicio/top1');
        //Carga del menú principal
        $this->load->view('inicio/menuprincipal');
        //Carga del segmento inicial
        $this->load->view('inicio/inicio');
        //Carga del footer
		$this->load->view('inicio/bottom1');
	}

	public function menu(){
		$this->load->view('inicio/top_single1');
		$this->load->view('menu');
		$this->load->view('inicio/bottom1');
	}
	/*
    |--------------------------------------------------------------------------
    | Vista principal | Usuario registrado
    |--------------------------------------------------------------------------
    */
    public function proceso(){
		$this->load->view('inicio/top1');
		$this->load->view('inicio/menuprincipal');
		$this->load->view('inicio/proceso');
		$this->load->view('inicio/bottom1');
	}

    public function servicios(){
		$this->load->view('inicio/top1');
		$this->load->view('inicio/menuprincipal');
		$this->load->view('inicio/servicios');
		$this->load->view('inicio/bottom1');
	}

    public function sistema(){
		$this->load->view('inicio/top1');
		$this->load->view('inicio/menuprincipal');
		$this->load->view('inicio/sistema');
		$this->load->view('inicio/bottom1');
	}

	public function terminar() {
		$this->session->sess_destroy();
        $registroacc = array(
			"usuario" => $this->session->userdata('usuario'),
			"usuario_id" => $this->session->userdata('usuario_id'),
			"fecha_hora" => date ("Y-m-d H:i:s"),
			"accion"  => "TERMINO SESION",
			"tabla"   => "sistema",
			"detalle" => $this->session->userdata('usuario'));
		$this->db->insert('registroacciones',$registroacc);
		redirect('inicio/iniciar');
	}

    /*
    |--------------------------------------------------------------------------
    | Validación de credenciales
    |--------------------------------------------------------------------------
    */
	public function valida(){
        //Búsqueda del usuario en la BD
        $arr =  $this->db->query("select * from usuarios where usuario='" . $_POST['usuario'] . "' and passwd='" . $_POST['passwd'] . "' and nivel=1 and sucursal_id='Todas'");
        //Almacenamiento de resultados
        $data = ($arr->result_array());
        //Si existe un registro del usuario en sistema, los almacena en las siguientes variables
		if (count($data)>0) {
			$newdata = array(
				'username'  => $_POST['usuario'],
				'email'     => $data[0]['correo_electronico'],
				'usuario_id'     => $data[0]['id'],
				'usuario'     => $data[0]['usuario'],
				'nivel'     => $data[0]['nivel'],
				'logged_in' => TRUE
			);
            //Crea una sesión nueva en el sistema al usuario que ingresa
            $this->session->set_userdata($newdata);
            //Y se comienzan a almacenar los registros de las acciones que realiza el usuario en el sistema
            $registroacc = array(
				"usuario" => $_POST['usuario'],
				"usuario_id" => $data[0]['id'],
				"fecha_hora" => date ("Y-m-d H:i:s"),
				"accion"  => "INGRESO",
				"tabla"   => "sistema",
				"detalle" => $_POST['usuario']);
            $this->db->insert('registroacciones',$registroacc);
            //Posterior a tener su registro, se le da acceso a la pantalla principal del sistema
            redirect('inicio/iniciar');
		}
        //Si no existe un registro del usuario, se actualiza la misma pantalla de logueo para posteriores intentos
        else redirect('/');
	}
} 