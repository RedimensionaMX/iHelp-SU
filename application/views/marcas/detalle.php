<?php echo form_open('android/marcas/guardarMarca'); ?>
<div style="height:50px"></div>
<div class="row" style="height:80px">
  <div class="six columns">Marca de equipo:</div>
  <div class="six columns">
    <?php
      if ($marca!="")
        echo $marca;
      else
        echo form_input("marca",$marca); ?></div>
  </div>
  <div class="row" style="height:80px">
    <div class="six columns">Nuevo nombre de marca:</div>
    <div>
      <?php //echo form_input("estatus",(isset($estatus) ? $estatus : ""));
        echo form_input("marca2",$marca);
        
        if ($marca!="") {
          echo form_hidden("accion", "u");
          echo form_hidden("marca",$marca);
          echo form_hidden("tipo",$tipo);
        } else {
          echo form_hidden("accion", "i");
          echo form_hidden("tipo",$tipo);
        }
      ?>
    </div>
  </div>
  <div class="row" align="center">
    <div align="center"><?php echo form_submit("submit","Enviar","class='button button-primary'"); ?></div>
  </div>
  <?php echo form_close(); ?>
  <?php
    $atributos = array('id' => 'myform');
    echo form_open('android/tipos/index',$atributos); ?>
  <div class="row" align="center">
    <?php echo form_hidden("clase",$tipo); ?>
    <a href="javascript:{}" onclick="document.getElementById('myform').submit(); return false;">Regresar a los equipos</a>
  </div>
  <?php echo form_close(); ?>