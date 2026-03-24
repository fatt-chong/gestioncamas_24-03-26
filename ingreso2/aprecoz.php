<?php 
//usar la funcion header habiendo mandado c󤩧o al navegador
ob_start(); 
//end para header
$quehora = $_GET['quehora'];
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
<title>Gestion de Camas Hospital Dr. Juan No頃.</title>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

	<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
	<script language="JavaScript" src="../tablas/tigra_hints.js"></script>



</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

<script language="JavaScript">

var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 0, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : -20, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'brtl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'show_delay' : 100, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 0 // a delay between closing event (mouseout for example) and hint disappearing
};
var myHint = new THints (null, HINTS_CFG);

// custom JavaScript function that updates the text of the hint before displaying it
function myShow(s_text, e_origin) {
	var e_hint = getElement('reusableHint');
	e_hint.innerHTML = s_text;
	myHint.show('reusableHint', e_origin);
}

</script>




<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 


<div id="reusableHint" style="position:absolute;z-index:1;visibility:hidden; font-family:Tahoma, Geneva, sans-serif; font-size:12px; background-color:#f0f0f0;color:#000000; border:3px solid #006699; padding:5px;">
</div>


<div class="pantalla" align="center" style="display:block; border: 0px black solid; width:auto; float:center padding: 10px;">
	<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    
    <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Administraci󮠤e Pacientes.</th>
    
        <tr>
            <td class="encabezadoscentro" background="img/fondo.jpg">
            	<fieldset>
					<table>
						<tr>
							<td>



<?

include "../funciones/funciones.php";

$atenc[0] = "SIN ATENCION";
$atenc[1] = "M-1";
$atenc[2] = "M-2";
$atenc[3] = "E-1";
$atenc[4] = "E-2";
$atenc[5] = "TP-1";
$atenc[6] = "TP-2";
$atenc[7] = "TP-ADICIONAL";
$atenc[8] = "OTRO";
$atenc[9] = "ATENCION BOX";

$movil[0] = "SIN ASIGNAR";
$movil[1] = "MOVIL 1";
$movil[2] = "";
$movil[3] = "MOVIL 2";
$movil[4] = "";
$movil[5] = "MOVIL 3";
$movil[6] = "MOVIL 4";
$movil[7] = "MOVIL ADICIONAL";
$movil[8] = "OTROS";
$movil[9] = "CONSULTA BOX";


if ($_SESSION['MM_Quehora'] == '') { $_SESSION['MM_Quehora'] = 1; $quehora = 1; } 

if ( $quehora == '' ) { $quehora = $_SESSION['MM_Quehora']; } else { $_SESSION['MM_Quehora'] = $quehora; }

$permisos = $_SESSION['permiso'];

$fecha_hoy = date('Y-m-d');

$servicio = "106";
$desc_servicio = "HOSP. DOMICILIARIA";

	echo"<table align='center' >";
		echo"<tr>";
			echo"<td>";
				echo"<fieldset>";
					echo"<table width='700px' align='center'>";
						echo"<tr>";
							echo"<td width='600'>";
								echo"<a class='titulo'>Ingreso y Alta de Pacientes de ".$desc_servicio."</a>";
							echo"</td>";
							
						echo"</tr>";
					echo"</table>";
				echo"</fieldset>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>";
			echo"<td>";
				echo"<fieldset>";
					echo"<table width='700px' align='center'>";
						echo"<tr>";
							echo"<td>";
								?> <input style="font-size:15px; font-family:Verdana, Arial, Helvetica, sans-serif"type="Button" value="Ingresar Paciente"
<?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?>                                             onClick="window.location.href='<? echo"ingresopaciente.php"; ?>'; parent.GB_hide(); " > <?
							echo"</td>";
							echo"<td>";
								?>
								<form method="get" action="aprecoz.php" name="frm_aprecoz" id="frm_aprecoz">
									Horario de Atenci&oacute;n </br>
									<select name="quehora" onchange="document.frm_aprecoz.submit()">
										<option value="1" <? if ($quehora == 1) { echo "selected";  } ?> > ------ Ma&ntilde;ana ------ </option>";
										<option value="2" <? if ($quehora == 2) { echo "selected";  } ?> > ------ Tarde --------- </option>";
										<option value="3" <? if ($quehora == 3) { echo "selected";  } ?> > ------ Noche -------- </option>";
										<option value="4" <? if ($quehora == 4) { echo "selected";  } ?> > ------ Madrugada -------- </option>";
									</select>
								</form>
								<?
							echo"</td>";
							echo"<td>";
								?> <input style="font-size:15px; font-family:Verdana, Arial, Helvetica, sans-serif" type="button" value="Asignar Moviles"
								<?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> onClick="window.location.href='<? echo"asignamoviles.php"; ?>'; parent.GB_hide(); " > <?
							echo"</td>";
							echo"<td width='100'>";
								?> <input style="font-size:15px; font-family:Verdana, Arial, Helvetica, sans-serif"type="Button" value="Reporte Diario Excel" onClick="window.open('<? echo"XLS/generaXLS_domiciliaria.php"; ?>'); parent.GB_hide(); " > <?
							echo"</td>";
						echo"</tr>";
					echo"</table>";
				echo"</fieldset>";
			echo"</td>";
		echo"</tr>";
	echo"</table>";


	
	?>

