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
<title>Informe Censo Diario por Servicios.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"; >


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
$cod_servicio = $_REQUEST['cod_servicio'];
$censo_minsal = $_REQUEST['censo_minsal'];
$fecha_desde = $_REQUEST['fecha_desde'];
//$fecha_hoy = date('d-m-Y');
//$fecha_hoy = '05-11-2009';

if ($fecha_desde == '')
{
	$fecha_desde = date('d-m-Y');
}

$fecha_proceso = cambiarFormatoFecha($fecha_desde);


$cod_usuario = 1;
$usuario = 'Usuario de Prueba';
//$cod_servicio = 9;

if($cod_servicio == "todos"){
	$var1Tipo = " ";
	$var1SNTipo = " ";
	$var2Tipo = " ";
	$var2SNTipo = " ";
	
	$var1 = " ";
	$var1SN = " ";
	$var2 = " ";
	$var2SN= " ";
}else{
	$var1Tipo = " where tipo_1 = $cod_servicio ";
	$var1SNTipo = " where tipo1SN = $cod_servicio ";
	$var2Tipo = " tipo_1 = $cod_servicio AND ";
	$var2SNTipo = " que_tipo_1 = $cod_servicio AND ";
	
	$var1 = " where cod_servicio =  $cod_servicio ";
	$var1SN = " where desde_codServSN = $cod_servicio ";
	$var2 = " cod_servicio = $cod_servicio  AND ";
	$var2SN= " que_cod_servicio = $cod_servicio  AND ";
}
	
if ($censo_minsal == 1)
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


<form method="get" action="info_censo.php" name="frm_info_censo" id="frm_info_censo">


	<input name="tipo_categorizacion" value="<? echo $tipo_categorizacion; ?>" type="hidden"  />
	<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
	<input name="fecha_hasta" value="<? echo $fecha_hasta; ?>" type="hidden"  />



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
  		<tr class="noprint">
        	<td align="left" valign="bottom" height="25px" style="border-bottom-style:solid; border-color:#999; border-width:2px;">


	            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
						<td valign="bottom" height="25px">
				            &nbsp;&nbsp;<a style="font-size:14px">CENSO DIARIO.</a>
			            </td>
                        <td align="right">
                            Servicio Cl�nico
                            <select name="cod_servicio" onchange="document.frm_info_censo.submit()">
                                <?php
                                for($i=0; $i<count($servicios); $i++)
                                { ?>
                                    <option value=<?= $id_servicios[$i]; ?> <? if($id_servicios[$i]==$cod_servicio){ ?>  selected="selected" <? }?>><?= $servicios[$i]; ?></option>
                                    
                               <? } ?>
                               <option value="todos" <? if($cod_servicio=="todos"){ ?> selected="selected" <? } ?>>Todos los Servicios</option>
                            </select>
                        </td>
			        </tr>
                </table>

            </td>
        </tr>

        <tr class="noprint" align="left">
            <td colspan="2">
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td></tr>        
                    <tr>
                        <td align="left">
                        <input type='checkbox' <? if($censo_minsal == 1){ ?> checked="checked" <? } ?> name='censo_minsal' onclick='document.frm_info_censo.submit()' value="1" />Censo Minsal</td>
                            
                    	
                        <td align="center" >Fecha de Informe <input size="12" id="f_date4" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn4" value="....."  /></td>
                        <td align="center" > <input type="submit" value="      Generar Informe      " > </td>
                    </tr>
                    <tr><td height="5px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td colspan="2">
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >INFORME CENSO DIARIO <? echo $desc_servicio."  (Fecha ".$fecha_desde." )" ?></td>
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
	<table width="900px" id="Exportar_a_Excel" align="center" border="0" cellpadding="0" cellspacing="0">

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

echo "<tr align='center'>";
echo "<td colspan='2'>";
echo "<table border='1'  cellpadding='0' cellspacing='0'>";

echo "<tr>";
echo "<td width='400px' rowspan='2'><strong>NOMBRE Y APELLIDOS</strong></td>";
echo "<td width='400px' rowspan='2'><strong>RUN</strong></td>";
echo "<td width='80px' rowspan='2'>N� Observaci&oacute;n Cl&iacute;nica</td>";
echo "<td colspan='2'><strong>INGRESOS</strong></td>";
echo "<td colspan='3'><strong>EGRESOS</strong></td>";
echo "<td rowspan='2'>Ingresos Egresos en el mismo dia</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Desde Fuera o de Otro Hospital</td>";
echo "<td>De Servicios de Este Hospital</td>";
echo "<td>Alta al Hogar u Otro Hospital</td>";
echo "<td>Traslado a Otro Servicio de Este Hospital</td>";
echo "<td>Fallecidos</td>";
echo "</tr>";

