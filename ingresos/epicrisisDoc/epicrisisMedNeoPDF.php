<?php session_start();
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/spa.php');


	class MYPDF extends TCPDF {
		//Page header
		public function Header() {
	//		 get the current page break margin
			$bMargin = $this->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $this->AutoPageBreak;
			// disable auto-page-break
			$this->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = K_PATH_IMAGES;
			$img_file.= 'no_marca.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
	//		// set the starting point for the page content
			$this->setPageMark();
		}
	}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Medica');
$pdf->SetTitle('Epicrisis Medica');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Medica');

// set default header data
$pdf->SetHeaderData('logo_informe2.jpg', PDF_HEADER_LOGO_WIDTH,'SERVICIO DE SALUD ARICA ','HOSPITAL REGIONAL DE ARICA Y PARINACOTA');

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 6));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 9, '', true);

// Add a page
$pdf->AddPage();
//FORMATE DE FECHA A PALABRAS
function fecha($fecha){
$fe=explode("-",$fecha);
$di=$fe[2];
$me=$fe[1];
$an=$fe[0];
$me = mes($me);
$fec=$di." de ".$me." de ".$an;
return $fec;
}
function mes($mesi){
$mesi=$mesi-1;
$mes[0]="Enero"; $mes[6]="Julio";
$mes[1]="Febrero"; $mes[7]="Agosto";
$mes[2]="Marzo"; $mes[8]="Setiembre";
$mes[3]="Abril"; $mes[9]="Octubre";
$mes[4]="Mayo"; $mes[10]="Noviembre";
$mes[5]="Junio"; $mes[11]="Diciembre";
return $mes[$mesi];
}

//FUNCION QUE MUESTRA LA FECHA CORRECTAMENTE

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
}
//CONEXIONES A BD
$a=mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('epicrisis',$a) or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");

//CARGA LA INFORMACION DE LA EPICRISIS
$sqlInforme = "SELECT * FROM epicrisismedica WHERE epimedId = $idEpicrisis";
$queryInforme = mysql_query($sqlInforme) or die ("ERROR AL CARGAR INFORMACION DEL INFORME<br> $sqlInforme <br>".mysql_error());
$resInforme = mysql_fetch_array($queryInforme);

mysql_select_db('epicrisis') or die('Cannot select database');

//CREACION DE VARIABLES

$fechaHoy = fecha(date('Y-m-d'));

$fechaIngreso = cambiarFormatoFecha2($resInforme['epimedFechaIng']);
$fechaEgreso = cambiarFormatoFecha2($resInforme['epimedFechaEgr']);
$diasEstadia = $resInforme['epimedDias'];
$epiEgreso = $resInforme['epimedCond'];
$epiDiagnostico =  $resInforme['epimedDiag'];
$epiDiagnosticoOtro =  $resInforme['epimedODiagn'];
$epiEvolucion = $resInforme['epimedEvolucion'];
$epiIndica = $resInforme['epimedIndica'];
$epiIdMedico = $resInforme['epimedIdMedico'];
$epiPesoIn = explode('.',$resInforme['epimedPesoIn']);
$epiPesoEg = explode('.',$resInforme['epimedPesoEg']);
$epiApgar1 = $resInforme['epimedApgar1'];
$epiApgar5 = $resInforme['epimedApgar5'];
$epiMadre = $resInforme['epimedMadre'];
$epiMadrerut = $resInforme['epimedRutMadre'];
$epiVentila = $resInforme['epimedVent'];
$epiVentilaDias = $resInforme['epimedVentDias'];
$epiRNtipo = $resInforme['epimedRNtipo'];
$epiRNsem = $resInforme['epimedRNsem'];
$epiRNeg = $resInforme['epimedRNEG'];

$epiPesoIn = $epiPesoIn[0];
$epiPesoEg = $epiPesoEg[0];

$nombrePaciente = html_entity_decode($nombrePaciente);

//CONSULTA POR LOS CONTROLES GUARDADOS

