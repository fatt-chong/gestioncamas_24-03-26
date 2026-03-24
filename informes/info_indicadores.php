<?php set_time_limit(1000); ?>
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

$tipo_categorizacion= $_GET['tipo_categorizacion'];
$opcion_1= $_GET['opcion_1'];
$cod_servicio= $_GET['cod_servicio'];
$fecha_desde= $_GET['fecha_desde'];
$cod_servicio= $_GET['cod_servicio'];
$fecha_hasta= $_GET['fecha_hasta'];
$censo_minsal= $_GET['censo_minsal'];

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
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
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
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
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
                            <select name="cod_servicio" onchange="document.frm_info_indicadores.submit()">
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
	<table id="Exportar_a_Excel" align="center" border="1px" cellpadding="0" cellspacing="0">

		<tr align="center">
			<td rowspan="2">Fecha &nbsp;&nbsp;&nbsp;Proceso&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td rowspan="2">Existencia Dia Anterior</td>

			<td colspan="4">Ingresos</td>
			<td colspan="6">Egresos</td>

			<td rowspan="2">Ingresos y Egresos el mismo Dia</td>
			<td colspan="7">Dias Cama</td>
			<td colspan="3">Dias Estada</td>
			<td colspan="7">Indicadores</td>
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
            <td>Menores de 65</td>
            <td><strong>TOTAL</strong></td>
            
            <td>Dota.</td>
            <td>Disp.</td>
            <td>Bloq.</td>
            <td>Bloq. SN.</td>
            <td>Ocup. NR</td>
            <td>Ocup. SN.</td>
            <td>Tot. Ocup.</td>
            <td>Menores de 65</td>
            <td>Total</td>
            <td>Benef.</td>
            <td>% Ocupaci�n</td>
            <td>Prom. Dia Estada</td>
            <td>Giro de Camas</td>
            <td>Letalidad</td>
            <td>Camas Con D.Unit</td>
            <td>Camas Sin D.Unit</td>
            <td>%</td>
            <td>menos de 2 d�as</td>
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
		$total_egresos_con_d_uni = 0;
		$total_egresos_sin_d_uni = 0;
		
		
		$total_disponible = 0;
		$total_bloqueadas = 0;
		$total_bloqueadas_SN = 0;
		
		$total_camas = 0;
		$total_dia_hoy = 0;
		
		$total_dia_hoy_NR = 0;
		$total_dia_hoy_SN = 0;
		
		$total_el_mismo_dia_hospitalizados = 0;
		
		$total_dias_estada = 0;
		$total_dias_estada_benef = 0;

		$nro_dia_ant = 0;
		$adultonomayor = 0;

		
		
		$fecha_proceso = $fecha_desde_proceso;
		while($fecha_proceso <= $fecha_hasta_proceso)
		{
//echo $fecha_proceso." <br/>";
			$nro_ingresos = 0;
			$nro_ingresos_urgencia = 0;
			$nro_ingresos_admision = 0;
			$nro_ingresos_internos = 0;
			
			$nro_egresos = 0;
			$nro_egresos_alta = 0;
			$nro_egresos_internos = 0;
			$nro_egresos_otro = 0;
			$nro_egresos_fallecidos = 0;
			$nro_egresos_con_d_uni = 0;
			$nro_egresos_sin_d_uni = 0;
			$nro_egresos_menos_2_dias = 0;
			
			$nro_disponible = 0;
			$nro_bloqueadas = 0;
			$nro_bloqueadas_SN = 0;
			
			$nro_camas = 0;
			$nro_dia_hoy = 0;
			$nro_dia_hoy_NR = 0;
			$nro_dia_hoy_SN = 0;
			
			$nro_el_mismo_dia_hospitalizados = 0;
			
			$nro_dias_estada = 0;
			$nro_dias_estada_benef = 0;
			$adultonomayor = 0;
			$adultonomayorestada = 0;
			

			
			$sql = "SELECT * FROM nro_camas where tipo_servicio = $d_censo_minsal and cod_servicio = $cod_servicio order by fecha";
			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql) or die(mysql_error());
			
			while($cuantas_camas = mysql_fetch_array($query))
			{
				if ($cuantas_camas['fecha'] <= $fecha_proceso)
				{
					$nro_camas = $cuantas_camas['cantidad'];
				}
			}
			if ($cod_servicio == 0)
			{
				$sql = "SELECT * FROM camas where cod_servicio < 50 order by tipo_traslado";
				$sql_SN = "SELECT * FROM listasn";
			}
			else
			{
				if ($d_censo_minsal == 1)
				{
					$sql = "SELECT * FROM camas where tipo_1 = '".$cod_servicio."' order by tipo_traslado";
					$sql_SN = "SELECT * FROM listasn WHERE listasn.tipo1SN = '".$cod_servicio."'";
				}
				else
				{
					$sql = "SELECT * FROM camas where cod_servicio = '".$cod_servicio."' order by tipo_traslado";
					$sql_SN = "SELECT * FROM listasn WHERE listasn.desde_codServSN = '".$cod_servicio."'";
				}
			}


			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql) or die(mysql_error());
			
			while($censo = mysql_fetch_array($query))
			{
				if ( $censo['estado'] == 2 or $censo['estado'] == 4)
				{
					if ($censo['fecha_ingreso'] <= $fecha_proceso)
					{
						$nro_dia_hoy_NR++;
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
				}
				
				if ( $censo['estado'] == 3)
				{
					if ($censo['fecha_ingreso'] <= $fecha_proceso)
					{
						$nro_bloqueadas++;
					}
				}

				if ( $censo['estado'] == 5)
				{
					if ($censo['fecha_ingreso'] <= $fecha_proceso)
					{
						$nro_bloqueadas_SN++;
					}
				}
			}
			
//			Aqui se carga listasn de SN


			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql_SN) or die(mysql_error());

			while($censo = mysql_fetch_array($query))
			{
				if ($censo['fechaIngresoSN'] <= $fecha_proceso)
				{
					$nro_dia_hoy_SN++;
				}
				if ($censo['fechaIngresoSN'] == $fecha_proceso)
				{
					$nro_ingresos++;
					
					switch ($censo['codProcedenciaSN']) {
						case '10322':
							$nro_ingresos_urgencia++;
							$tipo_glosa = "Ingreso Desde Urgencia";
							break;
						case '10325':
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
			
			
			
			
//			$corr_flag = 0;
			$corr_flag = 1;
			if ($fecha_proceso < '2012-07-01') { $corr_flag = 1; }
			
			if ($cod_servicio == 0)
			{
				$sql = "SELECT * FROM hospitalizaciones where camaSN IS NULL and cod_servicio < 50 and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
				$sql_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
				$sql_bl_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
			}
			else
			{
				if ($d_censo_minsal == 1)
				{
					$sql = "SELECT * FROM hospitalizaciones where camaSN IS NULL and tipo_1 = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
//					Aqui va Query de listaSN
					$sql_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and que_tipo_1 = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
//					Aqui va Query de Blowueos SN
					$sql_bl_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and tipo_1 = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
					
				}
				else
				{
					$sql = "SELECT * FROM hospitalizaciones where camaSN IS NULL and cod_servicio = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
//					Aqui va Query de listaSN
					$sql_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and que_cod_servicio = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";
//					Aqui va Query de Blowueos SN
					$sql_bl_SN = "SELECT * FROM hospitalizaciones where camaSN = 'S' and cod_servicio = '".$cod_servicio."' and fecha_ingreso <= '".$fecha_proceso."' and fecha_egreso >= '".$fecha_proceso."' order by tipo_traslado";

				}
			}



			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql) or die(mysql_error());

			while($censo = mysql_fetch_array($query))
			{
				
				if ( $censo['tipo_traslado'] == 3)
				{
					if ($censo['fecha_ingreso'] < $fecha_proceso)
					{
						$nro_bloqueadas++;
					}
				}
				else
				{
					if ($censo['censo_correlativo'] > 0 or $corr_flag == 1)
					{
						$nro_dia_hoy_NR++;

						if ($censo['fecha_ingreso'] == $censo['fecha_egreso'])
						{
							$nro_el_mismo_dia_hospitalizados++;
							$nro_dias_estada++;
							if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
						{
							$adultonomayorestada++;
						}
							
							if ($censo['cod_prevision'] < 4) {  $nro_dias_estada_benef++; }
					
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
						if ($censo['fecha_egreso'] == $fecha_proceso and $censo['tipo_1'] < 50)
						{
							//$nro_egresos++;
							//$nro_dia_hoy_NR--;
							$nro_dias_estada = $nro_dias_estada + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400));
							if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
						{
							$adultonomayorestada++;
						}

				
							if ($censo['cod_prevision'] < 4) 
							{  $nro_dias_estada_benef = $nro_dias_estada_benef + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400)); }
							
							if ($censo['cod_destino'] < 100)
							{
								$nro_egresos++;
								$nro_dia_hoy_NR--;
								$nro_egresos_internos++;
								$tipo_glosa = "Egreso Desde Servicio de este hospital el mismo dia";
								if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
								{
									$adultonomayor++;
								}
							}
							else
							{
								switch ($censo['cod_destino']) {
									case '101':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_alta++;
										$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
										if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
										{
											$adultonomayor++;
										}
										break;
									case '113':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_alta++;
										$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
										if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
										{
											$adultonomayor++;
										}
										break;
									case '114':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_alta++;
										$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
										if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
										{
											$adultonomayor++;
										}
										break;
									case '115':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_alta++;
										$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
										if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
										{
											$adultonomayor++;
										}
										break;
									case '102':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_fallecidos++;
										$tipo_glosa = "Egreso Fallecidos el mismo dia";
										if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
										{
											$adultonomayor++;
										}
										break;
									case '110':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_otro++;
										$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
										break;
									case '111':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_otro++;
										$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
										break;
									case '112':
									$nro_egresos++;
									$nro_dia_hoy_NR--;
										$nro_egresos_otro++;
										$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
										break;
								}
							}



							$fecha_paso = $censo['fecha_egreso'];
							$egreso_menos_2= date("Y-m-d", strtotime("$fecha_paso - 2 days"));
			
						
							if ($censo['fecha_ingreso'] <= $egreso_menos_2)
							{
								if ($censo['tipo_1'] == 1 or $censo['tipo_1'] == 2 or $censo['tipo_1'] == 7 or $censo['tipo_1'] == 10 or $censo['tipo_1'] == 11 or $censo['tipo_1'] == 12 or $censo['tipo_1'] == 4 or $censo['tipo_1'] == 13)
								{
									$nro_egresos_con_d_uni++;
								}
								else
								{
									$nro_egresos_sin_d_uni++;
								}
							}
							else
							{
								$nro_egresos_menos_2_dias++;
							}
			//				echo "<br>";
		


						}
					}
				}
			}

