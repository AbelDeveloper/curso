<link rel="stylesheet" type="text/css" href="<?PHP echo base_url() ?>/assets/datetimepicker/jquery.datetimepicker.css"/>

<link rel="stylesheet" type="text/css" href="<?PHP echo base_url() ?>assets/table_column_fixed/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?PHP echo base_url() ?>assets/table_column_fixed/fixedColumns.dataTables.min.css"/>
<script src="<?PHP echo base_url() ?>assets/table_column_fixed/jquery-1.12.3.js"></script>
<script src="<?PHP echo base_url() ?>assets/table_column_fixed/jquery.dataTables.min.js"></script>
<script src="<?PHP echo base_url() ?>assets/table_column_fixed/dataTables.fixedColumns.min.js"></script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
        margin: 0 auto;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {



        // Comprobar los checkbox seleccionados
        //me sirve pare enviar todos los check que estan seleccionados en un array para luego ser procesados.
        $('#verDiasSeleccionados').on('click', function() {
            var diasSeleccionados = new Array();

            var cadena = '';
            $('input[type=checkbox]:checked').each(function() {
                diasSeleccionados.push($(this).val());
                cadena = cadena + $(this).val() + "-";
            });

            var url_select = <?php echo "'" . base_url() . "'"; ?> + "index.php/equipos/generarCodigoAlmacen/" + cadena;
            console.log(url_select);
            $.get( url_select, function( data ) {
                alert('buena mostro' + url_select);
            });
        });

        $("#MARCA").change(function (event) {
            var url = '<?php echo base_url() ?>index.php/equipos/cargaModelos/' + $("#MARCA").val();
            $("#MODELO").load(url);
        });
        $("#CONSERVACION_ESTADO").change(function (event) {
            var url = '<?php echo base_url() ?>index.php/equipos/cargaObservaciones/' + $("#CONSERVACION_ESTADO").val();
            $("#OBSERVACION_INOPERATIVIDADES").load(url);
        });

        $('#exportarExcel').click(function(){
            var IMEI_FISICO_1 = ( $("#IMEI_FISICO_1").val() == "") ?  null : $("#IMEI_FISICO_1").val();

            var OPERADOR_REPORTANTE = ( $("#OPERADOR_REPORTANTE").val() == "") ? null : $("#OPERADOR_REPORTANTE").val();
            var OSIPTEL_ESTADOS = ( $("#OSIPTEL_ESTADOS").val() == "") ? null : $("#OSIPTEL_ESTADOS").val();
            var COLOR = ( $("#color").val() == "") ? null : $("#color").val();

            var ENTIDAD_ENTREGANTES = ( $("#ENTIDAD_ENTREGANTES").val() == "") ? null : $("#ENTIDAD_ENTREGANTES").val();
            var MARCAS = ( $("#MARCA").val() == "") ? null : $("#MARCA").val();
            var MODELOS = ( $("#MODELO").val() == "") ? null : $("#MODELO").val();

            var CONSERVACION_ESTADO = ( $("#CONSERVACION_ESTADO").val() == "") ? null : $("#CONSERVACION_ESTADO").val();
            var OBSERVACION_INOPERATIVIDADES = ( $("#OBSERVACION_INOPERATIVIDADES").val() == "") ? null : $("#OBSERVACION_INOPERATIVIDADES").val();
            var CODIGO = ( $("#CODIGO").val() == "") ?  null : $("#CODIGO").val();
            var UBICACION_FISICA = ( $("#UBICACION_FISICA").val() == "") ? null : $("#UBICACION_FISICA").val();

            var USUARIOS = ( $("#USUARIOS").val() == "") ? null : $("#USUARIOS").val();
            var FECHA_INICIO = ( $("#datetimepicker_inicio").val() == "") ?  null : $("#datetimepicker_inicio").val();
            var FECHA_FIN = ( $("#datetimepicker_fin").val() == "") ?  null : $("#datetimepicker_fin").val();
            var FECHA_MININTER = ( $("#datetimepicker_mininte").val() == "") ?  null : $("#datetimepicker_mininte").val();
            var IMEI_COMPARATIVA = ( $("#IMEI_COMPARATIVA").val() == "") ? null : $("#IMEI_COMPARATIVA").val();

            var url = '<?PHP echo base_url() ?>excel/Examples/excel_almacen.php?\n\
            IMEI_FISICO_1='+IMEI_FISICO_1+'&FECHA_INICIO='+FECHA_INICIO+'&FECHA_FIN='+FECHA_FIN+'&FECHA_MININTER='+FECHA_MININTER+'&USUARIOS='+USUARIOS;

            console.log(url);
            window.open(url, '_blank');
        });

        $('#example').DataTable({
            scrollY: 600,
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            bFilter: false,
        });

        $(".micheckbox").change(function() {
            var name = $(this).attr('name');
            if($(this).prop('checked')){
                var url_select = <?php echo "'" . base_url() . "'"; ?> + "index.php/equipos/generarCodigoUnitarioAlmacen/" + name + "/1";
                console.log(url_select);
                $.get( url_select, function(data){
                    alert('buena mostro' + url_select + data);
                });
            }else{
                var url_select = <?php echo "'" . base_url() . "'"; ?> + "index.php/equipos/generarCodigoUnitarioAlmacen/" + name + "/0";
                console.log(url_select);
                $.get( url_select, function(data) {
                    alert('buena mostro' + url_select + data);
                });
            }


        });


    });

    function leer_excel(){

           window.location.href="<?php echo base_url(); ?>index.php/equipos/leer_excel_almacen";
        }
