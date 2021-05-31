<!--<?php echo form_open('usuarios/guardar');
    if ($id!="") {
      echo form_hidden("id",$id);
    }
      if ($id!="")
        echo form_hidden("accion", "u");
      else
        echo form_hidden("accion", "i");
?>-->
<?php echo form_open('usuarios/sucursal');
    if (isset($id)) {
      echo form_hidden("id",$id);
    }
    $sucursales = array(
      'XA1' => 'Xalapa Animas',
      'XC1' => 'Xalapa Centro',
      'XU1' => 'Xalapa Urban',
      'CD1' => 'Cuernavaca',
      'CL1' => 'Córdoba Lomas',
      'CP1' => 'Coatepec',
      'CQ1' => 'Culiacán Las Quintas',
      'CR1' => 'Coatza Paraiso',
      'CS1' => 'Culiacán Sendero',
      'CZ1' => 'Coatzacoalcos',
      'MG1' => 'Mérida Gran Plaza',
      'MI2' => 'Xalapa Pruebas',
      'OZ1' => 'Orizaba Sora',
      'PA1' => 'Puebla Ánimas',
      'PR1' => 'Poza Rica',
      'TX1' => 'Tuxpan',
      'VA1' => 'Veracruz Américas',
      'VB1' => 'Veracruz Bolivar',
      'VF1' => 'Veracruz Framboyanes',
      'VM1' => 'Villahermosa Moret',
      'VM2' => 'Villahermosa Deportiva',
      'Todas' => 'Todas',
    );
    $nombres = array(
      'name'          => 'nombre',
      'value'         => $nombre,
      'readonly'      => 'readonly'
    );
    $usuarios = array(
      'name'          => 'usuario',
      'value'         => $usuario,
      'readonly'      => 'readonly'
    );
    $niveles = array(
      1=>"Administrador",
      2=>"Tecnico",
      3=>"Solo lectura"
    );
  ?>
  <table class="tabla1">
    <tr>
      <td colspan="2"><h2>Detalle de usuario/sucursal</h2></td>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td><?php echo form_input($nombres);?></td>
    </tr>
    <tr>
      <td>Usuario:</td>
      <td><?php echo form_input($usuarios); ?></td>
    </tr>
    <tr>
      <td>Sucursal</td>
      <td>
        <?php
          echo form_dropdown("sucursal_id",$sucursales,$sucursal_id);
          echo form_hidden("accion", $accion);
          echo form_hidden("passwd", $passwd);
        ?>
      </td>
    </tr>
    <tr>
      <td>Nivel:</td>
      <td><?php echo form_dropdown("nivel",$niveles,$nivel); ?></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="demo"><?php echo form_submit("submit","Enviar"); ?></div></td>
    </tr>
  </table>
  <?php echo form_close(); ?>