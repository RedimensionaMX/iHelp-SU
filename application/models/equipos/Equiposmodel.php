<?php
class Equiposmodel extends CI_Model {

	function Formmodel() {
    parent::Model();
	}

  function get_campos() {
    $campos = array();
    if ($this->db->platform()=="ibase")
      $fields = $this->db->list_fields('EQUIPOS');
    else
      $fields = $this->db->list_fields('equipos');
        foreach ($fields as $field)
          {
           $campos[strtolower($field)] = "";
         }
         return $campos;
    }

   function get_campos_equipos_para_sql() {
      $campos = array();
    if ($this->db->platform()=="ibase") 
      $fields = $this->db->list_fields('EQUIPOS');
    else
      $fields = $this->db->list_fields('equipos');
    
      $sql = "";
      $i = 0;
      foreach ($fields as $field) {
        $sql .= "equipos." . $field;
        $i++;
        if ($i<count($fields))
           $sql .= ",";
      }
      return $sql;
   } 


   function get_datos_iniciales_recepcion() {
    $this->load->model('Tiposclasesequiposmodel');
        
    $registro = $this->get_campos();
    $registro['correo_electronico'] = '';
    $registro['telefono1'] = '';
    $registro['telefono2'] = '';

    $registro['direccion'] = '';
    $registro['numero_interior'] = '';
    $registro['numero_exterior'] = '';
    $registro['colonia'] = '';
    $registro['cp'] = '';
    $registro['ciudad'] = '';
    $registro['estado'] = '';

    $registro['contrasenia'] = '';
    $registro['fecha_de_entrega'] = '';
    $registro['chlst_encendido'] = 0;
    $registro['chlst_lcd'] = 0;
    $registro['chlst_digitalizador'] = 0;
    $registro['chlst_conector'] = 0;
    $registro['chlst_sonido'] = 0;
    $registro['chlst_camara'] = 0;
    $registro['chlst_conexiones'] = 0;
    $registro['chlst_botones'] = 0;
    $registro['chlst_sim'] = 0;
    $registro['chlst_software'] = 0;
    $registro['chlst_carcasa'] = 0;
    $registro['chlst_sensores'] = 0;
    $registro['caja_id'] = '';


    $tip1 = $this->Tiposclasesequiposmodel->get_tipos_dropdown();
    $tipant = array(""=>"Selecciona el tipo");
    $tip = array_merge($tipant,$tip1);


  
    $registro["num_orden"] = $this->Equiposmodel->get_numorden_no_incrementar();
    $registro["opciones_facturar"] = $this->Equiposmodel->opciones_facturar();
        $registro["tipos"] = $tip;
        $registro["tipo"] = "";
  
    $registro["titulo"] = "Recibir equipo"; 
    $registro["fecha_recibido"] = fecha_actual_mysql();
    $registro["hora_recibido"] = hora_actual_mysql();

    $registro["checklist"] = $this->Equiposmodel->array_checklist();  
    return $registro;        

   } 

    function get_equipos_where_str($wh,$lim="0",$cnt="900000") {
        $this->load->model("Clientesmodel");
        $arr = $this->db->query('select * from equipos ' . $wh . ' limit ' . $lim . ',' . $cnt);
        $res2 = array();

        if ($arr->num_rows()>0) {
           $res = $arr->result_array();
           foreach ($res as $k=>$v) {
              $cliente = $this->Clientesmodel->get_detalle($v['cliente_id']);
              $v['cliente'] = $cliente;
              $res2[$k] = $v;
           }
        }

        return $res2; 
    }

    function get_equipos_recibidos_por_mes($anio,$mes) {
        $this->load->model("Clientesmodel");

        $this->db->order_by("fecha_recibido");
        $this->db->where("YEAR(fecha_recibido)",$anio);
        $this->db->where("MONTH(fecha_recibido)",$mes);
        $arr = $this->db->get("equipos");
        $res2 = array();

        if ($arr->num_rows()>0) {
           $res = $arr->result_array();
           foreach ($res as $k=>$v) {
              $cliente = $this->Clientesmodel->get_detalle($v['cliente_id']);
              $v['cliente'] = $cliente;
              $res2[$k] = $v;
           }
        }
        return $res2; 
    }

    function get_equipos_facturacion_por_mes($anio,$mes) {
        $this->load->model("Clientesmodel");

        $this->db->order_by("fecha_de_entrega");
        $this->db->where("EXTRACT(YEAR from fecha_de_entrega)=",$anio);
        $this->db->where("EXTRACT(MONTH from fecha_de_entrega)=",$mes);
        $this->db->where("estatus","Entregado");
        $this->db->where_in("facturar",array("SI","YA FACTURADO"));
        $arr = $this->db->get("equipos");
        $res = $arr->result_array();
        $this->agregar_datos($res,TRUE,TRUE,TRUE,TRUE);
        return $res;
    }



    function agregar_datos(&$equipos,$clientes,$servicios,$tipos,$movimientos) {
      if ($clientes==TRUE)
          $this->load->model("Clientesmodel");
      if ($servicios==TRUE)
          $this->load->model("Serviciosequiposmodel");
      if ($tipos==TRUE) 
          $this->load->model("Tiposclasesequiposmodel");
      if ($movimientos==TRUE)   
          $this->load->model("Movimientosmodel");

           foreach ($equipos as $k=>$v) {

              $equipos[$k]['fecha_diagnostico'] = $this->get_fecha_diagnostico($v['id']);

            if ($clientes===TRUE) {
              $cliente = $this->Clientesmodel->get_detalle($v['cliente_id']);
              $equipos[$k]['cliente'] = $cliente;              
            }
            if ($servicios==TRUE) {
              $total = $this->Serviciosequiposmodel->get_total_de_servicios_de_equipo($v['id']);
              $equipos[$k]['total'] = $total;
              $equipos[$k]['importe_servicios'] = $this->Serviciosequiposmodel->get_total_de_servicios_de_equipo($v['id']);
            }
            if ($tipos==TRUE) {
              $equipos[$k]['tipo_equipo'] = $this->Tiposclasesequiposmodel->get_detalle($v['tipo']);
              $detalletipo = $this->Tiposclasesequiposmodel->get_detalle($v['tipo']);
              $equipos[$k]['descripcion_tipo'] = $detalletipo['descripcion'];
            }

                    $usuario_recibio = $this->get_usuario_recibio($v['id']);
              $equipos[$k]['usuario_recibio'] = $usuario_recibio['usuario'];
            if ($movimientos==TRUE) {  
              $equipos[$k]['pagos'] = $this->Movimientosmodel->get_pagos_de_equipo($v['id']);
              $equipos[$k]['remisiones'] = $this->Movimientosmodel->get_remisiones_str($v['id']);
            }
      }
    }




    function importe_a_pagar_a_la_entrega($equipo_id) {
         $totalservicios = $this->get_total_de_servicios_de_equipo($equipo_id);
         $anticipo = $this->get_valor_actual_de_campo_equipo($equipo_id,"anticipo");
         $importe_a_pagar = $totalservicios - $anticipo;
         return $importe_a_pagar;      
    }    


    function get_valor_actual_de_campo_equipo($equipo_id,$campo) {
      $this->db->where("id",$equipo_id);
      $a = $this->db->get("equipos");
      $r = $a->result_array();
      $r0 = $r[0];
      return $r0[$campo];
    }

    function get_remisiones_equipo($equipo_id) { // DEPRECATED
      die();
      /*$this->db->where("id",$equipo_id);
      $a = $this->db->get("equipos");
      $r = $a->result_array();
      $r0 = array();
      $r0['num_orden'] = $r[0]['num_orden'];
      $r0['numero_remision'] = $r[0]['numero_remision'];
      $r0['numero_remision_anticipo'] = $r[0]['numero_remision_anticipo'];
      $r0['archivo_remision'] = $r[0]['archivo_remision'];
      $r0['archivo_remision_anticipo'] = $r[0]['archivo_remision_anticipo'];
      $r0['fecha_hora_remision'] = $r[0]['fecha_hora_remision'];
      $r0['fecha_hora_remision_anticipo'] = $r[0]['fecha_hora_remision_anticipo'];
      return $r0;*/
    }

function guardar_modificaciones($p) { // !!!
  $this->load->model("Movimientosmodel");
  $this->load->model("Tiposclasesequiposmodel");
  if (isset($p['tipo'])) {
    $clase = $this->Tiposclasesequiposmodel->get_clase_de_tipo($p['tipo']);
    $p['clase'] = $clase;
  }

  if (isset($p['anticipo'])) {
        $this->Movimientosmodel->agregar_ingreso_por_equipo($p['id'], $p['anticipo'],"Anticipo","ENTRADAS","ANTICIPO",$p['forma_de_pago_anticipo']);             
   }


    $p = $this->filtra_post_guardar($p);

  if (isset($p['fecha_de_entrega'])) {
    if ($p['fecha_de_entrega']=='')
        unset($p['fecha_de_entrega']);
  }

  if (isset($p['fecha_recibido'])) {
    if ($p['fecha_recibido']=='')
        unset($p['fecha_recibido']);
  }



       $this->db->where('id', $p['id']);
/*       $str = $this->db->update_string('equipos',$p,array('id'=>$p['id']));
       echo $str; die();*/
     $this->db->update('equipos', $p);
}    

