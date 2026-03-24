<?
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="hospitalizacionDomiciliaria_'.date('d-m-Y').'.xls"');
header('Cache-Control: max-age=0');
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '2G'); 
set_time_limit(0);
require_once('../../../estandar/PHPExcel/Classes/PHPExcel.php');   $objPHPExcel = new PHPExcel();


mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT
					camas.altaprecoz.nom_paciente,
					concat(camas.altaprecoz.rut_paciente,'-',if(ISNULL(paciente.paciente.dv),paciente.digitoVerificador(camas.altaprecoz.rut_paciente),paciente.paciente.dv)) AS run,
					camas.altaprecoz.prevision,
					paciente.paciente.direccion as 'direcci�n',
					camas.altaprecoz.fono1_paciente as 'Telefono',
					camas.altaprecoz.fecha_ingreso,
					camas.altaprecoz.medico as 'M�dico',
					camas.altaprecoz.procedencia,
					camas.altaprecoz.diagnostico1 as 'Pre-diagn�stico',
					camas.altaprecoz.diagnostico2 as 'Diagn�stico',
					if(camas.altaprecoz.movil_m=0,'N',concat('Si (M-',camas.altaprecoz.movil_m,')')) as 'Ma�ana',
					if(camas.altaprecoz.movil_t=0,'N',concat('Si (M-',camas.altaprecoz.movil_t,')')) as 'Tarde',
					if(camas.altaprecoz.movil_n=0,'N',concat('Si (M-',camas.altaprecoz.movil_n,')')) as 'Noche',
					if(camas.altaprecoz.movil_ma=0,'N',concat('Si (M-',camas.altaprecoz.movil_ma,')')) as 'Madrugada',
					CASE
					WHEN camas.altaprecoz.movil_m>0 and camas.altaprecoz.movil_n>0 and camas.altaprecoz.movil_t = 0 and camas.altaprecoz.movil_ma = 0 THEN 'C/12'
					WHEN camas.altaprecoz.movil_m>0 and camas.altaprecoz.movil_n>0 and camas.altaprecoz.movil_t > 0 and camas.altaprecoz.movil_ma = 0 THEN 'C/8'
					WHEN (if(camas.altaprecoz.movil_m>0,1,0) + if(camas.altaprecoz.movil_n>0,1,0) + if(camas.altaprecoz.movil_t > 0,1,0) + if(camas.altaprecoz.movil_ma > 0,1,0))=1 THEN 'C/24'
					WHEN (if(camas.altaprecoz.movil_m>0,1,0) + if(camas.altaprecoz.movil_n>0,1,0) + if(camas.altaprecoz.movil_t > 0,1,0) + if(camas.altaprecoz.movil_ma > 0,1,0))=4 THEN 'C/6'
					END
					AS 'Atenci�n'
					FROM camas.altaprecoz
					INNER JOIN paciente.paciente ON camas.altaprecoz.id_paciente = paciente.paciente.id") or die(mysql_error());

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Plataforma Web HJNC")
							 ->setLastModifiedBy("Plataforma Web HJNC")
							 ->setTitle("Hospitalizaci�n domiciliaria")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Excel Document")
							 ->setKeywords("HJNC")
							 ->setCategory("Hospitalizaci�n domiciliaria");	
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'FECHA:');
$objPHPExcel->getActiveSheet()->SetCellValue('N2', 'HORA');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', date('d-m-Y'));
$objPHPExcel->getActiveSheet()->SetCellValue('O2', date('H:m:s'));


$objPHPExcel->getActiveSheet()->getCell('A4')->setValue('HOSPITALIZACION DOMICILIARIA');
$objPHPExcel->getActiveSheet()->mergeCells('A4:O4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:O5');

$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("A4:O4")->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle("A5:O5")->applyFromArray($style);

$objPHPExcel->getActiveSheet()->getStyle('A7:O7')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getCell('A7')->setValue("Nombre paciente");$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getCell('B7')->setValue("R.U.N.");$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getCell('C7')->setValue("Prevision");$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getCell('D7')->setValue("Direccion");$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getCell('E7')->setValue("Telefono");$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('F7')->setValue("Fecha ingreso");$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('G7')->setValue("Medico");$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getCell('H7')->setValue("Procedencia");$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getCell('I7')->setValue("Pre-diagnostico");$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getCell('J7')->setValue("Diagnostico");$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getCell('K7')->setValue("Manana");$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('L7')->setValue("Tarde");$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('M7')->setValue("Noche");$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('N7')->setValue("Madrugada");$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getCell('O7')->setValue("Atencion");$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
//FIN DE CABECERAS Y TITULOS
$i=8;
// $j=1;
while($listado = mysql_fetch_array($query)){
// for ($p=0; $p<count($datosBIN); $p++) {
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $listado['nom_paciente']);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $listado['run']);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $listado['prevision']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $listado['direcci�n']);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $listado['Telefono']);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $listado['fecha_ingreso']);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $listado['M�dico']);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $listado['procedencia']);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $listado['Pre-diagn�stico']);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $listado['Diagn�stico']);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $listado['Ma�ana']);
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $listado['Tarde']);
	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $listado['Noche']);
	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $listado['Madrugada']);
	$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $listado['Atenci�n']);
	$i++;
	// $j++;
}
// $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setName('Logo');
// $objDrawing->setDescription('Logo');
// $objDrawing->setPath('../../../../../assets/img/logo_chile_hospital.png');
// $objDrawing->setHeight(80);
// $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->getActiveSheet()->setTitle('hospitalizaciondomiciliaria');
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');