<div class="row">
<div class="row">
<div align="center">
<table width="100%" id="datatabla" class="cell-border stripe compact hover">
    <thead>
<tr>
         <th width='10%'>Suc</th>
         <th width='15%'>Total #</th>
         <th width='15%'>Total $</th>
         <th width='15%'>Efectivo #</th>
         <th width='15%'>Efectivo #</th>
         <th width='15%'>Digital #</th>
         <th width='15%'>Digital $</th>         
</tr>
</thead>
<tbody>
<?php
$suma1 = 0;
$suma2 = 0;
$suma3 = 0;
$suma4 = 0;
$suma5 = 0;
$suma6 = 0;

foreach ($cierredemes as $item) {
    echo "<tr>";
    
    //echo "<td>" . $item['sucursal_id'] . "</td>";
    //print_r($item);
    

    echo "<td>" . $item['sucursal'] . "</td>";
    echo "<td align='center' >" . $item['totalmovimientos'] . "</td>";
    $suma1 =$suma1+$item['totalmovimientos'];
    echo "<td align='center' >$" . number_format($item['total'],2). "</td>";
    $suma2 =$suma2+$item['total'];
    echo "<td align='center' >" . $item['totalmovefectivo'] . "</td>";
    $suma3 =$suma3+$item['totalmovefectivo'];
    echo "<td align='center' >$" . number_format($item['totalefectivo'],2) . "</td>";
    $suma4=$suma4+$item['totalefectivo'];
    echo "<td align='center' >" . $item['totalmovelectronico'] . "</td>";
    $suma5 =$suma5+$item['totalmovelectronico'];
    echo "<td align='center' >$" . number_format($item['totalelectronico'],2) . "</td>";
    $suma6=$suma6+$item['totalelectronico'];
    //echo "<td>" . ucfirst(strtolower($item['forma_de_pago'])) . "</td>";    
      // echo "<td>" . $item['observaciones'] . "</td>";    
    echo "</tr>";

}

    echo "<tr>";
    echo "<td></td>";
    echo "<td align = 'center' ><strong>" .$suma1. "</strong></td>";
    echo "<td align = 'center' ><strong>$" . number_format($suma2,2). "</strong></td>";
    echo "<td align = 'center' ><strong>" .$suma3. "</strong></td>";
    echo "<td align = 'center' ><strong>$" . number_format($suma4,2) . "</strong></td>";
    echo "<td align = 'center' ><strong>" .$suma5. "</strong></td>";
    echo "<td align = 'center' ><strong>$" . number_format($suma6,2) . "</strong></td>";
    //echo "<td>" . ucfirst(strtolower($item['forma_de_pago'])) . "</td>";    
      // echo "<td>" . $item['observaciones'] . "</td>";    
    echo "</tr>";

?>
</tbody>
</table>



</div>
</div>
<!--<div class="row" style="float:right">
    <a href="/index.php/reportes/exportarcierredemes/<?php// echo $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5); ?>" 
        class="button button-primary">Exportar a Excel</a>
</div>-->



<script>
$(document).ready(function() {
    $('#datatabla').DataTable( {
        paging:false,
        searching:false,
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
} );

function filtrarPorSucuarsal() {
  var input, filter, table, tr, td, i, td2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();

  input = document.getElementById("myInputTipo");
  filterTipo = input.value.toUpperCase();
  table = document.getElementById("datatabla");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td || td2) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 && td2.innerHTML.toUpperCase().indexOf(filterTipo) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function filtrarPorTipo() {
  var input, filter, table, tr, td, i, td2;
  input = document.getElementById("myInputTipo");
  filter = input.value.toUpperCase();
  input = document.getElementById("myInput");
  filterSucursal = input.value.toUpperCase();
  table = document.getElementById("datatabla");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td2 = tr[i].getElementsByTagName("td")[0];//Sucursal
    td = tr[i].getElementsByTagName("td")[1]; // Tipo
    if (td || td2) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 && td2.innerHTML.toUpperCase().indexOf(filterSucursal) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function filtrarPorFecha(){ ///ES UN RESPALDO DEL METODO
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" && dia2 == ""){
    dia1 = 1;
    dia2 = 33;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();
      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");

      if(!$('#tarjeta').prop('checked') && !$('#efectivo').prop('checked') && !$('#transferencia').prop('checked') 
        && !$('#sinespecificar').prop('checked')){

        for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3]; //Fecha
        if (td) {
          var str = td.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }//Cierre del for

      }else{

         for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3]; //Fecha
        td2 = tr[i].getElementsByTagName("td")[9]; //Forma de pago
        if (td) {
          var str = td.innerHTML;
         var str2 = td2.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2 
            && (  (str2 === "Tarjeta" && $('#tarjeta').prop('checked')) ||
             (str2 == "Efectivo" && $('#efectivo').prop('checked')) ||
              (str2 == "Transferencia" && $('#transferencia').prop('checked')) ||
              (str2 == "Noesp" && $('#sinespecificar').prop('checked')) )){
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
}

/*function filtrarPorFecha(){ ///ES UN RESPALDO DEL METODO
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();
      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
          var str = td.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }

    }else{
      //dia 1 > que dia 2
      alert("Hasta no puede ser menor que desde");
    }
  }
}*/




function prueba(){
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();

      //alert(anio + "-" + mes + "-");

      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");
      //alert(str);
      //Se extraen los ultimos numeros de la fecha
      //alert(str.substr(8, str.length-0));
      //if(dia1 >= str.substr(8, str.length-0) && dia2 <= str.substr(8, str.length-0)){
       // tr[1].style.display = "";
      //}

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
          var str = td.innerHTML;
          //alert("lle");
            //alert(str.substr(8, str.length-0));
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            //alert("entra");
            tr[i].style.display = "";
          } else {
             //alert("entra2");
            tr[i].style.display = "none";
          }
        }       
      }

    }else{
      //dia 1 > que dia 2
      alert("Hasta no puede ser menor que desde");
    }
  }
  
}




function marcarComoFacturado(id) {
    if (confirm('¿Marcar como facturado?')) {
        $.get( "/index.php/equipos/detalle/marcarcomofacturado/" + id, function( data ) {            
            $('#f' + id).html(data);
        });        
    }
    //alert(id);
}

$("#tarjeta").change(function () {
  if( $('#tarjeta').prop('checked') ) {
       
  }
});

</script>
