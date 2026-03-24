<?php 
//date_default_timezone_set('America/Santiago');

//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
    onload = focusIt;
    function focusIt()
    {
      document.ingresa_doc.doc_paciente.focus();
    }
</script>

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div align="center">

<?

$permisos = $_SESSION['permiso'];


if ($t_pac_transito == 'on') {
	$d_t_pac_transito = 1;
}
else {
	$d_t_pac_transito = 0;
}

include "../funciones/funciones.php";

mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM camas where id = $id_cama") or die(mysql_error());

$camas = mysql_fetch_array($query);


	if ($tipodocumento == '')
	{
		$tipodocumento = 2;
	}


if ($camas)

{

	$id_cama = $camas['id'];
	$cama = $camas['cama'];
	$sala = $camas['sala'];
	$servicio = $camas['cod_servicio'];
	$desc_servicio = $camas['servicio'];
	$tipo_1 = $camas['tipo_1'];
	$d_tipo_1 = $camas['d_tipo_1'];
	
	$estado = $camas['estado'];

	$_SESSION['MM_pro_id_cama'] = $id_cama;
	$_SESSION['MM_pro_cama'] = $cama;
	$_SESSION['MM_pro_sala'] = $sala;
	$_SESSION['MM_pro_servicio'] = $servicio;
	$_SESSION['MM_pro_desc_servicio'] = $desc_servicio;
	$_SESSION['MM_pro_tipo_1'] = $tipo_1;
	$_SESSION['MM_pro_d_tipo_1'] = $d_tipo_1;
	$_SESSION['MM_pro_estado'] = $estado;

	if ($estado == 1)
	
	{

	?>

	<form name="ingresa_doc" method="get" action="pro1_ingresopaciente.php">

    <fieldset class="fieldset_det2"><legend>Paciente</legend>
            <table align="center" border="0" cellspacing="0" cellpadding="0">
            <tr height="5px">
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
                <td>
					<select name="tipodocumento">
                    <option value=1 <? if ($tipodocumento == 1) { echo "selected"; } ?> >Cta-Cte</option>
			        <option value=2 <? if ($tipodocumento == 2) { echo "selected"; } ?> >Rut</option>
                    <option value=3 <? if ($tipodocumento == 3) { echo "selected"; } ?> >Ficha</option>
                    </select>
                </td>
                <td>
               	  <span id="spry_doc_paciente">
           	      	<input size="9" type="text" name="doc_paciente" value="<? echo $rut ?>" />
                  </span>
       	        	<input size="1" type="text" name="pdv" disabled="disabled" >
				    <input type="hidden" name="id_traslado" value="0" >
					<input type="submit" value="Acceptar" >
					<input type="Button" value="Buscar" onclick="window.location.href='<? echo"../busquedapacientes/busquedapacientes.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
					Prevision <input size="20" type="text" name="pprevision" disabled="disabled" >
                </td>
	            <td width="45px">Fono1</td>
                <td width="100px">
                    <input size="12" type="text" name="pfono1" disabled="disabled" >
                </td>
                <td width="10px">&nbsp;</td>
            </tr> 
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
                    <input size="79" type="text" name="pnombre" disabled="disabled" >
                </td>
	            <td width="45px">Fono2</td>
                <td>
                	<input size="12" type="text" name="pfono2" disabled="disabled" >
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Dirección</td>
                <td>
                <input size="79" type="text" name="pdireccion" disabled="disabled" >
                </td>
	            <td width="45px">Fono3</td>
                <td>
                	<input size="12" type="text" name="pfono3" disabled="disabled" >
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr height="5px">
            </tr>
        </table>
    </fieldset>




</div>

<?
    $cod_servicio = $_SESSION['MM_Servicio_activo'];
    
    mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
    mysql_select_db('camas') or die('Cannot select database');
    $query = mysql_query("SELECT * FROM sscc where id = $cod_servicio") or die(mysql_error());
    $query_servicio = mysql_fetch_array($query);
    $servicio = $query_servicio['id'];
    $desc_servicio = $query_servicio['servicio'];
    $id_rau =  $query_servicio['id_rau'];
    
    $_SESSION['MM_Servicio'] = $id_rau;

    if ($d_t_pac_transito == 1) {
        $sql_p_transito = "SELECT * FROM transito_paciente order by nom_paciente";
        $cuantos_pac = "<a href='ingresopaciente.php?id_cama=".$id_cama."&t_pac_transito=off'; > Mostrar solo los pacientes en transito del servicio de ".$desc_servicio."</a>";
    }
    else {
        $sql_p_transito = "SELECT * FROM transito_paciente where cod_sscc_hasta = $id_rau order by fecha";
        $cuantos_pac = "<a href='ingresopaciente.php?id_cama=".$id_cama."&t_pac_transito=on'; > Mostrar los pacientes en transito de todos los servicios.</a>";
    }
?>

    <fieldset><legend>Pacientes En Espera</legend>
        <table width="97%" align="center" border="0px" cellpadding="0px" cellspacing="0px">
            <tr align="left"> <td style="font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#FFF"> <? echo $cuantos_pac; ?> </td> </tr>
        </table>

		<div align="center" style="width:765px;height:265px;overflow:auto">
        
			<table width="97%" id="table_ingresopaciente" border="2px" cellpadding="1px" cellspacing="0px">
            	<tr>
                    <td colspan='2'>Paciente</td>
                	<td colspan="2">Servicio</td>
                    <td rowspan="2" width="80px">Fecha</td>
                </tr>
 				<tr>
                    <td>Nombres</td>
                	<td>Rut</td>
                	<td>Desde</td>
                	<td>Hasta</td>
                </tr>

                <?
				
				mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
				mysql_select_db('camas') or die('Cannot select database');
				$query = mysql_query($sql_p_transito) or die(mysql_error());


				while($traslados = mysql_fetch_array($query)){
					$id_traslado = $traslados['id'];
					$id_paciente = $traslados['id_paciente'];
					$rut_paciente = $traslados['rut_paciente'];
					$nom_paciente = $traslados['nom_paciente'];
					$cta_cte_traslado = $traslados['cta_cte'];
					$tipo_traslado = $traslados['tipo_traslado'];
					$cod_sscc_desde = $traslados['cod_sscc_desde'];
					$cod_sscc_hasta = $traslados['cod_sscc_hasta'];
					$id_solicitud = $traslados['id_solicitud'];
//					$desc_sscc_desde = $traslados['desc_sscc_desde'];
//					$desc_sscc_hasta = $traslados['desc_sscc_hasta'];

					$fecha = cambiarFormatoFecha2($traslados['fecha']);

					$sql = "SELECT * FROM servicio where idservicio = '".$cod_sscc_desde."'";
					mysql_select_db('acceso') or die('Cannot select database');
					$query2 = mysql_query($sql) or die(mysql_error());
					$l_servicios = mysql_fetch_array($query2);
					$desc_sscc_desde = $l_servicios['nombre'];
					
					$sql = "SELECT * FROM servicio where idservicio = '".$cod_sscc_hasta."'";
					mysql_select_db('acceso') or die('Cannot select database');
					$query2 = mysql_query($sql) or die(mysql_error());
					$l_servicios = mysql_fetch_array($query2);
					$desc_sscc_hasta = $l_servicios['nombre'];
					
					
					?>
                    <tr style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
                    	onClick="window.location.href='<? echo"pro1_ingresopaciente.php?tipodocumento=5&id_paciente=$id_paciente&id_traslado=$id_traslado&id_solicitud=$id_solicitud"; ?>'; parent.GB_hide(); ">
					<?
                    echo "<td align='left' style='padding-left:2px; padding-right:10px'>$nom_paciente</td>";
                    echo "<td align='left' style='padding-left:2px; padding-right:10px'>$rut_paciente</td>";
                    echo "<td align='left' style='padding-left:2px; padding-right:10px' >$desc_sscc_desde</td>";
                    echo "<td align='left' style='padding-left:2px; padding-right:10px' >$desc_sscc_hasta</td>";
                    echo "<td align='left' style='padding-left:3px; padding-right:10px' >$fecha</td>";
                    echo "</tr>";
                }
                ?>       
                </tr>
            </table>
    
            <script language="JavaScript">
            <!--
                tigra_tables('table_ingresopaciente', 2, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
            // -->
            </script>
    
        </div>
                    
    </fieldset>




    <fieldset class="fieldset_det2"><legend>Opciones</legend>
        <table align="center" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
					<input type="button" class="boton" onclick="window.location.href='<? echo"pro1_bloqueocama.php"; ?>'; parent.GB_hide(); " value=" Bloquear Cama "
      				<?php if ( array_search(20, $permisos) == null ) { ?> disabled="disabled" <? } ?>
					/>
                        
					<input type="button" class="boton"
                        	onClick="window.location.href='<? echo"sscc.php"; ?>'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                       	/>                         
				</td>
            </tr>
   	    </table>
    </fieldset>

	</form>

<script type="text/javascript">
<!--
var spry_doc_paciente = new Spry.Widget.ValidationTextField("spry_doc_paciente", "integer", {validateOn:["change"], useCharacterMasking:true, isRequired:false});
//-->
</script>




<?
	}
	else
	{
		?>
		<fieldset class="fieldset_det2">
            <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td align="center">Cama ha cambiado de estado,</td>
	            </tr>
    	        <tr>
        	        <td align="center">y ya no se encuentra libre,</td>
            	</tr>
	            <tr>
    	            <td align="center">recargue pagina de informacion de Servicio.</td>
        	    </tr>
            	<tr height="25px">
	            </tr>
    	    </table>
		</fieldset>
		<fieldset class="fieldset_det2"><legend>Opciones</legend>
            <table align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td>
          				<input type="button" class="boton"
                        	onClick="window.location.href='<? echo"sscc.php"; ?>'" value="               Volver               " />
					</td>
	            </tr>
            	<tr height="25px">
	            </tr>
    	    </table>

		</fieldset>
        <?
	}

}
else
{

echo "Problemas de Registro Cominuquese con el Administrador de Sistemas";
?>	<input type="button" value="               Volver               " onClick="top.window.location.href='<? echo"sscc.php"; ?>';
parent.parent.GB_hide(); " > 
<?
}
?>

</fieldset>
</td>
</tr>
</table>


</body>
</html>



<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>
