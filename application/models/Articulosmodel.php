<?php
class Articulosmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


  function get_campos() {
    $campos = array();  
    $fields = $this->db->list_fields('CATARTICULOS');
    foreach ($fields as $field) {
      $campos[strtolower($field)] = "";
    }
    return $campos;
  }

    function get_detalle($id){
      
      $arr =  $this->db->query("select * from catarticulos where id='" . $id . "'");
	    $data = $arr->result_array(); 
		  $registro = $data[0];
		  return $registro;
    }

    function get_articulos_dropdown() {
        
        $arr = $this->db->query('select id,descripcion from catarticulos order by id');
	      $articulos = ($arr->result_array());		
		    $cli = array();
		    foreach ($articulos as $articulo) {
			      $cli[$articulo["id"]] = $articulo["descripcion"];
	    	}
		    return $cli;
    }

    function get_articulos_where_str($wh,$lim,$cnt="20") {
        
        //$arr = $this->db->query('select * from catarticulos ' . $wh . ' limit ' . $lim . ' , ' . $cnt);
        $arr = $this->db->query('select first ' .$cnt. ' skip ' .$lim. ' * from catarticulos ' . $wh);
        //print_r($arr);
        return $arr->result_array(); 
    }

    function get_articulos_uniqid() {
        return uniqid();
    }

    function agregar_articulo($p) {
      
      $this->db->insert("catarticulos",$p);
      return 1;
    }

    function modificar_articulo($id,$p) {
       
       $this->db->where('id', $id);
       $this->db->update('catarticulos', $p);       
       return 1;
    }

    function get_articulos_para_json(){
       
       $arr =  $this->db->query("select * from articulos order by descripcion");
       return ($arr->result_array());      
    }

    function num_total_articulos() {
       
       $arrtot = $this->db->query('select * from catarticulos');
       return $arrtot->num_rows();
    }


    function get_articulos_por_clase($clase) {
        
        $this->db->like("clase_compatibilidad",$clase);
        $arr = $this->db->get("catarticulos");
        return $arr->result_array(); 
    }

    function get_tipos_de_clase($clase) {
      $this->db->where("clase",$clase);
      $this->db->order_by("descripcion");
      $a = $this->db->get("tipos");
      $r = $a->result_array();
      $this->agregar_subtipos_y_clases($r);
      return $r;
    }

    function get_tipos() {
      $this->db->order_by("descripcion");
      $a = $this->db->get("tipos");
      $r = $a->result_array();
      $this->agregar_subtipos_y_clases($r);
      return $r;
    }

    function agregar_subtipos_y_clases(&$res) {
      $res2 = array();
       foreach ($res as $k=>$v) {
            $arrst = $this->db->query("select * from subtipos where tipo='" . $v['tipo'] . "'");
            $resst = ($arrst->result_array()); 
            $v['subtipos'] = $resst;
            $res2[$k] = $v;

            $arrcl = $this->db->query("select * from clases where clase='" . $v['clase'] . "'");

               $rescl = ($arrcl->result_array()); 
            if (count($rescl)>0) {
               $v['clase_descripcion'] = $rescl[0]['descripcion'];
            }
            else $v['clase_descripcion'] = 'No asignada';
            $res2[$k] = $v;

       }
       $res = $res2;     

   }

   function get_clases_dropdown(){
    $arrt = ( $this->db->query('select distinct clase_compatibilidad from catarticulos order by clase_compatibilidad'));
    $clases = ($arrt->result_array());       
    $c = array();
    foreach ($clases as $cla) {
        $c[$cla["clase_compatibilidad"]] = $cla["clase_compatibilidad"];
    }
    return $c;
} 



}
?>