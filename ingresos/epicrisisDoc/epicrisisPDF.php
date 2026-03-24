<?php
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pediatria');
$pdf->SetTitle('Epicrisis Medica');
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('TCPDF, PDF, Pediatria');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 8));
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
$sqlInforme = "	SELECT * FROM epicrisis WHERE epiId = $idEpicrisis";
$queryInforme = mysql_query($sqlInforme) or die ("ERROR AL CARGAR INFORMACION DEL INFORME<br> $sqlInforme <br>".mysql_error());
$resInforme = mysql_fetch_array($queryInforme);

//CREACION DE VARIABLES

$fechaHoy = fecha(date('Y-m-d'));

$fechaIngreso = cambiarFormatoFecha2($resInforme['epiFechaIngreso']);
$fechaEgreso = cambiarFormatoFecha2($resInforme['epiFechaEgreso']);
$diasEstadia = $resInforme['epiDiasEstadia'];
$destinoEpi = $resInforme['epiDestinoEgreso'];
$epiTraslado = $resInforme['epiCentro'];
$epiEgreso = $resInforme['epiCondicion'];
$epiGes = $resInforme['epiGes'];
$epidocGes = $resInforme['epiDcoGes'];
$pesoIngreso = $resInforme['epiPesoIngreso2'];
$pesoEgreso = $resInforme['epiPesoAlta2'];
$epiNutricional = $resInforme['epiClasificacionNutricional'];
$epiDiagnostico =  $resInforme['epiCie10'];
$epiDetalle = $resInforme['epiDetalle'];
$epiMedico = $resInforme['epiMedico'];
$epiDetalleTotal = html_entity_decode($epiDetalle);

$control1 = controlesNom($resInforme['epiTipoControl']); 
$fechaControl1 = cambiarFormatoFecha2($resInforme['epiFechaControl']);
$control2 = controlesNom($resInforme['epiTipoControlDos']);
$fechaControl2 = cambiarFormatoFecha2($resInforme['epiFechaControlDos']);
$control3 = controlesNom($resInforme['epiTipoControltres']);
$fechaControl3 = cambiarFormatoFecha2($resInforme['epiFechaControltres']);
$control4 = controlesNom($resInforme['epiTipoControlCuatro']);
$fechaControl4 = cambiarFormatoFecha2($resInforme['epiFechaControlCuatro']);

//ASIGNA UN NOMBRE AL DESTINO DEL PACIENTE
switch($destinoEpi){
	case 1:
		$destinoEpi = "Domicilio";
		break;
	case 2:
		$destinoEpi = "Traslado";
		break;
	case 3:
		$destinoEpi = "CONIN";
		break;
	case 4:
		$destinoEpi = "Otro";
		break;
	}
	
