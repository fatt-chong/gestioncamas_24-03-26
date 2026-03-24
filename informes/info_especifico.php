<?php

$tipo_categorizacion= $_GET['tipo_categorizacion'];
$cod_servicio= $_GET['cod_servicio'];
$fecha_desde= $_GET['fecha_desde'];
$fecha_hasta= $_GET['fecha_hasta'];
// print('<pre>'); print_r($_GET); print('</pre>');

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

if ($tipo_categorizacion == '' or $tipo_categorizacion > 4)
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

    <form method="get" action="info_especifico.php" name="frm_info_especifico" id="frm_info_especifico">
    
    <tr class="noprint">
        <td align="left" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="bottom" height="25px">
                        &nbsp;&nbsp;<a style="font-size:14px">INFORMES DE GESTION.</a>
                    </td>
                    <td align="right">
                        TIPO DE INFORME 
                        <select name="tipo_categorizacion" onchange="document.frm_info_especifico.submit()">
                            <option value=1 <? if ($tipo_categorizacion == 1) { echo "selected"; } ?> >Tiempo Espera Hospitalizaci&oacute;n </option>
                            <option value=2 <? if ($tipo_categorizacion == 2) { echo "selected"; } ?> >Alta de Pacientes </option>
                            <option value=3 <? if ($tipo_categorizacion == 3) { echo "selected"; } ?> >Pacientes Hospitalizados </option>
                            <option value=4 <? if ($tipo_categorizacion == 4) { echo "selected"; } ?> >Consumos x Paciente </option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

	

	<?
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	
    switch ($tipo_categorizacion) {
    case 1:
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
                		        echo "<input type='checkbox' checked name='opcion_1' onclick='document.frm_info_especifico.submit()' />C/G</td>";
        		            }
		                    else {
        		                echo "<input type='checkbox' name='opcion_1'  onclick='document.frm_info_especifico.submit()' />C/G</td>";				
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
                        <td align="center" style="font-size:18px" >TIEMPO ESPERA DE HOSPITALIZACION ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
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
			$sql = "SELECT * FROM hospitalizaciones where fecha_ingreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_servicio = 50 and tipo_traslado <> 3 order by cod_destino";
		}
		else {
			$sql = "SELECT * FROM hospitalizaciones where fecha_ingreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_servicio = 50 and tipo_traslado <> 3 order by cod_destino";
		}

		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$total_b_00_08 = 0;
		$total_b_08_12 = 0;
		$total_b_12_24 = 0;
		$total_b_24_ms = 0;
		$total_p_00_08 = 0;
		$total_p_08_12 = 0;
		$total_p_12_24 = 0;
		$total_p_24_ms = 0;
		$total_b = 0;
		$total_p = 0;

		$s_total_b_00_08 = 0;
		$s_total_b_08_12 = 0;
		$s_total_b_12_24 = 0;
		$s_total_b_24_ms = 0;
		$s_total_b = 0;
		$s_total_p_00_08 = 0;
		$s_total_p_08_12 = 0;
		$s_total_p_12_24 = 0;
		$s_total_p_24_ms = 0;
		$s_total_p = 0;
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td rowspan=2 align='left'> DESTINO </td>";
							echo "<td colspan=5 width='250px'>Beneficiarios</td>";
							echo "<td colspan=5 width='250px'>Particulares</td>";
							echo "<td colspan=5 width='250px'>Total</td>";
						echo "</tr>";
						echo "<tr align='center'>";
							echo "<td> 0-8 Hrs </td>";
							echo "<td> 8-12 Hrs </td>";
							echo "<td> 12-24 Hrs </td>";
							echo "<td> +24 Hrs </td>";
							echo "<td> Total </td>";
							echo "<td> 0-8 Hrs </td>";
							echo "<td> 8-12 Hrs </td>";
							echo "<td> 12-24 Hrs </td>";
							echo "<td> +24 Hrs </td>";
							echo "<td> Total </td>";
							echo "<td> 0-8 Hrs </td>";
							echo "<td> 8-12 Hrs </td>";
							echo "<td> 12-24 Hrs </td>";
							echo "<td> +24 Hrs </td>";
							echo "<td> Total </td>";
						echo "</tr>";

						$flag = 0;

						while($hospitaliza = mysql_fetch_array($query))
						{
						
							if ($cod_destino <> $hospitaliza['cod_destino'] and $flag == 1)
							{
								$s_total_b = $s_total_b_00_08+$s_total_b_08_12+$s_total_b_12_24+$s_total_b_24_ms;
								$s_total_p = $s_total_p_00_08+$s_total_p_08_12+$s_total_p_12_24+$s_total_p_24_ms;
	
								echo "<tr align='right'>";
									echo "<td align='left'> ".$destino." </td>";
									echo "<td> ".$s_total_b_00_08." </td>";
									echo "<td> ".$s_total_b_08_12." </td>";
									echo "<td> ".$s_total_b_12_24." </td>";
									echo "<td> ".$s_total_b_24_ms." </td>";
									echo "<td> ".$s_total_b." </td>";
									echo "<td> ".$s_total_p_00_08." </td>";
									echo "<td> ".$s_total_p_08_12." </td>";
									echo "<td> ".$s_total_p_12_24." </td>";
									echo "<td> ".$s_total_p_24_ms." </td>";
									echo "<td> ".$s_total_p." </td>";
									echo "<td> ".($s_total_b_00_08 + $s_total_p_00_08)." </td>";
									echo "<td> ".($s_total_b_08_12 + $s_total_p_08_12)." </td>";
									echo "<td> ".($s_total_b_12_24 + $s_total_p_12_24)." </td>";
									echo "<td> ".($s_total_b_24_ms + $s_total_p_24_ms)." </td>";
									echo "<td> ".($s_total_b + $s_total_p)." </td>";
								echo "</tr>";		


								$total_b_00_08 = $total_b_00_08 + $s_total_b_00_08;
								$total_b_08_12 = $total_b_08_12 + $s_total_b_08_12;
								$total_b_12_24 = $total_b_12_24 + $s_total_b_12_24;
								$total_b_24_ms = $total_b_24_ms + $s_total_b_24_ms;
								$total_p_00_08 = $total_p_00_08 + $s_total_p_00_08;
								$total_p_08_12 = $total_p_08_12 + $s_total_p_08_12;
								$total_p_12_24 = $total_p_12_24 + $s_total_p_12_24;
								$total_p_24_ms = $total_p_24_ms + $s_total_p_24_ms;
								$total_b = $total_b + $s_total_b;
								$total_p = $total_p + $s_total_p;


								$s_total_b_00_08 = 0;
								$s_total_b_08_12 = 0;
								$s_total_b_12_24 = 0;
								$s_total_b_24_ms = 0;
								$s_total_p_00_08 = 0;
								$s_total_p_08_12 = 0;
								$s_total_p_12_24 = 0;
								$s_total_p_24_ms = 0;
						
							}
						
							$flag = 1;
							
							$cod_destino = $hospitaliza['cod_destino'];
							$destino = $hospitaliza['destino'];
						
							$ingreso = $hospitaliza['fecha_ingreso'].' '.$hospitaliza['hora_ingreso'];
							$egreso = $hospitaliza['fecha_egreso'].' '.$hospitaliza['hora_egreso'];
							$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
							
//							echo $ingreso." /// ".$egreso." /// ".$tiempo_espera." </br>";

							if ($hospitaliza['cod_prevision'] < 4)
							{
								if ($tiempo_espera <= 8)
								{
									$s_total_b_00_08++;
								}
								if ($tiempo_espera > 8 and $tiempo_espera <= 12)
								{
									$s_total_b_08_12++;
								}
								
								if ($tiempo_espera > 12 and $tiempo_espera <= 24)
								{
									$s_total_b_12_24++;
								}
								
								if ($tiempo_espera > 24)
								{
									$s_total_b_24_ms++;
								}
							}
							else
							{
								if ($tiempo_espera <= 8)
								{
									$s_total_p_00_08++;
								}
								if ($tiempo_espera > 8 and $tiempo_espera <= 12)
								{
									$s_total_p_08_12++;
								}
								
								if ($tiempo_espera > 12 and $tiempo_espera <= 24)
								{
									$s_total_p_12_24++;
								}
								
								if ($tiempo_espera > 24)
								{
									$s_total_p_24_ms++;
								}
							}

							
							
							
							
				
						}

						$s_total_b = $s_total_b_00_08+$s_total_b_08_12+$s_total_b_12_24+$s_total_b_24_ms;
						$s_total_p = $s_total_p_00_08+$s_total_p_08_12+$s_total_p_12_24+$s_total_p_24_ms;

						$total_b_00_08 = $total_b_00_08 + $s_total_b_00_08;
						$total_b_08_12 = $total_b_08_12 + $s_total_b_08_12;
						$total_b_12_24 = $total_b_12_24 + $s_total_b_12_24;
						$total_b_24_ms = $total_b_24_ms + $s_total_b_24_ms;
						$total_p_00_08 = $total_p_00_08 + $s_total_p_00_08;
						$total_p_08_12 = $total_p_08_12 + $s_total_p_08_12;
						$total_p_12_24 = $total_p_12_24 + $s_total_p_12_24;
						$total_p_24_ms = $total_p_24_ms + $s_total_p_24_ms;
						$total_b = $total_b + $s_total_b;
						$total_p = $total_p + $s_total_p;


						echo "<tr align='right'>";
							echo "<td align='left'> ".$destino." </td>";
							echo "<td> ".$s_total_b_00_08." </td>";
							echo "<td> ".$s_total_b_08_12." </td>";
							echo "<td> ".$s_total_b_12_24." </td>";
							echo "<td> ".$s_total_b_24_ms." </td>";
							echo "<td> ".$s_total_b." </td>";
							echo "<td> ".$s_total_p_00_08." </td>";
							echo "<td> ".$s_total_p_08_12." </td>";
							echo "<td> ".$s_total_p_12_24." </td>";
							echo "<td> ".$s_total_p_24_ms." </td>";
							echo "<td> ".$s_total_p." </td>";
							echo "<td> ".($s_total_b_00_08 + $s_total_p_00_08)." </td>";
							echo "<td> ".($s_total_b_08_12 + $s_total_p_08_12)." </td>";
							echo "<td> ".($s_total_b_12_24 + $s_total_p_12_24)." </td>";
							echo "<td> ".($s_total_b_24_ms + $s_total_p_24_ms)." </td>";
							echo "<td> ".($s_total_b + $s_total_p)." </td>";
						echo "</tr>";		

						echo "<tr align='right'>";
							echo "<td align='left'> TOTALES </td>";
							echo "<td> ".$total_b_00_08." </td>";
							echo "<td> ".$total_b_08_12." </td>";
							echo "<td> ".$total_b_12_24." </td>";
							echo "<td> ".$total_b_24_ms." </td>";
							echo "<td> ".$total_b." </td>";
							echo "<td> ".$total_p_00_08." </td>";
							echo "<td> ".$total_p_08_12." </td>";
							echo "<td> ".$total_p_12_24." </td>";
							echo "<td> ".$total_p_24_ms." </td>";
							echo "<td> ".$total_p." </td>";
							echo "<td> ".($total_b_00_08 + $total_p_00_08)." </td>";
							echo "<td> ".($total_b_08_12 + $total_p_08_12)." </td>";
							echo "<td> ".($total_b_12_24 + $total_p_12_24)." </td>";
							echo "<td> ".($total_b_24_ms + $total_p_24_ms)." </td>";
							echo "<td> ".($total_b + $total_p)." </td>";
						echo "</tr>";

						$total = $total_b + $total_p;
						
						echo "<tr align='right'>";
							echo "<td align='left'> % Sobre Total </td>";
							if ($total <> 0)
							{
								echo "<td> ".redondear_dos_decimal(($total_b_00_08*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b_08_12*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b_12_24*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b_24_ms*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_b*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_p_00_08*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_p_08_12*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_p_12_24*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_p_24_ms*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal(($total_p*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal((($total_b_00_08 + $total_p_00_08)*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal((($total_b_08_12 + $total_p_08_12)*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal((($total_b_12_24 + $total_p_12_24)*100)/$total)." % </td>";
								echo "<td> ".redondear_dos_decimal((($total_b_24_ms + $total_p_24_ms)*100)/$total)." % </td>";
								
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

    case 2:
		?>

		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />

        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
	                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	                <tr><td height="15px"></td><td></td></tr>        
        	            <tr>
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
                        <td align="center" style="font-size:18px" >ALTA DE PACIENTES ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
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

//		$sql = "SELECT * FROM hospitalizaciones where fecha_egreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_destino > 100";

		 $sql = "SELECT
				camas.hospitalizaciones.hospitalizado,
				IF(camaSN='S',que_d_tipo_1,d_tipo_1) as Tipo_minsal,
				camas.hospitalizaciones.fecha_ingreso,
				camas.hospitalizaciones.fecha_egreso,
				camas.hospitalizaciones.servicio,
				camas.hospitalizaciones.nom_paciente,
				paciente.paciente.nroficha,
				paciente.prevision.prevision,
				paciente.institucion.instNombre,
				camas.hospitalizaciones.cta_cte,
				paciente.paciente.extranjero,
				camas.hospitalizaciones.acctransito,
				camas.hospitalizaciones.tipo_traslado,
				camas.hospitalizaciones.censo_correlativo,
				camas.hospitalizaciones.id_paciente,
				camas.hospitalizaciones.destino,
				date_format( camas.hospitalizaciones.fecha_egreso, '%Y' ) - date_format(paciente.paciente.fechanac, '%Y' ) -
				  ( date_format( camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format(paciente.paciente.fechanac, '00-%m-%d' ) )
				AS 
				  edad_paciente
				FROM camas.hospitalizaciones 
				Inner Join paciente.paciente ON camas.hospitalizaciones.id_paciente = paciente.paciente.id 
				left Join paciente.prevision ON paciente.paciente.prevision = paciente.prevision.id 
				left Join paciente.institucion ON paciente.paciente.conveniopago = paciente.institucion.instCod
				WHERE fecha_egreso 
				BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."'
				AND cod_destino > 90 and censo_eliminado is NULL
				GROUP BY cta_cte";

		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Hospit. </td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Ingreso </td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Egreso </td>";
							echo "<td> Tipo Cama </td>";
							echo "<td> Servicio </td>";
							echo "<td> Nombre Paciente </td>";
							echo "<td> Edad </td>";
							echo "<td> Prevision </td>";
							echo "<td> Convenio de Pago </td>";
							echo "<td> Cuenta Corriente </td>";
							echo "<td> Nro Ficha </td>";
							echo "<td> Extranj. </td>";
							echo "<td> Accidente Transito </td>";
							echo "<td> Correlativo </td>";
							echo "<td> Tipo Alta </td>";
						echo "</tr>";

						while($hospitaliza = mysql_fetch_array($query))
						{
						
							echo "<tr align='left'>";
								echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitaliza['hospitalizado'],0,10))." </td>";
								echo "<td> ".cambiarFormatoFecha($hospitaliza['fecha_ingreso'])." </td>";
								echo "<td> ".cambiarFormatoFecha($hospitaliza['fecha_egreso'])." </td>";
								echo "<td> ".$hospitaliza['Tipo_minsal']." </td>";
								echo "<td> ".$hospitaliza['servicio']." </td>";
								echo "<td> ".$hospitaliza['nom_paciente']." </td>";
								echo "<td> ".$hospitaliza['edad_paciente']." </td>";
								echo "<td> ".$hospitaliza['prevision']." </td>";
								echo "<td> ".$hospitaliza['instNombre']." </td>";
								echo "<td> ".$hospitaliza['cta_cte']." </td>";
								echo "<td> ".$hospitaliza['nroficha']." </td>";
								echo "<td> ".$hospitaliza['extranjero']." </td>";
								echo "<td> ".$hospitaliza['acctransito']." </td>";
								echo "<td> ".$hospitaliza['censo_correlativo']." </td>";
								echo "<td> ".$hospitaliza['destino']." </td>";
							echo "</tr>";		
						}

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";

		break;

    case 3:
		?>


		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />
		<input name="fecha_desde" value="<? echo $fecha_desde; ?>" type="hidden"  />
		<input name="fecha_hasta" value="<? echo $fecha_hasta; ?>" type="hidden"  />


        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >PACIENTES HOSPITALIZADOS</td>
           	            <td align="center" > <input type="submit" value="    Generar Informe   " > </td>
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

//		$sql = "SELECT * FROM hospitalizaciones where fecha_egreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_destino > 100";

		$sql = "SELECT camas.camas.hospitalizado, camas.camas.fecha_ingreso, camas.camas.servicio, camas.camas.rut_paciente, camas.camas.nom_paciente, camas.camas.edad_paciente, paciente.prevision.prevision, paciente.institucion.instNombre, camas.camas.cta_cte, paciente.paciente.extranjero, camas.camas.acctransito FROM camas.camas Inner Join paciente.paciente ON camas.camas.id_paciente = paciente.paciente.id Inner Join paciente.prevision ON paciente.paciente.prevision = paciente.prevision.id Inner Join paciente.institucion ON paciente.paciente.conveniopago = paciente.institucion.instCod Order By camas.id";

		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Hospit. </td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Ingreso </td>";
							echo "<td> Servicio </td>";
							echo "<td> Rut_Paciente</td>";
							echo "<td> Nombre Paciente </td>";
							echo "<td> Edad </td>";
							echo "<td> Prevision </td>";
							echo "<td> Convenio de Pago </td>";
							echo "<td> Cuenta Corriente </td>";
							echo "<td> Extranj. </td>";
							echo "<td> Accidente Transito </td>";
						echo "</tr>";

						while($hospitaliza = mysql_fetch_array($query))
						{
							
						$rut = $hospitaliza['rut_paciente'];
						$dv = ValidaDVRut($rut);
						
?>						
							<tr align="left" onclick="window.open('http://200.51.172.210/dynamic/certificador/previsional/asp/CertificadorPrevisional.asp?TXTCERT_RUTA=<? echo $rut; ?>&TXTCERT_RUTB=<? Echo $dv; ?>','', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=630,height=380')" >
<?

								echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitaliza['hospitalizado'],0,10))." </td>";
								echo "<td> ".cambiarFormatoFecha($hospitaliza['fecha_ingreso'])." </td>";
								echo "<td> ".$hospitaliza['servicio']." </td>";
								echo "<td align='right'> ".$rut."-".$dv."</td>";
								echo "<td> ".$hospitaliza['nom_paciente']." </td>";
								echo "<td align='right'> ".$hospitaliza['edad_paciente']." </td>";
								echo "<td> ".$hospitaliza['prevision']." </td>";
								echo "<td> ".$hospitaliza['instNombre']." </td>";
								echo "<td align='right'> ".$hospitaliza['cta_cte']." </td>";
								echo "<td> ".$hospitaliza['extranjero']." </td>";
								echo "<td> ".$hospitaliza['acctransito']." </td>";
							echo "</tr>";		
						}

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";

		break;

	case 4:
		?>


		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />



        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
	                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	                <tr><td height="15px"></td><td></td></tr>        
        	            <tr>
    	                    <td align="center" >Desde <input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
        	                <td align="center" >Hasta <input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
                            <td align="center" >Diagnostico <input size="20" id="busca_diag" name="busca_diag"  value="<? echo $busca_diag ?>" /> </td>
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
                        <td align="center" style="font-size:18px" >CONSUMO DE PACIENTES DE ALTA ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
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

//		$sql = "SELECT * FROM hospitalizaciones where fecha_egreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_destino > 100";

		$sql = "SELECT * FROM hospitalizaciones WHERE fecha_egreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND cod_destino > 100 and (diagnostico1 LIKE '%$busca_diag%' or diagnostico2 LIKE '%$busca_diag%')";

		mysql_select_db('camas') or die('Cannot select database');
		$query_principal = mysql_query($sql) or die(mysql_error());
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td> RUT </td>";
							echo "<td> Nombre Paciente </td>";
							echo "<td> Diagnostico 1</td>";
							echo "<td> Diagnostico 2</td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Hospit. </td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Ingreso </td>";
							echo "<td> &nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp; Egreso </td>";
							echo "<td> Servicio </td>";
							echo "<td> Edad </td>";
							echo "<td> Prevision </td>";
							echo "<td> Cta_Cte </td>";
							echo "<td> CCRR </td>";
							echo "<td> Prest. </td>";
							echo "<td> Descripcion </td>";
							echo "<td> Cant. </td>";
							echo "<td> Obs.Detalle </td>";
							echo "<td> Servicio </td>";
							echo "<td> Fecha </td>";
							echo "<td> Valor </td>";

						echo "</tr>";

						while($hospitaliza = mysql_fetch_array($query_principal))
						{
							$id_paciente = $hospitaliza['id_paciente'];
							$rut_paciente = $hospitaliza['rut_paciente'];
							$nom_paciente = $hospitaliza['nom_paciente'];
							$diagnostico1 = $hospitaliza['diagnostico1'];
							$diagnostico2 = $hospitaliza['diagnostico2'];
							$hospitalizado = $hospitaliza['hospitalizado'];
							$fecha_ingreso = $hospitaliza['fecha_ingreso'];
							$fecha_egreso = $hospitaliza['fecha_egreso'];
							$servicio = $hospitaliza['servicio'];
							$edad_paciente = $hospitaliza['edad_paciente'];
							$prevision = $hospitaliza['prevision'];
							$cta_cte = $hospitaliza['cta_cte'];
							

							if ($id_paciente == 0)
							{
								$sql = "SELECT * FROM controlfarmacos where cuenta_corriente = '".$cta_cte."' and fecha BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by fecha";
							}
							else
							{
								$sql = "SELECT * FROM controlfarmacos where id = '".$id_paciente."' and fecha BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by fecha";
							}

							if ($id_paciente <> 0 or $cta_cte <> 0)
							{
								//$sql = "SELECT * FROM hospitalizaciones where rut_paciente = '".$rut_paciente."'";
								mysql_select_db('paciente') or die('Cannot select database');
								$query2 = mysql_query($sql) or die(mysql_error());
								while($list_paciente = mysql_fetch_array($query2)){
									$id_hosp = $list_paciente['id'];
									
									$sql = "SELECT * FROM sscc where id = '".$list_paciente['idservicio']."'";
									mysql_select_db('camas') or die('Cannot select database');
									$query = mysql_query($sql) or die(mysql_error());
									$l_servicios = mysql_fetch_array($query);

									echo "<tr align='left' height='25px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
										echo "<td> ".$rut_paciente." </td>";
										echo "<td> ".$nom_paciente." </td>";
										echo "<td> ".$diagnostico1." </td>";
										echo "<td> ".$diagnostico2." </td>";
										echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitalizado,0,10))." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_ingreso)." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_egreso)." </td>";
										echo "<td> ".$servicio." </td>";
										echo "<td> ".$edad_paciente." </td>";
										echo "<td> ".$prevision." </td>";
										echo "<td> ".$cta_cte." </td>";
										echo "<td>FARMACIA</td>";

										$codigo = $list_paciente['cod_producto'];
									  	$descripcion = $list_paciente['nombre'];
									  	$cantidad = $list_paciente['cantidad'];
									  	$unid_medida = $list_paciente['unid_medida'];
										$dsk_servicio = $l_servicios['servicio'];
									  	$fecha = cambiarFormatoFecha(substr($list_paciente['fecha'],0,10));

										$sql = "SELECT * FROM producto where produCodInt = '".$codigo."'";
										mysql_select_db('aba') or die('Cannot select database');
										$query = mysql_query($sql) or die(mysql_error());
										$l_prestacion = mysql_fetch_array($query);
										$valor =  $l_prestacion['produPrecio'];
										
//										$valor = $valor * $cantidad;
										
//										echo $sql;
//										echo "<br>";
//										echo $valor;
										
										echo "<td> ".$codigo." </td>";
										echo "<td> ".$descripcion." </td>";
										echo "<td> ".$cantidad." </td>";
										echo "<td> ".$unid_medida." </td>";
										echo "<td> ".$dsk_servicio." </td>";
										echo "<td> ".$fecha." </td>";
										echo "<td align='right'> ".$valor." </td>";
										
									echo"</tr>";
								}
							}

							if ($rut_paciente <> 0 or $cta_cte <> 0)
							{
								$sql = "SELECT * FROM controllaboratorio where rut_paciente = '".$rut_paciente."' and fecha_extraccion BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by solicitud_examen";

								mysql_select_db('laboratorio') or die('Cannot select database');
								$query2 = mysql_query($sql) or die(mysql_error());
								while($list_paciente = mysql_fetch_array($query2))
								{
									$solicitud_examen = $list_paciente['solicitud_examen'];
									
									$sql = "SELECT * FROM prestacioneslaboratorio where solicitud_examen = '".$solicitud_examen."' ";
									mysql_select_db('laboratorio') or die('Cannot select database');
									$query_prestacion = mysql_query($sql) or die(mysql_error());
									while($list_prestacion = mysql_fetch_array($query_prestacion))
									{
										$numero_orden = $list_prestacion['numero_orden'];
										if ($list_prestacion['tipo_prueba'] == "B")
										{
											$unid_medida = "BIOLOGICA";
										}
										else
										{
											$unid_medida = "MICROBIOLOGICA";
										}
										
										echo "<tr align='left' height='25px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
											echo "<td> ".$rut_paciente." </td>";
											echo "<td> ".$nom_paciente." </td>";
											echo "<td> ".$diagnostico1." </td>";
											echo "<td> ".$diagnostico2." </td>";
											echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitalizado,0,10))." </td>";
											echo "<td> ".cambiarFormatoFecha($fecha_ingreso)." </td>";
											echo "<td> ".cambiarFormatoFecha($fecha_egreso)." </td>";
											echo "<td> ".$servicio." </td>";
											echo "<td> ".$edad_paciente." </td>";
											echo "<td> ".$prevision." </td>";
											echo "<td> ".$cta_cte." </td>";
											echo "<td>LABORATORIO</td>";

											$codigo = $list_prestacion['prestacion'];
											$descripcion = $list_prestacion['desc_prestacion'];
											$cantidad = "1";
											$dsk_servicio = $list_paciente['desc_servicio'];
											$fecha = cambiarFormatoFecha(substr($list_paciente['fecha_extraccion'],0,10));
	
											echo "<td> ".$codigo." </td>";
											echo "<td> ".$descripcion." </td>";
											echo "<td> ".$cantidad." </td>";
											echo "<td> ".$unid_medida." </td>";
											echo "<td> ".$dsk_servicio." </td>";
											echo "<td> ".$fecha." </td>";
											
										echo"</tr>";

									}
								}
							}
							
							if ($rut_paciente <> 0 or $cta_cte <> 0)
							{
								$sql = "SELECT * FROM cirugia where ciruPacieRut = '".$rut_paciente."' and ciruFecha BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by ciruFecha";

								mysql_select_db('pabellon') or die('Cannot select database');
								$query2 = mysql_query($sql) or die(mysql_error());
								while($list_pabellon = mysql_fetch_array($query2))
								{
								
									$cd_servicio = $list_pabellon['ciruServOrigCod'];
									
									$sql = "SELECT * FROM servicio where idservicio = '".$cd_servicio."'";
									mysql_select_db('acceso') or die('Cannot select database');
									$query3 = mysql_query($sql) or die(mysql_error());
									$lisservicio =  mysql_fetch_array($query3);
									if ( $lisservicio ) {  $servicio = $lisservicio['nombre']; } else { $servicio = " "; }
									
									echo "<tr align='left' height='25px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
										echo "<td> ".$rut_paciente." </td>";
										echo "<td> ".$nom_paciente." </td>";
										echo "<td> ".$diagnostico1." </td>";
										echo "<td> ".$diagnostico2." </td>";
										echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitalizado,0,10))." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_ingreso)." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_egreso)." </td>";
										echo "<td> ".$servicio." </td>";
										echo "<td> ".$edad_paciente." </td>";
										echo "<td> ".$prevision." </td>";
										echo "<td> ".$cta_cte." </td>";
										echo "<td>PABELLON</td>";

										$codigo = $list_pabellon['ciruInter1Cod'];
										$descripcion = $list_pabellon['ciruInter1Glosa'];
										$cantidad = "1";
										$unid_medida = $list_pabellon['ciruEstado'];
										$dsk_servicio = $servicio;
										$fecha = cambiarFormatoFecha(substr($list_pabellon['ciruFecha'],0,10));

										$sql = "SELECT * FROM prestaciones_institucional where codigo = '".$codigo."'";
										mysql_select_db('paciente') or die('Cannot select database');
										$query = mysql_query($sql) or die(mysql_error());
										$l_prestacion = mysql_fetch_array($query);
										$valor =  $l_prestacion['valor_total'];
										
										echo "<td> ".$codigo." </td>";
										echo "<td> ".$descripcion." </td>";
										echo "<td> ".$cantidad." </td>";
										echo "<td> ".$unid_medida." </td>";
										echo "<td> ".$dsk_servicio." </td>";
										echo "<td> ".$fecha." </td>";
										echo "<td align='right'> ".$valor." </td>";
										
									echo"</tr>";
								
								}
							}
							
							if ($rut_paciente <> 0 or $cta_cte <> 0)
							{
								$sql = "SELECT * FROM controlrayos where rut_paciente = '".$rut_paciente."' and fecha BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by fecha";

								mysql_select_db('paciente') or die('Cannot select database');
								$query2 = mysql_query($sql) or die(mysql_error());
								while($list_paciente = mysql_fetch_array($query2)){

									echo "<tr align='left' height='25px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
										echo "<td> ".$rut_paciente." </td>";
										echo "<td> ".$nom_paciente." </td>";
										echo "<td> ".$diagnostico1." </td>";
										echo "<td> ".$diagnostico2." </td>";
										echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitalizado,0,10))." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_ingreso)." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_egreso)." </td>";
										echo "<td> ".$servicio." </td>";
										echo "<td> ".$edad_paciente." </td>";
										echo "<td> ".$prevision." </td>";
										echo "<td> ".$cta_cte." </td>";
										echo "<td>IMAGENOLOGIA</td>";

										$codigo = $list_paciente['prestacion'];
										$descripcion = $list_paciente['desc_prestacion'];
										$cantidad = $list_paciente['nro_prestacion'];
										$unid_medida = $list_paciente['profesional'];
										$dsk_servicio = $list_paciente['procedencia']."(".$list_paciente['subprocedencia'].")";
										$fecha = cambiarFormatoFecha(substr($list_paciente['fecha'],0,10));

										$sql = "SELECT * FROM prestaciones_institucional where codigo = '".$codigo."'";
										mysql_select_db('paciente') or die('Cannot select database');
										$query = mysql_query($sql) or die(mysql_error());
										$l_prestacion = mysql_fetch_array($query);
										$valor =  $l_prestacion['valor_total'];
										
										echo "<td> ".$codigo." </td>";
										echo "<td> ".$descripcion." </td>";
										echo "<td> ".$cantidad." </td>";
										echo "<td> ".$unid_medida." </td>";
										echo "<td> ".$dsk_servicio." </td>";
										echo "<td> ".$fecha." </td>";
										echo "<td align='right'> ".$valor." </td>";
										
									echo"</tr>";
								
								}
							}
							
							if ($rut_paciente <> 0 or $cta_cte <> 0)
							{
								$sql = "SELECT * FROM controlap where rut_paciente = '".$rut_paciente."' and fecha BETWEEN '".$fecha_ingreso."' AND '".$fecha_egreso."' order by fecha";

								mysql_select_db('paciente') or die('Cannot select database');
								$query2 = mysql_query($sql) or die(mysql_error());
								while($list_paciente = mysql_fetch_array($query2)){
									$id_hosp = $list_paciente['id'];
									
									echo "<tr align='left' height='25px' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif'>";
										echo "<td> ".$rut_paciente." </td>";
										echo "<td> ".$nom_paciente." </td>";
										echo "<td> ".$diagnostico1." </td>";
										echo "<td> ".$diagnostico2." </td>";
										echo "<td align='right'> ".cambiarFormatoFecha(substr($hospitalizado,0,10))." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_ingreso)." </td>";
										echo "<td> ".cambiarFormatoFecha($fecha_egreso)." </td>";
										echo "<td> ".$servicio." </td>";
										echo "<td> ".$edad_paciente." </td>";
										echo "<td> ".$prevision." </td>";
										echo "<td> ".$cta_cte." </td>";
										echo "<td>A.PATOLOGICA</td>";

										$codigo = $list_paciente['prestacion'];
										$descripcion = $list_paciente['desc_prestacion'];
										$cantidad = $list_paciente['nro_prestacion'];
										$unid_medida = $list_paciente['tipo_examen'];
										$dsk_servicio = $list_paciente['procedencia'];
										$fecha = cambiarFormatoFecha(substr($list_paciente['fecha'],0,10));

										$sql = "SELECT * FROM prestaciones_institucional where codigo = '".$codigo."'";
										mysql_select_db('paciente') or die('Cannot select database');
										$query = mysql_query($sql) or die(mysql_error());
										$l_prestacion = mysql_fetch_array($query);
										$valor =  $l_prestacion['valor_total'];
										
										echo "<td> ".$codigo." </td>";
										echo "<td> ".$descripcion." </td>";
										echo "<td> ".$cantidad." </td>";
										echo "<td> ".$unid_medida." </td>";
										echo "<td> ".$dsk_servicio." </td>";
										echo "<td> ".$fecha." </td>";
										echo "<td align='right'> ".$valor." </td>";
										
									echo"</tr>";
									
								}
							}
						}

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

