<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}


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
</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

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

	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database');
 
	$fecha_hoy = date('Y-m-d');
	$hora_hoy = date('H:i');
	
	?>

<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 


<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="img/fondo.jpg">

  <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">
  	<table width="1024">
    <tr>
        <td width="797">&nbsp;Hospitalizaci�n Domiciliaria.</td>
        
        <td width="24" align="right"><a href="lista_rau.php" title="Mapa de Piso Unidad de Urgencia" ><img src="img/i_rau.gif" width="25" height="25" /></a></td>
        <td width="24" align="right"><a href="altaPrecoz.php" title="Hospitalizaci�n Domiciliaria" ><img src="img/i_aprecoz.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="../../pabellon/sscc.php" title="Mapa Pabellon" ><img src="img/i_pabellon.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="ListadoPacientes.php" title="Cirugia Mayor Ambulatoria" ><img src="img/i_cma.gif" width="25" height="25" /></a></td>
        
    </tr>
    </table>
   </th>
    
<tr>
<td>
	<fieldset>

	<div align="center" style="width:950px;height:330px;overflow:auto ">
    <div id="TabbedPanels1" class="TabbedPanels">
    
<?


// ---------------------------------------------inicio alta precoz


			$i_mens_todos = 0;
			$servicio = 106;
			$desc_servicio = "HOSP. DOMICILIARIA";
			$sala = 1000;
			$nro_salas = 0;
			$max_largo = 0;
			
			$totalpac = 0;
			$capacidad = 24;
			$atendidos = 0;
			$at_manana = 0;
			$at_tarde  = 0;
			$at_noche  = 0;
			$at_madrigada  = 0;
			
			$hora = date('H');
			
			$atenc[0] = "SIN ATENCION";
			$atenc[1] = "M-1";
			$atenc[2] = "M-2";
			$atenc[3] = "E-1";
			$atenc[4] = "E-2";
			$atenc[5] = "TP-1";
			$atenc[6] = "TP-2";
			$atenc[7] = "TP-3";
			$atenc[8] = "TP-4";
			$atenc[9] = "TP-ADICIONAL";
			$atenc[10] = "OTRO";
			$atenc[11] = "ATENCION BOX";

			
		//$hora = "11";
			if ( $hora > "12" ) 
			{
				$queorden = "movil_n";
				$movil[0] = "SIN ASIGNAR";
				$movil[1] = "";
				$movil[2] = "";
				$movil[3] = "";
				$movil[4] = "";
				$movil[5] = "MOVIL 1";
				$movil[6] = "MOVIL 2";
				$movil[7] = "MOVIL 3";
				$movil[8] = "MOVIL 4";
				$movil[9] = "MOVIL ADICIONAL";
				$movil[10] = "OTROS";
				$movil[11] = "CONSULTA BOX";

			}
			
			else
			{
				$queorden = "movil_m";
				$movil[0] = "SIN ASIGNAR";
				$movil[1] = "MOVIL 1";
				$movil[2] = "";
				$movil[3] = "MOVIL 2";
				$movil[4] = "";
				$movil[5] = "MOVIL 3";
				$movil[6] = "MOVIL 4";
				$movil[7] = "";
				$movil[8] = "";
				$movil[9] = "MOVIL ADICIONAL";
				$movil[10] = "OTROS";
				$movil[11] = "CONSULTA BOX";
		}
			
			echo"<table border='5' width='100%' height='130'>";


			echo"<tr height='15px'>";
			echo"<td colspan='2' align='left' style='font-size:15px' > Hospitalizacion Domiciliaria</td>";
			echo"</tr>";


			echo"<tr>";
			echo"<td align='left'>";

		
			mysql_select_db('camas') or die('Cannot select database');
		 
			$query = mysql_query("SELECT * FROM altaprecoz where cod_servicio = 106 order by ".$queorden ) or die(mysql_error());
			
			$sala = 1000;
			
			$nro_salas = 0;
			$max_largo = 0;
			

			echo"<table align='left' vertical-align:top'>";

			echo"<tr style='vertical-align:top'>";
			
			$flag_m_resumen = 0;

			while($camas = mysql_fetch_array($query))
			
			{
				$totalpac ++;
				if ($camas[$queorden] <> 0)
				{
					$flag_m_resumen = 1;
					if ($sala <> $camas[$queorden]){
					
						$nro_salas++;
						$max_largo = 0;
			
						if ($sala <> 1000){
							echo"</td>";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
							echo"</tr>";
							echo"</table>";
							echo"</fieldset>";
						}
						
						$ind = $camas[$queorden];
						
						echo"<td>";
						echo"<fieldset style='background-image:url(img/fondosala.gif)'><legend style='font-size:8px' >".$movil[$ind]." (".$atenc[$ind].")</legend>";
						echo"<table align='center' border='0' cellpadding='0px' cellspacing='0px'>";
						echo"<tr style='vertical-align:top'>";
						echo"<td>";
						
						echo"<table align='center'>";
	
						$sala = $camas[$queorden];
					}
					else
					{
						if ($max_largo == 6) {
							$max_largo = 0;
			
							echo"</table>";
							echo"<td>";
							echo"<table align='center'>";
						}
					 }
			
					$max_largo++;
					
					$movil_m = $camas['movil_m'];
					$movil_t = $camas['movil_t'];
					$movil_n = $camas['movil_n'];
					$movil_ma = $camas['movil_ma'];
					$id_cama = $camas['id'];
					$cama = $camas['cama'];
					$servicio = $camas['cod_servicio'];
					$sala = $camas[$queorden];
					$desc_servicio = $camas['servicio'];
					$categorizacion_riesgo = $camas['categorizacion_riesgo'];
					$categorizacion_dependencia = $camas['categorizacion_dependencia'];
					$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
					$sexo_paciente = $camas['sexo_paciente'];
					
					$atencion = "";
					if ($camas['movil_m'] == 0 and $camas['movil_t'] == 0 and $camas['movil_n'] == 0 and $camas['movil_ma'] == 0 ) 
					{
						$atencion = "( SIN ATENCION )";
					}
					else
					{
						
						if ($camas['movil_m'] <> 0) 
						{
							$atencion = $atencion."( Ma&ntilde;ana ) "; 
						}
						if ($camas['movil_t'] <> 0) 
						{
							$atencion = $atencion."( Tarde ) "; 
						}
						if ($camas['movil_n'] <> 0)
						{
							$atencion = $atencion."( Noche ) "; 
						}
						if ($camas['movil_ma'] <> 0)
						{
							$atencion = $atencion."( Madrugada ) "; 
						}
					}
	
					$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." ) <br /> <b>- Atenci&oacute;n</b> : ".$atencion." ";
	
					$logo_cama = 'cama-sc';
	
					if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m.gif'; }
					else { $logo_cama = $logo_cama.'-h.gif'; }
	
					?>
					<a onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" href='detallepaciente.php?id_cama=<? echo $id_cama; ?>&es_ap=1' rel='gb_page_center[850, 570]'><img class='img_pr' src='img/<? echo $logo_cama; ?>' width='30' height='30' /></a>
				
					<? 
					$inf_paciente = str_replace("'", " ", $inf_paciente);

					$arreglo_camas[$i_mens_todos] = $inf_paciente;
					$i_mens_todos++;
				}
				
				if ($camas['movil_m'] <> 0) 
				{
					$at_manana ++;
				}
				if ($camas['movil_t'] <> 0) 
				{
					$at_tarde ++;
				}
				if ($camas['movil_n'] <> 0)
				{
					$at_noche ++;
				}
				if ($camas['movil_ma'] <> 0)
				{
					$at_madrugada ++;
				}
				

			}
			
			switch ($quehora)
			{
				case 1:
					$atendidos = $at_manana;
					break;
				case 2:
					$atendidos = $at_tarde;
					break;
				case 3:
					$atendidos = $at_noche;
					break;
				case 4:
					$atendidos = $at_madrugada;
					break;
			}
		
			echo"</td>";
			echo"</tr>";
			echo"</table>";
			
			if ($flag_m_resumen <> 0)
			{ ?>

			
			
				</td>
				</tr>
				</table>
				</fieldset>
				</table>
				</td>
				<td width='255px' align='right'>
						
					
					
					<table>
					<tr>
						<td colspan="<? echo $nro_salas; ?>">
							<table width="250px" align='left' border="1" cellpadding="0px" cellspacing="0px">
								<tr align="right" valign="">
									<td colspan="1" align="left">Total Pacientes</td>
									<td align="right"><? echo $totalpac ?></td>
									<td align="right"><? echo number_format((($totalpac*100)/$capacidad),1,",",".") ?>%</td>
								</tr>
								<tr align="right">
									<td colspan="1" align="left">Capacidad de Atenci&oacute;n</td>
									<td align="right"><? echo $capacidad ?></td>
									<td align="right"><? echo number_format((($capacidad*100)/$capacidad),1,",",".") ?>%</td>
								</tr>
								<tr align="right">
									<td colspan="1" align="left">Atenciones Ma�ana</td>
									<td align="right"><? echo $at_manana ?></td>
									<td align="right"><? echo number_format((($at_manana*100)/$totalpac),1,",",".") ?>%</td>
								</tr>
								<tr align="right">
									<td colspan="1" align="left">Atenciones Tarde</td>
									<td align="right"><? echo $at_tarde ?></td>
									<td align="right"><? echo number_format((($at_tarde*100)/$totalpac),1,",",".") ?>%</td>
								</tr>
								<tr align="right">
									<td colspan="1" align="left">Atenciones Noche</td>
									<td align="right"><? echo $at_noche ?></td>
									<td align="right"><? echo number_format((($at_noche*100)/$totalpac),1,",",".") ?>%</td>
								</tr>
								<tr align="right">
									<td colspan="1" align="left">Atenciones Madrugada</td>
									<td align="right"><? echo $at_madrugada ?></td>
									<td align="right"><? echo number_format((($at_madrugada*100)/$totalpac),1,",",".") ?>%</td>
								</tr>
							</table>
								
						</td>
					</tr>
	
					</table>
					
			<? } ?>
		
				
				

			</td>
			</tr>
			</tr>
			</table>


<? 
//--------------------------------------------separa tipos de hopspitalizacion domiciliaria
			
if($inf_paciente){
$mens_todos = "'".implode("','",$arreglo_camas)."'";
}

	?>    
    
    </div>
    </div>
    </fieldset>
</td>
</tr>
</table>
</form>

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
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1", {defaultTab:<? echo "$cualtab"; ?>});



</script>



</body>
</html>

<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>