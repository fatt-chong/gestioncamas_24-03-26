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
<title>Informe Ocupacion de Pabellones.</title>
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

//$fecha_hoy = date('d-m-Y');
//$fecha_hoy = '05-11-2009';

if ($fecha_desde == '')
{
	$fecha_desde = date('d-m-Y');
}

if ($fecha_hasta == '')
{
	$fecha_hasta = date('d-m-Y');
}

if ($censo_minsal == 'on') {
	$d_censo_minsal = 1;
}
else {
	$d_censo_minsal = 0;
}


$fecha_desde_proceso = cambiarFormatoFecha($fecha_desde);
$fecha_hasta_proceso = cambiarFormatoFecha($fecha_hasta);


if ($d_censo_minsal == 1)
{
	$sql = "SELECT * FROM sscc_minsal";
	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$i = 0;
	while($l_servicios = mysql_fetch_array($query))
	{
		if($l_servicios['tipo_1'] == $cod_servicio)
		{
			$desc_servicio = $l_servicios['d_tipo_1'];
		}
		$id_servicios[$i] = $l_servicios['tipo_1'];
		$servicios[$i] = $l_servicios['d_tipo_1'];
		$i++;
	}
}
else
{
	$sql = "SELECT * FROM sscc";
	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$i = 0;
	while($l_servicios = mysql_fetch_array($query)){
	
		if($l_servicios['id'] == $cod_servicio)
		{
			$desc_servicio = $l_servicios['servicio'];
		}	
	
		if ($l_servicios['id'] < 89 )
		{
			$id_servicios[$i] = $l_servicios['id'];
			$servicios[$i] = $l_servicios['servicio'];
			$i++;
		}
	}
}

?>




<form method="get" action="info_indicadores.php" name="frm_info_indicadores" id="frm_info_indicadores">

	<input name="tipo_categorizacion" value="<? echo $tipo_categorizacion; ?>" type="hidden"  />
	<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
	<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />


    <table width="900px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr class="noprint" align="right">
            <td style="border-bottom-style:solid; border-color:#999; border-width:2px;">

            <? $params = "?tipo_categorizacion=$tipo_categorizacion&cod_servicio=$cod_servicio&opcion_1=$opcion_1&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta"; ?>

            <div align="left" >
                <TABLE Cellpadding="0" Cellspacing="0" >
                <TR>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_categoriza.php<? echo $params; ?>" ONMOUSEOVER="change('1','m1')" ONMOUSEOUT= "change('2','m1')" name="m1"><IMG NAME="m1" SRC="img/p_menubutton1.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_censo.php<? echo $params; ?>"  ONMOUSEOVER="change('3','m2')" ONMOUSEOUT= "change('4','m2')" name="m2"><IMG NAME="m2" SRC="img/p_menubutton2.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_indicadores.php<? echo $params; ?>" ONMOUSEOVER="change('5','m3')" ONMOUSEOUT= "change('6','m3')" name="m3"><IMG NAME="m3" SRC="img/p_menubutton3.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" ONMOUSEOVER="change('7','m4')" ONMOUSEOUT= "change('8','m4')" name="m4"><IMG NAME="m4" SRC="img/p_menubutton4.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_pabellon.php<? echo $params; ?>" ONMOUSEOVER="change('9','m5')" ONMOUSEOUT= "change('10','m5')" name="m5"><IMG NAME="m5" SRC="img/p_menubutton5.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                </TR>
                </TABLE>
            </div>

			</td>
  		</tr>
		<tr class="noprint">
        	<td align="left" valign="bottom" height="25px" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
	            &nbsp;&nbsp;<a style="font-size:14px">INDICADORES.</a>
            </td>
        </tr>
        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr height="15px"><td></td><td></td><td></td>
                    </tr>
                    <tr>
                    	<td align="right" >Desde <input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
                        <td align="center">
                            Servicio Cl�nico
                            <select name="cod_servicio" onchange="document.info_indicadores.submit()">
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
						</td>
                        <td rowspan="2" align="center" > <input type="submit" value="    Generar Informe   " > </td>
                    </tr>
                    <tr>
                        <td align="right" >Hasta <input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
                    	<td align="center">
<?
                            if($d_censo_minsal == 1){
                                echo "<input type='checkbox' checked name='censo_minsal' onclick='document.frm_info_indicadores.submit()' />Censo Minsal</td>";
                            }
                            else {
                                echo "<input type='checkbox' name='censo_minsal'  onclick='document.frm_info_indicadores.submit()' />Censo Minsal</td>";
                            }
                            ?>
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
                        <td align="center" style="font-size:18px" >INDICADORES DE GESTION DE CAMAS ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
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