</td>
</tr>

<tr>
<td>

<?

echo "<div align='center'>";

$queorden = "movil_m";
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

switch ($quehora)
{
	case 1:
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
		break;
	case 2:
		$queorden = "movil_t";
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
		break;
	case 3:
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
		break;
	case 4:
		$queorden = "movil_ma";
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
		break;
}


mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM altaprecoz order by ".$queorden ) or die(mysql_error());

	$sala = 1000;
	$nro_salas = 0;
	$max_largo = 0;
 	
	$totalpac = 0;
	$capacidad = 60;
	$atendidos = 0;
	$at_manana = 0;
	$at_tarde  = 0;
	$at_noche  = 0;
	$at_madrugada  = 0;

	echo"<table align='center' vertical-align:top'>";
	echo"<tr style='vertical-align:top'>";	
	
    while($camas = mysql_fetch_array($query)){
	
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
			echo"<fieldset><legend style='font-size:12px' >".$movil[$ind]." (".$atenc[$ind].")</legend>";
			echo"<table align='center'>";
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

		$id_cama = $camas['id'];
		$cama = $camas['cama'];
		$servicio = $camas['cod_servicio'];
		$sala = $camas[$queorden];
		$desc_servicio = $camas['servicio'];
		$categorizacion_riesgo = $camas['categorizacion_riesgo'];
		$categorizacion_dependencia = $camas['categorizacion_dependencia'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$sexo_paciente = $camas['sexo_paciente'];
		$esta_ficha = $camas['esta_ficha'];
		$estado = $camas['estado'];

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
				$at_manana ++;
			}
			if ($camas['movil_t'] <> 0) 
			{
				$atencion = $atencion."( Tarde ) "; 
				$at_tarde ++;
			}
			if ($camas['movil_n'] <> 0)
			{
				$atencion = $atencion."( Noche ) "; 
				$at_noche ++;
			}
			if ($camas['movil_ma'] <> 0)
			{
				$atencion = $atencion."( Madrugada ) "; 
				$at_madrugada ++;
			}
		}
		
		$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." ) <br /> <b>- Atenci&oacute;n</b> : ".$atencion." ";


//				$inf_paciente = "Paciente: ***************************&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Pre-Diagnostico : ".$camas['diagnostico1']."&#13;&#10;Diagnostico : ".$camas['diagnostico2']."&#13;&#10;Medico : ".$camas['medico']."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";


				$logo_cama = 'cama-sc';
				
				if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m'; }
				else { $logo_cama = $logo_cama.'-h'; }

				if ($esta_ficha == 1) { $logo_cama = $logo_cama.'-f.gif'; }
				else { $logo_cama = $logo_cama.'.gif'; }

				echo"<tr><td class='td_sscc'";
				
				?>
				onmouseover="myShow('<? echo $inf_paciente; ?>', this)" onmouseout="myHint.hide()"
				<?
			
				echo"><a href='altapaciente.php?id_cama=$id_cama&tipo_atencion=XXX' ><img class='img_sscc' src='img/".$logo_cama."' /></a></td></tr>";
				$totalpac ++;
				
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
	echo"</td>";
	echo"</tr>";
	echo"</table>";
	echo"</fieldset>";
?>
    <tr>
		<td colspan="<? echo $nro_salas; ?>">
            <fieldset style="padding-left:15px"> <legend style="font-size:15px">Resumen</legend>
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
                            <td colspan="1" align="left">Atenciones Ma񡮡</td>
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
                
            </fieldset>
		</td>
	</tr>


</table>


        


</div>



</td>
</tr>

</table>















				</fieldset>          
			</td>
	    	<td class="encabezadostablas"></td>
        </tr>
	    
	</table>
</div>


<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>




</body>
</html>

<?php
//usar la funcion header habiendo mandado c󤩧o al navegador
ob_end_flush();
//end header
?>





