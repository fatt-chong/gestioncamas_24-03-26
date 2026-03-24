<?php session_start();
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/spa.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Enfermeria');
$pdf->SetTitle('Epicrisis de Matroneria');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Matroneria');
$pdf->SetHeaderData('logo_informe2.jpg', PDF_HEADER_LOGO_WIDTH,'SERVICIO DE SALUD ARICA ','HOSPITAL REGIONAL DE ARICA Y PARINACOTA');
$pdf->setHeaderFont(Array('helvetica', '', 6));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 12);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 8, '', true);
$pdf->AddPage();

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
$sqlInforme = "	SELECT * FROM epicrisismatrona WHERE epimatId = $idEpicrisis";
$queryInforme = mysql_query($sqlInforme) or die ("ERROR AL CARGAR INFORMACION DEL INFORME<br> $sqlInforme <br>".mysql_error());
$resInforme = mysql_fetch_array($queryInforme);

mysql_select_db('epicrisis') or die('Cannot select database');
//CARGA LAS EDUCACIONES
$sqlEduc = "SELECT
			educapac.educaNom
			FROM
			epimat_has_educa
			INNER JOIN educapac ON epimat_has_educa.educaId = educapac.educaId
			WHERE
			epimat_has_educa.epimatId = $idEpicrisis";
$queryEduc = mysql_query($sqlEduc) or die ("ERROR AL CARGAR EDUCACIONES<br> $sqlInforme <br>".mysql_error());
$i = 0;
$educVacio = 0;
while($arrayEduc = mysql_fetch_array($queryEduc)){
$arr_ok[$i] = $arrayEduc['educaNom'];
$i++;
}
$contador = count($arr_ok);
if ($contador == 0) { 
$educVacio = 1;
$arr_ok[0] = 'No se realizaron Educaciones'; 
$contador = 1;
}

//CARGA LAS CONSEJERIAS
$sqlConsj = "SELECT
			consejerias.consejoDesc
			FROM
			epimat_has_consejo
			INNER JOIN consejerias ON epimat_has_consejo.consejoId = consejerias.consejoId
			WHERE
			epimat_has_consejo.epimatId = $idEpicrisis";
			
$queryConsj = mysql_query($sqlConsj) or die ("ERROR AL CARGAR CONSEJOS<br> $sqlConsj <br>".mysql_error());
$i = 0;
$consVacio = 0;
while($arrayConsj = mysql_fetch_array($queryConsj)){
$arr_ok2[$i] = $arrayConsj['consejoDesc'];
$i++;
}
$contador2 = count($arr_ok2);
if ($contador2 == 0) { 
$consVacio = 1;
$arr_ok2[0] = 'No se realizaron Consejerias'; 
$contador2 = 1;
}
//CREACION DE VARIABLES

$fechaHoy = fecha(date('Y-m-d'));

$fechaIngreso = cambiarFormatoFecha2($resInforme['epimatFechaIng']);
$fechaEgreso = cambiarFormatoFecha2($resInforme['epimatFechaEgr']);
$diasEstadia = $resInforme['epimatDias'];

$epiDiagnostico =  $resInforme['epimatDiagn'];
$epiInter = $resInforme['epimatInterv'];
$epiTipoParto = $resInforme['epimatTipoParto'];
$epiEpisio = $resInforme['epimatEpisio'];
$epiDesgarro = $resInforme['epimatDesg'];
$epiRN = $resInforme['epimatEstadorn'];
$epiHosprn = $resInforme['epimatHosprn'];
$epiMalrn = $resInforme['epimatMalrn'];
$epiMalrncausa = $resInforme['epimatMalrncausa'];
$epiInfec = $resInforme['epimatInfec'];
$epiMulti = $resInforme['epimatMulti'];
$destinoEpi = $resInforme['epimatDestino'];

$epiVdrl = $resInforme['epimatVdrl'];
$epiHema = $resInforme['epimatHema'];
$epiUro = $resInforme['epimatUro'];
$epiEndo = $resInforme['epimatEndo'];
$epiLoqui = $resInforme['epimatLoqui'];
$epiOtroex = $resInforme['epimatOtroexam'];
$epiExamen = $resInforme['epimatExamen'];
$epiPend = $resInforme['epimatPend'];
$epiPendexam = $resInforme['epimatPendexam'];

$epimatResp = $resInforme['epimatResp'];
$epimatRespNom = $resInforme['epimatRespNom'];

$epiDetalle = $resInforme['epimatIndica'];
$epiMatrona = html_entity_decode($resInforme['epimatMatrona']);
$epiIdparto = $resInforme['epimatIdparto'];


$epiDetalleTotal = html_entity_decode($epiDetalle);
$direccionPac = html_entity_decode($direccionPac);
$nombrePaciente = html_entity_decode($nombrePaciente);