echo "<tr>";
echo "<td>1</td>";
echo "<td>1</td>";
echo "<td>2</td>";
echo "<td>3</td>";
echo "<td>4</td>";
echo "<td>5</td>";
echo "<td>6</td>";
echo "<td>7</td>";
echo "<td>8</td>";
echo "</tr>";




if ($censo_minsal == 1)
{
	$sql = "SELECT * FROM camas ".$var1Tipo." order by tipo_traslado";
	$sql_SN = "SELECT * FROM listasn ".$var1SNTipo." order by tipoTrasladoSN";
}
else
{
	$sql = "SELECT * FROM camas ".$var1." order by tipo_traslado";
	$sql_SN = "SELECT * FROM listasn ".$var1SN." order by tipoTrasladoSN";
}

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die("ERROR AL SELECCIONAR CAMAS NORMALES ".mysql_error());
$query_SN = mysql_query($sql_SN) or die("ERROR AL SELECCIONAR CAMAS SN  ". mysql_error());

while($censo = mysql_fetch_array($query)) // CAMAS NORMALES DESDE CAMAS
{
	$total_camas++;	
	if ( $censo['estado'] == 2)
	{
		if ($censo['fecha_ingreso'] <= $fecha_proceso)
		{
			$total_inicial_hosp++;
			$total_final_hosp++;
		}
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$total_inicial_hosp--;
		}
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$total_ingresos++;
			
			echo "<tr>";
			echo "<td align='left'>".$censo['nom_paciente']."</td>";
			echo "<td align='left'>".$censo['rut_paciente']."-".ValidaDVRut($censo['rut_paciente'])."</td>";
			echo "<td align='right'>".$censo['ficha_paciente']."</td>";
	
			switch ($censo['tipo_traslado']) {
				case 1:
					$total_ingresos_fuera++;
					$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital";
					
					echo "<td align='left'>".$censo['procedencia']."</td>";
					echo "<td>&nbsp;</td>";
					
					break;
				case 2:
					$total_ingresos_internos++;
					$tipo_glosa = "Ingreso Desde Servicio de este hospital";
	
					echo "<td>&nbsp;</td>";
					echo "<td align='left'>".$censo['procedencia']."</td>";
	
					break;
				default:
					$total_ingresos_otro++;
					$tipo_glosa = "Ingreso Otro Tipo";
					break;
			}
	
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}
}

while($censo_SN = mysql_fetch_array($query_SN))//CAMAS SUPERNUMERARIAS DESDE LISTASSN
{
	$total_camas++;	
	if ( $censo_SN['estado'] == 2)
	{
		if ($censo_SN['fechaIngresoSN'] <= $fecha_proceso)
		{
			$total_inicial_hosp++;
			$total_final_hosp++;
		}
		if ($censo_SN['fechaIngresoSN'] == $fecha_proceso)
		{
			$total_inicial_hosp--;
		}
		if ($censo_SN['fechaIngresoSN'] == $fecha_proceso)
		{
			$total_ingresos++;
			
			echo "<tr>";
			echo "<td align='left'>(SN)".$censo_SN['nomPacienteSN']."</td>";
			echo "<td align='left'>".$censo_SN['rutPacienteSN']."-".ValidaDVRut($censo_SN['rutPacienteSN'])."</td>";
			echo "<td align='right'>".$censo_SN['fichaPacienteSN']."</td>";
	
			switch ($censo_SN['tipoTrasladoSN']) {
				case 1:
					$total_ingresos_fuera++;
					$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital";
					
					echo "<td align='left'>".$censo_SN['nomProcedenciaSN']."</td>";
					echo "<td>&nbsp;</td>";
					
					break;
				case 2:
					$total_ingresos_internos++;
					$tipo_glosa = "Ingreso Desde Servicio de este hospital";
	
					echo "<td>&nbsp;</td>";
					echo "<td align='left'>".$censo_SN['nomProcedenciaSN']."</td>";
	
					break;
				default:
					$total_ingresos_otro++;
					$tipo_glosa = "Ingreso Otro Tipo";
					break;
			}
	
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
	}
}

if ($censo_minsal == 1)
{
	$sql = "SELECT * FROM hospitalizaciones where ".$var2Tipo." fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 and ISNULL(camaSN) order by tipo_traslado";
	$sql_SN = "SELECT * FROM hospitalizaciones where ".$var2SNTipo." fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 and camaSN = 'S' order by tipo_traslado";
}
else
{
	$sql = "SELECT * FROM hospitalizaciones where ".$var2." fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 and ISNULL(camaSN) order by tipo_traslado";
	
	$sql_SN = "SELECT * FROM hospitalizaciones where ".$var2SN." fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' and tipo_traslado <> 3 and camaSN = 'S' order by tipo_traslado";
	
}

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());
$query_SN = mysql_query($sql_SN) or die(mysql_error());


