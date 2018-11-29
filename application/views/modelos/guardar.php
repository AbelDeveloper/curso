<div class="container">    
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Ingresar nueva Marca</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/modelos/grabar">
        <table class="table table-condensed">            
            <tr>
                <td>Marca:</td>
                <td>
                    <select class="form-control" name="marca" id="marca">
                        <?php
                        foreach ($marcas as $value){?>
                        <option value="<?php echo $value['ID']?>"><?php echo $value['MARCA']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Modelo:</td>
                <td><input required="" class="form-control" type="text" name="modelo" /></td>
            </tr>
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>    
</div>