<?php session_start();
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/spa.php');

if($visualiza == 1){
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
			$img_file.= 'marca.jpg';
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
	//		// set the starting point for the page content
			$this->setPageMark();
		}
	}
}else{
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
	}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Enfermeria');
$pdf->SetTitle('Epicrisis de Enfermeria');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Enfermeria');

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
$pdf->SetFont('helvetica', '', 8, '', true);

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
$sqlInforme = "	SELECT * FROM epicrisisenf WHERE epienfId = $idEpicrisis";
$queryInforme = mysql_query($sqlInforme) or die ("ERROR AL CARGAR INFORMACION DEL INFORME<br> $sqlInforme <br>".mysql_error());
$resInforme = mysql_fetch_array($queryInforme);

//OBTIENE INFORMACION DE LOS EXAMENES DE AP
mysql_select_db('anatomia') or die('Cannot select database');

$sqlAnato = "SELECT
			anatomia.controlanatomiadetalle.regAOrganos,
			anatomia.controlanatomiadetalle.preCod2,
			paciente.prestacion.preCod,
			paciente.prestacion.preNombre,
			paciente.organos.orgdescripcion
			FROM
			anatomia.controlanatomiadetalle
			INNER JOIN anatomia.controlanatomia ON anatomia.controlanatomia.regAId = anatomia.controlanatomiadetalle.regAId
			INNER JOIN paciente.prestacion ON anatomia.controlanatomiadetalle.preCod2 = paciente.prestacion.preCod
			INNER JOIN paciente.organos ON anatomia.controlanatomiadetalle.regAOrganos = paciente.organos.orgId
			WHERE
			anatomia.controlanatomia.regAtipoExamen = 'B' AND
			anatomia.controlanatomia.pacId = '$id_paciente' AND
			anatomia.controlanatomia.regAFechaRecepcion >= '$hospitaliza'";
			
$queryAnato = mysql_query($sqlAnato) or die ("ERROR AL SELECCIONAR EXAMENES DE ANATOMIA ".mysql_error());

$e = 0;
while($arrayAnato = mysql_fetch_array($queryAnato)){
$arrayPres[$e] = $arrayAnato['preNombre'];
$arrayOrg[$e] = $arrayAnato['orgdescripcion'];
$e++;
}
$contador_a = count($arrayPres);
$muestra_1 = 0;
if ($contador_a == 0) { 
$arrayAnato[0] = 'NO EXISTEN EXAMENES ASOCIADOS';
$muestra_1 = 1; 
$contador_a = 1;
}

//SELECCIONA LOS EXAMENES DE RAYOS REALIZADOS
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
			WHERE rayos.atencion.PACid = '$id_paciente' and ATEfecha >= '$hospitaliza'
			order by ATEfecha DESC";
			
$queryRayos = mysql_query($sqlRayos);

$e = 0;
while($arrayRayos = mysql_fetch_array($queryRayos)){
$arr_rayos[$e] = $arrayRayos['preNombre'];
$e++;
}
$contador_r = count($arr_rayos);
$muestra = 0;
if ($contador_r == 0) { 
$arr_rayos[0] = 'NO EXISTEN EXAMENES ASOCIADOS';
$muestra = 1; 
$contador_r = 1;
}

mysql_select_db('epicrisis') or die('Cannot select database');

//CARGA LAS EDUCACIONES
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

//CARGA LOS AUTOCUIDADO
$sqlAuto = "SELECT DISTINCT
			autocuidado.cuidadoNom,
			autocuidado.cuidadoId
			FROM
			epienf_has_autocuidado
			INNER JOIN autocuidado ON epienf_has_autocuidado.cuidadoId = autocuidado.cuidadoId
			WHERE
			epienf_has_autocuidado.epienfId = $idEpicrisis";
			
$queryAuto = mysql_query($sqlAuto) or die ("ERROR AL CARGAR AUTOCUIDADOS <br> $sqlInforme <br>".mysql_error());
$i = 0;
while($arrayAuto = mysql_fetch_array($queryAuto)){
$arr_au[$i] = $arrayAuto['cuidadoNom'];
$arr_au2[$i] = $arrayAuto['cuidadoId'];
$i++;
}
$contador_au = count($arr_au);
if ($contador_au == 0) { 
$arr_au[0] = 'No se realizaron Autocuidados'; 
$contador_au = 1;
}

//CARGA LAS PLANIFICACIONES
$sqlPlan = "SELECT DISTINCT
			planificacion.planNom,
			planificacion.planId
			FROM
			epienf_has_planificacion
			INNER JOIN planificacion ON epienf_has_planificacion.planId = planificacion.planId
			WHERE
			epienf_has_planificacion.epienfId = $idEpicrisis";
			
