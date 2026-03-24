<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header
$id_cama= $_GET['id_cama'];
$nom_paciente= $_GET['nom_paciente']; 
$id_paciente= $_GET['id_paciente'];
$rut_paciente= $_GET['rut_paciente'];
$cta_cte= $_GET['cta_cte'];
$tipodocumento = $_GET['tipodocumento'];
$doc_paciente = $_GET['doc_paciente'];
$opcion_1 = $_GET['opcion_1'];

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

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

	<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
<script language="JavaScript" src="../tablas/tigra_hints.js"></script>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<style>
		.hintsClass {
			font-family: tahoma, verdana, arial;
			font-size: 12px;
			background-color: #f0f0f0;
			color: #000000;
			border: 1px solid #808080;
			padding: 5px;
		}
	</style>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>

<?
$permisos = $_SESSION['permiso'];

include "../funciones/funciones.php";

/*
$_SESSION['MM_pro_id_cama'] = $id_cama;
$_SESSION['MM_pro_cama'] = $cama;
$_SESSION['MM_pro_sala'] = $sala;
$_SESSION['MM_pro_servicio'] = $cod_servicio;
$_SESSION['MM_pro_desc_servicio'] = $desc_servicio;
$_SESSION['MM_pro_estado'] = $estado;
*/

if ($cualtab == '')
{
	$cualtab = 0;
}


$sql = "SELECT * FROM altaprecoz where id = '".$id_cama."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$hospitalizacion = mysql_fetch_array($query);
$fecha_hospitalizacion = substr($hospitalizacion['hospitalizado'],0,10);
	
	?>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <table width="890px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Historial Cl&iacute;nico de Paciente.</th>

        <tr>
            <td background="../../estandar/img/fondo.jpg">
            	<fieldset>

					<div>

<form method="get" action="hist_clinico.php" name="frm_hist_clinico" id="frm_hist_clinico">

    <input type="hidden" name="cualtab" value="<? echo $cualtab ?>" />
    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
    <input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
    <input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
    <input type="hidden" name="rut_paciente" value="<? echo $rut_paciente ?>" />
    <input type="hidden" name="cta_cte" value="<? echo $cta_cte ?>" />
    
<!-- Aca Comienza lo Igual    -->