<tr>
<td>
<table align="center" border="1px" cellpadding="1px" cellspacing="0">

<tr align="center">
<td rowspan="2">Fecha &nbsp;&nbsp;&nbsp;Proceso&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td rowspan="2">Existencia Dia Anterior</td>


<td colspan="4">Ingresos</td>
<td colspan="5">Egresos</td>

<td rowspan="2">Ingresos y Egresos el mismo Dia</td>
<td colspan="2">Dias Cama</td>
<td colspan="2">Dias Estada</td>
<td colspan="4">Indicadores</td>
</tr>

<tr align="center">

<td>Urgencia</td>
<td>Admision</td>
<td>Internos</td>
<td><strong>TOTAL</strong></td>

<td>Alta</td>
<td>Internos</td>
<td>Fallecidos</td>
<td>Otro</td>
<td><strong>TOTAL</strong></td>

<td>Disp.</td>
<td>Ocup.</td>



<td>Total</td>
<td>Benef.</td>
<td>% Ocupaci�n</td>
<td>Prom. Dia Estada</td>
<td>Giro de Camas</td>
<td>Letalidad</td>
</tr>






<?

$nro_dias = (intval((strtotime($fecha_hasta_proceso)-strtotime($fecha_desde_proceso))/86400))+1; 

$total_ingresos = 0;
$total_ingresos_urgencia = 0;
$total_ingresos_admision = 0;
$total_ingresos_internos = 0;

$total_egresos = 0;
$total_egresos_alta = 0;
$total_egresos_internos = 0;
$total_egresos_otro = 0;
$total_egresos_fallecidos = 0;

$total_camas = 0;
$total_dia_hoy = 0;

$total_el_mismo_dia_hospitalizados = 0;

$total_dias_estada = 0;
$total_dias_estada_benef = 0;


$fecha_proceso = $fecha_desde_proceso;
while($fecha_proceso <= $fecha_hasta_proceso)
{




$nro_ingresos = 0;
$nro_ingresos_urgencia = 0;
$nro_ingresos_admision = 0;
$nro_ingresos_internos = 0;

$nro_egresos = 0;
$nro_egresos_alta = 0;
$nro_egresos_internos = 0;
$nro_egresos_otro = 0;
$nro_egresos_fallecidos = 0;

$nro_camas = 0;
$nro_dia_hoy = 0;
$nro_dia_ant = 0;

$nro_el_mismo_dia_hospitalizados = 0;

$nro_dias_estada = 0;
$nro_dias_estada_benef = 0;




	if ($d_censo_minsal == 1)
	{
		$sql = "SELECT * FROM camas where tipo_1 = '".$cod_servicio."' order by tipo_traslado";
	}
	else
	{
		$sql = "SELECT * FROM camas where cod_servicio = '".$cod_servicio."' order by tipo_traslado";
	}

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

while($censo = mysql_fetch_array($query))
{
	$nro_camas++;
	
	if ( $censo['estado'] == 2)
	{
		if ($censo['fecha_ingreso'] <= $fecha_proceso)
		{
			
			$nro_dia_ant++;
			$nro_dia_hoy++;
		}
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$nro_dia_ant--;
			$nro_ingresos++;
			
			switch ($censo['cod_procedencia']) {
				case '50':
					$nro_ingresos_urgencia++;
					$tipo_glosa = "Ingreso Desde Urgencia";
					break;
				case '90':
					$nro_ingresos_admision++;
					$tipo_glosa = "Ingreso Desde Admision";
					break;
				default:
					$nro_ingresos_internos++;
					$tipo_glosa = "Ingreso Interno";
					break;
			}
	
		}
	}
}

if ($d_censo_minsal == 1)
{
	$sql = "SELECT * FROM hospitalizaciones where tipo_1 = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 order by tipo_traslado";
}
else
{
	$sql = "SELECT * FROM hospitalizaciones where cod_servicio = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 order by tipo_traslado";
}
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());


