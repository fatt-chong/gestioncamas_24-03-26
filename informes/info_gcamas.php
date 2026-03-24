<?php

// $tipo_categorizacion= $_GET['tipo_categorizacion'];
// $opcion_1= $_GET['opcion_1'];
// $fecha_desde= $_GET['fecha_desde'];
// $fecha_hasta= $_GET['fecha_hasta'];
// $act= $_GET['act'];

$act = $_REQUEST['act'];
$tipo_categorizacion = $_REQUEST['tipo_categorizacion'];
$opcion_1 = $_REQUEST['opcion_1'];
$cod_servicio = $_REQUEST['cod_servicio'];
$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];
$cantidad = $_REQUEST['cantidad'];
//$cod_servicio = $_REQUEST['cod_servicio'];
$fechaD1 = $_REQUEST['fechaD1'];
$fechaH1 = $_REQUEST['fechaH1'];
$fechaF1 = $_REQUEST['fechaF1'];

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
    <script type="text/javascript">
        var GB_ROOT_DIR = "../../solicitud_examen/CSS/greybox/";
    </script>

    <script type="text/javascript" src="../../solicitud_examen/CSS/greybox/AJS.js"></script>
    <script type="text/javascript" src="../../solicitud_examen/CSS/greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="../../solicitud_examen/CSS/greybox/gb_scripts.js"></script>
    <script type="text/javascript" src="../../estandar/src/tigra_tables.js"></script>
    <link href="../../solicitud_examen/CSS/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
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
	$cod_servicio = '-1';
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

    <form method="get" action="info_gcamas.php" name="frm_info_gcamas" id="frm_info_gcamas">
    <input type="hidden" name="act" id="act" />
    <tr class="noprint">
        <td align="left" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="bottom" height="25px">
                        &nbsp;&nbsp;<a style="font-size:14px">INFORMES GESTION DE CAMAS.</a>
                    </td>
                    <td align="right">
                        TIPO DE INFORME 
                        <select name="tipo_categorizacion" onchange="document.frm_info_gcamas.submit()">
                            <option value=1 <? if ($tipo_categorizacion == 1) { echo "selected"; } ?> >Registro Diario Pacientes en Espera Hospitalizaci�n </option>
                            <option value=2 <? if ($tipo_categorizacion == 2) { echo "selected"; } ?> >Pacientes hospitalizados en otro servicio </option>
                            <option value=3 <? if ($tipo_categorizacion == 3) { echo "selected"; } ?> >Pacientes hospitalizados con mas de 10 d�as hospitalizados</option>
                            <option value=4 <? if ($tipo_categorizacion == 4) { echo "selected"; } ?> >Egresos Hospitalarios</option>
                            <option value=5 <? if ($tipo_categorizacion == 5) { echo "selected"; } ?> >Reporte Epicrisis Enfermer�a</option>
                            <option value=6 <? if ($tipo_categorizacion == 6) { echo "selected"; } ?> >Reporte Epicrisis M�dica</option>
                            <option value=7 <? if ($tipo_categorizacion == 7) { echo "selected"; } ?> >Indice Barthel</option>
                            <option value=8 <? if ($tipo_categorizacion == 8) { echo "selected"; } ?> >REM A-03</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

	

	<?
    switch ($tipo_categorizacion) {
    case 1:
	
	
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
                            UNIDAD DE EMERGENCIA
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
                        <td align="center" style="font-size:18px" >REGISTRO DE PACIENTES EN ESPERA DE HOSPITALIZACION (Fecha <? echo $fecha_desde; ?> 08:00 Hrs.)"</td>
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

	<table id="Exportar_a_Excel" align="center" border="1px" cellpadding="5" cellspacing="0">

        <?

		$sql = "SELECT * FROM hospitalizaciones where cod_servicio = 50 and tipo_traslado <> 3 and fecha_ingreso <= '".$fecha_desde_proceso."' and  fecha_egreso >= '".$fecha_desde_proceso."' order by sala, cama";

		echo "<tr>";
		
		echo "<td align='center'>Sala</td>";
		echo "<td align='center'>Cama</td>";
		echo "<td align='center'>Paciente</td>";
		echo "<td align='center'>Edad</td>";
		echo "<td align='center' colspan='2'>Ingreso</td>";
		echo "<td align='center' colspan='2'>Egreso</td>";
		echo "<td align='center'>Destino</td>";
		
		echo "</tr>";
		
		mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());

		while($enespera = mysql_fetch_array($query))
		{
			

			$cuandoingreso = $enespera['fecha_ingreso']." ".$enespera['hora_ingreso'];
			$cuandosefue = $enespera['fecha_egreso']." ".$enespera['hora_egreso'];
			
			$fechacomparar = $fecha_desde_proceso." 08:00:00";
			
			if ($fechacomparar >= $cuandoingreso and $fechacomparar <= $cuandosefue)
			{
		
				echo "<tr>";
				
				echo "<td align='center'>".$enespera['sala']."</td>";
				echo "<td align='center'>".$enespera['cama']."</td>";
				echo "<td>".$enespera['nom_paciente']."</td>";
				echo "<td align='right'>".$enespera['edad_paciente']."</td>";
				echo "<td align='center'>".cambiarFormatoFecha2($enespera['fecha_ingreso'])."</td>";
				echo "<td align='center'>".substr($enespera['hora_ingreso'], 0, 5)."</td>";
				echo "<td align='center'>".cambiarFormatoFecha2($enespera['fecha_egreso'])."</td>";
				echo "<td align='center'>".substr($enespera['hora_egreso'], 0, 5)."</td>";
				
//				echo "<td align='center'>".$cuandoingreso."</td>";
//				echo "<td align='center'>".$cuandosefue."</td>";
				
				echo "<td>".$enespera['destino']."</td>";
				
				echo "</tr>";
			}
			
		}



?>

</table>
<table align="center">






		<?
		break;
    case 2:
//////////////////////////////////////////// *************** inicio intervencion danny *************************///////////////////////////////////////
		?>


		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />
        <tr class="noprint" align="left">
            <td width="1184">
                <fieldset>
	                <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                        <td align="center" style="font-size:18px">RESUMEN PACIENTES EN OTRO SERVICIO ( <? echo $fecha_desde; ?> )</td>
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
			$sql = "SELECT camas.que_servicio, camas.servicio, camas.sala, camas.cama, camas.nom_paciente, camas.diagnostico1, camas.diagnostico2
					FROM camas
					WHERE que_cod_servicio <> cod_servicio and nom_paciente <> ''
					ORDER BY que_servicio, servicio ASC"; 									// consulta por las camas normales
			// $sql2 = "SELECT listasn.desde_nomServSN, camassn.tipoCamaSN, camassn.salaCamaSN, camassn.nomCamaSN, listasn.nomPacienteSN, listasn.diagnostico1SN, listasn.diagnostico2SN
			// 		FROM listasn
			// 		INNER JOIN camassn ON camassn.codCamaSN = listasn.idCamaSN
			// 		ORDER BY listasn.desde_nomServSN, tipoCamaSN ASC"; 						// consulta por las camas supernumerarias
/*			$sql = "SELECT nom_paciente, que_cod_servicio, que_servicio, cod_servicio, servicio, sala, cama, cta_cte,
					concat(categorizacion_riesgo , ' ' , categorizacion_dependencia) AS categoria
					FROM camas
					WHERE cta_cte is NOT NULL and que_cod_servicio <> cod_servicio and nom_paciente <> ''
					ORDER BY que_cod_servicio, cod_servicio";
			$sql2 = "SELECT listasn.desde_nomServSN, camassn.tipoCamaSN, camassn.salaCamaSN,
					camassn.nomCamaSN, listasn.nomPacienteSN
					FROM camassn
					LEFT JOIN listasn ON camassn.codCamaSN = listasn.idCamaSN
					WHERE camassn.tipoCamaSN = 'P' AND  camassn.estadoCamaSN = 2 and ctaCteSN <> '' 
					ORDER BY desde_nomServSN ASC"; */
//			$sql3 = "SELECT listasn.desde_nomServSN, camassn.tipoCamaSN, camassn.salaCamaSN,
//					camassn.nomCamaSN, listasn.nomPacienteSN
//					FROM camassn
//					LEFT JOIN listasn ON camassn.codCamaSN = listasn.idCamaSN
//					WHERE camassn.salaCamaSN = '6' AND camassn.tipoCamaSN = 'I'
//					ORDER BY desde_nomServSN ASC";
		}
		//camas normales
		mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
		mysql_select_db('camas') or die('Cannot select database');
		$query2 = mysql_query($sql) or die(mysql_error());
		// campas SN pensionado

		// mysql_select_db('camas') or die('Cannot select database');
		// $query3 = mysql_query($sql2) or die(mysql_error());
		// campas SN pensionado

