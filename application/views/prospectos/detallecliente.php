<?php echo form_open('prospectos/guardar',"id='form1'");
    if ($id!="") {
        echo form_hidden("accion", "u");
		echo form_hidden("id",$id);
	}
else
    echo form_hidden("accion", "i");
    echo form_hidden("desdeequipo","N");
    if ($this->uri->segment(2)=="modificarframe")
        echo form_hidden("tipoventana","frame");
    else form_hidden("tipoventana","normal");
?>

<div id="tabs">
    <ul>
        <li><a href="#tabs-generales">Prospecto</a></li>
    </ul>
    <div id="tabs-generales">
        <div class="row">
            <div class="six columns" align="right"><b>Sucursal</b></div>
            <div class="six columns">
                <select class="form-control" name="sucursal_id" id="category" required>
                <?php foreach($sucursal as $row):?>
                    <option value="<?php echo $row['sucursal_id'];?>"><?php echo $row['nombre'];?></option>
                <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Fecha</b></div>
            <div class="six columns"><?php
                $dat = array(
                    'name'        => 'fecha',
                    'id'          => 'fecharecibido',
                    'value'       => $fecha_recibido,
                    'maxlength'   => '20',
                    'size'        => '12',
                    'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;width:200px'
                );
                $dat['readonly'] = 'readonly';
                echo form_input($dat);
            ?></div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Nombre</b></div>
            <div class="six columns"><?php
                $data = array(
                'name'        => 'nombre',
                'id'          => 'nombre',
                'value'       => $nombre,
                'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
                );
                echo form_input($data); ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Correo electrónico</b></div>
            <div class="six columns">
                <?php
                $t3 = array("id" => "correo", "name"=>"correo_electronico","size"=>70,"maxlength"=>50,"value"=>$correo_electronico,"placeholder"=>"Correo electrónico","style"=>"width:300px");
                echo form_input($t3);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Teléfono</b></div>
            <div class="six columns"><?php
                $telefono = array(
                    'name'        => 'telefono',
                    'id'          => 'tel',
                    'value'       => $telefono,
                    'type'        => 'number',
                    'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;width:180px;',
                );
                echo form_input($telefono);
                //echo form_input("telefono",$telefono,"id='tel' style='width:180px' type='number'"); ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Equipo</b></div>
            <div class="six columns">
                <select class="form-control" name="equipo_id" id="equipo_id" required>
                <?php if ($A == 'A'){?>
                    <?php foreach($equipo_id as $row):?>
                    <option value="<?php echo $row['clase'];?>"><?php echo $row['tipo'];?></option>
                    <?php endforeach;?>
                <?php }else{ ?>
                <option value="">Seleccionar</option>
                    <?php foreach($equipo_id as $row):?>
                    <option value="<?php echo $row->CLASE;?>"><?php echo $row->TIPO;?></option>
                    <?php endforeach;?>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Reparación</b></div>
            <div class="six columns">
                <select class="form-control" id="sub_category" name="reparacion_id" required>
                <?php if ($A == 'A'){?>
                    <?php foreach($reparacion_id as $row):?>
                    <option value="<?php echo $row['descripcion'];?>"><?php echo $row['descripcion'];?></option>
                    <?php endforeach;?>
                <?php }else{ ?>
                    <option>Seleccionar</option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Medio</b></div>
            <div class="six columns">
            <?php
                $opciones = array("Seleccionar"=>"Seleccionar",
                "REDES"=>"Redes",
                "WP"=>"WhatsApp",
                "LLAMADA"=>"Llamada",
                "VISITA"=>"Visita"
                ); 
            echo form_dropdown("medio",$opciones,$medio,"id='medio'");
            ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Estatus</b></div>
            <div class="six columns">
            <?php
                $opcionesEstatus = array("Seleccionar"=>"Seleccionar",
                "CONSULTA"=>"Consulta",
                "SEGUIMIENTO"=>"Se hizo seguimiento",
                "EQUIPO"=>"Ingresó equipo",
                "NOQUISO"=>"No quiso reparar",
                "BARATO"=>"Dejó en otra empresa"
                );
            echo form_dropdown("estatus",$opcionesEstatus,$estatus,"id='estatus'");
            ?>
            </div>
        </div>
        <div class="row">
            <div class="six columns" align="right"><b>Observaciones</b></div>
            <div class="six columns"><?php
                $data = array(
                    'name'        => 'observaciones',
                    'id'          => 'observaciones',
                    'value'       => (isset($observaciones) ? $observaciones : ""),
                    'rows'   => '4',
                    'cols'        => '30',
                    'style'       => 'width:100%'
                );
                echo form_textarea($data);
            ?></div>
            <!-- <div class="six columns"><?php echo form_input("observaciones",""); ?></div> -->
        </div>
    </div>
    <!-- <div class="row" style="padding-top:20px">
        <div align="center">
            <?php echo form_submit("enviardatos","Enviar","class='button button-primary'"); ?>
        </div>
    </div> -->
    <div class="row" style="margin-top:60px">
        <div align="center"><input style="font-size:1.3em" class="button button-primary" type='button' value='Enviar' name='enviardatos' id='enviardatos'></div>
    </div> <!-- row -->
    <?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#equipo_id').change(function(){
        var TIPO=$(this).val();
        $.ajax({
            url : "<?php echo site_url('prospectos/get_reparaciones');?>",
            method : "POST",
            data : {TIPO: TIPO},
            async : true,
            dataType : 'json',
            success: function(data){
            var html = '';
            var i;
            html += '<option>Seleccionar</option>';
            for(i=0; i<data.length; i++){
                html += "<option value='"+data[i].DESCRIPCION+"'>"+data[i].DESCRIPCION+"</option>";
            }
            $('#sub_category').html(html);
            //$('#sub_category2').html(html);
            }
        });
        return false;
        });
        $('#sub_category').change(function(){
        var MARCA=$(this).val();
        var TIPO=$('#equipo_id').val();
        $.ajax({
            url : "<?php echo site_url('equipos/recepcion/get_sub_category2');?>",
            method : "POST",
            data : {MARCA: MARCA,TIPO:TIPO},
            async : true,
            dataType : 'json',
            success: function(data){
            var html = '';
            var i;
            html += '<option>Seleccionar</option>';
            for(i=0; i<data.length; i++){
                html += "<option value='"+data[i].MODELO+"'>"+data[i].MODELO+"</option>";
            }
            $('#sub_category2').html(html);
            }
        });
        return false;
        });
        $('#sub_category2').change(function(){
        var MODELO=$(this).find('option:selected').text();
        var TIPO=$('#equipo_id').val();
        var MARCA=$('#sub_category').val();
        $.ajax({
            url : "<?php echo site_url('equipos/recepcion/get_sub_category3');?>",
            method : "POST",
            data : {MODELO: MODELO,TIPO:TIPO,MARCA:MARCA},
            async : true,
            dataType : 'json',
            success: function(data){
            var html = '';
            var i;
            for(i=0; i<data.length; i++){
                html += "<option value='"+data[i].CLASE+"'>"+data[i].CLASE+"</option>";
            }
            $('#sub_category3').html(html);
            }
        });
        return false;
        });
    });
