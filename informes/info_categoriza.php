<?php
$tipo_categorizacion = $_GET['tipo_categorizacion'];
$opcion_1 = $_GET['opcion_1'];
$opcion_2 = $_GET['opcion_2'];
$fecha_hasta = $_GET['fecha_hasta'];
$fecha_desde = $_GET['fecha_desde'];
$cod_servicio = $_GET['cod_servicio'];
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

if ($opcion_2 == 'on') {
	$d_opcion_2 = 1;
}
else {
	$d_opcion2 = 0;
}

$fecha_desde_proceso = cambiarFormatoFecha($fecha_desde);
$fecha_hasta_proceso = cambiarFormatoFecha($fecha_hasta);

?>

<table width="900px" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr class="noprint" align="right">
        <td style="border-bottom-style:solid; border-color:#999; border-width:2px;">

            <? $params = "?tipo_categorizacion=$tipo_categorizacion&cod_servicio=$cod_servicio&opcion_1=$opcion_1&opcion_2=$opcion_2&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta"; ?>

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

    <form method="get" action="info_categoriza.php" name="frm_info_categoriza" id="frm_info_categoriza">
    
    <tr class="noprint">
        <td align="left" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="bottom" height="25px">
                        &nbsp;&nbsp;<a style="font-size:14px">INFORMES DE CATEGORIZACION.</a>
                    </td>
                    <td align="right">
                        TIPO DE INFORME 
                        <select name="tipo_categorizacion" onchange="document.frm_info_categoriza.submit()">
                            <option value=1 <? if ($tipo_categorizacion == 1) { echo "selected"; } ?> >Detalle de Categorizacion </option>
                            <option value=2 <? if ($tipo_categorizacion == 2) { echo "selected"; } ?> >Resumen de Categorizacion </option>
                            <option value=3 <? if ($tipo_categorizacion == 3) { echo "selected"; } ?> >Cintas de Glicemia </option>
                            <option value=4 <? if ($tipo_categorizacion == 4) { echo "selected"; } ?> >Sonda Marcapaso transitoria </option>
                            <option value=5 <? if ($tipo_categorizacion == 5) { echo "selected"; } ?> >Tipos de Visitas </option>
                            <option value=6 <? if ($tipo_categorizacion == 6) { echo "selected"; } ?> >Score Riesgo Social </option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

	

	<?
    switch ($tipo_categorizacion) {
    case 1:
	
	
	
	
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
		
			if ($l_servicios['id'] < 50 OR $l_servicios['id'] == 98 )
			{
				$id_servicios[$i] = $l_servicios['id'];
				$servicios[$i] = $l_servicios['servicio'];
				$i++;
			}
		}
	
		?>

		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="opcion_2" value="<? echo $opcion_2; ?>" type="hidden"  />
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
                        <td align="center" style="font-size:18px" >CATEGORIZACIONES SERVICIO CLINICO <? echo $desc_servicio."  (Fecha ".$fecha_desde." )" ?></td>
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

		$sql = "SELECT * FROM categorizacion where cod_servicio = '".$cod_servicio."' and fecha = '".$fecha_desde_proceso."' AND 
			(categorizacion.ev_1 <>  '0' OR categorizacion.ev_2 <>  '0' OR categorizacion.ev_3 <>  '0' OR categorizacion.ev_4 <>  '0' OR categorizacion.ev_5 <>  '0' OR categorizacion.ev_6 <>  '0' OR categorizacion.ev_7 <>  '0' OR categorizacion.ev_8 <>  '0' OR categorizacion.ev_9 <>  '0' OR categorizacion.ev_10 <>  '0' OR categorizacion.ev_11 <>  '0' OR categorizacion.ev_12 <>  '0' OR categorizacion.ev_13 <>  '0' OR categorizacion.ev_14 <>  '0')
			order by sala, cama";
		
		mysql_connect ('10.6.21.29','usuario','hospital');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$total_riesgo = 0;
		$total_dependencia = 0;
		
		$sala = '0';
		
		$total_a1 = 0;
		$total_a2 = 0;
		$total_a3 = 0;
		$total_b1 = 0;
		$total_b1 = 0;
		$total_b2 = 0;
		$total_b3 = 0;
		$total_c1 = 0;
		$total_c2 = 0;
		$total_c3 = 0;
		$total_d1 = 0;
		$total_d2 = 0;
		$total_d3 = 0;
		
		$total_uci = 0;
		
		$total_indi = 0;
		$total_lact = 0;
		$total_mini = 0;
		$total_inte = 0;
		
		$total_incu = 0;
		$total_cuna = 0;
		
		$total_gine = 0;
		$total_obst = 0;
		
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
		
		$total_s_uci = 0;
		
		$total_s_indi = 0;
		$total_s_lact = 0;
		$total_s_mini = 0;
		$total_s_inte = 0;
		
		$total_s_incu = 0;
		$total_s_cuna = 0;
		
		$total_s_gine = 0;
		$total_s_obst = 0;
		
		$flag = 0;
		
		
		//echo "<table align='center'>";


		while($categoriza = mysql_fetch_array($query))
		{
			$flag = 1;
			if ($sala <> $categoriza['sala']){
		
				if ($sala <>'0'){
					if ($cod_servicio == 10 or $cod_servicio == 11)
					{
						echo"<tr style=font-size:15px;'>";
						echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
						echo"<td colspan='9' align='center'>GINECOLOGICO = ".$total_s_gine."</td>";
						echo"<td colspan='10' align='center'>OBSTETRICO = ".$total_s_obst."</td>";
						echo"</tr>";
					}
					if ($cod_servicio == 7)
					{
						echo"<tr style=font-size:15px;'>";
						echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
						echo"<td colspan='3' align='center'>UCI=".$total_s_uci."</td>";
						echo"<td colspan='5' align='center'>INDIFERENCIADO=".$total_s_indi."</td>";
						echo"<td colspan='4' align='center'>LACTANTE=".$total_s_lact."</td>";
						echo"<td colspan='3' align='center'>MINIMO=".$total_s_mini."</td>";
						echo"<td colspan='4' align='center'>INTERMEDIO=".$total_s_inte."</td>";
						echo"</tr>";
					}
					if ($cod_servicio == 6)
					{
						echo"<tr style=font-size:15px;'>";
						echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
						echo"<td colspan='5' align='center'>UCI=".$total_s_uci."</td>";
						echo"<td colspan='8' align='center'>INTERMEDIO (INCUBADORA)=".$total_s_incu."</td>";
						echo"<td colspan='6' align='center'>CUNA BASICA=".$total_s_cuna."</td>";
						echo"</tr>";
					}
					echo"<tr style=font-size:15px;'>";
					echo"<td colspan='2' align='center'>Resumen Categorizacion de Sala</td>";
					echo"<td colspan='5' align='center'>A1=".$total_s_a1." - A2=".$total_s_a2." - A3=".$total_s_a3."</td>";
					echo"<td colspan='5' align='center'>B1=".$total_s_b1." - B2=".$total_s_b2." - B3=".$total_s_b3."</td>";
					echo"<td colspan='5' align='center'>C1=".$total_s_c1." - C2=".$total_s_c2." - C3=".$total_s_c3."</td>";
					echo"<td colspan='4' align='center'>D1=".$total_s_d1." - D2=".$total_s_d2." - D3=".$total_s_d3."</td>";
					echo"</tr>";
					echo "</table>";
					echo"</fieldset>";
					echo"</td>";
					echo"</tr>";
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
		
					$total_s_uci = 0;
					
					$total_s_indi = 0;
					$total_s_lact = 0;
					$total_s_mini = 0;
					$total_s_inte = 0;
					
					$total_s_incu = 0;
					$total_s_cuna = 0;
		
					$total_s_gine = 0;
					$total_s_obst = 0;
			
				}
				echo "<tr>";
				echo "<td>";
				echo "<fieldset><legend style='font-size:14px' >SALA ".$categoriza['sala']."</legend>";

				echo "<table width='100%' align='left' border='1px' cellspacing='0'>";
				echo "<tr style='vertical-align:bottom'>";
				echo "<td>Cama</td>";
				echo "<td width='250px' >Nombre Paciente</td>";
				echo "<td><img src='img/img_ev_1.gif' /></td>";
				echo "<td><img src='img/img_ev_2.gif' /></td>";
				echo "<td><img src='img/img_ev_3.gif' /></td>";
				echo "<td><img src='img/img_ev_4.gif' /></td>";
				echo "<td><img src='img/img_ev_5.gif' /></td>";
				echo "<td><img src='img/img_ev_6.gif' /></td>";
				echo "<td><img src='img/img_ev_7.gif' /></td>";
				echo "<td><img src='img/img_ev_8.gif' /></td>";
				echo "<td><img src='img/img_ev_totalpuntos.gif' /></td>";
				echo "<td><img src='img/img_ev_categorizacionriesgo.gif' /></td>";
				echo "<td><img src='img/img_ev_9.gif' /></td>";
				echo "<td><img src='img/img_ev_10.gif' /></td>";
				echo "<td><img src='img/img_ev_11.gif' /></td>";
				echo "<td><img src='img/img_ev_12.gif' /></td>";
				echo "<td><img src='img/img_ev_13.gif' /></td>";
				echo "<td><img src='img/img_ev_14.gif' /></td>";
				echo "<td><img src='img/img_ev_totalpuntos.gif' /></td>";
		
				echo "<td><img src='img/img_ev_categorizaciondepend.gif' /></td>";
				echo "<td><img src='img/img_ev_categorizacionfinal' /></td>";
				echo "</tr>";		
				
			}
			$sala = $categoriza['sala'];
		
			$ev_1 = $categoriza['ev_1'];
			$ev_2 = $categoriza['ev_2'];
			$ev_3 = $categoriza['ev_3'];
			$ev_4 = $categoriza['ev_4'];
			$ev_5 = $categoriza['ev_5'];
			$ev_6 = $categoriza['ev_6'];
			$ev_7 = $categoriza['ev_7'];
			$ev_8 = $categoriza['ev_8'];
			$ev_9 = $categoriza['ev_9'];
			$ev_10 = $categoriza['ev_10'];
			$ev_11 = $categoriza['ev_11'];
			$ev_12 = $categoriza['ev_12'];
			$ev_13 = $categoriza['ev_13'];
			$ev_14 = $categoriza['ev_14'];
			$observacion = $categoriza['observacion'];
			$total_riesgo = $ev_1 + $ev_2 + $ev_3 + $ev_4 + $ev_5 + $ev_6 + $ev_7 + $ev_8;
			$total_dependencia = $ev_9 + $ev_10 + $ev_11 + $ev_12 + $ev_13 + $ev_14;
			if ($total_riesgo < 6) { $categorizacion_riesgo = 'D'; }
			
			if ($total_riesgo > 5 and $total_riesgo < 12) { $categorizacion_riesgo = 'C'; } 
			
			if ($total_riesgo > 11 and $total_riesgo < 19) { $categorizacion_riesgo = 'B'; }
			
			if ($total_riesgo > 18) { $categorizacion_riesgo = 'A'; }
			
			
			if ($total_dependencia < 7) { $categorizacion_dependencia = '3'; }
			
			if ($total_dependencia > 6 and $total_dependencia < 13) { $categorizacion_dependencia = '2'; } 
			
			if ($total_dependencia > 12) { $categorizacion_dependencia = '1'; }
			
			$categorizacion_final = $categorizacion_riesgo.''. $categorizacion_dependencia;
		
		
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
		
			$nombre_paciente = $categoriza['nom_paciente'];
		
			if ($cod_servicio == 7)
			{
				switch ($categoriza['tipo_2']) {
					case 1:
						$total_mini++;
						$total_s_mini++;
						$nombre_paciente = '(MIN)-'.$nombre_paciente;
						break;
					case 2:
						$total_inte++;
						$total_s_inte++;
						$nombre_paciente = '(INT)-'.$nombre_paciente;
						break;
				}
			}
		
			switch ($categoriza['tipo_1']) {
				case 4:
					$total_uci++;
					$total_s_uci++;
					$nombre_paciente = '(UCI)-'.$nombre_paciente;
					break;
				case 5:
					$total_indi++;
					$total_s_indi++;
					$nombre_paciente = '(IND)-'.$nombre_paciente;
					break;
				case 6:
					$total_lact++;
					$total_s_lact++;
					$nombre_paciente = '(LAC)-'.$nombre_paciente;
					break;
				case 8:
					$total_gine++;
					$total_s_gine++;
					$nombre_paciente = '(GINE)-'.$nombre_paciente;
					break;
				case 9:
					$total_obst++;
					$total_s_obst++;
					$nombre_paciente = '(OBST)-'.$nombre_paciente;
					break;
				case 13:
					$total_uci++;
					$total_s_uci++;
					$nombre_paciente = '(UCI)-'.$nombre_paciente;
					break;
				case 14:
					$total_incu++;
					$total_s_incu++;
					$nombre_paciente = '(INCU)-'.$nombre_paciente;
					break;
				case 15:
					$total_cuna++;
					$total_s_cuna++;
					$nombre_paciente = '(CUNA)-'.$nombre_paciente;
					break;
			}
			
		$totaltotal = $total_a1+$total_a2+$total_a3+$total_b1+$total_b2+$total_b3+$total_c1+$total_c2+$total_c3+$total_d1+$total_d2+$total_d3;
		
			echo "<tr>";		
			echo "<td align='center'>".$categoriza['cama']."</td>";
			
		
			echo "<td>".$nombre_paciente."</td>";
		
			
			echo "<td align='center'>".$ev_1."</td>";
			echo "<td align='center'>".$ev_2."</td>";
			echo "<td align='center'>".$ev_3."</td>";
			echo "<td align='center'>".$ev_4."</td>";
			echo "<td align='center'>".$ev_5."</td>";
			echo "<td align='center'>".$ev_6."</td>";
			echo "<td align='center'>".$ev_7."</td>";
			echo "<td align='center'>".$ev_8."</td>";
			echo "<td align='center'><strong>".$total_riesgo."</strong></td>";
			echo "<td align='center'><strong>".$categorizacion_riesgo."</strong></td>";
			echo "<td align='center'>".$ev_9."</td>";
			echo "<td align='center'>".$ev_10."</td>";
			echo "<td align='center'>".$ev_11."</td>";
			echo "<td align='center'>".$ev_12."</td>";
			echo "<td align='center'>".$ev_13."</td>";
			echo "<td align='center'>".$ev_14."</td>";
			echo "<td align='center'><strong>".$total_dependencia."</strong></td>";
			echo "<td align='center'><strong>".$categorizacion_dependencia."</strong></td>";
			echo "<td align='center'><strong>".$categorizacion_final."</strong></td>";
			echo "</tr>";
		}