while($censo = mysql_fetch_array($query))
{

	if ($censo['fecha_ingreso'] == $censo['fecha_egreso'])
	{
		$nro_el_mismo_dia_hospitalizados++;

		$nro_ingresos++;
		$nro_egresos++;

		$nro_dias_estada++;
		
		if ($censo['cod_prevision'] < 4) {  $nro_dias_estada_benef++; }

		switch ($censo['cod_procedencia']) {
			case '50':
				$nro_ingresos_urgencia++;
				$tipo_glosa = "Ingreso Desde Urgencia";
				break;
			case '90':
				$nro_ingresos_admision++;
				$tipo_glosa = "Ingreso Desde Admision";
				break;
			default:
				$nro_ingresos_internos++;
				$tipo_glosa = "Ingreso Interno";
				break;
		}


		if ($censo['cod_destino'] < 100)
		{
			$nro_egresos_internos++;
			$tipo_glosa = "Egreso Desde Servicio de este hospital el mismo dia";
			
		}
		else
		{

			switch ($censo['cod_destino']) {
				case '101':
					$nro_egresos_alta++;
					$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
					break;
				case '102':
					$nro_egresos_fallecidos++;
					$tipo_glosa = "Egreso Fallecidos el mismo dia";
					break;
				default:
					$nro_egresos_otro++;
					$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
					break;
			}
		}
		
	}
	else
	{
		
		if ($censo['fecha_ingreso'] <= $fecha_proceso)
		{

			$nro_dia_ant++;
			$nro_dia_hoy++;
		}
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$nro_dia_ant--;
		}
		
		if ($censo['fecha_egreso'] == $fecha_proceso)
		{
			
			
//			echo "desde ".$censo['fecha_ingreso']." hasta ".$fecha_proceso." ".intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400);
//			echo "</br>";
		
			$nro_dias_estada = $nro_dias_estada + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400));

			if ($censo['cod_prevision'] < 4) 
			{  $nro_dias_estada_benef = $nro_dias_estada_benef + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400)); }

			$nro_dia_hoy--;
		}
		
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$nro_ingresos++;

			switch ($censo['cod_procedencia']) {
				case '50':
					$nro_ingresos_urgencia++;
					$tipo_glosa = "Ingreso Desde Urgencia";
					break;
				case '90':
					$nro_ingresos_admision++;
					$tipo_glosa = "Ingreso Desde Admision";
					break;
				default:
					$nro_ingresos_internos++;
					$tipo_glosa = "Ingreso Interno";
					break;
			}

		}
		if ($censo['fecha_egreso'] == $fecha_proceso)
		{
			$nro_egresos++;
			
			if ($censo['cod_destino'] < 100)
			{
				$nro_egresos_internos++;
				$tipo_glosa = "Egreso Desde Servicio de este hospital";
				
			}
			else
			{
				switch ($censo['cod_destino']) {
					case '101':
						$nro_egresos_alta++;
						$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
						break;
					case '102':
						$nro_egresos_fallecidos++;
						$tipo_glosa = "Egreso Fallecidos el mismo dia";
						break;
					default:
						$nro_egresos_otro++;
						$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
						break;
				}
			}
			
			
		}
	}
}



			$porcent_ocupacion = redondear_dos_decimal(($nro_dia_hoy * 100) / $nro_camas);
			
			$prom_dia_estada = 0;
			$letalidad = 0;
			
			$egresos = $nro_egresos_alta + $nro_egresos_fallecidos + $nro_egresos_otro;
			
			if ($egresos > 0)
			{ $prom_dia_estada = redondear_dos_decimal(($nro_dias_estada) / ($egresos));
			  $letalidad = redondear_dos_decimal(($nro_egresos_fallecidos * 100) / ($egresos)); }
			
			$rotacion = redondear_dos_decimal($nro_egresos / ($nro_camas/$nro_dias));

			echo "<tr align='center'>";
			echo "<td>".$fecha_proceso."</td>";
			echo "<td>".$nro_dia_ant."</td>";
			echo "<td>".$nro_ingresos_urgencia."</td>";
			echo "<td>".$nro_ingresos_admision."</td>";
			echo "<td>".$nro_ingresos_internos."</td>";
			echo "<td><strong>".$nro_ingresos."</strong></td>";
			echo "<td>".$nro_egresos_alta."</td>";
			echo "<td>".$nro_egresos_internos."</td>";
			echo "<td>".$nro_egresos_fallecidos."</td>";
			echo "<td>".$nro_egresos_otro."</td>";
			echo "<td><strong>".$nro_egresos."</strong></td>";
			echo "<td>".$nro_el_mismo_dia_hospitalizados."</td>";
			echo "<td>".$nro_camas."</td>";
			echo "<td>".$nro_dia_hoy."</td>";
			echo "<td>".$nro_dias_estada."</td>";
			echo "<td>".$nro_dias_estada_benef."</td>";
			echo "<td>".$porcent_ocupacion."</td>";
			echo "<td>".$prom_dia_estada."</td>";
			echo "<td>".$rotacion."</td>";
			echo "<td>".$letalidad."</td>";
			
			
			
			echo "</tr>";