//ESTADO DEL RECIEN NACIDO
switch($epiRN){
	case 'V':
		$epiRN = 'Vivo';
		break;
	case 'M':
		$epiRN = 'Mortinato';
		break;
	case 'N':
		$epiRN = 'Neomortinato';
		break;
	}

//TIPO DE PARTO	
switch($epiTipoParto){
	case 0:
		$epiTipoParto = 'No corresponde';
		break;
	case 1:
		$epiTipoParto = 'Cesarea';
		break;
	case 2:
		$epiTipoParto = 'Forcep';
		break;
	case 3:
		$epiTipoParto = 'Normal';
		break;
	}

//VERIFICA SI EL PACIENTE ES MULTIRESISTENTE
switch($epiMr){
	case 0:
		$epiMr = "NO";
		break;
	case 1:
		$epiMr = "SI";
		break;
	
	}

//VERIFICA SI EL PACIENTE ES MULTIRESISTENTE
switch($destinoEpi){
	case 1:
		$destinoEpi = "Domicilio";
		break;
	case 2:
		$destinoEpi = "Traslado";
		break;
	case 5:
		$destinoEpi = "Anatomia Patologica";
		break;
	
	}

$fechaCom = html_entity_decode($fechaNac);
$indice_barthel = $barthel." ".$vbarthel;
$indice_barthele = $barthele." ".$vbarthele;

