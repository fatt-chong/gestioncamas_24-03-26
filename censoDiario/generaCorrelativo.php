<? session_start(); 
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
$act= $_POST['act'];
$correlativo= $_POST['correlativo'];
$HOSid= $_POST['HOSid'];
$chekear= $_POST['chekear'];
$borra_session= $_POST['borra_session'];
$que_pag= $_POST['que_pag'];
$pacId= $_POST['pacId'];
$id_paciente= $_POST['id_paciente'];
$hospitalizado= $_POST['hospitalizado'];
$desde= $_POST['desde'];
$totalreg= $_POST['totalreg'];
$tipo_doc= $_POST['tipo_doc'];
$busca= $_POST['busca'];
$anio= $_POST['anio'];
$porCorrelativo= $_POST['porCorrelativo'];
$pacRut= $_POST['pacRut'];
$digito= $_POST['digito'];
$ficha= $_POST['ficha'];
$ficha2= $_POST['ficha2'];
$pacPrevision= $_POST['pacPrevision']; 
$pacNombre= $_POST['pacNombre'];
$pacSexo= $_POST['pacSexo'];
$fecha_nac= $_POST['fecha_nac'];
$pacDireccion= $_POST['pacDireccion']; 
$medico= $_POST['medico'];
$medico2= $_POST['medico2'];
$diagnostico1= $_POST['diagnostico1'];
$diagnostico2= $_POST['diagnostico2'];
$incluye= $_POST['incluye'];


