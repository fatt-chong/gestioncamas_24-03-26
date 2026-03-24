<?php

if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

</head>

<?
include "../funciones/funciones.php";

$fecha_hoy = date('d-m-Y');

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];


$sql = "SELECT * FROM camas where id = '".$id_cama."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);

$diagnostico1 = $paciente['diagnostico1'];
$fecha_ingreso = $paciente['fecha_ingreso'];
$fecha_bloqueo = cambiarFormatoFecha2($fecha_ingreso);
$estadoCama = $paciente['estado'];


?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
                
                <? if($estadoCama != 5){ ?>

                <div class="titulo" align="center">
                
                <table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr align="left">
                <td>
                <fieldset>
                <legend>Informacion de Cama</legend>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td width="20px" height="20px"></td><td width="160px"></td></tr>
                <tr><td></td><td>Cama N�mero</td><td>: <? echo $cama ?> </td></tr>
                <tr><td></td><td>Sala</td><td>: <? echo $sala ?> </td></tr>
                <tr><td></td><td>Servicio Cl�nico</td><td>: <? echo $desc_servicio ?> </td></tr>
                <tr><td></td><td>Fecha de Bloqueo</td><td>: <? echo $fecha_bloqueo ?> </td></tr>
                <tr><td></td><td>Motivo de Bloqueo</td><td>: <? echo $diagnostico1 ?> </td></tr>
                <tr><td width="20px" height="20px"></td><td width="160px"></td></tr>
                
                </table>
                
                </fieldset>
                </td>
                </tr>
                </table>
                
                    <form method="post" action="pro2_desbloqueocama.php">
                        <input type="hidden" name="diagnostico1" value="<? echo $diagnostico1 ?>" /> 
                        <input type="hidden" name="fecha_ingreso" value="<? echo $fecha_ingreso ?>" />
                
                        <table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr align="left">
                        <td>
                        <fieldset></br>
                        <legend>� Esta seguro de Realizar el Desboqueo de Cama ?</legend>
                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
                        <tr><td width="20px" height="20px"></td><td width="140px"></td></tr>
                        
                        <tr><td></td><td> Fecha </td>
                            <td><input size="12" id="f_date4" name="fecha_egreso" value="<? echo $fecha_hoy ?>" /> <input type="Button" id="f_btn4" value="....." />
                
                            </td></tr>
                        <tr><td></td><td> Comentario </td><td> <input type="text" size="60" name="diagnostico2" /> </td></tr>
                        <tr><td width="20px" height="20px"></td><td width="140px"></td></tr>
                        <tr><td></td><td> <input type="submit" value="          Acceptar          " >
                            </td><td><input type="button" value="      Cancelar      " onclick="window.location.href='<? echo"desbloqueocama.php?id_cama=$id_cama&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide(); " /></td></tr>
                            <tr><td width="20px" height="20px"></td><td width="140px"></td></tr>        
                        </table>
                        
                        </fieldset>
                        </td>
                        </tr>
                        </table>
                
                    </form>
                 
                       <script type="text/javascript">//<![CDATA[
                
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() }
                      });
                      cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");
                
                    //]]></script>
                
                 
                </div>
                
                <? } else {?>

            <fieldset class="fieldset_det2"><legend>Error</legend>
                    <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr height="25px">
                            </tr>
                            <tr>
                                <td align="center">La cama ha cambiado de estado,</td>
                            </tr>
                            <tr>
                                <td align="center"> y ya no se encuentra bloqueada,</td>
                            </tr>
                            <tr>
                                <td align="center">recargue pagina de informacion de Servicio.</td>
                            </tr>
                            <tr height="25px">
                            </tr>
                        </table>
                    
                </fieldset> 
                <fieldset class="fieldset_det2"><legend>Opciones</legend>
                  <div align="center">
                  <input type="button" value="               Volver               " onClick="window.location.href='<? echo"sscc.php"; ?>'" >
                  </div>
                </fieldset>
            
            <? } ?>

                </fieldset>
            </td>
        </tr>
   </table>


</body>
</html>
