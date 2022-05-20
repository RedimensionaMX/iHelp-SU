<div style="height:30px;"></div>
<label>Seleccione la situación</label><br>
  <div class ="row">
    <input type="checkbox" name="activa" value="activa" id="activa" onclick="filtrarCombos()">  Activa 
    <input type="checkbox" name="concluida" value="concluida" id="concluida" onclick="filtrarCombos()">      Concluida 
    <input type="checkbox" name="cancelada" value="cancelada" id="cancelada" onclick="filtrarCombos()">      Cancelada
  </div>
  <label>Seleccione el rango de fechas</label><br> 
    Desde: <input type="date" name="desde" id="desde">
    Hasta: <input type="date" name="hasta" id="hasta">
    <input type="button" onclick="filtrarPorFechas()" value="Filtrar"  style="background-color:#047c79; color:#FFFFFF;"> 
    <table width="100%" id="datatabla" class="cell-border stripe compact hover">
      <thead>
        <tr>
          <th>Suc</th>
          <th>Estatus</th>
          <th>Fecha recibido</th>
          <th>Días act.</th>
          <th>Num. orden</th>
          <th>Equipo</th>
          <th>Situación</th>
          <th>Subtotal</th>
          <th>Resta</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $fa = ""; $fechaadicional = "";
          foreach ($result as $item) {
            echo "<tr>";
            $colorline = "";
            if($item['dias_vencidos'] >= 10 && $item['dias_vencidos'] <= 29){ //Amarillo claro
              $colorline="#FCF6B4";
            }elseif($item['dias_vencidos'] >=30  && $item['dias_vencidos'] <= 59){//Amarrilo fuerte
              $colorline="#F6EF39";
            }elseif($item['dias_vencidos'] >= 60 && $item['dias_vencidos'] <= 89){ //Rojo
              $colorline="#CD3F3F";
            }elseif($item['dias_vencidos'] >= 90){  //Morado
              $colorline="#E397FF";
            }
            echo "<td  width='5%' align='center' style='background-color: ". $colorline . ";'><b>" . $item['sucursal_id'] . "</b>" . "</td>";
            if($item['estatus'] == "Listo para entrega"){
              echo "<td width='20%' style='background-color: ". $colorline . "; color:black;'><b>" . $item['estatus'] . "</b>" . "</td>";
            }else{
            echo "<td width='20%' style='background-color: ". $colorline . ";'><b>" . $item['estatus'] . "</b>" . "</td>";
            }
            echo "<td width='10%' align='center' style='background-color: ". $colorline . ";'>" . $item['fecha_recibido'] . "</td>";
            echo "<td width='5%' align = 'center' style='background-color: ". $colorline . ";'>" . $item['dias_vencidos'] . "</td>";
            echo "<td width='5%' align = 'center' style='background-color: ". $colorline . ";'>" . $item['num_orden'] ."</a></td>";
            if($item['software']!=NULL){
              echo "<td width='20%' align='center' style='background-color: ". $colorline . ";'>".$item['software']." ".$item['modelo']."<br></td>";
            }else{
                echo "<td width='20%' align='center' style='background-color: ". $colorline . ";'>" . $item['tipo'] . "<br></td>";
            }
            if($item['situacion'] == 'A'){
              echo "<td width='10%' align='center' style='background-color: ". $colorline . "; color:#51BF34;'>Activa</td>";
            }elseif($item['situacion'] == 'X'){
              echo "<td width='10%' align='center' style='background-color: ". $colorline . ";'>Cancelada</td>";
            }elseif($item['situacion'] == 'C'){
              echo "<td width='10%' align='center' style='background-color: ". $colorline . "; color:#4B2EDC;'>Concluida</td>";
            }else{
              echo "<td width='10%' align='center'>" . $item['situacion'] . "</td>";
            }
            echo "<td width='10%' align='center' style='background-color: ". $colorline . ";'>$" . number_format($item['subtotal_completo'], 2) . "</td>";
            $arr2 = ( $this->db->query("select sum(importe) as pagos from movimientos where equipo_id = '" .$item['id']. "'"));
            $pagos = ($arr2->result_array());
            echo "<td align='center' style='background-color: " . $colorline .";'>$" . number_format($item['subtotal_completo'] - $pagos[0]['pagos'], 2) . "</td>";
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
</div>
<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script>

<script>
$(document).ready(function() {

    $('#datatabla').DataTable( {
        paging:false,
        searching:true,
        ordering:true,
        info: "",
        iDisplayLength: 100,
        language: {
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