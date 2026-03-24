<?php 
error_reporting(1);
ini_set('post_max_size', '2024M'); 
ini_set('memory_limit', '2024M'); 
set_time_limit(0); 
// $buscaPDF = $_GET['buscaPDF'];
// $servicio_activo = $_GET['servicio_activo'];

$servicio = $_GET['servicio'];
$fecha_turno = $_GET['fecha_turno'];
$idTurno = $_GET['idTurno'];
$nomservicio = $_GET['nomservicio'];

//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/eng.php');

// create new PDF document
$pdf = new TCPDF('H', PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gestion de Camas');
$pdf->SetTitle('ENTREGA TURNO');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte');

// set default header data
$pdf->SetHeaderData('logo_informe2.jpg', PDF_HEADER_LOGO_WIDTH, 'HOSPITAL REGIONAL DE ARICA Y PARINACOTA', 'Gestión de Camas');

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 8));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(9, PDF_MARGIN_TOP, 9);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 7, '', true);


// Add a page
$pdf->AddPage();

function cambiarFormatoFecha($fecha){
	if($fecha=='')
		return $fecha;
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio;
}

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
} 


function ValidaDVRut($rut) { 

    $tur = strrev($rut); 
    $mult = 2; 

    for ($i = 0; $i <= strlen($tur); $i++) {  
       if ($mult > 7) $mult = 2;  
     
       $suma = $mult * substr($tur, $i, 1) + $suma; 
       $mult = $mult + 1; 
    } 
     
    $valor = 11 - ($suma % 11); 

    if ($valor == 11) {  
        $codigo_veri = "0"; 
      } elseif ($valor == 10) { 
        $codigo_veri = "k"; 
      } else {  
        $codigo_veri = $valor; 
    } 
  return $codigo_veri; 
} 
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");


function titulo($nombre){
	$nombreMay = ucwords(strtolower($nombre));
	return $nombreMay;
	}

function buscaMedico($medico){
	$sqlMedico = "SELECT
					medicos.medico
					FROM medicos
					WHERE id = '$medico'";
	$queryMedico = mysql_query($sqlMedico) or die($sqlMedico." Error al seleccionar medicos ".mysql_error());
	$arrayMedico = mysql_fetch_array($queryMedico);
	$nomMedico = $arrayMedico['medico'];
	return utf8_encode($nomMedico);
	}