  function get_clase_de_equipo($id) {
       $arreq =  $this->db->query('select clase from equipos where id=' . $id);
      $eq = ($arreq->result_array());    
      return $eq[0]['clase'];
  }  

 function get_fecha_diagnostico($equipo_id) {
      $q = $this->db->query("select fecha_adicional from bitacoras where estatus='Recibido' and equipo_id=" . $equipo_id);
      $a = $q->result_array();
      if (count($a)>0) {
        return $a[0]['fecha_adicional'];
      }
      else return 0;
 }

 function get_sqldesdebusqueda($p,$usarlim = 1,$tipoorden = "",$lim) {

		$sucursal_id = $this->session->sucursal_id;
		//$wh = " where (estatus not in ('Entregado','Donado a Rec','Reciclaje x olv'))";
		$wh = " where (equipos.sucursal_id='" . $sucursal_id . "') ";
		$pendientes = "S";
		$busca_numorden = "";
		$busca_numserie = "";
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($p)>0) { 
			     $wh = " where (sucursal_id='" . $sucursal_id . "') ";
			
			  if ((isset($p['busca_numorden'])) && ($p['busca_numorden']!="")) 
				  $wh .= " and (num_orden='" . $p['busca_numorden'] . "')";				 
			  
              if ((isset($_POST['busca_numserie'])) && ($p['busca_numserie']!="")) 
				  $wh .= " and num_serie='" . $p['busca_numserie'] . "'";
				  
			  if ((isset($p['busca_estatus'])) && ($p['busca_estatus']!="")) 
				  $wh .= " and (estatus='" . $p['busca_estatus'] . "')";				 
			  
              if ((isset($p['busca_modelo'])) && ($p['busca_modelo']!="")) 
				  $wh .= " and modelo='" . $p['busca_modelo'] . "'";
				  
              if ((isset($p['busca_tipo'])) && ($p['busca_tipo']!="")) 
				  $wh .= " and tipo='" . $p['busca_tipo'] . "'";	
				  
              if ((isset($p['busca_nombre'])) && ($p['busca_nombre']!="")) {
				  $arr = $this->db->query("select id from clientes where nombre like '%" . 
											   $p['busca_nombre'] . "%'");
	              $r = ($arr->result_array());
				  //$ids = $r[0];

        if ($arr->num_rows()>0) {      
            $ids = $r;
      

				  $nr = " and (cliente_id in (";
				  foreach ($ids as $k=>$v) {
					  $nr .= $v['id'] . ",";
				  }

          }
          else $nr = "and (cliente_id in (";
				  $nr .= "-1))";
				  $wh .= $nr;			
			  }
				 
			 
			  	  
		}
		

		$queryprincipal = 'select ' . $this->get_campos_equipos_para_sql() .  
                      //',clientes.nombre'
                      ' from equipos ' .
                      //'inner join clientes on equipos.cliente_id=clientes.id' . 
                        $wh; 	
		
