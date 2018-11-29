<div class="container">    
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Ingresar nueva Entidad Entregable</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/entidad_entregantes/grabar">
        <table class="table table-condensed">            
            <tr>
                <td>Entidad Entregable:</td>
                <td><input required="" class="form-control" type="text" name="entidad" /></td>
            </tr>            
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>    
</div>