//		mysql_select_db('camas') or die('Cannot select database');
//		$query4 = mysql_query($sql3) or die(mysql_error());
		
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
						$contador = 0;
						$contador1 = 0;
						$contador2 = 0;
						$contador3 = 0;
						$contador4 = 0;
						$contador5 = 0;
						$contador6 = 0;
						$contador7 = 0;
						$contador8 = 0;
						$contador9 = 0;
						$contador10 = 0;
						$contador11 = 0;
						$total_cat_A1 = 0;
						$total_cat_A2 = 0;
						$total_cat_A3 = 0;
						$total_cat_B1 = 0;
						$total_cat_B2 = 0;
						$total_cat_B3 = 0;
						$total_cat_C1 = 0;
						$total_cat_C2 = 0;
						$total_cat_C3 = 0;
						$total_cat_D1 = 0;
						$total_cat_D2 = 0;
						$total_cat_D3 = 0;
						$flag = 0;
						
						while($categoriza = mysql_fetch_array($query2))
						{	
							if($categoriza['categoria'] == "A 1"){$total_cat_A1 = $contador + 1;   $contador = $contador + 1;}
							if($categoriza['categoria'] == "A 2"){$total_cat_A2 = $contador1 + 1;  $contador1 = $contador1 + 1;}
							if($categoriza['categoria'] == "A 3"){$total_cat_A3 = $contador2 + 1;  $contador2 = $contador2 + 1;}
							if($categoriza['categoria'] == "B 1"){$total_cat_B1 = $contador3 + 1;  $contador3 = $contador3 + 1;}
							if($categoriza['categoria'] == "B 2"){$total_cat_B2 = $contador4 + 1;  $contador4 = $contador4 + 1;}
							if($categoriza['categoria'] == "B 3"){$total_cat_B3 = $contador5 + 1;  $contador5 = $contador5 + 1;}
							if($categoriza['categoria'] == "C 1"){$total_cat_C1 = $contador6 + 1;  $contador6 = $contador6 + 1;}
							if($categoriza['categoria'] == "C 2"){$total_cat_C2 = $contador7 + 1;  $contador7 = $contador7 + 1;}
							if($categoriza['categoria'] == "C 3"){$total_cat_C3 = $contador8 + 1;  $contador8 = $contador8 + 1;}
							if($categoriza['categoria'] == "D 1"){$total_cat_D1 = $contador9 + 1;  $contador9 = $contador9 + 1;}
							if($categoriza['categoria'] == "D 2"){$total_cat_D2 = $contador10 + 1; $contador10 = $contador10 + 1;}
							if($categoriza['categoria'] == "D 3"){$total_cat_D3 = $contador11 + 1; $contador11 = $contador11 + 1;}
							
						}		

// camas normales		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='7px' cellspacing='2px'>";
					echo "<tr align='center'>";
					echo "<td><strong>Servicio al que pertenece</strong></td>";
					echo "<td><strong>Servicio donde se encuentra</strong></td>";
					echo "<td><strong>Sala</strong></td>";
					echo "<td><strong>Cama</strong></td>";
					echo "<td><strong>Nombre Paciente</strong></td>";
					echo "<td><strong>Diagn&oacute;stico 1</strong></td>";
					echo "<td><strong>Diagn&oacute;stico 2</strong></td>";
					echo "</tr>";
					mysql_data_seek($query2,0);
// almaceno en cateoriza1 los parametros de la primera consulta para fusionarlos con la siguiente consulta inisializando el indice en 0
					$k=0;
					while($categoriza = mysql_fetch_array($query2))	{
					$categoriza1[$k]['que_servicio']=$categoriza['que_servicio'];
					$categoriza1[$k]['servicio']=$categoriza['servicio'];
					$categoriza1[$k]['sala']=$categoriza['sala'];
					$categoriza1[$k]['cama']=$categoriza['cama'];
					$categoriza1[$k]['nom_paciente']=$categoriza['nom_paciente'];
					$categoriza1[$k]['diagnostico1']=$categoriza['diagnostico1'];
					$categoriza1[$k]['diagnostico2']=$categoriza['diagnostico2'];
					$k++;
					}
// 					mysql_data_seek($query3,0);
// //termino de almacenar los datos de la primera consulta, y comienzo con la siguiente manteniendo el contador anterior
// // fusionando siguiente contenido al anterior con el indice k				
// 					while($categoriza2 = mysql_fetch_array($query3))	{
// 					if ($categoriza2['tipoCamaSN'] == "P"){$depensio = "CMI";}if ($categoriza2['tipoCamaSN'] == "I"){$depensio = "Sexto Piso";}
// 					$categoriza1[$k]['que_servicio']=$categoriza2['desde_nomServSN'];
// 					$categoriza1[$k]['servicio']=$depensio;
// 					$categoriza1[$k]['sala']=$categoriza2['salaCamaSN'];
// 					$categoriza1[$k]['cama']=$categoriza2['nomCamaSN'];
// 					$categoriza1[$k]['nom_paciente']=$categoriza2['nomPacienteSN'];
// 					$categoriza1[$k]['diagnostico1']=$categoriza2['diagnostico1SN'];
// 					$categoriza1[$k]['diagnostico2']=$categoriza2['diagnostico2SN'];
// 					$k++;
// 					}
					$limite = $k;
// termino de fusionar los elmentos en el arreglo de categoriza1
// funcion para ordenar
for($inicio=0;$inicio<=$limite;$inicio++){
	for($i=0;$i<$limite;$i++){
		$siguiente=$i+1;
		if($categoriza1[$i]['que_servicio'] > $categoriza1[$siguiente]['que_servicio']){
					//almacenando variables del arreglo que son segunda mayor que primera en una variable auxiliar
					$aux[$i]['que_servicio']					=$categoriza1[$siguiente]['que_servicio'];
					$aux[$i]['servicio']						=$categoriza1[$siguiente]['servicio'];
					$aux[$i]['sala']							=$categoriza1[$siguiente]['sala'];
					$aux[$i]['cama']							=$categoriza1[$siguiente]['cama'];
					$aux[$i]['nom_paciente']					=$categoriza1[$siguiente]['nom_paciente'];
					$aux[$i]['diagnostico1']					=$categoriza1[$siguiente]['diagnostico1'];
					$aux[$i]['diagnostico2']					=$categoriza1[$siguiente]['diagnostico2'];
					//pasando los parametros con valor m�s bajo al otro extremo del arreglo
					$categoriza1[$siguiente]['que_servicio']	=$categoriza1[$i]['que_servicio'];
					$categoriza1[$siguiente]['servicio']		=$categoriza1[$i]['servicio'];
					$categoriza1[$siguiente]['sala']			=$categoriza1[$i]['sala'];
					$categoriza1[$siguiente]['cama']			=$categoriza1[$i]['cama'];
					$categoriza1[$siguiente]['nom_paciente']	=$categoriza1[$i]['nom_paciente'];
					$categoriza1[$siguiente]['diagnostico1']	=$categoriza1[$i]['diagnostico1'];
					$categoriza1[$siguiente]['diagnostico2']	=$categoriza1[$i]['diagnostico2'];
					//rellenando primer arreglo menor con los datos de la variable auxiliar
					$categoriza1[$i]['que_servicio']			=$aux[$i]['que_servicio'];
					$categoriza1[$i]['servicio']				=$aux[$i]['servicio'];
					$categoriza1[$i]['sala']					=$aux[$i]['sala'];
					$categoriza1[$i]['cama']					=$aux[$i]['cama'];
					$categoriza1[$i]['nom_paciente']			=$aux[$i]['nom_paciente'];
					$categoriza1[$i]['diagnostico1']			=$aux[$i]['diagnostico1'];
					$categoriza1[$i]['diagnostico2']			=$aux[$i]['diagnostico2'];
		}
	}
}
// termina funcion para ordenar
// lista los elemnetos ordenados

					for($i=1;$i<=$k;$i++){
					echo "<tr>";
					echo "<td>".$categoriza1[$i]['que_servicio']."</td><td>".$categoriza1[$i]['servicio']."</td><td>".$categoriza1[$i]['sala']."</td><td>".$categoriza1[$i]['cama']."</td><td>".$categoriza1[$i]['nom_paciente']."</td><td>".$categoriza1[$i]['diagnostico1']."</td><td>".$categoriza1[$i]['diagnostico2']."</td></tr>";
					}
					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";
