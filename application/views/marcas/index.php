<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Listado de Marcas de Celulares</h2>
    <div align="right"><a href="<?php echo base_url()?>index.php/marcas/guardar" class="btn btn-success">Nuevo</a></div>
    
    <table class="table tab-content">
        <tr>
            <th>N</th>
            <th>Marca</th>            
            
            
        </tr>
        <?php
        $i = 1;
        foreach ($marcas as $value){?>
        
            <?php if($value['ESTADO']==1){?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php echo $value['MARCA']?></td>            
                <?php
                if($this->session->userdata('nivel') == 1){?>
                <td><a class="btn btn-primary" href="<?php echo base_url()?>index.php/marcas/editar/<?php echo $value['ID']?>">Editar</a></td>
                <td><a class="btn btn-primary" onclick="eliminar(<?php echo $value['ID']?>)">Eliminar</a></td>
                <?php
                }
                ?>            
            </tr>
            <?php }?>
        <?php
        }
        ?>
    </table>
</div>

<script>

   function eliminar($id){
          if(confirm("¿Esta seguro de eliminar marca?")){
            window.location.href= "<?php echo base_url()?>index.php/marcas/eliminar/"+$id;
          }
      
   }


</script>