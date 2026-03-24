<?php 
ob_start(); 
if (!isset($_SESSION)) { session_start(); }
if ( $_SESSION['MM_Username'] == null ) { $GoTo = "../../acceso/index.php"; header(sprintf("Location: %s", $GoTo)); }

if ($_GET["calendario"]){$fecha_selected = $_GET["calendario"]; $fecha_selected = date("Y-m-d",strtotime($fecha_selected)); header ("Location: camas2.php?calendario=$fecha_selected"); }

$fechahoy = date("d-m-Y"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>

<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script>setTimeout("document.frm_camas.submit()",300000); </script>

	<script language="JavaScript" src="../tablas/tigra_hints.js"></script>
	<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<style>
		.hintsClass {
			font-family: tahoma, verdana, arial;
			font-size: 12px;
			background-color: #f0f0f0;
			color: #000000;
			border: 1px solid #808080;
			padding: 5px;
		}
	</style>
    
<style> 
	a{text-decoration:none} 
	#linea_color{
       border-bottom: 1px solid #7A7A7A;
       border-right: 1px solid #7A7A7A;
}
</style> 


 	<!--EFECTTO VENTANA GREYBOX-->
    <script type="text/javascript">
        var GB_ROOT_DIR = "../greybox/";
    </script>
    

    <script type="text/javascript" src="../greybox/AJS.js"></script>
    <script type="text/javascript" src="../greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="../greybox/gb_scripts.js"></script>
    <link href="../greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<!-- ******************************* calendario **************************************** -->
<script type="text/javascript" src="../jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery/css/custom-theme/jquery-ui-1.10.4.custom.css"/>
<script>
 $(function() {
$( ".calendario" ).datepicker({
	 minDate: '29-05-2014',
	 maxDate: '$fechahoy',
     changeMonth: true,
     changeYear: true
   });
 });
</script>
<!-- ********************************* fin de calendario *********************************** -->

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px; color:#616161"">

<?
if ($cualtab == '')
{
	$cualtab = 0;
}
?>

<form method="get" action="camas.php" name="frm_camas" id="frm_camas">

    <input type="hidden" name="cualtab" value="<? echo $cualtab ?>" />
    

	<?
	include "../funciones/funciones.php";	

	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	
	mysql_select_db('pensionado') or die('Cannot select database');

	$sqlSalas = "SELECT DISTINCT
				lista.salaPensio
				FROM lista
				ORDER BY salaPensio ASC";
	$querySalas = mysql_query($sqlSalas) or die($sqlSalas." Error al seleccionar salas ".mysql_error());
	
	mysql_select_db('camas') or die('Cannot select database');
 
	$query = mysql_query("SELECT * FROM sscc order by orden") or die(mysql_error());

	$fecha_hoy = date('Y-m-d');
	$hora_hoy = date('H:i');
	
	?>

<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 


<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="img/fondo.jpg">
    <tr height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">
        <td>
        <table width="1024">
        <tr>
            <td width="797">&nbsp;Gesti�n Hospital.</td>
            <td width="24" align="right"><a href="camas.php" title="Gestion Hospital" ><img src="img/i_camas.gif" width="25" height="25" /></a></td>
            <td width="24" align="right"><a href="lista_rau.php" title="Mapa de Piso Unidad de Urgencia" ><img src="img/i_rau.gif" width="25" height="25" /></a></td>
            <td width="24" align="right"><a href="altaPrecoz.php" title="Hospitalizaci�n Domiciliaria" ><img src="img/i_aprecoz.gif" width="25" height="25" /></a></td>
            <td width="24" align="right"><a href="../../pabellon/sscc.php" title="Mapa Pabellon" ><img src="img/i_pabellon.gif" width="25" height="25" /></a></td>
            <td width="24" align="right"><a href="ListadoPacientes.php" title="Cirugia Mayor Ambulatoria" ><img src="img/i_cma.gif" width="25" height="25" /></a></td>
        <? $permisos = $_SESSION['permiso']; if ( array_search(507, $permisos) != null ) { ?>
	        <td width="24" align="right"><input type="text" id="calendario" name="calendario" class="calendario" size="10px"  placeholder ="<?=date("d-m-Y");?>" onchange="document.frm_camas.submit();"/></form></td> 
		<? } ?>
        </tr>
        </table>
        </td>
    </tr>    
<tr>
<td  colspan="3">
	<fieldset>

	<div align="center" style="width:1000px;height:400px;overflow:auto ">
    <div id="TabbedPanels1" class="TabbedPanels">
<?
		$i = 0;
		$camas_ocupadas = 0;
		$camas_desocupadas = 0;
		$camas_desocupadas_adulto = 0;
		$camas_bloqueadas = 0;
		$camas_bloqueadas_sn = 0;
		$tot_cat_a1 = 0;
		$tot_cat_a2 = 0;
		$tot_cat_a3 = 0;
		$tot_cat_b1 = 0;
		$tot_cat_b2 = 0;
		$tot_cat_b3 = 0;
		$tot_cat_c1 = 0;
		$tot_cat_c2 = 0;
		$tot_cat_c3 = 0;
		$tot_cat_d1 = 0;
		$tot_cat_d2 = 0;
		$tot_cat_d3 = 0;
		$camas_categorizadas = 0;
		$camas_x_categorizar = 0;

?>      <ul class="TabbedPanelsTabGroup"> <?
    	while($sscc = mysql_fetch_array($query)){
			$servicio = $sscc['id'];
			$desc_servicio = $sscc['servicio'];
			if ($sscc['id'] <= 46) {
			$servicios[$i] = $sscc['id'];
			$desc_servicios[$i] = $desc_servicio; ?>

<li class='TabbedPanelsTab' onclick="javascript:document.getElementById('cualtab').value='<? echo $i; ?>';" tabindex='0'><? echo $desc_servicio; ?></li>
<?
			$arr_camas_ocupadas[$i] = 0;
			$arr_camas_desocupadas[$i] = 0;
			$arr_camas_desocupadas_adulto[$i] = 0;
			$arr_camas_bloqueadas[$i] = 0;
			$arr_camas_bloqueadas_sn[$i] = 0;
			$arr_tot_cat_a1[$i] = 0;
			$arr_tot_cat_a2[$i] = 0;
			$arr_tot_cat_a3[$i] = 0;
			$arr_tot_cat_b1[$i] = 0;
			$arr_tot_cat_b2[$i] = 0;
			$arr_tot_cat_b3[$i] = 0;
			$arr_tot_cat_c1[$i] = 0;
			$arr_tot_cat_c2[$i] = 0;
			$arr_tot_cat_c3[$i] = 0;
			$arr_tot_cat_d1[$i] = 0;
			$arr_tot_cat_d2[$i] = 0;
			$arr_tot_cat_d3[$i] = 0;
			$arr_camas_categorizadas[$i] = 0;
			$arr_camas_x_categorizar[$i] = 0;

			$t_cma_ocupadas = 0;
			$t_cma_desocupadas = 0;
			$t_cma_bloqueadas = 0;
			$t_urg_ocupadas = 0;
			$t_urg_desocupadas = 0;
			$t_urg_bloqueadas = 0;

			$total_b_00_03 = 0;
			$total_b_03_08 = 0;
			$total_b_08_12 = 0;
			$total_b_12_ms = 0;
			$i++;
			}
    	}
		
		$arr_camas_ocupadas[$i] = 0;
		$arr_camas_capacidad[$i] = 24;
		$arr_camas_totalpac[$i] = 0;
		$arr_tot_cat_a1[$i] = 0;
		$arr_tot_cat_a2[$i] = 0;
		$arr_tot_cat_a3[$i] = 0;
		$arr_tot_cat_b1[$i] = 0;
		$arr_tot_cat_b2[$i] = 0;
		$arr_tot_cat_b3[$i] = 0;
		$arr_tot_cat_c1[$i] = 0;
		$arr_tot_cat_c2[$i] = 0;
		$arr_tot_cat_c3[$i] = 0;
		$arr_tot_cat_d1[$i] = 0;
		$arr_tot_cat_d2[$i] = 0;
		$arr_tot_cat_d3[$i] = 0;
		$arr_camas_categorizadas[$i] = 0;
		$arr_camas_x_categorizar[$i] = 0;

?>      </ul> <?

		$i_mens_todos = 0;