echo "<tr><td colspan='3'>";
echo "</td></tr>";
//////////////////////////////////////////// *************** fin intervencion danny *************************///////////////////////////////////////
		break;
	case 3: 
	
			$sql = "SELECT * FROM sscc WHERE id < 89";
			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$query = mysql_query($sql) or die(mysql_error());
			
			if($cod_servicio <> '-1')
				$criterioServicio = " AND cod_servicio = '$cod_servicio'";
			if($cantidad == '')
				$cantidad = "10";
			
			$sql = "SELECT camas.rut_paciente, camas.nom_paciente, camas.diagnostico1,
					camas.servicio, camas.hospitalizado, camas.fecha_ingreso, camas.sala, camas.cama, camas.categorizacion_riesgo, camas.categorizacion_dependencia,
					DATEDIFF(curdate(),camas.hospitalizado ) AS dias_hosp, DATEDIFF(curdate(),camas.fecha_ingreso ) AS dias_cama
					FROM camas
					WHERE camas.id_paciente <>  0 
					AND DATEDIFF(curdate(),camas.hospitalizado ) > '$cantidad' ".$criterioServicio."
					ORDER BY camas.hospitalizado ASC";
			mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
			mysql_select_db('camas') or die('Cannot select database');
			$row10Dias = mysql_query($sql) or die(mysql_error()."<br>ERROR EN REPORTE 10 DIAS<br> $sql");

	?>
    
		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />
		<input name="fecha_desde" value="<? echo $fecha_desde; ?>" type="hidden"  />
        <input name="fecha_hasta" value="<? echo $fecha_hasta; ?>" type="hidden"  />

    <tr align="left">
            <td height="73">
            <fieldset>
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="38" align="center">Cantidad Dias
                    <input name="cantidad" type="text" id="cantidad" size="5" value="<? if($cantidad <> '') echo $cantidad; else echo 10;?>"/></td>
                    <td align="center">Servicio Cl�nico
                      <select name="cod_servicio" onchange="document.frm_info_censo.submit()">
                        	<option value="-1">Todos los Servicios</option>
                        	<? while($arrServicio = mysql_fetch_array($query)){?>
                        		<option value="<? echo $arrServicio['id'];?>" <? if($arrServicio['id'] == $cod_servicio) echo "selected";?>><? echo $arrServicio['servicio'];?></option>
                        	<? }?>
                    </select></td>
                    <td align="center"><span style="font-size:18px">
                      <input type="submit" value="      Generar Informe      " />
                    </span></td>
              </tr>
            </table>
            </fieldset>
            </td>
  			</tr>
            <tr align="left">
            <td>
            <fieldset>
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="46" align="center" style="font-size:18px">PACIENTES  HOSPITALIZADOS CON M&Aacute;S DE <? if($cantidad) echo $cantidad; else echo 10;?> DIAS DE HOSPITALIZACI&Oacute;N</td>
              </tr>
            </table>
            </fieldset>
            <fieldset>
			<table id="Exportar_a_Excel" align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
				<tr>
                    <th width="3%" height="20" align="center">Rut</th>
                    <th width="15%" align="center">Nombre</th>
                    <th width="11%" align="center">Diagnostico</th>
                    <th width="11%" align="center">Categorizacion</th>
                    <th width="8%" align="center">Servicio</th>
                    <th width="3%" align="center">Sala</th>
                    <th width="4%" align="center">Cama</th>
                    <th width="16%" align="center">Hospitalizado</th>
                    <th width="15%" align="center">Fecha Ingreso</th>
                    <th width="7%" align="center">Dias Hosp</th>
                    <th width="7%" align="center">Dias Ultimo Servicio</th>
                </tr>
               	<? while($array10Dias = mysql_fetch_array($row10Dias)){
						list($fecha_hosp,$hora) = explode(" ",$array10Dias['hospitalizado']);
					
					?>
                    <tr>
                        <td align="center"><? if($array10Dias['rut_paciente']) echo $array10Dias['rut_paciente']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['nom_paciente']) echo $array10Dias['nom_paciente']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['diagnostico1']) echo $array10Dias['diagnostico1']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['categorizacion_riesgo']) echo $array10Dias['categorizacion_riesgo'].$array10Dias['categorizacion_dependencia']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['servicio']) echo $array10Dias['servicio']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['sala']) echo $array10Dias['sala']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['cama']) echo $array10Dias['cama']; else echo "&nbsp;";?></td>
                      <td align="center"><? if($fecha_hosp) echo cambiarFormatoFecha($fecha_hosp)." ".$hora; else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['fecha_ingreso']) echo cambiarFormatoFecha($array10Dias['fecha_ingreso']); else echo "&nbsp;";?></td>
                      <td align="center"><? if($array10Dias['dias_hosp']) echo $array10Dias['dias_hosp']; else echo "&nbsp;";?></td>
                        <td align="center"><? if($array10Dias['dias_cama']) echo $array10Dias['dias_cama']; else echo "&nbsp;";?></td>
                    </tr>
				<? }?>
        
        	</table>
            </fieldset>

		</td>
  </tr>
	<?	break;
    case 4:
		?>

		<input name="opcion_1" value="<? echo $opcion_1; ?>" type="hidden"  />
		<input name="cod_servicio" value="<? echo $cod_servicio; ?>" type="hidden"  />



        <tr class="noprint" align="left">
            <td width="1184">
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
                        <td align="center" style="font-size:18px">RESUMEN EGRESOS ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
                    </tr>
                    <tr><td height="10px"></td><td></td></tr>        
                </table>
                
                </fieldset>
            </td>
        </tr>

        
        
          <script type="text/javascript">//<![CDATA[
        
          var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
          cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
        
        //]]></script>
    

		<?

		$tot_s_altas = 0;
		$tot_s_defun = 0;
		$tot_s_o_egr = 0;
		$tot_s_c_inf = 0;
		
		$tot_altas = 0;
		$tot_defun = 0;
		$tot_o_egr = 0;
		$tot_c_inf = 0;

		$sql = "SELECT * FROM hospitalizaciones where cod_destino > 100 and fecha_egreso BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' order by cod_servicio";

		mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
		mysql_select_db('camas') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		
		echo "<tr>";
			echo "<td>";
				echo "<fieldset>";
					echo "<table id='Exportar_a_Excel' align='center' border='1px' cellpadding='0' cellspacing='0'>";
						echo "<tr align='center'>";
							echo "<td rowspan=2 align='left'> SERVICIOS CLINICOS </td>";
							echo "<td colspan=2 width=140 >Altas</td>";
							echo "<td colspan=2 width=140 >Defunciones</td>";
							echo "<td colspan=2 width=140 >Otro Egreso</td>";
							echo "<td rowspan=2 width=100 >TOTAL EGRESOS</td>";
							echo "<td colspan=2 width=140 >Con Informacion</td>";
						echo "</tr>";		
						echo "<tr align='center'>";
							echo "<td width=70>Nro</td>";
							echo "<td width=70>%</td>";
							echo "<td width=70>Nro</td>";
							echo "<td width=70>%</td>";
							echo "<td width=70>Nro</td>";
							echo "<td width=70>%</td>";
							echo "<td width=70>Nro</td>";
							echo "<td width=70>%</td>";
						echo "</tr>";		

						$flag = 0;

						while($categoriza = mysql_fetch_array($query))
						{
						
							if ($cod_servicio <> $categoriza['cod_servicio'] and $flag == 1)
							{
									
								$total_s = $tot_s_altas+$tot_s_defun+$tot_s_o_egr;

								echo "<tr align='right'>";
								echo "<td align='left'> ".$servicio." </td>";
								echo "<td> ".$tot_s_altas." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_s_altas*100)/$total_s)." % </td>";
								echo "<td> ".$tot_s_defun." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_s_defun*100)/$total_s)." % </td>";
								echo "<td> ".$tot_s_o_egr." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_s_o_egr*100)/$total_s)." % </td>";
								echo "<td> ".$total_s." </td>";
								echo "<td> ".$tot_s_c_inf." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_s_c_inf*100)/$total_s)." % </td>";
								echo "</tr>";		
								
								$tot_altas = $tot_altas + $tot_s_altas;
								$tot_defun = $tot_defun + $tot_s_defun;
								$tot_o_egr = $tot_o_egr + $tot_s_o_egr;
								$tot_c_inf = $tot_c_inf + $tot_s_c_inf;
								$total = $total + $total_s;
						
								$tot_s_altas = 0;
								$tot_s_defun = 0;
								$tot_s_o_egr = 0;
								$tot_s_c_inf = 0;
								$total_s = 0;
						
							}
						
							$flag = 1;
							
							
							
							$cod_servicio = $categoriza['cod_servicio'];
							$servicio = $categoriza['servicio'];
						
							if ($categoriza['info_egreso'] == 0)	{ $tot_s_c_inf++; }
							
							switch ($categoriza['cod_destino']) {
								case '101':
									$tot_s_altas++;
									break;
								case '102':
									$tot_s_defun++;
									break;
								default:
									$tot_s_o_egr++;
									break;
							}
				
						}

						
						$total_s = $tot_s_altas+$tot_s_defun+$tot_s_o_egr;
						
						echo "<tr align='right'>";
						echo "<td align='left'> ".$servicio." </td>";
						if ($total_s <> 0)
						{
							echo "<td> ".$tot_s_altas." </td>";
							echo "<td> ".redondear_dos_decimal(($tot_s_altas*100)/$total_s)." % </td>";
							echo "<td> ".$tot_s_defun." </td>";
							echo "<td> ".redondear_dos_decimal(($tot_s_defun*100)/$total_s)." % </td>";
							echo "<td> ".$tot_s_o_egr." </td>";
							echo "<td> ".redondear_dos_decimal(($tot_s_o_egr*100)/$total_s)." % </td>";
							echo "<td> ".$total_s." </td>";
							echo "<td> ".$tot_s_c_inf." </td>";
							echo "<td> ".redondear_dos_decimal(($tot_s_c_inf*100)/$total_s)." % </td>";
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
						}
						echo "</tr>";		

						$tot_altas = $tot_altas + $tot_s_altas;
						$tot_defun = $tot_defun + $tot_s_defun;
						$tot_o_egr = $tot_o_egr + $tot_s_o_egr;
						$tot_c_inf = $tot_c_inf + $tot_s_c_inf;
						$total = $total + $total_s;


						echo "<tr align='right'>";
							if ($total <> 0)
							{
								echo "<td align='left'> TOTALES </td>";
								echo "<td> ".$tot_altas." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_altas*100)/$total)." % </td>";
								echo "<td> ".$tot_defun." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_defun*100)/$total)." % </td>";
								echo "<td> ".$tot_o_egr." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_o_egr*100)/$total)." % </td>";
								echo "<td> ".$total." </td>";
								echo "<td> ".$tot_c_inf." </td>";
								echo "<td> ".redondear_dos_decimal(($tot_c_inf*100)/$total)." % </td>";
							}
							else
							{
								echo "<td align='left'> TOTALES </td>";
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
 case 5:
 // Variables
$cont_medicina_si = 0;
$cont_medicina_no = 0;
$cont_oncologia_si = 0;
$cont_oncologia_no = 0;
$cont_cirugia_si = 0;
$cont_cirugia_no = 0;
$cont_cirugia_ais_si = 0;
$cont_cirugia_ais_no = 0;
$cont_traumatologia_si = 0;
$cont_traumatologia_no = 0;
$cont_UCI_si = 0;
$cont_UCI_no = 0;
$cont_SAI_si = 0;
$cont_SAI_no = 0;
$cont_partos_si = 0;
$cont_partos_no = 0;
$cont_pediatria_si = 0;
$cont_pediatria_no = 0; 
$cont_neonatologia_si = 0;
$cont_neonatologia_no = 0; 
$cont_psiquiatria_si = 0;
$cont_psiquiatria_no = 0;
$cont_CMI_si = 0;
$cont_CMI_no = 0; 
$cont_6to_piso_si = 0; 
$cont_6to_piso_no = 0; 
$cont_puerperio_si = 0;
$cont_puerperio_no = 0;
$cont_ginecologia_si = 0;
$cont_ginecologia_no = 0;
$cont_embarazo_si = 0;
$cont_embarazo_no = 0;
$cont_pensionado_si = 0;
$cont_pensionado_no = 0;

$cont_medicina_barthel = 0;
$cont_oncologia_barthel = 0;
$cont_cirugia_barthel = 0;
$cont_cirugia_ais_barthel = 0;
$cont_traumatologia_barthel = 0;
$cont_UCI_barthel = 0;
$cont_SAI_barthel = 0;
$cont_partos_barthel = 0;
$cont_psiquiatria_barthel = 0;
$cont_CMI_barthel = 0;
$cont_6to_piso_barthel = 0; 
$cont_puerperio_barthel = 0;
$cont_ginecologia_barthel = 0;
$cont_embarazo_barthel = 0;
$cont_pensionado_barthel = 0;

$cont_medicina_barthel_corr = 0;
$cont_oncologia_barthel_corr = 0;
$cont_cirugia_barthel_corr = 0;
$cont_cirugia_ais_barthel_corr = 0;
$cont_traumatologia_barthel_corr = 0;
$cont_UCI_barthel_corr = 0;
$cont_SAI_barthel_corr = 0;
$cont_partos_barthel_corr = 0;
$cont_psiquiatria_barthel_corr = 0;
$cont_CMI_barthel_corr = 0;
$cont_6to_piso_barthel_corr = 0; 
$cont_puerperio_barthel_corr = 0;
$cont_ginecologia_barthel_corr = 0;
$cont_embarazo_barthel_corr = 0;
$cont_pensionado_barthel_corr = 0;



if($act == 1){
	$fechainicio = cambiarFormatoFecha2($fechaD1);
	$fechahasta = cambiarFormatoFecha2($fechaH1);
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');  // Reporte Pabellon

	 	 $sql = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisisenf.epienfEstado) AS ESTADO,
IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS PERSONAL,
epicrisis.epicrisisenf.epienfBarthel,
epicrisis.epicrisisenf.epienfCond
FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.cta_cte = camas.hospitalizaciones.cta_cte
WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
		AND camas.hospitalizaciones.tipo_traslado > 100
		#AND camas.hospitalizaciones.tipo_traslado <> 107
		ORDER BY  camas.hospitalizaciones.fecha_egreso, SERVICIO  ASC";


	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql<br><br>".mysql_error());
	$rows= mysql_num_rows($query);	
	
	$sql_medicina = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 1
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_medicina = mysql_query($sql_medicina) or die("Error<br>$sql_medicina<br><br>".mysql_error());
	$rows_medicina = mysql_num_rows($query_medicina);
	if($rows_medicina){
		while($arr_medicina = mysql_fetch_array($query_medicina)){
			$medicina = $arr_medicina['servicio'];
			if($arr_medicina['IDEPICRISIS']){ $cont_medicina_si++; }
			if(!$arr_medicina['IDEPICRISIS']){ $cont_medicina_no++; }
			if($arr_medicina['epienfBarthel']){ $cont_medicina_barthel++;}
			if($arr_medicina['edad_paciente']>=60){ $cont_medicina_barthel_corr++; }
			
		}
	$por_medicina_si =  (($cont_medicina_si * 100)/($rows_medicina)); 	
	$por_medicina_no =  (($cont_medicina_no * 100)/($rows_medicina));
	}
	$sql_oncologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	
		IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 2
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_oncologia = mysql_query($sql_oncologia) or die("Error<br>$sql_oncologia<br><br>".mysql_error());
	$rows_oncologia = mysql_num_rows($query_oncologia);
	if($rows_oncologia){
		while($arr_oncologia = mysql_fetch_array($query_oncologia)){
			$oncologia = $arr_oncologia['servicio'];
			if($arr_oncologia['IDEPICRISIS']){ $cont_oncologia_si++; }
			if(!$arr_oncologia['IDEPICRISIS']){ $cont_oncologia_no++; }
			if($arr_oncologia['epienfBarthel']){ $cont_oncologia_barthel++; }
			if($arr_oncologia['edad_paciente']>=60){ $cont_oncologia_barthel_corr++; }
		}
	$por_oncologia_si =  (($cont_oncologia_si * 100)/($rows_oncologia));
	$por_oncologia_no =  (($cont_oncologia_no * 100)/($rows_oncologia));
	}
	$sql_cirugia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	
		IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 3
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia = mysql_query($sql_cirugia) or die("Error<br>$sql_cirugia<br><br>".mysql_error());
	$rows_cirugia = mysql_num_rows($query_cirugia);
	if($rows_cirugia){
		while($arr_cirugia = mysql_fetch_array($query_cirugia)){
			$cirugia = $arr_cirugia['servicio'];
			if($arr_cirugia['IDEPICRISIS']){ $cont_cirugia_si++; }
			if($arr_cirugia['epienfBarthel']){ $cont_cirugia_barthel++; }
			if($arr_cirugia['edad_paciente']>=60){ $cont_cirugia_barthel_corr++; }
			if(!$arr_cirugia['IDEPICRISIS']){ $cont_cirugia_no++; }
		}
		$por_cirugia_si =  (($cont_cirugia_si * 100)/($rows_cirugia));
		$por_cirugia_no =  (($cont_cirugia_no * 100)/($rows_cirugia)); 
	}
	$sql_cirugia_ais = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 4
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia_ais = mysql_query($sql_cirugia_ais) or die("Error<br>$sql_cirugia_ais<br><br>".mysql_error());
	$rows_cirugia_ais = mysql_num_rows($query_cirugia_ais);
	if($rows_cirugia_ais){
		while($arr_cirugia_ais = mysql_fetch_array($query_cirugia_ais)){
			$cirugia_ais = $arr_cirugia_ais['servicio'];
			if($arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_si++; }
			if($arr_cirugia_ais['epienfBarthel']){ $cont_cirugia_ais_barthel++; }
			if($arr_cirugia_ais['edad_paciente']>=60){ $cont_cirugia_ais_barthel_corr++; }
			if(!$arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_no++; }
		}
	$por_cirugia_ais_si =  (($cont_cirugia_ais_si * 100)/($rows_cirugia_ais)); 
	}
	$sql_traumatologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,

	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 5
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");

	$query_traumatologia = mysql_query($sql_traumatologia) or die("Error<br>$sql_traumatologia<br><br>".mysql_error());
	$rows_traumatologia = mysql_num_rows($query_traumatologia);
	if($rows_traumatologia){
		while($arr_traumatologia = mysql_fetch_array($query_traumatologia)){
			$traumatologia = $arr_traumatologia['servicio'];
			if($arr_traumatologia['IDEPICRISIS']){  $cont_traumatologia_si++; }
			if($arr_traumatologia['epienfBarthel']){ $cont_traumatologia_barthel++; }
			if($arr_traumatologia['edad_paciente']>=60){ $cont_traumatologia_barthel_corr++; }
			if(!$arr_traumatologia['IDEPICRISIS']){ $cont_traumatologia_no++; }
		}
		$por_traumatologia_si =  (($cont_traumatologia_si * 100)/($rows_traumatologia));
	}
	$sql_UCI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 8
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_UCI = mysql_query($sql_UCI) or die("Error<br>$sql_UCI<br><br>".mysql_error());
	$rows_UCI = mysql_num_rows($query_UCI);
	if($rows_UCI){
		while($arr_UCI = mysql_fetch_array($query_UCI)){
			$UCI = $arr_UCI['servicio'];
			if($arr_UCI['IDEPICRISIS']){  $cont_UCI_si++; }
			if($arr_UCI['epienfBarthel']){ $cont_UCI_barthel++; }
			if($arr_UCI['edad_paciente']>=60){ $cont_UCI_barthel_corr++; }
			if(!$arr_UCI['IDEPICRISIS']){ $cont_UCI_no++; }
		}
		$por_UCI_si =  (($cont_UCI_si * 100)/($rows_UCI));
		$por_UCI_no =  (($cont_UCI_no * 100)/($rows_UCI));
	}
	$sql_SAI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 9
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_SAI = mysql_query($sql_SAI) or die("Error<br>$sql_SAI<br><br>".mysql_error());
	$rows_SAI = mysql_num_rows($query_SAI);
	if($rows_SAI){
		while($arr_SAI = mysql_fetch_array($query_SAI)){
			$SAI = $arr_SAI['servicio'];
			if($arr_SAI['IDEPICRISIS']){  $cont_SAI_si++; }
			if($arr_SAI['epienfBarthel']){ $cont_SAI_barthel++; }
			if($arr_SAI['edad_paciente']>=60){ $cont_SAI_barthel_corr++; }
			if(!$arr_SAI['IDEPICRISIS']){ $cont_SAI_no++; }
		}
		$por_SAI_si =  (($cont_SAI_si * 100)/($rows_SAI));
	}
	$sql_partos = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
		CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 45
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_partos = mysql_query($sql_partos) or die("Error<br>$sql_partos<br><br>".mysql_error());
	$rows_partos = mysql_num_rows($query_partos);
	if($rows_partos){
		while($arr_partos = mysql_fetch_array($query_partos)){
			$partos = $arr_partos['servicio'];
			if($arr_partos['IDEPICRISIS']){  $cont_partos_si++; }
			if($arr_partos['epienfBarthel']){ $cont_partos_barthel++; }
			if($arr_partos['edad_paciente']>=60){ $cont_partos_barthel_corr++; }
			if(!$arr_partos['IDEPICRISIS']){ $cont_partos_no++; }
		}
	$por_partos_si =  (($cont_partos_si * 100)/($rows_partos));
	}
	
	$sql_pediatria = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,

	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 7
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pediatria = mysql_query($sql_pediatria) or die("Error<br>$sql_pediatria<br><br>".mysql_error());
	$rows_pediatria = mysql_num_rows($query_pediatria);
	if($rows_pediatria){
		while($arr_pediatria = mysql_fetch_array($query_pediatria)){
			$pediatria = $arr_pediatria['servicio'];
			if($arr_pediatria['ENFERMERA']){  $cont_pediatria_si++; }
			if(!$arr_pediatria['ENFERMERA']){ $cont_pediatria_no++; }
		}
	$por_pediatria_si =  (($cont_pediatria_si * 100)/($rows_pediatria));
	}
	
	$sql_neonatologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,

	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_neonatologia = mysql_query($sql_neonatologia) or die("Error<br>$sql_neonatologia<br><br>".mysql_error());
	$rows_neonatologia = mysql_num_rows($query_neonatologia);
	if($rows_neonatologia){
		while($arr_neonatologia = mysql_fetch_array($query_neonatologia)){
			$neonatologia = $arr_neonatologia['servicio'];
			if($arr_neonatologia['ENFERMERA']){  $cont_neonatologia_si++; }
			if(!$arr_neonatologia['ENFERMERA']){ $cont_neonatologia_no++; }
		}
	$por_neonatologia_si =  (($cont_neonatologia_si * 100)/($rows_neonatologia));
	}
	
	$sql_psiquiatria = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte

	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 12
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_psiquiatria = mysql_query($sql_psiquiatria) or die("Error<br>$sql_psiquiatria<br><br>".mysql_error());
	$rows_psiquiatria = mysql_num_rows($query_psiquiatria);
	if($rows_psiquiatria){
		while($arr_psiquiatria = mysql_fetch_array($query_psiquiatria)){
			$psiquiatria = $arr_psiquiatria['servicio'];
			if($arr_psiquiatria['IDEPICRISIS']){  $cont_psiquiatria_si++; }
			if($arr_psiquiatria['epienfBarthel']){ $cont_psiquiatria_barthel++; }
			if($arr_psiquiatria_corr['edad_paciente']>=60){ $cont_psiquiatria_barthel_corr++; }
			if(!$arr_psiquiatria['IDEPICRISIS']){ $cont_psiquiatria_no++; }
		}
	$por_psiquiatria_si =  (($cont_psiquiatria_si * 100)/($rows_psiquiatria));
	}
	
	$sql_CMI = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14)  AND (camas.hospitalizaciones.nomSalaSN = 'CMI 3')
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_CMI = mysql_query($sql_CMI) or die("Error<br>$sql_CMI<br><br>".mysql_error());
	$rows_CMI = mysql_num_rows($query_CMI);
	if($rows_CMI){
		while($arr_CMI = mysql_fetch_array($query_CMI)){
			$CMI = $arr_CMI['servicio'];
			if($arr_CMI['IDEPICRISIS']){  $cont_CMI_si++; }
			if($arr_CMI['epienfBarthel']){ $cont_CMI_barthel++; }
			if($arr_CMI['edad_paciente']>=60){ $cont_CMI_barthel_corr++; }
			if(!$arr_CMI['IDEPICRISIS']){ $cont_CMI_no++; }
		}
	$por_CMI_si =  (($cont_CMI_si * 100)/($rows_CMI));
	}
	
	$sql_6to_piso = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisisenf.epienfEstado,
	IF(epicrisis.epicrisisenf.epienfEstado = 1,epicrisis.epicrisisenf.epienfEnfermera,epicrisis.epicrisismatrona.epimatMatrona) AS ENFERMERA,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_6to_piso = mysql_query($sql_6to_piso) or die("Error<br>$sql_6to_piso<br><br>".mysql_error());
	$rows_6to_piso = mysql_num_rows($query_6to_piso);
	if($rows_6to_piso){
		while($arr_6to_piso = mysql_fetch_array($query_6to_piso)){
			$sexto_piso = $arr_6to_piso['servicio'];
			if($arr_6to_piso['IDEPICRISIS']){  $cont_6to_piso_si++; }
			if($arr_6to_piso['epienfBarthel']){ $cont_6to_piso_barthel++; }
			if($arr_6to_piso['edad_paciente']>=60){ $cont_6to_piso_barthel_corr++; }
			if(!$arr_6to_piso['IDEPICRISIS']){ $cont_6to_piso_no++; }
		}
	$por_6to_piso_si =  (($cont_6to_piso_si * 100)/($rows_6to_piso));
	}
	
	$sql_puerperio = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
	IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 11
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_puerperio = mysql_query($sql_puerperio) or die("Error<br>$sql_puerperio<br><br>".mysql_error());
	$rows_puerperio = mysql_num_rows($query_puerperio);
	if($rows_puerperio){
		while($arr_puerperio = mysql_fetch_array($query_puerperio)){
			$puerperio = $arr_puerperio['servicio'];
			if($arr_puerperio['IDEPICRISIS']){  $cont_puerperio_si++; }
			if($arr_puerperio['epienfBarthel']){ $cont_puerperio_barthel++; }
			if($arr_puerperio['edad_paciente']>=60){ $cont_puerperio_barthel_corr++; }
			if(!$arr_puerperio['IDEPICRISIS']){ $cont_puerperio_no++; }
		}
	$por_puerperio_si =  (($cont_puerperio_si * 100)/($rows_puerperio));
	}
	
	$sql_ginecologia = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 10
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_ginecologia = mysql_query($sql_ginecologia) or die("Error<br>$sql_ginecologia<br><br>".mysql_error());
	$rows_ginecologia = mysql_num_rows($query_ginecologia);
	if($rows_ginecologia){
		while($arr_ginecologia = mysql_fetch_array($query_ginecologia)){
			$ginecologia = $arr_ginecologia['servicio'];
			if($arr_ginecologia['IDEPICRISIS']){  $cont_ginecologia_si++; }
			if($arr_ginecologia['epienfBarthel']){ $cont_ginecologia_barthel++; }
			if($arr_ginecologia['edad_paciente']>=60){ $cont_ginecologia_barthel_corr++; }
			if(!$arr_ginecologia['IDEPICRISIS']){ $cont_ginecologia_no++; }
		}
	$por_ginecologia_si =  (($cont_ginecologia_si * 100)/($rows_ginecologia));
	}
	
	$sql_embarazo = "SELECT
	camas.hospitalizaciones.rut_paciente,
	camas.hospitalizaciones.nom_paciente,
	camas.hospitalizaciones.hospitalizado,
	camas.hospitalizaciones.fecha_ingreso,
	camas.hospitalizaciones.fecha_egreso,
	camas.hospitalizaciones.hora_ingreso,
	camas.hospitalizaciones.hora_egreso,
	camas.hospitalizaciones.tipo_traslado,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),CONCAT(fecha_ingreso,' ', hora_ingreso))) AS DIAS_EN_SERVICIO,
	(DATEDIFF(CONCAT(fecha_egreso,' ', hora_egreso),(hospitalizado))) AS DIAS_HOSPITALIZADO,
	camas.hospitalizaciones.cta_cte,
			IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	camas.hospitalizaciones.cod_servicio,
			CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
	camas.hospitalizaciones.ficha_paciente,
	camas.hospitalizaciones.usuario_que_egresa,
	epicrisis.epicrisismatrona.epimatEstado,
	IF(epicrisis.epicrisismatrona.epimatEstado = 1,epicrisis.epicrisismatrona.epimatMatrona, '') AS MATRONA
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 14
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_embarazo = mysql_query($sql_embarazo) or die("Error<br>$sql_embarazo<br><br>".mysql_error());
	$rows_embarazo = mysql_num_rows($query_embarazo);
	if($rows_embarazo){
		while($arr_embarazo = mysql_fetch_array($query_embarazo)){
			$puerperio = $arr_embarazo['servicio'];
			if($arr_embarazo['IDEPICRISIS']){  $cont_embarazo_si++; }
			if($arr_embarazo['epienfBarthel']){ $cont_embarazo_barthel++; }
			if($arr_embarazo['edad_paciente']>=60){ $cont_embarazo_barthel_corr++; }
			if(!$arr_embarazo['IDEPICRISIS']){ $cont_embarazo_no++; }
		}
	$por_embarazo_si =  (($cont_embarazo_si * 100)/($rows_embarazo));
	}
	//pensionado
	$sql_pensionado = "SELECT	 IF(epicrisis.epicrisisenf.epienfId IS NULL,epicrisis.epicrisismatrona.epimatId,epicrisis.epicrisisenf.epienfId) as IDEPICRISIS,
	CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
	END AS SERVICIO,
	date_format(camas.hospitalizaciones.fecha_egreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') - (date_format(camas.hospitalizaciones.fecha_egreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) AS edad_paciente,
	epicrisis.epicrisisenf.epienfBarthel
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 46
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pensionado = mysql_query($sql_pensionado) or die("Error<br>$sql_pensionado<br><br>".mysql_error());
	$rows_pensionado = mysql_num_rows($query_pensionado);
	if($rows_pensionado){
		while($arr_pensionado = mysql_fetch_array($query_pensionado)){
			$pensionado = $arr_pensionado['SERVICIO'];
			if($arr_pensionado['IDEPICRISIS']){  $cont_pensionado_si++; }
			if($arr_pensionado['epienfBarthel']){ $cont_pensionado_barthel++; }
			if($arr_pensionado['edad_paciente']>=60){ $cont_pensionado_barthel_corr++; }
			if(!$arr_pensionado['IDEPICRISIS']){ $cont_pensionado_no++; }
		}
	$por_pensionado_si =  (($cont_pensionado_si * 100)/($rows_pensionado));
	}
	
		$total_hospital = ($rows_medicina + $rows_oncologia + $rows_cirugia + $rows_cirugia_ais + $rows_traumatologia + $rows_UCI + $rows_SAI + $rows_partos + $rows_pediatria + $rows_neonatologia +$rows_psiquiatria + $rows_CMI + $rows_6to_piso + $rows_puerperio + $rows_ginecologia + $rows_embarazo + $rows_pensionado);
		$total_epi = ($cont_medicina_si + $cont_oncologia_si + $cont_cirugia_si + $cont_cirugia_ais_si + $cont_traumatologia_si + $cont_UCI_si + $cont_SAI_si + $cont_partos_si + $cont_pediatria_si + $cont_neonatologia_si + $cont_psiquiatria_si + $cont_CMI_si + $cont_6to_piso_si + $cont_puerperio_si + $cont_ginecologia_si + $cont_embarazo_si + $cont_pensionado_si );
		$por_cumplimiento =  @(($total_epi * 100)/($total_hospital));
}

 include('../reportes/Reporte_Epi.php');
	break;		