//  Aqui va codigo SN

			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql_SN) or die(mysql_error());

			while($censo = mysql_fetch_array($query))
			{
				if ($censo['censo_correlativo'] > 0 or $corr_flag == 1)
				{
					$nro_dia_hoy_SN++;

					if ($censo['fecha_ingreso'] == $censo['fecha_egreso'])
					{
						$nro_el_mismo_dia_hospitalizados++;
						$nro_dias_estada++;
						if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
						{
							$adultonomayorestada++;
						}
						
						
						if ($censo['cod_prevision'] < 4) {  $nro_dias_estada_benef++; }
				
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
					if ($censo['fecha_egreso'] == $fecha_proceso and $censo['tipo_1'] < 50)
					{
						//$nro_egresos++;
						//$nro_dia_hoy_SN--;
						$nro_dias_estada = $nro_dias_estada + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400));
						if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
						{
							$adultonomayorestada++;
						}

			
						if ($censo['cod_prevision'] < 4) 
						{  $nro_dias_estada_benef = $nro_dias_estada_benef + (intval((strtotime($fecha_proceso)-strtotime($censo['fecha_ingreso']))/86400)); }
						
						if ($censo['cod_destino'] < 100)
						{
							$nro_egresos++;
							$nro_dia_hoy_SN--;
							$nro_egresos_internos++;
							$tipo_glosa = "Egreso Desde Servicio de este hospital el mismo dia";
							if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
							{
								$adultonomayor++;
							}
						}
						else
						{
							switch ($censo['cod_destino']) {
								case '101':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_alta++;
									$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
									if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
									{
										$adultonomayor++;
									}
									break;
								case '113':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_alta++;
									$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
									if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
									{
										$adultonomayor++;
									}
									break;
								case '114':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_alta++;
									$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
									if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
									{
										$adultonomayor++;
									}
									break;
								case '115':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_alta++;
									$tipo_glosa = "Egreso Alta al Hogar el mismo dia";
									if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
									{
										$adultonomayor++;
									}
									break;
								case '102':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_fallecidos++;
									$tipo_glosa = "Egreso Fallecidos el mismo dia";
									if($censo['edad_paciente'] < 65 and $censo['edad_paciente'] != NULL)
									{
										$adultonomayor++;
									}
									break;
								case '110':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_otro++;
									$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
									break;
								case '111':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_otro++;
									$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
									break;
								case '112':
								$nro_egresos++;
								$nro_dia_hoy_SN--;
									$nro_egresos_otro++;
									$tipo_glosa = "Egreso Otro Tipo de Egreso el mismo dia";
									break;
							}
						}



						$fecha_paso = $censo['fecha_egreso'];
						$egreso_menos_2= date("Y-m-d", strtotime("$fecha_paso - 2 days"));
		
					
						if ($censo['fecha_ingreso'] <= $egreso_menos_2)
						{
							if ($censo['tipo_1'] == 1 or $censo['tipo_1'] == 2 or $censo['tipo_1'] == 7 or $censo['tipo_1'] == 10 or $censo['tipo_1'] == 11 or $censo['tipo_1'] == 12 or $censo['tipo_1'] == 4 or $censo['tipo_1'] == 13)
							{
								$nro_egresos_con_d_uni++;
							}
							else
							{
								$nro_egresos_sin_d_uni++;
							}
						}
						else
						{
							$nro_egresos_menos_2_dias++;
						}
		//				echo "<br>";
	


					}
				}

			}