//$idTurno = 	5;
if($idTurno){ // SI ID TURNO EXISTE!!!
$sqlTurno = "SELECT 
			entrega_turno.id_turno,
			entrega_turno.fecha_turno,
			entrega_turno.desde_fecha_turno,
			entrega_turno.hasta_fecha_turno,
			entrega_turno.desde_hora_turno,
			entrega_turno.hasta_hora_turno,
			entrega_turno.usuario_turno,
			entrega_turno.servicio_turno,
			entrega_turno.a_medico_turno,
			entrega_turno.de_medico_turno,
			entrega_turno.ingresos_turno,
			entrega_turno.egresos_turno,
			entrega_turno.detalle_turno
			FROM entrega_turno
			WHERE id_turno = '$idTurno'";
			
$queryTurno = mysql_query($sqlTurno) or die ($sqlTurno." Error al seleccionar Turno ".mysql_error());
$arrayTurno = mysql_fetch_array($queryTurno);


$desdeTurno = cambiarFormatoFecha($arrayTurno['desde_fecha_turno'])." ".$arrayTurno['desde_hora_turno'];
$hastaTurno = cambiarFormatoFecha($arrayTurno['hasta_fecha_turno'])." ".$arrayTurno['hasta_hora_turno'];
$a_medicoTurno = buscaMedico($arrayTurno[a_medico_turno]);
$de_medicoTurno = buscaMedico($arrayTurno[de_medico_turno]);
$ingresoTurno = $arrayTurno['ingresos_turno'];
$egresoTurno = $arrayTurno['egresos_turno'];
$detalleTurno = $arrayTurno['detalle_turno'];


  $sqlPacTurno = "SELECT
				camas.camas.sala,
				camas.camas.cama,
				camas.camas.cta_cte,
				camas.camas.procedencia,
				camas.turno_has_paciente.prev_turnopac,
				camas.turno_has_paciente.evento_turnopac,
				camas.turno_has_paciente.hosp_turnopac,
				camas.turno_has_paciente.ing_turnopac,
				camas.turno_has_paciente.edad_turnopac,
				camas.turno_has_paciente.talla_turnopac,
				camas.turno_has_paciente.peso_turnopac,
				camas.turno_has_paciente.pcp_turnopac,
				camas.turno_has_paciente.sc_turnopac,
				camas.turno_has_paciente.imc_turnopac,
				camas.turno_has_paciente.diagn_turnopac,
				camas.turno_has_paciente.bact_turnopac,
				camas.turno_has_paciente.planes_turnopac,
				camas.turno_has_paciente.diaupc_turnopac,
				camas.entrega_turno.id_turno,
				camas.entrega_turno.fecha_turno,
				paciente.paciente.rut,
				paciente.paciente.nombres,
				paciente.paciente.apellidopat,
				paciente.paciente.apellidomat,
				paciente.paciente.nroficha,
				paciente.paciente.sexo,
				paciente.paciente.fechanac,
				camas.turno_has_paciente.pac_turnopac
				FROM
				camas.turno_has_paciente
				INNER JOIN camas.entrega_turno ON camas.entrega_turno.id_turno = camas.turno_has_paciente.id_turno
				LEFT JOIN paciente.paciente ON camas.turno_has_paciente.pac_turnopac = paciente.paciente.id
				LEFT JOIN camas.camas ON camas.turno_has_paciente.pac_turnopac = camas.camas.id_paciente
				WHERE
				camas.turno_has_paciente.id_turno = '$idTurno'
				ORDER BY
				camas.camas.sala, camas.camas.cama ASC";
				
$queryPacTurno = mysql_query($sqlPacTurno) or die ($sqlPacTurno."<br/> Error al seleccionar detalle de turno<br/>" .mysql_error());

$i=0;
while($arrayPacTurno = mysql_fetch_array($queryPacTurno)){			
		$arr_turno[$i]['num_cama'] = $arrayPacTurno['sala']."<br>".$arrayPacTurno['cama'];
		$arr_turno[$i]['cta_cte'] = $arrayPacTurno['cta_cte'];
		$arr_turno[$i]['prev'] = $arrayPacTurno['prev_turnopac'];
		$arr_turno[$i]['evento'] = cambiarFormatoFecha($arrayPacTurno['evento_turnopac']);
		$arr_turno[$i]['hosp'] = cambiarFormatoFecha($arrayPacTurno['hosp_turnopac']);
		$arr_turno[$i]['ingreso'] = cambiarFormatoFecha($arrayPacTurno['ing_turnopac']);
		$arr_turno[$i]['edad'] = $arrayPacTurno['edad_turnopac'];
		$arr_turno[$i]['talla'] = $arrayPacTurno['talla_turnopac'];
		$arr_turno[$i]['peso'] = $arrayPacTurno['peso_turnopac'];
		$arr_turno[$i]['pcp'] = $arrayPacTurno['pcp_turnopac'];
		$arr_turno[$i]['sc'] = $arrayPacTurno['sc_turnopac'];
		$arr_turno[$i]['imc'] = $arrayPacTurno['imc_turnopac'];
		$arr_turno[$i]['diagnostico'] =  ($arrayPacTurno['diagn_turnopac']);
		$arr_turno[$i]['bacterio'] =   ($arrayPacTurno['bact_turnopac']);
		$arr_turno[$i]['planes'] =  ($arrayPacTurno['planes_turnopac']);
		$arr_turno[$i]['rut'] = $arrayPacTurno['rut']."-".ValidaDVRut($arrayPacTurno['rut']);
		$arr_turno[$i]['ficha'] = $arrayPacTurno['nroficha'];
		$arr_turno[$i]['nombre'] = utf8_encode(titulo(($arrayPacTurno['nombres'])." ".($arrayPacTurno['apellidopat'])." ".($arrayPacTurno['apellidomat'])));
		$arr_turno[$i]['sexo'] = $arrayPacTurno['sexo'];
		$arr_turno[$i]['procedencia'] = $arrayPacTurno['procedencia'];
		$arr_turno[$i]['idTurno'] = $arrayPacTurno['id_turno'];
		$arr_turno[$i]['fechaTurno'] = cambiarFormatoFecha($arrayPacTurno['fecha_turno']);
		$arr_turno[$i]['diaupc'] = $arrayPacTurno['diaupc_turnopac'];
		$arr_turno[$i]['fechanac'] = $arrayPacTurno['fechanac'];

$i++;	
}	
$cont_arr = count($arr_turno);	
$html='
<style>
	.titulo{
		font-family: helvetica;
		font-size: 9pt;
		color: black;
		font-weight: bold; 
		}
	
	td.first_td {
		border: 1px solid white;
		background-color: #CECECE;
		color: black;
	}
	td.second_td {
		border: 1px solid grey;
		color:#000;
	}
	td.third_td {
		border: 1px solid white;
		background-color: #999;
		color:#000;
	}
	
	td.four_td {
		border: 1px solid white;
		background-color: #DFDFDF;
		color:#000;
	}
	
	
</style>
';

$html.= '
<table border="0" > 
	<tr>
	    <td width="40%" class="titulo" align="center" colspan="2">ENTREGA TURNO<br />'.$nomservicio.' </td> 
   		<td width="30%" align="right">FECHA REPORTE: '.date("d-m-Y - H:i").' Hrs.</td>
		<td width="30%" align="right"> [ ING: <strong>'.$ingresoTurno.'</strong>&nbsp;&nbsp;EGR: <strong>'.$egresoTurno.'  ]</strong></td>
		</tr>
    <tr>
	
    	<td align="center">
        	<table width="100%" cellpadding="2" cellspacing="0" border="0">
            	<tr>
                	<td width="100" class="four_td" >Entrega:</td>
                    <td width="250" class="second_td" >'.$de_medicoTurno.'</td>
                    <td width="20" class="four_td" rowspan="2">a</td>
                    <td width="250" class="second_td">'.$a_medicoTurno.'</td>
                </tr>
                <tr>
                	<td class="four_td">Turno de:</td>
                    <td class="second_td">'.$desdeTurno.'</td>
                    <td class="second_td">'.$hastaTurno.' 24 horas</td>
                </tr>
                
			</table>
		
        </td>
	
    </tr> 
    <tr  >
		<td >
			<table cellpadding="4" cellspacing="3" border="0">
				<tr align="center">
					<td class="first_td" width="30"  >#</td>
					<td class="first_td" width="200" ><strong>Nombre Paciente</strong></td>
					<td class="first_td" width="100" ><strong>Antropometr&iacute;a</strong></td>  
					<td class="first_td" width="100" ><strong>Diagnostico</strong></td>
					<td class="first_td" width="80" ><strong>Bacter.</strong></td>
					<td class="first_td" width="100"><strong>Planes y problemas</strong></td>
				</tr>
			</table>
		</td>
	</tr>';
				$pdf->writeHTML($html, true, false, true, false, '');
					  $e = 0;
					  $a = 1;
					  $html = '';
						while($e <> $cont_arr){
						$html='
<style>
	.titulo{
		font-family: helvetica;
		font-size: 9pt;
		color: black;
		font-weight: bold; 
		}
	
	td.first_td {
		border: 1px solid white;
		background-color: #CECECE;
		color: black;
	}
	td.second_td {
		border: 1px solid grey;
		color:#000;
	}
	td.third_td {
		border: 1px solid white;
		background-color: #999;
		color:#000;
	}
	
	td.four_td {
		border: 1px solid white;
		background-color: #DFDFDF;
		color:#000;
	}
	
	
</style>
	<tr>
		</td>
			<table cellpadding="4" cellspacing="3" border="0">  
				 <tr>
						<td class="second_td" width="30">'.$arr_turno[$e][num_cama].'</td>
						<td class="second_td" width="200">
							<table border="0" cellpadding="1">
								<tr >
									<td class="titulo" colspan="4">'.$arr_turno[$e][nombre].'</td>
								</tr>
								<tr>
									<td width="45">RUT</td>
									<td width="70">'.$arr_turno[$e][rut].'</td>
                                    <td width="40">Cta Cte</td>
									<td width="40">'.$arr_turno[$e][cta_cte].'</td>
								</tr>
								<tr>
									<td>Nac</td>
									<td>'.cambiarFormatoFecha($arr_turno[$e][fechanac]).'</td>
                                    <td>Ficha</td>
									<td>'.$arr_turno[$e][ficha].'</td>
								</tr>
								<tr>
									<td >Previs</td>
									<td colspan="3">'.$arr_turno[$e][prev].'</td>
								</tr>
								<tr>
									<td>Viene de</td>
									<td colspan="3">'.$arr_turno[$e][procedencia].'</td>
								</tr>
								<tr>
									<td>Evento</td>
									<td colspan="3">'.$arr_turno[$e][evento].'</td>
								</tr>
								<tr>
									<td>Hospit</td>
									<td colspan="3">'.$arr_turno[$e][hosp].'</td>
								</tr>
								<tr>
									<td>Ing Ud</td>
									<td colspan="3">'.$arr_turno[$e][ingreso].'</td>
								</tr>
							</table>
						</td>
						<td class="second_td" width="100">
							<table border="0" cellpadding="1">
									<tr>
										<td>Sexo</td>
										<td>'.$arr_turno[$e][sexo].'</td>
										
									</tr>
									<tr>
										<td>Edad</td>
										<td>'.$arr_turno[$e][edad].' a&ntilde;os</td>
									</tr>
									<tr>
										<td>Talla</td>
										<td>'.$arr_turno[$e][talla].'</td>
									</tr>
									<tr>
										<td>Peso</td>
										<td>'.$arr_turno[$e][peso].'</td>
									</tr>
									<tr>
										<td>PCP</td>
										<td>'.$arr_turno[$e][pcp].'</td>
									</tr>
									<tr>
										<td>SC</td>
										<td>'.$arr_turno[$e][sc].'</td>
									</tr>
									<tr>
										<td>IMC</td>
										<td>'.$arr_turno[$e][imc].'</td>
									</tr>
									
									<tr>
										<td colspan="2">&nbsp;</td>
										
									</tr>
									<tr>
										<td colspan="2">'.$arr_turno[$e][diaupc].' dia '.$nomservicio.'</td>
										
									</tr>
							</table>
						</td>
						<td class="second_td" width="100">'.$arr_turno[$e][diagnostico].'</td>  
						<td class="second_td" width="80">'.$arr_turno[$e][bacterio].'</td>
						<td class="second_td" width="100">'.$arr_turno[$e][planes].'</td>
					</tr>
				</table>
			</td>
		</tr>
				  ';
				$pdf->writeHTML($html, true, false, true, false, '');
				$html = '';
				  $e++;
				  $a++;
				  $bandera++;
				}		
				  $html= '
<style>
	.titulo{
		font-family: helvetica;
		font-size: 9pt;
		color: black;
		font-weight: bold; 
		}
	
	td.first_td {
		border: 1px solid white;
		background-color: #CECECE;
		color: black;
	}
	td.second_td {
		border: 1px solid grey;
		color:#000;
	}
	td.third_td {
		border: 1px solid white;
		background-color: #999;
		color:#000;
	}
	
	td.four_td {
		border: 1px solid white;
		background-color: #DFDFDF;
		color:#000;
	}
	
	
</style>
	<tr>
		<td  >'.$detalleTurno.'</td>
	</tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');
$html = '';
}else{
	$html.= '
<table border="0" cellpadding="4" cellspacing="6"> 
	<tr>
	  <td class="titulo" align="center">'.$idTurno.'Se ha producido un error, el cual no permire generar el reporte<br />Fecha : '.date("d-m-Y - H:i").' Hrs. </td>
    </tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');
	}
// Print text using writeHTMLCell()


//$pdf->Image('../img/marcaAgua.png', 50, 160, 115, '', '', '', '', true, 300);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('entrega_turno'.date('Y').'.pdf','I');