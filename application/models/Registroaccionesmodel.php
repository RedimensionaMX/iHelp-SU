<?php
class Registroaccionesmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('registroacciones');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

   function registrar($accion,$tabla,$detalle) { 
          $registroacc = array(
                       "usuario" => $this->session->userdata('usuario'),
                       "usuario_id" => $this->session->userdata('usuario_id'),
                       "fecha_hora" => date ("Y-m-d H:i:s"),
                       "accion"  => $accion,
                       "tabla"   => $tabla,
                       "detalle" => $detalle);
          $this->db->insert('registroacciones',$registroacc);    
          return 1;
   }    

    function get_detalle($tipo_id){
        $arrt = ( $this->db->query("select * from tipos where tipo='" . $tipo_id . "'"));
        $clasetipo = ($arrt->result_array());
        $registro = $clasetipo[0];
		return $registro;
    }

    function get_tipos_dropdown(){
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());       
        $tip = array();
        foreach ($tipos as $tipo) {
            $tip[$tipo["tipo"]] = $tipo["descripcion"];
        }
        return $tip;
    }      


    function consulta_por_dia($a = 0, $m = 0, $d =0, $wh = "") {
      $arr = $this->db->query("select * from registroacciones where EXTRACT(YEAR from fecha_hora)=" . $a . 
            " and EXTRACT(MONTH FROM fecha_hora)=" . $m . " and EXTRACT(DAY from fecha_hora)=" . $d. " " .$wh);
      //$arr = $this->db->query("select * from registroacciones where YEAR(fecha_hora)=" . $a . 
        //    " and MONTH(fecha_hora)=" . $m . " and DAY(fecha_hora)=" . $d);
      return $arr->result_array(); 
    }

    function get_usuarios_dropdown(){
      $arrt = ( $this->db->query('SELECT usuario FROM USUARIOS where nivel <>-1 order by usuario'));
      $usuarios = ($arrt->result_array());       
      $c = array();
      foreach ($usuarios as $cla) {
          $c[$cla["usuario"]] = $cla["usuario"];
      }
      return $c;
    }

    function get_usuariosat_dropdown($seleccionados){
      $resultado2 = [];
      for ($i=0; $i < sizeof($seleccionados); $i++) {
        $qry = " SELECT distinct(usuario) from usuarios where nivel = '2' and sucursal_id = '". $seleccionados[$i] ."';";
        $arr = $this->db->query($qry);
        $guard = $arr->result_array();
        $resultado2  = array_merge($resultado2, $guard);
      }
      //$resultado2 = array_values(array_unique($resultado2));
      print_r($resultado2);
      return $resultado2;
    }
}
?>