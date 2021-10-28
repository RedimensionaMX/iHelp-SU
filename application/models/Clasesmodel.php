<?php
class Clasesmodel extends CI_Model {
  function get() {
    $this->db->not_like('descripcion', 'zz_');
    $this->db->order_by('descripcion');
    $arr = $this->db->get('clases');
    return ($arr->result_array());
  }

  function get_campos() {
    $campos = array();
    $fields = $this->db->list_fields('CLASES');
    foreach ($fields as $field)
    {
    $campos[strtolower($field)] = "";
    }
    return $campos;
  }

  function get_campos_android() {
    $DB2 = $this->load->database('pruebas', TRUE);
    $campos = array();
    $fields = $DB2->list_fields('MARCAS');
    foreach ($fields as $field)
    {
    $campos[strtolower($field)] = "";
    }
    return $campos;
  }

  function get_clases_dropdown_clase(){
    $arrt = ( $this->db->query('select * from clases order by clase'));
    $clases = ($arrt->result_array());
    $cla = array();
    foreach ($clases as $clase) {
      $cla[$clase["clase"]] = $clase["clase"];
    }
    return $cla;
  }

  function get_clases_dropdown(){
    //$arrt = ( $this->db->query('select * from clases order by clase'));
    $arrt = ( $this->db->query("select * from clases WHERE descripcion NOT LIKE '%zz_%' order by clase"));
    $clases = ($arrt->result_array());
    $c = array();
    foreach ($clases as $cla) {
        $c[$cla["clase"]] = $cla["descripcion"];
    }
    return $c;
  }

  function get_clases_dropdown_todas() {
    $arr = $this->get_clases_dropdown();
    $arr1 = array(''=>'Todas las clases');
    $arr2 = array_merge($arr1,$arr);
    return $arr2;
  }

  function get_detalle($clase){
    $arr =  $this->db->query("select * from clases where clase='" . $clase . "'");
    $data = $arr->result_array();
		$registro = $data[0];
		return $registro;
  }

  function get_clases_where($wh) {
    $this->db->order_by('descripcion');
    $arr = $this->db->get_where('clases',$wh,100000,0);
    return ($arr->result_array());
  }

  function get_clases_where_str($wh,$lim="10",$cnt="20") {
    $arr = ( $this->db->query('select * from clases ' . $wh . ' limit ' . $lim . ',' . $cnt));
    return ($arr->result_array());
  }

  function guardar($p) {
    $accion = $p['accion'];
    $p = $this->filtra_post_guardar($p);
    $p['clase'] = strtoupper($p['clase']);
    if ($accion=="i")
      $this->db->insert('clases',$p);
    else {
        $this->db->where("clase",$p['clase']);
        $this->db->update("clases",$p);
    }
  }

  function guardarMarca($p) {
    $DB2 = $this->load->database('pruebas', TRUE);
    $accion = $p['accion'];
    $p = $this->filtra_post_guardar_android($p);
    $p['marca'] = strtoupper($p['marca']);
    if ($accion=="i")
      $DB2->insert('marcas',$p);
    else {
        $DB2->where("marca",$p['marca']);
        $DB2->update("marca",$p);
    }
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

  function filtra_post_guardar_android($p) {
    $a = $this->get_campos_android();
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
}
?>