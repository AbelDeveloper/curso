<div class="container">    
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Editar Entidad Entregable</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/entidad_entregantes/editar_g">
        <table class="table table-condensed">            
            <tr>
                <td>Entidad Entregable:</td>
                <td><input required="" value="<?php echo $data['ENTIDAD']?>" class="form-control" type="text" name="entidad" /></td>
            </tr>            
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $data['ID']?>"/>
                    <input class="btn btn-primary" type="submit" value="Modificar"/>
                </td>
            </tr>
        </table>
    </form>    
</div>