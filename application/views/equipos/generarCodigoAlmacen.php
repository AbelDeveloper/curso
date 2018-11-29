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
        $('#example').DataTable({
            scrollY: 600,
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: true,
            bFilter: false,
        });
        
        $("#checkTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        
    });    
</script>

<div class="container">    
    <h2 align="center">Ingresar a Almacen</h2>
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
            <tr>            
                <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/equipos/detalle/<?php echo $value['EQUIPO_ID']?>', '', 'width=750,height=600,scrollbars=yes,resizable=yes')" href="#"><?php echo $i; $i++;?></a></td>                
                
                <?php if($value['CAJA']==''){?>
                   <td><input type="checkbox" name="che-<?php echo $value['EQUIPO_ID']?>" value="1"></td>
                <?php }else{ ?>
                   <td></td>
                <?php } ?>   
                
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
            <?php
            }
            ?>
            </tbody>
        </table>
        <div align="center">
            <input type="submit" class="btn btn-primary" value="Ingresar Almacen"/>
            <input type="hidden" name="param1" value="<?php echo base64_encode(serialize($equipos));?>" />
        </div>
    </form>
</div>