while($censo = mysql_fetch_array($query)) // DESDE HOSPITALIZACIONES CAMAS NORMALES
{

	if ($censo['fecha_ingreso'] == $censo['fecha_egreso'])
	{
		$total_el_mismo_dia_hospitalizados++;
		echo "<tr>";
		echo "<td align='left'>".$censo['nom_paciente']."</td>";
		echo "<td align='left'>".$censo['rut_paciente']."-".ValidaDVRut($censo['rut_paciente'])."</td>";
		echo "<td align='right'>".$censo['ficha_paciente']."</td>";

		$total_ingresos++;
		$total_egresos++;

		if ($censo['cod_procedencia'] >= 50 or $censo['cod_procedencia'] == 0)
		{
			$total_ingresos_fuera++;
			$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital el mismo dia";

			echo "<td align='left'>".$censo['procedencia']."</td>";
			echo "<td>&nbsp;</td>";
		}
		else
		{
			$total_ingresos_internos++;
			$tipo_glosa = "Ingreso Desde Servicio de este hospital el mismo dia";

			echo "<td>&nbsp;</td>";
			echo "<td align='left'>".$censo['procedencia']."</td>";
		}


		if ($censo['tipo_traslado'] < 100)
		{
			$total_egresos_internos++;
			$tipo_glosa = "Egreso Desde Servicio de este hospital el mismo dia";
			
			echo "<td>&nbsp;</td>";
			echo "<td align='left'>".$censo['destino']."</td>";
			echo "<td>&nbsp;</td>";
		}
		else
		{


			switch ($censo['tipo_traslado']) {
				case 101:
					echo "<td>X</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					$total_egresos_fuera++;
					$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
					
					break;
				case 102:
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>X</td>";
					$total_egresos_fallecidos++;
					$tipo_glosa = "Egreso Fallecidos el mismo dia";
					break;
				case 103:
					echo "<td>X</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					$total_egresos_fuera++;
					$tipo_glosa = "Egreso Alta a Otro Servicio el mismo dia";
					break;
				default:
					$total_egresos_otro++;
					$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
					$total_egresos_otro++;
					break;
			}
		}
		
		echo "<td>X</td>";
		echo "</tr>";
	}
	else
	{
		
		if ($censo['fecha_ingreso'] <= $fecha_proceso)
		{
			$total_inicial_hosp++;
			$total_final_hosp++;
		}
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$total_inicial_hosp--;
		}
		
		if ($censo['fecha_egreso'] == $fecha_proceso)
		{
			$total_final_hosp--;
		}
		
		if ($censo['fecha_ingreso'] == $fecha_proceso)
		{
			$total_ingresos++;

			echo "<tr>";
			echo "<td align='left'>".$censo['nom_paciente']."</td>";
			echo "<td align='left'>".$censo['rut_paciente']."-".ValidaDVRut($censo['rut_paciente'])."</td>";
			echo "<td align='right'>".$censo['ficha_paciente']."</td>";

			if ($censo['cod_procedencia'] >= 50 or $censo['cod_procedencia'] == 0)
			{
				$total_ingresos_fuera++;
				$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital";

				echo "<td align='left'>".$censo['procedencia']."</td>";
				echo "<td>&nbsp;</td>";
			}
			else
			{
				$total_ingresos_internos++;
				$tipo_glosa = "Ingreso Desde Servicio de este hospital";

				echo "<td>&nbsp;</td>";
				echo "<td align='left'>".$censo['procedencia']."</td>";
			}

			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
		if ($censo['fecha_egreso'] == $fecha_proceso)
		{
			$total_egresos++;
			
			echo "<tr>";
			echo "<td align='left'>".$censo['nom_paciente']."</td>";
			echo "<td align='left'>".$censo['rut_paciente']."-".ValidaDVRut($censo['rut_paciente'])."</td>";
			echo "<td align='right'>".$censo['ficha_paciente']."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			
			
			if ($censo['tipo_traslado'] < 100)
			{
				$total_egresos_internos++;
				$tipo_glosa = "Egreso Desde Servicio de este hospital";
				
				echo "<td>&nbsp;</td>";
				echo "<td align='left'>".$censo['destino']."</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";

			}
			else
			{
		
				switch ($censo['tipo_traslado']) {
					case 101:
						$total_egresos_fuera++;
						$tipo_glosa = "Egreso Alta al Hogar u Otro Hospital";

						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					case 102:
						$total_egresos_fallecidos++;
						$tipo_glosa = "Egreso Fallecidos";

						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					case 103:
						$total_egresos_fuera++;
						$tipo_glosa = "Egreso Alta al Hogar u Otro Hospital";

						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					default:
						$total_egresos_otro++;
						$tipo_glosa = "Egreso Otro Tipo de Egreso";
						break;
				}
			}
			
			echo "</tr>";
			
		}
	}
}
//FIN CAMAS NORMALES

