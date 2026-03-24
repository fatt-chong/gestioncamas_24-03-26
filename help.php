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

<title>Detalle de Cama</title>
<link type="text/css" rel="stylesheet" href="gestion/css/estilo.css" />

</head>

<body background="../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">



<table width="800px" align="center" border="0" cellspacing="0" cellpadding="0" background="ingresos/img/fondo.jpg">

        <tr>
            <td>
            	<fieldset>

<table align="center" width="100%" border="1" cellpadding="10">

  <tr>
    <th scope="col">Cama Sin Paciente</th>
    <th scope="col">Cama Bloqueada</th>
    <th scope="col">Cama Sin Categorizacion</th>
    <th scope="col">Paciente Cat-A</th>
    <th scope="col">Paciente Cat-B</th>
    <th scope="col">Paciente Cat-C</th>
    <th scope="col">Paciente Cat-D</th>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr align="center">
    <td class="td_sscc"><img src="ingresos/img/cama-vacia.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/icono-sn.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-sc.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-a.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-b.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-c.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-d.gif" width="53" height="53" /></td>
    <td>Cama Ocupada</td>
  </tr>
  <tr align="center">
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc"><img src="ingresos/img/cama-sc-h.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-a-h.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-b-h.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-c-h.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img src="ingresos/img/cama-d-h.gif" width="53" height="53" /></td>
    <td>Paciente  Sin Historial Clinico</td>
  </tr>
  <tr align="center">
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc"><img class="img_pr_otroservicio" src="ingresos/img/cama-sc.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_otroservicio" src="ingresos/img/cama-a.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_otroservicio" src="ingresos/img/cama-b.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_otroservicio" src="ingresos/img/cama-c.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_otroservicio" src="ingresos/img/cama-d.gif" width="53" height="53" /></td>
    <td>Paciente Perteneciente a otro Servicio</td>
  </tr>
  <tr align="center">
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc"><img class="img_pr_dealta" src="ingresos/img/cama-sc.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_dealta" src="ingresos/img/cama-a.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_dealta" src="ingresos/img/cama-b.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_dealta" src="ingresos/img/cama-c.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_dealta" src="ingresos/img/cama-d.gif" width="53" height="53" /></td>
    <td>Paciente Con Alta Administrativa</td>
  </tr>
  <tr align="center">
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc">&nbsp;</td>
    <td class="td_sscc"><img class="img_pr_multires" src="ingresos/img/cama-sc.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_multires" src="ingresos/img/cama-a.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_multires" src="ingresos/img/cama-b.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_multires" src="ingresos/img/cama-c.gif" width="53" height="53" /></td>
    <td class="td_sscc"><img class="img_pr_multires" src="ingresos/img/cama-d.gif" width="53" height="53" /></td>
    <td>Paciente Multiresistente</td>
  </tr>

</table>



				</fieldset>
			</td>
		</tr>
    <tr align="center">
        	<td height="52">
              	<A>
              	<input type="button" onclick="window.parent.close()" value="&nbsp;&nbsp;&nbsp;&nbsp; Cerrar Ventana &nbsp;&nbsp;&nbsp;&nbsp;" hspace="0" vspace="0"/>
            	</A>
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


