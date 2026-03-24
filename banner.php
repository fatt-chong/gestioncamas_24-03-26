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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body style="background-repeat:no-repeat" background="../estandar/img/banner_web..jpg">



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
imgsrc[13]="img/a_menubutton7.gif";
imgsrc[14]="img/p_menubutton7.gif";
imgsrc[15]="img/a_menubutton8.gif";
imgsrc[16]="img/p_menubutton8.gif";
imgsrc[17]="img/a_menubutton9.gif";
imgsrc[18]="img/p_menubutton9.gif";
imgsrc[19]="img/a_menubutton10.gif";
imgsrc[20]="img/p_menubutton10.gif";
imgsrc[21]="img/a_menubutton11.gif";
imgsrc[22]="img/p_menubutton11.gif";
imgsrc[23]="img/a_menubutton12.gif";
imgsrc[24]="img/p_menubutton12.gif";
imgsrc[25]="img/a_epi1.gif";
imgsrc[26]="img/p_epi1.gif";
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
$permisos = $_SESSION['permiso'];
?>



<div align="left">
<TABLE height="91px" align="left" border="0" Cellpadding="0" Cellspacing="0">
  <TR valign="bottom">
	<TD style="border-width: 0px;">

    <?php if ( array_search(17, $permisos) != null ) { ?>  
	    <A ID="<#AWBID>" HREF="gestion/camas.php" TARGET="mainFrame"  ONMOUSEOVER="change('1','m1')" ONMOUSEOUT= "change('2','m1')" name="m1"><img name="m1" src="img/p_menubutton1.gif" border="0" vspace="0" hspace="0" /></A>
	<? } ?>
    
    </TD>
	<TD style="border-width: 0px;">
    <?php if ( array_search(18, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="ingresos/sscc.php"  TARGET="mainFrame"  ONMOUSEOVER="change('3','m2')" ONMOUSEOUT= "change('4','m2')" name="m2"><img name="m2" src="img/p_menubutton2.gif" border="0" vspace="0" hspace="0" /></a></A>
	<? } ?>
    
    </TD>
	<TD style="border-width: 0px;">
    <?php if ( array_search(18, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="ingreso2/aprecoz.php"  TARGET="mainFrame"  ONMOUSEOVER="change('5','m3')" ONMOUSEOUT= "change('6','m3')" name="m3"><img name="m3" src="img/p_menubutton3.gif" border="0" vspace="0" hspace="0" /></a></A>
	<? } ?>
    
    </TD>
    
     <!--CAMA SUPERNUMERARIA-->
    <TD style="border-width: 0px;">
    <?php if  ( array_search(323, $permisos) != null ){ ?>  
    	<A ID="<#AWBID>" HREF="superNumeraria/camaSuperNum.php"  TARGET="mainFrame"  ONMOUSEOVER="change('19','m9')" ONMOUSEOUT= "change('20','m9')" name="m9"><img name="m9" src="img/p_menubutton10.gif" border="0" vspace="0" hspace="0"/></a>
	<? } ?>
    </TD>
    
    <TD style="border-width: 0px;">
    <?php if ( array_search(265, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="../hospitalDia/listadoPacientes.php"  TARGET="mainFrame"  ONMOUSEOVER="change('21','m11')" ONMOUSEOUT= "change('22','m11')" name="m11"><img name="m11" src="img/p_menubutton11.gif" border="0" vspace="0" hspace="0" /></a>
	<? } ?>
    
    </TD>
    
    <TD style="border-width: 0px;">
    <?php if ( array_search(270, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="../cma/listadoPacientes.php"  TARGET="mainFrame"  ONMOUSEOVER="change('23','m12')" ONMOUSEOUT= "change('24','m12')" name="m12"><img name="m12" src="img/p_menubutton12.gif" border="0" vspace="0" hspace="0" /></a>
	<? } ?>
    
    </TD>
    
    <TD style="border-width: 0px;">
    <?php if ( array_search(226, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="../partos/gestion_partos.php"  TARGET="mainFrame"  ONMOUSEOVER="change('17','m10')" ONMOUSEOUT= "change('18','m10')" name="m10"><img name="m10" src="img/p_menubutton9.gif" border="0" vspace="0" hspace="0" /></a></A>
	<? } ?>
    
    </TD>
        
	<TD style="border-width: 0px;">
	<?php if (( array_search(18, $permisos) != null ) or ( array_search(319, $permisos) != null )) { ?>  
    	<A ID="<#AWBID>" HREF="../../historialclinico/Interfaz/resumenHistorial.php"  TARGET="mainFrame"  ONMOUSEOVER="change('7','m4')" ONMOUSEOUT= "change('8','m4')" name="m4"><IMG NAME="m4" SRC="img/p_menubutton4.gif" BORDER="0" vspace="0" hspace="0"></A>
	<? } ?>
    
    </TD>
    
    <TD style="border-width: 0px;">
	<?php if ( array_search(27, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="informes/info_categoriza.php"  TARGET="mainFrame"  ONMOUSEOVER="change('9','m5')" ONMOUSEOUT= "change('10','m5')" name="m5"><IMG NAME="m5" SRC="img/p_menubutton5.gif" BORDER="0" vspace="0" hspace="0"></A>
	<? } ?>
    
    </TD>

	<TD style="border-width: 0px;">
    <?php if ( array_search(247, $permisos) != null ) { ?>  
    		<A ID="<#AWBID>" HREF="censo/mantencion_censo.php"  TARGET="mainFrame"  ONMOUSEOVER="change('11','m6')" ONMOUSEOUT= "change('12','m6')" name="m6"><IMG NAME="m6" SRC="img/p_menubutton6.gif" BORDER="0" vspace="0" hspace="0"></A>
	<? } ?>
        
    </TD>
   	<TD style="border-width: 0px;">
    <?php if ( array_search(29, $permisos) != null ) { ?>  
    		<A ID="<#AWBID>" HREF="censoDiario/listadoCensoDiario.php?borra_session=si"  TARGET="mainFrame"  ONMOUSEOVER="change('11','m6')" ONMOUSEOUT= "change('12','m6')" name="m6"><IMG NAME="m6" SRC="img/p_menubutton6.gif" BORDER="0" vspace="0" hspace="0"></A>
	<? } ?>
        
    </TD>
	<TD style="border-width: 0px;">
	<?php if ( array_search(26, $permisos) != null ) { ?>  
    	<A ID="<#AWBID>" HREF="consultas/consultapacientes.php"  TARGET="mainFrame"  ONMOUSEOVER="change('13','m7')" ONMOUSEOUT= "change('14','m7')" name="m7"><IMG NAME="m7" SRC="img/p_menubutton7.gif" BORDER="0" vspace="0" hspace="0"></A>
	<? } ?>
    
    </TD>
	<TD style="border-width: 0px;">
	<?php if ( 1 == 1 ) { ?>  
    <A ID="<#AWBID>" ONMOUSEOVER="change('15','m8')" ONMOUSEOUT= "change('16','m8')" name="m8"><IMG NAME="m8" SRC="img/p_menubutton8.gif" BORDER="0" onclick="window.parent.close()" vspace="0" hspace="0"></A>
	<? } ?>
    
    
    </TD>

  </TR>
</TABLE>
</div>



</body>
</html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>
