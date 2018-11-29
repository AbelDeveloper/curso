<?php
$campos = array();

$campos = ( isset($_REQUEST['IMEI_FISICO_1']) && (($_REQUEST['IMEI_FISICO_1']) != 'null')) ? array_merge($campos, array('IMEI_FISICO_1' => $_REQUEST['IMEI_FISICO_1'])) : $campos;
$campos = ( isset($_REQUEST['OPERADOR_REPORTANTE']) && (($_REQUEST['OPERADOR_REPORTANTE']) != 'null')) ? array_merge($campos, array('OPERADOR_REPORTANTE_ID' => $_REQUEST['OPERADOR_REPORTANTE'])) : $campos;
$campos = ( isset($_REQUEST['OSIPTEL_ESTADOS']) && (($_REQUEST['OSIPTEL_ESTADOS']) != 'null')) ? array_merge($campos, array('OSIPTEL_ESTADO_ID' => $_REQUEST['OSIPTEL_ESTADOS'])) : $campos;
$campos = ( isset($_REQUEST['COLOR']) && (($_REQUEST['COLOR']) != 'null')) ? array_merge($campos, array('COLOR_ID' => $_REQUEST['COLOR'])) : $campos;

$campos = ( isset($_REQUEST['ENTIDAD_ENTREGANTES']) && (($_REQUEST['ENTIDAD_ENTREGANTES']) != 'null')) ? array_merge($campos, array('ENTIDAD_ENTREGANTE_ID' => $_REQUEST['ENTIDAD_ENTREGANTES'])) : $campos;
$campos = ( isset($_REQUEST['MARCAS']) && (($_REQUEST['MARCAS']) != 'null')) ? array_merge($campos, array('MARCA_ID' => $_REQUEST['MARCAS'])) : $campos;
$campos = ( isset($_REQUEST['MODELOS']) && (($_REQUEST['MODELOS']) != 'null')) ? array_merge($campos, array('MODELO_ID' => $_REQUEST['MODELOS'])) : $campos;

$campos = ( isset($_REQUEST['CONSERVACION_ESTADO']) && (($_REQUEST['CONSERVACION_ESTADO']) != 'null')) ? array_merge($campos, array('CONSERVACION_ESTADO_ID' => $_REQUEST['CONSERVACION_ESTADO'])) : $campos;
$campos = ( isset($_REQUEST['OBSERVACION_INOPERATIVIDADES']) && (($_REQUEST['OBSERVACION_INOPERATIVIDADES']) != 'null')) ? array_merge($campos, array('OBSERVACION_INOPERATIVIDAD_ID' => $_REQUEST['OBSERVACION_INOPERATIVIDADES'])) : $campos;
$campos = ( isset($_REQUEST['CODIGO']) && (($_REQUEST['CODIGO']) != 'null')) ? array_merge($campos, array('CODIGO' => $_REQUEST['CODIGO'])) : $campos;
$campos = ( isset($_REQUEST['UBICACION_FISICA']) && (($_REQUEST['UBICACION_FISICA']) != 'null')) ? array_merge($campos, array('UBICACION_FISICA_ID' => $_REQUEST['UBICACION_FISICA'])) : $campos;
$condicion_imei_comparativa = ( isset($_REQUEST['IMEI_COMPARATIVA']) && (($_REQUEST['IMEI_COMPARATIVA']) != 'null')) ? $_REQUEST['IMEI_COMPARATIVA'] : '';

$campos = ( isset($_REQUEST['USUARIOS']) && (($_REQUEST['USUARIOS']) != 'null')) ? array_merge($campos, array('USUARIO_ID' => $_REQUEST['USUARIOS'])) : $campos;
$campos = ( isset($_REQUEST['USUARIOS_D']) && (($_REQUEST['USUARIOS_D']) != 'null')) ? array_merge($campos, array('EMPLEADO_DEVOLUCION' => $_REQUEST['USUARIOS_D'])) : $campos;

$condicion_fecha = '';
if(($_REQUEST['FECHA_INICIO'] != 'null') && ($_REQUEST['FECHA_FIN'] != 'null')) $condicion_fecha = "FECHA_INSERT BETWEEN TO_DATE ('".$_REQUEST['FECHA_INICIO']."', 'dd/mm/yyyy HH24:MI:SS') AND TO_DATE ('".$_REQUEST['FECHA_FIN']."', 'dd/mm/yyyy HH24:MI:SS')";

if ($_REQUEST['FECHA_MININTER'] != 'null'){
		$time = strtotime($_REQUEST['FECHA_MININTER']);
		$newformat = date('d/M/y',$time);
		$envio_mininte = $newformat;
}else{
		$envio_mininte = '';
}

