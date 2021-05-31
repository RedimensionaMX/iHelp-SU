<script language="javascript">
	$("a#regresar").attr('href', '/index.php/inicio/clientes');
	$('#titulo').html('Lista de clientes');

$(function () {
  $("#ddsucursal").change(function() {
      var str = window.location.href;
      var name2 = str.split('/')[5]
      if (name2 != "index"){
        top.location.href=window.location.href + '/index/0/' + $("#ddsucursal").val();
      }else{
          top.location.href='/index.php/usuarios/index/0/'  + $("#ddsucursal").val();
      }
  });

  $("#ddusuario").change(function() {
    var str = window.location.href;
    var name2 = str.split('/')[5]
    if (name2 != "index"){
      top.location.href=window.location.href + '/index/1/' + $("#ddusuario").val();
    }else{
        top.location.href='/index.php/usuarios/index/1/'  + $("#ddusuario").val();
    }
  });
});
</script>
<?php echo form_open('usuarios/index');?>
<div align="center">
  <div align="center" style="height:50px">
    Seleccionar usuario: <?php echo form_dropdown("usuario",$usuarios,$usuario,"id='ddusuario'"); ?>
  </div>
  <div align="center" style="height:50px">
    Seleccionar sucursal: <?php echo form_dropdown("sucursal",$sucursales,$sucursal,"id='ddsucursal'"); ?>
  </div>
</div>
<?php echo form_close(); ?>
  <div align="center">
	<table width="100%" id="datatabla" class="cell-border stripe compact hover">
		<thead>
			<tr>
				<th>Usuario</th>
				<th>Nombre</th>
				<th>Sucursal(es)</th>
				<th>Dar de baja</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($result as $item) {
					echo "<tr>";

					echo "<td align='center'><a href='/catalogo/index.php/usuarios/modificar/" . $item['usuario'] . "'>" . $item['usuario'] . "</a></td>";
					echo "<td align='center'>" . $item['nombre'] . "</td>";
					echo "<td align='center'><a href='/catalogo/index.php/usuarios/index/1/".$item['usuario']."'>" . $item['sucursales'] . "</td>";
					echo "<td align='center'><a href='/catalogo/index.php/usuarios/eliminar/" . $item['usuario'] . "'><img src='/images/ico_eliminar.png'></a></td>";
					echo "</tr>";
				} 
			?>
		</tbody>
	</table>
	<div>
		<a class="button button-primary" href="/catalogo/index.php/usuarios/agregar">Agregar usuario</a></div>
	</div>

	<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>
<script>
  $(document).ready(function() {
    $('#datatabla').DataTable( {
      paging:false,
      searching:false,
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
          "loadingRecords": "Cargadon...",
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "zeroRecords":    "No hay registros",
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
  window.onload = function(){
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if(dia<10)
      dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
      mes='0'+mes //agrega cero si el menor de 10
    document.getElementById('desde').value=ano+"-"+mes+"-"+dia;
    document.getElementById('hasta').value=ano+"-"+mes+"-"+dia;
  }
  $("#datatabla").tablesorter();
  function cambioFormatoFecha(texto){
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
  }
  function filtrarPorFechas(){ ///ES UN RESPALDO DEL METODO
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    if(desde == hasta){
    }
    var dia1 = $("#dia1").val(); //desde
    var dia2 = $("#dia2").val(); //hasta
  if(hasta >= desde){
    var table = document.getElementById("datatabla");
    var tr = table.getElementsByTagName("tr");
    if(!$('#activa').prop('checked') && !$('#concluida').prop('checked') && !$('#cancelada').prop('checked') ){
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          var str = td.innerHTML;
          if(str >= desde && str <= hasta){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    } else {
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]; //Fecha
        td2 = tr[i].getElementsByTagName("td")[6]; //Situación
        if (td) {
          var str = td.innerHTML;
          var str2 = td2.innerHTML;
          if(str >= desde && str <= hasta 
            && (  (str2 === "Activa" && $('#activa').prop('checked')) ||
             (str2 == "Concluida" && $('#concluida').prop('checked')) ||
             (str2 == "Cancelada" && $('#cancelada').prop('checked')) )){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  }else{
    //dia 1 > que dia 2
    alert("Hasta no puede ser menor que desde");
  }
}

function filtrarCombos(){
  var table = document.getElementById("datatabla");
  var tr = table.getElementsByTagName("tr");
  if(!$('#activa').prop('checked') && !$('#concluida').prop('checked') && !$('#cancelada').prop('checked') ){
    for (i = 0; i < tr.length; i++) {
      tr[i].style.display = "";
    }
  } else {
    for (i = 0; i < tr.length; i++) {
      td2 = tr[i].getElementsByTagName("td")[6]; //Situación
      if (td2) {
        var str2 = td2.innerHTML;
        if( (str2 === "Activa" && $('#activa').prop('checked')) || (str2 == "Concluida" && $('#concluida').prop('checked')) ||
           (str2 == "Cancelada" && $('#cancelada').prop('checked')) ){
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
      }
    }
  }
}
</script>