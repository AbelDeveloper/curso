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
            var IMEI_COMPARATIVA = ( $("#IMEI_COMPARATIVA").val() == "") ? null : $("#IMEI_COMPARATIVA").val();

            var url = '<?PHP echo base_url() ?>excel/Examples/excel_equipos.php?\n\
            IMEI_FISICO_1='+IMEI_FISICO_1+'&OPERADOR_REPORTANTE='+OPERADOR_REPORTANTE+'&OSIPTEL_ESTADOS='+OSIPTEL_ESTADOS+'&COLOR='+COLOR+'&ENTIDAD_ENTREGANTES='+ENTIDAD_ENTREGANTES+'&MARCAS='+MARCAS+'&MODELOS='+MODELOS+'&CONSERVACION_ESTADO='+CONSERVACION_ESTADO+'&OBSERVACION_INOPERATIVIDADES='+OBSERVACION_INOPERATIVIDADES+'&CODIGO='+CODIGO+'&UBICACION_FISICA='+UBICACION_FISICA+'&USUARIOS='+USUARIOS+'&FECHA_INICIO='+FECHA_INICIO+'&FECHA_FIN='+FECHA_FIN+'&IMEI_COMPARATIVA='+IMEI_COMPARATIVA;

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
            if($(this).prop('checked')) {
                var url_select = <?php echo "'" . base_url() . "'"; ?> + "index.php/equipos/generarCodigoUnitarioAlmacen/" + name + "/1";
                console.log(url_select);
                $.get( url_select, function( data ) {
                    alert('buena mostro' + url_select + data);
                });                 
            } else {
                var url_select = <?php echo "'" . base_url() . "'"; ?> + "index.php/equipos/generarCodigoUnitarioAlmacen/" + name + "/0";
                console.log(url_select);
                $.get( url_select, function( data ) {
                    alert('buena mostro' + url_select + data);
                }); 
            }
        });
    });
</script>

<div class="container">
    <form method="post" action="<?php echo base_url() ?>index.php/equipos/verAlmacen">
        <div class="row">
            <div class="col-xs-3" style="font-size: 20px">Devoluciones</div>        
        </div>        
        <div class="row">
            <div class="col-xs-3">
                <input type="text" class="form-control input-sm" name="IMEI_FISICO_1" id="IMEI_FISICO_1" placeholder=" Imei Físico 1"  value="<?php if(isset($_POST['IMEI_FISICO_1'])) echo $_POST['IMEI_FISICO_1'];?>">
            </div>
            
            <div class="col-xs-3">
                <input value="<?php if(isset($_POST['datetimepicker_inicio'])) echo $_POST['datetimepicker_inicio']?>" type="text" class="form-control input-sm" name="datetimepicker_inicio" id="datetimepicker_inicio" placeholder="Fecha Desde">
            </div>
            <div class="col-xs-3">
                <input value="<?php if(isset($_POST['datetimepicker_fin'])) echo $_POST['datetimepicker_fin']?>" type="text" class="form-control input-sm" name="datetimepicker_fin" id="datetimepicker_fin" placeholder="Fecha Hasta">
            </div>

            <div class="col-xs-1">
                <a style="padding-right: 10px" href="#"><img id="exportarExcel" src="<?= base_url()?>/images/excel.png"></a>
            </div>
            <div class="col-xs-1">
                <input type="submit" class="btn btn-primary" value="Buscar"/>
            </div>
            
            <div class="col-xs-1">
               
                <div align="right"><a href="<?php echo base_url()?>index.php/equipos/devoluciones" class="btn btn-success">Devoluciones</a></div>
                
            </div>  
            
 
        </div>
        
        
      
    </form>   
    
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
    

    <form method="post" action="<?php echo base_url()?>index.php/equipos/generarCodigoAlmacen_g">            
        <table id="example" class="stripe row-border order-column" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th>N.</th>
                <th><input type="checkbox" name="cheka" id="checkTodos" value="0"></th>
                <?php
                if(($this->session->userdata('nivel') == 2) && ($carga_activa != '')){        ?>
                <th>EDITAR</th>
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
                <th>FECHA INSERT</th>          
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
                
            <?php if($value['CAJA']!=''){?>    
            <tr>            
                <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/equipos/detalle/<?php echo $value['EQUIPO_ID']?>', '', 'width=750,height=600,scrollbars=yes,resizable=yes')" href="#"><?php echo $i; $i++;?></a></td>                
                
                
                   <td><input type="checkbox" name="che-<?php echo $value['EQUIPO_ID']?>" value="1"></td>
               
                
                <?php
                if(($this->session->userdata('nivel') == 2) && ($carga_activa != '')){        ?>
                <td>
                    <div style="width: 65px">
                        <a href="<?php echo base_url()?>index.php/equipos/editar/<?php echo $value['EQUIPO_ID']?>" ><img width="20px" src="<?php echo base_url()?>images/Mobile-Smartphone-icon.png"></a>                    
                        <a href="<?php echo base_url()?>index.php/entregantes/<?php echo $ruta_entregante;?>"><img width="20px" src="<?php echo base_url()?>images/entregante.png"></a>                    
                    </div>                
                </td>
                <?php
                }
                ?>
                <td><?php echo $value['CAJA']?></td>
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
            <input type="submit" class="btn btn-primary" value="Realizar Devolución"/>
            <input type="hidden" name="param1" value="<?php echo base64_encode(serialize($equipos));?>" />
        </div>
    </form>
    
    
</div>