require_once '../clases_personalizadas/Equipos.php';

$objEquipo = new Equipos();
$equipos = $objEquipo->lista(3,'',$campos, '', $condicion_fecha, $condicion_imei_comparativa,'',$envio_mininte);
$usuarios = $objEquipo->lista_usuarios();

//var_dump($equipos);exit;
//print_r("hola");exit;
/** Error reporting */
//print_r($equipos);exit;
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('A1', 'FILTRO_PERSONALIZADO')
						->setCellValue('A1', 'ALMACÉN')
            ->setCellValue('B1', 'ITEM')
            ->setCellValue('C1', 'IMEI_FISICO_PRINCIPAL')
            ->setCellValue('D1', 'CODIGO')
            ->setCellValue('E1', 'BACKUP')
            ->setCellValue('F1', 'UBICACIÓN_FÍSICA')
            ->setCellValue('G1', 'DEPARTAMENTO')
            ->setCellValue('H1', 'OPERADOR REPORTANTE')
            ->setCellValue('I1', 'OSIPTEL_ESTADO')
            ->setCellValue('J1', 'FECHA_REPORTE_OPERADOR')
            ->setCellValue('K1', 'FECHA_INGRESO_MININTER')
            ->setCellValue('L1', 'DIFERENCIA FECHAS')

            ->setCellValue('M1', 'MARCA')
            ->setCellValue('N1', 'MODELO')
            ->setCellValue('O1', 'COLOR')

            ->setCellValue('P1', 'IMEI_FISICO_1')
            ->setCellValue('Q1', 'IMEI_FISICO_2')
            ->setCellValue('R1', 'COINCIDENCIA_IMEI_FISICO')

            ->setCellValue('S1', 'IMEI_LOGICO_1')
            ->setCellValue('T1', 'IMEI_LOGICO_2')
            ->setCellValue('U1', 'COINCIDENCIA_IMEI_LOGICO')
            ->setCellValue('V1', 'IMEI COMPARATIVA')


            ->setCellValue('W1', 'ESTADO DE CONSERVACIÓN')
            ->setCellValue('X1', 'OBS. DEL ESTADO CONSERVACIÓN')

            ->setCellValue('Y1', 'ENTIDAD ENTREGANTE')
            ->setCellValue('Z1', 'TIPO DOCUMENTO')
            ->setCellValue('AA1', 'N. Documento')
            ->setCellValue('AB1', 'NOMBRES')
            ->setCellValue('AC1', 'SEXO ENTREGANTE')

            ->setCellValue('AD1', 'AÑO')
            ->setCellValue('AE1', 'TELÉFONO')
            ->setCellValue('AF1', 'DISTRITO')
            ->setCellValue('AG1', 'USUARIO')
            ->setCellValue('AH1', 'OPERADOR_PRIMER_ABONADO')
            ->setCellValue('AI1', 'ESTADO_OSIPTEL_PRIMER_ABONADO')
            ->setCellValue('AJ1', 'FECHA_REPORTE_PRIMER_ABONADO')
            ->setCellValue('AK1', 'HORA_REPORTE_PRIMER_ABONADO')

            ->setCellValue('AL1', 'MOTIVO EQUIPO')
            ->setCellValue('AM1', 'MOTIVO ENTREGANTE')
            ->setCellValue('AN1', 'FECHA REGISTRO')
						->setCellValue('AO1', 'FECHA ALMACENADO')

						->setCellValue('AP1', 'USUARIO DEVOLUCIÓN')
						->setCellValue('AQ1', 'FECHA DEVOLUCIÓN')

        ;

