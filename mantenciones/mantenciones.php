<?php

if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

	<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

 	<!--EFECTTO VENTANA GREYBOX-->
    <script type="text/javascript">
        var GB_ROOT_DIR = "../greybox/";
    </script>

    <script type="text/javascript" src="../greybox/AJS.js"></script>
    <script type="text/javascript" src="../greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="../greybox/gb_scripts.js"></script>
    <link href="../greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body style="font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif" background="../../estandar/img/fdo.jpg">

<?

include "../funciones/funciones.php";	

$fecha_hoy = date('d-m-Y');

//$id_rau = $_SESSION['MM_Servicio'];

$servicios_rau = $_SESSION['serviciousuario'];


//$servicios_rau[0] = 10311;
//$servicios_rau[0] = 10314;
//$servicios_rau[2] = 10320;

if ($cod_servicio == '') { $cod_servicio = $_SESSION['MM_Servicio_activo']; } else { $_SESSION['MM_Servicio_activo'] = $cod_servicio; }

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM sscc where id = $cod_servicio") or die(mysql_error());
$query_servicio = mysql_fetch_array($query);
$servicio = $query_servicio['id'];
$desc_servicio= $query_servicio['servicio'];

?>

<div class="pantalla" align="center" style="display:block; border: 0px black solid; width:auto; float:center padding: 10px;">

<table width="800" align="center" border="0" cellspacing="0" cellpadding="0">

	<tr>
		<td width="20px" height="20px" align="left" valign="top" class="esquinas"><img src="../../estandar/img/esquina_tr1.gif" /></td>
	    <td colspan="3" class="encabezadostablas"></td>
	    <td width="20px" align="right" valign="top" class="esquinas" ><img src="../../estandar/img/esquina_tr2.gif" alt="a" /></td>
	</tr>
	<tr>
		<td class="encabezadostablas"></td>
	    <td width="130px" align="center" valign="bottom" class="encabezadostablas"><img src="../../estandar/img/gobierno_lado.gif" /></td>
	    <td align="center" valign="center" class="encabezadoscentro"><a class='titulo'>Seguimiento y Mantencion de Pacientes Servicio Cl&iacute;nico de <? echo $desc_servicio; ?></a></td>
	    <td width="130px" align="right" class="encabezadostablas">
        	<a href="mantenciones.php"><img src="img/refresh.gif" width="32" height="32" border="0" title="Recargar Informaci&oacute;n"></a>
          	<a href="../menu.php"><img src="img/close.gif" width="32" height="32" border="0" title="Salir a Menu Principal"></a>
        </td>
		<td class="encabezadostablas"></td>
	</tr>

    	
    <tr>
    	<td colspan="2" class="encabezadostablas"></td>
        <td align="center" class="encabezadoscentro">
            <?
            if (count($servicios_rau) > 1)
            {
                ?>
                <form method="get" action="mantenciones.php" name="frm_sscc" id="frm_sscc">
                            Servicio Cl&iacute;nico
                            <select name="cod_servicio" onchange="document.frm_sscc.submit()">
                            <?php
                                $i = 0;
                                mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
                                mysql_select_db('camas') or die('Cannot select database');
                            
                                for($i=0; $i<count($servicios_rau); $i++)
                                {
                                    $query = mysql_query("SELECT * FROM sscc where id_rau = $servicios_rau[$i]") or die(mysql_error());
                                    $query_servicio = mysql_fetch_array($query);
                            
                                    if( $query_servicio['id'] == $cod_servicio )
                                    {
                                        echo "<option value='".$query_servicio['id']."' selected>".$query_servicio['servicio']."</option>";
                                        $id_rau=$query_servicio['id_rau'];
                                    }
                                    else
                                    {
                                        echo "<option value='".$query_servicio['id']."'>".$query_servicio['servicio']."</option>";
                                    }
                                }
                                ?>
                            </select>
                </form>
                <?
            }
            else
            {
                $id_rau = $servicios_rau[0];
            }
            
                
                ?>
        </td>
        <td colspan="2" class="encabezadostablas"></td>
    </tr>




    <tr>
        <td class="encabezadoscentro"></td>
        <td colspan="3" background="img/fondo.jpg"> 

			<fieldset>


            <table width="100%" align="center" background="../ingresos/img/fondo.jpg">
				<tr>







<?



mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM camas where cod_servicio = $servicio order by sala, cama") or die(mysql_error());


	$sala = '0';
	$nro_salas = 0;
	$max_largo = 0;
 	
	$camas_ocupadas = 0;
	$camas_desocupadas = 0;
	$camas_bloqueadas = 0;
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
			echo"<fieldset><legend style='font-size:12px' >SALA ".$camas['sala']."</legend>";
			echo"<table align='center'>";
			echo"<tr style='vertical-align:top'>";
			echo"<td>";
			echo"<table align='center'>";

			$sala = $camas['sala'];
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
		$sala = $camas['sala'];
		$desc_servicio = $camas['servicio'];
		$categorizacion_riesgo = $camas['categorizacion_riesgo'];
		$categorizacion_dependencia = $camas['categorizacion_dependencia'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$sexo_paciente = $camas['sexo_paciente'];
		$estado = $camas['estado'];

		switch ($camas['estado']) {
			case 1:
				$inf_paciente = "Cama N&uacute;mero : ".$cama;
				echo"<tr><td class='td_sscc'><a href='ingresopaciente.php?id_cama=$id_cama&id_hosp=0&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado' title='Ingreso de Pacientes' rel='gb_page_center[850, 550]'; ><img class='img_sscc' src='img/cama-vacia.gif' title='$inf_paciente' alt='$inf_paciente' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				$camas_desocupadas ++;
 				break;
			case 2:
//				$inf_paciente = "Paciente: ".$camas['nom_paciente']."&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";

//				$inf_paciente = "Paciente: ".$camas['nom_paciente']."&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Pre-Diagnos : ".$camas['diagnostico1']."&#13;&#10;Diagnostico : ".$camas['diagnostico2']."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";


				$inf_paciente = "Paciente: ".$camas['nom_paciente']."&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Pre-Diagnostico : ".$camas['diagnostico1']."&#13;&#10;Diagnostico : ".$camas['diagnostico2']."&#13;&#10;Medico : ".$camas['medico']."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";


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

				echo"<tr><td class='td_sscc'><a href='altapaciente.php?id_cama=$id_cama' title='Hospitalizaci&oacute;n de Pacientes' rel='gb_page_center[850, 570]'><img class='img_sscc' src='img/".$logo_cama."' title='$inf_paciente' alt='$inf_paciente' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				$camas_ocupadas ++;
 				break;
			case 3:
				$inf_paciente = "Cama Bloqueada Desde: ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Motivo : ".$camas['diagnostico1'];			
				echo"<tr><td class='td_sscc'><a href='desbloqueocama.php?id_cama=$id_cama&id_hosp=0&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado' title='Bloqueo de Cama' rel='gb_page_center[850, 550]'><img class='img_sscc' src='img/icono-sn.gif' title='$inf_paciente' alt='$inf_paciente' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
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


       













            		</td>
                </tr>

                <tr>
					<td colspan="<? echo $nro_salas; ?>">
                        <fieldset style="padding-left:15px"> <legend style="font-size:15px">Resumen</legend>
                            <table align='left' border="1" cellpadding="7px" cellspacing="2px">
                                <tr>
                                    <td colspan="2"> Detalle de Ocupaci&oacuten </td>
                                </tr>
                                <tr>
                                    <td align="left"> Camas Ocupadas </td>
                                    <td> <? echo $camas_ocupadas ?> </td>
                                </tr>
                                <tr>
                                    <td align="left"> Camas Libres </td>
                                    <td> <? echo $camas_desocupadas ?> </td>
                                </tr>
                                <tr>
                                    <td align="left"> Camas Bloqueadas </td>
                                    <td> <? echo $camas_bloqueadas ?> </td>
                                </tr>
                            </table>
                    
                            <table align='left' border="1" cellpadding="7px" cellspacing="2px">
                                <tr>
                                    <td colspan="4"> Resumen de Categorizaci&oacuten </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#00CC33">A1 = <? echo $tot_cat_a1 ?></td>
                                    <td bgcolor="#FFFF00">B1 = <? echo $tot_cat_b1 ?></td>
                                    <td bgcolor="#FFCC33">C1 = <? echo $tot_cat_c1 ?></td>
                                    <td bgcolor="#FF0000">D1 = <? echo $tot_cat_d1 ?></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#00CC33">A2 = <? echo $tot_cat_a2 ?></td>
                                    <td bgcolor="#FFFF00">B2 = <? echo $tot_cat_b2 ?></td>
                                    <td bgcolor="#FFCC33">C2 = <? echo $tot_cat_c2 ?></td>
                                    <td bgcolor="#FF0000">D2 = <? echo $tot_cat_d2 ?></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#00CC33">A3 = <? echo $tot_cat_a3 ?></td>
                                    <td bgcolor="#FFFF00">B3 = <? echo $tot_cat_b3 ?></td>
                                    <td bgcolor="#FFCC33">C3 = <? echo $tot_cat_c3 ?></td>
                                    <td bgcolor="#FF0000">D3 = <? echo $tot_cat_d3 ?></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            
            
                <tr>
					<td colspan="<? echo $nro_salas; ?>">
                        <fieldset style="padding-left:15px"> <legend style="font-size:16px">Pacientes En Espera</legend>
                            <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <?
                                    $sql = "SELECT * FROM transito_paciente where cod_sscc_hasta = $id_rau";
                    
                                    mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
                                    mysql_select_db('camas') or die('Cannot select database');
                                    $query = mysql_query($sql) or die(mysql_error());
            
            
                                    echo "<tr>";
                                    echo "<td rowspan='2'>Fecha</td>";
                                    echo "<td rowspan='2' width='200px'>Servicio Procedencia</td>";
                                    echo "<td width='400px' colspan='2'>Paciente</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td>Rut</td>";
                                    echo "<td>Nombres</td>";
                                    echo "</tr>";
                    
                                    while($traslados = mysql_fetch_array($query)){
                                        $id_traslado = $traslados['id'];
                                        $idpaciente = $traslados['id_paciente'];
                                        $rutpaciente = $traslados['rut_paciente'];
                                        $nompaciente = $traslados['nomb_paciente'];
                                        
                                        echo "<tr style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif' >";
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px' >".cambiarFormatoFecha2($traslados['fecha'])."</td>";
            
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px' >".$traslados['desc_sscc_desde']."</td>";
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['rut_paciente']."</td>";
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['nom_paciente']."</td>";
                                        echo "</tr>";
                                    } 
                                    ?>       
                                </tr>
                            </table>
                                
                            <table>
                                <tr>
                                    
                                </tr>                
                            </table>
                        </fieldset>
                    </td>
                </tr>
            
                <tr>
					<td colspan="<? echo $nro_salas; ?>">
                        <fieldset style="padding-left:15px"> <legend style="font-size:16px">Pacientes Trasladados</legend>
                            <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <?
                                    $sql = "SELECT * FROM transito_paciente where cod_sscc_desde = $id_rau";
                    
                                    mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
                                    mysql_select_db('camas') or die('Cannot select database');
                                    $query = mysql_query($sql) or die(mysql_error());
                    
                                    echo "<tr>";
                                    echo "<td width='200px'>Servicio</td>";
                                    echo "<td width='400px' colspan='2'>Paciente</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td>Destino</td>";
                                    echo "<td>Rut</td>";
                                    echo "<td>Nombres</td>";
                                    echo "</tr>";
                    
                                    while($traslados = mysql_fetch_array($query)){
                                        $id_traslado = $traslados['id'];
                                        $id_paciente = $traslados['id_paciente'];
                                        $rut_paciente = $traslados['rut_paciente'];
                                        $nom_paciente = $traslados['nom_paciente'];
                                        
                                        echo "<tr style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif' >";
                                       
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['desc_sscc_hasta']."</td>";
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$rut_paciente."</td>";
                                        echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$nom_paciente."</td>";
                                        echo "</tr>";
                                    } 
                                    ?>       
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            
            
            
            </table>

        <td class="encabezadoscentro"></td>

        </td>
	
    </tr>
    
    <tr height="40px">
    	<td align="center" colspan="5" class="encabezadostablas">&nbsp;</td>
    </tr>
	<tr>
		<td align="left" valign="bottom" class="esquinas"><img src="../../estandar/img/esquina_tr3.gif" /></td>
	    <td class="encabezadostablas"></td>
	    <td align="center" class="encabezadostablas"></td>
	    <td class="encabezadostablas"></td>
	    <td align="right" valign="bottom" class="esquinas"><img src="../../estandar/img/esquina_tr4.gif" /></td>
    </tr>
</table>


<table width="700">
	<tr>
		<td align="center" class="titulos"><strong>Usuario conectado : <?php echo $_SESSION['MM_Username']; ?>&nbsp;<a href="../acceso/menu.php" class="enlace">(SALIR)</a></strong></td>
    </tr>
</table>
</div>



























</td>
</tr>

</table>






       <script language="JavaScript">
    <!--
        tigra_tables('traslado_table', 3, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
    // -->
    </script>
 
    
    
    
    

</div>
</td>
</tr>
</table>

</body>
</html>


