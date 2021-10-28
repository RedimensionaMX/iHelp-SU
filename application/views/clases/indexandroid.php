<div align="center">
	<table width="100%" id="tablaclases" class="cell-border stripe compact hover">
		<thead>
			<tr>
				<th>Marca</th>
				<th>Tipo</th>
				<th>Modelos</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($result as $item) {
				echo "<tr>";
				echo "<td><a href='/catalogo/index.php/android/marcas/modificar/" . $item['marca'] . "/".$item['tipo']."'>" . $item['marca'] . "</a></td>";
				echo "<td>" . $item['tipo'] . "</td>";
				echo "<td><button class='button button-primary' onclick='top.location.href=\"/catalogo/index.php/android/modelos/index/" . $item['marca'] . "/".$item['tipo']."\"'>Modelos</button></td>";
				echo "</tr>";
			}
		?>
		</tbody>
	</table>
	<div>
		<a class="button button-primary" href="/catalogo/index.php/android/tipos">Regresar</a>
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