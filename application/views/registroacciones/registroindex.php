  <script language="javascript">
    $(function () {
      $("#ddusuario").change(function() {
      //top.location.href=window.location.href +'index/' + $("#ddsucursal").val();
      //top.location.href='/index.php/clientes/index/2/' + $("#ddsucursal").val();

      //var slice3 = str.split('/')[8]
      var str = window.location.href;
      var name2 = str.split('/')[5]
      //alert(name2);
      if (name2 != "index"){
        top.location.href=window.location.href + '/index/' + $("#ddusuario").val();
      }else{
        top.location.href='/index.php/registroacciones/index/'  + $("#ddusuario").val();
      }
    }); 
    });
  </script>

  <div align="center">
    <?php  
      $actual_link = ''.$_SERVER['PHP_SELF'];
      $actual_link = str_replace("/index.php/", "", $actual_link);
      //echo $actual_link;
      echo form_open($actual_link);
    ?>
    A&ntilde;o:
      <?php
        $anios = array();
        for ($i=2011;$i<=2020;$i++) {
            $anios[$i] = $i;		   
        }
          echo form_dropdown("anio",$anios,$anio);
      ?>
      
      Mes:
      <?php
            $meses = array("1"=>"Enero",
                          "2"=>"Febrero",
                          "3"=>"Marzo",
                          "4"=>"Abril",
                          "5"=>"Mayo",
                          "6"=>"Junio",
                          "7"=>"Julio",
                          "8"=>"Agosto",
                          "9"=>"Septiembre",
                          "10"=>"Octubre",
                          "11"=>"Noviembre",
                          "12"=>"Diciembre");
          echo form_dropdown("mes",$meses,$mes);
      ?>
      D&iacute;a:
      <?php
        $dias = array();
        for ($i=1;$i<=31;$i++) {
            $dias[$i] = $i;		   
        }
          echo form_dropdown("dia",$dias,$dia);
      ?>
  <?php echo form_submit("enviar","Enviar"); ?>
  <?php echo form_close(); ?>
  <div align="center" style="height:50px">
    Usuario: <?php echo form_dropdown("usuario",$usuarios,$usuario,"id='ddusuario'"); ?>
  </div>
  </div>

  <div align="center">
  <table width="100%" id="datatabla" class="cell-border stripe compact hover">
    <thead>
      <tr>
        <th>Usuario</th>
        <th>Fecha y hora</th>
        <th>Acci&oacute;n</th>
        <th>Tabla</th>
        <th>Descripci&oacute;n</th>
        <th>Num. Orden</th>
      </tr>
      </thead>
      <tbody>
  <?php
  foreach ($result as $item) {
    if($item['tabla']=="comunicaciones" || $item['tabla']=="bitacora"){
      //echo "AQUI";
      $orden = substr($item['detalle'], 0, -14);
      if($orden=="Reparado " and $item['tabla']=="bitacora"){ 
        echo "<tr style='background-color: yellow;'>";
      }else{
        if($item['tabla']=="comunicaciones"){
          echo "<tr style='background-color: yellow;'>";
        }
      }
    }else{
      echo "<tr>";
    }
    echo "<td>" . $item['usuario'] . "</td>";
    echo "<td>" . $item['fecha_hora'] . "</td>";
    echo "<td>" . $item['accion'] . "</td>";
    echo "<td>" . $item['tabla'] . "</td>";
    
    if($item['tabla']=="comunicaciones"){
      echo "<td></td>";
    }else{
      if($item['tabla']=="bitacora"){
        $orden = substr($item['detalle'], 0, -14);
        //$detalle = rtrim($item['detalle'], $orden);
        echo "<td>" . $orden. "</td>";
      }else{
        if(($item['tabla']=="servicios-equipo") && ($item['accion']=="AGREGAR")){
          $cadena = substr($item['detalle'], 0, -14);
          $prueba = substr($cadena,3,10);
          $prueba = trim($prueba);
          $orden = substr($item['detalle'], -6);

          $arrt = ( $this->db->query("select descripcion from servicios where servicio_id = '".$prueba."' and equipo_id = '".$orden."'"));
          
          //$arrt = ( $this->db->query("select * from servicios where servicio_id like '%".$prueba."%'"));
          //$arrt = ( $this->db->query("select * from servicios where equipo_id = '".$orden."'"));
          
          $descripcion = ($arrt->result_array());
          //print_r($descripcion);
          
          if(empty($descripcion[0]['descripcion'])){
            echo "<td>/td>";
          }else{
            echo "<td>" . $descripcion[0]['descripcion']. "</td>";
          }
          //$detalle = rtrim($item['detalle'], $orden);
          //echo "<td>" . $descripcion[0]['descripcion']. "</td>";
          //echo "<td>" . $orden . "</td>";
          //echo "<td>" . $item['detalle'] . "</td>";
        }else{
          echo "<td>" . $item['detalle'] . "</td>";
        }
      }
    }

    if($item['tabla']=="bitacora"){
      //echo "<td>LLEGASTE</td>";
      $orden = substr($item['detalle'], -6);
      
      $arrt = ( $this->db->query("select num_orden from equipos where id = '".$orden."'"));
      $tipos = ($arrt->result_array());
      //print_r($tipos);
      echo "<td><a target='_blank' href='https://".$item['sucursal_id'].".idoctor.mx/index.php/equipos/detalle/ver/".$orden."'>" . $tipos[0]['num_orden'] . "</a></td>";

      //echo "<td>" . $tipos[0]['num_orden'] . "</td>";
    
      //$orden = $item['sucursal_id'].$orden;
      //echo "<td>" . $orden . "</td>";
    
    }else{
      if($item['tabla']=="equipos"){
        $orden = $item['detalle'];
        $arrt = ( $this->db->query("select id from equipos where num_orden = '".$orden."'"));
        $tipos = ($arrt->result_array());
        
        echo "<td><a target='_blank' href='https://".$item['sucursal_id'].".idoctor.mx/index.php/equipos/detalle/ver/".$tipos[0]['id']."'>" . $orden . "</a></td>";

        //echo "<td>" . $tipos[0]['id'] . "</td>";
        //echo "<td>" . $item['detalle'] . "</td>";
      }else{
        if($item['tabla']=="comunicaciones"){
          //echo "<td>LLEGASTE</td>";
          $orden = substr($item['detalle'], -6);
            
          $arrt = ( $this->db->query("select num_orden from equipos where id = '".$orden."'"));
          $tipos = ($arrt->result_array());
          $sucursal = substr($tipos[0]['num_orden'], 0, 3);
          
          //print_r($tipos);
          echo "<td><a target='_blank' href='https://".$item['sucursal_id'].".idoctor.mx/index.php/equipos/detalle/ver/".$orden."'>" . $tipos[0]['num_orden'] . "</a></td>";

          //$orden = $item['sucursal_id'].$orden;
          //echo "<td>" . $orden . "</td>";
        }else{
          if($item['tabla']=="servicios-equipo"){
            //echo "<td>LLEGASTE</td>";
            $orden = substr($item['detalle'], -6);
            
            $arrt = ( $this->db->query("select num_orden from equipos where id = '".$orden."'"));
            $tipos = ($arrt->result_array());
            //print_r($tipos);
            if($item['accion']=="ELIMINADO"){
              echo "<td>N/A</td>";
            }else{
              echo "<td><a target='_blank' href='https://".$item['sucursal_id'].".idoctor.mx/index.php/equipos/detalle/ver/".$orden."'>" . $tipos[0]['num_orden'] . "</a></td>";
              //echo "<td>" . $tipos[0]['num_orden'] . "</td>";
            }
            
            //$orden = $item['sucursal_id'].$orden;
            //echo "<td>" . $orden . "</td>";
          }else{
            echo "<td>N/A</td>";
          }
        }
      }
    }
    echo "</tr>";	
  }
  //print_r($result); 
  ?>
  </tbody>
  </table>
  <div class="paginate" align="center">
  <?php

  //echo $this->pagination->create_links();		
      
  ?>
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