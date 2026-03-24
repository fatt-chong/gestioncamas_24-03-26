<?php 
//usar la funcion header habiendo mandado código al navegador
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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Ingreso Hospitalizaci&oacute;n Domiciliaria de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div align="center">

<?

$permisos = $_SESSION['permiso'];

include "../funciones/funciones.php";

	if ($tipodocumento == '') { $tipodocumento = 2; }
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
			        <option value=2 <? if ($tipodocumento == 2) { echo "selected"; } ?> />Rut
                    <option value=3 <? if ($tipodocumento == 3) { echo "selected"; } ?> />Ficha
                    <option value=4 <? if ($tipodocumento == 4) { echo "selected"; } ?> />ctatce
                    </select>		                
                </td>
                <td>
               	  <span id="spry_doc_paciente">
           	      	<input size="9" type="text" name="doc_paciente" value="<? echo $rut ?>" />
                  </span>
       	        	<input size="1" type="text" name="pdv" disabled="disabled" >
				    <input type="hidden" name="id_traslado" value="0" >
					<input type="submit" value="Acceptar" >
					<input type="Button" value="Buscar" onclick="window.location.href='<? echo"../busquedapacientes/busquedapacientes3.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
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


    <fieldset class="fieldset_det2"><legend>Opciones</legend>
        <table align="center" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
					<input type="button" class="boton"
                        	onClick="window.location.href='<? echo"aprecoz.php"; ?>'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
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
