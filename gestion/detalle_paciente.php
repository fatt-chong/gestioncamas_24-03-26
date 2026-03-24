<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../../rau/listaEspera_rau/lista_rau.php";
	header(sprintf("Location: %s", $GoTo));
}
$permisos = $_SESSION['permiso']; 
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_query("SET NAMES 'utf8'");
include ('funciones/funciones.php');

mysql_select_db('rau') or die(mysql_error());

$sqlPaciente = "SELECT * FROM camas_urgencia WHERE id_camaUrg = $id_cama";
$queryPaciente = mysql_query($sqlPaciente) or die("ERROR AL SELECCIONAR DATOS DEL PACIENTE ".mysql_error());
$arrayPaciente =mysql_fetch_array($queryPaciente);
$servicio = $arrayPaciente['id_servicio'];
$rut = $arrayPaciente['rut_paciente'];
$preDiagnos = $arrayPaciente['pre_diagnostico'];

//SELECCIONA LOS SERVICIOS PARA HACER EL TRASLADO
mysql_select_db('camas') or die(mysql_error());
$sqlServicio = mysql_query("SELECT * FROM sscc WHERE id < 50 ") or die("ERROR AL SELECCIONAR SERVICIO ".mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estiloMapa.css" />
<title>Listado Pacientes</title>
</head>

<script>

window.onload=function(){
	setInterval('disableCombos()',10);
	setInterval('disableBoton()',10);
	setInterval('disableBoton2()',10);
}
</script>

<body>
<form id="form_detalle" name="form_detalle" method="get">
<input type="hidden" name="id_cama" id="id_cama" value="<? echo $id_cama; ?>" />
<input type="hidden" name="id_paciente" id="id_paciente" value="<? echo $arrayPaciente['id_paciente']; ?>" />
<input type="hidden" name="cta_cte" id="cta_cte" value="<? echo $arrayPaciente['cta_cte']; ?>" />
<input type="hidden" name="act" id="act"  />
<table  width="658" border="0" style="border:1px solid #000000;" align="center" cellpadding="4" cellspacing="4" class="fondoTabla">
    <th width="647" height="25" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Detalle Paciente Urgencia
</th>
<tr class="titulocampo">
	<td align="right">
    N° Rau
    <input size="8" type="text" readonly="readonly" name="idRau" id="idRau" value="<? echo $idRau; ?>" />
    </td>
</tr>
    
    <tr> 
    	<td>
        <fieldset><legend class="titulos_menu">Datos del Paciente</legend>
        <table width="100%" class="titulocampo" >
        	<tr>
            	<td width="69">Nombre :
                </td>
                <td width="247">
                <input readonly="readonly" size="40" type="text" name="nom_paciente" value="<? echo $arrayPaciente['nom_paciente']; ?>" />
                </td>
                <td width="67">Edad :
                </td>
                <td width="221"><input readonly="readonly" size="5" type="text" name="edad_paciente" value="<? echo $arrayPaciente['edad_paciente']; ?>" /></td>

          </tr>
          <tr>
            	<td>Rut :
                </td>
                <td>
            	  <input readonly="readonly" size="9" type="text" name="rut_paciente" value="<? echo $rut; ?>" />-
                  <input readonly="readonly" size="1" type="text" name="digito" value="<? echo ValidaDVRut($rut); ?>" />
                </td>
                <td>Ficha:
                </td>
                <td>
                  <input readonly="readonly" size="10" type="text" name="ficha_paciente" value="<? echo $arrayPaciente['ficha_paciente']; ?>" /></td>

          </tr>
          <tr>
            	<td>Direccion :</td>
                <td>
                <input readonly="readonly" size="40" type="text" name="direc_paciente" value="<? echo $arrayPaciente['direc_paciente']; ?>" />
                </td>
                <td>Prevision:</td>
                <td>
                <input readonly="readonly" size="15" type="text" name="prev_paciente" value="<? echo $arrayPaciente['prevision']; ?>" /></td>

          </tr>
          
        </table>
        </fieldset>
        <fieldset><legend class="titulos_menu">Datos Urgencia</legend>
       	<table class="titulocampo">
        	<tr>
            	<td>
                Causa:
                </td>
                <td colspan="4">
                <input size="50" readonly="readonly" type="text" name="causa" value="<? echo $arrayPaciente['descConsulta'];?>" />
                </td>
            </tr>
            <tr>
                <td>Fecha RAU :
                </td>
                <td><input size="10" type="text" readonly="readonly" name="fecha_ing" value="<? echo cambiarFormatoFecha($arrayPaciente['fecha_rau']); ?>" />
                </td>
                <td>Hora :
                </td>
                <td><input size="5" type="text" readonly="readonly" name="hora_ing" value="<? echo $arrayPaciente['hora_rau']; ?>" />
                </td>
          </tr>
          
          <tr>
                <td>Fecha Categ. :
                </td>
                <td><input size="10" type="text" readonly="readonly" name="fecha_cat" value="<? echo cambiarFormatoFecha($arrayPaciente['fecha_categ']); ?>" />
                </td>
                <td>Hora :
                </td>
                <td><input size="5" type="text" readonly="readonly" name="hora_cat" value="<? echo $arrayPaciente['hora_categ']; ?>" />
                </td>
                <td> Categorizacion: 
                </td>
                <td><input size="5" type="text" readonly="readonly" name="cat" value="<? echo $arrayPaciente['categorizacion']; ?>" />
                </td>
          </tr>
          
            <tr>
                <td>Fecha Ingreso :
                </td>
                <td><input size="10" type="text" readonly="readonly" name="fecha_ing" value="<? echo cambiarFormatoFecha($arrayPaciente['fecha_ingreso']); ?>" />
                </td>
                <td>Hora :
                </td>
                <td><input size="5" type="text" readonly="readonly" name="hora_ing" value="<? echo $arrayPaciente['hora_ingreso']; ?>" />
                </td>
          </tr>
          
          <tr>
                <td>Fecha Indicacion :
                </td>
                <td><input size="10" type="text" readonly="readonly" name="fecha_ind" value="<? echo cambiarFormatoFecha($arrayPaciente['fecha_indicacion']); ?>" />
                </td>
                <td>Hora :
                </td>
                <td><input size="5" type="text" readonly="readonly" name="hora_ind" value="<? echo $arrayPaciente['hora_indicacion']; ?>" />
                </td>
          </tr>
          <tr>
          	<td>
            Indicacion Egreso:
            </td>
            <td>
            	<select name="estado" id="estado" >
                	<option value="2" <? if($arrayPaciente['estado'] == 2){ ?> selected="selected" <? } ?> >Seleccione</option>
                	<option value="3" <? if($arrayPaciente['estado'] == 3){ ?> selected="selected" <? } ?> >Alta Hogar</option>
                    <? if( array_search(297, $permisos) != null ){ ?><option value="4" <? if($arrayPaciente['estado'] == 4){ ?> selected="selected" <? } ?>>Hospitalizacion</option><? } ?>
                    <option value="5" <? if($arrayPaciente['estado'] == 5){ ?> selected="selected" <? } ?>>Rechaza Hospt.</option>
                    <option value="6" <? if($arrayPaciente['estado'] == 6){ ?> selected="selected" <? } ?>>Defuncion</option>
                </select>
            </td>
          </tr>
          <? if( array_search(297, $permisos) != null ){ ?>
          <tr>
          	<td>
            Servicio Destino:
            </td>
            <td>
            <select name="servicio_tras" id="servicio_tras">
           
            <? while($arrayServicios = mysql_fetch_array($sqlServicio)){
				$id_servicio = $arrayServicios['id_rau'];
				$nom_servicio = $arrayServicios['servicio'];
				
				?>
                <option value="<? echo $id_servicio; ?>" <? if($servicio==$id_servicio){?> selected="selected" <? } ?>><? echo $nom_servicio; ?></option>
            <? }?>
            </select>
            </td>
          </tr>
          <tr>
          	<td>Pre-Diagnostico:</td>
            <td colspan="5"><input type="text" name="preDiagnostico" id="preDiagnostico" size="70" value="<? echo $preDiagnos; ?>" />
            </td>
          </tr>
         <? } ?>
        </table>
        </fieldset>
         <fieldset><legend class="titulos_menu">Operaciones</legend>
       	<table class="titulocampo" align="right">
            <tr>
                <td><input type="button" name="atras" id="atras" value="   Atras   " onclick="javascript: document.location.href='lista_rau.php'" />
                </td>
          </tr>
          
        </table>
        </fieldset>
        </td>   
    </tr>
    
</table>
</form>
</body>
</html>