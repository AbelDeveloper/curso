<div class="container">
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Ingresar nuevo Color</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/colores/grabar">
        <table class="table table-condensed">            
            <tr>
                <td>Color:</td>
                <td><input required="" class="form-control" type="text" name="color" /></td>
            </tr>            
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>    
</div>