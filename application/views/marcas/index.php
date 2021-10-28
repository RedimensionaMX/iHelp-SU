<div align="center">
	<table width="100%" id="tablaclases" class="cell-border stripe compact hover">
		<thead>
			<tr>
				<th>Equipo</th>
				<th>Descripción</th>
				<th>Modelos</th>
				<th>Servicios</th>
				<th>Refacciones</th>
				<th>Accesorios</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($clases as $item) {
				echo "<tr>";
				echo "<td><a href='/index.php/clases/modificar/" . $item['clase'] . "'>" . $item['clase'] . "</a></td>";
				echo "<td>" . $item['descripcion'] . "</td>";
				echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/tipos/index/" . $item['clase'] . "\"'>Modelos</button></td>";
				echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/servicios/clase/" . $item['clase'] . "\"'>Servicios</button></td>";
				echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/piezas/clase/" . $item['clase'] . "\"'>Refacciones</button></td>";
				echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/articulos/clase/" . $item['clase'] . "\"'>Accesorios</button></td>";
				echo "</tr>";
			}
		?>
		</tbody>
	</table>
	<div>
		<a class="button button-primary" href="/index.php/clases/agregar">Agregar equipo</a>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#tablaclases').DataTable( {
			paging:false,
			searching:false,
			ordering:false,
			info: ""
		});
	} );
</script>