</script>

<div class="container" style="width:96%;">
    <form method="post" action="<?php echo base_url() ?>index.php/equipos/verAlmacen">
        <div class="row">
            <div class="col-xs-3" style="font-size: 20px">Almacén</div>  </br>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <input type="text" class="form-control input-sm" name="IMEI_FISICO_1" id="IMEI_FISICO_1" placeholder=" Imei Físico 1"  value="<?php if(isset($_POST['IMEI_FISICO_1'])) echo $_POST['IMEI_FISICO_1'];?>">
            </div>
            <div class="col-xs-2">
                <select class="form-control input-sm" name="USUARIOS" id="USUARIOS">

                    <!-- <option value="">Digitadores:</option>
                    <?php

                    foreach ($usuarios as $usuarios_values){
                        $SELECTED = (isset($_POST['USUARIOS']) && ($_POST['USUARIOS'] == $usuarios_values['ID'])) ? 'SELECTED' : '';?>
                    <option <?php echo $SELECTED;?> value="<?php echo $usuarios_values['ID'];?>"><?php echo $usuarios_values['NOMBRES']." ".$usuarios_values['APELLIDO_PATERNO']?></option>
                    <?php
                         }
                    ?>-->

                    <?php
                    foreach ($usuarios as $usuarios_values){?>
                        <?php if($usuarios_values['ID']!=1){ ?>
                           <?php if($usuario_seleccionado==$usuarios_values['ID']){ ?>
                              <option selected value="<?php echo $usuarios_values['ID'];?>"><?php echo $usuarios_values['NOMBRES']." ".$usuarios_values['APELLIDO_PATERNO']?></option>
                           <?php }else{ ?>
                              <option value="<?php echo $usuarios_values['ID'];?>"><?php echo $usuarios_values['NOMBRES']." ".$usuarios_values['APELLIDO_PATERNO']?></option>
                           <?php } ?>
                         <?php }else{ ?>
                           <?php if($usuario_seleccionado==$usuarios_values['ID']){ ?>
                                <option selected value="">Todos</option>
                           <?php }else{ ?>
                              <option value="">Todos</option>
                           <?php } ?>
                         <?php } ?>
                    <?php
                         }
                    ?>
                     <option value="">Todos</option>
                </select>
            </div>

            <div class="col-xs-2">
                <input value="<?php if(isset($_POST['datetimepicker_inicio'])) echo $_POST['datetimepicker_inicio']?>" type="text" class="form-control input-sm" name="datetimepicker_inicio" id="datetimepicker_inicio" placeholder="Fecha Desde">
            </div>
            <div class="col-xs-2">
                <input value="<?php if(isset($_POST['datetimepicker_fin'])) echo $_POST['datetimepicker_fin']?>" type="text" class="form-control input-sm" name="datetimepicker_fin" id="datetimepicker_fin" placeholder="Fecha Hasta">
            </div>
            <div class="col-xs-2">
                 <input value="<?php if(isset($_POST['datetimepicker_mininte'])) echo $_POST['datetimepicker_mininte']?>" type="text" class="form-control input-sm" name="datetimepicker_mininte" id="datetimepicker_mininte" placeholder="Fecha Mininter">
            </div>

            <div class="col-xs-1">
                <a style="padding-right: 10px" href="#"><img id="exportarExcel" src="<?= base_url()?>/images/excel.png"></a>
            </div>
            <div class="col-xs-1">
                <input type="submit" class="btn btn-primary" value="Buscar"/>
            </div>




           <!--
            <div class="col-xs-1">

                <div align="right"><a href="<?php echo base_url()?>index.php/equipos/devoluciones" class="btn btn-success">Subir Archivo</a></div>

            </div>-->


        </div>



    </form>