$que_cod_servicio =$_POST['que_cod_servicio'];
$anio_egreso = $_POST['anio_egreso'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Asociar componente sanguineo</title>
<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css" />
</head>
<? //:::CARGA DE DATOS DEL FORMULARIO::://
//CONEXIONES A BD
require_once("clases/Conectar.inc");
$bd = new Conectar;
$link = $bd->db_connect();

//OBTENER DATOS PACIENTE
$bd->db_select("paciente",$link);
require_once("clases/Paciente.inc");
$objPaciente = new Paciente;
$rowPaciente = $objPaciente->getPaciente($link, $id_paciente);
$digito = $objPaciente->generaDigito($rowPaciente['rut']);
$fecha_nac = $objPaciente->invierteFecha($rowPaciente['fechanac']);

//CARGA EN PANTALLA SOLO LOS MOVIMIENTOS DE HOSPITALIZACION QUE HAYAN SIDO MARCADO PARA INCLUIR EN CORRELATIVO
$bd->db_select("camas",$link);
require_once("clases/Censo.inc");
$objCenso = new Censo;
$lista = $objCenso->cargaSoloMarcados();

//GRABA LOS CAMBIOS REALIZADOS EN SESSION A LOS REGISTERO EN LA BD CAMAS.HOSPITALIZACION
if($act == 'grabar'){
	$arrayDatos = $objCenso->generaCorrelativo($link, $anio_egreso);
	if($arrayDatos['correlativoGenerado'])
		$objCenso->grabarEnProduccion($arrayDatos['correlativoGenerado'], $link);
}
?>
<body>
<form name="form1" id="form1" action="generaCorrelativo.php" method="post">
<input type="hidden" name="act" id="act" />
<input type="hidden" name="borra_session" id="borra_session" />
<input type="hidden" name="que_pag" id="que_pag" />
<input type="hidden" name="id_paciente" id="id_paciente" value="<? echo $id_paciente;?>" />
<input type="hidden" name="hospitalizado" id="hospitalizado" value="<? echo $hospitalizado;?>" />
<input type="hidden" name="que_cod_servicio" id="que_cod_servicio" value="<? echo $que_cod_servicio;?>" />
<table width="750" align="center" bgcolor="#EBEBEB" cellpadding="5">
    <tr>
        <th align="left" bgcolor="#999999" style="font-size:18px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Correlativo egreso Hospitalario</th>
    </tr>
    <tr>
        <td>
        <fieldset class="titulocampo">
        <legend class="titulos_menu">IDENTIFICACIón del paciente</legend>
        <table width="100%">
            <tr>
                <td width="10%" align="left" valign="middle">Rut</td>
                <td width="90%" align="left" valign="middle"><input name="pacRut" type="text" id="pacRut" value="<? echo $rowPaciente['rut'];?>" size="8" readonly="readonly"/>
                  -
                    <input name="digito" type="text" class="casilla_chica" id="digito" value="<? echo $digito;?>" size="1" readonly="readonly" />
                    Ficha
                    
                  <input name="ficha" type="text" id="ficha" value="<? echo $rowPaciente['nroficha']; ?>" size="10" readonly="readonly" />
                    Previsión
                    <input name="pacPrevision" type="text" id="pacPrevision" value="<? echo $rowPaciente['nom_prev']; ?>" size="20" readonly="readonly" /></td>
            </tr>
            <tr>
              <td>
              Nombre</td>
              <td>
                <input name="pacNombre" type="text" id="pacNombre" value="<? echo $rowPaciente['nombres']." ".$rowPaciente['apellidopat']." ".$rowPaciente['apellidomat']; ?>" size="50" readonly="readonly" />
                
                Sexo
                <input name="pacSexo" type="text" class="casilla_media" id="pacSexo" value="<? echo $rowPaciente['sexo']; ?>" size="2" readonly="readonly"/>
                
                Fecha Nac
                <input name="fecha_nac" type="text" id="fecha_nac" value="<? echo $fecha_nac; ?>" size="6" readonly="readonly"/>
                
              </td>
              </tr>
            <tr>
              <td>Dirección</td>
              <td><input name="pacDireccion" type="text" id="pacDireccion" value="<? echo $rowPaciente['direccion']; ?>" size="50" readonly="readonly" /></td>
            </tr>
    	</table>
        </fieldset>
        <fieldset class="titulocampo">
        <legend class="titulos_menu">Datos hospitalización</legend>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr bgcolor="#999999" style="color:#FFF">
                <th width="4%" height="31" rowspan="2" align="center" valign="middle">N°</th>
                <th width="19%" rowspan="2" align="center" valign="middle">SERVICIO</th>
                <th colspan="2" align="center" valign="middle">INGRESO</th>
                <th colspan="2" align="center" valign="middle">EGRESO</th>
            </tr>
            <tr bgcolor="#999999" style="color:#FFF">
                <th width="14%" height="15" align="center" valign="middle">Fecha</th>
                <th width="14%" align="center" valign="middle">Procedencia</th>
                <th width="14%" align="center" valign="middle">Fecha</th>
                <th width="14%" align="center" valign="middle">Destino</th>
            </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <? 	$i=1;
				foreach($lista as $k => $v){ 
					$anio_censo = substr($v['fecha_egreso'], 0,4);
					$fecha_ingreso = $objPaciente->invierteFecha($v['fecha_ingreso']);
					$fecha_egreso = $objPaciente->invierteFecha($v['fecha_egreso']); ?>
					<tr>
					  <td width="4%" height="34" align="center" valign="middle"><? echo $i;?></td>
					  <td width="19%" align="center" valign="middle"><? echo $v['servicio'];?></td>
					  <td width="14%" align="center" valign="middle"><? echo $fecha_ingreso." ".$v['hora_ingreso'];?></td>
					  <td width="14%" align="center" valign="middle"><? echo $v['procedencia'];?></td>
					  <td width="14%" align="center" valign="middle"><? echo $fecha_egreso." ".$v['hora_egreso'];?></td>
                      <input type="hidden" name="anio_egreso" value="<? echo $anio_censo; ?>"  />
					  <td width="14%" align="center" valign="middle"><? echo $v['destino']; ?></td>
					  
					</tr>
				<? $i++; 
				}
               ?>
        </table>
    	</fieldset>
    	</td>
    </tr>
    <tr>
        <td>
        <fieldset class="titulocampo">
        <legend class="titulos_menu">correlativo de egreso</legend>
        <? if($objCenso->chekeaAltaUltimo()){?>
			  <? if($act == 'grabar' && $arrayDatos['correlativoGenerado']){?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="70" align="center" valign="middle" style="font-size:16px; font-family:Arial, Helvetica, sans-serif;">¡CORRELATIVO DE EGRESO GENERADO!, <br />
                            NÚMERO  CORRELATIVO:<br /> #<? echo $arrayDatos['correlativoGenerado'];?></td>
                        </tr>
                        <tr>
                            <td height="20" align="center" valign="middle"><input type="button" name="volver" id="volver" value="   Aceptar    " onclick="javascript: document.location.href='listadoCensoDiario.php?borra_session=si&act=pac&amp;que_pag=det&id_paciente=<? echo $id_paciente;?>&tipo_doc=<? echo $tipo_doc;?>&busca=<? echo $busca;?>&hospitalizado=<? echo $arrayDatos['hospitalizadoActualizado'];?>&correlativo=<? echo $arrayDatos['correlativoGenerado']; ?>&que_cod_servicio=<? echo $que_cod_servicio;?>';" />
                            <input type="button" name="volver2" id="volver2" value="   Imprimir Egreso    " onclick="javascript: window.open('imprimeEgreso.php?id_paciente=<? echo $id_paciente;?>&hospitalizado=<? echo $arrayDatos['hospitalizadoActualizado'];?>&correlativo=<? echo $arrayDatos['correlativoGenerado']; ?>','','titlebars=0,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,height=700,width=1000');" /></td>
                        </tr>            
                    </table>
                    <? }else if($act == 'grabar' && $arrayDatos == false){ ?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="70" align="center" valign="middle" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#F00;">¡NO SE GENERÓ UN  CORRELATIVO!<br />
                              LA HOSPITALIZACION YA POSEE UN CORRELATIVO GENERADO<br />
                              REALICE LA BUSQUEDA DEL PACIENTE NUEVAMENTE</td>
                        </tr>
                        <tr>
                          <td height="20" align="center" valign="middle"><input type="button" name="volver" id="volver" value="   Aceptar    " onclick="javascript: document.location.href='listadoCensoDiario.php?borra_session=si';" /></td>
                        </tr>            
                    </table>
                    <? }else{?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="70" align="center" valign="middle" style="font-size:16px; font-family:Arial, Helvetica, sans-serif;">SE GENERARÁ EL CORRELATIVO DE EGRESO PARA<br /> LOS REGISTROS DE HOSPITALIZACIÓN<br /> ¿DESEA CONTINUAR?</td>
                        </tr>
                        <tr>
                          <td height="20" align="center" valign="middle"><input type="button" name="aceptar" id="aceptar" value="     Grabar     " onclick="javascript: document.form1.act.value='grabar'; document.form1.submit();" />
                            <input type="button" name="volver" id="volver" value="   Volver   " onclick="javascript: document.form1.act.value='pac'; document.form1.que_pag.value='det'; document.form1.action='listadoCensoDiario.php'; document.form1.submit();" /></td>
                        </tr>            
                    </table>
                    <? }?>
        <? }else{?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="70" align="center" valign="middle" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#F00;">¡NO SE ASIGNÓ DESTINO COMO ALTA!<br />
                              LA HOSPITALIZACION  NO POSEE EL DESTINO FINAL COMO ALTA<br />
                              DEBE SELECCIONAR UN DESTINO DE ALTA (ej: Alta Hogar, Defunción, etc.)</td>
                        </tr>
                        <tr>
                          <td height="20" align="center" valign="middle"><input type="button" name="volver" id="volver" value="   Volver   " onclick="javascript: document.form1.act.value='pac'; document.form1.que_pag.value='det'; document.form1.action='listadoCensoDiario.php'; document.form1.submit();" /></td>
                        </tr>            
        </table>
        <? }?>
        </fieldset>
        </td>
    </tr>
</table>
</form>
</html>