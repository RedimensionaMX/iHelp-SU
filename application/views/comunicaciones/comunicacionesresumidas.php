
<div class="row">
    <div align="center">
        <table width="100%" id="datatabla" class="cell-border stripe compact hover">
            <thead>
                <tr>
                    <th width='50%'>Usuario</th>
                    <th width='50%'>Comunicados</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($comunicados as $comunicado) {
                    echo "<tr>";
                    echo "<td align='center'>" . $comunicado['usuario'] . "</td>";
                    echo "<td align='center'>" . $comunicado['count'] . "</td>";
                    //echo "<td>" . $comunicado['mensaje_para_fecha_adicional'] . "<br>" . $comunicado['fecha_adicional'] . "</td>";
                    // echo "<td>" . $comunicado['proceso'] . "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#datatabla').DataTable( {
        paging:true,
        searching:false,
        ordering:true,
        order: [0,'desc'],
        info: "",
        iDisplayLength: 100,
        language:
        {
            "emptyTable":     "No existen valores en la tabla",
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
</script>
