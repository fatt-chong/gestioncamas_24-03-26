<?php 
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$fecha_censo= $_GET['fecha_censo'];
$cod_servicio= $_GET['cod_servicio'];
$censo_minsal= $_GET['censo_minsal'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">



<?
include "../funciones/funciones.php";

//$fecha_hoy = date('d-m-Y');
//$fecha_hoy = '05-11-2009';

if ($fecha_censo == '')
{
	$fecha_censo = date('d-m-Y');
}

$fecha_proceso = cambiarFormatoFecha($fecha_censo);


if ($censo_minsal == 'on') {
	$d_censo_minsal = 1;
}
else {
	$d_censo_minsal = 0;
}

$servicios_rau = $_SESSION['serviciousuario'];

if ($cod_servicio == '') { $cod_servicio = $_SESSION['MM_Servicio_activo']; } 
else { if ($d_censo_minsal == 0) { $_SESSION['MM_Servicio_activo'] = $cod_servicio; } }


$cod_usuario = 1;
$usuario = 'Usuario de Prueba';
//$cod_servicio = 9;

if ($d_censo_minsal == 1)
{

	
	$i = 0;
	$j = 0;
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	for($i=0; $i<count($servicios_rau); $i++)
	{
		$query = mysql_query("SELECT * FROM sscc where id_rau = $servicios_rau[$i]") or die(mysql_error());
		$query_servicio = mysql_fetch_array($query);

		if( $query_servicio['id'] == $cod_servicio )
		{
			$desc_servicio = $query_servicio['servicio'];
		}

		if( $query_servicio['id'] == 1 )
		{
			$id_servicios[$j] = 2;
			$servicios[$j] = 'MEDICINA';
			$j++;
		}
		if( $query_servicio['id'] == 2 )
		{
			$id_servicios[$j] = 3;
			$servicios[$j] = 'ONCOLOGIA';
			$j++;
		}
		if( $query_servicio['id'] == 3 or $query_servicio['id'] == 4)
		{
			$id_servicios[$j] = 1;
			$servicios[$j] = 'CIRUGIA';
			$j++;
		}
		if( $query_servicio['id'] == 5 )
		{
			$id_servicios[$j] = 7;
			$servicios[$j] = 'TRAUMATOLOGIA';
			$j++;
		}
		if( $query_servicio['id'] == 6 )
		{
			$id_servicios[$j] = 13;
			$servicios[$j] = 'NEONATOLOGIA UCI';
			$j++;
			$id_servicios[$j] = 14;
			$servicios[$j] = 'NEONATOLOGIA INTERMEDIO (INCUBADORA)';
			$j++;
			$id_servicios[$j] = 15;
			$servicios[$j] = 'NEONATOLOGIA CUNA BASICA';
			$j++;
		}
		if( $query_servicio['id'] == 7 )
		{
			$id_servicios[$j] = 4;
			$servicios[$j] = 'PEDIATRIA UTI';
			$j++;
			$id_servicios[$j] = 5;
			$servicios[$j] = 'PEDIATRIA INDIFERENCIADA';
			$j++;
			$id_servicios[$j] = 6;
			$servicios[$j] = 'PEDIATRIA LACTANTES';
			$j++;
		}
		if( $query_servicio['id'] == 8 )
		{
			$id_servicios[$j] = 11;
			$servicios[$j] = 'UCI';
			$j++;
		}
		if( $query_servicio['id'] == 9 )
		{
			$id_servicios[$j] = 12;
			$servicios[$j] = 'SAI';
			$j++;
		}
		if( $query_servicio['id'] == 10 or $query_servicio['id'] == 11)
		{
			$id_servicios[$j] = 8;
			$servicios[$j] = 'GINECOLOGIA';
			$j++;
			$id_servicios[$j] = 9;
			$servicios[$j] = 'OBSTETRICIA';
			$j++;
		}
		if( $query_servicio['id'] == 12 )
		{
			$id_servicios[$j] = 10;
			$servicios[$j] = 'PSIQUIATRIA';
			$j++;
		}

	}
}
else
{


	$i = 0;
	$j = 0;
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	for($i=0; $i<count($servicios_rau); $i++)
	{
		$query = mysql_query("SELECT * FROM sscc where id_rau = $servicios_rau[$i]") or die(mysql_error());
		$query_servicio = mysql_fetch_array($query);

		if( $query_servicio['id'] == $cod_servicio )
		{
			$desc_servicio = $query_servicio['servicio'];
		}
		if ($query_servicio['id'] < 50 )
		{
			$id_servicios[$j] = $query_servicio['id'];
			$servicios[$j] = $query_servicio['servicio'];
			$j++;
		}


	}
	
}

?>



	<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Mantención Censo Diario.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

                    <form method="get" action="mantencion_censo.php" name="frm_mantencion_censo" id="frm_mantencion_censo">
                    
                        <table width="800px" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr align="left">
                                <td>
                                	<br />
                                    <fieldset>
                                    
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left">
                                                <?
                                                if($d_censo_minsal == 1){
                                                    echo "<input type='checkbox' checked name='censo_minsal' onclick='document.frm_mantencion_censo.submit()' />Minsal";
                                                }
                                                else {
                                                    echo "<input type='checkbox' name='censo_minsal'  onclick='document.frm_mantencion_censo.submit()' />Minsal";
                                                }
                                                ?>
                                            </td>
                                            <td align="center" >Fecha<input size="12" id="f_date4" name="fecha_censo"  value="<? echo $fecha_censo ?>" /> <input type="Button" id="f_btn4" value="....."  /></td>
                                            <td align="center" > <input type="submit" value="Generar Informe" > </td>
                                            <td align="right">
                                            Servicio Clínico
                                            <select name="cod_servicio" onchange="document.frm_mantencion_censo.submit()">
                                                <?php
                                                for($i=0; $i<count($servicios); $i++)
                                                {
                                                    if($id_servicios[$i]==$cod_servicio)
                                                    {
                                                        echo "<option value='".$id_servicios[$i]."' selected>".$servicios[$i]."</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$id_servicios[$i]."'>".$servicios[$i]."</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </td>
                                        </tr>
                                    </table>
                                    </fieldset>
                                </td>
                            </tr>
                            
                    	</table>

                    </form>
                    
                  


       
					<table width="780" align="center" border="0" cellspacing="0" cellpadding="0">
						<tr>
                        	<td>
					        	<fieldset>
						        	<table width="780px" align="center">
						            	<tr>
						                	<td>
									        	<div id="afectado" align="left" style="float:none; width: 100%; padding: 2px;">
						            		    	<table border="1px" cellpadding="1px" cellspacing="0px">
						                    			<tr valign="middle">
								                        	<td width="25" align="center" rowspan="2" bgcolor="#e8eaec">N°</td>
								                        	<td width="260" align="center" rowspan="2" bgcolor="#e8eaec">PACIENTE</td>
							        		                <td width="220" align="center" colspan="2" bgcolor="#e8eaec">INGRESO</td>
							        		                <td width="220" align="center" colspan="2" bgcolor="#e8eaec">EGRESO</td>
		    	            						    </tr>
                                                        <tr>
								                        	<td width="90" align="center" bgcolor="#e8eaec">Fecha</td>
								                        	<td width="130" align="center" bgcolor="#e8eaec">Procedencia</td>
							        		                <td width="90" align="center" bgcolor="#e8eaec">Fecha</td>
							        		                <td width="130" align="center" bgcolor="#e8eaec">Destino</td>
                                                        </tr>
							        		        </table>
			       								    <div style="width:780px;height:380px;overflow:auto;">






	<?

	$total_ingresos = 0;
	$total_ingresos_fuera = 0;
	$total_ingresos_internos = 0;
	$total_ingresos_otro = 0;
	
	$total_egresos = 0;
	$total_egresos_fuera = 0;
	$total_egresos_internos = 0;
	$total_egresos_fallecidos = 0;
	$total_egresos_otro = 0;
	
	$total_camas = 0;
	$total_final_hosp = 0;
	$total_inicial_hosp = 0;
	
	$total_el_mismo_dia_hospitalizados = 0;


			echo "<table id='table_mantencion_censo' border='1' cellpadding='1' cellspacing='0'>";
				if ($d_censo_minsal == 1)
				{
					$sql = "SELECT * FROM camas where tipo_1 = '".$cod_servicio."' AND estado = 2 order by fecha_ingreso DESC";
				}
				else
				{
					$sql = "SELECT * FROM camas where cod_servicio = '".$cod_servicio."' AND estado = 2 order by fecha_ingreso DESC";
				}
				mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
				mysql_select_db('camas') or die('Cannot select database');
				$query = mysql_query($sql) or die(mysql_error());
				
				$i=1;
				
				while($censo = mysql_fetch_array($query))
				{
					if ($censo['fecha_ingreso'] <= $fecha_proceso and fecha_ingreso)
					{
						$id_cama=$censo['id']
						?>
						<tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
						onClick="window.location.href='<? echo"modifica_cama_censo.php?id_cama=$id_cama&fecha_censo=$fecha_censo&cod_servicio=$cod_servicio&d_censo_minsal=$d_censo_minsal"; ?>'; ">
						<?
							echo "<td width='25'>".$i."</td>";
							echo "<td width='260' align='left'>".$censo['nom_paciente']."</td>";
							echo "<td width='90' align='center'>".cambiarFormatoFecha($censo['fecha_ingreso'])."</td>";
							echo "<td width='130' align='left'>".$censo['procedencia']."</td>";
							echo "<td width='90' align='center'>&nbsp;</td>";
							echo "<td width='130' align='left'>&nbsp;</td>";
						echo "<tr>";
						$i++;
					}
				}

				if ($d_censo_minsal == 1)
				{
					$sql = "SELECT * FROM hospitalizaciones where tipo_1 = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 order by fecha_ingreso DESC";
				}
				else
				{
					$sql = "SELECT * FROM hospitalizaciones where cod_servicio = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 order by fecha_ingreso DESC";
				}
				mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
				mysql_select_db('camas') or die('Cannot select database');
				$query = mysql_query($sql) or die(mysql_error());
				
				while($censo = mysql_fetch_array($query))
				{
						$id_hosp=$censo['id']
						?>
						<tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
						onClick="window.location.href='<? echo"modifica_hosp_censo.php?id_hosp=$id_hosp&fecha_censo=$fecha_censo&cod_servicio=$cod_servicio&d_censo_minsal=$d_censo_minsal"; ?>'; ">
						<?
						echo "<td width='25'>".$i."</td>";
						echo "<td width='260' align='left'>".$censo['nom_paciente']."</td>";
						echo "<td width='90' align='center'>".cambiarFormatoFecha($censo['fecha_ingreso'])."</td>";
						echo "<td width='130' align='left'>".$censo['procedencia']."</td>";
						echo "<td width='90' align='center'>".cambiarFormatoFecha($censo['fecha_egreso'])."</td>";
						echo "<td width='130' align='left'>".$censo['destino']."</td>";
					echo "<tr>";
					$i++;
				}

				?>


			</table>




													</div>
												</div>

											</td>
                                        </tr>
                                    </table>
								</fieldset>
                            </td>
                        </tr>
                    </table>
                </fieldset>    
			</td>
        </tr>
	    
	</table>

<script language="JavaScript">
<!--
	tigra_tables('table_mantencion_censo', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
// -->
</script>

<script type="text/javascript">//<![CDATA[

var cal = Calendar.setup({
  onSelect: function(cal) { cal.hide() }
});
cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");

//]]></script>



</div>


</body>
</html>

<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>