for ($i = 2; $i <= (count($equipos) + 1); $i++) {
    $imei_comparativa = '';
    if($equipos[$i-2]['IMEI_FISICO_1'] == $equipos[$i-2]['IMEI_LOGICO_1']) $imei_comparativa = 'COINCIDE' ;
    if(($equipos[$i-2]['IMEI_FISICO_1'] !=  "") && ($equipos[$i-2]['IMEI_LOGICO_1'] != '') && ($equipos[$i-2]['IMEI_FISICO_1'] != $equipos[$i-2]['IMEI_LOGICO_1'])) $imei_comparativa = 'NO COINCIDE';
    if(($equipos[$i-2]['IMEI_FISICO_1'] == "") OR ($equipos[$i-2]['IMEI_LOGICO_1'] == "")) $imei_comparativa = 'NULO';

		if($equipos[$i-2]['ESTADO_ALMACEN']==3){
			if($equipos[$i-2]['TIPO_DEVOLUCION']==1){
					 $valor = 'ENTREGADO';
			}else if($equipos[$i-2]['TIPO_DEVOLUCION']==2){
					 $valor = 'DERIVADO A PNP';
			}else{
					 $valor = 'OTROS';
			}
		}else{
			$valor = $equipos[$i-2]['CAJA'];
		}

		$empleado_devolucion = '';
		foreach($usuarios as $u){
			if($u['ID']==$equipos[$i-2]['EMPLEADO_DEVOLUCION']){
				$empleado_devolucion = $u['USUARIO'];
			}
		}

		if(isset($equipos[$i-2]['FECHA_ALMACENADO'])){
			$fecha_almacenado  = substr($equipos[$i-2]['FECHA_ALMACENADO'],0,10);
		}else{
			$fecha_almacenado = '';
		}

    $objPHPExcel->setActiveSheetIndex(0)
            //->setCellValue('A' . $i, '')
            ->setCellValue('A' . $i, $valor)
            ->setCellValue('B' . $i, $equipos[$i-2]['ITEM'])
            ->setCellValue('C' . $i, '')
            ->setCellValue('D' . $i, $equipos[$i-2]['CODIGO'])
            ->setCellValue('E' . $i, '')
            ->setCellValue('F' . $i, $equipos[$i-2]['UBICACION_FISICA'])
            ->setCellValue('G' . $i, $equipos[$i-2]['DEPARTAMENTO'])
            ->setCellValue('H' . $i, $equipos[$i-2]['OPERADOR'])
            ->setCellValue('I' . $i, $equipos[$i-2]['OSIPTEL_ESTADO'])
            ->setCellValue('J' . $i, $equipos[$i-2]['FECHA_REPORTE_OPERADOR'])
            ->setCellValue('K' . $i, $equipos[$i-2]['FECHA_INGRESO_MININTER'])
            ->setCellValue('L' . $i, $equipos[$i-2]['DIFERENCIA_EN_DIAS'])
            ->setCellValue('M' . $i, $equipos[$i-2]['MARCA'])
            ->setCellValue('N' . $i, $equipos[$i-2]['MODELO'])
            ->setCellValue('O' . $i, $equipos[$i-2]['COLOR'])

            ->setCellValue('P' . $i, $equipos[$i-2]['IMEI_FISICO_1'])
            ->setCellValue('Q' . $i, $equipos[$i-2]['IMEI_FISICO_2'])
            ->setCellValue('R' . $i, '')
            ->setCellValue('S' . $i, $equipos[$i-2]['IMEI_LOGICO_1'])
            ->setCellValue('T' . $i, $equipos[$i-2]['IMEI_LOGICO_2'])
            ->setCellValue('U' . $i, '')
            ->setCellValue('V' . $i, $imei_comparativa)

            ->setCellValue('W' . $i, $equipos[$i-2]['CONSERVACION_ESTADO'])
            ->setCellValue('X' . $i, $equipos[$i-2]['OBSERVACION_INOPERATIVIDAD'])

            ->setCellValue('Y' . $i, $equipos[$i-2]['ENTIDAD'])
            ->setCellValue('Z' . $i, $equipos[$i-2]['TIPO_DOCUMENTO'])
            ->setCellValue('AA' . $i, $equipos[$i-2]['NUMERO_DOCUMENTO'])

            ->setCellValue('AB' . $i, $equipos[$i-2]['NOMBRES'])
            ->setCellValue('AC' . $i, $equipos[$i-2]['SEXO'])

            ->setCellValue('AD' . $i, $equipos[$i-2]['ANIO'])
            ->setCellValue('AE' . $i, $equipos[$i-2]['TELEFONO'])
            ->setCellValue('AF' . $i, $equipos[$i-2]['DISTRITO'])
            ->setCellValue('AG' . $i, $equipos[$i-2]['USUARIO'])
            ->setCellValue('AH' . $i, '')
            ->setCellValue('AI' . $i, '')
            ->setCellValue('AJ' . $i, '')
            ->setCellValue('AK' . $i, '')

            ->setCellValue('AL' . $i, $equipos[$i-2]['MOTIVO_UPDATE_EQUIPO'])
            ->setCellValue('AM' . $i, $equipos[$i-2]['MOTIVO_UPDATE_ENTREGANTE'])
            ->setCellValue('AN' . $i, $equipos[$i-2]['FECHA_INSERT'])
						->setCellValue('AO' . $i, $fecha_almacenado)

						->setCellValue('AP' . $i, $empleado_devolucion)
						->setCellValue('AQ' . $i, $equipos[$i-2]['FECHA_DEVOLUCION'])
            ;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Equipos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
$objWriter->save('php://output');
exit;
