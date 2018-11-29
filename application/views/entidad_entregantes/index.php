<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>ENTIDADES ENTREGABLES</h2>
    <div align="right"><a href="<?php echo base_url()?>index.php/entidad_entregantes/guardar" class="btn btn-success">Nuevo</a></div>
    
    <table class="table tab-content">
        <tr>
            <th>N</th>
            <th>Marca</th>            
        </tr>
        <?php
        $i = 1;
        foreach ($entidades as $value){?>
        <tr>
            <td><?php echo $i; $i++;?></td>
            <td><?php echo $value['ENTIDAD']?></td>            
            <?php
            if($this->session->userdata('nivel') == 1){?>
            <td><a class="btn btn-primary" href="<?php echo base_url()?>index.php/entidad_entregantes/editar/<?php echo $value['ID']?>">Editar</a></td>
            <?php
            }
            ?>            
        </tr>
        <?php
        }
        ?>
    </table>
</div>