?>      
<div class="TabbedPanelsContentGroup"> 
<?
		for($i=0; $i<count($servicios); $i++)
		{
			$servicio = $servicios[$i];
			$desc_servicio = $desc_servicios[$i];
?>        <div class="TabbedPanelsContent"> 
			<? if($servicio == 46){ ?>
            
            <!-- INICIO PENSIONADO -->
            <table>
        	<tr>
            	<? 
				$i_detalleCama = 0;
					
				while($arraySalas = mysql_fetch_array($querySalas)){ 
						$salaPensionado = $arraySalas['salaPensio'];
						$total_salas = mysql_num_rows($querySalas);
				?>
                <td >
                <fieldset><legend style="font-size:10px;">s-<? echo $salaPensionado; ?></legend>
                	<table cellspacing="1px">
                    	<? $sqlCamasPensio = "SELECT
										pensionado.lista.idPensio,
										pensionado.lista.salaPensio,
										pensionado.lista.numPensio,
										pensionado.camas.corrPensio,
										pensionado.camas.estadoPensio,
										pensionado.camas.cat_riesgoPensio,
										pensionado.camas.cat_depPensio,
										pensionado.camas.c_tipoPensio,
										pensionado.camas.d_tipoPensio,
										pensionado.camas.ctactePensio,
										pensionado.camas.c_medicoPensio,
										pensionado.camas.n_medicoPensio,
										pensionado.camas.c_augePensio,
										pensionado.camas.n_augePensio,
										pensionado.camas.diagn1Pensio,
										pensionado.camas.diagn2Pensio,
										pensionado.camas.accTranPensio,
										pensionado.camas.multiresPensio,
										pensionado.camas.idPaciente,
										pensionado.camas.sexoPensio,
										pensionado.camas.rutPensio,
										pensionado.camas.nacPensio,
										pensionado.camas.fichaPensio,
										pensionado.camas.nombrePensio,
										pensionado.camas.direcPensio,
										pensionado.camas.c_comunaPensio,
										pensionado.camas.n_comunaPensio,
										pensionado.camas.fono1Pensio,
										pensionado.camas.fono2Pensio,
										pensionado.camas.fono3Pensio,
										pensionado.camas.cat_fechaPensio,
										pensionado.camas.pabellonPensio,
										pensionado.camas.hospPensio,
										pensionado.camas.fechaIngresoPensio,
										pensionado.camas.horaIngresoPensio,
										pensionado.camas.c_previsionPensio,
										pensionado.camas.n_previsionPensio,
										pensionado.camas.usuarioPensio,
										pensionado.camas.tipo_paciente,
										camas.listasn.nomPacienteSN
										FROM
										pensionado.lista
										LEFT JOIN pensionado.camas ON pensionado.lista.idPensio = pensionado.camas.idPensio
										LEFT JOIN camas.camassn ON pensionado.camas.idPensio = camas.camassn.idPensio
										LEFT JOIN camas.listasn ON camas.camassn.codCamaSN = camas.listasn.idCamaSN
										WHERE
										pensionado.lista.salaPensio = '$salaPensionado'"; 
										
							mysql_select_db('pensionado') or die('Cannot select database');
							$queryCamasPensio = mysql_query($sqlCamasPensio) or die($sqlCamasPensio. " Error al seleccionar camas". mysql_error());
						
						while($arrayCamasPensio = mysql_fetch_array($queryCamasPensio)){
							
								$numCamaPen = $arrayCamasPensio['numPensio'];
								$idPensioPen = $arrayCamasPensio['idPensio'];
								$salaPensioPen = $arrayCamasPensio['salaPensio'];
								$corrCamaPen = $arrayCamasPensio['corrPensio'];
								$estadoCamaPen = $arrayCamasPensio['estadoPensio'];
								$catRiesgoPen = $arrayCamasPensio['cat_riesgoPensio'];
								$catDepPen = $arrayCamasPensio['cat_depPensio'];
								$sexoCamaPen = $arrayCamasPensio['sexoPensio'];
								$multiCamaPen = $arrayCamasPensio['multiresPensio'];
								$pacienteSNPen = $arrayCamasPensio['nomPacienteSN'];
								$categorizacionPen = $catRiesgoPen.$catDepPen;

/***** modificacion danny para dias hospitalizados 08-01-2014	*****/
	date_default_timezone_set("America/Santiago");
    setlocale(LC_TIME, "spanish");
    $Time = strftime("%H:%M:%S");
	$fecha = date('Y-m-d');
	$hoyPensio = $fecha." ".$Time;		
						$hoyPensio;
						$ingresoPensio = $arrayCamasPensio['fechaIngresoPensio'].' '.$arrayCamasPensio['horaIngresoPensio'];
						$segundos=strtotime($hoyPensio) - strtotime($ingresoPensio);
						
						$diferencia_dias=floor((($segundos/60)/60)/24);
						if($diferencia_dias>0){	$diass = $diferencia_dias; $segundos = $segundos - ((($diferencia_dias*24)*60)*60); }else{$diass=0;}
						
						$diferencia_horas=floor(($segundos/60)/60);
						if($diferencia_horas>0){ $horass = $diferencia_horas; $segundos = $segundos - (($horass*60)*60);}else{$horass=0;}
						
						$diferencia_minutos=floor($segundos/60);
						if($diferencia_minutos>0){ $minutoss = $diferencia_minutos; }else{$minutoss=0;}

	/* fin del calculo danny para dias hospitalizados 08-01-2014 */
						
						$hoyPensio = date("Y-m-d").' '.date("H:i:s");

						$ingresoPensio = $arrayCamasPensio['fechaIngresoPensio'].' '.$arrayCamasPensio['horaIngresoPensio'];
						$ingreso_hospPensio = $arrayCamasPensio['hospPensio'];
						$egresoPensio = $hoy;
						
						$tiempo_esperaPensio = intval((strtotime($egresoPensio)-strtotime($ingresoPensio))/3600);
						
						$dias_esperaPensio = ($tiempo_esperaPensio / 24);
						$decimalesPensio = explode(".",$dias_esperaPensio);
						$dias_esperaPensio = $decimalesPensio[0];
						$horas_esperaPensio = ($tiempo_esperaPensio - ($dias_esperaPensio*24));
						
						$tiempo_espera_hospPensio = intval((strtotime($egresoPensio)-strtotime($ingreso_hospPensio))/3600);
				
						$dias_espera_hospPensio = ($tiempo_espera_hospPensio / 24);
						$decimalesPensio = explode(".",$dias_espera_hospPensio);
						$dias_espera_hospPensio = $decimalesPensio[0];
						$horas_espera_hospPensio = ($tiempo_espera_hospPensio - ($dias_espera_hospPensio*24));
								
						if($estadoCamaPen == NULL){
							
							$camas_desocupadas++;
							$arr_camas_desocupadas[$i]++;
							
							$camas_desocupadas_adulto ++;
							$arr_camas_desocupadas_adulto[$i] ++;
							}
						if(($estadoCamaPen == 2) or ($estadoCamaPen == 4)){
								
								$camas_ocupadas ++;
								$arr_camas_ocupadas[$i] ++;
								
							switch($categorizacionPen){
								case 'A1';
									$tot_cat_a1++; 
									$arr_tot_cat_a1[$i]++;
									break;
								case 'A2';
									$tot_cat_a2++; 
									$arr_tot_cat_a2[$i]++;
									break;
								case 'A3';
									$tot_cat_a3++; 
									$arr_tot_cat_a3[$i]++;
									break;
								case 'B1';
									$tot_cat_b1++; 
									$arr_tot_cat_b1[$i]++;
									break;
								case 'B2';
									$tot_cat_b2++; 
									$arr_tot_cat_b2[$i]++;
									break;
								case 'B3';
									$tot_cat_b3++; 
									$arr_tot_cat_b3[$i]++;
									break;
								case 'C1';
									$tot_cat_c1++; 
									$arr_tot_cat_c1[$i]++;
									break;
								case 'C2';
									$tot_cat_c2++; 
									$arr_tot_cat_c2[$i]++;
									break;
								case 'C3';
									$tot_cat_c3++; 
									$arr_tot_cat_c3[$i]++;
									break;
								case 'D1';
									$tot_cat_d1++; 
									$arr_tot_cat_d1[$i]++;
									break;
								case 'D2';
									$tot_cat_d2++; 
									$arr_tot_cat_d2[$i]++;
									break;
								case 'D3';
									$tot_cat_d3++; 
									$arr_tot_cat_d3[$i]++;
									break;
								
								
								}	
							
							//CAMBIA ESTILO DE LA CELDA SI ES MULTIRESISTENTE 
							if($multiCamaPen == 1){
								$estiloCamaPen = " class='td_sscc_multires'";
								}
							
							//CAMBIA ESTILO DE LA CELDA SEGUN EL ESTADO DE LA CAMA
							if($estadoCamaPen == 4){
								$estiloCamaPen = " class ='td_sscc_dealta' ";
								}else{
									$estiloCamaPen = " class='td_sscc' ";
									}
							
																								
							//CAMBIA COLOR DE IMAGEN SEGUN CATEGORIZACION		
							switch($catRiesgoPen){
									case 'A';
											$bgImagen = "cama-a";
											break;
											
											case 'B';
											$bgImagen = "cama-b";
											break;
											
											case 'C';
											$bgImagen = "cama-c";
											break;
											
											case 'D';
											$bgImagen = "cama-d";
											break;
											
											case '';
											$bgImagen = "cama-sc";
											break;
							}
							//AGREGA IMAGEN DE MASCULINO O FEMENINO
							if($sexoCamaPen == 'M'){
								$imgSex = "-h";
							}else{
								$imgSex = "-m";
								}
							if($arrayCamasPensio['tipo_paciente'] == 'OBST'){
								$tipoPaciente = '-p';
								}else{
									$tipoPaciente = '';
									}
											
							$imagenFinalPen = $bgImagen.$imgSex.$tipoPaciente;
							$enlacePen = "";
							
																	
$infPacientePen = "<b>- Paciente</b> : ".$arrayCamasPensio['nombrePensio']."<br/><b>- Ingreso Hospital</b> : ".cambiarFormatoFecha2(substr(($arrayCamasPensio['hospPensio']),0,10))." - ".substr($arrayCamasPensio['hospPensio'],11,15)." Hrs."."<br/><b>- Dias Hospitalizado </b> : ".$diass." dias ".$horass." horas ".$minutoss." minutos <br /><b>- Ingreso al Servicio</b> : ".cambiarFormatoFecha2($arrayCamasPensio['fechaIngresoPensio'])." - ".$arrayCamasPensio['horaIngresoPensio']." Hrs."."<br/><b>- Dias en el Pensionado </b> : ".$diass." dias ".$horass." horas ".$minutoss." minutos <br /><b>- M�dico</b> : ".$arrayCamasPensio['n_medicoPensio']."<br/><b>- Pre Diagn�stico</b> : ".$arrayCamasPensio['diagn1Pensio']."<br/><b>- Diagn�stico</b> : ".$arrayCamasPensio['diagn2Pensio']."<br/><b>- Categorizacion</b> : ".$categorizacionPen." ( ".cambiarFormatoFecha2($arrayCamasPensio['cat_fechaPensio'])." )<br />";
							
							/* copia linea vivi mensaje 
$infPacientePen = "<b>- Paciente</b> : ".$arrayCamasPensio['nombrePensio']."<br/><b>- Ingreso Hospital</b> : ".cambiarFormatoFecha2(substr(($arrayCamasPensio['hospPensio']),0,10))." - ".substr($arrayCamasPensio['hospPensio'],11,15)." Hrs."."<br/><b>- Dias Hospitalizado </b> : ".$dias_espera_hospPensio." dias y ".$horas_espera_hospPensio." horas <br /><b>- Ingreso al Servicio</b> : ".cambiarFormatoFecha2($arrayCamasPensio['fechaIngresoPensio'])." - ".$arrayCamasPensio['horaIngresoPensio']." Hrs."."<br/><b>- Dias en el Pensionado </b> : ".$dias_esperaPensio." dias y ".$horas_esperaPensio." horas <br /><b>- M�dico</b> : ".$arrayCamasPensio['n_medicoPensio']."<br/><b>- Pre Diagn�stico</b> : ".$arrayCamasPensio['diagn1Pensio']."<br/><b>- Diagn�stico</b> : ".$arrayCamasPensio['diagn2Pensio']."<br/><b>- Categorizacion</b> : ".$categorizacionPen." ( ".cambiarFormatoFecha2($arrayCamasPensio['cat_fechaPensio'])." )<br />";
							
							 fin de la copia linea vivi */
							
							
							
							}else if($estadoCamaPen == 3){
								
								$estiloCamaPen = " class='td_sscc'";
								$infPacientePen = "<b>- Cama Bloqueada desde: </b>".cambiarFormatoFecha2(substr(($arrayCamasPensio['hospPensio']),0,10))." <br/><b> - Motivo: </b>".$arrayCamasPensio['diagn1Pensio'];
								$imagenFinalPen = "icono-block";
								$enlace = "";
																
								$camas_bloqueadas ++;
								$arr_camas_bloqueadas[$i] ++;
								
							}else if($estadoCamaPen == 5){
								
								$estiloCama = " class='td_sscc'";
								$infPacientePen = "<b>- Cama Bloqueada desde: </b>".cambiarFormatoFecha2(substr(($arrayCamasPensio['fechaIngresoPensio']),0,10))." <br/><b> - Motivo: </b>".$arrayCamasPensio['diagn2Pensio']."<br/><b> - Paciente: </b>".$pacienteSNPen;
								$imagenFinalPen = "icono-block-sn";
								$enlace = "";
								
								$camas_bloqueadas_sn ++;
								$arr_camas_bloqueadas_sn[$i] ++;
								
								}else{
								$estiloCama = " class='td_sscc'";
								$infPacientePen = "<b>- Cama ".$numCamaPen." :</b> Vacia<br/>- Haga clic para ingresar nuevo Paciente";
								$imagenFinalPen = "cama-vacia";
								$enlace = "";
								}
						?>
                        <tr>
                        	<td <?= $estiloCamaPen; ?>  style="font-size:8px; font-family:Arial, Helvetica, sans-serif;" ><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../../pensionado/img/<?= $imagenFinalPen; ?>.gif" width='30' height='30' /></a></td>
                        </tr>
                        <?
					  //CREA ARREGLO CON LAS VARIABLES DE LOS HINTS
							$infPacientePen = str_replace("\"", " ", $infPacientePen);
							$infPacientePen = str_replace("'", " ", $infPacientePen);
							$arreglo_camas[$i_mens_todos] = $infPacientePen;
							$i_mens_todos++;
                               
						 } ?>
                    </table>
                    </fieldset>
                </td>
                <? } 
				$total_camas = $arr_camas_desocupadas_adulto[$i]+$arr_camas_ocupadas[$i]+$arr_camas_bloqueadas[$i]+$arr_camas_bloqueadas_sn[$i];
				?>
            </tr>
            <tr>
            	<td colspan="<?= $total_salas; ?>">
                	<!-- INICIO TABLA DE OCUPACION PENSIONADO -->
                    <table style="border: 1px solid #6E6E6E" align='left' cellpadding="5px" cellspacing="1px"  >
                         <tr>
                        <td colspan="3" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"><strong>Detalle de Ocupaci�n</strong></td>
                    </tr>
                        <tr align="right">
                            <td colspan="1" align="left"id="linea_color" >Camas Ocupadas  </td>
                            <td align="right" id="linea_color"><? echo $arr_camas_ocupadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_ocupadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Libres</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_desocupadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_desocupadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Bloqueadas</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_bloqueadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_bloqueadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Bloqueadas SN</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_bloqueadas_sn[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_bloqueadas_sn[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Total Camas</td>
                            <td align="right" id="linea_color"><? echo $total_camas ?></td>
                            <td align="right" id="linea_color">100%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas x Categorizar</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_x_categorizar[$i] ?></td>
                            <td align="right" id="linea_color"><? if ($arr_camas_ocupadas[$i] <> 0) { echo number_format((($arr_camas_x_categorizar[$i]*100)/$arr_camas_ocupadas[$i]),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                            <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Categorizadas</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_categorizadas[$i] ?></td>
                            <td align="right" id="linea_color"><? if ($arr_camas_x_categorizar[$i] <> 0) { echo number_format((($arr_camas_categorizadas[$i]*100)/$arr_camas_x_categorizar[$i]),1,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
            
                    </table>
                    <!-- FIN TABLA DE OCUPACION PENSIONADO -->
                </td>
            </tr>
        </table>
        
        <!-- FIN PENSIONADO -->
            <? }else{ ?>
            <table border='0' width='100%'  >
			<tr>
			<td align='left' colspan="3" >
			<? 
			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query("SELECT * FROM camas where cod_servicio = $servicio order by sala, cama") or die(mysql_error());

			$sala = '0';
			
			$nro_salas = 0;
			$max_largo = 0;
			?>
			<table align='left'>
			<tr>
            	<td valign="top">
			<?
			while($camas = mysql_fetch_array($query)){
			
				if ($sala <> $camas['sala']){
				
					$nro_salas++;
					$max_largo = 0;
		
					if ($sala <>'0'){ ?>
                
                </table>
            </td>
            </tr>
        </table>
        </div>
        </div>
        </div>
        </div>
        
    </fieldset>
					<? } ?>

	
    <td valign="top">
					<fieldset style='background-image:url(img/fondosala.gif)'><legend style='font-size:10px' >S-<?= $camas['sala']; ?></legend>

					<table align='center' border='0' cellpadding='0px' cellspacing='0px'>
					<tr >
					<td valign="top">
					<table align='center'>
						<tr>
                        <td>
					<? $sala = $camas['sala'];
						}
						else
						{
							if ($max_largo == 6) {
								$max_largo = 0;
					?>
						</td>
                        </tr>
                    </table>
                    <td>
                    <table align='center'>
				<?	}
				 }
		
				$max_largo++;
		
				$id_cama = $camas['id'];
				$cama = $camas['cama'];
				$que_cod_servicio = $camas['que_cod_servicio'];
				$que_servicio = $camas['que_servicio'];
				$servicio = $camas['cod_servicio'];
				$sala = $camas['sala'];
				$desc_servicio = $camas['servicio'];
				$categorizacion_riesgo = $camas['categorizacion_riesgo'];
				$categorizacion_dependencia = $camas['categorizacion_dependencia'];
				$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
				$sexo_paciente = $camas['sexo_paciente'];
				$multires = $camas['multires'];
				$estado = $camas['estado'];
				$pabellon = $camas['pabellon'];
				$prevision = $camas['prevision'];
				$cod_prevision = $camas['cod_prevision'];

				$ingreso = $camas['fecha_ingreso'].' '.$camas['hora_ingreso'];
				$ingreso_hosp = $camas['hospitalizado'];
				$egreso = $camas['fecha_hoy'].' '.$camas['hora_hoy'];
				
				$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
				
				$dias_espera = ($tiempo_espera / 24);
				$decimales = explode(".",$dias_espera);
				$dias_espera = $decimales[0];
				$horas_espera = ($tiempo_espera - ($dias_espera*24));
				
				$tiempo_espera_hosp = intval((strtotime($egreso)-strtotime($ingreso_hosp))/3600);

				$dias_espera_hosp = ($tiempo_espera_hosp / 24);
				$decimales = explode(".",$dias_espera_hosp);
				$dias_espera_hosp = $decimales[0];
				$horas_espera_hosp = ($tiempo_espera_hosp - ($dias_espera_hosp*24));

				switch ($camas['estado']){
					case 1:
						$inf_paciente = "Cama N�mero : ".$cama;

						?>
						<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
						rel='gb_page_center[850, 550]'><img class='img_pr' src='img/cama-vacia.gif' width='30' height='30' /></a>
						<?
                        if ($servicio <> 50)
						{
							$camas_desocupadas ++;
							$arr_camas_desocupadas[$i] ++;
							if(($servicio == 1) or ($servicio == 2) or ($servicio == 3) or ($servicio == 4) or ($servicio == 5) or ($servicio == 12)){
								$camas_desocupadas_adulto ++;
								$arr_camas_desocupadas_adulto[$i] ++;
								}
						}
						else
						{
							if ($sala == " CAMAS HOSP CMA")
							{
								$t_cma_desocupadas++;
							}
							else
							{
								$t_urg_desocupadas++;
							}
						}

						break;
					case 2:
						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso Hospital</b> &nbsp;&nbsp;: ".cambiarFormatoFecha2(substr($camas['hospitalizado'],0,10))." - ".substr($camas['hospitalizado'],11,5)." Hrs. <br /> <b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /> <b>- Ingreso Servicio</b> &nbsp;&nbsp; : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Prevision</b> : ".$prevision;


						$logo_cama = 'cama-sc';
						
						if ($servicio <> 50)
						{
							if ($categorizacion == 'A1') { $logo_cama = 'cama-a'; $tot_cat_a1++; $arr_tot_cat_a1[$i]++; }
							if ($categorizacion == 'A2') { $logo_cama = 'cama-a'; $tot_cat_a2++; $arr_tot_cat_a2[$i]++; }
							if ($categorizacion == 'A3') { $logo_cama = 'cama-a'; $tot_cat_a3++; $arr_tot_cat_a3[$i]++; }
							if ($categorizacion == 'B1') { $logo_cama = 'cama-b'; $tot_cat_b1++; $arr_tot_cat_b1[$i]++; }
							if ($categorizacion == 'B2') { $logo_cama = 'cama-b'; $tot_cat_b2++; $arr_tot_cat_b2[$i]++; }
							if ($categorizacion == 'B3') { $logo_cama = 'cama-b'; $tot_cat_b3++; $arr_tot_cat_b3[$i]++; }
							if ($categorizacion == 'C1') { $logo_cama = 'cama-c'; $tot_cat_c1++; $arr_tot_cat_c1[$i]++; }
							if ($categorizacion == 'C2') { $logo_cama = 'cama-c'; $tot_cat_c2++; $arr_tot_cat_c2[$i]++; }
							if ($categorizacion == 'C3') { $logo_cama = 'cama-c'; $tot_cat_c3++; $arr_tot_cat_c3[$i]++; }
							if ($categorizacion == 'D1') { $logo_cama = 'cama-d'; $tot_cat_d1++; $arr_tot_cat_d1[$i]++; }
							if ($categorizacion == 'D2') { $logo_cama = 'cama-d'; $tot_cat_d2++; $arr_tot_cat_d2[$i]++; }
							if ($categorizacion == 'D3') { $logo_cama = 'cama-d'; $tot_cat_d3++; $arr_tot_cat_d3[$i]++; }
						}
						else
						{
							if ($sala == " CAMAS HOSP CMA")
							{
								$t_cma_ocupadas++;

								$logo_cama = 'cama-sc';
							}
							else
							{
								$t_urg_ocupadas++;
								
								if ($tiempo_espera <= 3) { $logo_cama = 'cama-a'; $total_b_00_03++; }
								if ($tiempo_espera > 3 and $tiempo_espera <= 8) { $logo_cama = 'cama-b'; $total_b_03_08++; }
								if ($tiempo_espera > 8 and $tiempo_espera <= 12) { $logo_cama = 'cama-c'; $total_b_08_12++; }
								if ($tiempo_espera > 12) { $logo_cama = 'cama-d'; $total_b_12_ms++; }

							}

						}
						
						
						if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m'; }
						else { $logo_cama = $logo_cama.'-h'; }

						if ($pabellon == 1){ $logo_cama = str_replace("cama","pabe",$logo_cama);}
						
						if(($cod_prevision >=2) && ($pabellon <> 1)){
							$logo_cama.="_prev";
							}
						$logo_cama.= ".gif";
						
						?>
						<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
						<?
						
						$que_color_paciente = "img_pr";
						
						if ($servicio <> $que_cod_servicio and $servicio <> 50)
						{
							$que_color_paciente = "img_pr_otroservicio";
						}
						
						if ($multires == 1)
						{
							$que_color_paciente = "img_pr_multires";
						} ?>
											
						rel='gb_page_center[850, 570]'><img class=<?= $que_color_paciente; ?> src='img/<?= $logo_cama; ?>' width='30' height='30' /></a>
						
						<?
						$camas_ocupadas ++;
						$arr_camas_ocupadas[$i] ++;
						
						if ($camas['fecha_ingreso'] < $fecha_hoy)
						{
							$camas_x_categorizar ++;
							$arr_camas_x_categorizar[$i] ++;
							
						}
						if ($camas['fecha_categorizacion'] == $fecha_hoy)
						{
							$camas_categorizadas ++;
							$arr_camas_categorizadas[$i] ++;
						}
						
						break;
					case 3:
						$inf_paciente = "<b>- Cama Bloqueada Desde</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Motivo</b> : ".$camas['diagnostico1'];			

						?>
						<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
						 rel='gb_page_center[850, 550]'><img class='img_pr' src='img/icono-sn.gif' width='30' height='30' /></a>

						<?
                        if ($servicio <> 50)
						{
							$camas_bloqueadas ++;
							$arr_camas_bloqueadas[$i] ++;
						}
						else
						{
							if ($sala == " CAMAS HOSP CMA")
							{
								$t_cma_bloqueadas++;
							}
							else
							{
								$t_urg_bloqueadas++;
							}
						}
						break;
					case 4:
						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso Hospital</b> &nbsp;&nbsp;: ".cambiarFormatoFecha2(substr($camas['hospitalizado'],0,10))." - ".substr($camas['hospitalizado'],11,5)." Hrs. <br /> <b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /> <b>- Ingreso Servicio</b> &nbsp;&nbsp; : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Prevision</b> : ".$prevision;


						$logo_cama = 'cama-sc';
						
						if ($servicio <> 50)
						{
							if ($categorizacion == 'A1') { $logo_cama = 'cama-a'; $tot_cat_a1++; $arr_tot_cat_a1[$i]++; }
							if ($categorizacion == 'A2') { $logo_cama = 'cama-a'; $tot_cat_a2++; $arr_tot_cat_a2[$i]++; }
							if ($categorizacion == 'A3') { $logo_cama = 'cama-a'; $tot_cat_a3++; $arr_tot_cat_a3[$i]++; }
							if ($categorizacion == 'B1') { $logo_cama = 'cama-b'; $tot_cat_b1++; $arr_tot_cat_b1[$i]++; }
							if ($categorizacion == 'B2') { $logo_cama = 'cama-b'; $tot_cat_b2++; $arr_tot_cat_b2[$i]++; }
							if ($categorizacion == 'B3') { $logo_cama = 'cama-b'; $tot_cat_b3++; $arr_tot_cat_b3[$i]++; }
							if ($categorizacion == 'C1') { $logo_cama = 'cama-c'; $tot_cat_c1++; $arr_tot_cat_c1[$i]++; }
							if ($categorizacion == 'C2') { $logo_cama = 'cama-c'; $tot_cat_c2++; $arr_tot_cat_c2[$i]++; }
							if ($categorizacion == 'C3') { $logo_cama = 'cama-c'; $tot_cat_c3++; $arr_tot_cat_c3[$i]++; }
							if ($categorizacion == 'D1') { $logo_cama = 'cama-d'; $tot_cat_d1++; $arr_tot_cat_d1[$i]++; }
							if ($categorizacion == 'D2') { $logo_cama = 'cama-d'; $tot_cat_d2++; $arr_tot_cat_d2[$i]++; }
							if ($categorizacion == 'D3') { $logo_cama = 'cama-d'; $tot_cat_d3++; $arr_tot_cat_d3[$i]++; }
						}
						else{
							if ($sala == " CAMAS HOSP CMA"){
								$t_cma_ocupadas++;
								$logo_cama = 'cama-sc';
							}
							else {
								$t_urg_ocupadas++;
								
								if ($tiempo_espera <= 3) { $logo_cama = 'cama-a'; $total_b_00_03++; }
								if ($tiempo_espera > 3 and $tiempo_espera <= 8) { $logo_cama = 'cama-b'; $total_b_03_08++; }
								if ($tiempo_espera > 8 and $tiempo_espera <= 12) { $logo_cama = 'cama-c'; $total_b_08_12++; }
								if ($tiempo_espera > 12) { $logo_cama = 'cama-d'; $total_b_12_ms++; }
							}
						}
						
						
						if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m'; }
						else { $logo_cama = $logo_cama.'-h'; }
						
						if ($pabellon == 1){ $logo_cama = str_replace("cama","pabe",$logo_cama);}
						
						if(($cod_prevision >=2) && ($pabellon <> 1)){
							$logo_cama.="_prev";
							}
						$logo_cama.= ".gif";
						?>
						<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
						rel='gb_page_center[850, 570]'><img class='img_pr_dealta' src='img/<?= $logo_cama; ?>' width='30' height='30' /></a>
						
                        <?
						$camas_ocupadas ++;
						$arr_camas_ocupadas[$i] ++;
						if ($camas['fecha_ingreso'] < $fecha_hoy){
							$camas_x_categorizar ++;
							$arr_camas_x_categorizar[$i] ++;
						}
						if ($camas['fecha_categorizacion'] == $fecha_hoy)
						{
							$camas_categorizadas ++;
							$arr_camas_categorizadas[$i] ++;
						}

						
						break;
					//NUEVO ESTADO DE CAMA SUPER NUMERARIA
					case 5:
						$sqlCamaSN = mysql_query("SELECT * FROM listaSN WHERE que_idcamaSN = $id_cama"); 
						$arrayCamaSN = mysql_fetch_array($sqlCamaSN);
						
						$inf_paciente = "<b>- Cama Bloqueada Desde</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Paciente</b> : ".$arrayCamaSN['nomPacienteSN']."<br /> <b>- Sala </b> : ".$arrayCamaSN['que_salaSN']."<b> Cama </b> : ".$arrayCamaSN['que_camaSN']."<br /> <b>- Servicio:</b> : ".$arrayCamaSN['desde_nomServSN']."<br /> <b>- Motivo</b> : ".$camas['diagnostico1'];			

						?>
						<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
						rel='gb_page_center[850, 550]'><img class='img_pr' src='../superNumeraria/img/cama-vacia-sn.gif' width='30' height='30' /></a>

						<?
                        if ($servicio <> 50)
						{
							$camas_bloqueadas_sn ++;
							$arr_camas_bloqueadas_sn[$i] ++;
						}
						else
						{
							if ($sala == " CAMAS HOSP CMA")
							{
								$t_cma_bloqueadas++;
							}
							else
							{
								$t_urg_bloqueadas++;
							}
						}
						break;
						
				}

				$inf_paciente = str_replace("'", " ", $inf_paciente);

				$arreglo_camas[$i_mens_todos] = $inf_paciente;
				$i_mens_todos++;
			
			}
			?>
		
				</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</fieldset>
			</table>
			</td>
  <td valign='top' width='255px' align='center'>
			
            <?
                $arr_total_categorizado = $arr_tot_cat_a1[$i]+$arr_tot_cat_a2[$i]+$arr_tot_cat_a3[$i]+$arr_tot_cat_b1[$i]+$arr_tot_cat_b2[$i]+$arr_tot_cat_b3[$i]+$arr_tot_cat_c1[$i]+$arr_tot_cat_c2[$i]+$arr_tot_cat_c3[$i]+$arr_tot_cat_d1[$i]+$arr_tot_cat_d2[$i]+$arr_tot_cat_d3[$i];
				$arr_total_cat_a = $arr_tot_cat_a1[$i]+$arr_tot_cat_a2[$i]+$arr_tot_cat_a3[$i];
				$arr_total_cat_b = $arr_tot_cat_b1[$i]+$arr_tot_cat_b2[$i]+$arr_tot_cat_b3[$i];
				$arr_total_cat_c = $arr_tot_cat_c1[$i]+$arr_tot_cat_c2[$i]+$arr_tot_cat_c3[$i];
				$arr_total_cat_d = $arr_tot_cat_d1[$i]+$arr_tot_cat_d2[$i]+$arr_tot_cat_d3[$i];

//				echo $servicios[$i];
				if 	($servicios[$i] >= 45)
				{
				
					$no_ocupadas    = $no_ocupadas + $arr_camas_ocupadas[$i];
					$no_desocupadas = $no_desocupadas + $arr_camas_desocupadas[$i];
					$no_desocupadas_adulto = $no_desocupadas_adulto + $arr_camas_desocupadas_adulto[$i];
					$no_bloqueadas  = $no_bloqueadas + $arr_camas_bloqueadas[$i];
					$no_bloqueadas_sn  = $no_bloqueadas_sn + $arr_camas_bloqueadas_sn[$i];
					$no_arr_tot_cat_a1 = $no_arr_tot_cat_a2 + $arr_tot_cat_a2[$i];
					$no_arr_tot_cat_a3 = $no_arr_tot_cat_a3 + $arr_tot_cat_a3[$i];
					$no_arr_tot_cat_b1 = $no_arr_tot_cat_b1 + $arr_tot_cat_b1[$i];
					$no_arr_tot_cat_b2 = $no_arr_tot_cat_b2 + $arr_tot_cat_b2[$i];
					$no_arr_tot_cat_b3 = $no_arr_tot_cat_b3 + $arr_tot_cat_b3[$i];
					$no_arr_tot_cat_c1 = $no_arr_tot_cat_c1 + $arr_tot_cat_c1[$i];
					$no_arr_tot_cat_c2 = $no_arr_tot_cat_c2 + $arr_tot_cat_c2[$i];
					$no_arr_tot_cat_c3 = $no_arr_tot_cat_c3 + $arr_tot_cat_c3[$i];
					$no_arr_tot_cat_d1 = $no_arr_tot_cat_d1 + $arr_tot_cat_d1[$i];
					$no_arr_tot_cat_d2 = $no_arr_tot_cat_d2 + $arr_tot_cat_d2[$i];
					$no_arr_tot_cat_d3 = $no_arr_tot_cat_d3 + $arr_tot_cat_d3[$i];
					
					$no_categorizadas  = $no_categorizadas + $arr_camas_categorizadas[$i];
					$no_x_categorizar  = $no_x_categorizar + $arr_camas_x_categorizar[$i];
				}
				
               	$total_camas = $arr_camas_ocupadas[$i]+$arr_camas_desocupadas[$i]+$arr_camas_bloqueadas[$i]+$arr_camas_bloqueadas_sn[$i];

//				if ( $arr_total_categorizado == '0')
				if 	($servicios[$i] == 50){
               	$total_cma_camas = $t_cma_ocupadas+$t_cma_desocupadas+$t_cma_bloqueadas;
               	$total_urg_camas = $t_urg_ocupadas+$t_urg_desocupadas+$t_urg_bloqueadas;
					
				?>
                
	<table width="100%" border="0">
                <tr>
                <td>
                    <table width="100%"  align="left" border="1" cellpadding="0px" cellspacing="0px">
                        <tr align="right">
                            <td colspan="3" align="center">Camas Transitorias Hospitalizacion CMA.</td>
                        </tr>

                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Ocupadas</td>
                            <td align="right" id="linea_color"><? echo $t_cma_ocupadas ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($t_cma_ocupadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Camas Libres</td>
                            <td align="right"><? echo $t_cma_desocupadas ?></td>
                            <td align="right"><? echo number_format((($t_cma_desocupadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Camas Bloqueadas</td>
                            <td align="right"><? echo $t_cma_bloqueadas ?></td>
                            <td align="right"><? echo number_format((($t_cma_bloqueadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                       
                        <tr align="right">
                            <td colspan="1" align="left">Total Camas</td>
                            <td align="right"><? echo $total_cma_camas ?></td>
                            <td align="right">100%</td>
                        </tr>
                        <tr align="right" height="5">
                            <td colspan="3" align="center"></td>
                        </tr>
                        <tr align="right">
                            <td colspan="3" align="center">Pacientes Hosp. en Box de Urgencia.</td>
                        </tr>

                        <tr align="right">
                            <td colspan="1" align="left">Ocupacion</td>
                            <td align="right"><? echo $t_urg_ocupadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_ocupadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Disponibilidad</td>
                            <td align="right"><? echo $t_urg_desocupadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_desocupadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Bloqueos</td>
                            <td align="right"><? echo $t_urg_bloqueadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_bloqueadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Total Camas</td>
                            <td align="right"><? echo $total_urg_camas ?></td>
                            <td align="right">100%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Espera Menos de 3 Hrs.</td>
                            <td align="right"><? echo number_format(($total_b_00_03),0,",",".") ?></td>
                            <td align="right"><? if ($total_urg_camas <> 0) { echo number_format((($total_b_00_03*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Espera Entre 3 y 8 Hrs.</td>
                            <td align="right"><? echo number_format(($total_b_03_08),0,",",".") ?></td>
                            <td align="right"><? if ($total_urg_camas <> 0) { echo number_format((($total_b_03_08*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Espera Entre 8 y 12 Hrs.</td>
                            <td align="right"><? echo number_format(($total_b_08_12),0,",",".") ?></td>
                            <td align="right"><? if ($total_urg_camas <> 0) { echo number_format((($total_b_08_12*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Espera Mas de 12 Hrs.</td>
                            <td align="right"><? echo number_format(($total_b_12_ms),0,",",".") ?></td>
                            <td align="right"><? if ($total_urg_camas <> 0) { echo number_format((($total_b_12_ms*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>

                    </table>
				</td>
                </tr>

                </table>
				<? } ?>
                       
            </td>
            </tr>
<!-- Danny Inicio-->             
            <tr>
<td>
 
 <fieldset><legend style="font-size:16px">Resumen por Servicio <strong>[<? echo $desc_servicio; ?>]</strong></legend>
 	<table >
            <tr>
            
            <td>
         <? if 	($servicios[$i] != 50){ ?>   
			            <table width="250px" height="170" align='left' style="border:1px solid #6E6E6E" cellpadding="1px" cellspacing="0px">
                       <tr>
                        <td colspan="3" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"><strong>Detalle de Ocupaci�n</strong></td>
                    </tr>
                        <tr align="right">
                            <td align="left" id="linea_color">Camas Ocupadas</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_ocupadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_ocupadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right" >
                            <td colspan="1" align="left" id="linea_color">Camas Libres</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_desocupadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_desocupadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Bloqueadas</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_bloqueadas[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_bloqueadas[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas Bloqueadas SN</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_bloqueadas_sn[$i] ?></td>
                            <td align="right" id="linea_color"><? echo number_format((($arr_camas_bloqueadas_sn[$i]*100)/$total_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Total Camas</td>
                            <td align="right" id="linea_color"><? echo $total_camas ?></td>
                            <td align="right" id="linea_color">100%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" id="linea_color">Camas x Categorizar</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_x_categorizar[$i] ?></td>
                            <td align="right" id="linea_color"><? if ($arr_camas_ocupadas[$i] <> 0) { echo number_format((($arr_camas_x_categorizar[$i]*100)/$arr_camas_ocupadas[$i]),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                            <tr align="right">
                            <td colspan="1" align="left"id="linea_color">Camas Categorizadas</td>
                            <td align="right" id="linea_color"><? echo $arr_camas_categorizadas[$i] ?></td>
                            <td align="right" id="linea_color"><? if ($arr_camas_x_categorizar[$i] <> 0) { echo number_format((($arr_camas_categorizadas[$i]*100)/$arr_camas_x_categorizar[$i]),1,",","."); } else { echo "0"; } ?>%</td>
                        </tr>

                    </table>
            </td>
            <td>&nbsp;</td>
            <td>
         		   <? if ( $arr_total_categorizado <> '0'){ ?>
          <table width="250px"  height="170"align='left' style="border: 1px solid #6E6E6E" cellpadding="5px" cellspacing="0px">
           <tr>
                        <td colspan="12" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"><strong>Resumen de Categorizaci�n</strong></td>
                    </tr>
              <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color" width="30">A1</td>
                        <td bgcolor="#00CC33" id="linea_color" width="30"><? echo $arr_tot_cat_a1[$i] ?></td>
                        <td bgcolor="#00CC33" id="linea_color" width="30"><? echo number_format((($arr_tot_cat_a1[$i]*100)/$arr_total_categorizado),1,",",".") ?>%%</td>
                        <td bgcolor="#FFFF00" id="linea_color" width="30">B1</td>
                        <td bgcolor="#FFFF00" id="linea_color" width="30"><? echo $arr_tot_cat_b1[$i] ?></td>
                        <td bgcolor="#FFFF00" id="linea_color" width="30"><? echo number_format((($arr_tot_cat_b1[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color" width="30">C1</td>
                        <td bgcolor="#FFCC33" id="linea_color" width="30"><? echo $arr_tot_cat_c1[$i] ?></td>
                        <td bgcolor="#FFCC33" id="linea_color" width="30"><? echo number_format((($arr_tot_cat_c1[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color" width="30"> <font color="#FFFFFF">D1</font></td>
                        <td bgcolor="#FF0000" id="linea_color" width="30"> <font color="#FFFFFF"><? echo $arr_tot_cat_d1[$i] ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color" width="30"> <font color="#FFFFFF"><? echo number_format((($arr_tot_cat_d1[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color">A2</td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $arr_tot_cat_a2[$i] ?></td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $arr_tot_cat_a2[$i] ?>%</td>
                        <td bgcolor="#FFFF00" id="linea_color">B2</td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo $arr_tot_cat_b2[$i] ?></td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo number_format((($arr_tot_cat_b2[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color">C2</td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo $arr_tot_cat_c2[$i] ?></td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo number_format((($arr_tot_cat_c2[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF">D2</font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo $arr_tot_cat_d2[$i] ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo number_format((($arr_tot_cat_d2[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color">A3</td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $arr_tot_cat_a3[$i] ?></td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo number_format((($arr_tot_cat_a3[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FFFF00" id="linea_color">B3</td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo $arr_tot_cat_b3[$i] ?></td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo number_format((($arr_tot_cat_b3[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color">C3</td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo $arr_tot_cat_c3[$i] ?></td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo number_format((($arr_tot_cat_c3[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF">D3</font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo $arr_tot_cat_d3[$i] ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo number_format((($arr_tot_cat_d3[$i]*100)/$arr_total_categorizado),1,",",".") ?>%</font></td>
                    </tr>
          </table>
          <? } ?>
            </td>
            <td>&nbsp;</td>
          <? } ?> 
          		<td>
  				        <table width="270px" height="170"  align='left' style="border: 1px solid #6E6E6E" cellpadding="0px" cellspacing="0px">
                  <tr>
                        <td colspan="3" bgcolor="#6E6E6E" style="color:#FFFFFF"><center> <strong>Resumen de Camas Categorizada</strong></center></td>
                    </tr>
                    <tr align="center">
                    	<td id="linea_color">Cuidados</td>
                        <td id="linea_color">TOTAL</td>
                        <td id="linea_color"> % sobre <?=$arr_total_categorizado?></td>
                    </tr>
                    <tr align="right">
                        <td align="left" id="linea_color"> Criticos </td><td id="linea_color" ><? echo ($arr_tot_cat_a1[$i]+$arr_tot_cat_a2[$i]+$arr_tot_cat_a3[$i]+$arr_tot_cat_b1[$i]+$arr_tot_cat_b2[$i]); ?></td>
                        
                        <td id="linea_color"><? if($arr_total_categorizado!=0){ echo number_format(((($arr_tot_cat_a1[$i]+$arr_tot_cat_a2[$i]+$arr_tot_cat_a3[$i]+$arr_tot_cat_b1[$i]+$arr_tot_cat_b2[$i])*100)/$arr_total_categorizado),1,",",".");}else{echo 0;} ?>%</td>
                    </tr>
                    <tr align="right">
                        <td align="left" id="linea_color"> Medios </td><td id="linea_color"><? echo ($arr_tot_cat_b3[$i]+$arr_tot_cat_c1[$i]+$arr_tot_cat_c2[$i]); ?></td>
                        
                        <td id="linea_color"><? if($arr_total_categorizado !=0){ echo number_format(((($arr_tot_cat_b3[$i]+$arr_tot_cat_c1[$i]+$arr_tot_cat_c2[$i])*100)/$arr_total_categorizado),1,",",".");}else{ echo 0;} ?>%</td>
                    </tr>
                    <tr align="right">
                        <td align="left" id="linea_color"> Basicos </td><td id="linea_color"><? echo ($arr_tot_cat_c3[$i]+$arr_tot_cat_d1[$i]+$arr_tot_cat_d2[$i]+$arr_tot_cat_d3[$i]); ?></td>
                        
                        <td id="linea_color"><? if ($arr_total_categorizado !=0){echo number_format(((($arr_tot_cat_c3[$i]+$arr_tot_cat_d1[$i]+$arr_tot_cat_d2[$i]+$arr_tot_cat_d3[$i])*100)/$arr_total_categorizado),1,",",".");}else{ echo 0;} ?>%</td>
                    </tr>
                    <tr align="right">
                    <td id="linea_color" align="left">TOTAL</td>
                    <td id="linea_color"><? echo (($arr_tot_cat_a1[$i]+$arr_tot_cat_a2[$i]+$arr_tot_cat_a3[$i]+$arr_tot_cat_b1[$i]+$arr_tot_cat_b2[$i]) + ($arr_tot_cat_b3[$i]+$arr_tot_cat_c1[$i]+$arr_tot_cat_c2[$i]) + ($arr_tot_cat_c3[$i]+$arr_tot_cat_d1[$i]+$arr_tot_cat_d2[$i]+$arr_tot_cat_d3[$i]));?></td>
                    
                    <td id="linea_color"><? if($arr_total_categorizado !=0){ echo number_format(((($arr_tot_cat_a1[$i] + $arr_tot_cat_a2[$i] + $arr_tot_cat_a3[$i] + $arr_tot_cat_b1[$i] + $arr_tot_cat_b2[$i] + $arr_tot_cat_b3[$i] + $arr_tot_cat_c1[$i] + $arr_tot_cat_c2[$i] + $arr_tot_cat_c3[$i] + $arr_tot_cat_d1[$i] + $arr_tot_cat_d2[$i] + $arr_tot_cat_d3[$i])*100)/$arr_total_categorizado),1,",","."); }else{ echo 0;} ?>%</td>
                    </tr>
                </table>
                </td> 
            </tr>
    </table>
   </fieldset>
             
</td>
</tr>
 <!-- Danny Fin-->            
            
            
            
            </table>
            
        
            
			
			<? } ?>
</div>
<?		}


$mens_todos = "'".implode("','",$arreglo_camas)."'";

		?>
      </div>
    </div>

</div>

</form>




</td>
</tr>




<tr>
<td>
            <fieldset style="padding-left:15px"> <legend style="font-size:16px">Resumen <strong>Hospital</strong> ( No Considera Urgencia, Hospitalizaci&oacute;n Domiciliaria y Partos ) &nbsp;&nbsp;<? echo cambiarFormatoFecha2($fecha_hoy)." - ".$hora_hoy." Hrs."; ?>
</legend>
<table width="100%" align="left">
    <tr>
		<td colspan="10">

                <?

				$camas_ocupadas    = $camas_ocupadas    - $no_ocupadas;
				$camas_desocupadas_adulto = $camas_desocupadas_adulto - $no_desocupadas_adulto;
				$camas_desocupadas = $camas_desocupadas - $camas_desocupadas_adulto - $no_desocupadas;
				$camas_bloqueadas  = $camas_bloqueadas  - $no_bloqueadas;
				$camas_bloqueadas_sn  = $camas_bloqueadas_sn  - $no_bloqueadas_sn;
				$tot_cat_a1 = $tot_cat_a1 - $no_arr_tot_cat_a1;
				$tot_cat_a2 = $tot_cat_a2 - $no_arr_tot_cat_a2;
				$tot_cat_a3 = $tot_cat_a3 - $no_arr_tot_cat_a3;
				$tot_cat_b1 = $tot_cat_b1 - $no_arr_tot_cat_b1;
				$tot_cat_b2 = $tot_cat_b2 - $no_arr_tot_cat_b2;
				$tot_cat_b3 = $tot_cat_b3 - $no_arr_tot_cat_b3;
				$tot_cat_c1 = $tot_cat_c1 - $no_arr_tot_cat_c1;
				$tot_cat_c2 = $tot_cat_c2 - $no_arr_tot_cat_c2;
				$tot_cat_c3 = $tot_cat_c3 - $no_arr_tot_cat_c3;
				$tot_cat_d1 = $tot_cat_d1 - $no_arr_tot_cat_d1;
				$tot_cat_d2 = $tot_cat_d2 - $no_arr_tot_cat_d2;
				$tot_cat_d3 = $tot_cat_d3 - $no_arr_tot_cat_d3;

				$camas_categorizadas  = $camas_categorizadas - $no_categorizadas;
				$camas_x_categorizar  = $camas_x_categorizar - $no_x_categorizar;


				$total_categorizado = $tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3;
				$total_cat_a = $tot_cat_a1+$tot_cat_a2+$tot_cat_a3;
				$total_cat_b = $tot_cat_b1+$tot_cat_b2+$tot_cat_b3;
				$total_cat_c = $tot_cat_c1+$tot_cat_c2+$tot_cat_c3;
				$total_cat_d = $tot_cat_d1+$tot_cat_d2+$tot_cat_d3;

               	$total_general_camas = $camas_ocupadas+$camas_desocupadas+$camas_desocupadas_adulto+$camas_bloqueadas+$camas_bloqueadas_sn;

        		?>


                <table height="250" style="border: 1px solid #6E6E6E" align='left' cellpadding="7px" cellspacing="1px" >
                  <tr>
                        <td colspan="3" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"><strong>Detalle de Ocupaci�n</strong></td>
                    </tr>
                    <tr>
                        <td align="left"  id="linea_color">Camas Ocupadas</td>
                        <td align="right" id="linea_color" >&nbsp;<? echo $camas_ocupadas ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_ocupadas*100)/$total_general_camas),2,",",".") ?>%</td>

                    </tr>
                    <tr>
                        <td align="left"  id="linea_color" >Camas Libres</td>
                        <td align="right"  id="linea_color"><? echo $camas_desocupadas ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_desocupadas*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left" id="linea_color">Camas Libres Adulto</td>
                        <td align="right"  id="linea_color"><? echo $camas_desocupadas_adulto ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_desocupadas_adulto*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left"  id="linea_color">Camas Bloqueadas</td>
                        <td align="right" id="linea_color" ><? echo $camas_bloqueadas ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_bloqueadas*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left" id="linea_color">Camas Bloqueadas SN</td>
                        <td align="right" id="linea_color"><? echo $camas_bloqueadas_sn; ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_bloqueadas_sn*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left" id="linea_color">Totales</td>
                        <td align="right" id="linea_color"><? echo $total_general_camas ?></td>
                        <td id="linea_color">100%</td>
                    </tr>
                </table>
                </td>
                <td>
               <table height="250" align='left' style="border: 1px solid #6E6E6E" cellpadding="7px" cellspacing="1px">
                    <tr>
                        <td colspan="12" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"><strong>Resumen de Categorizaci�n</strong></td>
                    </tr>
                    
                    <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color">A1</td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $tot_cat_a1 ?></td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo number_format((($tot_cat_a1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00" id="linea_color">B1</td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo $tot_cat_b1 ?></td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo number_format((($tot_cat_b1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color">C1</td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo $tot_cat_c1 ?></td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo number_format((($tot_cat_c1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF">D1</font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo $tot_cat_d1 ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d1*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color">A2</td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $tot_cat_a2 ?></td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo number_format((($tot_cat_a2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00" id="linea_color">B2</td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo $tot_cat_b2 ?></td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo number_format((($tot_cat_b2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color">C2</td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo $tot_cat_c2 ?></td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo number_format((($tot_cat_c2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF">D2</font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo $tot_cat_d2 ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d2*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33" id="linea_color">A3</td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo $tot_cat_a3 ?></td>
                        <td bgcolor="#00CC33" id="linea_color"><? echo number_format((($tot_cat_a3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00" id="linea_color">B3</td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo $tot_cat_b3 ?></td>
                        <td bgcolor="#FFFF00" id="linea_color"><? echo number_format((($tot_cat_b3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33" id="linea_color">C3</td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo $tot_cat_c3 ?></td>
                        <td bgcolor="#FFCC33" id="linea_color"><? echo number_format((($tot_cat_c3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF">D3</font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo $tot_cat_d3 ?></font></td>
                        <td bgcolor="#FF0000" id="linea_color"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d3*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td align="left" bgcolor="#00CC33">A</td>
                        <td bgcolor="#00CC33"><? echo $total_cat_a ?></td>
                        <td bgcolor="#00CC33"><? echo number_format((($total_cat_a*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FFFF00">B</td>
                        <td bgcolor="#FFFF00"><? echo $total_cat_b ?></td>
                        <td bgcolor="#FFFF00"><? echo number_format((($total_cat_b*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FFCC33">C</td>
                        <td bgcolor="#FFCC33"><? echo $total_cat_c ?></td>
                        <td bgcolor="#FFCC33"><? echo number_format((($total_cat_c*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FF0000"> <font color="#FFFFFF">D</font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo $total_cat_d ?></font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo number_format((($total_cat_d*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>

                </table>
                 </td>
                <td>
                <table height="250" align='left' style="border: 1px solid #6E6E6E" cellpadding="7px" cellspacing="1px">
                  <tr>
                        <td colspan="2" bgcolor="#6E6E6E" style="color:#FFFFFF" align="center"> <strong>Categorizaci�n Diaria</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" id="linea_color">Camas x Categorizar</td>
                    </tr>
                    <tr>
                        <td align="right" id="linea_color"><? echo $camas_x_categorizar ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_x_categorizar*100)/$camas_ocupadas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" id="linea_color">Camas Categorizadas</td>
                    </tr>
                    <tr>
                        <td align="right" id="linea_color"><? echo $camas_categorizadas ?></td>
                        <td align="right" id="linea_color"><? echo number_format((($camas_categorizadas*100)/$camas_x_categorizar),2,",",".") ?>%</td>
                    </tr>
                </table>
                 </td>
              <td>
                <!-- danny -->
				<table height="250" align='left' style="border: 1px solid #6E6E6E" cellpadding="0px" cellspacing="1px">
                  <tr>
                        <td colspan="3" bgcolor="#6E6E6E" style="color:#FFFFFF"><center> <strong>Resumen de Camas</strong></center></td>
                    </tr>
                    <tr>
                    <td id="linea_color">Cuidados</td>
                    <td id="linea_color">Camas</td>
                    <td id="linea_color">% sobre <?=($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)?></td>
                    </tr>
                  <tr>
                        <td align="left" id="linea_color">Criticos </td><td id="linea_color"><center><? $ccriticos = $tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2; echo $ccriticos; ?></center></td>
                        <td id="linea_color"><? echo number_format(((($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2)*100)/($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)),2,",",".");?>%</td>
                    </tr>
                    <tr>
                        <td align="left" id="linea_color">Medios </td><td id="linea_color"><center><? $cmedios = $tot_cat_b3+$tot_cat_c1+$tot_cat_c2; echo $cmedios; ?></center></td>
                        <td id="linea_color"><? echo number_format(((($tot_cat_b3+$tot_cat_c1+$tot_cat_c2)*100)/($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)),2,",",".");?>%</td>
                    </tr>
                    <tr>
                        <td align="left" id="linea_color">Basicos </td><td id="linea_color"><center><? $cbasicos = $tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3; echo $cbasicos; ?></center></td>
                        <td id="linea_color"><? echo number_format(((($tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)*100)/($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)),2,",",".");?>%</td>
                    </tr>
                    <tr>
                    <td id="linea_color">TOTAL</td>
                    <td id="linea_color"><center><? echo ($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2) + ($tot_cat_b3+$tot_cat_c1+$tot_cat_c2) + ($tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)?></center></td>
                    <td id="linea_color"><? echo number_format(((($ccriticos+$cmedios+$cbasicos)*100)/($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)),1,",","."); ?>%</td>
                    </tr>
                </table>
                <!-- danny -->

          
		</td>
	</tr>
</table>
  </fieldset>
</td>
</tr>

</table>

</table>

<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>

<script language="JavaScript">
// configuration variable for the hint object, these setting will be shared among all hints created by this object
var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 10, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : 20, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'bctl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'css'        : 'hintsClass', // a style class name for all hints, applied to DIV element (see style section in the header of the document)
	'show_delay' : 0, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 200, // a delay between closing event (mouseout for example) and hint disappearing
	'follow'     : true, // hint follows the mouse as it moves
	'z-index'    : 100, // a z-index for all hint layers
	'IEfix'      : false, // fix IE problem with windowed controls visible through hints (activate if select boxes are visible through the hints)
	'IEtrans'    : ['blendTrans(DURATION=.3)', null], // [show transition, hide transition] - nice transition effects, only work in IE5+
	'opacity'    : 95 // opacity of the hint in %%
};
// text/HTML of the hints
var HINTS_ITEMS = [ <? echo $mens_todos; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);

<?php /*?>var HINTS_ITEMS = [ <? echo $mens_todos; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);
<?php */?>
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1", {defaultTab:<? echo "$cualtab"; ?>});



</script>
</body>
</html>

<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>

