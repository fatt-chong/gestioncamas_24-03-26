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
$pdf->SetTitle('REPORTE BARTHEL');
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


//$fechainicio = date("d-m-Y", time()-86400);
//$fechahasta = date("d-m-Y", time()-86400);
$fechainicio = $_GET['desde'];
$fechahasta = $_GET['hasta'];

$fechaBusca1 = $fechainicio." 00:00:00";
$fechaBusca2 = $fechahasta." 23:59:59";

//$fechainicio = cambiarFormatoFecha2($fechaD1);
//$fechahasta  = cambiarFormatoFecha2($fechaH1);
	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database'); 

/*
	$sql = "(SELECT 
			camas.rut_paciente, 
			camas.nom_paciente,
			camas.hospitalizado AS fecha,
			camas.barthel,
			date_format(camas.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '%Y') -
			(date_format(camas.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '00-%m-%d')) as edad, 
			camas.usuario_que_ingresa as usuario_ingresa,
			IF (camas.servicio is NOT NULL,'Camas','-') AS Desde, 
			camas.servicio as Servicio
			FROM camas 
			WHERE tipo_traslado IN (1,2) AND camas.edad_paciente >= 60
			AND (hospitalizado >='$fechaBusca1' and hospitalizado <='$fechaBusca2'))
			UNION
			(SELECT 
			listasn.rutPacienteSN, 
			listasn.nomPacienteSN,
			listasn.hospitalizadoSN, 
			listasn.barthelSN, 
			date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) AS edad, 
			NULL as usuario_ingresa,
			IF (listasn.desde_nomServSN is NOT NULL,'CMI','-') AS Desde, 
			listasn.desde_nomServSN as Servicio 
			FROM listasn 
			WHERE (listasn.hospitalizadoSN >='$fechaBusca1' and listasn.hospitalizadoSN <='$fechaBusca2') AND date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) >= 60)
			UNION
			(SELECT
			camas.hospitalizaciones.rut_paciente,
			camas.hospitalizaciones.nom_paciente,
			camas.hospitalizaciones.hospitalizado,
			camas.hospitalizaciones.barthel, 
			date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) as edad,
			camas.hospitalizaciones.usuario_que_ingresa,
			IF(hospitalizaciones.servicio is NOT NULL,'Hospitalizaciones','-') AS Desde, 
			hospitalizaciones.servicio as Servicio
			FROM
			camas.hospitalizaciones
			LEFT JOIN epicrisis.epicrisisenf ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisisenf.epienfCtacte
			WHERE
			(camas.hospitalizaciones.hospitalizado >='$fechaBusca1' and camas.hospitalizaciones.hospitalizado <='$fechaBusca2') AND tipo_traslado>100 AND date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) >= 60)
			UNION
			(SELECT 
			pensionado.camas.rutPensio,
			pensionado.camas.nombrePensio,
			pensionado.camas.hospPensio,
			pensionado.camas.barthelPensio,
			date_format(pensionado.camas.hospPensio, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '%Y') -
						(date_format(pensionado.camas.hospPensio, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '00-%m-%d')) as edad,
			pensionado.camas.usuarioPensio,
			'Pensionado',
			'Pensionado'
			FROM pensionado.camas
			WHERE (pensionado.camas.hospPensio >='$fechaBusca1' and pensionado.camas.hospPensio <='$fechaBusca2') AND pensionado.camas.edadPensio >= 60)
			ORDER BY nom_paciente ASC";
			*/
	$sql = "(SELECT 
			camas.rut_paciente, 
			camas.nom_paciente,
			camas.hospitalizado AS fecha,
			camas.barthel,
			camas.barthelegreso,
			date_format(camas.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '%Y') -
			(date_format(camas.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '00-%m-%d')) as edad, 
			camas.usuario_que_ingresa as usuario_ingresa,
			IF (camas.servicio is NOT NULL,'Camas','-') AS Desde, 
			camas.servicio as Servicio,
			'sin egreso' AS 'destino'
			FROM camas 
			WHERE tipo_traslado IN (1,2) AND camas.edad_paciente >= 60
			AND (hospitalizado >='$fechaBusca1' and hospitalizado <='$fechaBusca2'))
			UNION
			(SELECT 
			listasn.rutPacienteSN, 
			listasn.nomPacienteSN,
			listasn.hospitalizadoSN, 
			listasn.barthelSN,
			listasn.barthelegreso, 
			date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) AS edad, 
			NULL as usuario_ingresa,
			IF (listasn.desde_nomServSN is NOT NULL,'CMI','-') AS Desde, 
			listasn.desde_nomServSN as Servicio,
			'sin egreso' AS 'destino'
			FROM listasn 
			WHERE (listasn.hospitalizadoSN >='$fechaBusca1' and listasn.hospitalizadoSN <='$fechaBusca2') AND date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) >= 60)
			UNION
			(SELECT
			camas.hospitalizaciones.rut_paciente,
			camas.hospitalizaciones.nom_paciente,
			camas.hospitalizaciones.hospitalizado,
			camas.hospitalizaciones.barthel,
			camas.hospitalizaciones.barthelegreso, 
			date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) as edad,
			camas.hospitalizaciones.usuario_que_ingresa,
			IF(hospitalizaciones.servicio is NOT NULL,'Hospitalizaciones','-') AS Desde, 
			hospitalizaciones.servicio as Servicio,
			camas.hospitalizaciones.destino
			FROM
			camas.hospitalizaciones
			LEFT JOIN epicrisis.epicrisisenf ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisisenf.epienfCtacte
			WHERE
			(camas.hospitalizaciones.hospitalizado >='$fechaBusca1' and camas.hospitalizaciones.hospitalizado <='$fechaBusca2') AND tipo_traslado>100 AND date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) >= 60)
			UNION
			(SELECT 
			pensionado.camas.rutPensio,
			pensionado.camas.nombrePensio,
			pensionado.camas.hospPensio,
			pensionado.camas.barthelPensio,
			pensionado.camas.barthelPensioEgreso,
			date_format(pensionado.camas.hospPensio, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '%Y') -
						(date_format(pensionado.camas.hospPensio, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '00-%m-%d')) as edad,
			pensionado.camas.usuarioPensio,
			'Pensionado',
			'Pensionado',
			'sin egreso' AS 'destino'
			FROM pensionado.camas
			WHERE (pensionado.camas.hospPensio >='$fechaBusca1' and pensionado.camas.hospPensio <='$fechaBusca2') AND pensionado.camas.edadPensio >= 60)
			ORDER BY nom_paciente ASC";
	
	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql_barthel Ingreso<br><br>".mysql_error());
	$rows = mysql_num_rows($query);


