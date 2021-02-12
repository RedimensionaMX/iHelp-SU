<script language="javascript">
    $(function () {
        $("#ddusuario").change(function() {
            var str = window.location.href;
            var name1 = str.split('/')[6];
            //alert(name1);
            var name2 = str.split('/')[7];
            //alert(name2);
            if (name2 === undefined){
                top.location.href=window.location.href + '/'+  $("#ddusuario").val();
            }else{
                if(name1 == "comunicadospropias"){
                    top.location.href='../' + 'comunicadospropias/' + $("#ddusuario").val();
                }else{
                    top.location.href='../' + 'comunicadosfranquicias/' + $("#ddusuario").val();
                }
            }
        });
    });
</script>

<div align="center">
    <div align="center" style="height:50px">
        Usuario: <?php echo form_dropdown("usuario",$usuarios,$usuario,"id='ddusuario'"); ?>
    </div>
</div>


<div class="row">
    <div align="center">
        <table width="100%" id="datatabla" class="cell-border stripe compact hover">
            <thead>
                <tr>
                    <th width='20%'>Fecha</th>
                    <th width='20%'>Usuario</th>
                    <th width='20%'>Asunto</th>
                    <th width='20%'>Notas</th>
                    <th width='20%'>No. Orden</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($comunicados as $comunicado) {
                    echo "<tr>";
                    echo "<td align='center'>" . $comunicado['fecha'] . "</td>";
                    echo "<td align='center'>" . $comunicado['usuario'] . "</td>";
                    echo "<td align='center'>" . $comunicado['asunto'] . "</td>";
                    //echo "<td>" . $comunicado['mensaje_para_fecha_adicional'] . "<br>" . $comunicado['fecha_adicional'] . "</td>";
                    // echo "<td>" . $comunicado['proceso'] . "</td>";
                    echo "<td align='center'>" . $comunicado['notas'] . "</td>";
                    echo "<td align='center'>" . $comunicado['num_orden'] . "</td>";
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
