<?

if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
$id_cama= $_GET['id_cama'];
$pac_corresponde_serv= $_GET['pac_corresponde_serv'];
$pservicio= $_GET['pservicio'];
$barthel= $_GET['barthel'];
$valorBart= $_GET['valorBart'];
$cod_medico= $_GET['cod_medico'];
$nom_procedencia= $_GET['nom_procedencia'];
$diagnostico1= $_GET['diagnostico1']; 
$diagnostico2= $_GET['diagnostico2']; 
$cod_auge= $_GET['cod_auge'];
$visitas_max= $_GET['visitas_max'];
//date_default_timezone_set('America/Santiago');

require_once("include/funciones/funciones.php");

$permisos = $_SESSION['permiso'];
$dbhost = $_SESSION['BD_SERVER'];
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

//MEDICOS
$sqlMedicos = "SELECT * FROM medicos WHERE id = $cod_medico ";

$queryMedicos = mysql_query($sqlMedicos) or die(mysql_error());

$l_medicos = mysql_fetch_array($queryMedicos);
$nombre_medico = $l_medicos['medico'];

//SERVICIO Y TIPO1
$sqlServ = "SELECT * from sscc WHERE id = '$pac_corresponde_serv'";
$queryServ = mysql_query($sqlServ) or die(mysql_error());
$arrServ = mysql_fetch_assoc($queryServ);
$nomServ_corr = $arrServ['servicio'];

$tipo1_corr = cual_tipo($pac_corresponde_serv);
$arr_tipo1_corr = explode(" ",$tipo1_corr);
$cod_tipo1 = $arr_tipo1_corr[0];
$nom_tipo1 = $arr_tipo1_corr[1];
		
//PATOLOGIAS AUGE
$sqlAuge = "SELECT * FROM pauge WHERE id = $cod_auge";
	
$queryAuge = mysql_query($sqlAuge) or die(mysql_error());

$l_pauge = mysql_fetch_array($queryAuge);
$nombre_auge = $l_pauge['pauge'];

if($d_acctransito == 'on'){
	$d_acctransito = 1;
	}else{
		$d_acctransito = 0;
		}
if($d_multires == 'on'){
	$d_multires = 1;
	}else{
		$d_multires = 0;
		}
		
if($barthel != ''){
		$sqlBarthel = ",barthelSN = '$barthel'";
		}else{
			$sqlBarthel = ",barthelSN = NULL";
			}
$actulizaCama = "UPDATE listasn SET
				codMedicoSN = $cod_medico,
				nomMedicoSN = '$nombre_medico',
				codAugeSN = $cod_auge,
				nomAugeSN = '$nombre_auge',
				diagnostico1SN = '$diagnostico1',
				diagnostico2SN = '$diagnostico2',
				accTranSN = '$d_acctransito',
				desde_codServSN = $pac_corresponde_serv,
				desde_nomServSN = '$nomServ_corr',
				tipo1SN = $cod_tipo1,
				d_tipo1SN = '$nom_tipo1',
				multiresSN = '$d_multires',
				visitas_max = '$visitas_max'".$sqlBarthel."
				WHERE idListaSN = $id_cama";
$queryactualizaCama = mysql_query($actulizaCama) or die($actulizaCama. " Error al actualizar hospitalizacion ".mysql_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Detalle Atencion</title>
</head>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="483" border="0" style="border:1px solid #000000;" align="center" cellpadding="4" cellspacing="4" background="../ingresos/img/fondo.jpg">
<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Datos de Hospitalizaci&oacute;n.</th>
    <tr>
        <td>
		<fieldset><legend class="titulos">Informacion</legend>
        <? if($actulizaCama){ ?>
        <table style="font-size: 14px; font-family: Verdana, Geneva, sans-serif; color: #000" width="333" border="0" align="center" cellpadding="5" cellspacing="10">
        	<tr>
            	<td>
                
                ¡Los datos de Hospitalizacion del paciente han sido actualizados correctamente!
                
                </td>
            </tr>
            <tr>
            	<td align="center">
                <input type="button" name="volver" value="Aceptar" onclick="window.location.href='<? echo"camaSuperNum.php"; ?>'; parent.GB_hide(); " />
                </td>
            </tr>
        </table>
        <? }else{ ?>
        <table style="font-size: 14px; font-family: Verdana, Geneva, sans-serif; color: #000" width="333" border="0" align="center" cellpadding="5" cellspacing="10">
        	<tr>
            	<td>
                
                ¡ERROR AL ACTUALIZAR LOS DATOS DE HOSPITALIZACION!
                
                </td>
            </tr>
            <tr>
            	<td align="center">
                <input type="button" name="volver" value="Aceptar" onclick="window.location.href='<? echo"camaSuperNum.php"; ?>'; parent.GB_hide(); " />
                </td>
            </tr>
        </table>
        
        <? } ?> 
        </fieldset>
      </td>
    </tr>
</table>
</body>
</html>