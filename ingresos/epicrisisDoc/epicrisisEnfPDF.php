<?php session_start();
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);

$bd = $_SESSION['BD_SERVER'];
$usuario = $_SESSION['MM_RUNUSU'];
$usuario_nombre = $_SESSION['MM_UsernameName'];

$idEpicrisis = $_REQUEST['idEpicrisis'];
$vbarthel = $_REQUEST['vbarthel'];

$vbarthel = $_GET['vbarthel'];
$barthel = $_GET['barthel'];
$vbarthele = $_GET['vbarthele'];
$barthele = $_GET['barthele'];
$nomCR = $_GET['nomCR'];
$id_paciente = $_GET['id_paciente'];
$hospitaliza = $_GET['hospitaliza'];
$nombrePaciente = $_GET['nombrePaciente'];
$fichaPaciente = $_GET['fichaPaciente'];
$direccionPac = $_GET['direccionPac'];
$generoPaciente = $_GET['generoPaciente'];
$serv_paciente = $_GET['serv_paciente'];
$rutPaciente = $_GET['rutPaciente'];
$fechaNac = $_GET['fechaNac'];
$nacimiento = $_GET['nacimiento'];
$prevPaciente = $_GET['prevPaciente'];
$visualiza = $_GET['visualiza'];
$ctaCte = $_GET['ctaCte'];
$cama_sn = $_GET['cama_sn'];
$digitoR = $_GET['digitoR'];
$desde = $_GET['desde'];


//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/spa.php');

if($visualiza == 1){
	class MYPDF extends TCPDF {
		public function Header() {
			$bMargin = $this->getBreakMargin();
			$auto_page_break = $this->AutoPageBreak;
			$this->SetAutoPageBreak(false, 0);
			$img_file = K_PATH_IMAGES;
			$img_file.= 'marca.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
			$this->setPageMark();
		}
	}
}else{
	class MYPDF extends TCPDF {
		public function Header() {
			$bMargin = $this->getBreakMargin();
			$auto_page_break = $this->AutoPageBreak;
			$this->SetAutoPageBreak(false, 0);
			$img_file = K_PATH_IMAGES;
			$img_file.= 'no_marca.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
			$this->setPageMark();
		}
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Enfermeria');
$pdf->SetTitle('Epicrisis de Enfermeria');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Enfermeria');
$pdf->SetHeaderData('logo_informe2.jpg', PDF_HEADER_LOGO_WIDTH,'SERVICIO DE SALUD ARICA ','HOSPITAL REGIONAL DE ARICA Y PARINACOTA');
$pdf->setHeaderFont(Array('helvetica', '', 6));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 15);
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

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
}



$a=mysql_connect ($bd,'gestioncamas','123gestioncamas');
mysql_select_db('epicrisis',$a) or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");


$sqlInforme = "	SELECT * FROM epicrisisenf WHERE epienfId = $idEpicrisis";
$queryInforme = mysql_query($sqlInforme) or die ("ERROR AL CARGAR INFORMACION DEL INFORME<br> $sqlInforme <br>".mysql_error());
$resInforme = mysql_fetch_array($queryInforme);
mysql_select_db('rayos') or die('Cannot select database');

$sqlRayos = "SELECT DISTINCT
			rayos.examen.EXAcorrelativo,
			rayos.atencion.ATEfecha,
			paciente.prestacion.preNombre,
			rayos.examen.EXAinforme_estado,
			rayos.examen.EXTIcod,
			serv.nombre AS servicio,
			esp.nombre AS especialidad
			FROM rayos.atencion
			Left Join rayos.examen ON rayos.examen.ATEcorrelativo = rayos.atencion.ATEcorrelativo
			Left Join paciente.prestacion ON paciente.prestacion.preCod = rayos.examen.PREcod
			Inner Join acceso.servicio AS serv ON rayos.atencion.ATEservicio = serv.idservicio
			Inner Join acceso.servicio AS esp ON rayos.atencion.ATEespecialidad = esp.idservicio
			WHERE rayos.atencion.PACcta_cte = '$ctaCte'
			order by ATEfecha DESC";
			
$queryRayos = mysql_query($sqlRayos);
$e = 0;
while($arrayRayos = mysql_fetch_array($queryRayos)){
$arr_rayos[$e] = $arrayRayos['preNombre'];
$e++;
}
$contador_r = count($arr_rayos);
if ($contador_r == 0) { 
$arr_rayos[0] = 'NO EXISTEN EXAMENES ASOCIADOS'; 
$contador_r = 1;
}

mysql_select_db('epicrisis') or die('Cannot select database');
$sqlEduc = "SELECT
			educapac.educaNom
			FROM
			epienf_has_educapac
			INNER JOIN educapac ON epienf_has_educapac.educaId = educapac.educaId
			WHERE
			epienf_has_educapac.epienfId = $idEpicrisis";
