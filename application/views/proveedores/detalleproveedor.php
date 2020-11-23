<?php echo form_open('Proveedores/guardar'); 
if ($id!="") {
  echo form_hidden("accion", "u");
  echo form_hidden("id",$id);
}
else
  echo form_hidden("accion", "i");?>

<table class="tabla1">
  <tr>
    <td colspan="4" align="center"><h2>Detalle de proveedor</h2></td>
  </tr>
  <tr>
    <td width="15%" colspan="2">CLAVE</td>
    <td width="31%" colspan="2"><?php echo form_input("clave_proveedor",$clave_proveedor);?></td>
  </tr>
  <tr>
    <td colspan="2">NOMBRE DEL PROVEEDOR</td>
    <td colspan="2"><?php echo form_input("nombre_proveedor",$nombre_proveedor);?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><?php echo form_submit("submit","Enviar"); ?></td>
    </td>
  </tr>
</table>

<div class="row" align="center">
  <a href="/index.php/proveedores" ?>Regresar a los proveedores</a>
</div>
<?php echo form_close(); 
?>

