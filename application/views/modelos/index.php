<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Listado de Modelos de Celulares</h2>
    <div align="right"><a href="<?php echo base_url()?>index.php/modelos/guardar" class="btn btn-success">Nuevo</a></div>

    <table class="table tab-content">
        <tr>
            <th>N</th>
            <th>Marca</th>


        </tr>
        <?php

        $i = 1;

        foreach ($modelos as $valueMarcas){?>

         <?php if($valueMarcas['estado_marca']==1){?>
        <tr>
            <td><b><?php echo $i; $i++;?></b></td>
            <td><b><?php echo $valueMarcas['marca']?></b></td>
            <td></td>
        </tr>
            <?php
            $j = 1;
            //print_r($valueMarcas['modelos']);
            foreach ($valueMarcas['modelos'] as $key => $valueModelos){ ?>

                 <?php if($valueModelos['ESTADO']){?>
                    <tr>
                        <td><?php echo $j; $j++;?></td>
                        <td><?php echo $valueModelos['NAME'];?></td>
                        <?php
                        if($this->session->userdata('nivel') == 1){?>
                        <td><a class="btn btn-primary" href="<?php echo base_url()?>index.php/modelos/editar/<?php echo $key?>">Editar</a></td>
                         <td><a class="btn btn-primary" onclick="eliminar(<?php echo $key?>)">Eliminar</a></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php } ?>

            <?php
            }
            ?>
         <?php } ?>
        <?php
        }
        ?>
    </table>
</div>

<script>

   function eliminar($id){
          if(confirm("¿Esta seguro de eliminar modelo?")){
            window.location.href= "<?php echo base_url()?>index.php/modelos/eliminar/"+$id;
          }

   }


</script>