$html = '
<br />
<table width="700" border="0">
  
  <tr>
    <td width="30%" align="left"></td>
    <td align="center">&nbsp;</td>
    <td width="30%" align="right" style="font-size:9;">Arica, '.$fechaHoy.'<br/></td>
  </tr>
  <tr>
    
	<td colspan="3" align="center" style="font-size:10;">EPICRISIS DE MATRONERIA CENTRO DE RESPONSABILIDAD<br />'.$nomCR.'</td>
  </tr>    
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Antecedentes Personales</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td colspan="3" align="left" style="font-size:11;">
    
    	<table width="100%" cellpadding="1" style="font-size:8;">
        	<tr>
            	<td width="14%"><strong>Nombre:</strong></td>
                <td width="33%">'.$nombrePaciente.'</td>
                <td width="13%"><strong>Rut:</strong></td>
                <td width="40%">'.$rutPaciente.'</td>
            </tr>
            <tr>
            	<td><strong>N de Ficha:</strong></td>
                <td>'.$fichaPaciente.'</td>
                <td><strong>Prevision:</strong></td>
                <td>'.$prevPaciente.'</td>
            </tr>
            <tr>
            	<td><strong>Direccion:</strong></td>
                <td>'.$direccionPac.'</td>
                <td><strong>Genero:</strong></td>
                <td>'.$generoPaciente.'</td>
            </tr>
            <tr>
            	<td><strong>Edad: </strong></td>
                <td>'.$fechaNac.'</td>
                <td><strong>Servicio:</strong></td>
				<td>'.$serv_paciente.'</td>
			</tr>
            <tr>
            	<td><strong>Fono: </strong></td>
                <td>'.$fonoCont.'</td>
                
			</tr>
            
        </table>
     
    </td>
  </tr>
  <tr>
  	<td colspan="3" height="2" valign="top"><hr /></td>
  </tr>  
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:8;">
        	<tr>
            	<td width="17%"><strong>Fecha Ingreso:</strong></td>
                <td width="19%">'.$fechaIngreso.'</td>
                <td width="18%"><strong>Fecha Egreso:</strong></td>
                <td width="14%">'.$fechaEgreso.'</td>
                <td width="15%"><strong>Dias Estadia:</strong></td>
                <td width="17%">'.$diasEstadia.'</td>
            </tr>
            <tr>
            	<td><strong>Diagnostico Egreso:</strong></td>
                <td colspan="5">'.$epiDiagnostico .'</td>
                
            </tr>
            <tr>
            	<td><strong>Intervencion:</strong></td>
                <td colspan="5">'.$epiInter .'</td>
                
            </tr>';
            if($epiIdparto > 0){
            $html.='
            
            <tr>
            	<td><strong>Tipo Parto:</strong></td>
                <td>'.$epiTipoParto .'</td>
                <td><strong>Episiotomia</strong></td>
                <td >'.$epiEpisio .'</td>
                <td><strong>Desgarros:</strong></td>
                <td >'.$epiDesgarro .'</td>
                
            </tr>
            
            <tr>
            	<td><strong>R. Nacido:</strong></td>
                <td>'.$epiRN.'</td>
                <td><strong>Hospitalizacion RN:</strong></td>
              	<td >'.$epiHosprn .'</td>
                   
            </tr>
            
            <tr>
            	<td><strong>Malformacion:</strong></td>
                <td >'.$epiMalrn .'</td>
                <td><strong>Detalle:</strong></td>
                <td>'.$epiMalrncausa.'</td>
            </tr>
            ';
            }
          if($barthel <> "NULL"){
          $html.= 
          '  
          <tr>
          <td width="19%"><strong>Barthel Ingreso:</strong></td>
          <td>'.$indice_barthel.'</td>
          <td width="19%"><strong>Barthel egreso:</strong></td>
          <td>'.$indice_barthele.'</td>
          </tr>';
          }
            $html.='
            <tr>
            	<td><strong>Infeccion:</strong></td>
                <td>'.$epiInfec .'</td>
                <td><strong>Multiresistente:</strong></td>
                <td>'.$epiMulti .'</td>
                               
            </tr>
            
            <tr>
            	<td><strong>Destino: </strong></td>
                <td colspan="5">'.$destinoEpi .'</td>
                
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
    <td height="2" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Examenes</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:8;">
        	<tr>
            	<td width="18%"><strong>VDRL:</strong></td>
                <td>'.$epiVdrl.'</td>
                <td width="18%"><strong>Hematocrito:</strong></td>
                <td>'.$epiHema.'</td>
                <td width="18%"><strong>Urocultivo:</strong></td>
                <td>'.$epiUro.'</td>
                
            </tr>
            <tr>
            	<td width="18%"><strong>C. Endocervical:</strong></td>
                <td>'.$epiEndo.'</td>
                <td width="18%"><strong>Loquiocultivo:</strong></td>
                <td>'.$epiLoqui.'</td>   
            </tr>
            <tr>
            	<td width="18%"><strong>Otros:</strong></td>
                <td>'.$epiOtroex.'</td>
                <td><strong>Pendientes:</strong></td>
                <td>'.$epiPend.'</td>
            </tr>
            ';
			if($epiOtroex == 'SI'){
			$html.='
            <tr>
            	<td colspan="6"><strong>'.$epiExamen.'</strong></td>   
            </tr>';
			} if($epiPend == 'SI'){
			$html.='
            <tr>
            	<td colspan="6"><strong>'.$epiPendexam.'</strong></td>   
            </tr>';
			}
            $html.='
        </table>
     
    </td>
  </tr>';
  if($educVacio == 0){
  $html.='
  <tr>
    <td height="2" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Educaciones</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:8;">';
	$i = 0;
	while($i <> $contador)
	{
	$html.='<tr><td>'.$arr_ok[$i].'</td></tr>';
	$i++;
	}			              
            
    $html.= '</table>
     
    </td>
  </tr>';
  }
  if($consVacio == 0){
  $html.='
  <tr>
    <td height="2" colspan="3">&nbsp;</td>
  </tr>		  
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Consejerias</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:8;">';
	$a = 0;
	while($a <> $contador2)
	{
	$html.='<tr><td>'.$arr_ok2[$a].'</td></tr>';
	$a++;
	}			              
            
    $html.= '</table>
     
    </td>
  </tr>';
  }
  $html.='
  <tr>
    <td height="2" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Indicaciones al alta</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="12" colspan="3">
    
      <table width="100%">
        	<tr>
            	<td>'.$epiDetalle .'</td>
            </tr>
        </table>
    
    </td>
  </tr>
      
  <tr>
	<td align="center" colspan="3">&nbsp;</td>  
  </tr>
  
  <tr height="3">
        <td align="center">&nbsp;</td>
        <td align="center" valign="bottom"></td>
        <td>&nbsp;</td>
  </tr>
  <tr height="3">
        <td align="center"><hr /></td>
        <td align="center" valign="bottom"></td>
        <td><hr /></td>
  </tr>
  <tr>
        <td align="center"><strong>Matron(a)</strong><br/>
          '.$epiMatrona.'</td>
        <td align="center" valign="top"></td>';
		if($epimatResp == 'paciente'){
        $html.='
		<td align="center"><strong>'.$nombrePaciente.'<br/></strong></td>';
		}else{
		$html.='
		<td align="center"><strong>'.$epimatRespNom .' ('.$epimatResp.')'.'<br/></strong></td>';	
			}
	$html.='		
  </tr>
  <tr>
  	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="3" style="font-size:8;">
    <strong>Importante: Si antes de su control en policlínico presenta molestias que Ud. estime como una complicación derivada de su operación, hospitalización o recien nacido, Ud. debe consultar inmediatamente en el Servicio de Urgencia de la Maternidad, presentando este documento.</strong>
    </td>
  </tr>
</table>

';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('epicrisis_mat_'.$ctaCte.'_'.date('Y').'.pdf','FI');

DEFINE ('FTP_USER','epicrisisMatrona'); 
DEFINE ('FTP_PASS','epicrisisMatrona');
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
        
$conn_id = @ftp_connect($ftp_server,21,1);
if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {
  ftp_put($conn_id, date('Y').'/epicrisis_mat_'.$ctaCte.'_'.date('Y').'.pdf', 'epicrisis_mat_'.$ctaCte.'_'.date('Y').'.pdf', FTP_BINARY);
  unlink('epicrisis_mat_'.$ctaCte.'_'.date('Y').'.pdf');
  @ftp_close($conn_id);
}