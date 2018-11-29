<div class="container">    
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <h2>Ingresar nueva Marca</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/marcas/grabar">
        <table class="table table-condensed">            
            <tr>
                <td>Marca:</td>
                <td><input required="" class="form-control" type="text" name="marca" /></td>
            </tr>            
            <tr>
                <td colspan="2"><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>    
</div>