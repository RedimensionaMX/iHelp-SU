<?php
class Preciosmodel extends CI_Model {




   function get_campos() {
    	$campos = array();
      $DBcatalogo = $this->load->database('catalogos', TRUE);
      $fields = $DBcatalogo->list_fields('clases');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
      $DBcatalogo = $this->load->database('catalogos', TRUE);

        $arr =  $DBcatalogo->query("select * from clases where id='" . $id . "'");
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }




    function get_clases_dropdown(){
        $DBcatalogo = $this->load->database('catalogos', TRUE);
        $arrt = ( $DBcatalogo->query('select * from clases order by clase'));
        $clases = ($arrt->result_array());       
        $c = array();
        foreach ($clases as $cla) {
            $c[$cla["clase"]] = $cla["descripcion"];
        }
        return $c;
    }     

    function get_clases_dropdown_clase(){
        $DBcatalogo = $this->load->database('catalogos', TRUE);
        $arrt = ( $DBcatalogo->query('select * from clases order by clase'));   
        $clases = ($arrt->result_array());     
         $cla = array();
          foreach ($clases as $clase) {
            $cla[$clase["clase"]] = $clase["clase"];
         }    
         return $cla;
    } 

    function get() {        
        $DBcatalogo = $this->load->database('catalogos', TRUE);
        $DBcatalogo->not_like('descripcion', 'zz_');
        $DBcatalogo->order_by('descripcion');

        $arr = $DBcatalogo->get('clases');
        return ($arr->result_array()); 
    }    

    function get_clases_where($wh) {        
        $DBcatalogo = $this->load->database('catalogos', TRUE);
        $DBcatalogo->order_by('descripcion');

        $arr = $DBcatalogo->get_where('clases',$wh,100000,0);
        return ($arr->result_array()); 
    }


    function get_clases_where_str($wh,$lim="10",$cnt="20") {
        $DBcatalogo = $this->load->database('catalogos', TRUE);
        $arr = ( $DBcatalogo->query('select * from clases ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

   


}
?>