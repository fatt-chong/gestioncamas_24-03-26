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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">


<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 


<div style="position:relative">
<form name="frmPacientes" id="frmPacientes" method="post">
<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="../../estandar/img/fondo.jpg">

		<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Consulta Estado de Pacientes.</th>

        <tr>
            <td colspan="3">
            	<fieldset>

          


<table width="800" align="center" border="0" cellspacing="0" cellpadding="0">

	<tr><td>
        <fieldset><legend>PACIENTES HOSPITALIZADOS</legend>
        <table width="750px" align="center">
        	<tr>
        		<td width="47">Paciente: </td>
                <td width="144"><input type="text" name="buscador" id="buscador" value="<? echo $buscador; ?>" /></td>
                <td width="561"><input type="button" name="buscar" value="Buscar" onclick="document.frmPacientes.action='consultapacientes.php';document.frmPacientes.submit();" /></td>
        	</tr>
            <tr>
                <td colspan="3">
			        <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
            		    <table border="2px" cellpadding="1px" cellspacing="0px">
                    		<tr valign="middle">
		                        <td width="350" align="center" bgcolor="#e8eaec">PACIENTE</td>
        		                <td width="170" align="center" bgcolor="#e8eaec">SERVICIO</td>
                		        <td width="140" align="center" bgcolor="#e8eaec">SALA</td>
                        		<td width="50" align="center" bgcolor="#e8eaec">CAMA</td>
		                    </tr>
        		        </table>
			            <div style="width:750px;height:400px;overflow:auto;">
							<?
                            include "../funciones/funciones.php";	
     
                            mysql_connect ('10.6.21.29','usuario','hospital');
                            mysql_select_db('camas') or die('Cannot select database');
                 			if($buscador){
								$condicion = " and nom_paciente like '%$buscador%' ";
								$condicion_sn = " WHERE nomPacienteSN like '%$buscador%' ";
								$condicion_PEN = " AND nombrePensio like '%$buscador%' ";
								}else{
									$condicion = "";
									$condicion_sn = "";
									$condicion_PEN = "";
									}
                            $sql = "SELECT * FROM camas WHERE (estado = 2 or estado = 4) ".$condicion." order by nom_paciente";
							$query = mysql_query($sql) or die("ERROR AL SELECCIONAR NORMAL".mysql_error());
							
							//BUSCA EN LAS CAMAS DE CMI
							$sql_SN = "SELECT *
									  FROM listasn  
									  INNER JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
									  ".$condicion_sn."
									  order by nomPacienteSN";
							
							$query_SN = mysql_query($sql_SN) or die("ERROR AL SELECCIONAR SN".mysql_error());
							
							//BUSCA EN LAS CAMAS DE PENSIONADO
							mysql_select_db('pensionado') or die('Cannot select database');
							$sql_PENSIONADO = "SELECT
												camas.idPensio,
												lista.salaPensio,
												lista.numPensio,
												camas.nombrePensio
												FROM
												camas
												INNER JOIN lista ON camas.idPensio = lista.idPensio
												WHERE
												camas.estadoPensio = 2 ".$condicion_PEN." 
												ORDER BY
												camas.nombrePensio ASC";
							
							$query_PENSIONADO = mysql_query($sql_PENSIONADO) or die("ERROR AL SELECCIONAR SN".mysql_error());
     						?>
                            <table id='table_consultapacientes' align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif" border='2px' cellpadding='1px' cellspacing='0px'>
                            <?
							while($camas = mysql_fetch_array($query)){
								$id_cama = $camas['id'];
							?>
                            <tr onClick="window.location.href='<? echo"detalleconsultapaciente.php?id_cama=$id_cama"; ?>'; ">
                                    
                                    <td width="350"><? echo $camas['nom_paciente']; ?></td>
                                    <td width="170"><? echo $camas['servicio']; ?></td>
                                    <td width="140"><? echo $camas['sala']; ?></td>
                                    <td width="50"><? echo $camas['cama']; ?></td>
									
                                </tr>
                                
                            <? }
							 while($camas_sn = mysql_fetch_array($query_SN)){
									$id_cama = $camas_sn['idListaSN'];
								?>
							<tr onClick="window.location.href='<? echo"detalleconsultapaciente.php?id_cama=$id_cama&SN=1"; ?>'; ">
                            	<td width="350"><? echo $camas_sn['nomPacienteSN']; ?></td>
                                <td width="170">INDIFERENCIADAS</td>
                                <td width="140"><? echo $camas_sn['salaCamaSN']; ?></td>
                                <td width="50"><? echo $camas_sn['nomCamaSN']; ?></td>
                            </tr>
							 
                            <? }
                            while($camas_PEN = mysql_fetch_array($query_PENSIONADO)){
								$id_cama = $camas_PEN['idPensio'];
							?>
                            <tr onClick="window.location.href='<? echo"detalleconsultapaciente.php?id_cama=$id_cama&PEN=1"; ?>'; ">
                                    
                                    <td width="350"><? echo $camas_PEN['nombrePensio']; ?></td>
                                    <td width="170">PENSIONADO</td>
                                    <td width="140"><? echo $camas_PEN['salaPensio']; ?></td>
                                    <td width="50"><? echo $camas_PEN['numPensio']; ?></td>
									
                                </tr>
                            <? } ?>
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
</form>
<script language="JavaScript">
<!--
	tigra_tables('table_consultapacientes', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
// -->
</script>

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

