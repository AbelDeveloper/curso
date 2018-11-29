<script type="text/javascript">
    $(document).ready(function () {
        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if (key < 48 || key > 57) {
                return false;
            } else {
                return true;
            }
        }
        ;

      
        
       
        
        
        
        
    });
    
    
      function grabar(){
        var equipo_id = $("#equipo").val();
        var obs = $("#obs").val();
        if (confirm("¿Esta seguro de devolver?")) {
            window.location.href= "<?php echo base_url() ?>index.php/egresados/grabar?equipo_id="+equipo_id+"&obs="+obs;
        
        }
     }  
    
</script>
<div class="container">
        <h2>Entregar a ciudadano</h2>   
   
    <form method="post" action="<?php echo base_url() ?>index.php/egresados/grabar">
        <table class="table table-condensed">
           
            <!--
            <tr>
                <td>OPCION 0 :</td>
                <td>
                    <select name="tipo_documento" id="tipo_documento" class="form-control">
                        <?php
                        foreach ($tipo_documentos as $value_documentos){?>
                        <option value="<?php echo $value_documentos['ID'];?>"><?php echo $value_documentos['TIPO_DOCUMENTO'];?></option>
                        <?php
                        }
                        ?>                        
                    </select>
                </td>
            </tr>
            <tr>
                <td><span id="label_numero_doc">OPCION 1 :</span>:</td>
                <td><input maxlength="8" maxlength="8" type="text" class="form-control" name="NUMERO_DOCUMENTO" id="NUMERO_DOCUMENTO"></td>
            </tr>
            <tr>
                <td>OPCION 2 :</td>
                <td><input type="text" class="form-control" name="NOMBRES" id="NOMBRES"></td>
            </tr>
          
            <tr>
                <td>OPCION 3 :</td>
                <td>
                    <select class="form-control" name="ANIO">
                        <option value="">Seleccionar</option>
                        <?php
                        for($i=1920; $i<=2000; $i++){?>
                        <option value="<?php echo $i;?>"><?php echo $i?></option>
                        <?php
                        }
                        ?>                        
                    </select>                    
                </td>
            </tr>-->
            <tr>
                <td>Devolucion :</td>
                <td colspan="2"><select class="form-control" name="devolucion">
                        <option value="1">ENTREGADO DE CIUDADANO</option>
                        
                    </select></td>
            </tr>
            <tr>
                <td>Observación:</td>
               
                <td><textarea type="text" class="form-control" name="obs" id="OBS"></textarea></td>
               
            </tr>
            <tr>
                <input type="hidden" name="equipo_id" value=""/>
                <td style="padding-top: 20px" align="center" colspan="2"><input class="btn btn-primary" type="button" onclick="grabar()" value="Entregar"></td>
            </tr>
        </table>
        <input type="hidden" name="equipo_id" value="<?php echo $equipo;?>" id="equipo">
    </form>
</div>