$queryPlan = mysql_query($sqlPlan) or die ("ERROR AL CARGAR PLANIFICACIONES <br> $sqlPlan <br>".mysql_error());
$i = 0;
while($arrayPlan = mysql_fetch_array($queryPlan)){
$arr_pl[$i] = $arrayPlan['planNom'];
$arr_pl2[$i] = $arrayPlan['planId'];
$i++;
}
$contador_pl = count($arr_pl);
if ($contador_pl == 0) { 
$arr_pl[0] = 'No se realizaron Planificaciones'; 
$contador_pl = 1;
}
//CREACION DE VARIABLES

$fechaHoy = fecha(date('Y-m-d'));

$fechaIngreso = cambiarFormatoFecha2($resInforme['epienfFechaIng']);
$fechaEgreso = cambiarFormatoFecha2($resInforme['epienfFechaEgr']);
$diasEstadia = $resInforme['epienfDias'];
$destinoEpi = $resInforme['epienfDestino'];
$epiTraslado = $resInforme['epienfTraslado'];
$epiEgreso = $resInforme['epienfCond'];
$epiDiagnostico =  $resInforme['epienfCie10'];
$epiDeriva =  $resInforme['epienfDerivado'];
$epiDetalle = $resInforme['epienfIndica'];
$epiHospDom = $resInforme['epienfHosdom'];
$epiHogar = $resInforme['epienfHogar'];
$epiHerida = $resInforme['epienfHerida'];
$epiPie = $resInforme['epienfPie'];
$epiMr = $resInforme['epienfMr'];
$epiEscaras = $resInforme['epienfEscara'];
$epiYeso = $resInforme['epienfYeso'];
$epiEnfermera = html_entity_decode($resInforme['epienfEnfermera']);
$epiResp = $resInforme['epienfResp'];
$epiRespNom = $resInforme['epienfRespNom'];
$epiRespRut = $resInforme['epienfRespRut'];

//$servicio_paciente = html_entity_decode($serv_paciente, ENT_NOQUOTES, 'UTF-8');
$epiDetalleTotal = html_entity_decode($epiDetalle);
$direccionPac = html_entity_decode($direccionPac);
$nombrePaciente = html_entity_decode($nombrePaciente);

//SELECCIONA EL NOMBRE DE LAS DERIVACIONES
$sqlDeriva = "SELECT * FROM derivaciones WHERE derivadoId = $epiDeriva";
$queryDeriva = mysql_query($sqlDeriva)or die("ERROR AL SELECCIONAR LAS DERIVACIONES ".mysql_error());
$arrayDeriva = mysql_fetch_array($queryDeriva);

$nombreDeriva = $arrayDeriva['derivadoNom'];

//SELECCIONA EL NOMBRE DEL CIE10
//mysql_select_db('cie10',$a) or die('Cannot select database');
//
//$sqlCie = mysql_query("SELECT nomcompletoCIE FROM cie10 WHERE codigoCIE = '$epiDiagnostico'") or die("Error al seleccionar CIE 10 ".mysql_error());
//$arrayCie = mysql_fetch_array($sqlCie);
//$nombreCie = $arrayCie['nomcompletoCIE'];

//VERIFICA SI EL PACIENTE ES MULTIRESISTENTE
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

