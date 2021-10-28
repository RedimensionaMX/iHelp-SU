<?php
class Prospectosmodel extends CI_Model {

	function Formmodel() {
    // load the parent constructor
    parent::Model();
	}

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('PROSPECTOS');
        foreach ($fields as $field)
          {
           $campos[strtolower($field)] = "";
         }
         return $campos;
    }

  function get_detalle($id){
    $arr =  $this->db->query('select * from prospectos where id=' . $id);
    $data = $arr->result_array();
    if (count($data)>0)
      $registro = $data[0];
    else
    $registro = $this->get_campos();
    $registro["desdeequipo"] = "S";
    // $registro['esta_sucursal'] = $this->session->sucursal_id;
    return $registro;
  }

    function get_clientes_dropdown() {
      $sucursal_id = $this->session->sucursal_id;
        $arr = $this->db->query("select id,nombre from clientes where sucursal_id='" . $sucursal_id . "' order by nombre");
	    $clientes = ($arr->result_array());		
		$cli = array();
		foreach ($clientes as $cliente) {
			$cli[$cliente["id"]] = $cliente["nombre"];
		}
		return $cli;
    }

 
    function actualizar_correo($p) {
      $arr = array("correo_electronico"=>$p['correo_electronico']);
      $this->db->where("id",$p['cliente_id']);
      $this->db->update("clientes",$arr);
      return 1;
    }

    function agregar_nuevo_cliente_nueva_orden($datos) {
      $sucursal_id = $this->session->sucursal_id;
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
                            'fechaalta'=>fecha_hora_actual_mysql(),
                            'estatus'=>"ACTIVO",
                            'sucursal_id' => $sucursal_id
                            );
        $this->db->insert('clientes',$arrcli);
        $q = $this->db->query("select first 1 id from clientes where sucursal_id='" . $sucursal_id . "' order by id desc");
        $a = $q->result_array();
        $idc = $a[0]['id'];
        return $idc;        
    }

    function get_prospectos_where_str($wh,$lim="10",$cnt="20") {
        $arr = $this->db->query('select first ' . $cnt . ' skip ' . $lim . ' p.id,p.nombre,p.telefono,p.sucursal_id,p.correo_electronico,p.reparacion_id,p.estatus,p.equipo_id,u.sucursal_id,p.fecha,p.observaciones,p.medio,p.estatus from prospectos p inner join sucursales u on u.id=p.sucursal_id  ' . $wh . ' order by p.id');
        return $arr->result_array();
    }

    function get_prospectos($anio,$mes) {
      $q = $this->db->query("select p.id,p.nombre,p.telefono,p.sucursal_id,p.correo_electronico,p.reparacion_id,p.estatus,p.equipo_id,u.sucursal_id,p.fecha,p.observaciones,p.medio,p.estatus from prospectos p inner join sucursales u on u.id=p.sucursal_id where p.fecha LIKE '%".$anio."-".$mes."%'");
      $a = $q->result_array();
      return $a;
    }

    function get_prospectos_filtro($seleccionados,$anio,$mes) {
    if(date("n")<10){
      $mes = "0".$mes;
    }
    $resultado = [];
    for ($i=0; $i < sizeof($seleccionados); $i++) {
      $arr = $this->db->query("select id from sucursales where sucursal_id='" . $seleccionados[$i] . "'");
      $result = ($arr->result_array());
      $q = $this->db->query("select p.id,p.nombre,p.telefono,p.sucursal_id,p.correo_electronico,p.reparacion_id,p.estatus,p.equipo_id,u.sucursal_id,p.fecha,p.observaciones,p.medio,p.estatus from prospectos p inner join sucursales u on u.id=p.sucursal_id where p.sucursal_id= ".$result[0]['id']." and p.fecha LIKE '%".$anio."-".$mes."%'");
      $a = $q->result_array();
      $resultado  = array_merge($resultado, $a);
    }
    return $resultado;
    // $q = $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha, s1.nombre as "."SEGRESO".", s2.nombre AS "."SAPP".", e.importe, e.concepto , e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones, u.usuario from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion inner join usuarios u on u.id=e.usuario_id where fecha LIKE '%".$anio."-".$mes."%'");
    // $a = $q->result_array();
    // return $a;
  }

    function get_prospectos_where_str_2($wh,$lim="10",$cnt="20") {
      $arr = $this->db->query('select first ' . $cnt . ' skip ' . $lim . ' p.id,p.nombre,p.telefono,p.sucursal_id,p.correo_electronico,p.reparacion_id,p.estatus,p.equipo_id,u.sucursal_id,p.fecha,p.observaciones,p.medio,p.estatus from prospectos p inner join sucursales u on u.id=p.sucursal_id  ' . $wh . ' order by p.id');
      return $arr->result_array();
  }

    function resultados($p) {
       if (count($p)>0) { 
           $wh = " where (1=1) and (nombre<>'') and (nombre not like ' %')";
      
        if ((isset($p['busca_nombre'])) && ($p['busca_nombre']!=""))  {
          $wh .= "   and (nombre like '%" . $p['busca_nombre'] . "%')";        
        //$busca_nombre = $p['busca_nombre'];     
        }  
        else $wh .= "   and (sucursal_id='" . $this->session->sucursal_id . "')";        
        } 
       else
         $wh = " where sucursal_id='" . $this->session->sucursal_id . "'";
       $arr =  $this->db->query('select  first 500 * from clientes ' . $wh . ' order by nombre');
      $result = $arr->result_array();
      return $result;
    }

    function get_cliente_de_equipo($equipo_id) {
            $arr =  $this->db->query("select clientes.id,clientes.nombre,clientes.telefono1,clientes.telefono2, " .
              "clientes.direccion, clientes.correo_electronico, clientes.colonia, clientes.cp, " .
              "clientes.ciudad, clientes.estado from clientes inner join equipos " .
              "on clientes.id=equipos.cliente_id where equipos.id=" .  $equipo_id);
            $data = $arr->result_array(); 
            $cliente = $data[0]; 
            return $cliente;        
    }

    function get_num_prospectos() {
        $arrtot = $this->db->query("select count(*) as cnt from prospectos");
        $arr = $arrtot->result_array();
        return $arr[0]['cnt'];
    }

    function guardar($p) {
        //$p = $this->filtra_post_guardar($p);
         $this->db->where('id', $p["id"]);
         $this->db->update('prospectos', $p);
         return 1;
    }

    function filtra_post_guardar($p) {
        $a = $this->get_campos();
        foreach ($p as $pk=>$pv) {
            $existe = 0;
             foreach ($a as $k=>$v) {
                 if ($pk==$k)
                     $existe = 1;                
             }             
              if (!$existe)
                unset($p[$pk]);
         }
         return $p; 
    }


    function get_tipos_dropdown(){
      $DBcatalogo = $this->load->database('catalogos', TRUE);
      $arrt = ( $DBcatalogo->query('select * from tipos order by descripcion'));
      $tipos = ($arrt->result_array());
      $tip = array();
      foreach ($tipos as $tipo) {
          $tip[$tipo["tipo"]] = $tipo["descripcion"];
      }
      return $tip;
  }

  function get_tipos(){
    $query = $this->db->query('select * from tipos order by descripcion');
    return $query;  
  }

  function get_reparaciones($clase) {
    $arr = $this->db->query("select * from catservicios where (clase is null) or (clase='') or (clase='" . $clase . "') or (clase like '%" . $clase . " %') ORDER BY CLASE, descripcion");
    //$result = ($arr->result_array());
    return $arr;
 }
}
?>