case 6:
 // Variables
$cont_medicina_si = 0;
$cont_medicina_no = 0;
$cont_oncologia_si = 0;
$cont_oncologia_no = 0;
$cont_cirugia_si = 0;
$cont_cirugia_no = 0;
$cont_cirugia_ais_si = 0;
$cont_cirugia_ais_no = 0;
$cont_traumatologia_si = 0;
$cont_traumatologia_no = 0;
$cont_UCI_si = 0;
$cont_UCI_no = 0;
$cont_SAI_si = 0;
$cont_SAI_no = 0;
$cont_partos_si = 0;
$cont_partos_no = 0;
$cont_pediatria_si = 0;
$cont_pediatria_no = 0; 
$cont_neonatologia_si = 0;
$cont_neonatologia_no = 0; 
$cont_psiquiatria_si = 0;
$cont_psiquiatria_no = 0;
$cont_CMI_si = 0;
$cont_CMI_no = 0; 
$cont_6to_piso_si = 0; 
$cont_6to_piso_no = 0; 
$cont_puerperio_si = 0;
$cont_puerperio_no = 0;
$cont_ginecologia_si = 0;
$cont_ginecologia_no = 0;
$cont_embarazo_si = 0;
$cont_embarazo_no = 0;
$cont_pensionado_si = 0;
$cont_pensionado_no = 0;




