<script type="text/javascript">    
    $(document).ready(function () {
            $("#FECHA").datepicker();
    });
</script>
<h3 class="bg-info" align="center">
<?PHP echo $this->session->flashdata('mensaje');?>
</h3>
<div class="container">    
    <h2>Carga de Digitador</h2>
    <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/cargas/grabar">
        <table class="table table-condensed">
            <tr>
                <td>Personal:</td>
                <td>
                    <select class="form-control" name="usuarios">
                        <?php
                        foreach ($usuarios as $values) {
                            ?>
                            <option value="<?php echo $values['ID'] ?>"><?php echo $values['NOMBRES']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cantidad de Celulares:</td>
                <td><input required="" class="form-control" type="text" name="cantidad_celulares" /></td>
            </tr>
            <tr>
                <td>Entidad Entregante:</td>
                <td>
                    <select class="form-control" name="entidad_entregante">
                        <?php
                        foreach ($entidad_entregante as $value){?>
                        <option value="<?php echo $value['ID']?>"><?php echo $value['ENTIDAD']?></option>
                        <?php
                        }                    
                        ?>                    
                    </select>
                </td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td><input required="" type="text" class="form-control" name="FECHA" id="FECHA" value="<?php echo $fecha_actual;?>"></td>
            </tr>
            <tr>
                <td><input class="btn btn-primary" type="submit" value="Guardar"/></td>
            </tr>
        </table>
    </form>    
</div>