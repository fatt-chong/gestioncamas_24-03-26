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

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>


<?

include "../funciones/funciones.php";	

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$cod_servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];


?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Categorizaci&oacute;n de Pacientes.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

	<table width="770px" align="left">
    	<tr>
        	<td>
            	<fieldset>
                	<table align="center">
                    	<tr>
                        	<td align="center">
								<? echo"<a class='titulo'>Traslado Interno de Pacientes Servicio Cl&iacute;nico de ".$desc_servicio."</a>"; ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
        </tr>
        <tr>
        	<td>
            	<fieldset>

<?

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query("SELECT * FROM camas where cod_servicio = $cod_servicio order by sala, cama") or die(mysql_error());


	$sala = '0';
	$nro_salas = 0;
	$max_largo = 0;

	echo"<table align='center' vertical-align:top'>";
	echo"<tr style='vertical-align:top'>";	
	
    while($camas = mysql_fetch_array($query)){
	
		if ($sala <> $camas['sala']){
		
			$nro_salas++;
		 	$max_largo = 0;

			if ($sala <>'0'){
				echo"</td>";
				echo"</tr>";
				echo"</table>";
				echo"</td>";
				echo"</tr>";
				echo"</table>";
				echo"</fieldset>";
			}

			echo"<td>";
			echo"<fieldset><legend style='font-size:9px' >S-".$camas['sala']."</legend>";
			echo"<table align='center' style='padding-left:0px'>";
			echo"<tr style='vertical-align:top'>";
			echo"<td>";
			echo"<table align='center' style='padding-left:0px'>";

			$sala = $camas['sala'];
        }
		else
		{
			if ($max_largo == 6) {
		 		$max_largo = 0;

				echo"</table>";
				echo"<td>";
				echo"<table align='center' style='padding-left:0px'>";
		 	}
		 }

		$max_largo++;

		$t_id_cama = $camas['id'];
		$t_cama = $camas['cama'];
		$t_cod_servicio = $camas['cod_servicio'];
		$t_sala = $camas['sala'];
		$t_desc_servicio = $camas['servicio'];
		
		$categorizacion_riesgo = $camas['categorizacion_riesgo'];
		$categorizacion_dependencia = $camas['categorizacion_dependencia'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$sexo_paciente = $camas['sexo_paciente'];
		$estado = $camas['estado'];
		$pabellon = $camas['pabellon'];
		
		switch ($camas['estado']) {
			case 1:
				$inf_paciente = "Cama N&uacute;mero : ".$cama;
				echo"<tr><td><a href='pro2_traslado_interno.php?t_id_cama=$t_id_cama&t_cama=$t_cama&t_sala=$t_sala&t_cod_servicio=$t_cod_servicio&t_desc_servicio=$t_desc_servicio' title='Trasladar Paciente' rel='gb_page_center[850, 550]'; ><img  src='img/cama-vacia.gif' width='25' height='25' border='0' title='$inf_paciente' alt='$inf_paciente' /></a><br>";
				echo"N� ".$t_cama." </td></tr>";
 				break;
			case 2:
				$inf_paciente = "Paciente: ".$camas['nom_paciente']."&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";			
				$logo_cama = 'cama-sc';
				if ($categorizacion == 'A1') { $logo_cama = 'cama-a'; $tot_cat_a1++; }
				if ($categorizacion == 'A2') { $logo_cama = 'cama-a'; $tot_cat_a2++; }
				if ($categorizacion == 'A3') { $logo_cama = 'cama-a'; $tot_cat_a3++; }
				if ($categorizacion == 'B1') { $logo_cama = 'cama-b'; $tot_cat_b1++; }
				if ($categorizacion == 'B2') { $logo_cama = 'cama-b'; $tot_cat_b2++; }
				if ($categorizacion == 'B3') { $logo_cama = 'cama-b'; $tot_cat_b3++; }
				if ($categorizacion == 'C1') { $logo_cama = 'cama-c'; $tot_cat_c1++; }
				if ($categorizacion == 'C2') { $logo_cama = 'cama-c'; $tot_cat_c2++; }
				if ($categorizacion == 'C3') { $logo_cama = 'cama-c'; $tot_cat_c3++; }
				if ($categorizacion == 'D1') { $logo_cama = 'cama-d'; $tot_cat_d1++; }
				if ($categorizacion == 'D2') { $logo_cama = 'cama-d'; $tot_cat_d2++; }
				if ($categorizacion == 'D3') { $logo_cama = 'cama-d'; $tot_cat_d3++; }
				
				if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m.gif'; }
				else { $logo_cama = $logo_cama.'-h.gif'; }
				
				if ($pabellon == 1){ $logo_cama = str_replace("cama","pabe",$logo_cama);}
				
				echo"<tr><td><img src='img/".$logo_cama."' width='25' height='25' border='0' title='$inf_paciente' alt='$inf_paciente' ><br>";
				echo"N� ".$t_cama." </td></tr>";
				$camas_ocupadas ++;
 				break;
			case 3:
				$inf_paciente = "Cama Bloqueada Desde: ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Motivo : ".$camas['diagnostico1'];			
				echo"<tr><td><img src='img/icono-sn.gif' width='25' height='25' border='0' title='$inf_paciente' alt='$inf_paciente' ><br>";
				echo"N� ".$t_cama." </td></tr>";
				$camas_bloqueadas ++;
 				break;
		}
	}
	
	
	echo"</td>";
	echo"</tr>";
	echo"</table>";
	echo"</td>";
	echo"</tr>";
	echo"</table>";
	echo"</fieldset>";
	
	?> 

</table>
<tr>
<td>
	<fieldset>
	<table width="770" align="center">
	<tr>
	<td align="center">
	<input type="Button" value=    "       Cancelar       " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >	</td>
	</tr>
	</table>
	</fieldset>
</td>
</tr>
</table>


</div>

</fieldset>
</td>
</tr>
</table>


</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>