		$queryprincipal .= ' order by equipos.num_orden ' . $tipoorden . ' ';

		
	if ($usarlim==1) {	
	    //$lim = $this->uri->segment(4,'0');	
    if ($this->db->platform()=="ibase") 
      $queryprincipal = str_replace("select", "select first 35 skip " . $lim . " ",$queryprincipal);
    else
	   	$queryprincipal .= ' limit ' . $lim . ',35';
	}
	  return $queryprincipal;
		
	}	


 function get_sqldesdebusqueda_fb($p,$usarlim = 1,$tipoorden = "",$lim) {

    
    //$wh = " where (estatus not in ('Entregado','Donado a Rec','Reciclaje x olv'))";
    $sucursal_id = $this->session->sucursal_id;
    $wh = " where (equipos.sucursal_id='" . $sucursal_id . "') ";  
    $pendientes = "S";
    $busca_numorden = "";
    $busca_numserie = "";
    // $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
    if (count($p)>0) { 
          $wh = " where (equipos.sucursal_id='" . $sucursal_id . "') ";  
      
        if ((isset($p['busca_numorden'])) && ($p['busca_numorden']!="")) 
          $wh .= " and (num_orden='" . $p['busca_numorden'] . "')";        
        
              if ((isset($_POST['busca_numserie'])) && ($p['busca_numserie']!="")) 
          $wh .= " and num_serie='" . $p['busca_numserie'] . "'";
          
        if ((isset($p['busca_estatus'])) && ($p['busca_estatus']!="")) 
          $wh .= " and (estatus='" . $p['busca_estatus'] . "')";         
        
              if ((isset($p['busca_modelo'])) && ($p['busca_modelo']!="")) 
          $wh .= " and modelo='" . $p['busca_modelo'] . "'";
          
              if ((isset($p['busca_tipo'])) && ($p['busca_tipo']!="")) 
          $wh .= " and tipo='" . $p['busca_tipo'] . "'";  
          
              if ((isset($p['busca_nombre'])) && ($p['busca_nombre']!="")) {
          $arr = $this->db->query("select id from clientes where nombre like '%" . 
                         $p['busca_nombre'] . "%'");
                $r = ($arr->result_array());
          //$ids = $r[0];

        if ($arr->num_rows()>0) {      
            $ids = $r;
      

          $nr = " and (cliente_id in (";
          foreach ($ids as $k=>$v) {
            $nr .= $v['id'] . ",";
          }

          }
          else $nr = "and (cliente_id in (";
          $nr .= "-1))";
          $wh .= $nr;     
        }
         
       
            
    }
    

    $queryprincipal = 'select clientes.nombre as cliente,' . $this->get_campos_equipos_para_sql() .  
                      //',clientes.nombre'
                      ' from equipos ' .
                      'inner join clientes on equipos.cliente_id=clientes.id' . 
                        $wh;  
    
    $queryprincipal .= ' order by equipos.num_orden ' . $tipoorden . ' ';

    
  if ($usarlim==1)   
      $queryprincipal = str_replace("select", "select first 35 skip " . $lim . " ",$queryprincipal);
    return $queryprincipal;
    
  }    


   function get_equipos_desde_busqueda($p,$usarlim,$orden,$lim) {
        $qry = $this->Equiposmodel->get_sqldesdebusqueda_fb($p,$usarlim,$orden,$lim);
        $arr = $this->db->query($qry);
        $r = $arr->result_array(); 
        //$clientes=TRUE,$servicios=TRUE,$tipos=TRUE,$movimientos=TRUE
        if ($this->db->platform()!="ibase")
          $this->agregar_datos($r,TRUE,FALSE,FALSE,TRUE);
     /*   else
          $this->agregar_datos($r,FALSE,FALSE,FALSE,TRUE);*/

        return $r;
   }

   function get_total_equipos_desde_busqueda($p) {
        $sql = $this->Equiposmodel->get_sqldesdebusqueda($p,0,"",0);
        $campos = $this->get_campos_equipos_para_sql();
        $sql = str_replace($campos, "count(*) as cnt", $sql);
        $p = strpos($sql,"order by",0);
        $sql = substr($sql, 0, $p);
        $arrtot = $this->db->query($sql);
        $res = $arrtot->result_array();

        $total_rows = $res[0]['cnt'];
        return $total_rows;   
    //return 500;
   }

   function get_valor_de_campo_de_equipo($equipo_id,$campo) {
       $this->db->where("id",$equipo_id);
       $arr = $this->db->get("equipos");
       $res = $arr->result_array();
       if (count($res)>0) {
          $eq = $res[0];
          return $eq[$campo];
        }
      else return "";
   }

   function get_equipo($id) {
      return $this->get_detalle_equipo($id);
   }

   function get($id) {
      return $this->get_detalle_equipo($id);
   }

   function get_detalle($id) {
      return $this->get_detalle_equipo($id);    
   }


   function get_detalle_equipo($id) {
       $sucursal_id = $this->session->sucursal_id;

       $this->load->model("Clientesmodel");
       $this->load->model('Tiposclasesequiposmodel');
       $this->load->model('Movimientosmodel');
       $this->load->model('Serviciosequiposmodel');
       $this->db->where("id",$id);
       $this->db->where("sucursal_id",$sucursal_id);

   	   $arr = $this->db->get("equipos");
       $data = $arr->result_array();
        if (count($data)) {
           
           $equipo = $data[0];
           $equipo['diagnostico'] = str_replace('\r\n', PHP_EOL, $equipo['diagnostico']);
           $equipo['descripcion_problema'] = str_replace('\r\n', PHP_EOL, $equipo['descripcion_problema']);
           $equipo['condiciones_recepcion_eq'] = str_replace('\r\n', PHP_EOL, $equipo['condiciones_recepcion_eq']);


           $detalletipo = $this->Tiposclasesequiposmodel->get_detalle($equipo['tipo']);
           $equipo['descripcion_tipo'] = $detalletipo['descripcion'];

      $equipo['fecha_diagnostico'] = $this->get_fecha_diagnostico($id);
      $equipo['cliente'] = $this->Clientesmodel->get_cliente_de_equipo($id);
      $usuario_recibio = $this->get_usuario_recibio($id);
      $equipo['usuario_recibio'] = $usuario_recibio['usuario'];
      $equipo['pagos'] = $this->Movimientosmodel->get_pagos_de_equipo($id);
      $equipo['remisiones'] = $this->Movimientosmodel->get_remisiones_str($id);
      $equipo['importe_servicios'] = $this->Serviciosequiposmodel->get_total_de_servicios_de_equipo($id);

           return $equipo;
        }
        else return null;
   }


   function get_usuario_recibio($id) {
        $arrur = $this->db->query("select b.usuario_id,b.equipo_id,u.usuario from bitacoras b inner join usuarios u on b.usuario_id=u.id where b.equipo_id=" . $id . " and estatus='Recibido'") ;
	    $usrur = $arrur->result_array();
	    if (count($usrur)>0)
	       return $usrur[0];
	    else {
	         return array("usuario"=>"","equipo_id"=>0,"usuario"=>"");
	    }
   }

   function existe_numorden($num_orden) {
        $arreq = $this->db->query("select count(*) as cnt from equipos where num_orden='" . $num_orden . "'");
        $arreqarr = $arreq->result_array();
        $nr = $arreqarr[0]['cnt'];
        if ($nr==0)
        	  return FALSE;
        else return TRUE;
   }

   function insertar_equipo($arreq){
    $arreq = $this->filtra_post_guardar($arreq);
    $this->load->model("Registroaccionesmodel");
    $this->load->model("Movimientosmodel");

    $tipodetalle = $this->Tiposclasesequiposmodel->get_detalle($_POST['tipo']);



    $arreq['clase'] =  $tipodetalle['clase'];
    $arreq['modelo'] = $tipodetalle['modelo'];
    $arreq['usuario_id'] = $this->session->userdata('usuario_id');
    $arreq['sucursal_id'] =  $this->session->sucursal_id;


    $this->Registroaccionesmodel->registrar("NUEVO","equipos",$_POST['num_orden']);

    $this->db->insert('equipos',$arreq);

    $q = $this->db->query("select first 1 id from equipos order by id desc");
    $aq = $q->result_array();

		$ultimo_eq_id = $aq[0]['id'];

/*
    if ($_POST['anticipo']!=0) {
            $es_anticipo = 1;
        //function agregar_ingreso_por_equipo($equipo_id, $importe,$concepto,$cta,$scta,$sscta)            
        $this->Movimientosmodel->agregar_ingreso_por_equipo($ultimo_eq_id, $_POST['anticipo'],"Anticipo","ENTRADAS","ANTICIPO",$_POST['forma_de_pago_anticipo']);             
    }
    */

		return $ultimo_eq_id;
   }

    function id_numorden($num_orden) {
        $arreq = $this->db->query("select id from equipos where num_orden='" . $num_orden . "'");
        $ra = $arreq->result_array();
        return $ra[0]['id'];
   }


   function  get_total_de_servicios_de_equipo($equipo_id) {
       $this->load->model("Serviciosequiposmodel");
      //echo $equipo_id; die();
       $t = $this->Serviciosequiposmodel->get_total_de_servicios_de_equipo($equipo_id);
       return $t;
   }

   function get_total_a_pagar_a_la_entrega($equipo_id) {
       $t = $this->get_total_de_servicios_de_equipo($equipo_id);
       $e = $this->get_detalle_equipo($equipo_id);
       $anticipo = $e['anticipo'];
       $r = $t - $anticipo;
       return $t;
   }


   function get_numorden_estandarizado($num_orden_no_estandarizado) {
        $serie = $this->get_serie_actual();
        //echo substr($num_orden_no_estandarizado,0,2); die();
        if (substr($num_orden_no_estandarizado,0,2)!=$serie) {
          $num_orden_nuevo = ltrim($num_orden_no_estandarizado,"0");
          $num_orden_nuevo_con_serie = $serie . sprintf("%04d",$num_orden_nuevo); 
        }
        else
          $num_orden_nuevo_con_serie = $num_orden_no_estandarizado;
        return $num_orden_nuevo_con_serie;
   }

   function get_numorden_incrementar() {
   	    $arrnumord =  $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();		
		$signumorden = $numordenes[0]['numero_orden'] + 1;		   
	    $p = array("numero_orden"=>$signumorden);  
		$this->db->where('sucursal_id', $this->session->sucursal_id);
		$this->db->update('numerosordenes', $p);
		$numordenactual =  $numordenes[0]['serie'] . sprintf("%04d",$numordenes[0]['numero_orden']);
		return $numordenactual;
   }

   function get_numorden_no_incrementar() {
        $arrnumord =  $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();   	
		$numordenactual = $numordenes[0]['serie'] . sprintf("%04d",$numordenes[0]['numero_orden']);
		return $numordenactual;
   }

   function get_numero_orden_actual() {
        $arrnumord =  $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();   
		$no = $numordenes[0]['numero_orden'];
		return $no; 
   }   

   function get_numremision_incrementar() {
   	    $arrnumord = $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = ($arrnumord->result_array());		

        if ($numordenes[0]['numero_remision']=="")
        	$signum = 1;
        else
		    $signum = $numordenes[0]['numero_remision'] + 1;		   

	    $p = array("numero_remision"=>$signum);  
		$this->db->where('sucursal_id', $this->session->sucursal_id);
		$this->db->update('numerosordenes', $p);
		$numactual =  $numordenes[0]['numero_remision'];
		return $numactual;
   }

   function get_numremision_no_incrementar() {
        $arrnumord = $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");

        $numordenes = ($arrnumord->result_array());		
		$numremisionactual = $numordenes[0]['numero_remision'];
		if ($numremisionactual=="")
			 $numremisionactual = 0;
		return $numremisionactual;
   }

   function set_numero_remision_a_equipo($equipo_id) {
   	    $numero_remision = $this->get_numremision_incrementar();
   	    $this->db->where('id',$equipo_id);
   	    $p = array("numero_remision"=>$numero_remision);
   	    $this->db->update('equipos',$p);
        // EN MOVIMIENTOS
        $wh = array("equipo_id"=>$equipo_id,
                    "cta"=>"ENTRADAS",
                    "scta"=>"ENTREGA");
        $this->db->where($wh);
        $this->db->update("movimientos",array("numero_remision"=>$numero_remision));

   	    return $numero_remision;
   }

   function eliminar_remision($equipo_id) {
     if ($this->session->userdata('nivel')==1) {
       $eq = $this->get_detalle_equipo($equipo_id);

       if ($eq['archivo_remision']!="")
            unlink(dirname(__FILE__) . '/../../../archivos/remisiones/' . $eq['archivo_remision']);
       //archivos/remisiones/ unlink

       $this->db->where("id",$equipo_id);
       $this->db->set("numero_remision",NULL);
       $this->db->set("archivo_remision",NULL);
       $this->db->set("fecha_hora_remision",NULL);
       $this->db->update("equipos");
     }
     else die('Usuario sin permisos para esta operación.');
   }

   function eliminar_remision_anticipo($equipo_id) {
     if ($this->session->userdata('nivel')==1) {
       $eq = $this->get_detalle_equipo($equipo_id);

   

       if ($eq['archivo_remision_anticipo']!="") {

         $nombre_fichero = dirname(__FILE__) . '/../../../archivos/remisiones/cancelado-' . $eq['archivo_remision_anticipo'];
         $i = 1;
         while (file_exists($nombre_fichero)) { 
               $nombre_fichero = dirname(__FILE__) . '/../../../archivos/remisiones/cancelado-' . $i . '-' . $eq['archivo_remision_anticipo'];
               $i++;
            }        

            rename(dirname(__FILE__) . '/../../../archivos/remisiones/' . $eq['archivo_remision_anticipo'],
              $nombre_fichero    //dirname(__FILE__) . '/../../../archivos/remisiones/cancelado-' . $eq['archivo_remision_anticipo']
              );      
        }
       $this->db->where("id",$equipo_id);
       $this->db->set("numero_remision_anticipo",NULL);
       $this->db->set("anticipo",0);
       $this->db->set("archivo_remision_anticipo",NULL);
       $this->db->set("fecha_hora_remision_anticipo",NULL);
       $this->db->set("forma_de_pago_anticipo","NOESP");
       $this->db->update("equipos");
     }
     else die('Usuario sin permisos para esta operación.');
   }



   function set_numero_remision_anticipo_a_equipo($equipo_id) {
        $numero_remision = $this->get_numremision_incrementar();
        $this->db->where('id',$equipo_id);
        $p = array("numero_remision_anticipo"=>$numero_remision);
        $this->db->update('equipos',$p);

        // EN MOVIMIENTOS
        $wh = array("equipo_id"=>$equipo_id,
                    "cta"=>"ENTRADAS",
                    "scta"=>"ANTICIPO");
        $this->db->where($wh);
        $this->db->update("movimientos",array("numero_remision"=>$numero_remision));


        return $numero_remision;
   }   

   function set_paquete_a_equipo($equipo_id,$paquete_id) {
        $this->load->model("Paquetesmodel");
        $paquete = $this->Paquetesmodel->get_detalle($paquete_id);        
        
         if (($paquete['paquete']=='LIGHT') or ($paquete['paquete']=='BASICO'))
             $se ="N";
         else $se = "S";

        $this->db->where('id',$equipo_id);
        $p = array("paquete_id"=>$paquete_id,"servicio_express"=>$se);
        $this->db->update('equipos',$p);
        return 1;        
   }

   function get_serie_actual() {
   	    $arrnumord =  $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();		
		$serie = $numordenes[0]['serie'];
		return $serie;
   }

   function get_clave_sucursal() {
        $arrnumord =  $this->db->query("select * from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();   
    $serie = $numordenes[0]['clave_sucursal'];
    return $serie;
   }

   function get_datos_smtp() {
        $arrnumord =  $this->db->query("select smtp_user,smtp_pass,sucursal,clave_sucursal from numerosordenes where sucursal_id='" . $this->session->sucursal_id . "'");
        $numordenes = $arrnumord->result_array();   

    $serie = $numordenes[0];
    return $serie;
   }


   function set_serie_numorden($serie,$numorden) {
   	  $qry1 = "update  numerosordenes set serie='" . $serie . 
                 "', numero_orden=" . $numorden . " where sucursal_id='" . $this->session->sucursal_id . "'";
		$arr1 = ( $this->db->query($qry1));
   	 return 1;
   }

   function set_numero_remision($numremision) {
   	  $qry1 = "update  numerosordenes set "  . 
                 " numero_remision=" . $numremision . " where sucursal_id='" . $this->session->sucursal_id . "'";
		$arr1 = ( $this->db->query($qry1));
   	 return 1;
   }


   function cancelar_orden($id) {
   	 $this->db->query("update equipos set situacion='X',fecha_cancelado=NOW() where id='" . $id . "'");
   	 return 1;
   }

   function cancelar_entrega($equipo_id) {
   	    // NO VERIFICA SI FUE ENTREGADO
   	    // YA QUE PARA CUANDO SE EJECUTA ESTO, YA SE ELIMINO EN LA BITACORA EL ESTATUS DE ENTREGADO.
    if ($this->db->platform()=="ibase")
    	$arr =  $this->db->query("select first 1 * from bitacoras where equipo_id=" .  $equipo_id . 
    		                     " order by fecha desc, hora desc");
    else
      $arr =  $this->db->query("select * from bitacoras where equipo_id=" .  $equipo_id . 
                             " order by fecha desc, hora desc limit 1");

	    $databit = ($arr->result_array());


	    if (count($databit)>0) {
			$registro = $databit[0];
			$est = $registro['estatus'];
			$estid = $registro['estatus_id'];
		}
		else {
			$est = "";
			$estid = -1;
		}	    


        $actualizachlistent = "chlst_ent_encendido='N',chlst_ent_lcd='N',chlst_ent_digitalizador='N'," .
                              "chlst_ent_conector='N',chlst_ent_sonido='N',chlst_ent_camara='N',chlst_ent_conexiones='N'," .
                              "chlst_ent_botones='N',chlst_ent_sim='N',chlst_ent_software='N',chlst_ent_carcasa='N'," .
                              "chlst_ent_sensores='N',";
		$actualizasituacion = " situacion='A', forma_de_pago='', ";

        $query = "update equipos set " . $actualizachlistent  . $actualizasituacion . 
                 "estatus='" . $est . "', estatus_id=" . $estid . 
                 "  where id='" . $this->uri->segment(4)  . "'" ;
        $r     = $this->db->query($query);
        return TRUE;

   }

   function eliminar_equipo($equipo_id,$num_orden,$passwd_admin) {

	   	$qry1 = "select * from equipos where id=" . $equipo_id;
			$arr1 = ( $this->db->query($qry1));
			$res1 = ($arr1->result_array());
			$eq = $res1[0];
			
			$qry2 = "select * from usuarios where passwd='" . $passwd_admin . "'";
			$arr2 = ( $this->db->query($qry2));
		if ($arr2->num_rows()>0) {
			$res2 = ($arr2->result_array());
			$nivusr = $res2[0]['nivel'];
		}
		else $nivusr=-1;

   if (($num_orden==$eq['num_orden']) && ($nivusr==1)) {
     	$this->db->query("delete from equipos where id='" . $equipo_id . "'");
     	$this->db->query("delete from bitacoras where equipo_id='" . $equipo_id . "'");
		$this->db->query("delete from piezas where equipo_id='" . $equipo_id . "'");
		$this->db->query("delete from servicios where equipo_id='" . $equipo_id . "'");
		return TRUE;
	}
	else return FALSE;

   }



  function get_equipos_en_empresa() {
  	  $arr = $this->db->query("select * from equipos where estatus not in ('Entregado','Reciclaje forzado','Donado a reciclaje') and situacion='A'");
	    $data = ($arr->result_array());
	    $data2 = array();
	    foreach ($data as $k=>$v) {
	    	 $arrt = $this->db->query("select * from tipos where tipo='" . $v['tipo'] . "'");
	         $datat = $arrt->result_array();
	         $v['descripcion_tipo'] = $datat[0]['descripcion'];
            $data2[$k] = $v;
	    }
	    return $data;
  }

  function concluir_orden_equipo(){
        $this->db->where('id',$_POST['equipo_id']);
		$e = array("situacion"=>"C");
		$this->db->update('equipos',$e);	  	
		return 1;
  }

  function get_estatus_equipo($equipo_id){
  	   $equipo = $this->get_equipo($equipo_id);
  	   $estatus = $equipo['estatus'];
  	   return $estatus;
  }

  function poner_servicios_en_cero($equipo_id){
  	   $this->db->where('equipo_id',$equipo_id);
  	   $u = array("subtotal"=>0);
  	   $this->db->update('servicios',$u);
       return 1;
  }

  function reestablecer_servicios_sin_ceros($equipo_id){
  	   $this->db->query('update servicios set subtotal=costo-descuento where equipo_id=' . $equipo_id);
       return 1;
  }

  function get_numero_servicios_equipo($equipo_id) {
      $arr = $this->db->query("select count(*) as cnt from servicios where equipo_id=" . $equipo_id);
      $data = ($arr->result_array());
      return $data[0]['cnt'];
  }

  function array_checklist($tipo="") {
      $ch = array(
           "chlst_rec_sensor_centro"=>"a. Sensor de centro de carga activado.",
           "chlst_rec_sensor_humedad"=>"b. Sensor de humedad de entrada de auriculares activado.",
           "chlst_rec_falla_carga"=>"c. Falla recepci&oacute;n de carga de corriente.",
           "chlst_rec_falla_deteccion"=>"d. Falla detecci&oacute;n en computadora.",
           "chlst_rec_falla_senal"=>"e. Falla recepci&oacute;n de se&ntilde;al telef&oacute;nica.",
           "chlst_rec_falla_wifi"=>"f.  Falla recepci&oacute;n de se&ntilde;al wifi y bluetooth.",
           "chlst_rec_falla_visualizacion"=>"g. Falla visualizaci&oacute;n correcta del pantalla.",
           "chlst_rec_falla_com_touch"=>"h. Falla detecci&oacute;n de comandos de touch.",
           "chlst_rec_falla_com_rueda"=>"i.  Falla detecci&oacute;n de comandos rueda.",
           "chlst_rec_func_boc_altavoz"=>"j.  Falla funci&oacute;n de la bocina altavoz.",
           "chlst_rec_func_boc_auricular"=>"k. Falla funci&oacute;n de la bocina auricular.",
           "chlst_rec_func_ent_auriculares"=>"l.  Falla funci&oacute;n de la entrada de auriculares.",
           "chlst_rec_func_microfono"=>"m. Falla funci&oacute;n del micr&oacute;fono.",
           "chlst_rec_func_bot_home"=>"n. Falla funci&oacute;n del bot&oacute;n home.",
           "chlst_rec_func_bot_encendido"=>"o. Falla funci&oacute;n del bot&oacute;n de encendido o hold.",
           "chlst_rec_func_bot_silencio"=>"p. Falla funci&oacute;n del bot&oacute;n de silencio.",
           "chlst_rec_func_bot_volumen"=>"q. Falla funci&oacute;n de los botones de volumen.",
           "chlst_rec_falla_bandeja_sim"=>"r.  Falla bandeja SIM."
        );

    if ($tipo=="ent") { 
      $newarray = array();
      foreach ($ch as $k=>$v) {
        $knw = str_replace("_rec_", "_ent_", $k);
        $newarray[$knw] = $v;
      }
        return $newarray;
    }    
    else {
       return $ch;
     }
  }


  function siguiente_equipo_activo($equipo_id=0) {

      $arr = $this->db->query("select first 1 id from equipos where id>" . $equipo_id . 
           " and situacion='A' and sucursal_id='" . $this->session->sucursal_id . "' order by id");

      $data = $arr->result_array();
      if (count($data)>0)
         return $data[0]['id'];
      else return $equipo_id;

  }

  function anterior_equipo_activo($equipo_id=0) {

      $arr = $this->db->query("select first 1 id from equipos where id<" . $equipo_id . 
           " and situacion='A' and sucursal_id='" . $this->session->sucursal_id . "' order by id desc");

      $data = $arr->result_array();
      if (count($data)>0)
         return $data[0]['id'];
      else return $equipo_id;

  }

  function siguiente_equipo($equipo_id=0) {

      $arr = $this->db->query("select first 1 id from equipos where id>" . $equipo_id . 
           "   and sucursal_id='" . $this->session->sucursal_id . "' order by id");

      $data = $arr->result_array();
      if (count($data)>0)
         return $data[0]['id'];
      else return $equipo_id;

  }

  function anterior_equipo($equipo_id=0) {

      $arr = $this->db->query("select first 1 id from equipos where id<" . $equipo_id . 
           "   and sucursal_id='" . $this->session->sucursal_id . "' order by id desc");

      $data = $arr->result_array();
      if (count($data)>0)
         return $data[0]['id'];
      else return $equipo_id;

  }  

  function exportacion_datos($anio,$mes) {

    $qry = "select * from equipos inner join clientes on equipos.cliente_id=clientes.id where (equipos.sucursal_id='" . $this->session->sucursal_id . "') and  extract(year from fecha_recibido)=" . $anio . " and extract(month from fecha_recibido)=" . $mes . " order by equipos.id";
    
    $arr = $this->db->query($qry);
    $data = $arr->result_array();
    $data2 = array();
    $ii = 0;
    foreach ($data as $k=>$v) {
       //$v['servicio_descripcion'] = "";
       

       $sql = "select * from servicios where equipo_id=" . $v['id'];
       $arrs = $this->db->query($sql); 
       $a1 = $arrs->result_array();
      if (count($a1)>0) {
          $v['servicios'] = $a1;
         }
         else $v['servicios'] = array();
      $data2[$ii] = $v;
      $ii++;
    }
    return $data2;
 

  }


    function colocar_nota_de_venta($equipo_id,$nombre_archivo) {
      $this->db->where("id",$equipo_id);
      $arr = array("archivo_remision"=>$nombre_archivo, "fecha_hora_remision"=>fecha_hora_actual_mysql());
      $this->db->update("equipos",$arr);
      return 1;
    }  

    function tiene_nota_de_venta($equipo_id) {

      $this->load->model("Movimientosmodel");
      $sql = "select first 1 * from movimientos where equipo_id=" . $equipo_id . " and cta='ENTRADAS' and scta='ENTREGA'";
      $q = $this->db->query($sql);
      $a = $q->result_array();
      
      if (count($a)>0)
         return 1;
      else
         return 0;
    }      


    function colocar_nota_de_venta_anticipo($equipo_id,$nombre_archivo) {
      $this->db->where("id",$equipo_id);
      $arr = array("archivo_remision_anticipo"=>$nombre_archivo, "fecha_hora_remision_anticipo"=>fecha_hora_actual_mysql());
      $this->db->update("equipos",$arr);
      return 1;
    }  

    function tiene_nota_de_venta_anticipo($equipo_id) {
      $this->load->model("Movimientosmodel");
      $sql = "select first 1 * from movimientos where equipo_id=" . $equipo_id . " and cta='ENTRADAS' and scta='ANTICIPO' ORDER by fecha,hora";
      $q = $this->db->query($sql);
      $a = $q->result_array();
      if (count($a)>0)
         return 1;
      else
         return 0;
    }   

    function ruta_nota_de_venta($equipo_id) {
     
      if ($this->tiene_nota_de_venta($equipo_id)==1){
            $sql = "select first 1 * from movimientos where equipo_id=" . $equipo_id . " and cta='ENTRADAS' and scta='ENTREGA' ORDER by fecha,hora";
            $q = $this->db->query($sql);
            $a = $q->result_array();
            $a0 = $a[0];

          return '/archivos/remisiones/' . $a0['archivo_remision'];
        }
      else
          return '';
    }             

    function ruta_nota_de_venta_anticipo($equipo_id) {
     
      if ($this->tiene_nota_de_venta_anticipo($equipo_id)==1){

            $sql = "select first 1 * from movimientos where equipo_id=" . $equipo_id . " and cta='ENTRADAS' and scta='ANTICIPO' ORDER by fecha,hora";
            $q = $this->db->query($sql);
            $a = $q->result_array();
            $a0 = $a[0];
          return '/archivos/remisiones/' . $a0['archivo_remision'];
        }
      else
          return '';
    }      

   
    function remisiones() {
      $this->db->where("MONTH(fecha)",9);
      $this->db->order_by('fecha');
      $q = $this->db->get("movimientos");
      $a = $q->result_array();
    }



    function filtra_post_guardar($p) {
        $a = $this->get_campos();
        //print_r($a); die();
        foreach ($p as $pk=>$pv) {
            $existe = 0;
             foreach ($a as $k=>$v) {
                 if (strtolower($pk)==strtolower($k))
                     $existe = 1;                
             }             
              if (!$existe)
                unset($p[$pk]);
         }
         return $p; 
    }   

    function opciones_facturar() {
      $a = array("NO"=>"No facturar","SI"=>"Sí facturar","YA FACTURADO"=>"Ya fue facturado");
      return $a;
    }

    function marcar_como_facturado($equipo_id) {
      try {
      $this->db->where("id",$equipo_id);
      $fecha = fecha_actual_mysql();
      $hora = hora_actual_mysql();
      $a = array("facturar"=>"YA FACTURADO","fecha_facturado"=>$fecha,"hora_facturado"=>$hora);
      $this->db->update("equipos",$a);
      return 1;
      }
      catch (Exception $e) {
        return $e->getMessage();
      }
      
    } 


    function get_estatuses() {
       $this->load->model("Estadosmodel");
       return $this->Estadosmodel->get_estatuses();
    }

    function get_cierre_de_mes_administracion($sucursal_id,$anio,$mes) {

        $q = $this->db->query("select * from R_CIERRE_DE_MES_INGRESOS('" . $sucursal_id . "'," . $anio . "," . $mes . ") order by numero_remision desc ");
        $a = $q->result_array();

        return $a;
    }
     function get_cierre_de_mes_administracion_varios($seleccionados,$anio,$mes) {

      $resultado = [];

     	for ($i=0; $i < sizeof($seleccionados); $i++) { 
        $q = $this->db->query("select * from R_CIERRE_DE_MES_INGRESOS('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") order by numero_remision desc ");
        $a = $q->result_array();
        for($i = 0; $i<sizeof($a);$i++){
          if (is_null($a[$i]['numero_remision'])){
            $a[$i]['importe'] = "-".$a[$i]['importe'];
          }
        }

        $resultado  = array_merge($resultado, $a);
      }
        return $resultado;
    }

	function get_accesorios_varios($seleccionados,$anio,$mes) {

      $resultado = [];

     	for ($i=0; $i < sizeof($seleccionados); $i++) { 
		
			$q = $this->db->query("select * from R_CIERRE_DE_MES_INGRESOS('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") WHERE DESCRIPCION_TIPO = 'Accesorios' order by numero_remision desc ");
			$a = $q->result_array();

        $resultado  = array_merge($resultado, $a);
      }
        return $resultado;
    }


	function get_ventas_sucursales_dia($seleccionados,$anio,$mes,$dia) {

		$resultado = [];

     	for ($i=0; $i < sizeof($seleccionados); $i++) { 
        
      		$q = $this->db->query("select * from R_CIERRE_DE_MES_INGRESOS('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") WHERE extract(day from fecha) = '" . $dia . "' order by numero_remision desc ");

              $a = $q->result_array();

              $resultado  = array_merge($resultado, $a);
      }
        return $resultado;
    }

  function get_accesorios_sucursales_dia($seleccionados,$anio,$mes,$dia) {

    $resultado = [];

      /*
      $anio = 2020;
      $mes  = 10;
      $dia  = 17;
      */

      for ($i=0; $i < sizeof($seleccionados); $i++) { 
        
          $qry = "SELECT * "; 
          $qry .= "FROM R_CIERRE_DE_MES_INGRESOS('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") ";
          $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' ";
          $qry .= "AND extract(day from fecha) = '" . $dia . "' "; 
          $qry .= "ORDER BY numero_remision desc ";

          //print($qry);  

          $q = $this->db->query($qry);

              $a = $q->result_array();

              $resultado  = array_merge($resultado, $a);
      }
        return $resultado;
    }


  function get_accesorios_sucursales_mes($seleccionados,$anio,$mes) {

    $resultado = [];

    $q = $this->db->query("select distinct numero_remision from movimientos where Extract(Month From MOVIMIENTOS.FECHA) = 08 And Extract(Year From MOVIMIENTOS.FECHA) = 2021 and sucursal_id = 'XU1'");
    $a = $q->result_array();
    //print_r($a);

      
      for ($i=0; $i < sizeof($seleccionados); $i++) { 
        
         $qry =  " SELECT";
         $qry .= " SERVICIOS.SUBTOTAL As Importe, EQUIPOS.SUCURSAL_ID, EQUIPOS.TIPO AS descripcion_tipo, ";
         $qry .= "'" . $mes . "/" . $anio . "' as periodo, ";
         $qry .= " SERVICIOS.FECHA, MOVIMIENTOS.NUMERO_REMISION As numero_remision, EQUIPOS.NUM_ORDEN AS num_orden, ";
         $qry .= " SERVICIOS.DESCRIPCION as descripcion_servicios, ";
         $qry .= " MOVIMIENTOS.SSCTA As forma_de_pago, MOVIMIENTOS.CONCEPTO As observaciones ";
         $qry .= " FROM ";
         $qry .= " SERVICIOS Inner Join EQUIPOS On EQUIPOS.ID = SERVICIOS.EQUIPO_ID ";
         $qry .= " Inner Join MOVIMIENTOS On MOVIMIENTOS.EQUIPO_ID = EQUIPOS.ID ";
         $qry .= " WHERE ";
         $qry .= " EQUIPOS.SUCURSAL_ID = '" . $seleccionados[$i] . "' And EQUIPOS.TIPO = 'Accesorios' And ";
         $qry .= " Extract(Month From SERVICIOS.FECHA) = " . $mes . " And ";
         $qry .= " Extract(Year From SERVICIOS.FECHA) = " . $anio . " ";
         $qry .= " Order By SERVICIOS.ID Desc ";
         
         /*
          $qry = "SELECT * "; 
          $qry .= "FROM R_CIERRE_DE_MES_INGRESOS('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") ";
          $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' ";
          $qry .= "ORDER BY numero_remision desc ";
         */ 
          //print($qry);  

          $q = $this->db->query($qry);

              $a = $q->result_array();

              $resultado  = array_merge($resultado, $a);
      }
        return $resultado;
    }

    function get_ventas_sucursales_dia_resumen($seleccionados,$anio,$mes,$dia) {

      $resultado = [];

      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");

      $guion = '-';
      $fecha = $anio.$guion.$mes.$guion.$dia;

      for ($i=0; $i < sizeof($seleccionados); $i++) {

        // SUCURSAL
        $qry = "SELECT SUCURSAL_ID AS sucursal, count(*) AS totalMovimientos , sum(IMPORTE) AS total, ";

        //EFECTIVO - NUMERO DE NOTAS  
        $qry .= "(SELECT count(*) AS totalMovEfectivo FROM MOVIMIENTOS ";
        $qry .= "WHERE SUCURSAL_ID = '" . $seleccionados[$i] . "' AND FECHA = '" . $fecha . "' ";
        $qry .= "AND SSCTA = 'EFECTIVO' ), ";
        
        //EFECTIVO - MONTO TOTAL  
        $qry .= "(SELECT sum(IMPORTE) AS totalEfectivo FROM MOVIMIENTOS ";
        $qry .= "WHERE SUCURSAL_ID = '" . $seleccionados[$i] . "' AND FECHA = '" . $fecha . "' ";
        $qry .= "AND SSCTA = 'EFECTIVO' ), ";
        
        //NO EFECTIVO - NUMERO DE NOTAS 
        $qry .= "(SELECT count(*) AS totalMovElectronico FROM MOVIMIENTOS ";
        $qry .= "WHERE SUCURSAL_ID = '" . $seleccionados[$i] . "' AND FECHA = '" . $fecha . "' ";
        $qry .= "AND SSCTA <> 'EFECTIVO' ), ";
        
        // NUMERO DE NOTAS NNOO EFECTIVO Y SU IMPORTE TOTAL 
        $qry .= "(SELECT sum(IMPORTE) AS totalElectronico FROM MOVIMIENTOS ";
        $qry .= "WHERE SUCURSAL_ID = '" . $seleccionados[$i] . "' AND FECHA = '" . $fecha . "' ";
        $qry .= "AND SSCTA <> 'EFECTIVO' ) ";
        
        // NUMERO DE NOTAS EN TARJETA TRANSFERENCIA U OTROS Y SU IMPORTE TOTAL 
        $qry .= "FROM MOVIMIENTOS ";
        $qry .= "WHERE SUCURSAL_ID = '" . $seleccionados[$i] . "' AND FECHA = '" . $fecha . "' ";
        $qry .= "GROUP BY SUCURSAL_ID "; 
        //print_r($qry);
        
        //print($qry);

        $q = $this->db->query($qry);
        
        $a = $q->result_array();
        $resultado  = array_merge($resultado, $a);
      }
      return $resultado;
    }