while($censo_SN = mysql_fetch_array($query_SN))// DESDE HOSPITALIZACIONES CAMAS SUPERNUMERARIAS
{

	if ($censo_SN['fecha_ingreso'] == $censo_SN['fecha_egreso'])
	{
		$total_el_mismo_dia_hospitalizados++;
		echo "<tr>";
		echo "<td align='left'>(SN)".$censo_SN['nom_paciente']."</td>";
		echo "<td align='left'>".$censo_SN['rut_paciente']."-".ValidaDVRut($censo_SN['rut_paciente'])."</td>";
		echo "<td align='right'>".$censo_SN['ficha_paciente']."</td>";

		$total_ingresos++;
		$total_egresos++;

		if ($censo_SN['cod_procedencia'] >= 50 or $censo_SN['cod_procedencia'] == 0)
		{
			$total_ingresos_fuera++;
			$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital el mismo dia";

			echo "<td align='left'>".$censo_SN['procedencia']."</td>";
			echo "<td>&nbsp;</td>";
		}
		else
		{
			$total_ingresos_internos++;
			$tipo_glosa = "Ingreso Desde Servicio de este hospital el mismo dia";

			echo "<td>&nbsp;</td>";
			echo "<td align='left'>".$censo_SN['procedencia']."</td>";
		}


		if ($censo_SN['tipo_traslado'] < 100)
		{
			$total_egresos_internos++;
			$tipo_glosa = "Egreso Desde Servicio de este hospital el mismo dia";
			
			echo "<td>&nbsp;</td>";
			echo "<td align='left'>".$censo_SN['destino']."</td>";
			echo "<td>&nbsp;</td>";
		}
		else
		{


			switch ($censo_SN['tipo_traslado']) {
				case 101:
					echo "<td>X</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					$total_egresos_fuera++;
					$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
					
					break;
				case 102:
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>X</td>";
					$total_egresos_fallecidos++;
					$tipo_glosa = "Egreso Fallecidos el mismo dia";
					break;
				case 103:
					echo "<td>X</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					$total_egresos_fuera++;
					$tipo_glosa = "Egreso Alta a Otro Servicio el mismo dia";
					break;
				default:
					$total_egresos_otro++;
					$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
					$total_egresos_otro++;
					break;
			}
		}
		
		echo "<td>X</td>";
		echo "</tr>";
	}
	else
	{
		
		if ($censo_SN['fecha_ingreso'] <= $fecha_proceso)
		{
			$total_inicial_hosp++;
			$total_final_hosp++;
		}
		if ($censo_SN['fecha_ingreso'] == $fecha_proceso)
		{
			$total_inicial_hosp--;
		}
		
		if ($censo_SN['fecha_egreso'] == $fecha_proceso)
		{
			$total_final_hosp--;
		}
		
		if ($censo_SN['fecha_ingreso'] == $fecha_proceso)
		{
			$total_ingresos++;

			echo "<tr>";
			echo "<td align='left'>(SN)".$censo_SN['nom_paciente']."</td>";
			echo "<td align='left'>".$censo_SN['rut_paciente']."-".ValidaDVRut($censo_SN['rut_paciente'])."</td>";
			echo "<td align='right'>".$censo_SN['ficha_paciente']."</td>";

			if ($censo_SN['cod_procedencia'] >= 50 or $censo_SN['cod_procedencia'] == 0)
			{
				$total_ingresos_fuera++;
				$tipo_glosa = "Ingreso Desde Fuera u Otro Hospital";

				echo "<td align='left'>".$censo_SN['procedencia']."</td>";
				echo "<td>&nbsp;</td>";
			}
			else
			{
				$total_ingresos_internos++;
				$tipo_glosa = "Ingreso Desde Servicio de este hospital";

				echo "<td>&nbsp;</td>";
				echo "<td align='left'>".$censo_SN['procedencia']."</td>";
			}

			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}
		if ($censo_SN['fecha_egreso'] == $fecha_proceso)
		{
			$total_egresos++;
			
			echo "<tr>";
			echo "<td align='left'>(SN)".$censo_SN['nom_paciente']."</td>";
			echo "<td align='left'>".$censo_SN['rut_paciente']."-".ValidaDVRut($censo_SN['rut_paciente'])."</td>";
			echo "<td align='right'>".$censo_SN['ficha_paciente']."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			
			
			if ($censo_SN['tipo_traslado'] < 100)
			{
				$total_egresos_internos++;
				$tipo_glosa = "Egreso Desde Servicio de este hospital";
				
				echo "<td>&nbsp;</td>";
				echo "<td align='left'>".$censo_SN['destino']."</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";

			}
			else
			{
		
				switch ($censo_SN['tipo_traslado']) {
					case 101:
						$total_egresos_fuera++;
						$tipo_glosa = "Egreso Alta al Hogar u Otro Hospital";

						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					case 102:
						$total_egresos_fallecidos++;
						$tipo_glosa = "Egreso Fallecidos";

						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					case 103:
						$total_egresos_fuera++;
						$tipo_glosa = "Egreso Alta al Hogar u Otro Hospital";

						echo "<td>X</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						
						break;
					default:
						$total_egresos_otro++;
						$tipo_glosa = "Egreso Otro Tipo de Egreso";
						break;
				}
			}
			
			echo "</tr>";
			
		}
	}
}
// FIN CAMAS SUPERNUMERARIAS
?>


