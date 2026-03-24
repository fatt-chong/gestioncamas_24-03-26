<? session_start();
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
$permisos = $_SESSION['permiso'];
$borra_session = $_REQUEST['borra_session'];
$act = $_REQUEST['act'];
$que_pag = $_REQUEST['que_pag'];
$tipo_doc = $_REQUEST['tipo_doc'];
$busca = $_REQUEST['busca'];
$porCorrelativo = $_REQUEST['porCorrelativo'];

$id_paciente 	= $_REQUEST['id_paciente'];
$hospitalizado 	= $_REQUEST['hospitalizado'];
$correlativo 	= $_REQUEST['correlativo'];
$que_cod_servicio = $_REQUEST['que_cod_servicio'];

$act= $_REQUEST['act'];
$correlativo= $_REQUEST['correlativo'];
$HOSid= $_REQUEST['HOSid'];
$chekear= $_REQUEST['chekear'];
$borra_session= $_REQUEST['borra_session'];
$que_pag= $_REQUEST['que_pag'];
$pacId= $_REQUEST['pacId'];
$id_paciente= $_REQUEST['id_paciente'];
$hospitalizado= $_REQUEST['hospitalizado'];
$desde= $_REQUEST['desde'];
$totalreg= $_REQUEST['totalreg'];
$tipo_doc= $_REQUEST['tipo_doc'];
$busca= $_REQUEST['busca'];
$anio= $_REQUEST['anio'];
$porCorrelativo= $_REQUEST['porCorrelativo'];

//ELIMINA LA SESSION SI SE BUSCA UN NUEVO RUT
if($borra_session == 'si')
	unset($_SESSION['censo_diario']); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Documento sin título</title>
<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css" />
</head>
<SCRIPT LANGUAGE="JavaScript">
imgsrc=new Array(); imgsrc[1]="include/img/a_buscarboton2.gif";	imgsrc[2]="include/img/p_buscarboton2.gif"; 
img =new Array();
for (i=0; i< imgsrc.length; i++){
  img[i]=new Image();
  img[i].src=imgsrc[i];
}
function change(number, picture){
  {document[picture].src=img[number].src;}
}
</script>
<?
require_once("include/funciones/funciones.php"); 
//CONEXIONES A BD
require_once("clases/Conectar.inc");
$bd = new Conectar;
$link = $bd->db_connect();
require_once("clases/Paciente.inc");
$objPaciente = new Paciente;

//OBTENER DATOS PACIENTE
if($act == 'pac'){
	if($busca != ''){//EN CASO DE QUE SE MANDE EL RUT POR FORMULARIO
		$pacId = $objPaciente->buscaPacienteDocumento($link, $tipo_doc, $busca);
		if($pacId == '')
			$pacId=0;
	}
	if($porCorrelativo != ''){//EN CASO DE QUE SE MANDE EL CORRELATIVO
		$pacId = $objPaciente->buscaPacienteCorrelativo($link, $porCorrelativo, $anio);
	}
}
//CHECKEAR O UNCHECKEAR EL INCLUIR EN CORRELATIVO
if($chekear != ''){
	require_once("clases/Censo.inc");
	$objCenso = new Censo;
	$res = $objCenso->chekeaMovimiento($link, $chekear);
}
?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="act" id="act" />
<input type="hidden" name="correlativo" id="correlativo" value="<? echo $correlativo;?>"/>
<input type="hidden" name="HOSid" id="HOSid" value="<? echo $HOSid;?>"/>
<input type="hidden" name="chekear" id="chekear" />
<input type="hidden" name="borra_session" id="borra_session" />
<input type="hidden" name="que_pag" id="que_pag" value="<? echo $que_pag;?>" />
<input type="hidden" name="pacId" id="pacId" value="<? echo $rowPaciente['id'];?>" />
<input type="hidden" name="id_paciente" id="id_paciente" value="<? echo $id_paciente;?>"/>
<input type="hidden" name="hospitalizado" id="hospitalizado" value="<? echo $hospitalizado;?>"/>
<input type="hidden" name="desde" id="desde" value="<? echo $desde;?>"/>
<input type="hidden" name="totalreg" id="totalreg" value="<? echo $totalreg;?>"/>

<table width="982" border="1" align="center" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <th width="962" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Mantencion Censo Diario</th>
    </tr>
    <tr>
      <td>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr valign="top">
              <td>
                  <fieldset class="titulocampo">
                    <legend class="titulos_menu">Busqueda</legend>
                    <table width="100%">
                      <tr>
                        <td width="31%">
                          <select name="tipo_doc" id="tipo_doc">
                            <option value="rut" <? if($tipo_doc == 'rut') echo "selected";?>>Rut</option>
                            <option value="cta_cte" <? if($tipo_doc == 'cta_cte') echo "selected";?>>Cta Cte</option>
                            <option value="ficha" <? if($tipo_doc == 'ficha') echo "selected";?>>Ficha</option>
                          </select> <label for="busca"></label>
                          <input name="busca" type="text" id="busca" size="10" value="<? echo $busca;?>" onkeypress="return submitDocumento(event);"/>
                          <input type="button" name="ir" id="ir" value="  Ir  " onclick="javascript: document.form1.act.value='pac'; document.form1.pacId.value=''; document.form1.porCorrelativo.value=''; document.form1.que_pag.value='lis'; document.form1.borra_session.value='si'; document.form1.submit();" /></td>
                        <td width="16%"><a id="<#AWBID1>" href="buscarPaciente.php?urlLlamada=listadoCensoDiario.php" title="Busqueda en Indice de Pacientes" onMouseOver="change('1','m1')" onmouseout= "change('2','m1')" name="m1"><img src="include/img/p_buscarboton2.gif" alt="" name="m1" hspace="0" vspace="0" border="0" usemap="#m1Map" id="m1" /></a></td>
                        <td width="13%">&nbsp;</td>
                        <td width="40%">Correlativo
                        <select name="anio" id="anio">
							<? for($i = date('Y'); $i >= 2011; $i--){?>
                            <option value="<?= $i;?>" <? if($anio == $i) echo 'selected'; ?>><?= $i;?></option>
                            <? }?>
                        </select>
        				<input type="text" name="porCorrelativo" id="porCorrelativo" size="8" value="<? echo $porCorrelativo;?>" onkeypress="return submitCorrelativo(event);"/>
                        <input type="button" name="ir2" id="ir2" value="  Ir  " onclick="javascript: document.form1.act.value='pac'; document.form1.pacId.value=''; document.form1.busca.value=''; document.form1.que_pag.value='lis'; document.form1.borra_session.value='si'; document.form1.submit();" /></td>
                      </tr>
                    </table>
                  </fieldset>
              </td>
            </tr>
            <tr valign="top">
				<td width="100%">
					<? 
					switch($que_pag){
						case 'lis':		require_once("bloque_listado.php");
										
										break;
						case 'det':		require_once("bloque_detalle.php");
										
										break;									
						default: 		require_once("bloque_listado.php");
										break;
					}?>
            	</td>
            </tr>            
          </table>
    	</td>
    </tr>
</table>
</form>
</body>
<script>
function confirmaEliminar(HOSid){
	if(confirm("Usted va a Eliminar el registro, este no será considerado para el censo, ¿Desea continuar?")) {
		document.location.href="listadoCensoDiario.php?que_pag=det&act=pac&borra=si&id_paciente=<? echo $id_paciente;?>&hospitalizado=<? echo $hospitalizado;?>&que_cod_servicio=<? echo $que_cod_servicio;?>&HOSid=" + HOSid;	
	}
}
</script>
</html>