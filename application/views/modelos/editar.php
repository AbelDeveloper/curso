<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Editar Modelo</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/modelos/editar_g">
        <table class="table table-condensed">            
            <tr>
                <td>Marca:</td>
                <td>
                    <select class="form-control" name="MARCA" id="MARCA">
                        <?php
                        foreach ($marcas as $value){
                            $SELECTED = ($value['ID'] == $data[0]['MARCA_ID']) ? 'SELECTED' : '';
                        ?>
                        <option <?php echo $SELECTED;?> value="<?php echo $value['ID']?>"><?php echo $value['MARCA']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td><input required="" value="<?php echo $data[0]['MODELO'];?>" class="form-control" type="text" name="MODELO" /></td>
            </tr>            
            <tr>
                <td colspan="2">
                    <input type="hidden" name="MODELO_ID" value="<?php echo $data[0]['MODELO_ID']?>" />
                    <input class="btn btn-primary" type="submit" value="Editar"/>
                </td>
            </tr>
        </table>
    </form>    
</div>