<script language="javascript">
  $("a#regresar").attr('href', '/index.php/tipos/index');
  $('#titulo').html('Detalle de modelo de Dispositivo');
</script>
<?php $this->load->helper('form');?>
<?php echo form_open('android/tipos/guardar/'.$tipo); ?>
<script language="javascript">
  function myFunction() {
    $.getJSON('/index.php/tipos/subtiposjson/iPad2', null, function(data) {
      var options = '';
      $.each(data, function(key, val) {
        options += '<option value="' + key + '">' + val + '</option>';
      });
      $('#select').html(options);
      $("#select option[value='']").remove();
    });
}
</script>
<!--<a href="#" onclick="myFunction();">AAA</a>
<select id="select"></select>-->
<table  class="tabla1">
  <tr>
  <?php if($tipo!=""){ ?>
    <td colspan="2"><h2>Actualizar modelo</h2></td>
  <?php }else{ ?>
    <td colspan="2"><h2>Agregar nuevo modelo</h2></td>
  <?php } ?>
  </tr>
  <?php if ($tipo!="") {?>
  <tr>
  <td><div align="right" class="demo">Modelo:</div></td>
    <td><div align="left" class="demo"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 
      echo form_input("modelo",$modelo);
      if ($tipo!="") 
        echo form_hidden("accion", "u");
      else
        echo form_hidden("accion", "i");
      ?>
      
    </div></td>
  </tr>
    <tr>
      <td><div align="right" class="demo">Marca:</div></td>
      <td><div align="left" class="demo">
      <select class="form-control" name="marca" id="category" required>
          
          <?php foreach($marcas as $row):?>
            <option value="<?php echo $row['marca'];?>"><?php echo $row['marca'];?></option>
          <?php endforeach;?>
        </select></div></td>
    </tr>
    <tr>
      <td><div align="right" class="demo">Tipo:</div></td>
      <td><div align="left" class="demo">
      <select class="form-control" name="tipo" id="category" required>
          
          <?php foreach($tiposAndroid as $row):?>
            <option value="<?php echo $row['tipo'];?>"><?php echo $row['tipo'];?></option>
          <?php endforeach;?>
        </select>
      <?php echo form_hidden("id", $id);?></div></td>
    </tr>
    <tr>
      <td><div align="right" class="demo">Clase</div></td>
      <td><div align="left" class="demo">
      <select class="form-control" name="clase" id="category" required>
          
          <?php foreach($category as $row):?>
            <option value="<?php echo $row['tipo'];?>"><?php echo $row['tipo'];?></option>
          <?php endforeach;?>
        </select>
      </div></td>
    </tr>
  <?php  }else{ ?>
    <tr>
    <td><div align="right" class="demo">Tipo:</div></td>
    <td><div align="left" class="demo">
    <select class="form-control" name="tipo" id="category" required>
        <option value="">Seleccionar</option>
        <?php foreach($category as $row):?>
          <option value="<?php echo $row->TIPO;?>"><?php echo $row->TIPO;?></option>
        <?php endforeach;?>
      </select>
    <?php echo form_hidden("id", $id);?></div></td>
  </tr>
  <tr>
    <td><div align="right" class="demo">Marca:</div></td>
    <td><div align="left" class="demo">
    <select class="form-control" id="sub_category" name="marca" required>
        <option>Seleccionar</option>
      </select></div></td>
  </tr>
    <tr>
  <td><div align="right" class="demo">Modelo:</div></td>
    <td><div align="left" class="demo"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 
      echo form_input("modelo","");
      if ($tipo!="") 
        echo form_hidden("accion", "u");
      else
        echo form_hidden("accion", "i");
      ?>
      
    </div></td>
  </tr>
  <tr>
    <td><div align="right" class="demo">Clase</div></td>
    <td><div align="left" class="demo">
    <select class="form-control" name="clase" id="category2" required>
        
        <?php foreach($category2 as $row):?>
          <option value="<?php echo $row['tipo'];?>"><?php echo $row['tipo'];?></option>
        <?php endforeach;?>
      </select>
    </div></td>
  </tr>
  <tr>
  <?php } ?>
  	
    <td colspan="2"><div align="center" class="demo"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>


<script type="text/javascript">
  $(document).ready(function(){
    $('#category').change(function(){
      var TIPO=$(this).val();
      $.ajax({
        url : "<?php echo site_url('android/Modelos/get_sub_category');?>",
        method : "POST",
        data : {TIPO: TIPO},
        async : true,
        dataType : 'json',
        success: function(data){
          var html = '';
          var i;
          html += '<option>Seleccionar</option>';
          for(i=0; i<data.length; i++){
            html += '<option value='+data[i].MARCA+'>'+data[i].MARCA+'</option>';
          }
          $('#sub_category').html(html);
          $('#sub_category2').html(html);
        }
      });
      return false;
    });
    $('#sub_category').change(function(){
      var MARCA=$(this).val();
      var TIPO=$('#category').val();
      $.ajax({
        url : "<?php echo site_url('android/modelos/get_sub_category2');?>",
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
      var TIPO=$('#category').val();
      var MARCA=$('#sub_category').val();
      $.ajax({
        url : "<?php echo site_url('android/modelos/get_sub_category3');?>",
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