//ASIGNA UN NOMBRE A LA CLASIFICACION NUTRICIONAL
switch($epiNutricional){
	case 1:
		$epiNutricional = "Eutrofico";
		break;
	case 2:
		$epiNutricional = "Obeso";
		break;
	case 3:
		$epiNutricional = "Riesgo";
		break;
	case 4:
		$epiNutricional = "Desnutrido";
		break;
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
//ASIGNA SI O NO A VARIABLE
switch($epiGes){
	case 'S':
	$epiGes = "Si";
	break;
	case 'N':
	$epiGes = "No";
	break;	
	}
//SELECCIONA LOS TIPOS DE CONTROLES
function controlesNom($var){
$sqlControles = mysql_query("SELECT	
							epiNomAgenda
							FROM epiAgenda
							WHERE epiIdAgenda = $var") or die ("Error al seleccionar tipos de controles ". mysql_error());
$arrayControles = mysql_fetch_array($sqlControles);
$control = $arrayControles['epiNomAgenda'];
return $control;
}
//SELECCIONA LOS TIPOS DE DOC. GES	
$sqlGes = mysql_query("SELECT dcoGesDes 
						FROM dcoges
						WHERE dcoGesCod = $epidocGes ") or die("Error al seleccionar doc. ges ". mysql_error());
$arrayGes = mysql_fetch_array($sqlGes);
$epidocGes = $arrayGes['dcoGesDes'];
											
//SELECCIONA LOS TIPOS DE TRASLADOS
mysql_select_db('acceso') or die('Cannot select database');
$sqlTraslado = mysql_query("SELECT 
							nombre
							FROM centro
							WHERE idcentro= $epiTraslado") or die("Error al seleccionar traslados ".mysql_error());
$arrayTraslado = mysql_fetch_array($sqlTraslado);
$epiTraslado = $arrayTraslado['nombre'];

						
// OBTIENE PEDIATRAS
mysql_select_db('camas') or die('Cannot select database');	
$sqlPediatras = mysql_query("SELECT medico 
				FROM medicos 
				WHERE id = $epiMedico") or die ("ERROR AL CARGAR INFORMACION DEL PACIENTE <br> $sqlPediatras <br>".mysql_error());
$arrayPediatras = mysql_fetch_array($sqlPediatras); 
$nomMedico = $arrayPediatras['medico'];
$fechaCom = html_entity_decode($fechaNac);

// Set some content to print
$html = '
<br />
<table width="700" border="0">
  <tr>
    <td align="left" style="font-size:9;"></td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="30%" align="left"></td>
    <td align="center">&nbsp;</td>
    <td width="30%" align="right" style="font-size:9;">Arica, '.$fechaHoy.'</td>
  </tr>
  <tr>
    
    <td colspan="3" align="center" style="font-size:10;">EPICRISIS MEDICA</td>
    
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
            	<td><strong>N° de Ficha:</strong></td>
                <td>'.$fichaPaciente.'</td>
                <td><strong>Prevision:</strong></td>
                <td>'.$prevPaciente.'</td>
            </tr>
            <tr>
            	<td><strong>Direccion:</strong></td>
                <td>'.$direccionPaciente.'</td>
                <td><strong>Genero:</strong></td>
                <td>'.$generoPaciente.'</td>
            </tr>
            <tr>
            	<td><strong>Edad: </strong></td>
                <td>'.$fechaCom.'</td>
                <td><strong>Servicio:</strong></td>
                <td>'.$serv_paciente.'</td>
            </tr>
        </table>
     
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom"><strong>Epicrisis Medica</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="20" colspan="3">
    <table width="100%" align="left" cellpadding="1" style="font-size:9;">
        	<tr>
            	<td width="19%"><strong>Fecha Ingreso:</strong></td>
                <td width="17%">'.$fechaIngreso.'</td>
                <td width="16%"><strong>Fecha Egreso:</strong></td>
                <td width="16%">'.$fechaEgreso.'</td>
                <td width="15%"><strong>Dias Estadia:</strong></td>
                <td width="17%">'.$diasEstadia.'</td>
            </tr>
            <tr>
            	<td><strong>Destino:</strong></td>
                <td>'.$destinoEpi.'</td>
                <td><strong>Traslado:</strong></td>
                <td colspan="3">'.$epiTraslado.'</td>
                
            </tr>
            <tr>
            	<td><strong>Condicion Egreso</strong>:</td>
                <td>'.$epiEgreso.'</td>
                <td><strong>Ges:</strong></td>
                <td>'.$epiGes.'</td>
                <td><strong>Doc. Ges:</strong></td>
                <td>'.$epidocGes.'</td>
            </tr>
            <tr>
            	<td><strong>Peso Ingreso:</strong></td>
                <td>'.$pesoIngreso.'</td>
                <td><strong>Peso Alta:</strong></td>
                <td>'.$pesoEgreso.'</td>
                <td><strong>Clas. Nutricional:</strong></td>
                <td>'.$epiNutricional.'</td>
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
    <td colspan="3" align="left" valign="bottom"><strong>Controles</strong></td>
  </tr> 
  <tr>
  	<td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
	<td align="left" colspan="3">
    <table width="100%" cellpadding="1" style="font-size:9;">
        	<tr>
            	<td width="19%"><strong>Primer Control:</strong></td>
                <td width="18%">'.$control1.'</td>
                <td width="14%"><strong>Fecha:</strong></td>
                <td width="49%">'.$fechaControl1.'</td>
            </tr>
            <tr>
            	<td><strong>Segundo Control</strong></td>
                <td>'.$control2.'</td>
                <td><strong>Fecha:</strong></td>
                <td>'.$fechaControl2.'</td>
            </tr>
            <tr>
            	<td><strong>Tercer Control</strong></td>
                <td>'.$control3.'</td>
                <td><strong>Fecha:</strong></td>
                <td>'.$fechaControl3.'</td>
            </tr>
            <tr>
            	<td><strong>Cuarto Control</strong></td>
                <td>'.$control4.'</td>
                <td><strong>Fecha:</strong></td>
                <td>'.$fechaControl4.'</td>
            </tr>
        </table>
     
    </td>  
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="bottom">Detalle Diagnostico</td>
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
	<td align="center" colspan="3">&nbsp;</td>  
  </tr>
  <tr height="3">
        <td align="center">&nbsp;</td>
        <td align="center" valign="bottom">'.$nomMedico.'</td>
        <td>&nbsp;</td>
  </tr>
  <tr height="3">
        <td align="center"></td>
        <td align="center" valign="bottom"><hr /></td>
        <td></td>
  </tr>
  <tr>
        <td align="center">&nbsp;</td>
        <td align="center" valign="top"><strong>Medico Tratante</strong></td>
        <td>&nbsp;</td>
  </tr>

</table>
';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->Image('../img/marcaAgua.png', 50, 160, 115, '', '', '', '', true, 300);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('epicrisisMedica.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+