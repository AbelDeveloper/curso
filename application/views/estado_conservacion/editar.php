<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Editar Observación</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/estado_conservacion/editar_g">
        <table class="table table-condensed">            
            <tr>
                <td>Observación :</td>
                <td><input required="" value="<?php echo $data['OBSERVACION_INOPERATIVIDAD'];?>" class="form-control" type="text" name="obs" /></td>
            </tr>            
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $data['ID']?>" />
                    <input class="btn btn-primary" type="submit" value="Editar"/>
                </td>
            </tr>
        </table>
    </form>    
</div>