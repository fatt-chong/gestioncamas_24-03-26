<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "renovarSession.php?urlOrigen=listadoPacientes.php";
	header(sprintf("Location: %s", $GoTo));
}
require_once('../acceso/cargarpermiso.php'); $permisos = $_SESSION['permiso'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<!--<link type="text/css" rel="stylesheet" href="include/tinybox/style.css" />-->
<!--<link type="text/css" rel="stylesheet" href="include/jquery/css/modal-hora.css" />
<script src="include/jquery/js/jquery-1.7.2.js"></script>
<script src="include/jquery/js/jquery-1.7.2.min.js"></script>
<script src="include/jquery/js/jquery-ui-1.8.19.custom.min.js"></script>
<script src="include/jquery/js/modal-hora.js"></script>-->
<!--<script src="include/tinybox/tinybox.js"></script>-->
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Detalle Atencion</title>
</head>
<? //PARAMETROS
if($_GET['HOSid'])
	$HOSid = $_GET['HOSid'];
if($_POST['HOSid'])
	$HOSid = $_POST['HOSid'];
require_once("include/funciones/funciones.php");
require_once("clases/Conectar.inc");
$bd = new Conectar; $link = $bd->db_connect(); 
$bd->db_select("cma",$link);
require_once("clases/Atencion.inc");
$objAtencion = new Atencion; 
$RSAtencion = $objAtencion->getAtencion($link,$HOSid);
$digito = generaDigito($RSAtencion['rut']);
?>
<body>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="PACid" id="PACid" value="<? echo $PACid; ?>"/>  
  <table width="790" border="0" style="border:1px solid #000000;" align="center" cellpadding="4" cellspacing="4" background="../gestioncamas/ingresos/img/fondo.jpg">
    <tr>
        <th height="30" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Detalle Atención</th>
    </tr>
    <tr>
        <td>
        	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
    				<td>
                        <fieldset class="titulocampo">
                        <legend class="titulos_menu">paciente</legend>
                        <table width="100%">
                        <tr>
                            <td width="14%" align="left" valign="middle">Rut:</td>
                            <td width="86%" align="left" valign="middle"><input name="pacRut" type="text" id="pacRut" value="<? echo $RSAtencion['rut'];?>" size="8" readonly="readonly"/>-<input name="digito" type="text" class="casilla_chica" id="digito" value="<? echo $digito;?>" size="1" readonly="readonly" />
                                Ficha:
                                <input name="ficha" type="text" id="ficha" value="<? echo $RSAtencion['nroficha']; ?>" size="10" readonly="readonly" />
                                Cta Cte:
                                <input name="ficha2" type="text" id="ficha2" value="<? echo $RSAtencion['cta_cte']; ?>" size="10" readonly="readonly" />
                                Previsión:
                                <input name="pacPrevision" type="text" id="pacPrevision" value="<? echo $RSAtencion['prevision']; ?>" size="20" readonly="readonly" /></td>
                        </tr>
                        <tr>
                            <td>Nombre:</td>
                            <td>
                                <input name="pacNombre" type="text" id="pacNombre" value="<? echo $RSAtencion['nombres']." ".$RSAtencion['apellidopat']." ".$RSAtencion['apellidomat']; ?>" size="50" readonly="readonly" />
                                Sexo:
                                <input name="pacSexo" type="text" class="casilla_media" id="pacSexo" value="<? echo $RSAtencion['sexo']; ?>" size="2" readonly="readonly"/>
                                Fecha Nac:
                                <input name="fecha_nac" type="text" id="fecha_nac" value="<? echo $RSAtencion['fechanac']; ?>" size="6" readonly="readonly"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Dirección:</td>
                            <td><input name="pacDireccion" type="text" id="pacDireccion" value="<? echo $RSAtencion['direccion']; ?>" size="50" readonly="readonly" /></td>
                        </tr>
                        <tr>
                          <td>Pre-Diagnóstico:</td>
                          <td><input name="PACdiagnostico1" type="text" id="PACdiagnostico1" value="<? echo $RSAtencion['HOSdiagnostico1']; ?>" size="100" readonly="readonly" /></td>
                        </tr>
                        <tr>
                          <td>Diagnóstico:</td>
                          <td><input name="PACdiagnostico2" type="text" id="PACdiagnostico2" value="<? echo $RSAtencion['HOSdiagnostico2']; ?>" size="100" readonly="readonly" /></td>
                        </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                      <fieldset class="titulocampo">
                        <legend class="titulos_menu">Datos Ingreso <? if(array_search(305, $permisos) != null){?><img src="img/no_check.jpg" class="mouse" title="Modificar datos ingreso" onclick="document.location.href='modificarIngreso.php?<? echo "HOSid=$HOSid&PACid=$PACid";?>';"/><? }?></legend>
                        <table width="100%">
                            <tr>
                              <td width="14%">Servicio:</td>
                              <td width="8%"><input name="servicio" type="text" id="servicio" value="<? echo $RSAtencion['nombre']; ?>" size="8" readonly="readonly" /></td>
                              <td width="7%" align="left">Cama:</td>
                              <td width="12%"><input name="cama" type="text" id="cama" value="<? echo $RSAtencion['CAMnombre']; ?>" size="8" readonly="readonly" /></td>
                              <td width="8%" align="left">Medico:</td>
                              <td width="51%" align="left"><input name="medico" type="text" id="medico" value="<? echo $RSAtencion['medico']; ?>" size="30" readonly="readonly" /></td>
                            </tr>
                            <tr>
                              <td>Ingreso:</td>
                              <td width="8%"><input name="fecha" type="text" id="fecha" value="<? echo $RSAtencion['HOSingreso_hora']; ?>" size="8" readonly="readonly" /></td>
                              <td width="7%" align="left">Hora:</td>
                              <td width="12%"><input name="hora_ingreso" type="text" id="hora_ingreso" style="width:38px" value="<? if($RSAtencion['HOSingreso'] != '') echo $RSAtencion['HOSingreso']; else echo "--";?>" maxlength="4" readonly="readonly" /></td>
                              <td colspan="2" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>Patología Auge:</td>
                              <td colspan="5"><input name="auge" type="text" id="auge" value="<? echo $RSAtencion['pauge']; ?>" size="70" readonly="readonly" /></td>
                            </tr>
                            <tr>
                              <td width="14%">Acc. Transito:</td>
                              <td><input type="checkbox" name="accidente" id="accidente" <? if($RSAtencion['HOSaccidente']) echo "checked='checked'";?> disabled="disabled"/></td>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>Multiresistente:</td>
                              <td><input type="checkbox" name="multires" id="multires" <? if($RSAtencion['HOSmultires']) echo "checked='checked'";?> disabled="disabled"/></td>
                              <td align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                              <td colspan="2" align="right">&nbsp;</td>
                            </tr>    
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset class="titulocampo">
						<legend class="titulos_menu">Operaciones</legend>
						<table width="100%">
							<tr>
                                <td align="right">
                                	<? if($RSAtencion['HOSestado'] == 4){?>
                                	<input type="button" name="alta" id="alta" value="Alta del Paciente" onclick="javascript: document.location.href='altaPaciente.php?<?= "HOSid=$HOSid&PACid=$PACid";?>'" />
                               	  	<? }else{?>
                                    <input type="button" name="traslado" id="traslado" value="Traslado a otro Servicio" onclick="javascript: document.location.href='trasladoPaciente.php?<?= "HOSid=$HOSid&PACid=$PACid";?>'" />
								  	<? }?>
                                    <input type="button" name="historial" id="historial" value="Historial Clínico" onclick="javascript: window.open('historial_clinico.php?<?= "PACid=$PACid"?>','','titlebars=0,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,height=600,width=1000')" />
                                	<input type="button" name="atras" id="atras" value="Atras" onclick="javascript: document.location.href='listadoPacientes.php'" />
                                </td>
                            </tr>
                        </table>
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<!--<div id="modal-hora"></div>-->
</body>
</html>