if($epiTraslado == 0){
	
	$epiTraslado = "";
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
    
    <td colspan="3" align="center" style="font-size:10;">EPICRISIS DE ENFERMERIA CENTRO DE RESPONSABILIDAD<br />'.$nomCR.'</td>
    
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
    
    	<table width="100%" cellpadding="1" style="font-size:9;">
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
                <td colspan="3">'.$epiFono.'</td>
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Epicrisis de Enfermeria</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:9;">
        	<tr>
            	<td width="17%"><strong>Fecha Ingreso:</strong></td>
                <td width="19%">'.$fechaIngreso.'</td>
                <td width="18%"><strong>Fecha Egreso:</strong></td>
                <td width="14%">'.$fechaEgreso.'</td>
                <td width="15%"><strong>Dias Estadia:</strong></td>
                <td width="17%">'.$diasEstadia.'</td>
            </tr>
            <tr>
            	<td><strong>Egreso:</strong></td>
                <td>'.$epiEgreso.'</td>
                <td><strong>Destino:</strong></td>
                <td colspan="4">'.$destinoEpi." ".$epiTraslado.'</td>
				
            </tr>
              ';
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
          $html.= '
            
            <tr>
            	<td><strong>Diagnostico: </strong></td>
                <td colspan="5">'.$epiDiagnostico.'</td>
                
            </tr>
			<tr>
            	<td><strong>Derivado: </strong></td>
                <td colspan="5">'.$nombreDeriva.'</td>
                
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Autocuidados</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table border="1" width="100%" align="left" cellpadding="1" style="font-size:9;">
		<tr>
			<td>Nombre</td>
			<td>Ingreso</td>
			<td>Alta</td>
		</tr>
	';
	mysql_select_db('epicrisis') or die('Cannot select database');
	$sqlepiCuidado = "SELECT *
						FROM
						epienf_has_autocuidado
						WHERE epienf_has_autocuidado.epienfId = $idEpicrisis";
	$queryepiCuidado = mysql_query($sqlepiCuidado) or die ($sqlepiCuidado." ERROR AL SELECCIONAR LOS AUTOCUIDADOS DEL PACIENTE ". mysql_error());

	$arrayepiCuidado = mysql_fetch_array($queryepiCuidado);
	
	$i = 0;
	while($i <> $contador_au)
	{
	$html.='<tr>
	<td>'.$arr_au[$i].'</td>';
	
	if(mysql_num_rows($queryepiCuidado) > 0){
									
		do{
			switch($arrayepiCuidado['cuidadoValor']){
			case "A":
				$valor = "Autovalente";
			break;
			case "DP":
				$valor = "Dependencia Parcial";
			break;
			case "DT":
				$valor = "Dependencia Total";
			break;
			}
			
			if(($arrayepiCuidado['cuidadoId'] == $arr_au2[$i]) and ($arrayepiCuidado['cuidadoTipo'] == 'I')){
				$cuidadoI[$arr_au2[$i]] = $valor;	
			}
			if(($arrayepiCuidado['cuidadoId'] == $arr_au2[$i]) and ($arrayepiCuidado['cuidadoTipo'] == 'A')){
				$cuidadoA[$arr_au2[$i]] = $valor;
			}
			
			}while($arrayepiCuidado = mysql_fetch_array($queryepiCuidado));
			
			$rowsAC = mysql_num_rows($queryepiCuidado);
			if($rowsAC > 0){
			mysql_data_seek($queryepiCuidado, 0);
			$arrayepiCuidado = mysql_fetch_array($queryepiCuidado);
			}
	}
	$html.='
	<td>'.$cuidadoI[$arr_au2[$i]].'</td>
	<td>'.$cuidadoA[$arr_au2[$i]].'</td>
	</tr>';
	$i++;
	}			              
            
    $html.= '</table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Intervenciones Realizadas</strong></td>
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
    <td colspan="3" align="left" valign="bottom"><strong>Planificacion Evaluativa</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table border="1" width="100%" align="left" cellpadding="1" style="font-size:9;">
	<tr>
			<td>Diagnostico Enfermera</td>
			<td>Al Ingreso</td>
			<td>Al Alta</td>
		</tr>
	';
	$sqlepiPlan = "SELECT *
					FROM
					epienf_has_planificacion
					WHERE epienf_has_planificacion.epienfId = $idEpicrisis";
	$queryepiPlan = mysql_query($sqlepiPlan) or die("ERROR AL SELECCIONAR PLANIFICACIONES DEL PACIENTE ". mysql_error());

	$arrayepiPlan = mysql_fetch_array($queryepiPlan);
	
	$i = 0;
	while($i <> $contador_pl)
	{
	$html.='<tr>
	<td>'.$arr_pl[$i].'</td>';
	
	if(mysql_num_rows($queryepiPlan) > 0){
									
		do{
			if(($arrayepiPlan['planId'] == $arr_pl2[$i]) and ($arrayepiPlan['planTipo'] == 'I')){
				$planI[$arr_pl2[$i]] = "X";	
			}
			if(($arrayepiPlan['planId'] == $arr_pl2[$i]) and ($arrayepiPlan['planTipo'] == 'A')){
				$planA[$arr_pl2[$i]] = "X";
			}
			
			}while($arrayepiPlan = mysql_fetch_array($queryepiPlan));
			
			$rowsPL = mysql_num_rows($queryepiPlan);
			if($rowsPL > 0){
			mysql_data_seek($queryepiPlan, 0);
			$arrayepiPlan = mysql_fetch_array($queryepiPlan);
			}
	}
	$html.='
	<td>'.$planI[$arr_pl2[$i]].'</td>
	<td>'.$planA[$arr_pl2[$i]].'</td>
	</tr>';
	$i++;
	}		              
            
    $html.= '</table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Indicaciones de Enfermeria y Tratamientos.</strong></td>
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
  </tr>';
  if($muestra == 0){
  $html.='
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
  </tr>';
  }
   
	if($muestra_1 == 0){
  $html.='
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Examenes de Anatomia Patologica</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr>  

  <tr>
    <td height="12" colspan="3">
    
      <table width="100%" align="left" cellpadding="1" style="font-size:9;">';
	$e = 0;
	while($e <> $contador_ar)
	{
	$html.='<tr><td>'.$arrayPres[$e].'('.$arrayOrg[$e].')</td></tr>';
	$e++;
	}			              
            
    $html.= '</table>
    
    </td>
  </tr>';
  }
  
  $html.='  
  <tr>
	<td align="center" colspan="3">&nbsp;</td>  
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
        <td align="center">'.$epiEnfermera.'<strong>(EU)</strong></td>
        <td align="center" valign="top"></td>
        <td align="center"><strong>'.$epiRespNom.'('.$epiResp.')'.'<br/>'.$epiRespRut.'</strong></td>
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