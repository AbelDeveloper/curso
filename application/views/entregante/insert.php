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

        $("#NUMERO_DOCUMENTO").keypress(validateNumber);
        $("#TELEFONO").keypress(validateNumber);
        $("#tipo_documento").change(function(){
            if($("#tipo_documento").val() == '1'){
                $("#label_numero_doc").text('Numero de DNI');
                $("#NUMERO_DOCUMENTO").attr('minlength', '8');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '8');
            }
            if($("#tipo_documento").val() == '2'){
                $("#label_numero_doc").text('Numero de Carnet de Extranjeria');
                $("#NUMERO_DOCUMENTO").attr('minlength', '10');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '10');
            }
            if($("#tipo_documento").val() == '3'){
                $("#label_numero_doc").text('Numero de RUC');
                $("#NUMERO_DOCUMENTO").attr('minlength', '11');
                $("#NUMERO_DOCUMENTO").attr('maxlength', '11');
            }
        })

        if(<?php echo $data_equipo[0]['CONSERVACION_ESTADO_ID']?> == 3){
            $('#UBICACION_FISICA > option[value="2"]').attr('selected', 'selected');
            $('#UBICACION_FISICA > option[value="1"]').remove();
            $('#UBICACION_FISICA > option[value="3"]').remove();
            $('#UBICACION_FISICA > option[value=""]').remove();
            $('#UBICACION_FISICA').attr('readonly',true);
        }else if(<?php echo ($data_equipo[0]['IMEI_FISICO_1']=='')?0:$data_equipo[0]['IMEI_FISICO_1'];?> != <?php echo ($data_equipo[0]['IMEI_LOGICO_1']=='')?0:$data_equipo[0]['IMEI_LOGICO_1'];?> && (<?php echo $data_equipo[0]['CONSERVACION_ESTADO_ID']?> == 1 || <?php echo $data_equipo[0]['CONSERVACION_ESTADO_ID']?> == 2) && ("<?php echo $data_equipo[0]['OBSERVACION_INOPERATIVIDAD']?>").indexOf("CELULAR ANTIGUO")!=-1){
          $('#UBICACION_FISICA > option[value="3"]').attr('selected', 'selected');
          $('#UBICACION_FISICA > option[value="2"]').remove();
          $('#UBICACION_FISICA > option[value="1"]').remove();
          $('#UBICACION_FISICA > option[value=""]').remove();
          $('#UBICACION_FISICA').attr('readonly',true);
        }else {
          $('#UBICACION_FISICA > option[value="1"]').attr('selected', 'selected');
          $('#UBICACION_FISICA > option[value="2"]').remove();
          $('#UBICACION_FISICA > option[value="3"]').remove();
          $('#UBICACION_FISICA > option[value=""]').remove();
          $('#UBICACION_FISICA').attr('readonly',true);
          //$('#UBICACION_FISICA > option[value="2"]').remove();
        }
    });
</script>
<div class="container">

        <h2>Nuevo Entregante</h2>
    <h4>Codigo:<?php echo $data_equipo[0]['CODIGO_DEPARTAMENTO'].".".$data_equipo[0]['CODIGO_OPERADOR'].".".$data_equipo['item']?></h4>
    <h5>Equipo:<?php echo $data_equipo[0]['MARCA']." ".$data_equipo[0]['MODELO']." ".$data_equipo[0]['COLOR']?></h5>
    <form method="post" action="<?php echo base_url() ?>index.php/entregantes/grabar">
        <table class="table table-condensed">
            <tr>
                <td>Entidad Entregante:</td>
                <td><input class="form-control" readonly="" type="text" value="<?php echo $CARGA_ENTIDAD_ENTREGANTE?>" />
                    <input type="hidden" value="<?php echo $CARGA_ENTIDAD_ENTREGANTE_ID?>" name="ENTIDAD_ENTREGANTE"/>
                </td>
            </tr>
            <tr>
                <td>Tipo Documentos:</td>
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
                <td><span id="label_numero_doc">Número de DNI</span>:</td>
                <td><input maxlength="8" maxlength="8" type="text" class="form-control" name="NUMERO_DOCUMENTO" id="NUMERO_DOCUMENTO"></td>
            </tr>
            <tr>
                <td>Nombres:</td>
                <td><input type="text" class="form-control" name="NOMBRES" id="NOMBRES"></td>
            </tr>
            <tr>
                <td>Sexo:</td>
                <td>
                    <select class="form-control" name="SEXO" id="SEXO">
                        <option value="">NINGUNO</option>
                        <option value="MASCULINO">MASCULINO</option>
                        <option value="FEMENINO">FEMENINO</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Año Nacimiento:</td>
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
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td><input minlength="7" maxlength="9" type="text" class="form-control" name="TELEFONO" id="TELEFONO"></td>
            </tr>
            <tr>
                <td>Distrito:</td>
                <td>
                    <select class="form-control" name="DISTRITOS" id="DISTRITOS">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($distritos as $value_distritos) {
                            ?>
                            <option value="<?php echo $value_distritos['ID'] ?>"><?php echo $value_distritos['DISTRITO'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Ubicación Física:</td>
                <td>
                    <select class="form-control" name="UBICACION_FISICA" id="UBICACION_FISICA" required="">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($ubicacion_fisica as $values){?>
                        <option value="<?php echo $values['ID']?>"><?php echo $values['UBICACION_FISICA']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <input type="hidden" name="equipo_id" value="<?php echo $data_equipo[0]['EQUIPO_ID'];?>"/>
                <td style="padding-top: 20px" align="center" colspan="2"><input class="btn btn-primary" type="submit" value="Grabar Entregante"></td>
            </tr>
        </table>
    </form>
</div>