$queryEduc = mysql_query($sqlEduc) or die ("ERROR AL CARGAR EDUCACIONES<br> $sqlInforme <br>".mysql_error());
$i = 0;
while($arrayEduc = mysql_fetch_array($queryEduc)){
$arr_ok[$i] = $arrayEduc['educaNom'];
$i++;
}
$contador = count($arr_ok);
if ($contador == 0) { 
$arr_ok[0] = 'No se realizo Educacion'; 
$contador = 1;
}


$fechaHoy = fecha(date('Y-m-d'));
$fechaIngreso = cambiarFormatoFecha2($resInforme['epienfFechaIng']);
$fechaEgreso = cambiarFormatoFecha2($resInforme['epienfFechaEgr']);
$diasEstadia = $resInforme['epienfDias'];
$destinoEpi = $resInforme['epienfDestino'];
$epiTraslado = $resInforme['epienfTraslado'];
$epiEgreso = $resInforme['epienfCond'];
$epiDiagnostico =  $resInforme['epienfCie10'];
$epiDetalle = $resInforme['epienfIndica'];
$epiHospDom = $resInforme['epienfHosdom'];
$epiHogar = $resInforme['epienfHogar'];
$epiHerida = $resInforme['epienfHerida'];
$epiPie = $resInforme['epienfPie'];
$epiMr = $resInforme['epienfMr'];
$epiEscaras = $resInforme['epienfEscara'];
$epiYeso = $resInforme['epienfYeso'];
$epiEnfermera = html_entity_decode($resInforme['epienfEnfermera']);

$epiDetalleTotal = html_entity_decode($epiDetalle);
$direccionPac = html_entity_decode($direccionPac);
$nombrePaciente = html_entity_decode($nombrePaciente);

$querydestino = "SELECT der_descripcion from camas.derivada where der_ctacte = '$ctaCte'";
  mysql_query("SET NAMES utf8");
  $querydestinor = mysql_query($querydestino) or die($sql." <br>ERROR AL OBTENER traederivacionesa<br>".mysql_error());
  $querydestinor = mysql_fetch_array($querydestinor);

switch($epiMr){
	case 0:
		$epiMr = "NO";
		break;
	case 1:
		$epiMr = "SI";
		break;
	
	}

