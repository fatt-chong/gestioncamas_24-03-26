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

if ($solo_realizadas == 'on') {
	$d_compromiso = 1;
}
else {
	$d_compromiso = 0;
}



$fecha_desde_proceso = cambiarFormatoFecha($fecha_desde);
$fecha_hasta_proceso = cambiarFormatoFecha($fecha_hasta);

?>


<form method="get" action="info_pabellon.php" name="frm_info_pabellon" id="frm_info_pabellon">

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
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_farmacia.php<? echo $params; ?>" ONMOUSEOVER="change('7','m4')" ONMOUSEOUT= "change('8','m4')" name="m4"><IMG NAME="m4" SRC="img/p_menubutton4.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                <TD style="border-width: 0px;"><A ID="<#AWBID>" HREF="info_especifico.php<? echo $params; ?>" ONMOUSEOVER="change('9','m5')" ONMOUSEOUT= "change('10','m5')" name="m5"><IMG NAME="m5" SRC="img/p_menubutton5.gif" BORDER="0" vspace="0" hspace="0"></A></TD>
                </TR>
                </TABLE>
            </div>

			</td>
  		</tr>
		<tr class="noprint">
        	<td align="left" valign="bottom" height="25px" style="border-bottom-style:solid; border-color:#999; border-width:2px;">
	            &nbsp;&nbsp;<a style="font-size:14px">OCUPACION DE PABELLONES.</a>
            </td>
        </tr>

        <tr class="noprint" align="left">
            <td>
                <fieldset>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td height="15px"></td><td></td></tr>        
                    <tr>
                    	<td>
		                    <?
	                        if($d_compromiso == 1){
                		        echo "<input type='checkbox' checked name='solo_realizadas' onclick='document.frm_info_pabellon.submit()' />Solo Realizadas</td>";
        		            }
		                    else {
        		                echo "<input type='checkbox' name='solo_realizadas'  onclick='document.frm_info_pabellon.submit()' />Solo Realizadas</td>";				
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
                        <td align="center" style="font-size:18px" >INFORME OCUPACION PABELLON ( <? echo $fecha_desde; ?> AL <? echo $fecha_hasta; ?> )</td>
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


//$sql = "SELECT * FROM categorizacion where YEAR(fecha)= '".$ano_proceso."' and  MONTH(fecha)= '".$mes_proceso."' order by cod_servicio, fecha";
if($d_compromiso == 0){
	$sql = "SELECT * FROM cirugia where ciruFecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."'";
}
else {
	$sql = "SELECT * FROM cirugia where ciruFecha BETWEEN '".$fecha_desde_proceso."' AND '".$fecha_hasta_proceso."' AND estado = 'REALIZADA' order by ciruPabellon, ciruFecha, ciruHora";
}





mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('pabellon') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

		echo "<tr>";
			echo "<td>";
				echo "<fieldset><legend style='font-size:14px' >".$mes." ".$ano_proceso."</legend>";
					echo "<table border='1px' style='font-size:14px'>";
						echo "<tr align='left'>";
							echo "<td>Pabell&oacute;n</td>";
							echo "<td>Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
							echo "<td>Hora</td>";
							echo "<td>Estado</td>";
							echo "<td>Servicio</td>";
							echo "<td>Procedimiento</td>";
							echo "<td>Equipo Medico</td>";
						echo "</tr>";		

$flag = 0;


while($pabellon = mysql_fetch_array($query))
{

						echo "<tr align='left'>";
							echo "<td> ".$pabellon['ciruPabellon']." </td>";
							echo "<td align='center'> ".cambiarFormatoFecha2($pabellon['ciruFecha'])."</td>";
							echo "<td align='right'> ".$pabellon['ciruHora']."</td>";
							echo "<td align='center'> ".$pabellon['ciruEstado']." </td>";
							echo "<td> ".$pabellon['ciruServicio']." </td>";
							echo "<td> ".$pabellon['interNombre']." </td>";
							echo "<td> ".$pabellon['ciruCirujano']." / ".$pabellon['ciruAyudante']." / ".$pabellon['ciruAnestesista']."</td>";
						echo "</tr>";		


}

					echo"</table>";
				echo"</fieldset>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";

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



</div>



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



