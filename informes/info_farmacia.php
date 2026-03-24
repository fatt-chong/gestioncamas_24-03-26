<?php
$tipo_categorizacion= $_GET['tipo_categorizacion'];
$opcion_1= $_GET['opcion_1'];
$cod_servicio= $_GET['cod_servicio'];
$fecha_desde= $_GET['fecha_desde'];
$fecha_hasta= $_GET['fecha_hasta'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="exp_excel/jquery-1.3.2.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>

<style type="text/css">
.print { 
display: none;
}
@media print {
.noprint {
display: none;
}
}
</style>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Informe Categorizaci�n por Servicios.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"; >

<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 

<div style="position:relative">


<SCRIPT LANGUAGE="JavaScript"><!--
imgsrc=new Array();
imgsrc[1]="img/a_menubutton1.gif";
imgsrc[2]="img/p_menubutton1.gif";
imgsrc[3]="img/a_menubutton2.gif";
imgsrc[4]="img/p_menubutton2.gif";
imgsrc[5]="img/a_menubutton3.gif";
imgsrc[6]="img/p_menubutton3.gif";
imgsrc[7]="img/a_menubutton4.gif";
imgsrc[8]="img/p_menubutton4.gif";
imgsrc[9]="img/a_menubutton5.gif";
imgsrc[10]="img/p_menubutton5.gif";
imgsrc[11]="img/a_menubutton6.gif";
imgsrc[12]="img/p_menubutton6.gif";

img =new Array();
for (i=0; i< imgsrc.length; i++) {
  img[i]=new Image();
  img[i].src=imgsrc[i];
}
function change(number, picture) {
  {
    document[picture].src=img[number].src;
  }
}
// -->
</SCRIPT>



<?
include "../funciones/funciones.php";

if ($fecha_desde == '')
{
	$fecha_desde = date('d-m-Y');
}

if ($fecha_hasta == '')
{
	$fecha_hasta = date('d-m-Y');
}

if ($cod_servicio == '')
{
	$cod_servicio = 1;
}

if ($tipo_categorizacion == '')
{
	$tipo_categorizacion = 1;
}

if ($opcion_1 == 'on') {
	$d_opcion_1 = 1;
}
else {
	$d_opcion1 = 0;
}

$fecha_desde_proceso = cambiarFormatoFecha($fecha_desde);
$fecha_hasta_proceso = cambiarFormatoFecha($fecha_hasta);

?>

<table width="900px" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr class="noprint" align="right">
        <td style="border-bottom-style:solid; border-color:#999; border-width:2px;">

            <? $params = "?tipo_categorizacion=$tipo_categorizacion&cod_servicio=$cod_servicio&opcion_1=$opcion_1&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta"; ?>

            <div align="left" >
                <TABLE Cellpadding="0" Cellspacing="0" >
                <TR>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_categoriza.php<? echo $params; ?>" ONMOUSEOVER="change('1','m1')" ONMOUSEOUT= "change('2','m1')" name="m1"><IMG NAME="m1" SRC="img/p_menubutton1.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_gcamas.php<? echo $params; ?>"  ONMOUSEOVER="change('3','m2')" ONMOUSEOUT= "change('4','m2')" name="m2"><IMG NAME="m2" SRC="img/p_menubutton2.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_censo.php<? echo $params; ?>" ONMOUSEOVER="change('5','m3')" ONMOUSEOUT= "change('6','m3')" name="m3"><IMG NAME="m3" SRC="img/p_menubutton3.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_indicadores.php<? echo $params; ?>" ONMOUSEOVER="change('7','m4')" ONMOUSEOUT= "change('8','m4')" name="m4"><IMG NAME="m4" SRC="img/p_menubutton4.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_farmacia.php<? echo $params; ?>" ONMOUSEOVER="change('9','m5')" ONMOUSEOUT= "change('10','m5')" name="m5"><IMG NAME="m5" SRC="img/p_menubutton5.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_especifico.php<? echo $params; ?>" ONMOUSEOVER="change('11','m6')" ONMOUSEOUT= "change('12','m6')" name="m6"><IMG NAME="m6" SRC="img/p_menubutton6.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                </TR>
                </TABLE>
            </div>

        </td>
    </tr>

    <form method="get" action="info_farmacia.php" name="frm_info_categoriza" id="frm_info_categoriza">
    
    <tr class="noprint">
        <td align="left" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="bottom" height="25px">
                        &nbsp;&nbsp;<a style="font-size:14px">INFORMES DE FARMACIA.</a>
                    </td>
                    <td align="right">
                        TIPO DE INFORME 
                        <select name="tipo_categorizacion" onchange="document.frm_info_categoriza.submit()">
                            <option value=1 <? if ($tipo_categorizacion == 1) { echo "selected"; } ?> >Dosis Unitaria </option>
                            <option value=2 <? if ($tipo_categorizacion == 2) { echo "selected"; } ?> >Consumo por Servicio </option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

	

	<?
	
	mysql_connect ('10.6.21.29','usuario','hospital');
	
    switch ($tipo_categorizacion) {
    case 1:
	
		$sql = "SELECT * FROM sscc";
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$i = 0;
		while($l_servicios = mysql_fetch_array($query)){
		
			if($l_servicios['id'] == $cod_servicio)
			{
				$desc_servicio = $l_servicios['servicio'];
			}	
		
			if ($l_servicios['id'] < 50 )
			{
				$id_servicios[$i] = $l_servicios['id'];
				$servicios[$i] = $l_servicios['servicio'];
				$i++;
			}
		}
	
		?>

		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="fecha_hasta" value="<? echo $fecha_hasta; ?>" type="hidden"  />


        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td></tr>
                    <tr>
                        <td align="left" >Fecha de Informe <input size="12" id="f_date4" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn4" value="....."  /></td>
                        <td align="center">
                            Servicio Cl�nico
                            <select name="cod_servicio" onchange="document.frm_info_categoriza.submit()">
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

                        <td align="left" > <input type="submit" value="      Generar Informe      " > </td>
                    </tr>
                    <tr><td height="5px"></td><td></td></tr>
                </table>
                
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="left" style="font-size:18px" >DOSIS UNITARIA SERVICIO CLINICO <? echo $desc_servicio."  (Fecha ".$fecha_desde." )" ?></td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>

		</form>

		<script type="text/javascript">//<![CDATA[
        
        var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
        });
        cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");
        
        //]]></script>
        
    </table>

	<table id="Exportar_a_Excel" align="center" border="0px" cellpadding="0" cellspacing="0">

        <?

		$sql = "SELECT * FROM camas where cod_servicio = '".$cod_servicio."' order by sala, cama";
		
	
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$sala = '0';
		
		$flag = 0;
		
		//echo "<table align='center'>";

		while($paciente = mysql_fetch_array($query))
		{
			$flag = 1;
			if ($sala <> $paciente['sala']){
				if ($sala <>'0'){
//					echo"<tr style=font-size:15px;'>";
//					echo"<td align='center'>Resumen Pacientes de Sala</td>";
//					echo"</tr>";
					echo "</table>";
					echo"</fieldset>";
					echo"</td>";
					echo"</tr>";
				}
				echo "<tr>";
				echo "<td>";
				echo "<fieldset><legend style='font-size:14px' >SALA ".$paciente['sala']."</legend>";

				echo "<table width='100%' align='left' border='1px' cellspacing='0'>";
				echo "<tr style='vertical-align:bottom'>";
				echo "<td>CAMA</td>";
				echo "<td width='250px' >NOMBRE PACIENTE</td>";
				echo "<td>RUT</td>";
				echo "<td>INGRESO</td>";
				echo "<td>EGRESO</td>";
				echo "</tr>";
			}
			$sala = $paciente['sala'];
			$cama = $paciente['cama'];
			$fecha_ingreso = $paciente['fecha_ingreso'];
			
			if ($fecha_ingreso	<= $fecha_desde_proceso and $paciente['estado'] == 2)
			{
			 	$rut_paciente = $paciente['rut_paciente'];
			 	$nombre_paciente = $paciente['nom_paciente'];
				$id_paciente = $paciente['id_paciente'];
				$fecha_egreso = "Hospitalizado";
			}
			else
			{
				$sql = "SELECT * FROM hospitalizaciones where cod_servicio = $cod_servicio and sala = '".$sala."' and cama = $cama and fecha_ingreso <= '".$fecha_desde_proceso."' and fecha_egreso >= '".$fecha_desde_proceso."' order by fecha_ingreso DESC";
		
				mysql_select_db('camas') or die('Cannot select database');
				$query2 = mysql_query($sql) or die(mysql_error());
				$hospitalizado = mysql_fetch_array($query2);
				if ($hospitalizado)
				{
				 	$rut_paciente = $hospitalizado['rut_paciente'];
				 	$nombre_paciente = $hospitalizado['nom_paciente'];
					$id_paciente = $hospitalizado['id_paciente'];
					$fecha_ingreso = $hospitalizado['fecha_ingreso'];
					$fecha_egreso = $hospitalizado['fecha_egreso'];
				
				}
				else
				{
					$rut_paciente = 0;
		 			$nombre_paciente = "Cama Sin PAciente";
					$id_paciente = 0;
					$fecha_ingreso = "00/00/000";
					$fecha_egreso = "00/00/000";
				}
				
			}
			echo "<tr height='20px' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif'>";		
			echo "<td align='center'>".$paciente['cama']."</td>";
		
			echo "<td>".$nombre_paciente."</td>";
			echo "<td>".$rut_paciente."</td>";
			echo "<td align='center'>".cambiarFormatoFecha2($fecha_ingreso)."</td>";
			echo "<td align='center'>".cambiarFormatoFecha2($fecha_egreso)."</td>";
			
			echo "</tr>";
			
			echo "<tr>";
			echo "<td colspan='5'>";
			echo "<table width='100%' border='1px' cellspacing='0'>";

			if ($id_paciente <> 0)
			{
				// $sql = "SELECT * FROM controlfarmacos where id = '".$id_paciente."' and fecha = '".$fecha_desde_proceso."'";
				// mysql_select_db('paciente') or die('Cannot select database');
				// $query3 = mysql_query($sql) or die(mysql_error());
				
				// echo "<tr align='left' height='10px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
				// echo "<td width='65'>Codigo</td>";
				// echo "<td width='330'>Farmaco</td>";
				// echo "<td width='65'>Cantidad</td>";
				// echo "<td width='100'>Unidad</td>";
				// echo "</tr>";
				
				// while($list_paciente = mysql_fetch_array($query3)){
				// 	$id_hosp = $list_paciente['id'];
					?>
				<!-- 	<tr align="left" height="10px" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
					  <td width="65"><? echo $list_paciente['cod_producto']; ?>	</td>
					  <td width="330"><? echo $list_paciente['nombre']; ?> </td>
					  <td width="65" align="right"><? echo $list_paciente['cantidad']; ?> </td>
					  <td width="100"><? echo $list_paciente['unid_medida']; ?> </td> -->
					<?
					// echo"</tr>";
				// }
			}
			
			echo "</table>";

			
			
			
			
			
			
			
			
		}