$sqlControles = "SELECT
				control.id_control,
				control.nom_control,
				epimed_has_control.controlFecha
				FROM
				control
				INNER JOIN epimed_has_control ON control.id_control = epimed_has_control.controlTipo
				WHERE
				epimed_has_control.epimedId = '$idEpicrisis'";
$queryControles = mysql_query($sqlControles) or die ("ERROR AL SELECCIONAR CONTROLES ".mysql_error());

$i = 0;
while($rsControles = mysql_fetch_assoc($queryControles)){
	$arr_controles[$i]['nom_control'] = $rsControles['nom_control'];
	$arr_controles[$i]['controlFecha'] = $rsControles['controlFecha'];
	$i++;
	}
$contador_c = count($arr_controles);
$contador_c2 = count($arr_controles);
if ($contador_c == 0) { 
$arr_controles[0] = 'NO EXISTEN CONTROLES'; 
$contador_c = 1;
}

//SELECCIONA EL NOMBRE DEL MEDICO QUE REALIZO EPICRISIS
mysql_select_db('camas') or die('Cannot select database');

$sqlMedicos = "SELECT * FROM medicos WHERE id = $epiIdMedico";
$queryMedicos = mysql_query($sqlMedicos) or die ("ERROR AL SELECCIONAR MEDICOS ".mysql_error());
$arrayMedicos = mysql_fetch_array($queryMedicos);
$nomMedico = $arrayMedicos['medico'];

		
//ASIGNA ESTADO DEL PACIENTE
switch($epiEgreso){
	case 'V':
	$epiEgreso = "Vivo";
	break;
	case 'F':
	$epiEgreso = "Fallecido";
	break;	
	}

								
$fechaCom = html_entity_decode($fechaNac);

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

// Set some content to print