</script>

<script>
 $(document).ready(function () {
    fechas = $("#fecharecibido").val();
    $( "#fecharecibido" ).datepicker({ dateFormat: 'yy-mm-dd' });

$('#form1').validate({
    rules: {
        ciudad: { // <-- the field NAME attribute
            required: true
        },
        estado: { // <-- the field NAME attribute
            required: true
        },
        correo_electronico: { // <-- the field NAME attribute
            email: true
        },
        numero_exterior: { // <-- the field NAME attribute
            number: true
        },
        
        numero_interior: { // <-- the field NAME attribute
            number: true
        },
        cp: { // <-- the field NAME attribute
            number: true
        }

    }
});  


    $('#tel1').bind('keyup', function() {
        var fvalue = document.getElementById('tel1').value;

      var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    fvalue = fvalue.replace(r, '');
    npa = fvalue.substr(0, 3);
    nxx = fvalue.substr(3, 3);
    last4 = fvalue.substr(6, 4);
    fvalue = npa + '-' + nxx + '-' + last4;
    document.getElementById('tel1').value = fvalue;
   } );



  $('#tel2').bind('keyup', function() { 
      var fvalue = document.getElementById('tel2').value;

      var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    fvalue = fvalue.replace(r, '');
    npa = fvalue.substr(0, 3);
    nxx = fvalue.substr(3, 3);
    last4 = fvalue.substr(6, 4);
    fvalue = npa + '-' + nxx + '-' + last4;
    document.getElementById('tel2').value = fvalue;
   } );

$("#tabs").tabs().css({
   'min-height': '400px',
   'overflow': 'auto'
});

$( "#tabs > a" ).click(function( event ) {
event.preventDefault();
});

$('#enviardatos').click(function() {
      <?php if (FALSE) {  ?>
        if ($('#nombrecliente').val()=="") {
          $("#tabs").tabs( "option", "active", 0 );
          alert('Por favor escribe el nombre del cliente o selecciona uno ya capturado.');
        }
        else
          if ($('#tipo').val()=="") {
            $("#tabs").tabs( "option", "active", 1 );
            alert('Por favor especifica el tipo.');
          }
          else
            if ($('#descproblema').val()=="") {
              $("#tabs").tabs( "option", "active", 2 );
              alert('Por favor especifica la descripción del problema.');
            }
            else
              if ($('#condreceq').val()=="") {
                $("#tabs").tabs( "option", "active", 2 );
                alert('Por favor especifica las condiciones de recepción del equipo.');
              }
              else
      <?php } ?>
      {
        if ($('#fecharecibido').val()>fechas) {
            alert('No podemos viajar en el tiempo para descifrar ese ingreso. Ingresa una fecha correcta por favor');
          }else{
            if ($('#equipo_id').val()=="Seleccionar") {
              alert('Por favor selecciona un equipo.');
            }else{
              if ($('#sub_category').val()=="Seleccionar") {
                alert('Por favor selecciona un tipo de reparación.');
              }else{
                if ($('#medio').val()=="Seleccionar") {
                  alert('Por favor selecciona un medio de contacto.');
                }else{
                  if ($('#estatus').val()=="Seleccionar") {
                    alert('Por favor selecciona un estatus.');
                  }else{
                    if ($('#nombre').val()=="" && $('#correo').val()=="" && $('#tel').val()=="") {
                        alert('Por favor ingrese al menos una forma de contactar al prospecto.');
                    }else{
                        $('#form1').submit();
                    }
                  }
                }
              }
            }
          }
        }
    });



  });
</script>