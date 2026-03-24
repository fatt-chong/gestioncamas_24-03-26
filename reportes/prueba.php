<?php error_reporting(1);
ini_set('post_max_size', '1024M'); 
ini_set('memory_limit', '1024M'); 
set_time_limit(0); 
//date_default_timezone_set('America/Santiago'); 
require_once('../../estandar/tcpdf/tcpdf.php');
require_once('../../estandar/tcpdf/config/lang/spa.php');
header('Content-Type: text/html; charset=utf-8');
// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true,'utf-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gestion de Camas');
$pdf->SetTitle('REPORTE EPICRISIS');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte');

// set default header data
$pdf->SetHeaderData('logo_informe3.jpg', PDF_HEADER_LOGO_WIDTH, 'HOSPITAL REGIONAL DE ARICA Y PARINACOTA', 'Gestión de Camas');

// set header and footer fonts
$pdf->setHeaderFont(Array('courier', '', 8));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 10, '', true);



function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
}
function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
}

// Variables
$cont_medicina_si = 0;
$cont_medicina_no = 0;
$cont_oncologia_si = 0;
$cont_oncologia_no = 0;
$cont_cirugia_si = 0;
$cont_cirugia_no = 0;
$cont_cirugia_ais_si = 0;
$cont_cirugia_ais_no = 0;
$cont_traumatologia_si = 0;
$cont_traumatologia_no = 0;
$cont_UCI_si = 0;
$cont_UCI_no = 0;
$cont_SAI_si = 0;
$cont_SAI_no = 0;
$cont_partos_si = 0;
$cont_partos_no = 0;
$cont_pediatria_si = 0;
$cont_pediatria_no = 0; 
$cont_neonatologia_si = 0;
$cont_neonatologia_no = 0; 
$cont_psiquiatria_si = 0;
$cont_psiquiatria_no = 0;
$cont_CMI_si = 0;
$cont_CMI_no = 0; 
$cont_6to_piso_si = 0; 
$cont_6to_piso_no = 0; 
$cont_puerperio_si = 0;
$cont_puerperio_no = 0;
$cont_ginecologia_si = 0;
$cont_ginecologia_no = 0;
$cont_embarazo_si = 0;
$cont_embarazo_no = 0;
$cont_pensionado_si = 0;
$cont_pensionado_no = 0;

$cont_medicina_barthel = 0;
$cont_oncologia_barthel = 0;
$cont_cirugia_barthel = 0;
$cont_cirugia_ais_barthel = 0;
$cont_traumatologia_barthel = 0;
$cont_UCI_barthel = 0;
$cont_SAI_barthel = 0;
$cont_partos_barthel = 0;
$cont_psiquiatria_barthel = 0;
$cont_CMI_barthel = 0;
$cont_6to_piso_barthel = 0; 
$cont_puerperio_barthel = 0;
$cont_ginecologia_barthel = 0;
$cont_embarazo_barthel = 0;
$cont_pensionado_barthel = 0;

$cont_medicina_barthel_corr = 0;
$cont_oncologia_barthel_corr = 0;
$cont_cirugia_barthel_corr = 0;
$cont_cirugia_ais_barthel_corr = 0;
$cont_traumatologia_barthel_corr = 0;
$cont_UCI_barthel_corr = 0;
$cont_SAI_barthel_corr = 0;
$cont_partos_barthel_corr = 0;
$cont_psiquiatria_barthel_corr = 0;
$cont_CMI_barthel_corr = 0;
$cont_6to_piso_barthel_corr = 0; 
$cont_puerperio_barthel_corr = 0;
$cont_ginecologia_barthel_corr = 0;
$cont_embarazo_barthel_corr = 0;
$cont_pensionado_barthel_corr = 0;


//$fechainicio = date("d-m-Y", time()-86400);
//$fechahasta = date("d-m-Y", time()-86400);
$fechainicio = $_GET['desde'];
$fechahasta = $_GET['hasta'];

//$fechainicio = cambiarFormatoFecha2($fechaD1);
//$fechahasta  = cambiarFormatoFecha2($fechaH1);
	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database'); 

