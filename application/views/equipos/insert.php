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

        $("#FECHA_REPORTE_OPERADOR").datepicker({
            changeMonth: true,
            changeYear: true
          });

        $("#OBS_INOPERATIVIDAD").prop("disabled", true);

        $("#CONSERVACION_ESTADO").change(function () {
            if ($("#CONSERVACION_ESTADO").val() != 1) {
                $("#OBS_INOPERATIVIDAD").prop("disabled", false);
                $("#OBS_INOPERATIVIDAD").prop("required", true);
            } else {
                $("#OBS_INOPERATIVIDAD").val('');
                $("#OBS_INOPERATIVIDAD").prop("disabled", true);
            }
        });

        $("#IMEI_FISICO_1").keypress(validateNumber);
        $("#IMEI_LOGICO_1").keypress(validateNumber);
        $("#IMEI_FISICO_2").keypress(validateNumber);
        $("#IMEI_LOGICO_2").keypress(validateNumber);

        $("#CONSERVACION_ESTADO").change(function (event) {
            var url = '<?php echo base_url() ?>index.php/equipos/cargaObservaciones/' + $("#CONSERVACION_ESTADO").val();
            $("#OBSERVACION_INOPERATIVIDADES").load(url);
        });
        $("#marcas").change(function (event) {
            var url = '<?php echo base_url() ?>index.php/equipos/cargaModelos/' + $("#marcas").val();
            $("#MODELO").load(url);
        });
        $("#operador_reportantes").change(function (event) {
            var url = '<?php echo base_url() ?>index.php/equipos/cargaOsiptel/' + $("#operador_reportantes").val();
            $("#OSIPTEL_ESTADOS").load(url);
        });

        $("#IMEI_LOGICO_1").keyup(function() {
            if($("#IMEI_FISICO_1").val() == $("#IMEI_LOGICO_1").val()){
                $("#IMEI_FISICO_1").css({'color':'black'})
                $("#IMEI_LOGICO_1").css({'color':'black'})
            }else{
                $("#IMEI_FISICO_1").css({'color':'red'})
                $("#IMEI_LOGICO_1").css({'color':'red'})
            }
        });

        $("#operador_reportantes").change(function(){
            if($("#operador_reportantes").val() != 10){
               $("#IMEI_FISICO_1").prop( "required", true);
            }else if(($("#operador_reportantes").val() == 10) || ($("#operador_reportantes").val() == 11)){
                $('#FECHA_REPORTE_OPERADOR').val('');
                $("#FECHA_REPORTE_OPERADOR").prop("readonly", true);
                $("#FECHA_REPORTE_OPERADOR").datepicker("destroy");
                $("#IMEI_FISICO_1").prop( "required", false);
            }else{
                $("#FECHA_REPORTE_OPERADOR").prop( "readonly", false );
                $("#FECHA_REPORTE_OPERADOR").datepicker({
                    changeMonth: true,
                    changeYear: true
                });
            }
        })

    });
</script>
<div class="container">
    <h3 class="bg-info" align="center">
<?PHP echo $this->session->flashdata('mensaje'); ?>
    </h3>
    <h2 align="center">Ingresar Celular</h2><br>
    <form method="post" action="<?php echo base_url() ?>index.php/equipos/grabar">
        <table class="table table-condensed">
            <tr>
                <td>Departamento Origen:</td>
                <td>
                    <select required="" class="form-control" name="DEPARTAMENTOS" id="DEPARTAMENTOS">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($departamentos as $value_departamentos) {
                            ?>
                            <option value="<?php echo $value_departamentos['ID'] ?>"><?php echo $value_departamentos['DEPARTAMENTO'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Fecha Ingreso Mininter:</td>
                <td><input readonly="" value="<?php echo $FECHA_INGRESO_MININTER; ?>" required="" type="text" class="form-control" name="FECHA_INGRESO_MININTER" id="FECHA_INGRESO_MININTER"></td>
            </tr>
            <tr>
                <td>Imei Físico 1:</td>
                <td><input maxlength="15" minlength="15" type="text" class="form-control" name="IMEI_FISICO_1" id="IMEI_FISICO_1"></td>
                <td>Imei Físico 2:</td>
                <td><input maxlength="15" minlength="15" type="text" class="form-control" name="IMEI_FISICO_2" id="IMEI_FISICO_2"></td>

            </tr>
            <tr>
                <td>Marca:</td>
                <td>
                    <select required="" class="form-control" name="marcas" id="marcas">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($marcas as $value_marcas) {
                            ?>
                            <option value="<?php echo $value_marcas['ID'] ?>"><?php echo $value_marcas['MARCA'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Modelo:</td>
                <td>
                    <select name="MODELO" id="MODELO" class="form-control" required>

                    </select>
                </td>
            </tr>
            <tr>
                <td>Color Equipo:</td>
                <td>
                    <select required="" class="form-control" name="COLORES">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($colores as $value_colores) {
                            ?>
                            <option value="<?php echo $value_colores['ID'] ?>"><?php echo $value_colores['COLOR'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Operador Reportante:</td>
                <td>
                    <select required="" class="form-control" name="operador_reportantes" id="operador_reportantes" >
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($operador_reportantes as $value_operador_reportantes) {
                            ?>
                            <option value="<?php echo $value_operador_reportantes['ID'] ?>"><?php echo $value_operador_reportantes['OPERADOR'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Estado Osiptel:</td>
                <td>
                    <select required="" class="form-control" name="OSIPTEL_ESTADOS" id="OSIPTEL_ESTADOS">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($osiptel_estados as $value_osiptel_estados) {
                            ?>
                            <option value="<?php echo $value_osiptel_estados['ID'] ?>"><?php echo $value_osiptel_estados['OSIPTEL_ESTADO'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Fecha Reporte Operador:</td>
                <td><input required="" type="text" class="form-control" name="FECHA_REPORTE_OPERADOR" id="FECHA_REPORTE_OPERADOR"></td>
            </tr>
            <tr>
                <td>Estado de conservación: </td>
                <td>
                    <select id="CONSERVACION_ESTADO" class="form-control" name="CONSERVACION_ESTADO" required="">
                        <option value="">Seleccionar</option>
                        <?php
                        foreach ($conservacion_estado as $value_conservacion) {
                            ?>
                            <option value="<?php echo $value_conservacion['ID'] ?>"><?php echo $value_conservacion['CONSERVACION_ESTADO'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>Obs. del Estado Conservación:</td>
                <td>
                    <select required="" name="OBSERVACION_INOPERATIVIDADES" id="OBSERVACION_INOPERATIVIDADES" class="form-control">
                    </select>
                </td>
            </tr>
            <tr>
                <td>Imei Lógico 1:</td>
                <td><input maxlength="15" minlength="15" type="text" class="form-control" name="IMEI_LOGICO_1" id="IMEI_LOGICO_1"></td>
                <td>Imei Lógico 2:</td>
                <td><input maxlength="15" minlength="15" type="text" class="form-control" name="IMEI_LOGICO_2" id="IMEI_LOGICO_2"></td>
            </tr>


            <tr>
                <td style="padding-top: 20px" align="center" colspan="4">
                    <input class="btn btn-primary" type="submit" value="Grabar Telefono">
                </td>
            </tr>

        </table>
    </form>
</div>
