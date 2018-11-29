<div class="container">
    <h2>Listado de Cargas de Celulares Diarios</h2>
    <div align="right">
      <?php if($this->session->userdata('nivel') == 1){?>
        <a href="<?php echo base_url()?>index.php/cargas/nuevo" class="btn btn-success">Nuevo</a></div>
      <?php } ?>
    <table class="table tab-content">
        <tr>
            <th>N.</th>
            <th>PERSONAL</th>
            <th>FECHA</th>
            <th>CANTIDAD</th>
            <th>ENTIDAD ENTREGANTE</th>
            <th>ACTIVAR</th>
        </tr>
        <?php
        $i = 1;
        foreach ($cargas as $value){?>

        <?php if($this->session->userdata('nivel')==2){ ?>
          <?php if($this->session->userdata('empleado_id')==$value['USUARIO_ID']){?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php echo $value['NOMBRES']." ".$value['APELLIDO_PATERNO']?></td>
                <td><?php echo $value['FECHA']?></td>
                <td><?php echo $value['CANTIDAD']?></td>
                <td><?php echo $value['ENTIDAD']?></td>
                <td><?php echo $value['ACTIVO']?></td>
            </tr>
          <?php } ?>
        <?php }else{ ?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php echo $value['NOMBRES']." ".$value['APELLIDO_PATERNO']?></td>
                <td><?php echo $value['FECHA']?></td>
                <td><?php echo $value['CANTIDAD']?></td>
                <td><?php echo $value['ENTIDAD']?></td>
                <td><a href="<?php echo base_url()?>index.php/cargas/activar/<?php echo $value['FECHA'];?>/<?php echo $value['USUARIO_ID']?>/<?php echo $value['ACTIVO_ID']?>"><?php echo $value['ACTIVO']?></a></td>
            </tr>
        <?php } ?>
        <?php
        }
        ?>
    </table>
</div>