</div>
    <script src="<?PHP echo base_url() ?>/assets/datetimepicker/jquery.datetimepicker.js"></script>
    <script language="JavaScript" type="text/JavaScript">
        $('#datetimepicker_inicio').datetimepicker({
            format:'d-m-Y H:i',
            dayOfWeekStart : 1,
            lang:'es',
        });
        $('#datetimepicker_inicio').datetimepicker({value:'',step:10});

        $('#datetimepicker_fin').datetimepicker({
            format:'d-m-Y H:i',
            dayOfWeekStart : 1,
            lang:'es',
        });
        $('#datetimepicker_fin').datetimepicker({value:'',step:10});

        $('#datetimepicker_mininte').datetimepicker({
            format:'d-m-Y H:i',
            dayOfWeekStart : 1,
            lang:'es',
        });

        $('.some_class').datetimepicker();

        var array_eq = [];
        function almacenar(id_equipo){

            if($.inArray(id_equipo,array_eq)!=-1){

            }else{
                array_eq.push(id_equipo);
            }

            console.log(array_eq);
            $.get("<?php echo base_url()?>index.php/equipos/almacenar",{id:id_equipo})
             .done(function(res){

             });
        }



      function select_pagina(n){
         $("#pagina").val(n);
      }
    </script>

    <?php
    if($this->session->flashdata('mensaje') != ''){?>
    <h3 class="bg-info" align="center">
        <?PHP echo $this->session->flashdata('mensaje');?>
    </h3>
    <?php
    }
    ?>
    <!-- <table class="table tab-content"> -->

    </br>
    <form method="post" action="<?php echo base_url()?>index.php/equipos/generarCodigoAlmacen_g" >
        <div class="container-fluid" style="padding:5px 50px;">
            <div class="row">
                <?PHP if($this->session->userdata('nivel') == 2){        ?>
                  <div class="col-12"><a href="<?php echo base_url()?>index.php/equipos/devolucionesExcel" class="btn btn-success">Carga Masiva</a></div>
                <?php }?>
            </div>
        </div>
        <table id="example" class="stripe row-border order-column" cellspacing="0" width="90%" >
            <thead>
                <tr>
                <th>N.</th>
                <th>EGRESAR</th>
                <?php
                if(($this->session->userdata('nivel') == 2) && ($carga_activa != '')){        ?>

                <?php
                }
                ?>
                <th>ALMACÉN</th>
                <th>ITEM</th>
                <th>DIFERENCIA DIAS</th>
                <th>CÓDIGO</th>
                <th>IMEI FÍSICO 1</th>
                <th>IMEI FÍSICO 2</th>
                <th>IMEI LÓGICO 1</th>
                <th>IMEI LÓGICO 2</th>
                <th>OPERADOR REPORTANTE</th>
                <th>ESTADO OSIPTEL</th>
                <th>FECHA REPORTE</th>
                <th>MARCA</th>

                <th>MODELO</th>
                <th>COLOR</th>
                <th>FECHA INGRESO MININTER</th>
                <th>IMEI COMPARATIVA</th>
                <th>ESTADO DE CONSERVACIÓN</th>
                <th>OBS. DEL ESTADO CONSERVACIÓN</th>
                <th>DEPARTAMENTO</th>
                <th>ENTIDAD<br>ENTREGANTE</th>
                <th>NOMBRES</th>
                <th>SEXO ENTREGANTE</th>

                <th>TIPO DOCUMENTO</th>
                <th>N. Documento</th>
                <th>AÑO</th>
                <th>TELÉFONO</th>
                <th>UBICACIÓN FÍSICA</th>
                <th>MOTIVO EQUIPO</th>
                <th>MOTIVO ENTREGANTE</th>
                <th>DISTRITO</th>
                <th>USUARIO</th>
                <th>FECHA REGISTRO</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($equipos as $value){

                $imei_comparativa = '';
                $ruta_entregante = ($value['ENTREGANTE_ID'] == '') ? 'insert/'.$value['EQUIPO_ID'] : 'editar/'.$value['ENTREGANTE_ID'].'/'.$value['EQUIPO_ID'];
                  if($value['IMEI_FISICO_1'] == $value['IMEI_LOGICO_1']) $imei_comparativa = 'COINCIDE' ;
                  if(($value['IMEI_FISICO_1'] !=  "") && ($value['IMEI_LOGICO_1'] != '') && ($value['IMEI_FISICO_1'] != $value['IMEI_LOGICO_1'])) $imei_comparativa = 'NO COINCIDE';
                  if(($value['IMEI_FISICO_1'] == "") OR ($value['IMEI_LOGICO_1'] == "")) $imei_comparativa = 'NULO';
                ?>

            <?php if($value['CAJA']!=''){ ?>
            <tr>
                <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/equipos/detalle/<?php echo $value['EQUIPO_ID']?>', '', 'width=750,height=600,scrollbars=yes,resizable=yes')" href="#"><?php echo $i; $i++;?></a></td>

                <?PHP if($this->session->userdata('nivel') == 2){ ?>
                  <?php if($value['ARMARIO_ID']!=7){ ?>
                        <?php if($imei_comparativa=='COINCIDE'){?>
                           <td><a href="<?php echo base_url()?>index.php/equipos/devoluciones/<?php echo $value['EQUIPO_ID'];?>" class="btn btn-success">Egresar</a></td>
                        <?PHP }else{?>
                           <td></td>
                        <?php }?>
                 <?php }else{ ?>
                   <td></td>
                 <?php }?>
                <?PHP }else{?>
                   <td></td>
                <?php }?>



                <td><?php echo '<label style="color:blue;">'.$value['CAJA'].'</label>'?></td>

                <td><?php echo $value['ITEM']?></td>
                <td><?php echo $value['DIFERENCIA_EN_DIAS']?></td>
                <td><?php echo $value['CODIGO']?></td>
                <td><?php echo $value['IMEI_FISICO_1']?></td>
                <td><?php echo $value['IMEI_FISICO_2']?></td>
                <td><?php echo $value['IMEI_LOGICO_1']?></td>
                <td><?php echo $value['IMEI_LOGICO_2']?></td>
                <td><?php echo $value['OPERADOR']?></td>
                <td><?php echo $value['OSIPTEL_ESTADO']?></td>
                <td><?php echo $value['FECHA_REPORTE_OPERADOR']?></td>
                <td><?php echo $value['MARCA']?></td>

                <td><?php echo $value['MODELO']?></td>
                <td><?php echo $value['COLOR']?></td>
                <td><?php echo $value['FECHA_INGRESO_MININTER']?></td>
                <td><?php echo $imei_comparativa;?></td>
                <td><?php echo $value['CONSERVACION_ESTADO']?></td>
                <td><?php echo $value['OBSERVACION_INOPERATIVIDAD']?></td>
                <td><?php echo $value['DEPARTAMENTO']?></td>
                <td><?php echo $value['ENTIDAD']?></td>
                <td><?php echo $value['NOMBRES']?></td>
                <td><?php echo $value['SEXO']?></td>

                <td><?php echo $value['TIPO_DOCUMENTO']?></td>
                <td><?php echo $value['NUMERO_DOCUMENTO']?></td>
                <td><?php echo $value['ANIO']?></td>
                <td><?php echo $value['TELEFONO']?></td>
                <td><?php echo $value['UBICACION_FISICA']?></td>
                <td><?php echo $value['MOTIVO_UPDATE_EQUIPO']?></td>
                <td><?php echo $value['MOTIVO_UPDATE_ENTREGANTE']?></td>
                <td><?php echo $value['DISTRITO']?></td>
                <td><?php echo $value['USUARIO']?></td>
                <td><?php echo $value['FECHA_INSERT']?></td>
            </tr>

            <?php } ?>

            <?php
            }
            ?>
            </tbody>
        </table>
        <div align="center">
            <!--<input type="submit" class="btn btn-primary" value="Realizar Devolución"/>-->

            <input type="hidden" name="param1" value="<?php echo base64_encode(serialize($equipos));?>" />
        </div>
    </form>


</div>