function get_accesorios_sucursales_dia_resumen($seleccionados,$anio,$mes,$dia) {

      $resultado = [];

      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");

      $guion = '-';
      $fecha = $anio.$guion.$mes.$guion.$dia;

      for ($i=0; $i < sizeof($seleccionados); $i++) {

        // SUCURSAL
        $qry = "SELECT '" . $seleccionados[$i] . "' AS sucursal, count(*) AS totalMovimientos , sum(IMPORTE) AS total, ";

        //EFECTIVO - NUMERO DE NOTAS  
        $qry .= "(SELECT count(*) AS totalMovEfectivo FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO = 'EFECTIVO' AND extract(day from fecha) = '" . $dia . "' ), ";
        
        //EFECTIVO - MONTO TOTAL  
        $qry .= "(SELECT sum(IMPORTE) AS totalEfectivo FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO = 'EFECTIVO' AND extract(day from fecha) = '" . $dia . "' ), ";
        
        //DIGITAL - NUMERO DE NOTAS  
        $qry .= "(SELECT count(*) AS totalmovelectronico FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO <> 'EFECTIVO' AND extract(day from fecha) = '" . $dia . "' ), ";
        
        //DIGITAL - MONTO TOTAL  
        $qry .= "(SELECT sum(IMPORTE) AS totalelectronico FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO <> 'EFECTIVO' AND extract(day from fecha) = '" . $dia . "' ) ";
        
        // NUMERO DE NOTAS EN TARJETA TRANSFERENCIA U OTROS Y SU IMPORTE TOTAL 
        $qry .= "FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND extract(day from fecha) = '" . $dia . "'  ";
        $qry .= "group by DESCRIPCION_TIPO ";
         
        
        //print($qry);

        $q = $this->db->query($qry);
        
        $a = $q->result_array();
        $resultado  = array_merge($resultado, $a);
      }
      return $resultado;
    }