// 			Bloqueadas SN
			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql_bl_SN) or die(mysql_error());

			while($censo = mysql_fetch_array($query))
			{

				if ($censo['censo_correlativo'] > 0 or $corr_flag == 1)
				{
					$nro_bloqueadas_SN++;
					if ($censo['fecha_egreso'] == $fecha_proceso and $censo['tipo_1'] < 50)
					{ $nro_bloqueadas_SN--; }
				}
			}



			$nro_disponible = $nro_camas - $nro_bloqueadas - $nro_bloqueadas_SN + $nro_dia_hoy_SN;
			$nro_dia_hoy =  $nro_dia_hoy_NR + $nro_dia_hoy_SN;

if ($nro_disponible < $nro_dia_hoy)
{
	
	 $diferencia =  $nro_dia_hoy - $nro_disponible;
	 
	 $nro_bloqueadas = $nro_bloqueadas - $diferencia;
	 $nro_disponible = $nro_disponible + $diferencia;
	 
}



			
			$prom_dia_estada = 0;
			$letalidad = 0;
			$porc_camas_d_unit = 0;
			$porcent_ocupacion = 0;
			$rotacion = 0;

			if ($nro_disponible > 0)   { $porcent_ocupacion = ($nro_dia_hoy * 100) / $nro_disponible; }
			if ($nro_egresos > 0)   { $prom_dia_estada = ($nro_dias_estada) / ($nro_egresos); }
			if ($nro_egresos > 0)   { $letalidad = ($nro_egresos_fallecidos * 100) / ($nro_egresos); }
			if (($nro_egresos_con_d_uni+$nro_egresos_sin_d_uni) > 0)
				{ $porc_camas_d_unit = ($nro_egresos_con_d_uni/($nro_egresos_con_d_uni+$nro_egresos_sin_d_uni))*100; }

			if ($nro_disponible > 0 and $nro_dias > 0)   { $rotacion = $nro_egresos / ($nro_disponible/$nro_dias); }


			echo "<tr align='right'>";
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
				echo "<td>".$adultonomayor."</td>";
				echo "<td><strong>".$nro_egresos."</strong></td>";
				echo "<td>".$nro_el_mismo_dia_hospitalizados."</td>";
				echo "<td>".$nro_camas."</td>";
				
				echo "<td>".$nro_disponible."</td>";
				echo "<td>".$nro_bloqueadas."</td>";
				echo "<td>".$nro_bloqueadas_SN."</td>";
				
				
				echo "<td>".$nro_dia_hoy_NR."</td>";
				echo "<td>".$nro_dia_hoy_SN."</td>";
				echo "<td>".$nro_dia_hoy."</td>";
				echo "<td>".$adultonomayorestada."</td>";
				echo "<td>".$nro_dias_estada."</td>";
				echo "<td>".$nro_dias_estada_benef."</td>";
				echo "<td>".redondear_dos_decimal($porcent_ocupacion)."</td>";
				echo "<td>".redondear_dos_decimal($prom_dia_estada)."</td>";
				echo "<td>".redondear_dos_decimal($rotacion)."</td>";
				echo "<td>".redondear_dos_decimal($letalidad)."</td>";
				echo "<td>".$nro_egresos_con_d_uni."</td>";
				echo "<td>".$nro_egresos_sin_d_uni."</td>";
				echo "<td>".redondear_dos_decimal($porc_camas_d_unit)."</td>";
				echo "<td>".$nro_egresos_menos_2_dias."</td>";
				
				
				;
				
			echo "</tr>";