if ($flag == 1)
{
	if ($cod_servicio == 10 or $cod_servicio == 11)
	{
		echo"<tr style=font-size:15px;'>";
		echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
		echo"<td colspan='9' align='center'>GINECOLOGICO = ".$total_s_gine."</td>";
		echo"<td colspan='10' align='center'>OBSTETRICO = ".$total_s_obst."</td>";
		echo"</tr>";
	}
	
	if ($cod_servicio == 7)
	{
		echo"<tr style=font-size:15px;'>";
		echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
		echo"<td colspan='3' align='center'>UCI=".$total_s_uci."</td>";
		echo"<td colspan='5' align='center'>INDIFERENCIADO=".$total_s_indi."</td>";
		echo"<td colspan='4' align='center'>LACTANTE=".$total_s_lact."</td>";
		echo"<td colspan='3' align='center'>MINIMO=".$total_s_mini."</td>";
		echo"<td colspan='4' align='center'>INTERMEDIO=".$total_s_inte."</td>";
		echo"</tr>";
	}
	if ($cod_servicio == 6)
	{
		echo"<tr style=font-size:15px;'>";
		echo"<td colspan='2' align='center'>Resumen tipo pacientes</td>";
		echo"<td colspan='5' align='center'>UCI=".$total_s_uci."</td>";
		echo"<td colspan='8' align='center'>INTERMEDIO (INCUBADORA)=".$total_s_incu."</td>";
		echo"<td colspan='6' align='center'>CUNA BASICA=".$total_s_cuna."</td>";
		echo"</tr>";
	}
	
	echo"<tr style=font-size:15px;'>";
	echo"<td colspan='2' align='center'>Resumen Categorizacion de Sala</td>";
	echo"<td colspan='5' align='center'>A1=".$total_s_a1." - A2=".$total_s_a2." - A3=".$total_s_a3."</td>";
	echo"<td colspan='5' align='center'>B1=".$total_s_b1." - B2=".$total_s_b2." - B3=".$total_s_b3."</td>";
	echo"<td colspan='5' align='center'>C1=".$total_s_c1." - C2=".$total_s_c2." - C3=".$total_s_c3."</td>";
	echo"<td colspan='4' align='center'>D1=".$total_s_d1." - D2=".$total_s_d2." - D3=".$total_s_d3."</td>";
	echo"</tr>";
	
	echo "</table>";
	
	echo"</fieldset>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<fieldset><legend style='font-size:14px' >RESUMEN CATEGORIZACION SERVICIO ".$desc_servicio." </legend>";
	echo"<table width='100%' align='left' cellpadding='11px'  border='1px' cellspacing='0' style=font-size:15px;'>";

	if ($cod_servicio == 10 or $cod_servicio == 11)
	{
		echo"<tr>";
		echo"<td colspan='6' align='center'>GINECOLOGICO = ".$total_gine."</td>";
		echo"<td colspan='6' align='center'>OBSTETRICO = ".$total_obst."</td>";
		echo"</tr>";
	}
	if ($cod_servicio == 7)
	{
		echo"<tr>";
		echo"<td colspan='2' align='center'>UCI = ".$total_uci."</td>";
		echo"<td colspan='3' align='center'>INDIFERENCIADO = ".$total_indi."</td>";
		echo"<td colspan='2' align='center'>LACTANTE = ".$total_lact."</td>";
		echo"<td colspan='2' align='center'>MINIMO = ".$total_mini."</td>";
		echo"<td colspan='3' align='center'>INTERMEDIO = ".$total_inte."</td>";
		echo"</tr>";
	}
	if ($cod_servicio == 6)
	{
		echo"<tr>";
		echo"<td colspan='4' align='center'>UCI = ".$total_uci."</td>";
		echo"<td colspan='4' align='center'>INCUBADORA = ".$total_incu."</td>";
		echo"<td colspan='4' align='center'>CAMA BASICA = ".$total_cuna."</td>";
		echo"</tr>";
	}

	echo"<tr>";
	echo"<td>A1 = ".$total_a1."</td>";
	echo"<td>A2 = ".$total_a2."</td>";
	echo"<td>A3 = ".$total_a3."</td>";
	echo"<td>B1 = ".$total_b1."</td>";
	echo"<td>B2 = ".$total_b2."</td>";
	echo"<td>B3 = ".$total_b3."</td>";
	echo"<td>C1 = ".$total_c1."</td>";
	echo"<td>C2 = ".$total_c2."</td>";
	echo"<td>C3 = ".$total_c3."</td>";
	echo"<td>D1 = ".$total_d1."</td>";
	echo"<td>D2 = ".$total_d2."</td>";
	echo"<td>D3 = ".$total_d3."</td>";

	echo"</tr>";
	
	echo"<tr align='center'>";
	echo"<td colspan='12'>TOTAL PACIENTES CATEGORIZADOS = ".$totaltotal."</td>";
	echo"</tr>";

	echo"</table>";
	echo"</fieldset>";
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
                		        echo "<input type='checkbox' checked name='opcion_1' onclick='document.frm_info_categoriza.submit()' />C/G";
        		            }
		                    else {
        		                echo "<input type='checkbox' name='opcion_1'  onclick='document.frm_info_categoriza.submit()' />C/G";				
                		    }
							echo "</br>";
	                        if($d_opcion_2 == 1){
                		        echo "<input type='checkbox' checked name='opcion_2' onclick='document.frm_info_categoriza.submit()' />Por Servicios";
        		            }
		                    else {
        		                echo "<input type='checkbox' name='opcion_2'  onclick='document.frm_info_categoriza.submit()' />Por Servicios";				
                		    }
		                    ?>
							</td>
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
			if($d_opcion_2 == 0)
			{
				$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND 
				(categorizacion.ev_1 <>  '0' OR categorizacion.ev_2 <>  '0' OR categorizacion.ev_3 <>  '0' OR categorizacion.ev_4 <>  '0' OR categorizacion.ev_5 <>  '0' OR categorizacion.ev_6 <>  '0' OR categorizacion.ev_7 <>  '0' OR categorizacion.ev_8 <>  '0' OR categorizacion.ev_9 <>  '0' OR categorizacion.ev_10 <>  '0' OR categorizacion.ev_11 <>  '0' OR categorizacion.ev_12 <>  '0' OR categorizacion.ev_13 <>  '0' OR categorizacion.ev_14 <>  '0') order by tipo_1";
				
			}
			else
			{
				$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND 
				(categorizacion.ev_1 <>  '0' OR categorizacion.ev_2 <>  '0' OR categorizacion.ev_3 <>  '0' OR categorizacion.ev_4 <>  '0' OR categorizacion.ev_5 <>  '0' OR categorizacion.ev_6 <>  '0' OR categorizacion.ev_7 <>  '0' OR categorizacion.ev_8 <>  '0' OR categorizacion.ev_9 <>  '0' OR categorizacion.ev_10 <>  '0' OR categorizacion.ev_11 <>  '0' OR categorizacion.ev_12 <>  '0' OR categorizacion.ev_13 <>  '0' OR categorizacion.ev_14 <>  '0') order by cod_servicio";
			}

		}
		else {
			if($d_opcion_2 == 0)
			{
				$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND
				(categorizacion.ev_1 <>  '0' OR categorizacion.ev_2 <>  '0' OR categorizacion.ev_3 <>  '0' OR categorizacion.ev_4 <>  '0' OR categorizacion.ev_5 <>  '0' OR categorizacion.ev_6 <>  '0' OR categorizacion.ev_7 <>  '0' OR categorizacion.ev_8 <>  '0' OR categorizacion.ev_9 <>  '0' OR categorizacion.ev_10 <>  '0' OR categorizacion.ev_11 <>  '0' OR categorizacion.ev_12 <>  '0' OR categorizacion.ev_13 <>  '0' OR categorizacion.ev_14 <>  '0')			
				AND cod_servicio < 40 and cod_servicio <> 10 and cod_servicio <> 11 and cod_servicio <> 12 order by tipo_1";
			}
			else
			{
				$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND
				(categorizacion.ev_1 <>  '0' OR categorizacion.ev_2 <>  '0' OR categorizacion.ev_3 <>  '0' OR categorizacion.ev_4 <>  '0' OR categorizacion.ev_5 <>  '0' OR categorizacion.ev_6 <>  '0' OR categorizacion.ev_7 <>  '0' OR categorizacion.ev_8 <>  '0' OR categorizacion.ev_9 <>  '0' OR categorizacion.ev_10 <>  '0' OR categorizacion.ev_11 <>  '0' OR categorizacion.ev_12 <>  '0' OR categorizacion.ev_13 <>  '0' OR categorizacion.ev_14 <>  '0')			
				AND cod_servicio < 40 and cod_servicio <> 10 and cod_servicio <> 11 and cod_servicio <> 12 order by cod_servicio";
			}
		}

		mysql_connect ('10.6.21.29','usuario','hospital');
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
							
							if($d_opcion_2 == 0)
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
							
							}
							else
							{
								
								
								if ($t_cod_servicio <> $categoriza['cod_servicio'] and $flag == 1)
								{
										
									$total_s = $total_s_a1+$total_s_a2+$total_s_a3+$total_s_b1+$total_s_b2+$total_s_b3+$total_s_c1+$total_s_c2+$total_s_c3+$total_s_d1+$total_s_d2+$total_s_d3;
									echo "<tr align='right'>";
									echo "<td align='left'> ".$t_servicio." </td>";
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
								
								$t_cod_servicio = $categoriza['cod_servicio'];
								$t_servicio = $categoriza['servicio'];
								
								
							}
						
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
							if($d_opcion_2 == 0)
							{
								echo "<td align='left'> ".$d_tipo_1." </td>";
							}
							else
							{
								echo "<td align='left'> ".$t_servicio." </td>";
							}
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
	case 3:
		?>

		




		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="opcion_2" value="<? echo $opcion_2; ?>" type="hidden"  />
		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />

        <tr class="noprint" align="left">

            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                    <tr>
                        <td align="center" >Desde </td>
                        <td><input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
                        <td align="center" >Hasta </td>
                        <td><input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
                        <td align="center" > <input type="submit" value="    Generar Informe   " > </td>

                    </tr>

                    
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        	</form>
            
			<script type="text/javascript">//<![CDATA[
            
            var cal = Calendar.setup({
                  onSelect: function(cal) { cal.hide() }
            });
            cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
            cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
            
            //]]></script>

        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >CINTAS DE GLICEMIA ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>



		<?



		$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' order by cod_servicio, fecha";


		mysql_connect ('10.6.21.29','usuario','hospital');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$total_pac = 0;
		$total_pac_uso = 0;
		$total_prom_cinta = 0;
		$total_cinta = 0;
		
		$total_s_pac = 0;
		$total_s_pac_uso = 0;
		$total_s_prom_cinta = 0;
		$total_s_cinta = 0;
		
		echo "<tr align='center'>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> SERVICIOS CLINICOS </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> Total Pacientes </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> Pacientes C / Cinta </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> Promedio Cintas x Paciente </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> TOTAL CINTAS </strong> </td>";
						echo "</tr>";		

						$flag = 0;


						while($categoriza = mysql_fetch_array($query))
						{
						
							if ($codigo_servicio <> $categoriza['cod_servicio'] and $flag == 1)
							{
									
								if ($total_s_pac_uso <> 0) { $total_s_prom_cinta = $total_s_cinta/$total_s_pac_uso; }
								else { $total_s_prom_cinta = 0; }
								echo "<tr align='right'>";
								echo "<td style='padding-left:15px; padding-right:15px' align='left'>".$servicio."</td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac_uso." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".redondear_dos_decimal($total_s_prom_cinta)." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_cinta." </td>";
								echo "</tr>";		
						
								$total_s_pac = 0;
								$total_s_pac_uso = 0;
								$total_s_prom_cinta = 0;
								$total_s_cinta = 0;
						
							}
						
							$flag = 1;
							
							$codigo_servicio = $categoriza['cod_servicio'];
							$servicio = $categoriza['servicio'];
							
							$cantidad_de_cintas = $categoriza['glicemia'];
							
							$total_cinta = $total_cinta + $cantidad_de_cintas;
							$total_s_cinta = $total_s_cinta + $cantidad_de_cintas;
							
							$total_pac++;
							$total_s_pac++;
							
							if ($cantidad_de_cintas <> 0) {
								$total_pac_uso++;
								$total_s_pac_uso++;
							}
							
						}

						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> ".$servicio." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac_uso." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_prom_cinta." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_cinta." </td>";
						echo "</tr>";		

						$total_s_pac = 0;
						$total_s_pac_uso = 0;
						$total_s_prom_cinta = 0;
						$total_s_cinta = 0;



						$sql = "SELECT * FROM rau where fecha BETWEEN '".$fecha_desde_proceso." 00:00:00' AND '".$fecha_hasta_proceso." 23:59:59' ";
				
						mysql_connect ('10.6.21.29','usuario','hospital');
						mysql_select_db('rau') or die('Cannot select database');
						$query1 = mysql_query($sql) or die(mysql_error());
						
		
						while($rau = mysql_fetch_array($query1))
						{
							$total_pac++;
							$total_s_pac++;

							$cta_cte = $rau['idctacte'];
							if ($cta_cte == "") {$cta_cte = 0;}
							
							$sql = "SELECT * FROM ctacteprestacion where ctacteCod = $cta_cte and preCod = '0302047' ";
					
							mysql_connect ('10.6.21.29','usuario','hospital');
							mysql_select_db('paciente') or die('Cannot select database');
							$query2 = mysql_query($sql) or die(mysql_error());
							
							$tiene_cinta=0;
							while($ctacte_rau = mysql_fetch_array($query2))
							{
								if ($tiene_cinta == 0) 
								{ 
									$tiene_cinta=1; 
									$total_pac_uso++;
									$total_s_pac_uso++;
								}
								$cantidad_de_cintas = $ctacte_rau['ctactepreCant'];
								
								$total_cinta = $total_cinta + $cantidad_de_cintas;
								$total_s_cinta = $total_s_cinta + $cantidad_de_cintas;
								
							}
						
						}

						if ($total_s_pac_uso <> 0) { $total_s_prom_cinta = $total_s_cinta/$total_s_pac_uso; }
						else { $total_s_prom_cinta = 0; }

						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'>Urgencia (RAU)</td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac_uso." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".redondear_dos_decimal($total_s_prom_cinta)." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_cinta." </td>";
						echo "</tr>";		








						$total_s_pac = 0;
						$total_s_pac_uso = 0;
						$total_s_prom_cinta = 0;
						$total_s_cinta = 0;


						$sql = "SELECT * FROM cirugia WHERE ciruFecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."'";
				
						mysql_connect ('10.6.21.29','usuario','hospital');
						mysql_select_db('pabellon') or die('Cannot select database');
						$query2 = mysql_query($sql) or die(mysql_error());
						
		
						while($pabell = mysql_fetch_array($query2))
						{
							$total_pac++;
							$total_s_pac++;

							$ciruCintas = $pabell['ciruCintas'];
							if ($ciruCintas <> 0)
							{
								$tiene_cinta=1; 
								$total_pac_uso++;
								$total_s_pac_uso++;
							}
							$cantidad_de_cintas = $ciruCintas;
							
							$total_cinta = $total_cinta + $cantidad_de_cintas;
							$total_s_cinta = $total_s_cinta + $cantidad_de_cintas;
								
						
						}

						if ($total_s_pac_uso <> 0) { $total_s_prom_cinta = $total_s_cinta/$total_s_pac_uso; }
						else { $total_s_prom_cinta = 0; }

						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'>Pabellon</td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac_uso." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".redondear_dos_decimal($total_s_prom_cinta)." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_cinta." </td>";
						echo "</tr>";		










						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> TOTALES </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_pac." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_pac_uso." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_prom_cinta." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_cinta." </strong> </td>";
						echo "</tr>";		

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";

		
		
		break;
    case 4:
		?>

		




		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="opcion_2" value="<? echo $opcion_2; ?>" type="hidden"  />
		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />

        <tr class="noprint" align="left">

            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                    <tr>
                        <td align="center" >Desde </td>
                        <td><input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
                        <td align="center" >Hasta </td>
                        <td><input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
                        <td align="center" > <input type="submit" value="    Generar Informe   " > </td>

                    </tr>

                    
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        	</form>
            
			<script type="text/javascript">//<![CDATA[
            
            var cal = Calendar.setup({
                  onSelect: function(cal) { cal.hide() }
            });
            cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
            cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
            
            //]]></script>

        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >SONDA MARCAPASO TRANSITORIA ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>


		<?



		$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' order by cod_servicio, fecha";


		mysql_connect ('10.6.21.29','usuario','hospital');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$total_pac = 0;
		$total_smpt = 0;
		
		$total_s_pac = 0;
		$total_s_smpt = 0;
		
		echo "<tr align='center'>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> SERVICIOS CLINICOS </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> Total Pacientes </strong> </td>";
							echo "<td style='padding-left:15px; padding-right:15px'> <strong> TOTAL S.M.P.T. </strong> </td>";
						echo "</tr>";		

						$flag = 0;


						while($categoriza = mysql_fetch_array($query))
						{
						
							if ($codigo_servicio <> $categoriza['cod_servicio'] and $flag == 1)
							{
									
								echo "<tr align='right'>";
								echo "<td style='padding-left:15px; padding-right:15px' align='left'>".$servicio."</td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_smpt." </td>";
								echo "</tr>";		
						
								$total_s_pac = 0;
								$total_s_smpt = 0;
						
							}
						
							$flag = 1;

							$codigo_servicio = $categoriza['cod_servicio'];
							$servicio = $categoriza['servicio'];
							
							$total_pac++;
							$total_s_pac++;
							
							if ($categoriza['smpt'] == 1) {
								$total_smpt++;
								$total_s_smpt++;
							}
							
						}

						
						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> ".$servicio." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_pac." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$total_s_smpt." </td>";
						echo "</tr>";		
						
						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> TOTALES </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_pac." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$total_smpt." </strong> </td>";
						echo "</tr>";		
						

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";

		
		
		break;    case 5:
		?>

		




		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="opcion_2" value="<? echo $opcion_2; ?>" type="hidden"  />
		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />

        <tr class="noprint" align="left">

            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                    <tr>
                        <td align="center" >Desde </td>
                        <td><input size="12" id="f_date1" name="fecha_desde"  value="<? echo $fecha_desde ?>" /> <input type="Button" id="f_btn1" value="....."  /></td>
                        <td align="center" >Hasta </td>
                        <td><input size="12" id="f_date2" name="fecha_hasta"  value="<? echo $fecha_hasta ?>" /> <input type="Button" id="f_btn2" value="....."  /></td>
                        <td align="center" > <input type="submit" value="    Generar Informe   " > </td>

                    </tr>

                    
                    <tr><td height="15px"></td><td></td><td></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        	</form>
            
			<script type="text/javascript">//<![CDATA[
            
            var cal = Calendar.setup({
                  onSelect: function(cal) { cal.hide() }
            });
            cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
            cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
            
            //]]></script>

        </tr>
        
        <tr height="10px">
        </tr>

        <tr align="left">
            <td>
                <fieldset>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="10px"></td><td></td></tr>        
                    <tr>
                        <td align="center" style="font-size:18px" >TIPOS DE VISITAS ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>
        
        <tr height="10px">
        </tr>

		<?



		$sql = "SELECT * FROM categorizacion where fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' order by cod_servicio, fecha";


		mysql_connect ('10.6.21.29','usuario','hospital');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		
		
		$menos_15_sin = 0;
		$en_15_64_sin = 0;
		$masde_64_sin = 0;
		
		$menos_15_12h = 0;
		$en_15_64_12h = 0;
		$masde_64_12h = 0;
		
		$menos_15_24h = 0;
		$en_15_64_24h = 0;
		$masde_64_24h = 0;
		
		$menos_15_tot = 0;
		$en_15_64_tot = 0;
		$masde_64_tot = 0;
		
		$total_sin = 0;
		$total_12h = 0;
		$total_24h = 0;
		$total = 0;


		$s_menos_15_sin = 0;
		$s_en_15_64_sin = 0;
		$s_masde_64_sin = 0;
		
		$s_menos_15_12h = 0;
		$s_en_15_64_12h = 0;
		$s_masde_64_12h = 0;
		
		$s_menos_15_24h = 0;
		$s_en_15_64_24h = 0;
		$s_masde_64_24h = 0;
		
		$s_menos_15_tot = 0;
		$s_en_15_64_tot = 0;
		$s_masde_64_tot = 0;
		
		echo "<tr align='center'>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td rowspan='2' align='left'> <strong> SERVICIOS CLINICOS </strong> </td>";
							echo "<td colspan='3'> <strong> Sin Visitas </strong> </td>";
							echo "<td colspan='3'> <strong> Visitas 12 Hrs. </strong> </td>";
							echo "<td colspan='3'> <strong> Visitas 24 Hrs. </strong> </td>";
							echo "<td colspan='3'> <strong> TOTAL </strong> </td>";
						echo "</tr>";		
						echo "<tr align='center'>";
							echo "<td> - de 15 A�os </td>";
							echo "<td> 15 a 64 A�os </td>";
							echo "<td> + de 64 A�os </td>";
							echo "<td> - de 15 A�os </td>";
							echo "<td> 15 a 64 A�os </td>";
							echo "<td> + de 64 A�os </td>";
							echo "<td> - de 15 A�os </td>";
							echo "<td> 15 a 64 A�os </td>";
							echo "<td> + de 64 A�os </td>";
							echo "<td> - de 15 A�os </td>";
							echo "<td> 15 a 64 A�os </td>";
							echo "<td> + de 64 A�os </td>";
						echo "</tr>";		

						$flag = 0;


						while($categoriza = mysql_fetch_array($query))
						{
						
							if ($codigo_servicio <> $categoriza['cod_servicio'] and $flag == 1)
							{
								
								$total_s = $total_s_sin+$total_s_12h+$total_s_24h;
								echo "<tr align='right'>";
								echo "<td style='padding-left:15px; padding-right:15px' align='left'>".$servicio."</td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_sin." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_sin." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_sin." </td>";
								
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_12h." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_12h." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_12h." </td>";
								
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_24h." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_24h." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_24h." </td>";
								
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_tot." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_tot." </td>";
								echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_tot." </td>";
								echo "</tr>";		
						
								$s_menos_15_sin = 0;
								$s_en_15_64_sin = 0;
								$s_masde_64_sin = 0;
								
								$s_menos_15_12h = 0;
								$s_en_15_64_12h = 0;
								$s_masde_64_12h = 0;
								
								$s_menos_15_24h = 0;
								$s_en_15_64_24h = 0;
								$s_masde_64_24h = 0;
								
								$s_menos_15_tot = 0;
								$s_en_15_64_tot = 0;
								$s_masde_64_tot = 0;
						
							}
						
							$flag = 1;

							$fecha = $categoriza['fecha'];
							
							$id_paciente = $categoriza['id_paciente'];
							
							$sql = "SELECT * FROM paciente where id = '".$id_paciente."'";
							mysql_select_db('paciente') or die('Cannot select database');
							$query_pac = mysql_query($sql) or die(mysql_error());

							$paciente = mysql_fetch_array($query_pac);
							if ($paciente)
							{
								$fechanac = $paciente['fechanac'];
							}
							else
							{
								$fechanac = $fecha;
							}

							$dia=substr($fecha, 8, 2); 
							$mes=substr($fecha, 5, 2); 
							$anno=substr($fecha, 0, 4); 
							
							//descomponer fecha de nacimiento 
							$dia_nac=substr($fechanac, 8, 2); 
							$mes_nac=substr($fechanac, 5, 2); 
							$anno_nac=substr($fechanac, 0, 4); 
							
							
							if($mes_nac>$mes){$edad_paciente= $anno-$anno_nac-1;}else{if($mes==$mes_nac AND $dia_nac>$dia){$edad_paciente= $anno-$anno_nac-1;}
							else{$edad_paciente= $anno-$anno_nac;}} 


							$codigo_servicio = $categoriza['cod_servicio'];
							$servicio = $categoriza['servicio'];
						
							switch ($categoriza['estado_2']) {
								case '1':
									if ($edad_paciente < 15)
									{ 
										$s_menos_15_sin++; 
										$menos_15_sin++;
									}
									else
									{
										if($edad_paciente < 65)
										{
											$s_en_15_64_sin++;
											$en_15_64_sin++;
										}
										else
										{
											$s_masde_64_sin++;
											$masde_64_sin++;
										}
									}
									
									$total_sin++;

									break;
								case '2':
									if ($edad_paciente < 15) 
									{ 
										$s_menos_15_12h++; 
										$menos_15_12h++;
									}
									else
									{
										if($edad_paciente < 65)
										{
											$s_en_15_64_12h++;
											$en_15_64_12h++;
										}
										else
										{
											$s_masde_64_12h++;
											$masde_64_12h++;
										}
									}
									
									$total_12h++;
									
									break;
								case '3':
									if ($edad_paciente < 15) 
									{ 
										$s_menos_15_24h++; 
										$menos_15_24h++;
									}
									else
									{
										if($edad_paciente < 65)
										{
											$s_en_15_64_24h++;
											$en_15_64_24h++;
										}
										else
										{
											$s_masde_64_24h++;
											$masde_64_24h++;
										}
									}
									
									$total_24h++;
									
									break;
							}

							if ($edad_paciente < 15) 
							{ 
								$s_menos_15_tot++; 
								$menos_15_tot++;
							}
							else
							{
								if($edad_paciente < 65)
								{
									$s_en_15_64_tot++;
									$en_15_64_tot++;
								}
								else
								{
									$s_masde_64_tot++;
									$masde_64_tot++;
								}
							}

						}

						
						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'>".$servicio."</td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_sin." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_sin." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_sin." </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_12h." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_12h." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_12h." </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_24h." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_24h." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_24h." </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_menos_15_tot." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_en_15_64_tot." </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > ".$s_masde_64_tot." </td>";
						echo "</tr>";		
						
						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> TOTALES </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$menos_15_sin." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$en_15_64_sin." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$masde_64_sin." </strong> </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$menos_15_12h." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$en_15_64_12h." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$masde_64_12h." </strong> </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$menos_15_24h." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$en_15_64_24h." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$masde_64_24h." </strong> </td>";
						
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$menos_15_tot." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$en_15_64_tot." </strong> </td>";
						echo "<td style='padding-left:15px; padding-right:15px' > <strong> ".$masde_64_tot." </strong> </td>";
						echo "</tr>";


						echo "<tr align='center'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> % Sobre Total </td>";
						if ($total_sin <> 0)
						{
							echo "<td> ".redondear_dos_decimal(($menos_15_sin*100)/$total_sin)." % </td>";
							echo "<td> ".redondear_dos_decimal(($en_15_64_sin*100)/$total_sin)." % </td>";
							echo "<td> ".redondear_dos_decimal(($masde_64_sin*100)/$total_sin)." % </td>";
						}
						else
						{
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
						}
						
						if ($total_12h <> 0)
						{
							echo "<td> ".redondear_dos_decimal(($menos_15_12h*100)/$total_12h)." % </td>";
							echo "<td> ".redondear_dos_decimal(($en_15_64_12h*100)/$total_12h)." % </td>";
							echo "<td> ".redondear_dos_decimal(($masde_64_12h*100)/$total_12h)." % </td>";
						}
						else
						{
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
						}
						
						if ($total_24h <> 0)
						{
							echo "<td> ".redondear_dos_decimal(($menos_15_24h*100)/$total_24h)." % </td>";
							echo "<td> ".redondear_dos_decimal(($en_15_64_24h*100)/$total_24h)." % </td>";
							echo "<td> ".redondear_dos_decimal(($masde_64_24h*100)/$total_24h)." % </td>";
						}
						else
						{
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
						}


						$total = $total_sin+$total_12h+$total_24h;


						if ($total <> 0)
						{
							echo "<td> ".redondear_dos_decimal(($menos_15_tot*100)/$total)." % </td>";
							echo "<td> ".redondear_dos_decimal(($en_15_64_tot*100)/$total)." % </td>";
							echo "<td> ".redondear_dos_decimal(($masde_64_tot*100)/$total)." % </td>";
						}
						else
						{
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
							echo "<td> 0 </td>";
						}
						
						
						
						
						
						
						echo "</tr>";		






						
						echo "<tr align='right'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> <strong> TOTALES </strong> </td>";
						echo "<td colspan='3' align='center' > <strong> ".$total_sin." </strong> </td>";
						
						echo "<td colspan='3' align='center' > <strong> ".$total_12h." </strong> </td>";
						
						echo "<td colspan='3' align='center' > <strong> ".$total_24h." </strong> </td>";
						
						echo "<td colspan='3' align='center' > <strong> ".$total." </strong> </td>";
						echo "</tr>";		


						echo "<tr align='center'>";
						echo "<td style='padding-left:15px; padding-right:15px' align='left'> % Sobre Total </td>";
						if ($total <> 0)
						{
							echo "<td colspan='3'> ".redondear_dos_decimal(($total_sin*100)/$total)." % </td>";
							echo "<td colspan='3'> ".redondear_dos_decimal(($total_12h*100)/$total)." % </td>";
							echo "<td colspan='3'> ".redondear_dos_decimal(($total_24h*100)/$total)." % </td>";
							echo "<td colspan='3'> ".redondear_dos_decimal(($total*100)/$total)." % </td>";
						}
						else
						{
							echo "<td colspan='3'> 0 </td>";
							echo "<td colspan='3'> 0 </td>";
							echo "<td colspan='3'> 0 </td>";
							echo "<td colspan='3'> 0 </td>";
						}
						echo "</tr>";		

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";
		

		
		
		break;
		case 6:
				/********************************** Score Riesgo Social **********************************////////////////////////////////
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
                        <td align="center" style="font-size:18px" >Score Riesgo Social ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                </fieldset>
            </td>
        </tr>
        </form>
        <script type="text/javascript">
        var cal = Calendar.setup({ onSelect: function(cal) { cal.hide() } });
        cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
        cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
        </script>
		<?
		$sql = "SELECT
					camas.evaluacion_social.ED_recidencia,
					camas.evaluacion_social.ED_economica,
					camas.evaluacion_social.ED_mental,
					camas.evaluacion_social.ED_familiar,
					camas.evaluacion_social.ED_cuidador,
					camas.categorizacion.nom_paciente,
					camas.categorizacion.ev_1,
					camas.categorizacion.ev_2,
					camas.categorizacion.ev_3,
					camas.categorizacion.ev_4,
					camas.categorizacion.ev_5,
					camas.categorizacion.ev_6,
					camas.categorizacion.ev_7,
					camas.categorizacion.ev_8,
					camas.categorizacion.ev_9,
					camas.categorizacion.ev_10,
					camas.categorizacion.ev_11,
					camas.categorizacion.ev_12,
					camas.categorizacion.ev_13,
					camas.categorizacion.ev_14,
					camas.categorizacion.categorizacion_riesgo,
					camas.categorizacion.categorizacion_dependencia,
					paciente.ctacte.paciente_id,
					DATE_FORMAT(FROM_DAYS(TO_DAYS(camas.evaluacion_social.ED_fecha)-TO_DAYS(paciente.paciente.fechanac)), '%Y')+0 AS edad
					FROM
					camas.evaluacion_social
					INNER JOIN camas.categorizacion ON camas.evaluacion_social.CAT_id = camas.categorizacion.id
					INNER JOIN paciente.ctacte ON camas.evaluacion_social.ED_ctacte = paciente.ctacte.idctacte
					INNER JOIN paciente.paciente ON paciente.ctacte.idpaciente = paciente.paciente.id
					WHERE
					camas.evaluacion_social.ED_fecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."'";
				

		mysql_connect ('10.6.21.29','usuario','hospital');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td align='left'> N� </td>";
							echo "<td>Nombre de usuario con sospecha de condici�n sociosanitaria</td>";
							echo "<td>Edad</td>";
							echo "<td>RUN de usuario</td>";
							echo "<td>Categorizaci�n CUDYR</td>";
							echo "<td>Puntaje Evaluaci�n CUDYR</td>";
							echo "<td>Categorizaci�n social</td>";
							echo "<td>Puntaje Score Social</td>";
							echo "<td>Puntaje final Score Bio-social</td>";
							echo "<td>Cat final Score Bio-social</td>";
						echo "</tr>";		
						$i=1;
						while($categoriza = mysql_fetch_array($query)){
							echo "<tr align='right'>";
							echo "<td align='left'> ".$i." </td>";
							echo "<td align='left'> ".$categoriza['nom_paciente']." </td>";
							echo "<td align='center'> ".$categoriza['edad']." </td>";
							$dv = ValidaDVRut($categoriza['paciente_id']);
							$rutcompuesto = $categoriza['paciente_id']."-".$dv;
							echo "<td width='75px'> ".$rutcompuesto." </td>";
							echo "<td align='center'> ".$categoriza['categorizacion_riesgo'].$categoriza['categorizacion_dependencia']." </td>";
							$puntajeevaluacioncudyr = $categoriza['ev_1']+$categoriza['ev_2']+$categoriza['ev_3']+$categoriza['ev_4']+$categoriza['ev_5']+$categoriza['ev_6']+$categoriza['ev_7']+$categoriza['ev_8']+$categoriza['ev_9']+$categoriza['ev_10']+$categoriza['ev_11']+$categoriza['ev_12']+$categoriza['ev_13']+$categoriza['ev_14'];
							echo "<td align='center'> ".$puntajeevaluacioncudyr." </td>";
							$puntajescore = $categoriza['ED_recidencia']+$categoriza['ED_economica']+$categoriza['ED_mental']+$categoriza['ED_familiar']+$categoriza['ED_cuidador'];
										if($puntajescore>=11){
	                                        $textopuntajescore = "Alta Dep. Social � Riesgo Severo";
	                                    }elseif($puntajescore<=10 and $puntajescore>=6){
	                                        $textopuntajescore = "Mediana Dep. Social � Riesgo Moderado";
	                                    }elseif($puntajescore<=5 and $puntajescore>=1){
	                                        $textopuntajescore = "Baja o Nula Dep. Social � Riesgo Leve";
	                                    }else{$textopuntajescore = "";}
							echo "<td align='left'> ".$textopuntajescore." </td>";
							echo "<td align='center'> ".$puntajescore." </td>";
							$pfinal = $puntajescore+$puntajeevaluacioncudyr;
							echo "<td align='center'> ".$pfinal." </td>";
										if($pfinal>=34){
	                                        $textopuntajescoref = "Alta Riesgo Biosicosocial";
	                                    }elseif($pfinal<=33 and $pfinal>=23){
	                                        $textopuntajescoref = "Mediano Riesgo Biosicosocial";
	                                    }elseif($pfinal<=22 and $pfinal>=0){
	                                        $textopuntajescoref = "Bajo Riesgo Biosicosocial";
	                                    }else{$textopuntajescoref = "";}
	                        echo "<td align='left'> ".$textopuntajescoref." </td>";
							echo "</tr>";
						$i++;
						}
					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";?>
<?
				/**************************** fin de Score social *////////////////////////////////////////////////////////////////////
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