// Add a page
$pdf->AddPage();
// Set some content to print
$html = '
<table  border="0" align="center" cellpadding="0" cellspacing="0" width="100%"> 
<tr >
	  <td colspan="3"  align="center"><strong>REPORTE DIARIO <BR />
	  INDICE BARTHEL AL INGRESO</strong><br />
	  <br />Fecha Reporte : '.date("d-m-Y - H:i").' Hrs.<br /> </td>
    </tr>
	<tr>
		<td colspan="3" align="left" style="font-size:20px;">*SE ENCONTRARON <strong>'.$rows.'</strong> REGISTROS</td>
	</tr>
			  <tr  style="font:bold; background-color:#4682b4; color:#FFF; font-size:26px;" align="center">
				<td width="8%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>RUT</strong></td>
				<td width="14%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>NOMBRE</strong></td>
				
				<td width="10%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>SERVICIO</strong></td>
				<td width="12%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>FECHA<BR />INGRESO</strong></td>
				<td width="18%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>USUARIO<br />QUE INGRESA</strong></td>
				<td width="8%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>BARTHEL Ingreso</strong></td>
				<td width="8%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>BARTHEL Egreso</strong></td>
				<td width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>EDAD</strong></td>
				<td width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>Condicion</strong></td>
				
			  </tr>';

		 if($rows > 0){
		  while($arr_barthel = mysql_fetch_array($query)){ 
		  if($arr_barthel['Desde']=='CMI'){
			  $n_barthel = $arr_barthel['Servicio']."(CMI)";
			  }else{
				  $n_barthel = $arr_barthel['Servicio'];
				  }
			if($arr_barthel['destino']=="Defuncion"){
				$bartelegreso="F";
			}else{
				$bartelegreso=$arr_barthel['barthelegreso'];
			}	  
$html.= ' <tr style="border-top-color:#4682b4; border-top-style:solid; font-size:24px; "> 
			<td  width="8%" align="left" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.$arr_barthel['rut_paciente'].'</td>
			<td width="14%"  align="left" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;&nbsp;'.strtoupper($arr_barthel['nom_paciente']).'</td>
			<td  width="10%" align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.strtoupper($n_barthel).'</td>
			
			<td  width="12%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">'.cambiarFormatoFecha($arr_barthel['fecha']).'</td>
			<td width="18%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.(strtoupper($arr_barthel['usuario_ingresa'])).'</td>
			<td width="8%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.$arr_barthel['barthel'].'</td>
			<td width="8%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.$bartelegreso.'</td>
			<td width="5%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.$arr_barthel['edad'].'</td>
			<td width="5%"  align="center" style="border-bottom-color:#4682b4; border-bottom-style:solid;">&nbsp;'.$arr_barthel['destino'].'</td>
		 </tr>'; }  }else{ 
		 $html.='<tr><td colspan="15" style="border-bottom-color:#4682b4; border-bottom-style:solid; font:bold">No existen registros para el periodo seleccionado  '.$fechainicio.'</td></tr>';
		 }
	 
$html.='</table> ';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$fecha = date("d-m-Y", time()-86400);
$pdf->Output('Barthel_ingreso_'.$fecha.'.pdf','I');