//	echo $fecha_proceso;
//	echo "</br>";

$nro_dia_ant = $nro_dia_hoy;

			$fecha_proceso= date("Y-m-d", strtotime("$fecha_proceso + 1 days"));
		
			$TOTAL_adultonomayor = $TOTAL_adultonomayor + $adultonomayor;
			$TOTAL_adultonomayorestada = $TOTAL_adultonomayorestada + $adultonomayorestada;

		
			$total_ingresos = $total_ingresos + $nro_ingresos;
			$total_ingresos_urgencia = $total_ingresos_urgencia + $nro_ingresos_urgencia;
			$total_ingresos_admision = $total_ingresos_admision + $nro_ingresos_admision;
			$total_ingresos_internos = $total_ingresos_internos + $nro_ingresos_internos;
			
			$total_egresos = $total_egresos + $nro_egresos;
			$total_egresos_alta = $total_egresos_alta + $nro_egresos_alta;
			$total_egresos_internos = $total_egresos_internos + $nro_egresos_internos;
			$total_egresos_otro = $total_egresos_otro + $nro_egresos_otro;
			$total_egresos_fallecidos = $total_egresos_fallecidos + $nro_egresos_fallecidos;
			$total_egresos_con_d_uni = $total_egresos_con_d_uni + $nro_egresos_con_d_uni;
			$total_egresos_sin_d_uni = $total_egresos_sin_d_uni + $nro_egresos_sin_d_uni;
			 
			$total_disponible = $total_disponible + $nro_disponible;
			$total_bloqueadas = $total_bloqueadas + $nro_bloqueadas;
			$total_bloqueadas_SN = $total_bloqueadas_SN + $nro_bloqueadas_SN;
			
			$total_camas = $total_camas + $nro_camas;
			$total_dia_hoy_NR = $total_dia_hoy_NR + $nro_dia_hoy_NR;
			$total_dia_hoy_SN = $total_dia_hoy_SN + $nro_dia_hoy_SN;

			$total_dia_hoy = $total_dia_hoy_NR + $total_dia_hoy_SN;

			$total_el_mismo_dia_hospitalizados = $total_el_mismo_dia_hospitalizados + $nro_el_mismo_dia_hospitalizados;
			
			$total_dias_estada = $total_dias_estada + $nro_dias_estada;
			$total_dias_estada_benef = $total_dias_estada_benef + $nro_dias_estada_benef;
	
			$total_porcent_ocupacion = $total_porcent_ocupacion + $porcent_ocupacion;
			$total_prom_dia_estada = $total_prom_dia_estada + $prom_dia_estada;
			$total_rotacion = $total_rotacion + $rotacion;
			$total_letalidad = $total_letalidad + $letalidad;
			
			$tot2_porcent_ocupacion = 0;
			$tot2_prom_dia_estada = 0;
			$tot2_letalidad = 0;
			$total_porc_camas_d_unit = 0;
			$tot2_rotacion = 0;
			
			//$egresos = $total_egresos_alta + $total_egresos_fallecidos + $total_egresos_otro;
			if ($total_disponible > 0) { $tot2_porcent_ocupacion = redondear_dos_decimal(($total_dia_hoy * 100) / $total_disponible); }
			if ($total_egresos > 0) { $tot2_prom_dia_estada = redondear_dos_decimal(($total_dias_estada) / ($total_egresos)); }
			if ($total_egresos > 0) { $tot2_letalidad = redondear_dos_decimal(($total_egresos_fallecidos * 100) / ($total_egresos)); }
			if (($total_egresos_con_d_uni+$total_egresos_sin_d_uni) > 0)
			{ $total_porc_camas_d_unit = ($total_egresos_con_d_uni/($total_egresos_con_d_uni+$total_egresos_sin_d_uni))*100; }

			if ($total_disponible > 0 and $nro_dias > 0 ) { $tot2_rotacion = redondear_dos_decimal($total_egresos / ($total_disponible/$nro_dias)); }


		}

		echo "<tr align='right' style='font-size:14px'>";
			echo "<td align'center'><strong>TOTALES</strong></td>";
			echo "<td align'center'><strong>---</strong></td>";
			echo "<td><strong>".$total_ingresos_urgencia."</strong></td>";
			echo "<td><strong>".$total_ingresos_admision."</strong></td>";
			echo "<td><strong>".$total_ingresos_internos."</strong></td>";
			echo "<td><strong>".$total_ingresos."</strong></td>";
			echo "<td><strong>".$total_egresos_alta."</strong></td>";
			echo "<td><strong>".$total_egresos_internos."</strong></td>";
			echo "<td><strong>".$total_egresos_fallecidos."</strong></td>";
			echo "<td><strong>".$total_egresos_otro."</strong></td>";
			echo "<td>".$TOTAL_adultonomayor."</td>";
			echo "<td><strong>".$total_egresos."</strong></td>";
			echo "<td><strong>".$total_el_mismo_dia_hospitalizados."</strong></td>";
			echo "<td><strong>".$total_camas."</strong></td>";
			
			echo "<td><strong>".$total_disponible."</strong></td>";
			echo "<td><strong>".$total_bloqueadas."</strong></td>";
			echo "<td><strong>".$total_bloqueadas_SN."</strong></td>";

			echo "<td><strong>".$total_dia_hoy_NR."</strong></td>";
			echo "<td><strong>".$total_dia_hoy_SN."</strong></td>";
			echo "<td><strong>".$total_dia_hoy."</strong></td>";
			echo "<td>".$TOTAL_adultonomayorestada."</td>";
			echo "<td><strong>".$total_dias_estada."</strong></td>";
			echo "<td><strong>".$total_dias_estada_benef."</strong></td>";


			echo "<td><strong>".$tot2_porcent_ocupacion."</strong></td>";
			echo "<td><strong>".$tot2_prom_dia_estada."<strong></td>";
			echo "<td><strong>".$tot2_rotacion."</strong></td>";
			echo "<td><strong>".$tot2_letalidad."</strong></td>";
			echo "<td><strong>".$total_egresos_con_d_uni."</strong></td>";
			echo "<td><strong>".$total_egresos_sin_d_uni."</strong></td>";
			echo "<td><strong>".redondear_dos_decimal($total_porc_camas_d_unit)."</strong></td>";
			
		echo "</tr>";

?>

	</table>

	</td>
</tr>

<tr>

	<td>

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