//ASIGNA UN NOMBRE AL DESTINO DEL PACIENTE
switch($destinoEpi){
	case 1:
		$destinoEpi = "Domicilio";
		break;
	case 2:
		$destinoEpi = "Traslado";
		mysql_select_db('acceso') or die('Cannot select database');
		$sqlTraslado = mysql_query("SELECT 
									nombre
									FROM centro
									WHERE idcentro= $epiTraslado") or die("Error al seleccionar traslados ".mysql_error());
		$arrayTraslado = mysql_fetch_array($sqlTraslado);
		$epiTraslado = $arrayTraslado['nombre'];
		break;
	case 3:
		$destinoEpi = "CONIN";
		break;
	case 4:
		$destinoEpi = "Otro";
		mysql_select_db('epicrisis') or die('Cannot select database');
		$sqlTraslado = mysql_query("SELECT 
								hogarNom
								FROM hogares
								WHERE hogarId= $epiHogar") or die("Error al seleccionar hogares ".mysql_error());
		$arrayTraslado = mysql_fetch_array($sqlTraslado);
		$epiTraslado = $arrayTraslado['hogarNom'];
		break;
	case 5:
		$destinoEpi = "Anatomia Patologica";
		break;
	case 6:
		$destinoEpi = "Servicio Medico Legal";
		break;
	}
	

//SELECCIONA TIPO DE YESO SI CORRESPONDE
mysql_select_db('epicrisis') or die('Cannot select database');
if($epiYeso > 0){
	$sqlYeso = mysql_query("SELECT * 
				FROM tipoyeso
				WHERE yesoId = $epiYeso")or die("Error al seleccionar hogares ".mysql_error());
	$arrayYeso = mysql_fetch_array($sqlYeso);
	$tipoYeso = $arrayYeso['yesoNombre'];
	}else{
		$tipoYeso = "No Corresponde";
		}
		
//ASIGNA ESTADO DEL PACIENTE
switch($epiEgreso){
	case 'V':
	$epiEgreso = "Vivo";
	break;
	case 'F':
	$epiEgreso = "Muerto";
	break;	
	}
									
$fechaCom = html_entity_decode($fechaNac);
$indice_barthel = $barthel." ".$vbarthel;
$indice_barthele = $barthele." ".$vbarthele;


// Set some content to print
$html = '
<br />
<table width="700" border="0">
  
  <tr>
    <td width="30%" align="left"></td>
    <td align="center">&nbsp;</td>
    <td width="30%" align="right" style="font-size:9;">Arica, '.$fechaHoy.'<br/></td>
  </tr>
  <tr>
    
	<td colspan="3" align="center" style="font-size:10;">EPICRISIS DE ENFERMERIA '; 
		if($cama_sn == 1){
			$html.='<br />CAMAS INDIFERENCIADAS</td>';
			}else{
				$html.= ' CENTRO DE RESPONSABILIDAD<br />'.$nomCR.'</td>';
			}
		$html.='
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
                <td width="40%">'.$rutPaciente.'-'.$digitoR.'</td>
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
                <td><strong>Servicio:</strong></td>';
				if($cama_sn == 1){
					$html.='<td>Camas Indiferenciadas</td>';
					}else{
                		$html.='<td>'.$serv_paciente.'</td>';
					}
            $html.='</tr>
            
        </table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Antecedentes de Hospitalizacion</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:9;">
        	<tr>
            	<td width="19%"><strong>Fecha Ingreso:</strong></td>
                <td width="16%">'.$fechaIngreso.'</td>
                <td width="17%"><strong>Fecha Egreso:</strong></td>
                <td width="15%">'.$fechaEgreso.'</td>
                <td width="13%"><strong>Dias Estadia:</strong></td>
                <td width="20%">'.$diasEstadia.'</td>
            </tr>
            <tr>
            	<td><strong>Egreso:</strong></td>
                <td>'.$epiEgreso.'</td>
                <td><strong>Hosp. Domiciliaria:</strong></td>
                <td colspan="3">'.$epiHospDom.'</td>
                
            </tr>
            <tr>
            	<td><strong>Destino:</strong></td>
                <td colspan="4">'.$destinoEpi." ".$epiTraslado.'</td>
                
             </tr>';
        if($querydestinor[der_descripcion] != NULL OR $querydestinor[der_descripcion] != 0){
          $html.= '
            <tr>
              <td><strong>Destino a:</strong></td>
              <td colspan="3">'.$querydestinor[der_descripcion].'</td>
            </tr>';
        }
            $html.= '
            
            <tr>
            	<td><strong>Valor Herida:</strong></td>
                <td>'.$epiHerida.'</td>
                <td><strong>Valor Pie Diabetico:</strong></td>
                <td colspan="3">'.$epiPie.'</td>
                
            </tr>
            
            <tr>
            	<td><strong>Escaras:</strong></td>
                <td>'.$epiEscaras.'</td>
                <td><strong>Multiresistente:</strong></td>
                <td colspan="3">'.$epiMr.'</td>
                
            </tr>
            ';
          if($barthel <> "NULL"){
          $html.= 
          '  
          <tr>
          <td width="19%"><strong>Barthel Ingreso:</strong></td>
          <td>'.$indice_barthel.'</td>
          <td width="19%"><strong>Barthel Egreso:</strong></td>
          <td>'.$indice_barthele.'</td>
          </tr>';
          }
          $html.= '
            <tr>
            	<td><strong>Tipo Yeso:</strong></td>
                <td colspan="5">'.$tipoYeso.'</td>
                               
            </tr>
            
            <tr>
            	<td><strong>Diagnostico: </strong></td>
                <td colspan="5">'.$epiDiagnostico.'</td>
                
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Educaciones</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:9;">';
	$i = 0;
	while($i <> $contador)
	{
	$html.='<tr><td>'.$arr_ok[$i].'</td></tr>';
	$i++;
	}			              
            
    $html.= '</table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Indicaciones al Alta</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="12" colspan="3">
    
      <table width="100%">
        	<tr>
            	<td>'.$epiDetalle.'</td>
            </tr>
        </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Examenes de Rayos</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr>  
  <tr>
    <td height="12" colspan="3">
    
      <table width="100%" align="left" cellpadding="1" style="font-size:9;">';
	$e = 0;
	while($e <> $contador_r)
	{
	$html.='<tr><td>'.$arr_rayos[$e].'</td></tr>';
	$e++;
	}			              
            
    $html.= '</table>
    
    </td>
  </tr>  
    
  <tr>
	<td align="center" colspan="3">&nbsp;</td>  
  </tr>
  <tr height="3">
        <td align="center">'.$nomMedico.'</td>
        <td align="center" valign="bottom"></td>
        <td>&nbsp;</td>
  </tr>
  <tr height="3">
        <td align="center"><hr /></td>
        <td align="center" valign="bottom"></td>
        <td><hr /></td>
  </tr>
  <tr>
        <td align="center"><strong>Enfermera(o)</strong><br/>'.$epiEnfermera.'</td>
        <td align="center" valign="top"></td>
        <td align="center"><strong>Paciente o Familiar</strong></td>
  </tr>

</table>

';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('epicrisis_enf_'.$ctaCte.'_'.date('Y').'.pdf','FI');

DEFINE ('FTP_USER','epicrisisEnfermera'); 
DEFINE ('FTP_PASS','epicrisisEnfermera');
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
  ftp_put($conn_id, date('Y').'/epicrisis_enf_'.$ctaCte.'_'.date('Y').'.pdf', 'epicrisis_enf_'.$ctaCte.'_'.date('Y').'.pdf', FTP_BINARY);
  unlink('epicrisis_enf_'.$ctaCte.'_'.date('Y').'.pdf');
  @ftp_close($conn_id);
}