if($act == 2){
	$fechainicio = cambiarFormatoFecha2($fechaD1);
	$fechahasta = cambiarFormatoFecha2($fechaH1);
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');  // Reporte Pabellon

	 	 $sql = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
		AND camas.hospitalizaciones.tipo_traslado > 100
		#AND camas.hospitalizaciones.tipo_traslado <> 107
		ORDER BY  camas.hospitalizaciones.fecha_egreso, SERVICIO  ASC";
	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql<br><br>".mysql_error());
	$rows= mysql_num_rows($query);	
	
	$sql_medicina = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 1
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_medicina = mysql_query($sql_medicina) or die("Error<br>$sql_medicina<br><br>".mysql_error());
	$rows_medicina = mysql_num_rows($query_medicina);
	if($rows_medicina){
		while($arr_medicina = mysql_fetch_array($query_medicina)){
			$medicina = $arr_medicina['servicio'];
			if($arr_medicina['IDEPICRISIS']){ $cont_medicina_si++; }
			if(!$arr_medicina['IDEPICRISIS']){ $cont_medicina_no++; }
		}
	$por_medicina_si =  (($cont_medicina_si * 100)/($rows_medicina)); 	
	$por_medicina_no =  (($cont_medicina_no * 100)/($rows_medicina));
	}
	$sql_oncologia = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 2
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_oncologia = mysql_query($sql_oncologia) or die("Error<br>$sql_oncologia<br><br>".mysql_error());
	$rows_oncologia = mysql_num_rows($query_oncologia);
	if($rows_oncologia){
		while($arr_oncologia = mysql_fetch_array($query_oncologia)){
			$oncologia = $arr_oncologia['servicio'];
			if($arr_oncologia['IDEPICRISIS']){ $cont_oncologia_si++; }
			if(!$arr_oncologia['IDEPICRISIS']){ $cont_oncologia_no++; }
		}
	$por_oncologia_si =  (($cont_oncologia_si * 100)/($rows_oncologia));
	$por_oncologia_no =  (($cont_oncologia_no * 100)/($rows_oncologia));
	}
	$sql_cirugia = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 3
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia = mysql_query($sql_cirugia) or die("Error<br>$sql_cirugia<br><br>".mysql_error());
	$rows_cirugia = mysql_num_rows($query_cirugia);
	if($rows_cirugia){
		while($arr_cirugia = mysql_fetch_array($query_cirugia)){
			$cirugia = $arr_cirugia['servicio'];
			if($arr_cirugia['IDEPICRISIS']){ $cont_cirugia_si++; }
			if(!$arr_cirugia['IDEPICRISIS']){ $cont_cirugia_no++; }
		}
		$por_cirugia_si =  (($cont_cirugia_si * 100)/($rows_cirugia));
		$por_cirugia_no =  (($cont_cirugia_no * 100)/($rows_cirugia)); 
	}
	$sql_cirugia_ais = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 4
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_cirugia_ais = mysql_query($sql_cirugia_ais) or die("Error<br>$sql_cirugia_ais<br><br>".mysql_error());
	$rows_cirugia_ais = mysql_num_rows($query_cirugia_ais);
	if($rows_cirugia_ais){
		while($arr_cirugia_ais = mysql_fetch_array($query_cirugia_ais)){
			$cirugia_ais = $arr_cirugia_ais['servicio'];
			if($arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_si++; }
			if(!$arr_cirugia_ais['IDEPICRISIS']){ $cont_cirugia_ais_no++; }
		}
	$por_cirugia_ais_si =  (($cont_cirugia_ais_si * 100)/($rows_cirugia_ais)); 
	}
	$sql_traumatologia = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 5
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");

	$query_traumatologia = mysql_query($sql_traumatologia) or die("Error<br>$sql_traumatologia<br><br>".mysql_error());
	$rows_traumatologia = mysql_num_rows($query_traumatologia);
	if($rows_traumatologia){
		while($arr_traumatologia = mysql_fetch_array($query_traumatologia)){
			$traumatologia = $arr_traumatologia['servicio'];
			if($arr_traumatologia['IDEPICRISIS']){  $cont_traumatologia_si++; }
			if(!$arr_traumatologia['IDEPICRISIS']){ $cont_traumatologia_no++; }
		}
		$por_traumatologia_si =  (($cont_traumatologia_si * 100)/($rows_traumatologia));
	}
	$sql_UCI = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 8
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_UCI = mysql_query($sql_UCI) or die("Error<br>$sql_UCI<br><br>".mysql_error());
	$rows_UCI = mysql_num_rows($query_UCI);
	if($rows_UCI){
		while($arr_UCI = mysql_fetch_array($query_UCI)){
			$UCI = $arr_UCI['servicio'];
			if($arr_UCI['IDEPICRISIS']){  $cont_UCI_si++; }
			if(!$arr_UCI['IDEPICRISIS']){ $cont_UCI_no++; }
		}
		$por_UCI_si =  (($cont_UCI_si * 100)/($rows_UCI));
		$por_UCI_no =  (($cont_UCI_no * 100)/($rows_UCI));
	}
	$sql_SAI = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 9
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_SAI = mysql_query($sql_SAI) or die("Error<br>$sql_SAI<br><br>".mysql_error());
	$rows_SAI = mysql_num_rows($query_SAI);
	if($rows_SAI){
		while($arr_SAI = mysql_fetch_array($query_SAI)){
			$SAI = $arr_SAI['servicio'];
			if($arr_SAI['IDEPICRISIS']){  $cont_SAI_si++; }
			if(!$arr_SAI['IDEPICRISIS']){ $cont_SAI_no++; }
		}
		$por_SAI_si =  (($cont_SAI_si * 100)/($rows_SAI));
	}
	$sql_partos = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 45
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_partos = mysql_query($sql_partos) or die("Error<br>$sql_partos<br><br>".mysql_error());
	$rows_partos = mysql_num_rows($query_partos);
	if($rows_partos){
		while($arr_partos = mysql_fetch_array($query_partos)){
			$partos = $arr_partos['servicio'];
			if($arr_partos['IDEPICRISIS']){  $cont_partos_si++; }
			if(!$arr_partos['IDEPICRISIS']){ $cont_partos_no++; }
		}
	$por_partos_si =  (($cont_partos_si * 100)/($rows_partos));
	}
	
	 $sql_pediatria = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 7
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pediatria = mysql_query($sql_pediatria) or die("Error<br>$sql_pediatria<br><br>".mysql_error());
	$rows_pediatria = mysql_num_rows($query_pediatria);
	if($rows_pediatria){
		while($arr_pediatria = mysql_fetch_array($query_pediatria)){
			$pediatria = $arr_pediatria['servicio'];
			if($arr_pediatria['ENFERMERA']){  $cont_pediatria_si++; }
			if(!$arr_pediatria['ENFERMERA']){ $cont_pediatria_no++; }
		}
	$por_pediatria_si =  (($cont_pediatria_si * 100)/($rows_pediatria));
	}
	
	$sql_neonatologia = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_neonatologia = mysql_query($sql_neonatologia) or die("Error<br>$sql_neonatologia<br><br>".mysql_error());
	$rows_neonatologia = mysql_num_rows($query_neonatologia);
	if($rows_neonatologia){
		while($arr_neonatologia = mysql_fetch_array($query_neonatologia)){
			$neonatologia = $arr_neonatologia['servicio'];
			if($arr_neonatologia['ENFERMERA']){  $cont_neonatologia_si++; }
			if(!$arr_neonatologia['ENFERMERA']){ $cont_neonatologia_no++; }
		}
	$por_neonatologia_si =  (($cont_neonatologia_si * 100)/($rows_neonatologia));
	}
	
	$sql_psiquiatria = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 12
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_psiquiatria = mysql_query($sql_psiquiatria) or die("Error<br>$sql_psiquiatria<br><br>".mysql_error());
	$rows_psiquiatria = mysql_num_rows($query_psiquiatria);
	if($rows_psiquiatria){
		while($arr_psiquiatria = mysql_fetch_array($query_psiquiatria)){
			$psiquiatria = $arr_psiquiatria['servicio'];
			if($arr_psiquiatria['IDEPICRISIS']){  $cont_psiquiatria_si++; }
			if(!$arr_psiquiatria['IDEPICRISIS']){ $cont_psiquiatria_no++; }
		}
	$por_psiquiatria_si =  (($cont_psiquiatria_si * 100)/($rows_psiquiatria));
	}
	
	$sql_CMI = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14)  AND (camas.hospitalizaciones.nomSalaSN = 'CMI 3')
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_CMI = mysql_query($sql_CMI) or die("Error<br>$sql_CMI<br><br>".mysql_error());
	$rows_CMI = mysql_num_rows($query_CMI);
	if($rows_CMI){
		while($arr_CMI = mysql_fetch_array($query_CMI)){
			$CMI = $arr_CMI['servicio'];
			if($arr_CMI['IDEPICRISIS']){  $cont_CMI_si++; }
			if(!$arr_CMI['IDEPICRISIS']){ $cont_CMI_no++; }
		}
	$por_CMI_si =  (($cont_CMI_si * 100)/($rows_CMI));
	}
	
	$sql_6to_piso = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.camaSN = 'S'
	AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_6to_piso = mysql_query($sql_6to_piso) or die("Error<br>$sql_6to_piso<br><br>".mysql_error());
	$rows_6to_piso = mysql_num_rows($query_6to_piso);
	if($rows_6to_piso){
		while($arr_6to_piso = mysql_fetch_array($query_6to_piso)){
			$sexto_piso = $arr_6to_piso['servicio'];
			if($arr_6to_piso['IDEPICRISIS']){  $cont_6to_piso_si++; }
			if(!$arr_6to_piso['IDEPICRISIS']){ $cont_6to_piso_no++; }
		}
	$por_6to_piso_si =  (($cont_6to_piso_si * 100)/($rows_6to_piso));
	}
	
	$sql_puerperio = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 11
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_puerperio = mysql_query($sql_puerperio) or die("Error<br>$sql_puerperio<br><br>".mysql_error());
	$rows_puerperio = mysql_num_rows($query_puerperio);
	if($rows_puerperio){
		while($arr_puerperio = mysql_fetch_array($query_puerperio)){
			$puerperio = $arr_puerperio['servicio'];
			if($arr_puerperio['IDEPICRISIS']){  $cont_puerperio_si++; }
			if(!$arr_puerperio['IDEPICRISIS']){ $cont_puerperio_no++; }
		}
	$por_puerperio_si =  (($cont_puerperio_si * 100)/($rows_puerperio));
	}
	
	$sql_ginecologia = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 10
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_ginecologia = mysql_query($sql_ginecologia) or die("Error<br>$sql_ginecologia<br><br>".mysql_error());
	$rows_ginecologia = mysql_num_rows($query_ginecologia);
	if($rows_ginecologia){
		while($arr_ginecologia = mysql_fetch_array($query_ginecologia)){
			$ginecologia = $arr_ginecologia['servicio'];
			if($arr_ginecologia['IDEPICRISIS']){  $cont_ginecologia_si++; }
			if(!$arr_ginecologia['IDEPICRISIS']){ $cont_ginecologia_no++; }
		}
	$por_ginecologia_si =  (($cont_ginecologia_si * 100)/($rows_ginecologia));
	}
	
	$sql_embarazo = "SELECT
