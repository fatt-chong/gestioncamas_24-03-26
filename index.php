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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..:: Gesti&oacute;n de Camas Hospital Dr. Juan No&eacute; C.</title>
</head>


<?
$permisos = $_SESSION['permiso'];

$inic_con = "camas.php";


if ( array_search(26, $permisos) != null ) { $inic_con = "consultas/consultapacientes.php"; }
	
if ( array_search(29, $permisos) != null ) { $inic_con = "censo/mantencion_censo.php"; }

if ( array_search(27, $permisos) != null ) { $inic_con = "informes/info_categoriza.php"; }

if ( array_search(18, $permisos) != null ) { $inic_con = "hist_clinico/hist_clinico.php"; }

if ( array_search(18, $permisos) != null ) { $inic_con = "ingresos/sscc.php"; }

if ( array_search(17, $permisos) != null ) { $inic_con = "gestion/camas.php"; }

?>



<FRAMESET rows="100,*" frameborder="1" framespacing="0" border="1"> 
	<frame name="topFrame" src="banner.php" scrolling="no" frameborder="0">
	<frame name="mainFrame" src="<? echo $inic_con; ?>" scrolling="auto"> 
</FRAMESET> 


<noframes><body>
</body>
</noframes></html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>



