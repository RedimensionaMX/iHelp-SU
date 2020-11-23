<!--<div align="center" style="display:block" class="general">
	<div style="text-align:left;width:900px">
		<div style="padding:10px;width:200px;float:left;text-align:left">
			Titulo
		</div>
		<div style="padding:10px;width:600px;float:right;border: 1px solid;">
			<?php echo $titulo; ?>
		</div>
		<div style="padding:10px;width:200px;float:left;text-align:left;min-height:70px;">
			Mensaje
		</div>
		<div style="padding:10px;width:600px;float:right;border:1px solid;min-height:70px;">
			<?php 
			echo $mensaje;
			?>
		</div>
		<div style="padding:10px;width:200px;float:left;text-align:left">
			Fecha y hora
		</div>
		<div style="padding:10px;width:600px;float:right;">
			<?php echo $fecha . "&nbsp;" . $hora; ?>
		</div>
		<div style="padding:10px;width:200px;float:left;text-align:left">
			Enviado por
		</div>
		<div style="padding:10px;width:600px;float:right;">
			<?php echo $usuario; ?>
		</div>
	</div>
</div>
</div>-->

<?php $this->load->helper('form'); ?>
<table class="tabla1">
	<tr>
		<td colspan="2">Detalle de mensaje</td>
	</tr>
	<tr>
		<td>Título</td>
		<td><?php echo form_input("titulo", $titulo); ?></td>
	</tr>
	<tr>
		<td>Mensaje</td>
		<td><?php echo form_input("mensaje", $mensaje); ?></td>
	</tr>
	<tr>
		<td>Fecha y hora</td>
		<td><?php echo form_input("fechayhora", $fecha . " / " . $hora); ?></td>
	</tr>
	<tr>
		<td>Enviado por</td>
		<td><?php echo form_input("usuario", $usuario); ?></td>
	</tr>
</table>