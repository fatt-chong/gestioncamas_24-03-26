<?php 
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>


<?
include "../funciones/funciones.php";

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$cod_servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];

$fecha_hoy = date('d-m-Y');

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

//VERIFICA SI LA CAMA SELECCIONADA NO HA SIDO UTILIZADA COMO SN

$sqlVerifica = "SELECT * FROM camas where id = '".$t_id_cama."'";
$queryVerifica = mysql_query($sqlVerifica) or die(mysql_error());
$arrayVerifica = mysql_fetch_array($queryVerifica);
$estadoCama = $arrayVerifica['estado'];


$sql = "SELECT * FROM camas where id = '".$id_cama."'";
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);

$tipo_traslado = $paciente['tipo_traslado'];
$cod_servicio = $paciente['cod_servicio'];
$desc_servicio = $paciente['servicio'];
$sala = $paciente['sala'];
$cama = $paciente['cama'];
$tipo_1 = $paciente['tipo_1'];
$d_tipo_1 = $paciente['d_tipo_1'];
$tipo_2 = $paciente['tipo_2'];
$d_tipo_2 = $paciente['d_tipo_2'];
$cta_cte = $paciente['cta_cte'];
$cod_procedencia = $paciente['cod_procedencia'];
$procedencia = $paciente['procedencia'];
$cod_medico = $paciente['cod_medico'];
$medico = $paciente['medico'];
$cod_auge = $paciente['cod_auge'];
$auge = $paciente['auge'];
$acctransito = $paciente['acctransito'];
$diagnostico1 = $paciente['diagnostico1'];
$diagnostico2 = $paciente['diagnostico2'];
$id_paciente = $paciente['id_paciente'];
$rut_paciente = $paciente['rut_paciente'];
$ficha_paciente = $paciente['ficha_paciente'];
$esta_ficha = $paciente['esta_ficha'];
$nom_paciente = $paciente['nom_paciente'];
$sexo_paciente = $paciente['sexo_paciente'];
$edad_paciente = $paciente['edad_paciente'];
$cod_prevision = $paciente['cod_prevision'];
$prevision = $paciente['prevision'];
$direc_paciente = $paciente['direc_paciente'];
$cod_comuna = $paciente['cod_comuna'];
$comuna = $paciente['comuna'];
$fono1_paciente = $paciente['fono1_paciente'];
$fono2_paciente = $paciente['fono2_paciente'];
$fono3_paciente = $paciente['fono3_paciente'];
$fecha_categorizacion = $paciente['fecha_categorizacion'];
$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
$estado = $paciente['estado'];
$pabellon = $paciente['pabellon'];
$hospitalizado = $paciente['hospitalizado'];
$fecha_ingreso = $paciente['fecha_ingreso'];
$hora_ingreso = $paciente['hora_ingreso'];
$id_parto = $paciente['id_parto'];
$fecha_usuario_ingresa = $paciente['fecha_usuario_ingresa'];
$usuario_que_ingresa = $paciente['usuario_que_ingresa'];
$barthel = $paciente['barthel'];

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);

