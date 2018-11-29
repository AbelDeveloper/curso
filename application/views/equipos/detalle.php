<div class="container">
    <h3>Detalle de Equipo</h3>
    <table class="table table-bordered table-striped">
        <tr>
            <td>Código</td>
            <td><?php echo $detalle['CODIGO']?></td>
        </tr>
        <tr>
            <td>Fecha Reporte Operador</td>
            <td><?php echo $detalle['FECHA_REPORTE_OPERADOR']?></td>
        </tr>
        <tr>
            <td>Fecha Ingreso Miniter</td>
            <td><?php echo $detalle['FECHA_INGRESO_MININTER']?></td>
        </tr>
        <tr>
            <td>IMEI FISICO 1</td>
            <td><?php echo $detalle['IMEI_FISICO_1'] ?></td>
        </tr>
        <tr>
            <td>IMEI LOGICO 1</td>
            <td><?php echo $detalle['IMEI_LOGICO_1']?></td>
        </tr>
        <tr>
            <td>IMEI FISICO 2</td>
            <td><?php echo $detalle['IMEI_FISICO_2']?></td>
        </tr>
        <tr>
            <td>IMEI LOGICO 2</td>
            <td><?php echo $detalle['IMEI_LOGICO_2']?></td>
        </tr>
        <tr>
            <td>Observación de Inoperatividad</td>
            <td><?php echo $detalle['OBSERVACION_INOPERATIVIDAD']?></td>
        </tr>
        <tr>
            <td>Conservación de estado</td>
            <td><?php echo $detalle['CONSERVACION_ESTADO']?></td>
        </tr>
        <tr>
            <td>Marca</td>
            <td><?php echo $detalle['MARCA']?></td>
        </tr>
        <tr>
            <td>Modelo</td>
            <td><?php echo $detalle['MODELO']?></td>
        </tr>
        <tr>
            <td>Operador Reportante</td>
            <td><?php echo $detalle['OPERADOR']?></td>
        </tr>
        <tr>
            <td>Estado Osiptel</td>
            <td><?php echo $detalle['OSIPTEL_ESTADO']?></td>
        </tr>
        <tr>
            <td>Color</td>
            <td><?php echo $detalle['COLOR']?></td>
        </tr>
        <tr>
            <td>Departamento</td>
            <td><?php echo $detalle['DEPARTAMENTO']?></td>
        </tr>
        <tr>
            <td>Usuario</td>
            <td><?php echo $detalle['NOMBRES']." ".$detalle['APELLIDO_PATERNO']?></td>
        </tr>
        <tr>
            <td>Fecha de Ingreso:</td>
            <td><?php echo $detalle['FECHA_INSERT']?></td>
        </tr>
    </table>
    <h3>Detalle Entregantes</h3>
    <table class="table table-bordered table-striped">
        <tr>
            <td><?php echo $detalle['TIPO_DOCUMENTO'];?></td>
            <td><?php echo $detalle['NUMERO_DOCUMENTO'];?></td>
        </tr>
        <tr>
            <td>Nombres</td>
            <td><?php echo $detalle['ENT_NOMBRES'];?></td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td><?php echo $detalle['ENT_SEXO'];?></td>
        </tr>
        <tr>
            <td>Año Nacimiento</td>
            <td><?php echo $detalle['ENT_ANIO'];?></td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><?php echo $detalle['ENT_TELEFONO'];?></td>
        </tr>
        <tr>
            <td>Distrito</td>
            <td><?php echo $detalle['DISTRITO'];?></td>
        </tr>
        <tr>
            <td>Entidad Entregante</td>
            <td><?php echo $detalle['ENTIDAD'];?></td>
        </tr>
        <tr>
            <td>Ubicación Física</td>
            <td><?php echo $detalle['UBICACION_FISICA'];?></td>
        </tr>    
    </table>
</div>