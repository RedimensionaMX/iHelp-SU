<script language="javascript">
  $("a#regresar").attr('href', '/index.php/piezas/index');
  $('#titulo').html('Pieza');
</script>

<?php $this->load->helper('form'); ?>
<?php 
  echo form_open('estados/guardar');
  if ($accion!= 'N') {
    echo form_hidden("accion", "u");
  } else{
    echo form_hidden("accion", "i");
  }
  echo form_hidden("id",$id);
?>
<table class="tabla1">
  <tr>
    <td colspan="2"><h2>Detalle de estado</h2></td>
  </tr>
  <tr>
    <td>Estatus:</td>
    <td><?php
    	 echo form_input("estatus",$estatus); ?></td>
  </tr>
  <tr>
    <td>Mensaje para fecha adicional</td>
    <td><?php echo form_input("mensaje_para_fecha_adicional",$mensaje_para_fecha_adicional); ?></td>
  </tr>
  <tr>
    <td>ID Siguiente estatus</td>
    <td><?php echo form_input("id_siguiente_estatus",$id_siguiente_estatus); ?></td>
  </tr>
  <tr>
    <td>Siguiente estatus</td>
    <td><?php echo form_input("siguiente_estatus",$siguiente_estatus); ?></td>
  </tr>
  <tr>
    <td>Ubicación</td>
    <td><?php echo form_input("ubicacion",$ubicacion); ?></td>
  </tr>
  <tr>
    <td>Índice</td>
    <td><?php echo form_input("indice",$indice); ?></td>
  </tr>
  <tr>
    <td>Estatus de entrega</td>
    <td><?php echo form_input("estatus_de_entrega",$estatus_de_entrega); ?></td>
  </tr>
  <tr>
    <td>Estatus por notificar</td>
    <td><?php echo form_input("estatus_por_notificar",$estatus_por_notificar); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>
</table>

<div class="row" align="center">
    <a href="/index.php/estados" ?>Regresar a los estados</a>
  </div>

<?php echo form_close(); ?>