$sql = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisisenf.epienfEstado) AS ESTADO,
IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS PERSONAL,
epicrisis.epicrisisenf.epienfBarthel,
epicrisis.epicrisisenf.epienfCond
FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.cta_cte = camas.hospitalizaciones.cta_cte
WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
		AND camas.hospitalizaciones.tipo_traslado > 100
		#AND camas.hospitalizaciones.tipo_traslado <> 107
		ORDER BY  camas.hospitalizaciones.fecha_egreso, SERVICIO  ASC";


	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql<br><br>".mysql_error());
	$rows= mysql_num_rows($query);	
	
	$sql_medicina = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 1
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_medicina = mysql_query($sql_medicina) or die("Error<br>$sql_medicina<br><br>".mysql_error());
	$rows_medicina = mysql_num_rows($query_medicina);
	if($rows_medicina){
		while($arr_medicina = mysql_fetch_array($query_medicina)){
			$medicina = $arr_medicina['servicio'];
			if($arr_medicina['IDEPICRISIS']){ $cont_medicina_si++; }
			if(!$arr_medicina['IDEPICRISIS']){ $cont_medicina_no++; }
			if($arr_medicina['epienfBarthel']){ $cont_medicina_barthel++;}
			if($arr_medicina['edad_paciente']>=60){ $cont_medicina_barthel_corr++; }
			
		}
	$por_medicina_si =  (($cont_medicina_si * 100)/($rows_medicina)); 	
	$por_medicina_no =  (($cont_medicina_no * 100)/($rows_medicina));
	}
	$sql_oncologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	
		IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 2
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_oncologia = mysql_query($sql_oncologia) or die("Error<br>$sql_oncologia<br><br>".mysql_error());
	$rows_oncologia = mysql_num_rows($query_oncologia);
	if($rows_oncologia){
		while($arr_oncologia = mysql_fetch_array($query_oncologia)){
			$oncologia = $arr_oncologia['servicio'];
			if($arr_oncologia['IDEPICRISIS']){ $cont_oncologia_si++; }
			if(!$arr_oncologia['IDEPICRISIS']){ $cont_oncologia_no++; }
			if($arr_oncologia['epienfBarthel']){ $cont_oncologia_barthel++; }
			if($arr_oncologia['edad_paciente']>=60){ $cont_oncologia_barthel_corr++; }
		}
	$por_oncologia_si =  (($cont_oncologia_si * 100)/($rows_oncologia));
	$por_oncologia_no =  (($cont_oncologia_no * 100)/($rows_oncologia));
	}
	$sql_cirugia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	
		IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 3
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia = mysql_query($sql_cirugia) or die("Error<br>$sql_cirugia<br><br>".mysql_error());
	$rows_cirugia = mysql_num_rows($query_cirugia);
	if($rows_cirugia){
		while($arr_cirugia = mysql_fetch_array($query_cirugia)){
			$cirugia = $arr_cirugia['servicio'];
			if($arr_cirugia['IDEPICRISIS']){ $cont_cirugia_si++; }
			if($arr_cirugia['epienfBarthel']){ $cont_cirugia_barthel++; }
			if($arr_cirugia['edad_paciente']>=60){ $cont_cirugia_barthel_corr++; }
			if(!$arr_cirugia['IDEPICRISIS']){ $cont_cirugia_no++; }
		}
		$por_cirugia_si =  (($cont_cirugia_si * 100)/($rows_cirugia));
		$por_cirugia_no =  (($cont_cirugia_no * 100)/($rows_cirugia)); 
	}
	$sql_cirugia_ais = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 4
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia_ais = mysql_query($sql_cirugia_ais) or die("Error<br>$sql_cirugia_ais<br><br>".mysql_error());
	$rows_cirugia_ais = mysql_num_rows($query_cirugia_ais);
	if($rows_cirugia_ais){
		while($arr_cirugia_ais = mysql_fetch_array($query_cirugia_ais)){
			$cirugia_ais = $arr_cirugia_ais['servicio'];
			if($arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_si++; }
			if($arr_cirugia_ais['epienfBarthel']){ $cont_cirugia_ais_barthel++; }
			if($arr_cirugia_ais['edad_paciente']>=60){ $cont_cirugia_ais_barthel_corr++; }
			if(!$arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_no++; }
		}
	$por_cirugia_ais_si =  (($cont_cirugia_ais_si * 100)/($rows_cirugia_ais)); 
	}
	$sql_traumatologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 5
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");

	$query_traumatologia = mysql_query($sql_traumatologia) or die("Error<br>$sql_traumatologia<br><br>".mysql_error());
	$rows_traumatologia = mysql_num_rows($query_traumatologia);
	if($rows_traumatologia){
		while($arr_traumatologia = mysql_fetch_array($query_traumatologia)){
			$traumatologia = $arr_traumatologia['servicio'];
			if($arr_traumatologia['IDEPICRISIS']){  $cont_traumatologia_si++; }
			if($arr_traumatologia['epienfBarthel']){ $cont_traumatologia_barthel++; }
			if($arr_traumatologia['edad_paciente']>=60){ $cont_traumatologia_barthel_corr++; }
			if(!$arr_traumatologia['IDEPICRISIS']){ $cont_traumatologia_no++; }
		}
		$por_traumatologia_si =  (($cont_traumatologia_si * 100)/($rows_traumatologia));
	}
	$sql_UCI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 8
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_UCI = mysql_query($sql_UCI) or die("Error<br>$sql_UCI<br><br>".mysql_error());
	$rows_UCI = mysql_num_rows($query_UCI);
	if($rows_UCI){
		while($arr_UCI = mysql_fetch_array($query_UCI)){
			$UCI = $arr_UCI['servicio'];
			if($arr_UCI['IDEPICRISIS']){  $cont_UCI_si++; }
			if($arr_UCI['epienfBarthel']){ $cont_UCI_barthel++; }
			if($arr_UCI['edad_paciente']>=60){ $cont_UCI_barthel_corr++; }
			if(!$arr_UCI['IDEPICRISIS']){ $cont_UCI_no++; }
		}
		$por_UCI_si =  (($cont_UCI_si * 100)/($rows_UCI));
		$por_UCI_no =  (($cont_UCI_no * 100)/($rows_UCI));
	}
	$sql_SAI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 9
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_SAI = mysql_query($sql_SAI) or die("Error<br>$sql_SAI<br><br>".mysql_error());
	$rows_SAI = mysql_num_rows($query_SAI);
	if($rows_SAI){
		while($arr_SAI = mysql_fetch_array($query_SAI)){
			$SAI = $arr_SAI['servicio'];
			if($arr_SAI['IDEPICRISIS']){  $cont_SAI_si++; }
			if($arr_SAI['epienfBarthel']){ $cont_SAI_barthel++; }
			if($arr_SAI['edad_paciente']>=60){ $cont_SAI_barthel_corr++; }
			if(!$arr_SAI['IDEPICRISIS']){ $cont_SAI_no++; }
		}
		$por_SAI_si =  (($cont_SAI_si * 100)/($rows_SAI));
	}
	$sql_partos = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
		CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 45
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_partos = mysql_query($sql_partos) or die("Error<br>$sql_partos<br><br>".mysql_error());
	$rows_partos = mysql_num_rows($query_partos);
	if($rows_partos){
		while($arr_partos = mysql_fetch_array($query_partos)){
			$partos = $arr_partos['servicio'];
			if($arr_partos['IDEPICRISIS']){  $cont_partos_si++; }
			if($arr_partos['epienfBarthel']){ $cont_partos_barthel++; }
			if($arr_partos['edad_paciente']>=60){ $cont_partos_barthel_corr++; }
			if(!$arr_partos['IDEPICRISIS']){ $cont_partos_no++; }
		}
	$por_partos_si =  (($cont_partos_si * 100)/($rows_partos));
	}
	
	$sql_pediatria = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,

	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 7
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pediatria = mysql_query($sql_pediatria) or die("Error<br>$sql_pediatria<br><br>".mysql_error());
	$rows_pediatria = mysql_num_rows($query_pediatria);
	if($rows_pediatria){
		while($arr_pediatria = mysql_fetch_array($query_pediatria)){
			$pediatria = $arr_pediatria['servicio'];
			if($arr_pediatria['ENFERMERA']){  $cont_pediatria_si++; }
			if(!$arr_pediatria['ENFERMERA']){ $cont_pediatria_no++; }
		}
	$por_pediatria_si =  (($cont_pediatria_si * 100)/($rows_pediatria));
	}
	
	$sql_neonatologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,

	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_neonatologia = mysql_query($sql_neonatologia) or die("Error<br>$sql_neonatologia<br><br>".mysql_error());
	$rows_neonatologia = mysql_num_rows($query_neonatologia);
	if($rows_neonatologia){
		while($arr_neonatologia = mysql_fetch_array($query_neonatologia)){
			$neonatologia = $arr_neonatologia['servicio'];
			if($arr_neonatologia['ENFERMERA']){  $cont_neonatologia_si++; }
			if(!$arr_neonatologia['ENFERMERA']){ $cont_neonatologia_no++; }
		}
	$por_neonatologia_si =  (($cont_neonatologia_si * 100)/($rows_neonatologia));
	}
	
	$sql_psiquiatria = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 12
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_psiquiatria = mysql_query($sql_psiquiatria) or die("Error<br>$sql_psiquiatria<br><br>".mysql_error());
	$rows_psiquiatria = mysql_num_rows($query_psiquiatria);
	if($rows_psiquiatria){
		while($arr_psiquiatria = mysql_fetch_array($query_psiquiatria)){
			$psiquiatria = $arr_psiquiatria['servicio'];
			if($arr_psiquiatria['IDEPICRISIS']){  $cont_psiquiatria_si++; }
			if($arr_psiquiatria['epienfBarthel']){ $cont_psiquiatria_barthel++; }
			if($arr_psiquiatria_corr['edad_paciente']>=60){ $cont_psiquiatria_barthel_corr++; }
			if(!$arr_psiquiatria['IDEPICRISIS']){ $cont_psiquiatria_no++; }
		}
	$por_psiquiatria_si =  (($cont_psiquiatria_si * 100)/($rows_psiquiatria));
	}
	
	$sql_CMI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14)  AND (camas.hospitalizaciones.nomSalaSN = 'CMI 3')
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_CMI = mysql_query($sql_CMI) or die("Error<br>$sql_CMI<br><br>".mysql_error());
	$rows_CMI = mysql_num_rows($query_CMI);
	if($rows_CMI){
		while($arr_CMI = mysql_fetch_array($query_CMI)){
			$CMI = $arr_CMI['servicio'];
			if($arr_CMI['IDEPICRISIS']){  $cont_CMI_si++; }
			if($arr_CMI['epienfBarthel']){ $cont_CMI_barthel++; }
			if($arr_CMI['edad_paciente']>=60){ $cont_CMI_barthel_corr++; }
			if(!$arr_CMI['IDEPICRISIS']){ $cont_CMI_no++; }
		}
	$por_CMI_si =  (($cont_CMI_si * 100)/($rows_CMI));
	}
	
	$sql_6to_piso = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_6to_piso = mysql_query($sql_6to_piso) or die("Error<br>$sql_6to_piso<br><br>".mysql_error());
	$rows_6to_piso = mysql_num_rows($query_6to_piso);
	if($rows_6to_piso){
		while($arr_6to_piso = mysql_fetch_array($query_6to_piso)){
			$sexto_piso = $arr_6to_piso['servicio'];
			if($arr_6to_piso['IDEPICRISIS']){  $cont_6to_piso_si++; }
			if($arr_6to_piso['epienfBarthel']){ $cont_6to_piso_barthel++; }
			if($arr_6to_piso['edad_paciente']>=60){ $cont_6to_piso_barthel_corr++; }
			if(!$arr_6to_piso['IDEPICRISIS']){ $cont_6to_piso_no++; }
		}
	$por_6to_piso_si =  (($cont_6to_piso_si * 100)/($rows_6to_piso));
	}
	
	$sql_puerperio = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 11
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_puerperio = mysql_query($sql_puerperio) or die("Error<br>$sql_puerperio<br><br>".mysql_error());
	$rows_puerperio = mysql_num_rows($query_puerperio);
	if($rows_puerperio){
		while($arr_puerperio = mysql_fetch_array($query_puerperio)){
			$puerperio = $arr_puerperio['servicio'];
			if($arr_puerperio['IDEPICRISIS']){  $cont_puerperio_si++; }
			if($arr_puerperio['epienfBarthel']){ $cont_puerperio_barthel++; }
			if($arr_puerperio['edad_paciente']>=60){ $cont_puerperio_barthel_corr++; }
			if(!$arr_puerperio['IDEPICRISIS']){ $cont_puerperio_no++; }
		}
	$por_puerperio_si =  (($cont_puerperio_si * 100)/($rows_puerperio));
	}
	
	$sql_ginecologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 10
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_ginecologia = mysql_query($sql_ginecologia) or die("Error<br>$sql_ginecologia<br><br>".mysql_error());
	$rows_ginecologia = mysql_num_rows($query_ginecologia);
	if($rows_ginecologia){
		while($arr_ginecologia = mysql_fetch_array($query_ginecologia)){
			$ginecologia = $arr_ginecologia['servicio'];
			if($arr_ginecologia['IDEPICRISIS']){  $cont_ginecologia_si++; }
			if($arr_ginecologia['epienfBarthel']){ $cont_ginecologia_barthel++; }
			if($arr_ginecologia['edad_paciente']>=60){ $cont_ginecologia_barthel_corr++; }
			if(!$arr_ginecologia['IDEPICRISIS']){ $cont_ginecologia_no++; }
		}
	$por_ginecologia_si =  (($cont_ginecologia_si * 100)/($rows_ginecologia));
	}
	
	$sql_embarazo = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 14
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_embarazo = mysql_query($sql_embarazo) or die("Error<br>$sql_embarazo<br><br>".mysql_error());
	$rows_embarazo = mysql_num_rows($query_embarazo);
	if($rows_embarazo){
		while($arr_embarazo = mysql_fetch_array($query_embarazo)){
			$puerperio = $arr_embarazo['servicio'];
			if($arr_embarazo['IDEPICRISIS']){  $cont_embarazo_si++; }
			if($arr_embarazo['epienfBarthel']){ $cont_embarazo_barthel++; }
			if($arr_embarazo['edad_paciente']>=60){ $cont_embarazo_barthel_corr++; }
			if(!$arr_embarazo['IDEPICRISIS']){ $cont_embarazo_no++; }
		}
	$por_embarazo_si =  (($cont_embarazo_si * 100)/($rows_embarazo));
	}
	//pensionado
	$sql_pensionado = "SELECT	 
	IF(epicrisis.epicrisisenf.epienfId IS NULL,	epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
	END AS SERVICIO,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 46
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pensionado = mysql_query($sql_pensionado) or die("Error<br>$sql_pensionado<br><br>".mysql_error());
	$rows_pensionado = mysql_num_rows($query_pensionado);
	if($rows_pensionado){
		while($arr_pensionado = mysql_fetch_array($query_pensionado)){
			$pensionado = $arr_pensionado['SERVICIO'];
			if($arr_pensionado['IDEPICRISIS']){  $cont_pensionado_si++; }
			if($arr_pensionado['epienfBarthel']){ $cont_pensionado_barthel++; }
			if($arr_pensionado['edad_paciente']>=60){ $cont_pensionado_barthel_corr++; }
			if(!$arr_pensionado['IDEPICRISIS']){ $cont_pensionado_no++; }
		}
	$por_pensionado_si =  (($cont_pensionado_si * 100)/($rows_pensionado));
	}
	
		$total_hospital = ($rows_medicina + $rows_oncologia + $rows_cirugia + $rows_cirugia_ais + $rows_traumatologia + $rows_UCI + $rows_SAI + $rows_partos + $rows_pediatria + $rows_neonatologia +$rows_psiquiatria + $rows_CMI + $rows_6to_piso + $rows_puerperio + $rows_ginecologia + $rows_embarazo + $rows_pensionado);
		$total_epi = ($cont_medicina_si + $cont_oncologia_si + $cont_cirugia_si + $cont_cirugia_ais_si + $cont_traumatologia_si + $cont_UCI_si + $cont_SAI_si + $cont_partos_si + $cont_pediatria_si + $cont_neonatologia_si + $cont_psiquiatria_si + $cont_CMI_si + $cont_6to_piso_si + $cont_puerperio_si + $cont_ginecologia_si + $cont_embarazo_si + $cont_pensionado_si );
		$por_cumplimiento =  (($total_epi * 100)/($total_hospital));

// Add a page
$pdf->AddPage();
// Set some content to print
$html = '<table  border="0" align="center" cellpadding="0" cellspacing="0"> 
<tr >
	  <td colspan="3"  align="center"><strong>REPORTE DIARIO <BR /> EPICRISIS ENFERMERIA</strong><br /><br />Fecha Reporte : '.date("d-m-Y - H:i").' Hrs.<br /> </td>
    </tr>
    <tr><td colspan="3" align="center" style="color:#4682b4; "><strong>CUMPLIMIENTO HOSPITAL<BR />&nbsp;&nbsp;EGRESOS:  '.$total_hospital.'&nbsp; | &nbsp;EPICRISIS: '.$total_epi.'&nbsp;= '.number_format($por_cumplimiento,1,",",".").' %</strong></td></tr> 
        <tr>
        <td colspan="3" align="left" style="font-size:20px;">*SE ENCONTRARON <strong>'.$rows.'</strong> REGISTROS</td>
      </tr>
                 <thead>
                      <tr  style="font:bold; background-color:#4682b4; color:#FFF; font-size:26px;">
                        <th width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>RUT</strong></th>
                        <th width="12%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>NOMBRE</strong></th>
                        <th width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>FICHA</strong></th>  
                        <th width="10%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>SERVICIO</strong></th>
                        <th width="6%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>FECHA<BR />INGRESO</strong></th>
                        <th width="6%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>FECHA<BR />EGRESO</strong></th>
                        <th width="4%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>DIAS EN<BR />SERV.</strong></th>
                        <th width="4%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>DIAS<BR />HOSP.</strong></th>
                        <th width="5%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>ID <br />EPICRISIS</strong></th>
                        <th width="8%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>USUARIO<BR>QUE EGRESA</strong></th>
                        <th width="20%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>EPICRISIS<BR />ENFERMERA</strong></th>
                        <th width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>BARTHEL</strong></th>
                        <th width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>EDAD</strong></th>
                        <th width="4%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>COND. EGRESO</strong></th>
                      </tr></thead>';
            

                     if($rows > 0){
                      while($arr_epi = mysql_fetch_array($query)){ 
                     $html.= ' <tr style="border-top-color:#4682b4; border-top-style:solid; font-size:24px; "> 
                        <td  width="5%" align="right" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.($arr_epi['rut_paciente']).'</td>
                        <td width="12%"  align="left" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;&nbsp;'.strtoupper($arr_epi['nom_paciente']).'</td>
                        <td  width="5%" align="right" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.($arr_epi['ficha_paciente']).'</td>
                        <td width="10%"  style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.strtoupper($arr_epi['SERVICIO']).'</td>
                        <td  width="6%"  align="right" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.cambiarFormatoFecha($arr_epi['fecha_ingreso']).'</td>
                        <td  width="6%"  align="right" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.cambiarFormatoFecha($arr_epi['fecha_egreso']).'</td>
                        <td width="4%"   align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.strtoupper($arr_epi['DIAS_EN_SERVICIO']).'</td>
                        <td  width="4%" align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.$arr_epi['DIAS_HOSPITALIZADO'].'</td>
                        <td  width="5%" align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.$arr_epi['IDEPICRISIS'].'</td>
                        <td  width="8%"  align="left" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;&nbsp;'.strtoupper($arr_epi['usuario_que_egresa']).'</td>
                        <td width="20%"  align="left" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.(strtoupper($arr_epi['PERSONAL'])).'</td>
                        <td width="5%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.(strtoupper($arr_epi['epienfBarthel'])).'</td>
                        <td width="5%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.(strtoupper($arr_epi['edad_paciente'])).'</td>
                        <td width="4%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.(strtoupper($arr_epi['epienfCond'])).'</td>
                     </tr>'; }  }else{ 
                     $html.='<tr><td colspan="15" style="border-bottom-color:#4682b4; border-bottom-style:solid; font:bold">No existen registros para el periodo seleccionado  '.$fechainicio.'</td></tr>';
					 }
                 
 $html.='</table> ';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// Add a page
$pdf->AddPage();

$html2 = '<table  border="0" align="center" cellpadding="0" cellspacing="0"> 
		<tr> <td colspan="2">&nbsp;</td></tr>
		<tr>
            <td align="center" >
                <table border="1" align="center" cellpadding="0" cellspacing="0" width="100%"> 
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >RESUMEN POR SERVICIO - MEDICINA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td  align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">MEDICINA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_medicina.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_medicina_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_medicina_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_medicina_barthel."/".$cont_medicina_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
             <td align="center">
                <table border="0" align="center" cellpadding="0" cellspacing="0"> 
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - ONCOLOGIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                       <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td  align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">ONCOLOGIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_oncologia.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_oncologia_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_oncologia_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_oncologia_barthel."/".$cont_oncologia_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - CIRUGIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">CIRUGIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_cirugia.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_cirugia_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_cirugia_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_cirugia_barthel."/".$cont_cirugia_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - CIRUGIA AISLAMIENTO</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">CIR. AIS</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_cirugia_ais.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_cirugia_ais_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_cirugia_ais_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_cirugia_ais_barthel."/".$cont_cirugia_ais_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - TRAUMATOLOGIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">TRAUMATOLOGIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_traumatologia.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_traumatologia_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_traumatologia_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_traumatologia_barthel."/".$cont_traumatologia_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - UCI</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px;" align="center">
                        <td align="left"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">UCI</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_UCI.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_UCI_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_UCI_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_UCI_barthel."/".$cont_UCI_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - SAI</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td  align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">SAI</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_SAI.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_SAI_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_SAI_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_SAI_barthel."/".$cont_SAI_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - PARTOS</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">PARTOS</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_partos.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_partos_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_partos_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_partos_barthel."/".$cont_partos_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
        </tr> 
		     <tr>
            <td colspan="2">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - PEDIATRIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td  align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">PEDIATRIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_pediatria.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_pediatria_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_pediatria_si,1,",",".").'</td>
                        
                      </tr>
                </table>
            </td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - NEONATOLOGIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="20%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">NEONATOLOGIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_neonatologia.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_neonatologia_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_neonatologia_si,1,",",".").'</td>
                        
                      </tr>
                </table>
            </td>
        </tr>   
		 <tr>
            <td colspan="3">&nbsp;</td>
        </tr>  
           <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - PSIQUIATRIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">PSIQUIATRIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_psiquiatria.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_psiquiatria_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_psiquiatria_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_psiquiatria_barthel."/".$cont_psiquiatria_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
             <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - CMI</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">CMI</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_CMI.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_CMI_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_CMI_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_CMI_barthel."/".$cont_CMI_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            </tr> 
			  <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - 6TO PISO</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">6TO PISO</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_6to_piso.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_6to_piso_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_6to_piso_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_6to_piso_barthel."/".$cont_6to_piso_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            
			<td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - PUERPERIO</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">PUERPERIO</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_puerperio.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_puerperio_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_puerperio_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_puerperio_barthel."/".$cont_puerperio_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            </tr>  
            <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - GINECOLOGIA</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">GINECOLOGIA</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_ginecologia.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_ginecologia_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_ginecologia_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_ginecologia_barthel."/".$cont_ginecologia_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            
			<td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - EMB. PATOLOGICO</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">EMB. PATOLOGICO</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_embarazo.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_embarazo_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_embarazo_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_embarazo_barthel."/".$cont_embarazo_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            </tr>    
			<tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="5" style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  id="title">RESUMEN POR SERVICIO - PENSIONADO</td>
                    </tr>
                      <tr style="background-color:#4682b4; color:#FFF;  font-size:26px;" align="center"  >
                        <td width="40%" style="border-top-color:#4682b4; border-top-style:solid;">SERVICIO</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">% EPICRISIS</td>
                        
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;">C/ BARTHEL</td>
                      </tr>
                      <tr style="background-color:#FFF; font-size:24px; " align="center">
                        <td align="left" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">PENSIONADO</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$rows_pensionado.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.$cont_pensionado_si.'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'.number_format($por_pensionado_si,1,",",".").'</td>
                        <td style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;">'. $cont_pensionado_barthel."/".$cont_pensionado_barthel_corr.'</td>
                      </tr>
                </table>
            </td>
            
			
            </tr>    
			</table>';

			
$pdf->writeHTML($html2, true, false, true, false, '');

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$fecha = date("d-m-Y", time()-86400);
$pdf->Output('Epicrisis_Enfermeria_'.$fecha.'.pdf','I');
