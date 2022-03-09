<?php
class Egresosmodel extends CI_Model {
	function Formmodel() {
    // load the parent constructor
    parent::Model();
	}

  function insertarEgreso($arreq){
    $this->db->insert('egresos',$arreq);
    $q = $this->db->query("select first 1 id from egresos order by id desc");
    $aq = $q->result_array();
		$ultimo_eq_id = $aq[0]['id'];
		return $ultimo_eq_id;
  }

  function obtenerTipos(){
    $query = $this->db->query('select distinct id,nombre from egresos_tipo');
    return $query;
  }

  function obtenerUsuarios(){
    $q = $this->db->query("SELECT distinct usuario,nombre FROM USUARIOS where nivel <>-1 or nivel is null order by usuario");
    $a = $q->result_array();
    return $a;
  }

  function obtenerUsuarioSolicitante($usuario){
    $egresosCategoria = $this->db->query("SELECT distinct usuario,nombre FROM USUARIOS where usuario = '".$usuario."' and nivel <>-1 or usuario = '".$usuario."' and nivel is null order by usuario");
		$egresosCategoria2 = $this->db->query("SELECT distinct usuario,nombre FROM USUARIOS where usuario != '".$usuario."' and nivel <>-1 or usuario != '".$usuario."' and nivel is null order by usuario");
		$egresosCategoria = $egresosCategoria->result_array();
		$egresosCategoria2 = $egresosCategoria2->result_array();
		$registro['categorias'] = array_merge($egresosCategoria,$egresosCategoria2);
    $q = $this->db->query("SELECT distinct usuario,nombre FROM USUARIOS where nivel <>-1 or nivel is null order by usuario");
    $a = $q->result_array();
    return $registro['categorias'];
  }

  function obtenerTiposModificar($nombre){
    $query = $this->db->query('select distinct id,nombre from egresos_tipo');
    return $query;
  }

  function obtenerCategorias($id){
    $query = $this->db->query("select ID,NOMBRE from EGRESOS_CATEGORIA where EGRESOS_TIPO_ID = '".$id."' order by id asc");
    return $query;
  }

  function obtenerSubCategorias($id){
    $query = $this->db->query("select ID,NOMBRE from EGRESOS_SUBCATEGORIA where CATEGORIAEGRESO_ID = '".$id."' order by id asc");
    return $query;
  }

  function get_sub_category3($modelo,$marca,$tipo){
    $query = $this->db->query("select clase from correlacion_android where modelo = '".$modelo."' and marca = '".$marca."' and tipo = '".$tipo."'");
    return $query;
  }

  function get_marca($tipo){
    $query = $this->db->query("select marca from correlacion_android where modelo = '".$tipo."'");
    return $query;
  }

  function get_egresos($anio,$mes) {
    $q = $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha, s1.nombre as "."SEGRESO".", s2.nombre AS "."SAPP".", e.importe, e.concepto , e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones, u.usuario from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion inner join usuarios u on u.id=e.usuario_id where fecha LIKE '%".$anio."-".$mes."%'");
    $a = $q->result_array();
    return $a;
  }

  function get_egresos_prueba($seleccionados,$anio,$mes) {
    if(date("n")<10){
      $mes = "0".$mes;
    }
    $resultado = [];
    for ($i=0; $i < sizeof($seleccionados); $i++) {
      $arr = $this->db->query("select id from sucursales where sucursal_id='" . $seleccionados[$i] . "'");
      $result = ($arr->result_array());
      $q = $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha, s1.nombre as "."SEGRESO".", s2.nombre AS "."SAPP".", e.importe, e.concepto , e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones, u.usuario from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion inner join usuarios u on u.id=e.usuario_id where e.SUCURSAL_ID_EGRESO= ".$result[0]['id']." and fecha LIKE '%".$anio."-".$mes."%'");
      $a = $q->result_array();
      $resultado  = array_merge($resultado, $a);
    }
    return $resultado;
    // $q = $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha, s1.nombre as "."SEGRESO".", s2.nombre AS "."SAPP".", e.importe, e.concepto , e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones, u.usuario from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion inner join usuarios u on u.id=e.usuario_id where fecha LIKE '%".$anio."-".$mes."%'");
    // $a = $q->result_array();
    // return $a;
  }

  function get_egresos2($anio,$mes) {
    $q = $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha, s1.sucursal_id as "."SEGRESO".", s2.sucursal_id AS "."SAPP".", e.importe, e.concepto, e.forma_pago, e.observaciones from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion where fecha LIKE '%".$anio."-".$mes."%'");
    $a = $q->result_array();
    return $a;
  }

  function get_detalle($id){
    $arr =  $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha as "."FECHA_RECIBIDO".", s1.nombre as "."SUCURSAL_ID_EGRESO".", s2.nombre AS "."SAPP".", e.importe, e.concepto, e.forma_pago, e.observaciones from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion where e.id='".$id."'");
    $data = $arr->result_array();
    $registro = $data[0];
    return $registro;
  }

  function get_detalle2($id){
    $arr =  $this->db->query("select e.id, et.nombre as "."TIPO_EGRESO".", ec.nombre AS "."CATEGORIA".", esc.nombre as "."SUBCATEGORIA".", e.fecha as "."FECHA_RECIBIDO".", s1.id , s2.id, e.importe, e.concepto, e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion where e.id='".$id."'");
    $data = $arr->result_array();
    $registro = $data[0];
    return $registro;
  }

  function guardar_modificaciones($p) {
    $this->db->where('id', $p['id']);
    $this->db->update('egresos', $p);
  }

  function eliminar($id){
    $arr = $this->db->query("select * from egresos where id='" . $id . "'");
    $result = ($arr->result_array());
    $this->db->query("delete from egresos where id='" . $id . "'");
    return $result;
  }



  select e.id, et.nombre as "TIPO_EGRESO", ec.nombre AS "CATEGORIA", esc.nombre as "SUBCATEGORIA", e.fecha, s1.nombre as "SEGRESO", s2.nombre AS "SAPP", e.importe, e.concepto , e.usuario_id_ingreso, e.usuario_id_autoriza, e.usuario_id_solicita, e.forma_pago, e.observaciones, u.usuario from egresos e inner join sucursales as s1 on s1.id = e.sucursal_id_egreso inner join egresos_tipo et on et.id=e.tipoegreso_id inner join egresos_categoria ec on ec.id=e.categoriaegreso_id inner join egresos_subcategoria esc on esc.id=e.subcategoriaegreso_id inner join sucursales as s2 on s2.id=e.sucursal_id_aplicacion inner join usuarios u on u.id=e.usuario_id where fecha LIKE '%2021%' order by fecha asc

}
?>