camas.hospitalizaciones.rut_paciente,
camas.hospitalizaciones.nom_paciente,
camas.hospitalizaciones.hospitalizado,
camas.hospitalizaciones.fecha_ingreso,
camas.hospitalizaciones.fecha_egreso,
camas.hospitalizaciones.hora_ingreso,
camas.hospitalizaciones.hora_egreso,
camas.hospitalizaciones.tipo_traslado,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),CONCAT(camas.hospitalizaciones.fecha_ingreso,' ', camas.hospitalizaciones.hora_ingreso))) AS DIAS_EN_SERVICIO,
(DATEDIFF(CONCAT(camas.hospitalizaciones.fecha_egreso,' ', camas.hospitalizaciones.hora_egreso),(camas.hospitalizaciones.hospitalizado))) AS DIAS_HOSPITALIZADO,
camas.hospitalizaciones.cta_cte,
(epicrisis.epicrisismedica.epimedId) AS IDEPICRISIS,
camas.hospitalizaciones.cod_servicio,
CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIO,
camas.hospitalizaciones.ficha_paciente,
IF(camas.hospitalizaciones.usuario_que_egresa IS NULL,pensionado.hospitalizaciones.usuario_que_egresa,camas.hospitalizaciones.usuario_que_egresa) AS usuario_que_egresa,
IF(epicrisis.epicrisismedica.epimedId IS NULL,epicrisis.epicrisismatrona.epimatEstado,epicrisis.epicrisismedica.epimedEstado) AS ESTADO,
(epicrisis.epicrisismedica.epimedMedico) AS PERSONAL