<tr>
<td colspan="2" rowspan="2"><strong>TOTALES</strong></td>

<td><strong><? echo $total_ingresos_fuera ; ?></strong></td>
<td><strong><? echo $total_ingresos_internos; ?></strong></td>

<td><strong><? echo $total_egresos_fuera; ?></strong></td>
<td><strong><? echo $total_egresos_internos; ?></strong></td>
<td><strong><? echo $total_egresos_fallecidos; ?></strong></td>
<td rowspan="2"><strong><? echo $total_el_mismo_dia_hospitalizados; ?></strong></td>

</tr>

<tr>

<td colspan="2"><strong><? echo $total_ingresos; ?></strong></td>
<td colspan="3"><strong><? echo $total_egresos; ?></strong></td>

</tr>


<tr>
    <table border="1" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Pacientes Hospitalizados a las 00:00 Hrs. = <? echo $total_inicial_hosp; ?></td>
            <td>Pacientes Hospitalizados a las 23:59 Hrs. = <? echo $total_final_hosp; ?></td>
            <td>Total Camas. : <? echo $total_camas; ?></td>
		</tr>
    </table>
    <table border="1" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Otros Ingresos : <? echo $total_ingresos_otro; ?></td>
            <td>Otros Egresos : <? echo $total_egresos_otro; ?></td>
        </tr>
    </table>

</tr>

</table>


<table align="center">
    <tr class="noprint">
        <td>
        
			<SCRIPT LANGUAGE="JavaScript">
            if (window.print) {
            document.write('<form><input type=button name=print value="imprimir" onClick="javascript:window.print()"></form>');
            }
            </script>
    
        </td>
        <td width="30px"></td>
        <td>
            <form action="exp_excel/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                <p><img src="img/export_to_excel.gif" class="botonExcel" /></p>
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            </form>
        </td>
    
    </tr>
</table>



</body>
</html>