$html = '
<br />
<table width="700px" border="0">

  <tr>
    <td width="30%" align="left"></td>
    <td align="center">&nbsp;</td>
    <td width="30%" align="right" style="font-size:9;">Arica, '.$fechaHoy.'</td>
  </tr>
  <tr>
    
    <td colspan="3" align="center" style="font-size:10;">EPICRISIS MEDICA<br />'.$serv_paciente.'</td>
    
  </tr>
  
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Antecedentes</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td colspan="3" align="left" style="font-size:11;">
    
    	<table width="650px" cellpadding="1" style="font-size:9;">
        	<tr>
            	<td width="123px" ><strong>Nombre:</strong></td>
                <td width="224px" ><strong>'.$nombrePaciente.'</strong></td>
                <td><strong>Ficha:</strong></td>
                <td>'.$fichaPaciente.'</td>
                
                
            </tr>
            <tr>
            	<td ><strong>Edad: </strong></td>
                <td >'.$fechaNac.'</td>
                <td ><strong>Rut:</strong></td>
                <td >'.$rutPaciente.'-'.ValidaDVRut($rutPaciente).'</td>
                
            </tr>
            <tr>
            	<td ><strong>Genero:</strong></td>
                <td >'.$generoPaciente.'</td>
                <td><strong>Prevision:</strong></td>
                <td >'.$prevPaciente.'</td>
                
            </tr>
            
            <tr>
            	
                <td><strong>Madre:</strong></td>
                <td>'.$epiMadre.'</td>
                <td><strong>Rut Madre:</strong></td>
                <td>'.$epiMadrerut.'</td>
                
            </tr>
            <tr>
            	
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td colspan="3" align="left" style="font-size:11;">
    <table width="650px" align="left" cellpadding="2" style="font-size:9;">
        	<tr>
            	<td ><strong>Ingreso:</strong></td>
                <td >'.$fechaIngreso.'</td>
                <td ><strong>Egreso:</strong></td>
                <td >'.$fechaEgreso.'</td>
                <td ><strong>Dias Estadia:</strong></td>
                <td>'.$diasEstadia.'</td>
                
            </tr>
            <tr>
            	<td><strong>Peso Ingreso:</strong></td>
                <td valign="bottom" >'.$epiPesoIn.'</td>
                <td><strong>Peso Egreso:</strong></td>
                <td valign="bottom" >'.$epiPesoEg.'</td>
				
            </tr>
            
			<tr>
            	<td><strong>Condicion Egreso:</strong></td>
                <td valign="bottom">'.$epiEgreso.'</td>
                <td><strong>Vent. Mecanica:</strong></td>
                <td valign="bottom">'.$epiVentila.' '.$epiVentilaDias.' dias</td>
		
            </tr>
			<tr>
            	<td><strong>Apgar 1:</strong></td>
                <td valign="bottom">'.$epiApgar1.'</td>
                <td><strong>Apgar 5:</strong></td>
                <td valign="bottom">'.$epiApgar5.'</td>
		
            </tr>

        </table>
    </td>
  </tr>
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr>
  
  <tr>
  	<td colspan="3"><strong>Evolucion</strong></td>
  </tr>
  
  <tr>
  	<td colspan="3">'.$epiEvolucion.'</td>
  </tr>
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr>
  <tr>
  	<td colspan="3"><strong>Diagnostico</strong></td>
  </tr>
  
  <tr>
  	<td colspan="3">'.$epiRNtipo.' '.$epiRNsem.' '.$epiRNeg.'</td>
  </tr>
  <tr>
  	<td colspan="3">'.$epiDiagnostico.'</td>
  </tr>
  <tr>
  	<td colspan="3">'.$epiDiagnosticoOtro.'</td>
  </tr>
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
  	<td colspan="3"><strong>Indicaciones</strong></td>
  </tr>   
  
  <tr>
  	<td colspan="3">'.$epiIndica.'</td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr >
  	<td colspan="3"><strong>Controles</strong></td>
  </tr>
  
  <tr>  
    <td colspan="3">
    	
		<table cellpadding="3" align="left" border="1" style="font-size:9;">';
		$i = 0;
		while($i <> $contador_c)
		{
		$html.='<tr>
					<td>'.$arr_controles[$i]['nom_control'].'</td>
					<td>'.$arr_controles[$i]['controlFecha'].'</td>
				</tr>';
		$i++;
		}			              
				
		$html.= 
		'</table>
		
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
    
  <tr height="3">
        <td align="center">&nbsp;</td>
        <td align="center" valign="bottom">&nbsp;</td>
        <td>&nbsp;</td>
  </tr>
  <tr height="3">
        <td align="center"></td>

        <td align="center" valign="bottom"><hr /></td>
        <td></td>
  </tr>
  <tr>
        <td align="center">&nbsp;</td>
        <td align="center" valign="top"><strong>DOCTOR<br>'.$nomMedico.'</strong></td>
        <td>&nbsp;</td>
  </tr>

</table>
';
// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('epicrisis_med_'.$ctaCte.'_'.date('Y').'.pdf','FI');


DEFINE ('FTP_USER','epicrisisMedica'); 
DEFINE ('FTP_PASS','epicrisisMedica');
$ftp_server = $_SESSION['AR_SERVER'];
$path = date('Y');
        $path = explode("/",$path);
        $conn_id = @ftp_connect($ftp_server,21,1);
        if(!$conn_id) {
            return false;
        }
        if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {
            foreach ($path as $dir) {
                if(!$dir) {
                    continue;
                }
                $currPath.="/".trim($dir);
                if(!@ftp_chdir($conn_id,$currPath)) {
                    if(!@ftp_mkdir($conn_id,$currPath)) {
                        @ftp_close($conn_id);
                        return false;
                    }
                    @ftp_chmod($conn_id,0777,$currPath);
                }
            }
        }
        @ftp_close($conn_id);

$conn_id = ftp_connect($ftp_server, 21, 1); 
$login_result = ftp_login($conn_id, "epicrisisMedica", "epicrisisMedica");
ftp_put($conn_id, date('Y').'/epicrisis_med_'.$ctaCte.'_'.date('Y').'.pdf', 'epicrisis_med_'.$ctaCte.'_'.date('Y').'.pdf', FTP_BINARY);
unlink('epicrisis_med_'.$ctaCte.'_'.date('Y').'.pdf');