FROM
camas.hospitalizaciones
LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
LEFT JOIN pensionado.hospitalizaciones ON pensionado.hospitalizaciones.id_paciente = camas.hospitalizaciones.id_paciente
		WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	AND camas.hospitalizaciones.cod_servicio = 14
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_embarazo = mysql_query($sql_embarazo) or die("Error<br>$sql_embarazo<br><br>".mysql_error());
	$rows_embarazo = mysql_num_rows($query_embarazo);
	if($rows_embarazo){
		while($arr_embarazo = mysql_fetch_array($query_embarazo)){
			$puerperio = $arr_embarazo['servicio'];
			if($arr_embarazo['IDEPICRISIS']){  $cont_embarazo_si++; }
			if(!$arr_embarazo['IDEPICRISIS']){ $cont_embarazo_no++; }
		}
	$por_embarazo_si =  (($cont_embarazo_si * 100)/($rows_embarazo));
	}
	//pensionado
	$sql_pensionado = "SELECT	 (epicrisis.epicrisismedica.epimedId) as IDEPICRISIS,
	CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 3 THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 6 THEN '6to PISO'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'Pensionado' THEN 'CMI'
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN = 'CMI 3' THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
	END AS SERVICIO
	FROM camas.hospitalizaciones
	LEFT JOIN epicrisis.epicrisismedica ON epicrisis.epicrisismedica.epimedCtacte = camas.hospitalizaciones.cta_cte
	LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
	WHERE camas.hospitalizaciones.fecha_egreso BETWEEN '".$fechainicio."' AND '".$fechahasta."'
	AND camas.hospitalizaciones.tipo_traslado > 100
	AND camas.hospitalizaciones.camaSN IS NULL
	#AND camas.hospitalizaciones.tipo_traslado <> 107	
	AND camas.hospitalizaciones.cod_servicio = 46
	ORDER BY camas.hospitalizaciones.cod_servicio ASC, camas.hospitalizaciones.fecha_egreso ASC";
	mysql_query("SET NAMES 'utf8'");
	$query_pensionado = mysql_query($sql_pensionado) or die("Error<br>$sql_pensionado<br><br>".mysql_error());
	$rows_pensionado = mysql_num_rows($query_pensionado);
	if($rows_pensionado){
		while($arr_pensionado = mysql_fetch_array($query_pensionado)){
			$pensionado = $arr_pensionado['SERVICIO'];
			if($arr_pensionado['IDEPICRISIS']){  $cont_pensionado_si++; }
			if(!$arr_pensionado['IDEPICRISIS']){ $cont_pensionado_no++; }
		}
	$por_pensionado_si =  (($cont_pensionado_si * 100)/($rows_pensionado));
	}
	
		$total_hospital = ($rows_medicina + $rows_oncologia + $rows_cirugia + $rows_cirugia_ais + $rows_traumatologia + $rows_UCI + $rows_SAI + $rows_partos + $rows_pediatria + $rows_neonatologia +$rows_psiquiatria + $rows_CMI + $rows_6to_piso + $rows_puerperio + $rows_ginecologia + $rows_embarazo + $rows_pensionado);
		$total_epi = ($cont_medicina_si + $cont_oncologia_si + $cont_cirugia_si + $cont_cirugia_ais_si + $cont_traumatologia_si + $cont_UCI_si + $cont_SAI_si + $cont_partos_si + $cont_pediatria_si + $cont_neonatologia_si + $cont_psiquiatria_si + $cont_CMI_si + $cont_6to_piso_si + $cont_puerperio_si + $cont_ginecologia_si + $cont_embarazo_si + $cont_pensionado_si );
		$por_cumplimiento =  (($total_epi * 100)/($total_hospital));	
	
	
}

 include('../reportes/Reporte_Epi_Med.php');