if ($flag == 1)
{
	
//	echo"<tr style=font-size:15px;'>";
//	echo"<td align='center'>Resumen de Sala</td>";
//	echo"</tr>";
	
	echo "</table>";
	
//	echo"</fieldset>";
//	echo "</td>";
//	echo "</tr>";
//	echo "<tr>";
//	echo "<td>";
//	echo "<fieldset><legend style='font-size:14px' >RESUMEN SERVICIO ".$desc_servicio." </legend>";
//	echo"<table width='100%' align='left' cellpadding='11px'  border='1px' cellspacing='0' style=font-size:15px;'>";

//	echo"<tr>";
//	echo"<td> </td>";
//	echo"</tr>";
	
//	echo"<tr align='center'>";
//	echo"<td colspan='12'>TOTAL PACIENTES CATEGORIZADOS </td>";
//	echo"</tr>";

//	echo"</table>";
//	echo"</fieldset>";
}


?>

</table>
<table align="center">






		<?
		break;
    case 2:
		?>


		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />



        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
	                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	                <tr><td height="15px"></td><td></td></tr>        
        	            <tr>
	                    	<td>
		                    <?
	                        if($d_opcion_1 == 1){
                		        echo "<input type='checkbox' checked name='opcion_1' onclick='document.frm_info_categoriza.submit()' />C/G</td>";
        		            }
		                    else {
        		                echo "<input type='checkbox' name='opcion_1'  onclick='document.frm_info_categoriza.submit()' />C/G</td>";				
                		    }
		                    ?>
    	                    <td align="center" >Desde <input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
        	                <td align="center" >Hasta <input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
            	            <td align="center" > <input type="submit" value="    Generar Informe   " > </td>
                	    </tr>
                    	<tr><td height="5px"></td><td></td></tr>        
                	</table>
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >RESUMEN CATEGORIZACIONES ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>

        </form>
        
          <script type="text/javascript">//<![CDATA[
        
          var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
          cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
        
        //]]></script>
    

		<?



		if($d_opcion_1 == 0){
			$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' order by tipo_1";
		}
		else {
			$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' 
			AND cod_servicio < 40 and cod_servicio <> 10 and cod_servicio <> 11 and cod_servicio <> 12 order by tipo_1";
		}

		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$total_a1 = 0;
		$total_a2 = 0;
		$total_a3 = 0;
		$total_b1 = 0;
		$total_b1 = 0;
		$total_b2 = 0;
		$total_b3 = 0;
		$total_c1 = 0;
		$total_c2 = 0;
		$total_d3 = 0;
		$total_d1 = 0;
		$total_d2 = 0;
		$total_d3 = 0;
		$total = 0;
		
		$total_s_a1 = 0;
		$total_s_a2 = 0;
		$total_s_a3 = 0;
		$total_s_b1 = 0;
		$total_s_b1 = 0;
		$total_s_b2 = 0;
		$total_s_b3 = 0;
		$total_s_c1 = 0;
		$total_s_c2 = 0;
		$total_s_c3 = 0;
		$total_s_d1 = 0;
		$total_s_d2 = 0;
		$total_s_d3 = 0;
		
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td align='left'> SERVICIOS CLINICOS </td>";
							echo "<td>A-1</td>";
							echo "<td>A-2</td>";
							echo "<td>A-3</td>";
							echo "<td>B-1</td>";
							echo "<td>B-2</td>";
							echo "<td>B-3</td>";
							echo "<td>C-1</td>";
							echo "<td>C-2</td>";
							echo "<td>C-3</td>";
							echo "<td>D-1</td>";
							echo "<td>D-2</td>";
							echo "<td>D-3</td>";
							echo "<td>TOTAL</td>";
						echo "</tr>";		

						$flag = 0;

						while($categoriza = mysql_fetch_array($query))
						{
						
							if ($tipo_1 <> $categoriza['tipo_1'] and $flag == 1)
							{
									
								$total_s = $total_s_a1+$total_s_a2+$total_s_a3+$total_s_b1+$total_s_b2+$total_s_b3+$total_s_c1+$total_s_c2+$total_s_c3+$total_s_d1+$total_s_d2+$total_s_d3;
								echo "<tr align='right'>";
								echo "<td align='left'> ".$d_tipo_1." </td>";
								echo "<td> ".$total_s_a1." </td>";
								echo "<td> ".$total_s_a2." </td>";
								echo "<td> ".$total_s_a3." </td>";
								echo "<td> ".$total_s_b1." </td>";
								echo "<td> ".$total_s_b2." </td>";
								echo "<td> ".$total_s_b3." </td>";
								echo "<td> ".$total_s_c1." </td>";
								echo "<td> ".$total_s_c2." </td>";
								echo "<td> ".$total_s_c3." </td>";
								echo "<td> ".$total_s_d1." </td>";
								echo "<td> ".$total_s_d2." </td>";
								echo "<td> ".$total_s_d3." </td>";
								echo "<td> ".$total_s." </td>";
								echo "</tr>";		
						
								$total_s_a1 = 0;
								$total_s_a2 = 0;
								$total_s_a3 = 0;
								$total_s_b1 = 0;
								$total_s_b1 = 0;
								$total_s_b2 = 0;
								$total_s_b3 = 0;
								$total_s_c1 = 0;
								$total_s_c2 = 0;
								$total_s_c3 = 0;
								$total_s_d1 = 0;
								$total_s_d2 = 0;
								$total_s_d3 = 0;
						
							}
						
							$flag = 1;
							
							$tipo_1 = $categoriza['tipo_1'];
							$d_tipo_1 = $categoriza['d_tipo_1'];
						
							$categorizacion_final = $categoriza['categorizacion_riesgo'].''.$categoriza['categorizacion_dependencia'];
							
							switch ($categorizacion_final) {
								case 'A1':
									$total_a1++;
									$total_s_a1++;
									break;
								case 'A2':
									$total_a2++;
									$total_s_a2++;
									break;
								case 'A3':
									$total_a3++;
									$total_s_a3++;
									break;
								case 'B1':
									$total_b1++;
									$total_s_b1++;
									break;
								case 'B2':
									$total_b2++;
									$total_s_b2++;
									break;
								case 'B3':
									$total_b3++;
									$total_s_b3++;
									break;
								case 'C1':
									$total_c1++;
									$total_s_c1++;
									break;
								case 'C2':
									$total_c2++;
									$total_s_c2++;
									break;
								case 'C3':
									$total_c3++;
									$total_s_c3++;
									break;
								case 'D1':
									$total_d1++;
									$total_s_d1++;
									break;
								case 'D2':
									$total_d2++;
									$total_s_d2++;
									break;
								case 'D3':
									$total_d3++;
									$total_s_d3++;
									break;
							}
				
						}

						$total_s = $total_s_a1+$total_s_a2+$total_s_a3+$total_s_b1+$total_s_b2+$total_s_b3+$total_s_c1+$total_s_c2+$total_s_c3+$total_s_d1+$total_s_d2+$total_s_d3;
						
						$total = $total_a1+$total_a2+$total_a3+$total_b1+$total_b2+$total_b3+$total_c1+$total_c2+$total_c3+$total_d1+$total_d2+$total_d3;
						
						echo "<tr align='right'>";
							echo "<td align='left'> ".$d_tipo_1." </td>";
							echo "<td> ".$total_s_a1." </td>";
							echo "<td> ".$total_s_a2." </td>";
							echo "<td> ".$total_s_a3." </td>";
							echo "<td> ".$total_s_b1." </td>";
							echo "<td> ".$total_s_b2." </td>";
							echo "<td> ".$total_s_b3." </td>";
							echo "<td> ".$total_s_c1." </td>";
							echo "<td> ".$total_s_c2." </td>";
							echo "<td> ".$total_s_c3." </td>";
							echo "<td> ".$total_s_d1." </td>";
							echo "<td> ".$total_s_d2." </td>";
							echo "<td> ".$total_s_d3." </td>";
							echo "<td> ".$total_s." </td>";
						echo "</tr>";		

						echo "<tr align='right'>";
							echo "<td align='left'> TOTALES </td>";
							echo "<td> ".$total_a1." </td>";
							echo "<td> ".$total_a2." </td>";
							echo "<td> ".$total_a3." </td>";
							echo "<td> ".$total_b1." </td>";
							echo "<td> ".$total_b2." </td>";
							echo "<td> ".$total_b3." </td>";
							echo "<td> ".$total_c1." </td>";
							echo "<td> ".$total_c2." </td>";
							echo "<td> ".$total_c3." </td>";
							echo "<td> ".$total_d1." </td>";
							echo "<td> ".$total_d2." </td>";
							echo "<td> ".$total_d3." </td>";
							echo "<td> ".$total." </td>";
						echo "</tr>";		

						echo "<tr align='right'>";
							echo "<td align='left'> % Sobre Total </td>";
							if ($total <> 0)
							{
								echo "<td> ".redondear_dos_decimal(($total_a1*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_a2*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_a3*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b1*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b2*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b3*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_c1*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_c2*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_c3*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_d1*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_d2*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_d3*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total*100)/$total)." % </td>";
							}
							else
							{
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
								echo "<td> 0 </td>";
							}
						echo "</tr>";		
					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";






		break;
	}

	?>






    <tr height="10px">
    </tr>
    <tr align="center" class="noprint">
        <td>

            <SCRIPT LANGUAGE="JavaScript">
            if (window.print) {
            document.write('<form><input type=button name=print value="imprimir" onClick="javascript:window.print()"></form>');
            }
            </script>

            <form action="exp_excel/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                <p><img src="img/export_to_excel.gif" class="botonExcel" /></p>
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            </form>
        </td>

    </tr>
</table>



<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>

</body>
</html>

