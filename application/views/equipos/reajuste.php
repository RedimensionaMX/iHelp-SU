<script language="javascript">
    $(function () {
        $("#ddusuario").change(function() {
            var str = window.location.href;
            var name1 = str.split('/')[6];
            var name2 = str.split('/')[7];
            if (name2 === undefined && name === ""){
                top.location.href='../equiposReajuste/' + $("#ddusuario").val();
            }else{
                top.location.href='../' + $("#ddusuario").val();
            }
        });
    });
</script>

<div align="center">
    <div align="center" style="height:50px">
        Sucursal: <?php echo form_dropdown("usuario",$usuarios,$usuario,"id='ddusuario'"); ?>
    </div>
</div>


<div class="row">
    <div align="center">
        <table width="100%" id="datatabla" class="cell-border stripe compact hover">
            <thead>
                <tr>
                    <th width='20%'>Fecha</th>
                    <th width='20%'>Sucursal</th>
                    <th width='20%'>No. Orden</th>
                    <th width='20%'>Equipo</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($bitacoras as $bitacora) {
                    $id = substr($bitacora['num_orden'], 0,2);
                    echo "<tr>";
                    echo "<td align='center'>" . $bitacora['fecha'] . "</td>";
                    //echo "<td>" . $bitacora['mensaje_para_fecha_adicional'] . "<br>" . $bitacora['fecha_adicional'] . "</td>";
                    // echo "<td>" . $bitacora['proceso'] . "</td>";
                    if ($id == 'VM'){
                        echo "<td align='center'>" . $id . "2</td>";
                    }else{
                        echo "<td align='center'>" . $id . "1</td>";
                    }
                    echo "<td align='center'>" . $bitacora['num_orden'] . "</td>";
                    echo "<td align='center'>" . $bitacora['tipo'] . "</td>";
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
