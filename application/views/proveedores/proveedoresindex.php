<?php echo form_open('Proveedores/index'); ?>
<?php if (isset($clases)) { ?>
	<div class="row">
		<h4>Buscar por descripción</h4>
	</div>

	<div class="row">
		<div class="four columns" align="left">Descripci&oacute;n:</div>
			<div class="four columns" align="left"><?php echo form_input("busca_descripcion",(isset($busca_descripcion) ? $busca_descripcion : "")); ?></div>
			<div class="four columns" align="left"><?php echo form_submit("submit","Filtrar","class='button button-primary'"); ?></div>
		</div>
<?php } ?>

<?php echo form_close(); ?>
<?php 
if (isset($_POST['modificar'])) {
	if ($_POST['modificar']=='S')
   		$modificar = 1;
	if ($_POST['modificar']=='R')
   		$modificar = 2;
}
else $modificar = 0;
?>

<div align="center">
	<table width="100%" id="datatabla" class="cell-border stripe compact hover">
		<thead>
			<tr>
				<th width="80">ID</th>
				<th>CLAVE</th>
				<th>PROVEEDOR</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$j = 0; 
			foreach ($result as $item) {
				echo "<tr>";
				echo "<td align='center'><a href='/index.php/Proveedores/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
				echo form_hidden("id" . $j, $item['id']);
				echo "</td>";
				echo "<td align='center'>" . $item['clave_proveedor'] . "</td>";
				$desc = $item['nombre_proveedor'];
				$desc = str_replace('Ã', 'í', $desc);
				$desc = str_replace('í¡', 'á', $desc);
				$desc = str_replace('í³', 'ó', $desc);
				$desc = str_replace('Ã±', 'ñ', $desc);
				echo "<td align='center'><strong>" . $desc . "</strong></td>";
				echo "<td align='center'><a href='/index.php/Proveedores/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";	
				echo "</tr>";	
				$j++;
			}
			?>
		</tbody>
	</table>
	<div class="demo">
		<a href="/index.php/Proveedores/agregar">Agregar Proveedor</a>
	</div>
</div>

<?php echo form_close(); ?>

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
} );

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
 // alert(desde);
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
      }//Cierre del for

    }else{

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
      } //Cierre del for
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
    }//Cierre del for
  }else{
    for (i = 0; i < tr.length; i++) {
      td2 = tr[i].getElementsByTagName("td")[6]; //Situación
      if (td2) {
        var str2 = td2.innerHTML;
        if( (str2 === "Activa" && $('#activa').prop('checked')) || (str2 == "Concluida" && $('#concluida').prop('checked')) ||
           (str2 == "Cancelada" && $('#cancelada').prop('checked')) ){
            tr[i].style.display = "";
        }else{
            tr[i].style.display = "none";
        }
      }       
    } //Cierre del for
  }
}





</script>

