<?php echo form_open('reportes/recibidosdiapropias'); ?>
<div style="height:30px;"></div>
<?php if(!empty($fecha1)){?>
<h5 align="center"><b><?php echo "Equipos recibidos entre ".$fecha2." y ".$fecha1."";?></b></h5>
<p></p>
<?php } ?>
<table width="100%" id="datatabla" class="cell-border stripe compact hover">
<thead>
<tr>
<th>Sucursal</th>
<th>Total #</th>
<th>Concluídos #</th>
<th>Concluídos %</th>
<!--<th>Días activos</th>-->
<th>Concluídos $</th>

</tr>
</thead>
<tbody>
<?php
$suma1 = 0;
$suma2 = 0;
$suma3 = 0;

$fa = ""; $fechaadicional = "";
foreach ($result as $item) {
	
	echo "<tr>";



  echo "<td align='center' width='5%'><b>" . $item['sucursal_id'] . "</b>" . "</td>";

  echo "<td width='20%' align='center'>" . $item['totales'] . "</td>";
  $suma1 =$suma1+$item['totales'];
  echo "<td width='20%' align='center'>" . $item['concluidos'] . "</td>";
	$suma2 =$suma2+$item['concluidos'];
  if(empty($item)){
    echo "<td align = 'center' width='15%'>0%</a></td>";
  }else{
    echo "<td align = 'center' width='15%'>" . number_format($item['concluidos']/$item['totales']*100,2)."%</a></td>";
  }
  echo "<td align = 'center' width='15%'>$" . number_format($item['sumatotal'],2)."</a></td>";
  $suma3 =$suma3+$item['sumatotal'];
  

	
	echo "</tr>";	
}

  echo "<tr>";
    echo "<td></td>";
    echo "<td align = 'center' ><strong>" .$suma1. "</strong></td>";
    echo "<td align = 'center' ><strong>" .$suma2. "</strong></td>";
    if(empty($item)){
      echo "<td align = 'center' width='15%'>0%</a></td>";
    }else{
      echo "<td align = 'center' ><strong>" . number_format(($suma2/$suma1)*100,2)."%</strong></td>";
    }
    echo "<td align = 'center' ><strong>$" . number_format($suma3,2). "</strong></td>";
    echo "</tr>";
 
?>
</tbody>
</table>
<div class="paginate" align="center">
<?php

echo $this->pagination->create_links();		
		
?>
</div>

</div>
<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>

<script>
$(document).ready(function() {

    $('#datatabla').DataTable( {
        paging:false,
        searching:true,
        ordering:false,
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

