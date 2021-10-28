<div style="height:30px;"></div>
<div align="center">
    <table width="100%" id="datatabla"  class="cell-border stripe compact hover" >
        <thead>
            <tr style="font-size: 15px;">
                <th>ID</th>
                <th>Fecha</th>
                <th>Suc. Egreso</th>
                <th>Suc. Aplicación</th>
                <th>Tipo</th>
                <th>Categoria</th>
                <th>Subcat.</th>
                <th>Concepto</th>
                <th>Importe</th>
                <th>Observaciones</th>
                <th>Forma de pago</th>
                <th>Usuario</th>
                <th>Usuario Sol.</th>
                <th>Usuario Aut.</th>
				<?php
					if ($this->session->userdata('nivel')==1)
						echo "<th>Eliminar</th>";
				?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($egresos as $item) {
                    echo "<tr style='font-weight: initial; font-size: 15px;'>";
                    echo "<td><a href='/catalogo/index.php/egresos/modificar/".$item['id']."'>" . $item['id'] . "</td>";
                    echo "<td>" . $item['fecha'] . "</td>";
                    echo "<td>" . $item['segreso'] . "</td>";
                    echo "<td>" . $item['sapp'] . "</td>";
                    echo "<td>" . $item['tipo_egreso'] . "</td>";
                    echo "<td>" . $item['categoria'] . "</td>";
                    echo "<td>" . $item['subcategoria'] . "</td>";
                    echo "<td>" . $item['concepto'] . "</td>";
                    echo "<td style='text-align:right'>" . number_format($item['importe'],2) . "</td>";
                    echo "<td>" . $item['observaciones'] . "</td>";
                    echo "<td>" . ucfirst(strtolower($item['forma_pago'])) . "</td>";
                    echo "<td>" . $item['usuario'] . "</td>";
                    echo "<td>" . $item['usuario_id_solicita'] . "</td>";
                    echo "<td>" . $item['usuario_id_autoriza'] . "</td>";
                    if ($this->session->userdata('nivel')==1){
                        //echo "<td align='center'><a href='/catalogo/index.php/egresos/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
                        echo "<td align='center'><a onclick='Eliminacion(".$item['id'].")''><img src='/images/ico_eliminar.png'></a></td>";
                        echo "</tr>";
                    }
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<div class="row" align="center">
    <a href="/catalogo/index.php/egresos/nuevo/" class="button button-primary">Nuevo Egreso</a>
</div>

<script>
    $(document).ready(function() {
        $('#datatabla').DataTable( {
            paging:true,
            searching:false,
            ordering:true,
            info: "",
            iDisplayLength: 25,
            language:
            {
                "emptyTable":     "No data available in table",
                "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty":      "Showing 0 to 0 of 0 entries",
                "infoFiltered":   "(filtered from _MAX_ total entries)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Loading...",
                "processing":     "Processing...",
                "search":         "Search:",
                "zeroRecords":    "No matching records found",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Ultimo",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
    });
    function marcarComoFacturado(id) {
        if (confirm('¿Marcar como facturado?')) {
            $.get( "/index.php/equipos/detalle/marcarcomofacturado/" + $item['id'], function( data ) {
                $('#f' + id).html(data);
            });
        }
    }

    function Eliminacion(id) {
        if (confirm('¿Eliminar Egreso?')) {
            window.location = "/catalogo/index.php/egresos/eliminar/" + id;
        }
    }
</script>