//	echo $fecha_proceso;
//	echo "</br>";

	$fecha_proceso= date("Y-m-d", strtotime("$fecha_proceso + 1 days"));
	
	
	
	
	
	$total_ingresos = $total_ingresos + $nro_ingresos;
	$total_ingresos_urgencia = $total_ingresos_urgencia + $nro_ingresos_urgencia;
	$total_ingresos_admision = $total_ingresos_admision + $nro_ingresos_admision;
	$total_ingresos_internos = $total_ingresos_internos + $nro_ingresos_internos;
	
	$total_egresos = $total_egresos + $nro_egresos;
	$total_egresos_alta = $total_egresos_alta + $nro_egresos_alta;
	$total_egresos_internos = $total_egresos_internos + $nro_egresos_internos;
	$total_egresos_otro = $total_egresos_otro + $nro_egresos_otro;
	$total_egresos_fallecidos = $total_egresos_fallecidos + $nro_egresos_fallecidos;
	
	$total_camas = $total_camas + $nro_camas;
	$total_dia_hoy = $total_dia_hoy + $nro_dia_hoy;
	
	$total_el_mismo_dia_hospitalizados = $total_el_mismo_dia_hospitalizados + $nro_el_mismo_dia_hospitalizados;
	
	$total_dias_estada = $total_dias_estada + $nro_dias_estada;
	$total_dias_estada_benef = $total_dias_estada_benef + $nro_dias_estada_benef;

$total_porcent_ocupacion = $total_porcent_ocupacion + $porcent_ocupacion;
$total_prom_dia_estada = $total_prom_dia_estada + $prom_dia_estada;
$total_rotacion = $total_rotacion + $rotacion;
$total_letalidad = $total_letalidad + $letalidad;
	
	
	
$tot2_porcent_ocupacion = redondear_dos_decimal(($total_dia_hoy * 100) / $total_camas);

$tot2_prom_dia_estada = 0;
$tot2_letalidad = 0;

$tot2_egresos = $total_egresos_alta + $total_egresos_fallecidos + $total_egresos_otro;

if ($tot2_egresos > 0)
{ $tot2_prom_dia_estada = redondear_dos_decimal(($total_dias_estada) / ($tot2_egresos));
  $tot2_letalidad = redondear_dos_decimal(($total_egresos_fallecidos * 100) / ($tot2_egresos)); }

$tot2_rotacion = redondear_dos_decimal($tot2_egresos / ($total_camas/$nro_dias));

	
	
	
}




echo "<tr align='center'>";
echo "<td>TOTALES</td>";
echo "<td>---</td>";
echo "<td>".$total_ingresos_urgencia."</td>";
echo "<td>".$total_ingresos_admision."</td>";
echo "<td>".$total_ingresos_internos."</td>";
echo "<td><strong>".$total_ingresos."</strong></td>";
echo "<td>".$total_egresos_alta."</td>";
echo "<td>".$total_egresos_internos."</td>";
echo "<td>".$total_egresos_fallecidos."</td>";
echo "<td>".$total_egresos_otro."</td>";
echo "<td><strong>".$total_egresos."</strong></td>";
echo "<td>".$total_el_mismo_dia_hospitalizados."</td>";
echo "<td>".$total_camas."</td>";
echo "<td>".$total_dia_hoy."</td>";
echo "<td>".$total_dias_estada."</td>";
echo "<td>".$total_dias_estada_benef."</td>";

echo "<td>".$total_porcent_ocupacion/$nro_dias."</td>";
echo "<td>".$total_prom_dia_estada/$nro_dias."</td>";
echo "<td>".$total_rotacion/$nro_dias."</td>";
echo "<td>".$total_letalidad/$nro_dias."</td>";



echo "</tr>";


echo "<tr align='center'>";
echo "<td>TOTALES</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";
echo "<td>---</td>";

echo "<td>".$tot2_porcent_ocupacion."</td>";
echo "<td>".$tot2_prom_dia_estada."</td>";
echo "<td>".$tot2_rotacion."</td>";
echo "<td>".$tot2_letalidad."</td>";



echo "</tr>";




?>

<table align="center">
<tr class="noprint">
<td>

<SCRIPT LANGUAGE="JavaScript">
if (window.print) {
document.write('<form><input type=button name=print value="imprimir" onClick="javascript:window.print()"></form>');
}
</script>

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


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>



