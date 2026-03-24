<?php 
//date_default_timezone_set('America/Santiago');

//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$id_cama	= $_GET['id_cama'];
$id_paciente = $_GET['id_paciente'];
$desde		= $_GET['desde'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script type="text/javascript">

function activaboton(){
	document.formulario.btn_aceptar.disabled = false
}

function suma_uno() {
	document.formulario.glicemia.value++
}

function resta_uno() {
	document.formulario.glicemia.value--
}

function procesa(){
	
	if (document.formulario.ev_1[0].checked) { var ev_1 = 0 }
	if (document.formulario.ev_1[1].checked) { var ev_1 = 1 }
	if (document.formulario.ev_1[2].checked) { var ev_1 = 2 }
	if (document.formulario.ev_1[3].checked) { var ev_1 = 3 }
	
	if (document.formulario.ev_2[0].checked) { var ev_2 = 0 }
	if (document.formulario.ev_2[1].checked) { var ev_2 = 1 }
	if (document.formulario.ev_2[2].checked) { var ev_2 = 2 }
	if (document.formulario.ev_2[3].checked) { var ev_2 = 3 }
	
	if (document.formulario.ev_3[0].checked) { var ev_3 = 0 }
	if (document.formulario.ev_3[1].checked) { var ev_3 = 1 }
	if (document.formulario.ev_3[2].checked) { var ev_3 = 2 }
	if (document.formulario.ev_3[3].checked) { var ev_3 = 3 }
	
	if (document.formulario.ev_4[0].checked) { var ev_4 = 0 }
	if (document.formulario.ev_4[1].checked) { var ev_4 = 1 }
	if (document.formulario.ev_4[2].checked) { var ev_4 = 2 }
	if (document.formulario.ev_4[3].checked) { var ev_4 = 3 }
	
	if (document.formulario.ev_5[0].checked) { var ev_5 = 0 }
	if (document.formulario.ev_5[1].checked) { var ev_5 = 1 }
	if (document.formulario.ev_5[2].checked) { var ev_5 = 2 }
	if (document.formulario.ev_5[3].checked) { var ev_5 = 3 }
	
	if (document.formulario.ev_6[0].checked) { var ev_6 = 0 }
	if (document.formulario.ev_6[1].checked) { var ev_6 = 1 }
	if (document.formulario.ev_6[2].checked) { var ev_6 = 2 }
	if (document.formulario.ev_6[3].checked) { var ev_6 = 3 }
	
	if (document.formulario.ev_7[0].checked) { var ev_7 = 0 }
	if (document.formulario.ev_7[1].checked) { var ev_7 = 1 }
	if (document.formulario.ev_7[2].checked) { var ev_7 = 2 }
	if (document.formulario.ev_7[3].checked) { var ev_7 = 3 }
	
	if (document.formulario.ev_8[0].checked) { var ev_8 = 0 }
	if (document.formulario.ev_8[1].checked) { var ev_8 = 1 }
	if (document.formulario.ev_8[2].checked) { var ev_8 = 2 }
	if (document.formulario.ev_8[3].checked) { var ev_8 = 3 }
	
	var total_riesgo = ev_1 + ev_2 + ev_3 + ev_4 + ev_5 + ev_6 + ev_7 + ev_8
	document.formulario.total_riesgo.value = total_riesgo
   
	if (total_riesgo < 6) { var categorizacion_riesgo = 'D' }
	if (total_riesgo > 5 && total_riesgo < 12) { var categorizacion_riesgo = 'C' } 
	if (total_riesgo > 11 && total_riesgo < 19) { var categorizacion_riesgo = 'B' }
	if (total_riesgo > 18) { var categorizacion_riesgo = 'A' }

	if (document.formulario.ev_9[0].checked) { var ev_9 = 0 }
	if (document.formulario.ev_9[1].checked) { var ev_9 = 1 }
	if (document.formulario.ev_9[2].checked) { var ev_9 = 2 }
	if (document.formulario.ev_9[3].checked) { var ev_9 = 3 }
	
	if (document.formulario.ev_10[0].checked) { var ev_10 = 0 }
	if (document.formulario.ev_10[1].checked) { var ev_10 = 1 }
	if (document.formulario.ev_10[2].checked) { var ev_10 = 2 }
	if (document.formulario.ev_10[3].checked) { var ev_10 = 3 }
	
	if (document.formulario.ev_11[0].checked) { var ev_11 = 0 }
	if (document.formulario.ev_11[1].checked) { var ev_11 = 1 }
	if (document.formulario.ev_11[2].checked) { var ev_11 = 2 }
	if (document.formulario.ev_11[3].checked) { var ev_11 = 3 }
	
	if (document.formulario.ev_12[0].checked) { var ev_12 = 0 }
	if (document.formulario.ev_12[1].checked) { var ev_12 = 1 }
	if (document.formulario.ev_12[2].checked) { var ev_12 = 2 }
	if (document.formulario.ev_12[3].checked) { var ev_12 = 3 }
	
	if (document.formulario.ev_13[0].checked) { var ev_13 = 0 }
	if (document.formulario.ev_13[1].checked) { var ev_13 = 1 }
	if (document.formulario.ev_13[2].checked) { var ev_13 = 2 }
	if (document.formulario.ev_13[3].checked) { var ev_13 = 3 }
	
	if (document.formulario.ev_14[0].checked) { var ev_14 = 0 }
	if (document.formulario.ev_14[1].checked) { var ev_14 = 1 }
	if (document.formulario.ev_14[2].checked) { var ev_14 = 2 }
	if (document.formulario.ev_14[3].checked) { var ev_14 = 3 }
	
	var total_dependencia = ev_9 + ev_10 + ev_11 + ev_12 + ev_13 + ev_14
	document.formulario.total_dependencia.value = total_dependencia

	if (total_dependencia < 7) { var categorizacion_dependencia = '3'; }
	if (total_dependencia > 6 && total_dependencia < 13) { var categorizacion_dependencia = '2'; } 
	if (total_dependencia > 12) { var categorizacion_dependencia = '1'; }

	document.formulario.categorizacion_riesgo.value = categorizacion_riesgo
	document.formulario.categorizacion_dependencia.value = categorizacion_dependencia
	document.formulario.categorizacion_final.value = categorizacion_riesgo+categorizacion_dependencia
   
   
}
</script>

</head>


<?

include "../funciones/funciones.php";

$permisos = $_SESSION['permiso'];

$fecha_hoy 	= date('d-m-Y');
$fechaHoy 	= date('d-m-Y');
$fecha_categoriza = cambiarFormatoFecha($fecha_hoy);

$cod_usuario = 1;
$usuario = $_SESSION['MM_Username'];
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$sqlLista = "SELECT *
			FROM
			listasn
			INNER JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
			WHERE idListaSN  = '$id_cama'";

$queryLista = mysql_query($sqlLista);
$arrayLista =mysql_fetch_array($queryLista);

$cod_servicio = $arrayLista['que_codServSN'];
$desc_servicio = $arrayLista['que_nomServSN'];
$sala = $arrayLista['que_salaSN'];
$tipo_1 = $arrayLista['tipo1SN'];
$d_tipo_1 = $arrayLista['d_tipo1SN'];
$tipo2 = $arrayLista['tipo2SN'];
$d_tipo_2 = $arrayLista['d_tipo2SN'];
$nom_paciente = $arrayLista['nomPacienteSN'];
$cama = $arrayLista['que_camaSN'];
$sala_sn = $arrayLista['salaCamaSN'];
$ctacte = $arrayLista['ctaCteSN'];
$ctacteCama = $arrayLista['ctaCteSN'];
$sqlCabecera = "SELECT 
				*
				FROM cabecera_kine
				WHERE
				cabecera_kine.CKIctacte = '$ctacte' 
				AND
				DATE_FORMAT(cabecera_kine.CKIfecha_registro,'%d-%m-%Y') = '$fechaHoy'";
$queryCabecera 	= mysql_query($sqlCabecera);
$arrayCabecera 	= mysql_fetch_array($queryCabecera);
$idCategoriza 	= $arrayCabecera['CKIid'];

switch ($sala_sn) {
    case 1:
		$cod_servicio = 97;
		$desc_servicio = 'SN Maternidad';
		$tipo_1 = 97;
		$d_tipo_1 = 'SN Maternidad';
		break;
	case 3:
		$cod_servicio = 98;
		$desc_servicio = 'CMI';
		$tipo_1 = 98;
		$d_tipo_1 = 'CMI';
		break;
	case 'Pensionado':
		$cod_servicio = 98;
		$desc_servicio = 'CMI';
		$tipo_1 = 98;
		$d_tipo_1 = 'CMI';
		break;
	case 'CMI 3':
		$cod_servicio = 98;
		$desc_servicio = 'CMI';
		$tipo_1 = 98;
		$d_tipo_1 = 'CMI';
		break;
	case 6:
		$cod_servicio = 99;
		$desc_servicio = '6to piso';
		$tipo_1 = 99;
		$d_tipo_1 = '6to piso';
		break;
}
$sql="SELECT
					listasn.idListaSN,
					categorizacion.kinesiologicos,
					categorizacion.fecha,
					kinesiterapia.kine_tipo_respiratoria,
					kinesiterapia.kine_tipo_neurologica,
					kinesiterapia.kine_tipo_motora,
					kinesiterapia.kine_kinesiologo,
					kinesiterapia.kine_id,
					kinesiterapia.kine_f_h_ingresado
					FROM
					listasn
					INNER JOIN categorizacion ON listasn.ctaCteSN = categorizacion.ctacte_paciente
					INNER JOIN kinesiterapia ON categorizacion.ctacte_paciente = kinesiterapia.kine_ctacte AND categorizacion.fecha = date(kinesiterapia.kine_f_h_ingresado)
					WHERE categorizacion.kinesiologicos IN ('1','2','3','4') and categorizacion.fecha = date(CURDATE()) and listasn.idListaSN = '$id_cama'";
			mysql_query("SET NAMES utf8");
			$querykines = mysql_query($sql) or die(mysql_error());
$cantidadderesultados = mysql_num_rows($querykines);

$sql = "SELECT * FROM categorizacion where id_paciente = '$id_paciente' AND fecha = '$fecha_categoriza'";

$query = mysql_query($sql) or die(mysql_error());

$categoriza = mysql_fetch_array($query);

$total_riesgo = 0;

$total_dependencia = 0;

$estado_1 = 0;
$estado_2 = 0;

$glicemia = 0;
$d_smtp = 0;

if ($categoriza)
{
	$estado_1 = $categoriza['estado_1'];
	$estado_2 = $categoriza['estado_2'];
	$glicemia = $categoriza['glicemia'];
	$smpt = $categoriza['smpt'];
	$ev_1 = $categoriza['ev_1'];
	$ev_2 = $categoriza['ev_2'];
	$ev_3 = $categoriza['ev_3'];
	$ev_4 = $categoriza['ev_4'];
	$ev_5 = $categoriza['ev_5'];
	$ev_6 = $categoriza['ev_6'];
	$ev_7 = $categoriza['ev_7'];
	$ev_8 = $categoriza['ev_8'];
	$ev_9 = $categoriza['ev_9'];
	$ev_10 = $categoriza['ev_10'];
	$ev_11 = $categoriza['ev_11'];
	$ev_12 = $categoriza['ev_12'];
	$ev_13 = $categoriza['ev_13'];
	$ev_14 = $categoriza['ev_14'];
	$observacion = $categoriza['observacion'];
	$kinesiologicos = $categoriza['kinesiologicos'];


	$total_riesgo = $ev_1 + $ev_2 + $ev_3 + $ev_4 + $ev_5 + $ev_6 + $ev_7 + $ev_8;
	$total_dependencia = $ev_9 + $ev_10 + $ev_11 + $ev_12 + $ev_13 + $ev_14;
	
}

if ($total_riesgo < 6) { $categorizacion_riesgo = 'D'; }

if ($total_riesgo > 5 and $total_riesgo < 12) { $categorizacion_riesgo = 'C'; } 

if ($total_riesgo > 11 and $total_riesgo < 19) { $categorizacion_riesgo = 'B'; }

if ($total_riesgo > 18) { $categorizacion_riesgo = 'A'; }


if ($total_dependencia < 7) { $categorizacion_dependencia = '3'; }

if ($total_dependencia > 6 and $total_dependencia < 13) { $categorizacion_dependencia = '2'; } 

if ($total_dependencia > 12) { $categorizacion_dependencia = '1'; }

$categorizacion_final = $categorizacion_riesgo.''. $categorizacion_dependencia;

?>

<body topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <td >
            	<fieldset class="fondoF"><legend class="estilo1">Categorizacion del Paciente X</legend>

<div style="text-align:center" align="center">
<form method="get" name="formulario" action="sql_categorizaSN.php">

    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
    <input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
    <input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
    <input type="hidden" name="sala" value="<? echo $sala_sn ?>" />
    <input type="hidden" name="tipo_1" value="<? echo $tipo_1 ?>" />
    <input type="hidden" name="d_tipo_1" value="<? echo $d_tipo_1 ?>" />
    <input type="hidden" name="tipo_2" value="<? echo $tipo_2 ?>" />
    <input type="hidden" name="d_tipo_2" value="<? echo $d_tipo_2 ?>" />
    <input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
    <input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
    <input type="hidden" name="cama" value="<? echo $cama ?>" />
    <input type="hidden" name="cod_usuario" value="<? echo $cod_usuario ?>" />
    <input type="hidden" name="usuario" value="<? echo $usuario ?>" />
    <input type="hidden" name="desde" value="<? echo $desde ?>" />
    <input type="hidden" name="ctacte" value="<? echo $ctacte ?>" />
    

    <table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr align="left">
            <td colspan="3">
                <fieldset>
                <legend style="font-size:14px">Informacion de Paciente</legend>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr><td width="20px" height="5px"></td><td width="160px"></td></tr>
                        <tr><td></td><td style="font-size:14px">Serv.Cl�nico <? echo $desc_servicio ?>  --  Sala <? echo $sala ?>  --  Cama N� <? echo $cama ?> -- <strong> <? echo $d_tipo_1." ".$d_tipo_2; ?> </strong></td></tr>
                        <tr><td></td><td style="font-size:14px">Paciente    : <? echo $nom_paciente ?> </td></tr>
                        <tr><td></td><td style="font-size:14px">Diagnostico : <? echo $diagnostico2 ?> </td></tr>
                    </table>
                </fieldset>
            </td>
        </tr>
        
        <tr>
            <td>
                <fieldset>
                <legend style="font-size:14px">Evaluaci�n de Riesgo</legend>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="listado">
                        <tr>
                            <td>Evaluaci�n</td>
                            <td >0</td>
                            <td >1</td>
                            <td >2</td>
                            <td >3</td>
                        </tr>
                        <tr>
                            <td align="left">Medicion Signos Vitales</td>
                            <td> <input type="radio" name="ev_1" value="0" <? if ($ev_1 == 0) { echo "checked='checked'"; } ?> 
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_1" value="1" <? if ($ev_1 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_1" value="2" <? if ($ev_1 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_1" value="3" <? if ($ev_1 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                        </tr>
                        <tr>
                            <td align="left">Balance Hidrico</td>
                            <td> <input type="radio" name="ev_2" value="0" <? if ($ev_2 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_2" value="1" <? if ($ev_2 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_2" value="2" <? if ($ev_2 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                            <td> <input type="radio" name="ev_2" value="3" <? if ($ev_2 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /></td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados Oxigenoterapia</td>
                            <td> <input type="radio" name="ev_3" value="0" <? if ($ev_3 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_3" value="1" <? if ($ev_3 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_3" value="2" <? if ($ev_3 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_3" value="3" <? if ($ev_3 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados Diarios de V. Aerea</td>
                            <td> <input type="radio" name="ev_4" value="0" <? if ($ev_4 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_4" value="1" <? if ($ev_4 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_4" value="2" <? if ($ev_4 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_4" value="3" <? if ($ev_4 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Intervenciones Profesionales</td>
                            <td> <input type="radio" name="ev_5" value="0" <? if ($ev_5 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_5" value="1" <? if ($ev_5 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_5" value="2" <? if ($ev_5 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_5" value="3" <? if ($ev_5 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados Piel y Curaciones</td>
                            <td> <input type="radio" name="ev_6" value="0" <? if ($ev_6 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_6" value="1" <? if ($ev_6 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_6" value="2" <? if ($ev_6 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_6" value="3" <? if ($ev_6 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Adm. Tratam. Farmacologico</td>
                            <td> <input type="radio" name="ev_7" value="0" <? if ($ev_7 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_7" value="1" <? if ($ev_7 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_7" value="2" <? if ($ev_7 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_7" value="3" <? if ($ev_7 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Presencia Elem. Invasivos</td>
                            <td> <input type="radio" name="ev_8" value="0" <? if ($ev_8 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_8" value="1" <? if ($ev_8 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_8" value="2" <? if ($ev_8 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_8" value="3" <? if ($ev_8 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Total Puntos y Categorizaci�n</td>
                            <td colspan="2"> <input type="text" size="4" name="total_riesgo" value="<? echo $total_riesgo ?>" readonly="readonly" /> </td>
                            <td colspan="2"> <input type="text" size="4" name="categorizacion_riesgo" value="<? echo $categorizacion_riesgo ?>" readonly="readonly" /> </td>
                        </tr>
    
                    </table>
                </fieldset>
            </td>
            
            <td>
            </td>
    
            <td>
                <fieldset>
                <legend style="font-size:14px">Evaluaci�n Dependencia</legend>
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="listado">
                        <tr>
                            <td>Evaluaci�n</td>
                            <td>0</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados Confort y Bienestar</td>
                            <td> <input type="radio" name="ev_9" value="0" <? if ($ev_9 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_9" value="1" <? if ($ev_9 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_9" value="2" <? if ($ev_9 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_9" value="3" <? if ($ev_9 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados Confort y Bienestar</td>
                            <td> <input type="radio" name="ev_10" value="0" <? if ($ev_10 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_10" value="1" <? if ($ev_10 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_10" value="2" <? if ($ev_10 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_10" value="3" <? if ($ev_10 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados de Alimentaci�n</td>
                            <td> <input type="radio" name="ev_11" value="0" <? if ($ev_11 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_11" value="1" <? if ($ev_11 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_11" value="2" <? if ($ev_11 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_11" value="3" <? if ($ev_11 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Cuidados de Eliminaci�n</td>
                            <td> <input type="radio" name="ev_12" value="0" <? if ($ev_12 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_12" value="1" <? if ($ev_12 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_12" value="2" <? if ($ev_12 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_12" value="3" <? if ($ev_12 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Apoyo Psicosocial/emocional</td>
                            <td> <input type="radio" name="ev_13" value="0" <? if ($ev_13 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_13" value="1" <? if ($ev_13 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_13" value="2" <? if ($ev_13 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_13" value="3" <? if ($ev_13 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Vigilancia</td>
                            <td> <input type="radio" name="ev_14" value="0" <? if ($ev_14 == 0) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_14" value="1" <? if ($ev_14 == 1) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_14" value="2" <? if ($ev_14 == 2) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                            <td> <input type="radio" name="ev_14" value="3" <? if ($ev_14 == 3) { echo "checked='checked'"; } ?>
                            onclick="procesa()" /> </td>
                        </tr>
                        <tr>
                            <td align="left">Total Puntos y Categorizaci�n</td>
                            <td colspan="2"> <input type="text" size="4" name="total_dependencia" value="<? echo $total_dependencia ?>" readonly="readonly" /> </td>
                            <td colspan="2"> <input type="text" size="4" name="categorizacion_dependencia" value="<? echo $categorizacion_dependencia ?>" readonly="readonly" /> </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
						<tr>
                        	<td>Observaci�n <input type="text" size="40" maxlength="50" name="observacion" value="<? echo $observacion ?>" > </td>
                        </tr>

                    </table>
                </fieldset>
            </td>
        </tr>
    </table>
     
    <table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr align="left">
        <td>
        <fieldset>
        <legend>Categorizaci�n</legend>
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr align="center">
					<td width="25%"></td><td width="25%"></td><td></td><td></td>
				</tr>
            
                <tr align="center">
                    <td> 
                    	<input style="font-size:20px; text-align:center" type="text" size="2" name="categorizacion_final" value="<? echo $categorizacion_final ?>" readonly="readonly"  />
                    </td>
                    <td> 
                    	Fecha <input style="font-size:15px; text-align:center" type="text" size="10" name="fecha_categoriza" value="<? echo $fecha_categoriza ?>" readonly="readonly"  />
                    </td>
                    <td align="center">
                    	<input class="buttonGeneral" type="submit" name="btn_aceptar" value="       Grabar       "
                    <?php if ( array_search(25, $permisos) != null and (date('H:i:s') >= '03:00:00' and date('H:i:s') <= '10:00:00') ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?>  />
                    </td>
                    
                    <td align="center"><input class="buttonGeneral" type="Button" value=    "       Cancelar       " onClick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$id_cama&PACid=$id_paciente&desde=$desde"; ?>'; parent.GB_hide(); " ></td>
				</tr>
            </table>
        </fieldset>
        </td>
        </tr>

	</table>


	<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr align="left">
        <td>
        <fieldset>
        <legend>Informacion a Paciente</legend>
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr height="20px">
                    <td align="left">
						<input name="d_smpt" type="checkbox" <? if ($smpt == 1) { echo "checked"; } ?> /> Sonda Marcapaso Transitoria
                    </td>


                    <td align="center">
						Estado
                        <?php
						echo "<select name='estado_1'>";
						if($estado_1=="0")
						{ echo "<option value='0' selected> No-Ingresado </option>"; }
						else
						{ echo "<option value='0' > No-Ingresado </option>"; }
						if($estado_1=="1")
						{ echo "<option value='1' selected> Estable </option>"; }
						else
						{ echo "<option value='1' > Estable </option>"; }
						if($estado_1=="2")
						{ echo "<option value='2' selected> De Cuidado </option>"; }
						else
						{ echo "<option value='2' > De Cuidado </option>"; }
						if($estado_1=="3")
						{ echo "<option value='3' selected> Grave </option>"; }
						else
						{ echo "<option value='3' > Grave </option>"; }
						if($estado_1=="4")
						{ echo "<option value='4' selected> Muy Grave </option>"; }
						else
						{ echo "<option value='4' > Muy Grave </option>"; }
						if($estado_1=="5")
						{ echo "<option value='5' selected> De Alta </option>"; }
						else
						{ echo "<option value='5' > De Alta </option>"; }
						?>
                        </select>
                    </td>

                    <td align="right">Control Glicemia 
                    	<input class="buttonGeneral" type="button" value=" - " onclick="resta_uno()" />
                    	<input style="text-align:center" type="text" size="1" name="glicemia" value="<? echo $glicemia ?>" />
                    	<input class="buttonGeneral" type="button" value=" + " onclick="suma_uno()" />
                    </td>

                </tr>

                <tr height="30px">
                    <td align="left">
                                <label> Pacientes con Kinesiterapia&nbsp;</label>
                                <select name="kinesiologicos" id="kinesiologicos">
                                    <?/*
                                    switch ($cantidadderesultados) {
                                        case '4':
                                            ?>
                                            <option value='4' <? if($kinesiologicos == 4){ ?> selected="selected" <? } ?>> 4 Sesion </option>
                                            <?
                                            break;
                                        case '3':
                                            ?>
                                            <option value='3' <? if($kinesiologicos == 3){ ?> selected="selected" <? } ?>> 3 Sesion </option>
                                            <option value='4' <? if($kinesiologicos == 4){ ?> selected="selected" <? } ?>> 4 Sesion </option>
                                            <?
                                            break;
                                        case '2':
                                            ?>
                                            <option value='2' <? if($kinesiologicos == 2){ ?> selected="selected" <? } ?>> 2 Sesion </option>
                                            <option value='3' <? if($kinesiologicos == 3){ ?> selected="selected" <? } ?>> 3 Sesion </option>
                                            <option value='4' <? if($kinesiologicos == 4){ ?> selected="selected" <? } ?>> 4 Sesion </option>
                                            <?
                                            break;
                                        case '1':
                                            ?>
                                            <option value='1' <? if($kinesiologicos == 1){ ?> selected="selected" <? } ?>> 1 Sesion </option>
                                            <option value='2' <? if($kinesiologicos == 2){ ?> selected="selected" <? } ?>> 2 Sesion </option>
                                            <option value='3' <? if($kinesiologicos == 3){ ?> selected="selected" <? } ?>> 3 Sesion </option>
                                            <option value='4' <? if($kinesiologicos == 4){ ?> selected="selected" <? } ?>> 4 Sesion </option>
                                            <?
                                            break;
                                        case '0':
                                            ?>
                                            <option value='0' <? if($kinesiologicos == 0){ ?> selected="selected" <? } ?>> SIN Kinesiterapia </option>
                                            <option value='1' <? if($kinesiologicos == 1){ ?> selected="selected" <? } ?>> 1 Sesion </option>
                                            <option value='2' <? if($kinesiologicos == 2){ ?> selected="selected" <? } ?>> 2 Sesion </option>
                                            <option value='3' <? if($kinesiologicos == 3){ ?> selected="selected" <? } ?>> 3 Sesion </option>
                                            <option value='4' <? if($kinesiologicos == 4){ ?> selected="selected" <? } ?>> 4 Sesion </option>
                                            <?
                                            break;
                                    }*/
                                    if($cantidadderesultados=="0"){
?>
                                        <option value='0' <? if(!$idCategoriza){ ?> selected="selected" <? } ?>> NO </option>
                                        <option value='1' <? if($idCategoriza){ ?> selected="selected" <? } ?>> SI </option>
<?
                                    }else{
?>
                                        <option value='1' <? if($idCategoriza){ ?> selected="selected" <? } ?>> SI </option>
<?
                                    }
                                    ?>
                                </select>
                            </td>       

                    <td align="center">
                    
                    	Acompa�amiento
                        <?php
						echo "<select name='estado_2'>";
						if($estado_2=="0")
						{ echo "<option value='0' selected> No-Ingresado </option>"; }
						else
						{ echo "<option value='0' > No-Ingresado </option>"; }
						if($estado_2=="1")
						{ echo "<option value='1' selected> Sin Acompa�amiento </option>"; }
						else
						{ echo "<option value='1' > Sin Acompa�amiento </option>"; }
						if($estado_2=="2")
						{ echo "<option value='2' selected> 12 Horas </option>"; }
						else
						{ echo "<option value='2' > 12 Horas </option>"; }
						if($estado_2=="3")
						{ echo "<option value='3' selected> 24 Horas </option>"; }
						else
						{ echo "<option value='3' > 24Horas </option>"; }
						?>
                        </select>

                    </td>

                    <td align="right">
                    </td>

                </tr>

        
            </table>
        </fieldset>
        </td>
        </tr>
    </table>
    




















    
</form>

 
</div>

</fieldset>
</td>
</tr>
</table>


</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>