break;
//INDICE BARTHEL
case 7:

	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');  // Reporte Pabellon

	$fechaBusca1 = cambiarFormatoFecha2($fechaD1);
	$fechaBusca1 = $fechaBusca1." 00:00:00";
	$fechaBusca2 = cambiarFormatoFecha2($fechaF1);
	$fechaBusca2 = $fechaBusca2." 23:59:59";
	
	$sql = "(SELECT 
			camas.rut_paciente, 
			camas.nom_paciente,
			camas.hospitalizado AS fecha,
			camas.barthel,
			camas.barthelegreso,
			date_format(camas.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '%Y') -
			(date_format(camas.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.camas.id_paciente), '00-%m-%d')) as edad, 
			camas.usuario_que_ingresa as usuario_ingresa,
			IF (camas.servicio is NOT NULL,'Camas','-') AS Desde, 
			camas.servicio as Servicio,
			'sin egreso' AS 'destino'
			FROM camas 
			WHERE tipo_traslado IN (1,2) AND camas.edad_paciente >= 60
			AND (hospitalizado >='$fechaBusca1' and hospitalizado <='$fechaBusca2'))
			UNION
			(SELECT 
			listasn.rutPacienteSN, 
			listasn.nomPacienteSN,
			listasn.hospitalizadoSN, 
			listasn.barthelSN,
			listasn.barthelegreso, 
			date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) AS edad, 
			NULL as usuario_ingresa,
			IF (listasn.desde_nomServSN is NOT NULL,'CMI','-') AS Desde, 
			listasn.desde_nomServSN as Servicio,
			'sin egreso' AS 'destino'
			FROM listasn 
			WHERE (listasn.hospitalizadoSN >='$fechaBusca1' and listasn.hospitalizadoSN <='$fechaBusca2') AND date_format(now(), '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '%Y') -
			(date_format(now(), '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.listasn.idPacienteSN), '00-%m-%d')) >= 60)
			UNION
			(SELECT
			camas.hospitalizaciones.rut_paciente,
			camas.hospitalizaciones.nom_paciente,
			camas.hospitalizaciones.hospitalizado,
			camas.hospitalizaciones.barthel,
			camas.hospitalizaciones.barthelegreso, 
			date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) as edad,
			camas.hospitalizaciones.usuario_que_ingresa,
			IF(hospitalizaciones.servicio is NOT NULL,'Hospitalizaciones','-') AS Desde, 
			hospitalizaciones.servicio as Servicio,
			camas.hospitalizaciones.destino
			FROM
			camas.hospitalizaciones
			LEFT JOIN epicrisis.epicrisisenf ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisisenf.epienfCtacte
			WHERE
			(camas.hospitalizaciones.hospitalizado >='$fechaBusca1' and camas.hospitalizaciones.hospitalizado <='$fechaBusca2') AND tipo_traslado>100 AND date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
			(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) >= 60)
			UNION
			(SELECT 
			pensionado.camas.rutPensio,
			pensionado.camas.nombrePensio,
			pensionado.camas.hospPensio,
			pensionado.camas.barthelPensio,
			pensionado.camas.barthelPensioEgreso,
			date_format(pensionado.camas.hospPensio, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '%Y') -
						(date_format(pensionado.camas.hospPensio, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = pensionado.camas.idPaciente), '00-%m-%d')) as edad,
			pensionado.camas.usuarioPensio,
			'Pensionado',
			'Pensionado',
			'sin egreso' AS 'destino'
			FROM pensionado.camas
			WHERE (pensionado.camas.hospPensio >='$fechaBusca1' and pensionado.camas.hospPensio <='$fechaBusca2') AND pensionado.camas.edadPensio >= 60)
			ORDER BY nom_paciente ASC";
	
	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql_barthel Ingreso<br><br>".mysql_error());
	$rows = mysql_num_rows($query);
	
	include('../reportes/Reporte_Barthel.php');
break;
case 8:

	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');  // Reporte remA03

	$fechaBusca1 = cambiarFormatoFecha2($fechaD1);
	//$fechaBusca1 = $fechaBusca1." 00:00:00";
	$fechaBusca2 = cambiarFormatoFecha2($fechaF1);
	//$fechaBusca2 = $fechaBusca2." 23:59:59";
	
	/*$sql = "select 
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '60a64Fme',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '60a64Fma',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '60a64Fem',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '60a64Mme',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '60a64Mma',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '60a64Mem',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '65a69Fme',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '65a69Fma',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '65a69Fem',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '65a69Mme',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '65a69Mma',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '65a69Mem',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '70a74Fme',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '70a74Fma',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '70a74Fem',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '70a74Mme',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '70a74Mma',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '70a74Mem',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '75a79Fme',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '75a79Fma',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '75a79Fem',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '75a79Mme',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '75a79Mma',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '75a79Mem',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '80a84Fme',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '80a84Fma',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '80a84Fem',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '80a84Mme',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '80a84Mma',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '80a84Mem',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '85a89Fme',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '85a89Fma',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '85a89Fem',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '85a89Mme',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '85a89Mma',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '85a89Mem',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '90Fme',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '90Fma',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '90Fem',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '90Mme',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '90Mma',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '90Mem'
from(
SELECT
hospitalizaciones.cta_cte as ctacte,
(select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) as 'barthel',
(select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) as 'barthelegreso',
case
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) < (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'mejoro'
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) = (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'mantubo'
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) > (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'empeoro'
END 
AS estados,
(SELECT paciente.paciente.sexo from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente) as sexo,
date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) as edad
FROM
hospitalizaciones
WHERE
(date(hospitalizaciones.hospitalizado) >='$fechaBusca1' and date(hospitalizaciones.hospitalizado) <='$fechaBusca2') 
AND tipo_traslado>100 
AND date_format(hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente), '%Y') -
	(date_format(hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente), '00-%m-%d')) >= 60) as datos
";
*/
$sql ="select 
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '60a64Fme',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '60a64Fma',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '60a64Fem',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),1,0)) as '60a64Fbasalcantidad',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),datos.ibarthelbasal,0)) as '60a64Fbasal',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '60a64Mme',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '60a64Mma',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '60a64Mem',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),1,0)) as '60a64Mbasalcantidad',
sum(if((datos.edad>=60 && datos.edad<=64) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),datos.ibarthelbasal,0)) as '60a64Mbasal',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '65a69Fme',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '65a69Fma',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '65a69Fem',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),1,0)) as '65a69Fbasalcantidad',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),datos.ibarthelbasal,0)) as '65a69Fbasal',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '65a69Mme',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '65a69Mma',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '65a69Mem',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),1,0)) as '65a69MbasalCantidad',
sum(if((datos.edad>=65 && datos.edad<=69) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL ),datos.ibarthelbasal,0)) as '65a69Mbasal',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '70a74Fme',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '70a74Fma',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '70a74Fem',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '70a74Fbasalcantidad',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '70a74Fbasal',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '70a74Mme',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '70a74Mma',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '70a74Mem',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '70a74Mbasalcantidad',
sum(if((datos.edad>=70 && datos.edad<=74) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '70a74Mbasal',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '75a79Fme',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '75a79Fma',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '75a79Fem',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '75a79Fbasalcantidad',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '75a79Fbasal',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '75a79Mme',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '75a79Mma',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '75a79Mem',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '75a79Mbasalcantidad',
sum(if((datos.edad>=75 && datos.edad<=79) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '75a79Mbasal',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '80a84Fme',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '80a84Fma',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '80a84Fem',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '80a84Fbasalcantidad',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '80a84Fbasal',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '80a84Mme',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '80a84Mma',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '80a84Mem',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '80a84Mbasalcantidad',
sum(if((datos.edad>=80 && datos.edad<=84) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '80a84Mbasal',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '85a89Fme',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '85a89Fma',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '85a89Fem',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '85a89Fbasalcantidad',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '85a89Fbasal',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '85a89Mme',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '85a89Mma',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '85a89Mem',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '85a89Mbasalcantidad',
sum(if((datos.edad>=85 && datos.edad<=89) && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '85a89Mbasal',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'mejoro',1,0)) as '90Fme',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'mantubo',1,0)) as '90Fma',
sum(if(datos.edad>=90 && datos.sexo = 'F' && estados = 'empeoro',1,0)) as '90Fem',
sum(if(datos.edad>=90 && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '90Fbasalcantidad',
sum(if(datos.edad>=90 && datos.sexo = 'F' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '90Fbasal',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'mejoro',1,0)) as '90Mme',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'mantubo',1,0)) as '90Mma',
sum(if(datos.edad>=90 && datos.sexo = 'M' && estados = 'empeoro',1,0)) as '90Mem',
sum(if(datos.edad>=90 && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),1,0)) as '90Mbasalcantidad',
sum(if(datos.edad>=90 && datos.sexo = 'M' && (datos.ibarthelbasal <> '' or datos.ibarthelbasal <> NULL),datos.ibarthelbasal,0)) as '90Mbasal'
from(
SELECT
hospitalizaciones.cta_cte as ctacte,
(select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) as 'barthel',
(select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) as 'barthelegreso',
case
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) < (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'mejoro'
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) = (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'mantubo'
when (select hospitalizaciones.barthel from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id ASC LIMIT 1) > (select hospitalizaciones.barthelegreso from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) then 'empeoro'
END 
AS estados,
(SELECT paciente.paciente.sexo from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente) as sexo,
date_format(camas.hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '%Y') -
(date_format(camas.hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = camas.hospitalizaciones.id_paciente), '00-%m-%d')) as edad,
(select if(hospitalizaciones.ibarthelbasal REGEXP '^[0-9]+$',hospitalizaciones.ibarthelbasal,'') from camas.hospitalizaciones WHERE hospitalizaciones.cta_cte = ctacte ORDER BY hospitalizaciones.id DESC LIMIT 1) as 'ibarthelbasal'
FROM
hospitalizaciones
WHERE
(date(hospitalizaciones.hospitalizado) >= '$fechaBusca1' and date(hospitalizaciones.hospitalizado) <= '$fechaBusca2') 
AND tipo_traslado>100 
AND date_format(hospitalizaciones.fecha_ingreso, '%Y') - date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente), '%Y') -
    (date_format(hospitalizaciones.fecha_ingreso, '00-%m-%d') < date_format((SELECT paciente.paciente.fechanac from paciente.paciente WHERE paciente.paciente.id = hospitalizaciones.id_paciente), '00-%m-%d')) >= 60) as datos";
	
	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql_barthel Ingreso<br><br>".mysql_error());
	$rows = mysql_num_rows($query);
	$datos = mysql_fetch_assoc($query);
	
	include('../reportes/Reporte_remA03.php');
break;
	}
	

	?>



</form>


    <tr height="10px">
    </tr><? if ($tipo_categorizacion != 5 and $tipo_categorizacion != 6 and $tipo_categorizacion != 7 and $tipo_categorizacion != 8 )
{
 ?>
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

    </tr>  <? } ?>
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