function get_accesorios_sucursales_mes_resumen($seleccionados,$anio,$mes) {

      $resultado = [];

      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");

      $guion = '-';
      $fecha = $anio.$guion.$mes.$guion.$dia;

      for ($i=0; $i < sizeof($seleccionados); $i++) {

        // SUCURSAL
        $qry = "SELECT '" . $seleccionados[$i] . "' AS sucursal, count(*) AS totalMovimientos , sum(IMPORTE) AS total, ";

        //EFECTIVO - NUMERO DE NOTAS  
        $qry .= "(SELECT count(*) AS totalMovEfectivo FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO = 'EFECTIVO' ), ";
        
        //EFECTIVO - MONTO TOTAL  
        $qry .= "(SELECT sum(IMPORTE) AS totalEfectivo FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO = 'EFECTIVO'  ), ";
        
        //DIGITAL - NUMERO DE NOTAS  
        $qry .= "(SELECT count(*) AS totalmovelectronico FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO <> 'EFECTIVO'  ), ";
        
        //DIGITAL - MONTO TOTAL  
        $qry .= "(SELECT sum(IMPORTE) AS totalelectronico FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ")  ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios' AND FORMA_DE_PAGO <> 'EFECTIVO'  ) ";
        
        // NUMERO DE NOTAS EN TARJETA TRANSFERENCIA U OTROS Y SU IMPORTE TOTAL 
        $qry .= "FROM R_CIERRE_DE_MES_INGRESOS ('" . $seleccionados[$i] . "'," . $anio . "," . $mes . ") ";
        $qry .= "WHERE DESCRIPCION_TIPO = 'Accesorios'  ";
        $qry .= "group by DESCRIPCION_TIPO ";
         
        
        //print($qry);

        $q = $this->db->query($qry);
        
        $a = $q->result_array();
        $resultado  = array_merge($resultado, $a);
      }
      return $resultado;
    }
  
     
    function get_ventas_sucursales_mes($seleccionados,$anio,$mes,$dia) {
      $resultado = [];
      for ($i=0; $i < sizeof($seleccionados); $i++) { 
        $q = $this->db->query("select sucursal_id as sucursal, (select count(*) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."') as totalMovimientos, (select sum(importe) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."') as total, (select count(*) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."' and sscta='EFECTIVO') as totalMovEfectivo, (select sum(importe) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."' and sscta IN ('EFECTIVO','NOESP')) as totalEfectivo, (select count(*) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."' and sscta IN ('TARJETA','TRANSFERENCIA')) as totalMovElectronico, (select sum(importe) from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."' and sscta in ('TARJETA','TRANSFERENCIA')) as totalElectronico from movimientos where extract(month from fecha) = ".$mes." and extract(year from fecha) = ".$anio." and sucursal_id = '".$seleccionados[$i]."' group by SUCURSAL_ID");
        
        $a = $q->result_array();
        $resultado  = array_merge($resultado, $a);
      }
      return $resultado;
    }

	
	
    function get_supervision_sucursales($seleccionados) {
      $resultado = [];
      for ($i=0; $i < sizeof($seleccionados); $i++) {
        $qry = "SELECT ";
        $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO ";
        $qry .= "FROM ";
        $qry .= "EQUIPOS T1 INNER JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
        $qry .= "WHERE ";
        $qry .= "T1.FECHA_RECIBIDO > '01-01-2018' AND ";
        $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' ";
        $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID ";
        $qry .= "ORDER BY T1.NUM_ORDEN DESC;";
        $arr = $this->db->query($qry);
        $qry2 = "SELECT ";
        $qry2 .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, 0 AS SUBTOTAL_COMPLETO ";
        $qry2 .= "FROM EQUIPOS T1 ";
        $qry2 .= "WHERE ";
        $qry2 .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND " ;
        $qry2 .= "T1.FECHA_RECIBIDO > '01-01-2018' AND ";
        $qry2 .= "T1.ID NOT IN ( SELECT EQUIPO_ID FROM SERVICIOS) ";
        $qry2 .= "ORDER BY T1.NUM_ORDEN DESC ";
        $arr2 = $this->db->query($qry2);
        $arr = $this->db->query($qry);
        $guard = $arr->result_array();
        $guard2 = $arr2->result_array();
        $resultado2  = array_merge($guard, $guard2);
        $resultado  = array_merge($resultado, $resultado2);
      }
      return $resultado;
    }
    
    function get_supervision_sucursales_activas($seleccionados) {
      $resultado = [];
      for ($i=0; $i < sizeof($seleccionados); $i++) {
        $qry = "SELECT ";
        $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO ";
        $qry .= "FROM ";
        $qry .= "EQUIPOS T1 INNER JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
        $qry .= "WHERE ";
        $qry .= "T1.SITUACION = 'A' AND T1.FECHA_RECIBIDO > '01-01-2018' AND ";
        $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' ";
        $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID ";
        $qry .= "ORDER BY T1.NUM_ORDEN DESC;";
        $arr = $this->db->query($qry);
        $qry2 = "SELECT ";
        $qry2 .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.FECHA_DE_ENTREGA, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, 0 AS SUBTOTAL_COMPLETO ";
        $qry2 .= "FROM EQUIPOS T1 ";
        $qry2 .= "WHERE ";
        $qry2 .= "T1.SITUACION = 'A' AND ";
        $qry2 .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND " ;
        $qry2 .= "T1.FECHA_RECIBIDO > '01-01-2018' AND ";
        $qry2 .= "T1.ID NOT IN ( SELECT EQUIPO_ID FROM SERVICIOS) ";
        $qry2 .= "ORDER BY T1.NUM_ORDEN DESC ";
        $arr2 = $this->db->query($qry2);
        $arr = $this->db->query($qry);
        $guard = $arr->result_array();
        $guard2 = $arr2->result_array();
        $resultado2  = array_merge($guard, $guard2);
        $resultado  = array_merge($resultado, $resultado2);
      }
      return $resultado;
    }

	function get_registrosdiarios($seleccionados) {
      $resultado = [];
      $guion = '-';
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $fecha = $anio.$guion.$mes.$guion.$dia;

      //$fecha = '2020-08-26';
      for ($i=0; $i < sizeof($seleccionados); $i++) { 

        $qry = "SELECT ";

        $qry = "select ";
        $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO  ";
        $qry .= "FROM ";
        $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
        $qry .= "WHERE ";
        $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND ";  
        $qry .= "T1.FECHA_RECIBIDO = '".$fecha."' ";  
        $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";

        //print_r($qry);
        
        $arr = $this->db->query($qry);
        $guard = $arr->result_array();
        $resultado  = array_merge($resultado, $guard);
     }
        return $resultado;
    }

    function get_recibidosdiaresumen($seleccionados) {

      $resultado = [];

      $guion = '-';
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $fecha = $anio.$guion.$mes.$guion.$dia;
      $qry = " ";

      //$fecha = '2020-10-17';
      //print_r($fecha);


      for ($i=0; $i < sizeof($seleccionados); $i++) { 

        $qry = "SELECT ";
/*
        //EQUIPOS RECIBIDOS
        $qry .= "(SELECT COUNT(EQUIPOS.ID) AS RECIBIDOS FROM EQUIPOS WHERE EQUIPOS.SUCURSAL_ID = '" . $seleccionados[$i] . "'' And ";
        $qry .= "EQUIPOS.FECHA_RECIBIDO = '".$fecha."' GROUP BY  SUCURSAL_ID), ";

        //EQUIPOS REPARADOS
        $qry .= "count(EQUIPOS.ID) AS REPARADOS, "; 
      
        //TOTAL $ EQUIPOS REPARADOS
        $qry .= "SUM(servicios.SUBTOTAL) AS REPARADOS$, ";

        $qry .= "FROM ";
        $qry .= "EQUIPOS Inner Join SERVICIOS On EQUIPOS.ID = SERVICIOS.EQUIPO_ID ";
        $qry .= "WHERE ";
        $qry .= "EQUIPOS.SUCURSAL_ID = '" . $seleccionados[$i] . "' "; 
        $qry .= "AND EQUIPOS.FECHA_RECIBIDO = '".$fecha."' ";
        $qry .= "AND EQUIPOS.ESTATUS = 'Entregado' ";
        $qry .= "GROUP BY SUCURSAL_ID ";


*/
        $qry =  "Select t1.SUCURSAL_ID, (select count(t1.SUCURSAL_ID) as totales ";
        $qry .= "FROM equipos t1 left join servicios t2 on t1.id=t2.EQUIPO_ID ";
        $qry .= "where t1.sucursal_id = '".$seleccionados[$i]."' and ";
        $qry .= "fecha_recibido = '".$fecha."' ";
        $qry .= "group by t1.SUCURSAL_ID) as totales,  ";
        $qry .= "(select sum(t2.subtotal) from equipos t1 left join servicios t2 on t1.id=t2.equipo_id where t1.sucursal_id = '".$seleccionados[$i]."' and fecha_recibido = '".$fecha."' and t1.estatus = 'Entregado' group by t1.SUCURSAL_ID) as sumatotal, " ;        
        $qry .= "(select count(t1.SITUACION) from equipos t1 left join servicios t2 on t1.id=t2.equipo_id where t1.sucursal_id = '".$seleccionados[$i]."' and fecha_recibido = '".$fecha."' and t1.estatus = 'Entregado' group by t1.SUCURSAL_ID) as concluidos";
        $qry .= " FROM ";
        $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
        $qry .= " WHERE ";
        $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND T1.FECHA_RECIBIDO = '".$fecha."' "; 
        $qry .= "GROUP BY T1.SUCURSAL_ID ";
        

        //print_r($qry);


        $arr = $this->db->query($qry);

        $guard = $arr->result_array();

        $resultado  = array_merge($resultado, $guard);
        }
        
        return $resultado;
    }


	function get_registrosEsperaRefaccion($seleccionados) {
		$resultado = [];
		$guion = '-';
		for ($i=0; $i < sizeof($seleccionados); $i++) { 
      $qry = "select ";
      $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO  ";
      $qry .= "FROM ";
      $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
      $qry .= "WHERE ";
      $qry .= "T1.ESTATUS_ID IN (100, 510) AND T1.SITUACION = 'A' AND ";
      $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' ";  
      $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";
      $arr = $this->db->query($qry);
      $guard = $arr->result_array();
      $resultado  = array_merge($resultado, $guard);
		}
		return $resultado;
  }

  function get_registrosDevoluciones($seleccionados) {
		$resultado = [];
		$guion = '-';
		for ($i=0; $i < sizeof($seleccionados); $i++) { 
      $qry = "select ";
      $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO  ";
      $qry .= "FROM ";
      $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
      $qry .= "WHERE ";
      $qry .= "T1.ESTATUS_ID IN (390) AND T1.SITUACION = 'A' AND ";
      $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' ";
      $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";
      $arr = $this->db->query($qry);
      $guard = $arr->result_array();
      $resultado  = array_merge($resultado, $guard);
		}
		return $resultado;
  }

	function get_registrosLaboratorio($seleccionados) {
		
		
		$resultado = [];
		$guion = '-';
		
		for ($i=0; $i < sizeof($seleccionados); $i++) { 
		  $qry = "select ";
		  $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO  ";
		  $qry .= "FROM ";
		  $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
		  $qry .= "WHERE ";
	      $qry .= "T1.ESTATUS_ID IN (340, 320, 350, 360) AND T1.SITUACION = 'A'  AND ";
		  $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' ";  
		  $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";
		
		
		//print_r($qry);
		
		  $arr = $this->db->query($qry);
		  $guard = $arr->result_array();
		  $resultado  = array_merge($resultado, $guard);
		}
		return $resultado;
    }
	
	
	
	function get_registrosmes($seleccionados) {
		$resultado = [];
		$guion = '-';
		$anio = date("Y");
		$mes =  date("m");
		$dia =  date("d");
		$fecha = $anio.$guion.$mes.$guion.$dia;
		
		for ($i=0; $i < sizeof($seleccionados); $i++) { 
		  $qry = "select ";
		  $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO  ";
		  $qry .= "FROM ";
		  $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
		  $qry .= "WHERE ";
		  $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND EXTRACT(MONTH FROM T1.FECHA_RECIBIDO) = '".$mes."' AND EXTRACT(YEAR FROM T1.FECHA_RECIBIDO) = '".$anio."' "; 
		  $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";
		
		  $arr = $this->db->query($qry);
		  $guard = $arr->result_array();
		  $resultado  = array_merge($resultado, $guard);
		}
		return $resultado;
    }

    function get_registrosmesprueba($seleccionados) {
      $resultado = [];
      $guion = '-';
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $fecha = $anio.$guion.$mes.$guion.$dia;
      for ($i=0; $i < sizeof($seleccionados); $i++) { 
        $qry = "select ";
        $qry .= "t1.SUCURSAL_ID, 
        (select count(t1.SUCURSAL_ID) as registros from equipos t1 left join servicios t2 on t1.id=t2.EQUIPO_ID
        where t1.sucursal_id = '".$seleccionados[$i]."'  and extract(month from fecha_recibido)= '".$mes."' and extract(year from fecha_recibido)= '".$anio."' group by t1.SUCURSAL_ID) as totales,  
        (select sum(t2.subtotal) from equipos t1 left join servicios t2 on t1.id=t2.equipo_id 
        where t1.sucursal_id = '".$seleccionados[$i]."' and extract(month from fecha_recibido)= '".$mes."' and extract(year from fecha_recibido)= '".$anio."' and t1.estatus = 'Entregado' group by t1.SUCURSAL_ID) as sumatotal,
        (select count(t1.SITUACION) from equipos t1 left join servicios t2 on t1.id=t2.equipo_id 
        where t1.sucursal_id = '".$seleccionados[$i]."' and extract(month from fecha_recibido)= '".$mes."' and extract(year from fecha_recibido)= '".$anio."' and t1.estatus = 'Entregado' group by t1.SUCURSAL_ID) as concluidos ";
        //$qry .= ", T2.COSTO, T2.DESCRIPCION, T2.DESCUENTO, T2.SUBTOTAL";
        $qry .= " FROM ";
        $qry .= "EQUIPOS T1 LEFT JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
        $qry .= " WHERE ";
        $qry .= "t1.sucursal_id = '".$seleccionados[$i]."' and extract(month from fecha_recibido) = '".$mes."' and extract(year from fecha_recibido)= '".$anio."'"; 
        $qry .= "GROUP BY T1.SUCURSAL_ID order by concluidos asc;";
      $arr = $this->db->query($qry);

      $guard = $arr->result_array();

      $resultado  = array_merge($resultado, $guard);
     }
        return $resultado;
    }


    function get_supervision_sucursales_dia($seleccionados, $anio, $mes, $dia) {

      $resultado = [];

	  $guion = '-';
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      $fecha = $anio.$guion.$mes.$guion.$dia;


      for ($i=0; $i < sizeof($seleccionados); $i++) { 
      $qry = " SELECT ";
      $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO ";
      $qry .= "FROM ";
      $qry .= "EQUIPOS T1 INNER JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID ";
      $qry .= "WHERE ";
	  $qry .= "T1.FECHA_RECIBIDO = '".$fecha."' AND ";
      $qry .= "T1.SUCURSAL_ID = '" . $seleccionados[$i] . "' AND T1.ESTATUS <> 'Entregado' AND T1.ESTATUS <> 'Abandonado' AND T1.ESTATUS <> 'Donado a reciclaje' AND T1.ESTATUS <> 'Garant' AND T1.ESTATUS <> 'Donado' ";
      $qry .= "GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";


      $arr = $this->db->query($qry);

      $guard = $arr->result_array();

      $resultado  = array_merge($resultado, $guard);
     }
        return $resultado;
    }


    
    function establecer_ultimo_usuario() {
        $usuario_id = $this->session->userdata('usuario_id');
        $usuario = $this->session->userdata('usuario');
        $a = array("ultimo_usuario_id"=>$usuario_id,
                    "ultimo_usuario"=>$usuario);
        $this->db->where("sucursal_id",$this->session->sucursal_id);
        $this->db->update("numerosordenes",$a);
        return 1;
    }

    function set_ultimo_usuario() {
        $this->establecer_ultimo_usuario();
    }

    function crear_orden_por_reajuste($equipo_id) {
        $this->establecer_ultimo_usuario();
        $q = $this->db->query("select equipo_id_nuevo from crear_orden_por_reajuste(" . $equipo_id . ")");
        $a = $q->result_array();
        return $a[0]['equipo_id_nuevo'];
    }

    function r_equipos_x_turno($sucursal_id,$fecha,$turno) {
       $q = $this->db->query("select * from R_EQUIPOS_X_TURNO('" . $sucursal_id . "','" . $fecha . "'," . $turno . ")");
       $a = $q->result_array();
       return $a[0]; 
    }    
  
      
}
?>
