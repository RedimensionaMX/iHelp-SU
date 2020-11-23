<?php
class Estadosmodel extends CI_Model {

  function Formmodel() {
    // load the parent constructor
    parent::Model();
	}

  function get_campos() {
    $campos = array();
    //Obtención de los campos de la tabla "ESTADOS"
    $fields = $this->db->list_fields('ESTADOS');
    //Población de la variable campos con los campos de la tabla en minúsculas
    foreach ($fields as $field)
    {
      $campos[strtolower($field)] = "";
    }
    return $campos;
  }

  function get_detalle($id){
    $arr =  $this->db->query('select * from estados where id=' . $id);
    $data = $arr->result_array();
    $data[0]['accion'] = "U";
    //print_r ($data);
    $registro = $data[0];
    return $registro;
  }

  function last_id(){
    $arr =  $this->db->query('select first 1 (id+10) from estados order by id desc');
    $data = $arr->result_array();
    $id = $data[0]['add'];
    return $id;
  }

  function guardar($p) {
    unset($p['submit']);
    $accion = $p['accion'];
    unset($p['accion']);
    if ($accion=="i") {
      $this->db->insert('estados',$p);
      redirect('/estados/'); 
    } else {
      $this->db->where('id', $p["id"]);
      $this->db->update('estados', $p);
      redirect('/estados/modificar/' . $p["id"]);
    }
  }

  function eliminar_servicio($id){
       
    $this->db->query("delete from catservicios where id='" . $id . "'");      
  } 

  function eliminar($id) {
    $this->db->query("delete from estados where id='" . $id . "'");      
    redirect('/estados/');    
 } 

    /*if ($accion=="i") {
			$this->db->insert('estados',$_POST);
		  	redirect('/estados/'); 
	   	} else {
        $this->db->where('id', $p["id"]);
        $this->db->update('usuarios', $p); 
        $usr = $p['usuario'];
        unset ($p['id']);
        unset ($p['usuario']);
        unset ($p['sucursal_id']);
        unset ($p['nivel']);
        $this->db->where('usuario',$usr);
        $this->db->update('usuarios', $p); 
      
       }*/

    /*function get_clientes_dropdown() {
      $arr = $this->db->query('select id,nombre from clientes order by nombre');
	    $clientes = ($arr->result_array());		
		  $cli = array();
		  foreach ($clientes as $cliente) {
			  $cli[$cliente["id"]] = $cliente["nombre"];
		  }
		  return $cli;
    }

    function activar_cliente($id) {
      $this->db->where("id",$id);
      $data = array("estatus"=>"ACTIVO");
      $this->db->update("clientes",$data);
      return 1;
    }

    function agregar_nuevo_cliente_nueva_orden($datos) {
      $arrcli = array('nombre' => $datos['nombrecliente'],
                            'telefono1' => $datos['telefono1'],
                            'telefono2' => $datos['telefono2'],
                            'correo_electronico' => $datos['correo_electronico'],
                            'direccion' => $datos['direccion'],
                            'colonia' => $datos['colonia'],
                            'cp' => $datos['cp'],
                            'ciudad' => $datos['ciudad'],
                            'estado' => $datos['estado'],
                            'agregado_por'=>$this->session->userdata('username'),
                            'fechaalta'=>date("Y-m-d H:i:s"),
                            'estatus'=>"ACTIVO"
                            );
      $this->db->insert('clientes',$arrcli);
      return $this->db->insert_id();        
    }

    function get_clientes_where_str($wh,$lim="10",$cnt="20") {
      $arr = $this->db->query('select first ' .$cnt. ' skip ' .$lim. ' * from clientes ' . $wh);
      return ($arr->result_array()); 
    }

    function get_cliente_de_equipo($equipo_id) {
      $arr =  $this->db->query("select clientes.id,clientes.nombre,clientes.telefono1,clientes.telefono2, " .
              "clientes.direccion, clientes.correo_electronico, clientes.colonia, clientes.cp, " .
              "clientes.ciudad, clientes.estado from clientes inner join equipos " .
              "on clientes.id=equipos.cliente_id where equipos.id=" .  $equipo_id);
      $data = $arr->result_array(); 
      $cliente = $data[0]; 
      return $cliente;        
    }*/
}
?>