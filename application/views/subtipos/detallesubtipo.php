<?php 
if($id!=""){
  $hidden = array('id' => $id,'accion' => 0);
  echo form_open('Subtipos/guardar', '', $hidden);
}else{
  $hidden = array('tipo' => $tipo,'accion' => 1);
  echo form_open('Subtipos/guardar', '', $hidden);
  
//  echo form_open('Subtipos/guardar');
  //echo form_hidden("accion", 1);
}

//echo form_open('Subtipos/guardar'); 
//if ($id!="") {
//  echo form_hidden("accion", "u");
//  form_hidden("id",$id);
//  echo "Actualizar";
//  echo $id;
//}else{
//  echo form_hidden("accion", "i");
//  echo "OT";
//}
?>


  <!--<div class="row hei50">

	<div class="six columns">Id: </div><div class="six columns"><?php echo form_input("id",$id);  ?></div>
	
  </div>  row-->
   <div class="row hei50">
    <div class="six columns">Modelo al que pertenece:</div><div class="six columns"><?php 
    //if (isset($tipos))
	  //echo form_dropdown("tipo",$tipos,$tipo);
	//else
      echo $tipo;
      //echo form_hidden("tipo",$tipo);
      ?>
      </div>
  </div> <!-- row -->

  <div class="row hei50">
  <div class="six columns">Característica:</div>
    <div class="six columns"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("capacidad",$capacidad);
	   
	?></div>
  </div> <!-- row -->
  
  <div class="row hei50">
    <div align="center"><?php echo form_submit("submit","Enviar","class='button button-primary'"); ?></div>
  </div> <!-- row -->
  <div class="row" align="center">
    <a href="/index.php/subtipos" ?>Regresar a los subtipos</a>
  </div>


<?php echo form_close(); 

?>

