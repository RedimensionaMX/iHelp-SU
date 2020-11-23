<?php
class Usuariosmodel extends CI_Model {
  function cambiar_password($usuario,$nuevopassword) {
    $this->db->where("usuario",$usuario);
    $a = array("passwd"=>$nuevopassword);
    $this->db->update("usuarios",$a);
    return 1;
  }

  function crear_super_administrador($usuario) {
    $this->db->where("usuario",$usuario);
    $us = $this->db->get("usuarios");
    $arrus = $us->result_array();
    $arrus0 = $arrus[0];
    $arrus0['sucursal_id'] = 'Todas';
    $arrus0['nivel'] = 0;
    unset($arrus0['id']);
    $this->db->insert("usuarios",$arrus0);
    return 1;
  }

  function eliminar($usuario) {
    $data = array(
      'passwd' => '',
      'nivel' => '-1'
    );
    $this->db->where('usuario',$usuario);
    $this->db->update('usuarios',$data);
    redirect('/usuarios/');
  }

  function eliminarsucursal($usuario,$sucursal) {
    $data = array(
      'passwd' => '',
      'nivel' => '-1'
    );
    $this->db->where('usuario',$usuario);
    $this->db->where('sucursal_id',$sucursal);
    $this->db->update('usuarios',$data);
    redirect('/usuarios/index/1/'.$usuario);
  }

  function es_super_administrador($usuario) {
    $this->db->where("usuario",$usuario);
    $this->db->where("nivel",0);
    $g = $this->db->get("usuarios");
    $ag = $g->result_array();
    if (count($ag)>0)
      return TRUE;
    else return FALSE;
  }

  function get_campos() {
    $campos = array();
    $fields = $this->db->list_fields('USUARIOS');
    foreach ($fields as $field){
      $campos[strtolower($field)] = "";
    }
    return $campos;
  }

  function get_datosUsuario($usuario) {
    $q = $this->db->query("select first 1 nombre, telefono1, telefono2, es_tecnico, usuario, passwd, correo_electronico, nivel, sucursal_id from usuarios where usuario = '".$usuario."'");
    $a = $q->result_array();
    return $a;
  }

  function get_detalle($id){
    $arr =  $this->db->query("select * from usuarios where id=" . $id );
	  $data = $arr->result_array();
		$registro = $data[0];
		return $registro;
  }

  function get_detalle_usuario($usuario){
    $arr =  $this->db->query("select first 1 * from usuarios where usuario='" . $usuario . "' order by passwd desc");
    $data = $arr->result_array();
    $arrsuc = $this->db->query("select distinct sucursal_id,nivel from usuarios where usuario='" . $usuario . "' and nivel<>-1 order by nivel,sucursal_id");
    $dsuc = $arrsuc->result_array();
    $registro = $data[0];
    $dsuc2 = array();
    foreach ($dsuc as $k=>$v) {
      $v['nombre_nivel'] = $this->get_nivel($v['nivel']);
      $dsuc2[$k] = $v;
    }
    $registro['sucursales'] = $dsuc2;
    return $registro;
  }

  function get_lista_usuarios() {
    $q = $this->db->query("select usuario, nombre, list(distinct sucursal_id,',') as sucursales from usuarios where nivel <> -1 or nivel is null group by usuario,nombre");
    $a = $q->result_array();
    return $a;
  }

  function get_sucursales_dropdown(){
    $arrt = ( $this->db->query('select distinct sucursal_id from usuarios where nivel <>-1 order by sucursal_id'));
    $sucursales = ($arrt->result_array());
    $c = array();
    foreach ($sucursales as $cla) {
        $c[$cla["sucursal_id"]] = $cla["sucursal_id"];
    }
    return $c;
  }

  function get_sucursales_usuario($sucursal) {
    $q = $this->db->query("select id,usuario, nombre,sucursal_id as sucursales from usuarios where nivel <>-1 AND usuario = '".$sucursal."'");
    $a = $q->result_array();
    return $a;
  }

  function get_usuario($usuario,$sucursal) {
    $q = $this->db->query("select * from usuarios where usuario = '".$usuario."' and nivel <> -1 and sucursal_id = '".$sucursal."'");
    $a = $q->result_array();
    return $a;
  }

  function get_usuarios_de_sucursal() {
    $sucursal_id = $this->session->sucursal_id;
    $arr = $this->db->query("select * from usuarios where sucursal_id='" . $sucursal_id . "' and (nivel<>-1) and (passwd<>'') order by nivel,sucursal_id");
    return $arr->result_array();
  }

  function get_usuarios_dropdown(){
    $arrt = ( $this->db->query('SELECT usuario FROM USUARIOS where nivel <>-1 or nivel is null order by usuario'));
    $usuarios = ($arrt->result_array());
    $c = array();
    foreach ($usuarios as $cla) {
        $c[$cla["usuario"]] = $cla["usuario"];
    }
    return $c;
  }

  function get_usuarios_sucursal($sucursal) {
    $q = $this->db->query("select id,usuario, nombre,sucursal_id,nivel as sucursales from usuarios where nivel <>-1 AND sucursal_id = '".$sucursal."'");
    $a = $q->result_array();
    return $a;
  }

  function get_nivel($nivel) {
    if ($nivel!=-1) {
      $niveles = array(0=>"Super administrador", 1=>"Administrador",2=>"Tecnico",3=>"Solo lectura");
      return $niveles[$nivel];
    } else return "Suspendido";
  }

  function get_niveles() {
    $niveles = array("0"=>"Super administrador", "1"=>"Administrador","2"=>"Tecnico","3"=>"Solo lectura");
    return $niveles;
  }

  function guardar($p) {
    unset($p['submit']);
    $accion = $p['accion'];
    unset($p['accion']);
    if ($accion=="i") {
      $this->db->insert('usuarios',$p);
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
    }
  }

  function quitar_super_administrador($usuario) {
    $this->db->where("usuario",$usuario);
    $this->db->where("nivel",0);
    $this->db->delete("usuarios");
    return 1;
  }

  function sucursal($p) {
    unset($p['submit']);
    $accion = $p['accion'];
    unset($p['accion']);
    if ($accion=="i") {
      $q = $this->db->query("select * from usuarios where usuario = '".$p["usuario"]."' and sucursal_id = '".$p["sucursal_id"]."'");
      $duplicado = $q->result_array();
      if(count($duplicado)>0){
        $this->db->where('nombre', $p["nombre"]);
        $this->db->where('sucursal_id', $p["sucursal_id"]);
        $this->db->update('usuarios', $p);
      }else{
        $this->db->insert('usuarios',$p);
      }
      redirect('/usuarios/index/1/'.$p["usuario"]);
    }else{
      $this->db->where('id', $p["id"]);
      $this->db->update('usuarios', $p);
      $usr = $p['usuario'];
      redirect('/usuarios/index/1/'.$p["usuario"]);
    }
  }
}
?>