<fieldset>

	<div>
    	<table width="100%">
        	<tr>
            	<td>
	<?
	echo "Mostrar Historial Completo ";
	if($opcion_1 == 'on')
    {
        echo "<input type='checkbox' checked name='opcion_1' onclick='document.frm_hist_clinico.submit()' />";
    }
    else
    {
        echo "<input type='checkbox' name='opcion_1'  onclick='document.frm_hist_clinico.submit()' />";				
    }
	
	echo "</td><td align='right'>";
		
	echo "Fecha de Hospitalizaci&oacute;n = ".cambiarFormatoFecha($fecha_hospitalizacion);
	
	?>
    			</td>
            </tr>
        </table>
    </div>


	<div id="TabbedPanels1" class="TabbedPanels">
    	<ul class="TabbedPanelsTabGroup">
      		<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='0';" tabindex="0">FARMACIA</li>
   		  	<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='1';" tabindex="0">LABORATORIO</li>
   		  	<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='2';" tabindex="0">PABELLON</li>
   		  	<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='3';" tabindex="0">IMAGENOLOGIA</li>
   		  	<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='4';" tabindex="0">A. PATOLOGICA</li>
      		<li class="TabbedPanelsTab" onclick="javascript:document.getElementById('cualtab').value='5';" tabindex="0">HEMODIALISIS</li>
    	</ul>
    	<div class="TabbedPanelsContentGroup">
      		<div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="65">Codigo</td>
                                        <td width="330">Farmaco</td>
                                        <td width="65">Cantidad</td>
                                        <td width="100">U. Medida</td>
                                        <td width="100">Servcio</td>
                                        <td width="70">Fecha</td>
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='farmacia' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($id_paciente == 0)
                                        {
										    if($opcion_1 == 'on')
											{
                                            	$sql = "SELECT * FROM egresosdetalle where egreCtaCteCod = '".$cta_cte."' order by egreFecha2 DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM egresosdetalle where egreCtaCteCod = '".$cta_cte."' and egreFecha2 >= '".$fecha_hospitalizacion."' order by egreFecha2 DESC";
											}
                                        }
                                        else
                                        {
										    if($opcion_1 == 'on')
											{
	                                            $sql = "SELECT * FROM egresosdetalle where egrePacId = '".$id_paciente."' order by egreFecha2 DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM egresosdetalle where egrePacId = '".$id_paciente."' and egreFecha2 >= '".$fecha_hospitalizacion."' order by egreFecha2 DESC";
											}

                                        }
        
                                        if ($id_paciente <> 0 or $cta_cte <> 0)
                                        {
                                            //$sql = "SELECT * FROM hospitalizaciones where rut_paciente = '".$rut_paciente."'";
                                            mysql_select_db('farmacos') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            while($list_paciente = mysql_fetch_array($query2)){
                                                $id_hosp = $list_paciente['id'];
                                                ?>
                                                <tr align="left" height="25px" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
                                                    <?                
                                                    $sql = "SELECT * FROM sscc where id_rau = '".$list_paciente['egreserviCod2']."'";
                                                    mysql_select_db('camas') or die('Cannot select database');
                                                    $query = mysql_query($sql) or die(mysql_error());
                                                    $l_servicios = mysql_fetch_array($query);
                                                    $dsk_servicio = $l_servicios['servicio'];
                                                    ?>
                                                  <td width="65"><? echo $list_paciente['produCodInt']; ?>	</td>
                                                  <td width="330"><? echo $list_paciente['egreproduNombre']; ?> </td>
                                                  <td width="65" align="right"><? echo $list_paciente['egreDespachado']; ?> </td>
                                                  <td width="100"><? echo $list_paciente['egreumediCod']; ?> </td>
                                                  <td width="100"><? echo $dsk_servicio; ?>&nbsp;</td>
                                                  <td width="70"><? echo cambiarFormatoFecha(substr($list_paciente['egreFecha2'],0,10)); ; ?> </td>
                                                    <?
                                                echo"</tr>";
                                            }
                                        }
                                        ?>
			  						</table>
                                    <script language="JavaScript">
                                    <!--
                                        tigra_tables('farmacia', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                                    // -->
                                    </script>
		  						</div>
	  						</div>	
                        </td>
                    </tr>
				</table>
            
            </div>
      		
            <div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="70">N� Examen</td>
                                        <td width="230">M&eacute;dico Solicitante</td>
                                        <td width="130">Servicio</td>
                                        <td width="110">Atenci&oacute;n</td>
                                        <td width="110">Prioridad</td>
                                        <td width="80">Fecha</td>
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='laboratorio' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($rut_paciente <> 0)
                                        {
										    if($opcion_1 == 'on')
											{
                                            	$sql = "SELECT * FROM laboratorio.controllaboratorio where rut_paciente = '".$rut_paciente."' order by solicitud_examen DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM laboratorio.controllaboratorio where rut_paciente = '".$rut_paciente."' and fecha_extraccion >= '".$fecha_hospitalizacion."' order by solicitud_examen DESC";
											}

                                            mysql_select_db('paciente') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            $i_mens_todos = 0;
                                            while($list_paciente = mysql_fetch_array($query2))
                                            {
                                                $solicitud_examen = $list_paciente['solicitud_examen'];
                                                ?>
                                                <tr height="25px" onclick="window.open('../../omega/pdf/<? echo $solicitud_examen; ?>.PDF','', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=450')" onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
                                                    <td width="70"><? echo $solicitud_examen; ?> </td>
                                                    <td width="230"><? echo $list_paciente['nomb_medico']; ?> </td>
                                                    <td width="130"><? echo $list_paciente['desc_servicio']; ?> </td>
                                                    <td width="110"><? echo $list_paciente['desc_solicitante']; ?> </td>
                                                    <td width="110"><? echo $list_paciente['tipo_solicitante']; ?> </td>
                                                    <td width="80"><? echo cambiarFormatoFecha(substr($list_paciente['fecha_extraccion'],0,10)); ; ?> </td>
                                                    <?
                                                echo"</tr>";
                                                $sql = "SELECT * FROM laboratorio.prestacioneslaboratorio where solicitud_examen = '".$solicitud_examen."' ";
                                                mysql_select_db('paciente') or die('Cannot select database');
                                                $query_prestacion = mysql_query($sql) or die(mysql_error());
                                                while($list_prestacion = mysql_fetch_array($query_prestacion))
                                                {
                                                    $numero_orden = $list_prestacion['numero_orden'];
                                                    $arreglo_camas[$i_mens_todos] = $arreglo_camas[$i_mens_todos]." <b>- ".$list_prestacion['desc_prestacion']."</b> : ";
                                                    if ($list_prestacion['tipo_prueba'] == "B")
                                                    {
                                                        $sql = "SELECT * FROM laboratorio.resultadoslaboratorio where solicitud_examen = '".$solicitud_examen."' and numero_orden = '".$numero_orden."' ";
                                                        mysql_select_db('paciente') or die('Cannot select database');
                                                        $query_resultado = mysql_query($sql) or die(mysql_error());
                                                        while($list_resultado = mysql_fetch_array($query_resultado))
                                                        {
                                                            $arreglo_camas[$i_mens_todos] = $arreglo_camas[$i_mens_todos]." ".$list_resultado['resultado']." ".$list_resultado['unidades']."  ";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $arreglo_camas[$i_mens_todos] = $arreglo_camas[$i_mens_todos]." Prueba Microbiologica (Ver Resultado en Informe) ";
                                                    }
                                                        $arreglo_camas[$i_mens_todos] = $arreglo_camas[$i_mens_todos]." <br>";
                                                }
                                                $i_mens_todos++;
                                            }
                                        }
                                        ?>
			  						</table>
		  						</div>
							</div>	
                        </td>
                    </tr>
                </table>
            
            </div>
      		<div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="70">Fecha</td>
                                        <td width="50">Hora</td>
                                        <td width="55">Pabell&oacute;n</td>
                                        <td width="200">Prestaci&oacute;n</td>
                                        <td width="105">Estado</td>
                                        <td width="135">Servicio</td>
                                        <td width="105">Cirujano</td>
                                        
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='laboratorio' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($id_paciente <> 0)
                                        {
										    if($opcion_1 == 'on')
											{
	                                            $sql = "SELECT * FROM pabellon.cirugia where pacieCod = '".$id_paciente."' order by ciruFecha DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM pabellon.cirugia where pacieCod = '".$id_paciente."' and ciruFecha >= '".$fecha_hospitalizacion."' order by ciruFecha DESC";
											}

                                            mysql_select_db('pabellon') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            while($list_pabellon = mysql_fetch_array($query2))
                                            {
												$fecha = $list_pabellon['ciruFecha'];
												$hora = $list_pabellon['ciruHora'];
												$pabellon = $list_pabellon['pabCod'];
												$prestacion = $list_pabellon['ciruInter1Glosa'];
												$estado = $list_pabellon['ciruEstado'];
												
												$cd_servicio = $list_pabellon['ciruServOrigCod'];
												
												$cod_cirujano_1 = $list_pabellon['ciruCirujano1'];
												$cod_cirujano_2 = $list_pabellon['ciruCirujano2'];
												$cod_cirujano_3 = $list_pabellon['ciruCirujano3'];
												$cod_anestesista = $list_pabellon['ciruAnestesista'];
												
												$h_llegada = $list_pabellon['ciruHLlegada'];
												$h_anestesia = $list_pabellon['ciruHAnest'];
												$h_inicio = $list_pabellon['ciruHICirugia'];
												$h_termino = $list_pabellon['ciruHTCirugia'];
												$h_salida = $list_pabellon['ciruHSalida'];
												$motivo = $list_pabellon['ciruMotSuspencion'];

	                                            $sql = "SELECT * FROM servicio where idservicio = '".$cd_servicio."'";
												mysql_select_db('acceso') or die('Cannot select database');
    	                                        $query3 = mysql_query($sql) or die(mysql_error());
												$lisservicio =  mysql_fetch_array($query3);
												if ( $lisservicio ) {  $servicio = $lisservicio['nombre']; } else { $servicio = " "; }
												
	                                            $sql = "SELECT * FROM medico where id = '".$cod_cirujano_1."'";
    	                                        $query3 = mysql_query($sql) or die(mysql_error());
												$lismedico =  mysql_fetch_array($query3);
												if ( $lismedico ) {  $cirujano_1 = $lismedico['nombremedico']; } else { $cirujano_1 = " "; }
												
	                                            $sql = "SELECT * FROM medico where id = '".$cod_cirujano_2."'";
    	                                        $query3 = mysql_query($sql) or die(mysql_error());
												$lismedico =  mysql_fetch_array($query3);
												if ( $lismedico  ) {  $cirujano_2 = $lismedico['nombremedico']; } else { $cirujano_2 = " "; }
												
	                                            $sql = "SELECT * FROM medico where id = '".$cod_cirujano_3."'";
    	                                        $query3 = mysql_query($sql) or die(mysql_error());
												$lismedico =  mysql_fetch_array($query3);
												if ( $lismedico  ) {  $cirujano_3 = $lismedico['nombremedico']; } else { $cirujano_3 = " "; }
												
	                                            $sql = "SELECT * FROM medico where id = '".$cod_anestesista."'";
    	                                        $query3 = mysql_query($sql) or die(mysql_error());
												$lismedico =  mysql_fetch_array($query3);
												if ( $lismedico  ) {  $anestesista = $lismedico['nombremedico']; } else { $anestesista = " "; }
												
												
                                                ?>
                                                <tr height="25px" onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
                                                    <td width="70"><? echo cambiarFormatoFecha($fecha); ?> </td>
                                                    <td width="50"><? echo substr($hora,0,5); ?> </td>
                                                    <td width="55"><? echo $pabellon; ?> </td>
                                                    <td width="200"><? echo $prestacion; ?> </td>
                                                    <td width="105"><? echo $estado; ?> </td>
                                                    <td width="135"><? echo $servicio; ?> </td>
                                                    <td width="105"><? echo $cirujano_1; ?> </td>
                                                    <?
                                                echo"</tr>";
                                                $arreglo_camas[$i_mens_todos] = " <b>- 1er Cirujano : </b>".$cirujano_1."<br> <b>- 2er Cirujano : </b>".$cirujano_2."<br> <b>- Anestesista : </b>".$anestesista."<br> <b>- Hora Llegada : </b>".$h_llegada."<br> <b>- Hora Anestesia : </b>".$h_anestesia."<br> <b>- Hora Inicio : </b>".$h_inicio."<br> <b>- Hora Termino : </b>".$h_termino."<br> <b>- Hora Salida : </b>".$h_salida."<br>  <b>- Observacion : </b>".$motivo."<br>";

												$i_mens_todos++;
												
                                            }
                                        }
                                        ?>
			  						</table>
		  						</div>
							</div>	
                        </td>
                    </tr>
                </table>
            
            </div>
      		
            <div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="60">Codigo</td>
                                        <td width="440">Prestacion</td>
                                        <td width="30">Sala</td>
                                        <td width="140">Servcio</td>
                                        <td width="70">Fecha</td>
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='imagenologia' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($rut_paciente <> 0)
                                        {
										    if($opcion_1 == 'on')
											{
                                            	$sql = "SELECT * FROM controlrayos where rut_paciente = '".$rut_paciente."' order by fecha DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM controlrayos where rut_paciente = '".$rut_paciente."' and fecha >= '".$fecha_hospitalizacion."' order by fecha DESC";
											}

                                            mysql_select_db('paciente') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            while($list_paciente = mysql_fetch_array($query2)){
                                                $id_hosp = $list_paciente['id'];
                                                ?>
                                                <tr align="left" height="25px" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
												<td width="60"><? echo $list_paciente['prestacion']; ?>	</td>
												<td width="440"><? echo $list_paciente['desc_prestacion']; ?> </td>
												<td width="30"><? echo $list_paciente['sala']; ?> </td>
												<td width="140"><? echo $list_paciente['procedencia']."(".$list_paciente['subprocedencia'].")"; ?> </td>
												<td width="70"><? echo cambiarFormatoFecha(substr($list_paciente['fecha'],0,10)); ; ?> </td>
                                                <?
                                                echo"</tr>";
                                            }
                                        }
                                        ?>
			  						</table>
                                    <script language="JavaScript">
                                    <!--
                                        tigra_tables('imagenologia', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                                    // -->
                                    </script>
		  						</div>
	  						</div>	
                        </td>
                    </tr>
				</table>
            
            </div>
      		<div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="60">Codigo</td>
                                        <td width="440">Prestacion</td>
                                        <td width="30">Nro</td>
                                        <td width="140">Servcio</td>
                                        <td width="70">Fecha</td>
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='imagenologia' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($rut_paciente <> 0)
                                        {
										    if($opcion_1 == 'on')
											{
                                            	$sql = "SELECT * FROM controlap where rut_paciente = '".$rut_paciente."' order by fecha DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM controlap where rut_paciente = '".$rut_paciente."' and fecha >= '".$fecha_hospitalizacion."' order by fecha DESC";
											}

                                            mysql_select_db('paciente') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            while($list_paciente = mysql_fetch_array($query2)){
                                                $id_hosp = $list_paciente['id'];
                                                ?>
                                                <tr align="left" height="25px" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
												<td width="60"><? echo $list_paciente['prestacion']; ?>	</td>
												<td width="440"><? echo $list_paciente['desc_prestacion']; ?> </td>
												<td width="30"><? echo $list_paciente['nro_prestacion']; ?> </td>
												<td width="140"><? echo "(".$list_paciente['procedencia'].")"; ?> </td>
												<td width="70"><? echo cambiarFormatoFecha(substr($list_paciente['fecha'],0,10)); ; ?> </td>
                                                <?
                                                echo"</tr>";
                                            }
                                        }
                                        ?>
			  						</table>
                                    <script language="JavaScript">
                                    <!--
                                        tigra_tables('imagenologia', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                                    // -->
                                    </script>
		  						</div>
	  						</div>	
                        </td>
                    </tr>
				</table>
            
            </div>
      		<div class="TabbedPanelsContent">
            
                <table width="800px" align="center" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                        <td>
                            <div id="afectado" align="left" style="float:none; width: 100%; padding: 5px;">
                                <table border="2px" cellpadding="1px" cellspacing="0px">
                                    <tr valign="middle">
                                        <td width="60">Codigo</td>
                                        <td width="440">Prestacion</td>
                                        <td width="30">Turno</td>
                                        <td width="140">Servcio</td>
                                        <td width="70">Fecha</td>
                                    </tr>
                                </table>
                                <div style="width:780px;height:200px;overflow:auto;">
                                    <?php
                                    echo "<table id='dialisis' border='2px' cellpadding='1px' cellspacing='0px'>";
                                        if ($rut_paciente <> 0)
                                        {
										    if($opcion_1 == 'on')
											{
                                            	$sql = "SELECT * FROM controldialisis where pacId = '".$id_paciente."' order by regFecha DESC";
											}
											else
											{
                                            	$sql = "SELECT * FROM controldialisis where pacId = '".$id_paciente."' and regFecha >= '".$fecha_hospitalizacion."' order by regFecha DESC";
											}

                                            mysql_select_db('paciente') or die('Cannot select database');
                                            $query2 = mysql_query($sql) or die(mysql_error());
                                            while($list_paciente = mysql_fetch_array($query2)){
												
												$codigo = $list_paciente['preCod'];
												
												$sql = "SELECT * FROM prestacion where preCod = '".$codigo."'";
												mysql_select_db('paciente') or die('Cannot select database');
												$query = mysql_query($sql) or die(mysql_error());
												$l_prestacion = mysql_fetch_array($query);
												$desc_prestacion =  $l_prestacion['preNombre'];
												
                                                ?>
                                                <tr align="left" height="25px" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
												<td width="60"><? echo $list_paciente['preCod']; ?>	</td>
												<td width="440"><? echo $desc_prestacion; ?> </td>
												<td width="30"><? echo $list_paciente['regAturno']; ?> </td>
												<td width="140"><? echo "(".$list_paciente['procedencia'].")"; ?> </td>
												<td width="70"><? echo cambiarFormatoFecha(substr($list_paciente['regFecha'],0,10)); ; ?> </td>
                                                <?
                                                echo"</tr>";
                                            }
                                        }
                                        ?>
			  						</table>
                                    <script language="JavaScript">
                                    <!--
                                        tigra_tables('dialisis', 0, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                                    // -->
                                    </script>
		  						</div>
	  						</div>	
                        </td>
                    </tr>
				</table>
            
            </div>
    	</div>
  	</div>

</fieldset>


<!-- Aca Termina lo Igual    -->
    
<fieldset class="fieldset_det2">

</form>


    <table width="780px" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td width="10">&nbsp;</td>
            <td width="67">Rut</td>
            <td> 
          <input size="9" type="text" name="prut" value="<?php echo $hospitalizacion['rut_paciente']; ?>" readonly="readonly" />
        <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($hospitalizacion['rut_paciente']); ?>" readonly="readonly" /> 
        N&deg; Ficha 
        <input size="10" type="text" name="pficha" value="<?php echo $hospitalizacion['ficha_paciente']; ?>" readonly="readonly" /> Prevision <input size="20" type="text" name="pprevision" value="<?php echo $hospitalizacion['prevision']; ?>" readonly="readonly" />
            </td>
            <td colspan="2" align="right"><input type="button" class="boton"  
                    onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama&tipo_atencion=XXX"; ?>'; parent.GB_hide(); " value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                /></td>
            <td width="10">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>        
            <td>Nombre</td>
            <td>
            <input size="81" type="text" name="pnombre" value="<?php echo $hospitalizacion['nom_paciente']; ?>" readonly="readonly"  />
            </td>
            <td width="45">Fono1</td>
            <td width="100"><input size="12" type="text" name="pfono1" value="<?php echo $hospitalizacion['fono1_paciente']; ?>" readonly="readonly" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Direcci&oacute;n</td>
            <td>
        <input size="81" type="text" name="pdireccion" value="<?php echo $hospitalizacion['direc_paciente']; ?>" readonly="readonly"/>
            </td>
            <td width="45">Fono2</td>
            <td><input size="12" type="text" name="pfono2" value="<?php echo $hospitalizacion['fono2_paciente']; ?>" readonly="readonly" /></td>
            <td>&nbsp;</td>
        </tr>
    </table>
</fieldset>




<fieldset class="fieldset_det2">
    <table width="780px" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td width="10px">&nbsp;</td>
            <td width="112px">Servicio Clinico</td>
            <td><input size="25" type="text" name="pservicio" value="<?php echo $hospitalizacion['servicio']; ?>" readonly="readonly"/> Sala <input size="10" type="text" name="pcama" value="<?php echo $hospitalizacion['sala']; ?>" readonly="readonly" /> Cama N&deg; <input size="3" type="text" name="pcama" value="<?php echo $hospitalizacion['cama']; ?>" readonly="readonly" /> 
          Fecha Ingreso 
            <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($hospitalizacion['fecha_ingreso']); ?>" readonly="readonly" /></td>
        </tr>
        <tr>
            <td width="10px"></td>                
            <td>Medico Tratante</td>
            <td><input size="55" type="text" name="pmedico" value="<?php echo $hospitalizacion['medico']; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $hospitalizacion['procedencia']; ?>" readonly="readonly" /> </td>
        </tr>
        <tr>
            <td></td>
            <td>Pre-Diagnostico</td>
            <td><input size="101" type="text" name="pdiagnostico1" value="<?php echo $hospitalizacion['diagnostico1']; ?>" readonly="readonly" /></td>
        </tr>
        <tr>
            <td></td>
            <td>Diagnostico</td>
            <td><input size="101" type="text" name="pdiagnostico2" value="<?php echo $hospitalizacion['diagnostico2']; ?>" readonly="readonly" /></td>
        
        </tr>

    </table>

</fieldset>





</div>


</fieldset>
</td>
</tr>
</table>


<?

	if ($i_mens_todos <> 0)
	{
		$mens_todos = "'".implode("','",$arreglo_camas)."'";
	}

?>





<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>

<script language="JavaScript">
// configuration variable for the hint object, these setting will be shared among all hints created by this object
var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 10, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : 20, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'bctl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'css'        : 'hintsClass', // a style class name for all hints, applied to DIV element (see style section in the header of the document)
	'show_delay' : 0, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 200, // a delay between closing event (mouseout for example) and hint disappearing
	'follow'     : true, // hint follows the mouse as it moves
	'z-index'    : 100, // a z-index for all hint layers
	'IEfix'      : false, // fix IE problem with windowed controls visible through hints (activate if select boxes are visible through the hints)
	'IEtrans'    : ['blendTrans(DURATION=.3)', null], // [show transition, hide transition] - nice transition effects, only work in IE5+
	'opacity'    : 95 // opacity of the hint in %%
};
// text/HTML of the hints

var HINTS_ITEMS = [ <? echo $mens_todos; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1", {defaultTab:<? echo "$cualtab"; ?>});

</script>


</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>


