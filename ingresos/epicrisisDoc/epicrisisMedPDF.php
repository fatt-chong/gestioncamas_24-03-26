<?php
session_start();
$bd = $_SESSION['BD_SERVER'];
$usuario = $_SESSION['MM_RUNUSU'];
$usuario_nombre = $_SESSION['MM_UsernameName'];

$idEpicrisis = $_REQUEST['idEpicrisis'];
$hospitaliza  = $_REQUEST['hospitaliza'];
$id_paciente = $_REQUEST['id_paciente'];

$nomCR= $_REQUEST['nomCR'];

$nombrePaciente = $_REQUEST['nombrePaciente'];
$fichaPaciente = $_REQUEST['fichaPaciente'];
$direccionPac = $_REQUEST['direccionPac'];
$generoPaciente = $_REQUEST['generoPaciente'];
$serv_paciente = $_REQUEST['serv_paciente'];
$rutPaciente = $_REQUEST['rutPaciente'];
$fechaNac = $_REQUEST['fechaNac'];
$prevPaciente = $_REQUEST['prevPaciente'];
$visualiza = $_REQUEST['visualiza'];
$ctaCte = $_REQUEST['ctaCte'];
$idServicio =$_REQUEST['idServicio'];
$controlEspecialidad =$_REQUEST['controlEspecialidad'];
$controlEspecialidad = $_REQUEST['controlEspecialidad'];


error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
//date_default_timezone_set('America/Santiago'); 
require_once('../../../estandar/tcpdf/tcpdf.php');
require_once('../../../estandar/tcpdf/config/lang/spa.php');

require_once('../clases/Conectar.inc'); 
  $objConectar = new Conectar; 
  $link = $objConectar->db_connect();
require_once('../clases/diagnosticosmedicos.inc'); 
  $objdiagnosticomedico = new diagnosticosmedicos;

