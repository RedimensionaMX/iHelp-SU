<script language="javascript">
	$("a#regresar").attr('href', '/index.php/inicio/clientes');
	$('#titulo').html('Lista de clientes');

   
$(function () {
   $("#ddsucursal").change(function() {
      //top.location.href=window.location.href +'/' + $("#ddsucursal").val();
      //top.location.href='/index.php/clientes/index/2/' + $("#ddsucursal").val();
      
      //echo base_url(uri_string());
      var str = window.location.href;
      var slice1 = str.split('/')[6]
      var slice2 = str.split('/')[7]
      var slice3 = str.split('/')[8]
      var name2 = str.split('/')[5]
      alert(slice2);
      var name = str.split('/')[8]
      if (name2 != "index"){
        top.location.href=window.location.href + '/index/' + $("#ddsucursal").val();
      }else{
        if (name != ""){
          alert(name);
          top.location.href='/index.php/clientes/index/' + slice1 +'/' +slice2 +'/' + $("#ddsucursal").val();
        }else{
          top.location.href=window.location.href + $("#ddsucursal").val();
        }
      }     
   });
});
</script>

<?php echo form_open('clientes/index');
// base_url(uri_string());  
?>
	<div align="center">
   <table class="buscar">
			<th colspan="3">Buscar por nombre</th>
			<tr>
				<td>Nombre:</td>
        <td>
          <?php 
            $data = [
              'name' => 'busquedaNombre',
              'id' => 'username',
              'criterio' => '1',
              'maxlength' => '120'
            ];
            echo form_input($data);
          ?>
        </td>
				<td>
          <div align="center">
          <?php 
            echo form_submit('mysubmit', 'Filtrar');
          ?>
          </div>
        </td>
      </tr>
      <th colspan="3">Buscar por correo</th>
			<tr>
				<td>Correo:</td>
        <td>
          <?php 
            $correoData = [
              'name' => 'busquedaCorreo',
              'id' => 'correo',
              'criterio' => '2',
              'maxlength' => '120'
            ];
            echo form_input($correoData);
          ?>
        </td>
				<td>
          <div align="center">
          <?php 
            echo form_submit('submit', 'Filtrar');
          ?>
          </div>
        </td>
      </tr>
    </table>
    <div align="center" style="height:50px">
      Seleccionar sucursal: <?php echo form_dropdown("sucursal",$sucursales,$sucursal,"id='ddsucursal'"); ?>
    </div>
    <?php echo form_close(); ?>
		<table width="100%" id="datatabla" class="cell-border stripe compact hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Telefono 1</th>
					<th>Telefono 2</th>
					<th>Correo electronico</th>
					<th>Eliminar</th>
				</tr>
			</thead>
			<tbody>
        <?php
        //echo $busca_nombre;
				foreach ($result as $item) {
					echo "<tr>";
					echo "<td style='color:black;'><a href='/index.php/clientes/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
					echo "<td style='color:black;'><a href='/index.php/clientes/modificar/" . $item['id'] . "'>" . $item['nombre'] . "</a></td>";
					echo "<td style='color:black;'>" . $item['telefono1'] . "</td>";
					echo "<td style='color:black;'>" . $item['telefono2'] . "</td>";
					echo "<td style='color:black;'>" . $item['correo_electronico'] . "</td>";
					echo "<td style='color:black;' align='center'><a href='/index.php/clientes/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
          echo "</tr>";	
				}
				?>
			</tbody>
		</table>
		<div class="paginate" align="center">
			<?php
				echo $this->pagination->create_links();
			?>
		</div>
		<div class="demo">
			<a href="/index.php/clientes/agregar">Agregar cliente</a>
		</div>
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