?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Categorizaci&oacute;n de Pacientes.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
				<? if($estadoCama == 1){ ?> 
                <div class="titulo" align="center">
                
                <table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr align="left">
                <td>
                <fieldset>
                <legend>Informacion de Traslado Servicio de <? echo $desc_servicio ?></legend>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td width="20px" height="20px"></td><td width="160px"></td></tr>
                <tr><td></td><td>Paciente</td><td>: <? echo $nom_paciente ?> </td></tr>
                <tr><td></td><td>Nro Ficha</td><td>: <? echo $ficha_paciente ?> </td></tr>
                <tr><td></td><td>Medico</td><td>: <? echo $medico ?> </td></tr>
                <tr><td></td><td>Diagnostico</td><td>: <? echo $diagnostico2 ?> </td></tr>
                <tr><td></td><td>Fecha de Ingreso</td><td>: <? echo $fecha_hospitalizacion ?> </td></tr>
                <tr><td width="20px" height="20px"></td><td width="160px"></td></tr>
                </table>
                
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr><td width="20" height="20px"></td><td></td><td></td><td></td><td width="20"></td></tr>
                
                <tr><td></td><td>Traslado</td><td>Sala</td><td>Cama N�mero</td><td></td></tr>
                <tr><td width="20" height="4px"></td><td></td><td></td><td></td><td width="20"></td></tr>
                
                <tr><td></td><td>Desde</td><td> <? echo $sala ?> </td><td> <? echo $cama ?> </td><td></td></tr>
                <tr><td></td><td>Hasta</td><td> <? echo $t_sala ?> </td><td> <? echo $t_cama ?> </td><td></td></tr>
                
                <tr><td height="20px"></td><td></td><td></td><td></td><td></td></tr>
                
                </table>
                
                </fieldset>
                </td>
                </tr>
                </table>
                    <form method="get" action="pro3_traslado_interno.php">
                        <input type="hidden" name="t_id_cama" value="<? echo $t_id_cama ?>" />
                
                        <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
                        <input type="hidden" name="tipo_traslado" value="<? echo $tipo_traslado ?>" />
                        <input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
                        <input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
                        <input type="hidden" name="sala" value="<? echo $sala ?>" />
                        <input type="hidden" name="cama" value="<? echo $cama ?>" />
                        <input type="hidden" name="tipo_1" value="<? echo $tipo_1 ?>" />
                        <input type="hidden" name="d_tipo_1" value="<? echo $d_tipo_1 ?>" />
                        <input type="hidden" name="tipo_2" value="<? echo $tipo_2 ?>" />
                        <input type="hidden" name="d_tipo_2" value="<? echo $d_tipo_2 ?>" />
                        <input type="hidden" name="cta_cte" value="<? echo $cta_cte ?>" />
                        <input type="hidden" name="cod_procedencia" value="<? echo $cod_procedencia ?>" />
                        <input type="hidden" name="procedencia" value="<? echo $procedencia ?>" />
                        <input type="hidden" name="cod_medico" value="<? echo $cod_medico ?>" />
                        <input type="hidden" name="medico" value="<? echo $medico ?>" />
                        <input type="hidden" name="cod_auge" value="<? echo $cod_auge ?>" />
                        <input type="hidden" name="auge" value="<? echo $auge ?>" />
                        <input type="hidden" name="acctransito" value="<? echo $acctransito ?>" />
                        <input type="hidden" name="diagnostico1" value="<? echo $diagnostico1 ?>" />
                        <input type="hidden" name="diagnostico2" value="<? echo $diagnostico2 ?>" />
                        <input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
                        <input type="hidden" name="rut_paciente" value="<? echo $rut_paciente ?>" />
                        <input type="hidden" name="ficha_paciente" value="<? echo $ficha_paciente ?>" /> 
                        <input type="hidden" name="esta_ficha" value="<? echo $esta_ficha ?>" /> 
                        <input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
                        <input type="hidden" name="sexo_paciente" value="<? echo $sexo_paciente ?>" />
                        <input type="hidden" name="edad_paciente" value="<? echo $edad_paciente ?>" />
                        <input type="hidden" name="cod_prevision" value="<? echo $cod_prevision ?>" />
                        <input type="hidden" name="prevision" value="<? echo $prevision ?>" />
                        <input type="hidden" name="direc_paciente" value="<? echo $direc_paciente ?>" />
                        <input type="hidden" name="cod_comuna" value="<? echo $cod_comuna ?>" />
                        <input type="hidden" name="comuna" value="<? echo $comuna ?>" />
                        <input type="hidden" name="fono1_paciente" value="<? echo $fono1_paciente ?>" />
                        <input type="hidden" name="fono2_paciente" value="<? echo $fono2_paciente ?>" />
                        <input type="hidden" name="fono3_paciente" value="<? echo $fono3_paciente ?>" />
                        <input type="hidden" name="fecha_categorizacion" value="<? echo $fecha_categorizacion ?>" />
                        <input type="hidden" name="categorizacion_riesgo" value="<? echo $categorizacion_riesgo ?>" />
                        <input type="hidden" name="categorizacion_dependencia" value="<? echo $categorizacion_dependencia ?>" />
                        <input type="hidden" name="barthel" value="<? echo $barthel ?>" />
                        <input type="hidden" name="estado" value="<? echo $estado ?>" />
                        <input type="hidden" name="pabellon" value="<? echo $pabellon ?>" />
                        <input type="hidden" name="hospitalizado" value="<? echo $hospitalizado ?>" />
                        <input type="hidden" name="fecha_ingreso" value="<? echo $fecha_ingreso ?>" />
                        <input type="hidden" name="hora_ingreso" value="<? echo $hora_ingreso ?>" />
                        <input type="hidden" name="id_parto" value="<? echo $id_parto; ?>" />
                        <input type="hidden" name="usuario_que_ingresa" value="<? echo $usuario_que_ingresa; ?>" />
        				<input type="hidden" name="fecha_usuario_ingresa" value="<? echo $fecha_usuario_ingresa; ?>" />
                
                        <table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr align="left">
                        <td>
                        <fieldset></br>
                        <legend>� Esta seguro de Realizar Traslado de Paciente ?</legend>
                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
                        <tr><td width="20px" height="20px"></td><td width="120px"></td><td></td><td width="200px"></td></tr>
                        
                        <tr><td width="20px" height="20px"></td><td width="120px"></td></tr>
                        <tr><td></td><td> <input type="submit" value="       Aceptar       " >
                            </td><td> <input type="Button" value=    "       Cancelar       " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
                            </td></tr>
                            <tr><td width="20px" height="20px"></td><td width="120px"></td></tr>        
                        </table>
                        
                        </fieldset>
                        </td>
                        </tr>
                        </table>
                
                    </form>
                
                 
                </div>
                <? }else { ?>
                
                <fieldset class="fieldset_det2"><legend>Error</legend>
                <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr height="25px">
                        </tr>
                        <tr>
                            <td align="center">La cama selecciona ha cambiado de </td>
                        </tr>
                        <tr>
                            <td align="center"> estado, y ya no se encuentra disponible.</td>
                        </tr>
                        <tr>
                            <td align="center">Recargue pagina de informacion de Servicio.</td>
                        </tr>
                        <tr height="25px">
                        </tr>
                    </table>
                
            </fieldset> 
            <fieldset class="fieldset_det2"><legend>Opciones</legend>
              <div align="center">
              <input type="Button" value=    "       Volver       " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
              </div>
            </fieldset>
            <? } ?>
                
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
