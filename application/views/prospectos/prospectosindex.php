<div style="height:30px;"></div>
<div align="center">
    <table width="100%" id="datatabla" class="cell-border stripe compact hover center">
        <thead>
            <tr>
                <th style='width:8%'>ID</th>
                <th style='width:8%'>Fecha</th>
                <th style='width:8%'>Sucursal</th>
                <th style='width:8%'>Nombre</th>
                <th style='width:8%'>Teléfono</th>
                <th style='width:8%'>Correo electronico</th>
                <th style='width:8%'>Equipo</th>
                <th style='width:8%'>Reparación</th>
                <th style='width:8%'>Estatus</th>
                <th style='width:8%'>Medio</th>
                <th style='width:88%'>Observaciones</th>
                <?php
                    if ($this->session->userdata('nivel')==1)
                        echo "<th style='width:8%'>Eliminar</th>";
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($prospectos as $item) {
                $nombre = $item['nombre'];
                if ($nombre=='') $nombre = "Sin nombre";
                echo "<tr>";
                echo "<td><a href='/catalogo/index.php/prospectos/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
                echo "<td>" . $item['fecha'] . "</td>";
                echo "<td>" . $item['sucursal_id_01'] . "</td>";
                echo "<td>" . $nombre . "</td>";
                echo "<td style='text-align:center'>" . $item['telefono'] . "</td>";
                echo "<td>" . $item['correo_electronico'] . "</td>";
                echo "<td>" . $item['equipo_id'] . "</td>";
                echo "<td>" . $item['reparacion_id'] . "</td>";
                echo "<td>" . $item['medio'] . "</td>";
                echo "<td>" . $item['estatus'] . "</td>";
                echo "<td>" . $item['observaciones'] . "</td>";
                if ($this->session->userdata('nivel')==1){
                    echo "<td align='center'><a onclick='Eliminacion(".$item['id'].")''><img src='/images/ico_eliminar.png'></a></td>";
                    //echo "<td align='center'><a href='/catalogo/index.php/prospectos/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
                }
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<div class="row" align="center">
    <a href="/catalogo/index.php/prospectos/nuevo" class="button" style="color: #FFF; background-color: #047c79;border-color: #33C3F0;">Agregar prospecto</a>
</div>

<script>
    $(document).ready(function() {
        $('#datatabla').DataTable( {
            paging:false,
            searching:false,
            ordering:true,
            info: "",
            iDisplayLength: 500,
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
    function Eliminacion(id) {
        if (confirm('¿Eliminar Prospecto?')) {
            window.location = "/catalogo/index.php/prospectos/eliminar/" + id;
        }
    }
</script>