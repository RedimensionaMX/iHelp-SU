<?php echo form_open('precios/index'); ?>
    <div>
        <script language="javascript">
            $(function () {
                $("#ddclase").change(function() {
                    top.location.href='/catalogo/index.php/precios/index/' + $("#ddclase").val();
                });
            });
        </script>
        <div class="row">
            <div class="three columns">Dispositivo:</div>
            <div class="nine columns"><?php  echo form_dropdown("clase",$clases,$clase,"id='ddclase'"); ?></div>
        </div>
    </div>
<?php echo form_close(); ?>

<div align="center">
    <table width="100%" id="datatabla" class="cell-border stripe compact hover">
        <thead>
            <tr>
                <th style="width: 20%;">ID</th>
                <th>Descripci&oacute;n</th>
                <th>Costo</th>
                <th>Clase</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($result as $item) {
            echo "<tr>";
            if ($this->session->userdata('nivel')==1)
                echo "<td>" . $item['id'] . "</td>";
            else
                echo "<td>" . $item['id'] . "</td>";
            $descripcion = $item['descripcion'];
            $descripcion = str_replace("[P]", "<span color='#f00'>(Paquete)</span>", $descripcion);
            echo "<td>" . $descripcion . "</td>";
            $costo = $item['costo'];
            echo "<td align='right'>" . number_format($costo, 2, '.', ',')  . "</td>";
            echo "<td>" . $item['clase'] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
        if ($this->session->userdata('nivel')==1) 	{
    ?>
    <?php } ?>
</div>


<script>
$(document).ready(function() {
    $('#datatabla').DataTable( {
        paging:false,
        searching:true,
        ordering:true,
        info: "",
        iDisplayLength: 100,
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
</script>