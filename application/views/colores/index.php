<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Listado de Colores de Celulares</h2>
    <div align="right"><a href="<?php echo base_url()?>index.php/colores/guardar" class="btn btn-success">Nuevo</a></div>
    
    <table class="table tab-content">
        <tr>
            <th>N</th>
            <th>Color</th>            
    
        </tr>
        <?php
        $i = 1;
        foreach ($colores as $value){?>
        
        
                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $value['COLOR']?></td>
                    <?php
                    if($this->session->userdata('nivel') == 1){?>
                    <td><a class="btn btn-primary" href="<?php echo base_url()?>index.php/colores/editar/<?php echo $value['ID']?>">Editar</a></td>
                    <td><a class="btn btn-primary" onclick="eliminar(<?php echo $value['ID']?>)">Eliminar</a></td>
                    <?php
                    }
                    ?>            
                </tr>
            
        <?php
        }
        ?>
    </table>
</div>

<script>

   function eliminar($id){
          if(confirm("¿Esta seguro de eliminar color?")){
            window.location.href= "<?php echo base_url()?>index.php/colores/eliminar/"+$id;
          }
      
   }


</script>