if($visualiza == 1){
  class MYPDF extends TCPDF {
    //Page header
    public function Header() {
  //     get the current page break margin
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
  //    // set the starting point for the page content
      $this->setPageMark();
    }
  }
}else{
  class MYPDF extends TCPDF {
    //Page header
    public function Header() {
  //     get the current page break margin
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
  //    // set the starting point for the page content
      $this->setPageMark();
    }
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
$a=mysql_connect ($bd,'gestioncamas','123gestioncamas');
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
$destinoEpi = $resInforme['epimedDestino'];
$destinodetEpi = $resInforme['epimedDestinodet'];
$destinodet2Epi = $resInforme['epimedDestinodet2'];
$epiEgreso = $resInforme['epimedCond'];
$epiDiagnostico =  $resInforme['epimedDiag'];
$epiDetalle = $resInforme['epimedIndica'];
$epiFundamento = $resInforme['epimedFund'];
$epiIdMedico = $resInforme['epimedIdMedico'];
$epiPesoIn = $resInforme['epimedPesoIn'];
$epiPesoEg = $resInforme['epimedPesoEg'];
$epiGes = $resInforme['epimedGes'];
$epiGesNom = $resInforme['epimedGesNom'];
$epiNutri = $resInforme['epimedNutricion'];
$ctaCte = $resInforme['epimedCtacte'];
$epimedMedico = $resInforme['epimedMedico'];



$epiDetalleTotal = html_entity_decode($epiDetalle);
$direccionPac = html_entity_decode($direccionPac);
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
//SELECCIONA EL PROGRAMA GES SI CORRESPONDE
if($epiGes == 'si'){
$consGes = "SELECT
      ppvsubprogramas.subprogNombre,
      ppvsubprogramas.subprogCod
      FROM ppvsubprogramas
      WHERE
      ppvsubprogramas.subprogCod = '$epiGesNom'
      ";

mysql_select_db('acceso') or die('Cannot select database');
      
$sqlGes = mysql_query($consGes) or die("ERROR AL SELECCIONAR SUBPROGRAMAS ".mysql_error());
$rsGes = mysql_fetch_assoc($sqlGes);
$progGes = $rsGes['subprogNombre'];
}
//SELECCIONA EL NOMBRE DEL MEDICO QUE REALIZO EPICRISIS
mysql_select_db('camas') or die('Cannot select database');

$sqlMedicos = "SELECT * FROM medicos WHERE id = $epiIdMedico";
$queryMedicos = mysql_query($sqlMedicos) or die ("ERROR AL SELECCIONAR MEDICOS ".mysql_error());
$arrayMedicos = mysql_fetch_array($queryMedicos);
$nomMedico = $arrayMedicos['medico'];

//BUSCA LAS OPERACIONES REALIZADAS AL PACIENTE
 
$sqlPabellon = "SELECT
        epicrisis.epimed_has_operacion.opNombre,
        pabellon.cirugia.ciruHora,
        pabellon.cirugia.ciruFecha,
        pabellon.medicospab.mpNombre
        FROM
        epicrisis.epicrisismedica
        LEFT JOIN epicrisis.epimed_has_operacion ON epicrisis.epicrisismedica.epimedId = epicrisis.epimed_has_operacion.epimedId
        INNER JOIN pabellon.cirugia ON epicrisis.epimed_has_operacion.opCod = pabellon.cirugia.ciruCod
        INNER JOIN pabellon.medicospab ON pabellon.cirugia.ciruCirujano1 = pabellon.medicospab.mpCod
        WHERE
        epicrisis.epicrisismedica.epimedPacId = $id_paciente AND
        pabellon.cirugia.ciruFecha >= '$hospitaliza' AND
        (cirugia.ciruEstado = 'REALIZADA' OR cirugia.ciruEstado = 'EN PROCESO')";
        
mysql_select_db('pabellon') or die('Cannot select database');
$queryPabellon = mysql_query($sqlPabellon) or die($sqlPabellon. " ERROR AL SELECCIONAR LAS CIRUGIAS ".mysql_error());
$cantidad_op = mysql_num_rows($queryPabellon);
$e = 0;
while($arrayPabellon = mysql_fetch_array($queryPabellon)){
$arr_Pabellon[$e]['glosa'] = $arrayPabellon['opNombre'];
$arr_Pabellon[$e]['medico'] = $arrayPabellon['mpNombre'];
$arr_Pabellon[$e]['fecha'] = $arrayPabellon['ciruFecha']." ".$arrayPabellon['ciruHora'];
$e++;
}
$contador_p = count($arr_Pabellon);
if ($contador_p == 0) { 
$arr_Pabellon[0] = 'NO EXISTEN CIRUGIAS ASOCIADAS'; 
$contador_p = 1;
} 
    
//ASIGNA ESTADO DEL PACIENTE
switch($epiEgreso){
  case 'V':
  $epiEgreso = "Vivo";
  break;
  case 'F':
  $epiEgreso = "Fallecido";
  break;  
  }

switch($destinoEpi){
  case '1':
    $destinoPaciente = "Domicilio";
  break;
  case '2':
    $destinoPaciente = "Traslado";
  break;
  case '3':
    $destinoPaciente = "CONIN";
  break;
  case '4':
    $destinoPaciente = "Otros";
  break;
  case '5':
    $destinoPaciente = "Anatomia Patologica";
  break;
  case '6':
    $destinoPaciente = "Servicio Medico Legar";
  break;
  case '':
    $destinoPaciente = "";
  break;
  }
  if($destinoPaciente == "Traslado"){
    
    mysql_select_db('acceso') or die('Cannot select database');
    $sqlTraslado = mysql_query("SELECT 
        idcentro,
        nombre
        FROM centro
        WHERE idcentro = '$destinodetEpi'") or die("Error al seleccionar traslados ".mysql_error());    
    $rsTraslado = mysql_fetch_assoc($sqlTraslado);
    $trasladoDetalle = $rsTraslado['nombre'];
    }else if($destinoPaciente == "Otros"){
      mysql_select_db('epicrisis') or die('Cannot select database');
      
      $sqlTraslado = mysql_query("SELECT hogarNom 
            FROM hogares 
            WHERE hogarId = '$destinodet2Epi'") or die("Error al seleccionar Hogares ".mysql_error());
      $rsTraslado = mysql_fetch_assoc($sqlTraslado);
      $trasladoDetalle = $rsTraslado['hogarNom'];
      
      }
      
  
switch($epiNutri){
  case '1':
    $nutriPac = "Eutrofico";
  break;
  case '2':
    $nutriPac = "Obeso";
  break;
  case '3':
    $nutriPac = "Riesgo";
  break;
  case '4':
    $nutriPac = "Desnutrido";
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

$RSresultado = $objdiagnosticomedico->buscadiagnosticos($link, $ctaCte);
$RSresultadocontrol = $objdiagnosticomedico->buscarcontroles($link, $ctaCte);

// Set some content to print

$html = '
<br />
<table width="700px" border="0">

  <tr>
    <td width="30%" align="left"></td>
    <td align="center">&nbsp;</td>
    <td width="30%" align="right" style="font-size:9;">Arica, '.$fechaHoy.'<br/></td>
  </tr>
  <tr>
    
    <td colspan="3" align="center" style="font-size:10;">EPICRISIS MEDICA Y CARNE DE ALTA<br />CENTRO DE RESPONSABILIDAD
      '.$nomCR.'</td>
    
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
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
                <td width="98px" ><strong>Rut:</strong></td>
                <td width="185px" >'.$rutPaciente.'-'.ValidaDVRut($rutPaciente).'</td>
                
            </tr>
            <tr>
              <td ><strong>Edad: </strong></td>
                <td >'.$fechaNac.'</td>
                <td ><strong>Genero:</strong></td>
                <td colspan="3">'.$generoPaciente.'</td>
            </tr>
            <tr>
              <td><strong>Ficha:</strong></td>
                <td>'.$fichaPaciente.'</td>
                <td><strong>Prevision:</strong></td>
                <td >'.$prevPaciente.'</td>
                
            </tr>
            <tr>
              <td><strong>Direccion:</strong></td>
                <td colspan="5">'.$direccionPac.'</td>
                
            </tr>
            <tr>
              
                <td><strong>Servicio:</strong></td>
                <td>'.$serv_paciente.'</td>
                <td><strong>Fono: </strong></td>
                <td colspan="3">'.$epiFono.'</td>
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
              <td width="123px"><strong>Ingreso:</strong></td>
                <td width="191px">'.$fechaIngreso.'</td>
                <td width="127px"><strong>Egreso:</strong></td>
                <td width="181px">'.$fechaEgreso.'</td>
                
            </tr>
            <tr>
              <td ><strong>Dias Estadia:</strong></td>
                <td>'.$diasEstadia.'</td>
        ';
      
      if($idServicio == '7'){
            $html.='
                <td><strong>Condicion Egreso:</strong></td>
                <td valign="bottom">'.$epiEgreso.'</td>';
      }
      $html.='
            </tr>
            ';
      if($idServicio == '7'){
            $html.='
      <tr>
              <td><strong>Destino:</strong></td>
                <td valign="bottom" colspan="3">'.$destinoPaciente.' - '.$trasladoDetalle.'</td>
        
            </tr>
            
            <tr>
              <td><strong>Peso Ingreso:</strong></td>
                <td valign="bottom" >'.$epiPesoIn.'</td>
                <td><strong>Peso Egreso:</strong></td>
                <td valign="bottom" >'.$epiPesoEg.' '.$nutriPac.'</td>
        
            </tr>
            <tr>
              <td><strong>Ges:</strong></td>
                <td colspan="4">'.strtoupper($epiGes).' '.$progGes.'</td>
            </tr>
      
      
      ';
      }
      $html.='
            <tr>
              <td><strong>Diagnostico Egreso: </strong></td>
                <td colspan="5">'.$epiDiagnostico.'</td>
            </tr>';
        if(mysql_num_rows($RSresultado)>0){
          $html.='
                <tr>
                  <td><strong>Otros Diagnosticos</strong></td>
                  <td colspan="6">';
                mysql_data_seek($RSresultado,0);
                $j=1;
                while($arraydiagnosticos = mysql_fetch_assoc($RSresultado))
                  {
                    if($arrayEpicrisis[epimedDiag] == $arraydiagnosticos['dm_diagnostico']){
                      $j--;
                    }else{
                      $html.=$j.') '.$arraydiagnosticos['dm_diagnostico'].'<BR>';
                    }
$j++;
                  }
                  
          $html.='
                  </td>
                </tr>';
        }
        $html.='
            
            <tr>
              <td><strong>Fundamento: </strong></td>
                <td colspan="5">'.$epiFundamento.'</td>
                
            </tr>
      
        </table>
    </td>
  </tr>
  ';
  if($controlEspecialidad=="1"){
    $html.='<tr>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3"><strong>Controles con especialidad</strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td><strong>Control especialidad:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>  
    <td colspan="3">
      <table cellpadding="3" width="100%" align="left" border="1" style="font-size:9;">
      ';
    if(mysql_num_rows($RSresultadocontrol)>0){
      $html.='
        <tr>
          <td><strong>Especialidad</strong></td>
          <td><strong>Periodo de control</strong></td>
        </tr>';
      mysql_data_seek($RSresultadocontrol,0);
      while($arraycontrolinterconsulta = mysql_fetch_assoc($RSresultadocontrol))
      {
        $html.='
        <tr>
          <td>'.$arraycontrolinterconsulta[ESPdescripcion].'</td>
          <td>'.$arraycontrolinterconsulta[CA_INTperiodo_control].'</td>
        </tr>';
      }
    }
    $html.='</table></td></tr>';
}else{
  $html.='<tr>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3"><strong>Controles con especialidad</strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td><strong>Control especialidad:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>';
}
  
  if($cantidad_op > 0){
  
  $html.='
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3"><strong>Intervenciones</strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>  
    <td colspan="3">
      
    <table cellpadding="3" width="100%" align="left" border="1" style="font-size:9;">';
    $e = 0;
    while($e <> $contador_p)
    
    {
    $html.='<tr>
          <td width="20%"><strong>Intervencion: </strong></td>
          <td colspan="3">'.$arr_Pabellon[$e]['glosa'].'</td>
        </tr>
        <tr>
          <td><strong>Fecha:</strong></td>
          <td>'.$arr_Pabellon[$e]['fecha'].'</td>
          <td><strong>Cirujano:</strong></td>
          <td>'.$arr_Pabellon[$e]['medico'].'</td>
        </tr>';
    $e++;
    }                   
        
    $html.= '</table>
    
    </td>
  </tr>';
  }
   if(($idServicio == '7') && ($contador_c2 != 0)){
  
  $html.='
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3"><strong>Controles</strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>  
    <td colspan="3">
      
    <table cellpadding="3" width="100%" align="left" border="1" style="font-size:9;">';
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
  </tr>';
  }
  $html.='
   <tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td colspan="3" align="left" valign="bottom"><br/><strong>Indicaciones Medicas</strong></td>
  </tr> 
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr> 
  <tr>
    <td height="12" colspan="3">
    
      <table width="100%" style="font-size:10;">
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
  <td align="center" colspan="3">&nbsp;</td>  
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
    <td colspan="3">&nbsp;</td>

  </tr>
  
  <tr>
  <td align="center" colspan="3">&nbsp;</td> 

  </tr>
  <tr>
  <td align="center" valign="bottom">&nbsp;</td>
  <td>
  ';
if ($usuario == $epiIdMedico){
$URLUsuarioIndicaciones = "http://".$_SERVER['SERVER_NAME'].":12/firmaDigital/medicos/".$epiIdMedico.".png";
$file_headers_usuarioIndicaciones = @get_headers($URLUsuarioIndicaciones);
if($file_headers_usuarioIndicaciones[0] == 'HTTP/1.1 200 OK') {
       $html .= ' <img src="http://".$_SERVER['SERVER_NAME'].":12/firmaDigital/medicos/'.$epiIdMedico.'.png" style="width:150px; height:35px; ">';
}
}
  $html .= '
  </td>
  <td align="center" valign="bottom">&nbsp;</td>
  </tr>

  <tr height="3">
        <td align="center" valign="bottom">&nbsp;</td>
        <td align="center"> <hr /> </td>
        <td align="center" valign="bottom"></td>
        
  </tr>
  <tr height="3">
        <td align="center" colspan="3">'.$epimedMedico.'</td>
        
        
  </tr>
  <tr>
        <td align="center" colspan="3"><strong>Medico</strong><br/> </td>
        
        
  </tr>
  </table>';
  if ($usuario == $epiIdMedico){
    if($file_headers_usuarioIndicaciones[0] == 'HTTP/1.1 200 OK') {
     $html .= '<table><tr><td align="center" valign="bottom">Firma digital creada por sistema clinico GesCam propiedad de HJNC</td></tr></table>';
    }else{
     $html .= '<table><tr><td align="center" valign="bottom">Profesional sin firma digital en sistema clinico GesCam propiedad de HJNC</td></tr></table>';
   }
  }else{
    $html .= '<table><tr><td align="center" valign="bottom">Epicrisis generada por '.$usuario_nombre.' a nombre de '.$epimedMedico.' en sistema clinico GesCam propiedad de HJNC</td></tr></table>';
  }
  /*
  <tr>
        <td align="center">&nbsp;</td>
        <td align="center" valign="top"><strong>DOCTOR<br>'.$nomMedico.'</strong></td>
        <td>&nbsp;</td>
  </tr>

</table>
';
*/
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
