<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
//date_default_timezone_set('America/Santiago');

require_once("include/funciones/funciones.php");
$dbhost = $_SESSION['BD_SERVER'];
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('camas') or die('Cannot select database');

$hoy = date('Y-m-d');
$hora_egreso = date('H:i');

//VERIFICA SI LA CAMA AUN SE ENCUENTRA DESOCUPADA
$sqlVerifica = mysql_query("SELECT * FROM camas WHERE id = $que_idcama") or die(" ERROR AL VERIFICAR CAMA ".mysql_error());
$arrayVerifica = mysql_fetch_array($sqlVerifica);
$verifica_estado = $arrayVerifica['estado'];

if(($verifica_estado == 1) or ($verifica_estado == 3)){

if($que_estado == 3){
//REALIZA MOVIMIENTO EN HOSPITALIZACIONES CUANDO LA CAMA ANTERIORMENTE USADA ESTABA BLOQUEADA	

$resultado2 = mysql_query( "INSERT INTO hospitalizaciones
						(tipo_traslado, 
						cod_servicio, 
						servicio, 
						sala, 
						cama, 
						diagnostico1, 
						nom_paciente, 
						fecha_ingreso, 
						fecha_egreso )
						VALUES
						( 3, 
						$que_codServ, 
						'$que_nomServ', 
						'$que_sala', 
						$que_cama, 
						'$que_causa', 
						'CAMA BLOQUEADA', 
						'$que_fechaBloq', 
						'$hoy' ) ") or die(mysql_error());
	
	}

//SELECCIONA DATOS DE LA ANTIGUA CAMA UTILIZADA COMO SN
$sqlAntigua = "SELECT *
				FROM
				listasn
				INNER JOIN camassn ON camassn.codCamaSN = listasn.idCamaSN
				WHERE idListaSN = $idCamaSN "; 
$queryAntigua = mysql_query($sqlAntigua) or die ("ERROR AL SELECCIONAR DATOS DE LA CAMA ANTIGUA ".mysql_error());
$arrayAntigua =mysql_fetch_array($queryAntigua);

$id_antigua = $arrayAntigua['que_idcamaSN'];
$estado_antiguo = $arrayAntigua['estadoAnteriorSN'];
$causa_anterior = $arrayAntigua['causaAnteriorSN'];
$nom_cama_ant = $arrayAntigua['nomCamaSN'];
$nom_sala_ant = $arrayAntigua['salaCamaSN'];
$traslado_ant = $arrayAntigua['tipoTrasladoSN'];
$que_cod_ant = $arrayAntigua['desde_codServSN'];
$que_nom_ant = $arrayAntigua['desde_nomServSN'];
$cod_serv_ant = $arrayAntigua['que_codServSN'];
$nom_serv_ant = $arrayAntigua['que_nomServSN'];
$sala_ant = $arrayAntigua['que_salaSN'];
$cama_ant = $arrayAntigua['que_camaSN'];

$ctacte_ant = $arrayAntigua['ctaCteSN'];
$cod_proc_ant = $arrayAntigua['codProcedenciaSN'];
$nom_proc_ant = $arrayAntigua['nomProcedenciaSN'];
$cod_medico_ant = $arrayAntigua['codMedicoSN'];
$nom_medico_ant = $arrayAntigua['nomMedicoSN'];
$cod_auge_ant = $arrayAntigua['codAugeSN'];
$auge_ant = $arrayAntigua['nomAugeSN'];
$acctrans_ant = $arrayAntigua['accTransSN'];
$mutires_ant = $arrayAntigua['multiresSN'];
$diagnostico1_ant = $arrayAntigua['diagnostico1SN'];
$diagnostico2_ant = $arrayAntigua['diagnostico2SN'];
$idpac_ant = $arrayAntigua['idPacienteSN'];
$rut_ant = $arrayAntigua['rutPacienteSN'];
$ficha_ant = $arrayAntigua['fichaPacienteSN'];
$estaficha_ant = $arrayAntigua['esta_fichaSN'];
$nompac_ant = $arrayAntigua['nomPacienteSN'];
$fechanac_ant = $arrayAntigua['nacPacienteSN'];
$edad_ant = Edad($fechanac_ant);

$sexo_ant = $arrayAntigua['sexoPacienteSN'];
$codprevision_ant = $arrayAntigua['codPrevisionSN'];
$nomprevision_ant = $arrayAntigua['nomPrevisionSN'];
$direccion_ant = $arrayAntigua['direcPacienteSN'];
$codcomuna_ant = $arrayAntigua['codComunaSN'];
$nomcomuna_ant = $arrayAntigua['nomComunaSN'];
$fono1_ant = $arrayAntigua['fono1SN'];
$fono2_ant = $arrayAntigua['fono2SN'];
$fono3_ant = $arrayAntigua['fono3SN'];
$catriesgo_ant = $arrayAntigua['categorizaRiesgoSN'];
$catdep_ant = $arrayAntigua['categorizaDepSN'];
$hospital_ant = $arrayAntigua['hospitalizadoSN'];
$fechaing_ant = $arrayAntigua['fechaIngresoSN'];
$horaing_ant = $arrayAntigua['horaIngresoSN'];
$barthelSN = $arrayAntigua['barthelSN'];

if($barthelSN != ''){
		$sqlBarthel = ",barthelSN = '$barthelSN'";
		$sqlBarthel1 = ", barthel";
		$sqlBarthel2 = ", $barthelSN";
		}else{
			$sqlBarthel = ",barthelSN = NULL";
			$sqlBarthel1 = ", barthel";
			$sqlBarthel2 = ", NULL";
			}
if($paciente['barthelegreso']!=''){
	$sqlBarthele = ",barthel = ".$paciente['barthelegreso'];
	$sqlBarthel1e = ", barthelegreso";
	$sqlBarthel2e = ", '".$paciente['barthelegreso']."'";
}else{
	$sqlBarthele = ",barthel = NULL";
	$sqlBarthel1e = ", barthelegreso";
	$sqlBarthel2e = ", NULL";
}

if($cod_proc_ant > 1000){
	
	$sqlServicio = mysql_query("SELECT * FROM sscc WHERE id_rau = $cod_proc_ant ");
	$arrayServicio = mysql_fetch_array($sqlServicio);
	$cod_proc_ant = $arrayServicio['id'];
	
	}
	
$infoActualiza = "";
if($que_codServ != $cod_serv_ant){

//REGISTRA EL MOVIMIENTO EN LA TABLA HOSPITALIZACIONES

//ASIGNA VALOR A LA VARIABLE tipo_1
	$tipo_1 = '';
	$d_tipo_1 = '';
	switch($que_cod_ant){
		
		case(1):
			$tipo_1 = 2;
			$d_tipo_1 = "MEDICINA";
			break;
		case(2):
			$tipo_1 = 2;
			$d_tipo_1 = "MEDICINA";
			break;
		case(3):
			$tipo_1 = 1;
			$d_tipo_1 = "CIRUGIA"; 
			break;
		case(4):
			$tipo_1 = 1;
			$d_tipo_1 = "CIRUGIA"; 
			break;
		case(5):
			$tipo_1 = 7;
			$d_tipo_1 = "TRAUMATOLOGIA"; 
			break;
		case(6):
			$tipo_1 = 15;
			$d_tipo_1 = "NEONATOLOGIA CUNA BASICA"; 
			break;
		case(7):
			$tipo_1 = 5;
			$d_tipo_1 = "PEDIATRIA INDIFERENCIADA";
			break;
		case(8):
			$tipo_1 = 11;
			$d_tipo_1 = "UCI"; 
			break;
		case(9):
			$tipo_1 = 12;
			$d_tipo_1 = "SAI"; 
			break;
		case(10):
			$tipo_1 = 8;
			$d_tipo_1 = "GINECOLOGIA"; 
			break;
		case(11):
			$tipo_1 = 9;
			$d_tipo_1 = "OBSTETRICIA"; 
			break;
		case(12):
			$tipo_1 = 12;
			$d_tipo_1 = "PSIQUIATRIA"; 
			break;	
		case(14):
			$tipo_1 = 9;
			$d_tipo_1 = "OBSTETRICIA"; 
			break;
		case(45):
			$tipo_1 = 45;
			$d_tipo_1 = "PARTOS"; 
			break;	
		
		}

$array_tipo1 = cual_tipo($que_cod_ant);
$tipo1 = explode(" ", $array_tipo1);
$q_tipo_1 = $tipo1[0];
$q_d_tipo_1 = $tipo1[1];

$array_tipo2 = cual_tipo($cod_serv_ant);
$tipo2 = explode(" ", $array_tipo2);
$tipo_1 = $tipo2[0];
$d_tipo_1 = $tipo2[1];

$anio_actual = date('Y');

	$sqlMov = "INSERT INTO hospitalizaciones
	(camaSN,
	nomSalaSN,
	nomCamaSN,
	codServicioSN,
	tipo_traslado,
	que_cod_servicio,
	que_servicio,
	cod_servicio, 
	servicio, 
	sala, 
	cama,
	cta_cte,
	cod_procedencia, 
	procedencia, 
	cod_destino, 
	destino, 
	cod_medico, 
	medico, 
	cod_auge, 
	auge, 
	acctransito, 
	multires,
	diagnostico1, 
	diagnostico2, 
	id_paciente, 
	rut_paciente, 
	ficha_paciente, 
	esta_ficha, 
	nom_paciente, 
	edad_paciente,
	sexo_paciente, 
	cod_prevision, 
	prevision, 
	direc_paciente, 
	cod_comuna, 
	comuna, 
	fono1_paciente, 
	fono2_paciente, 
	fono3_paciente,
	categorizacion_riesgo,
	categorizacion_dependencia,
	hospitalizado,
	fecha_ingreso,
	hora_ingreso,
	fecha_egreso,
	hora_egreso,
	censo_anio,
	censo_correlativo,
	tipo_1,
	d_tipo_1,
	que_tipo_1,
	que_d_tipo_1".$sqlBarthel1.$sqlBarthel1e.")
	VALUES
	('S',
	'$nom_sala_ant',
	'$nom_cama_ant',
	'$cod_serv_ant',
	'$traslado_ant',
	'$que_cod_ant',
	'$que_nom_ant',
	'$cod_serv_ant', 
	'$nom_serv_ant', 
	'$sala_ant', 
	'$cama_ant',
	'$ctacte_ant',
	'$cod_proc_ant', 
	'$nom_proc_ant',
	'$que_cod_ant', 
	'$que_nom_ant',
	'$cod_medico_ant ',
	'$nom_medico_ant ',
	'$cod_auge_ant ', 
	'$auge_ant ', 
	'$acctrans_ant ', 
	'$mutires_ant',
	'$diagnostico1_ant',
	'$diagnostico2_ant ',
	'$idpac_ant ', 
	'$rut_ant', 
	'$ficha_ant', 
	'$estaficha_ant', 
	'$nompac_ant',
	'$edad_ant',
	'$sexo_ant', 
	'$codprevision_ant', 
	'$nomprevision_ant', 
	'$direccion_ant', 
	'$codcomuna_ant', 
	'$nomcomuna_ant',
	'$fono1_ant', 
	'$fono2_ant', 
	'$fono3_ant',
	'$catriesgo_ant',
	'$catdep_ant',
	'$hospital_ant',
	'$fechaing_ant',
	'$horaing_ant',
	'$hoy',
	'$hora_egreso',
	'$anio_actual',
	0,
	'$tipo_1',
	'$d_tipo_1',
	'$q_tipo_1',
	'$q_d_tipo_1'".$sqlBarthel2.$sqlBarthel2e.") ";
	
$resultadoMov = mysql_query($sqlMov) or die($sqlMov ." ERROR AL INSERTAR EN HOSPITALIZACIONES sql_cambiacamaSN ".mysql_error());

//datos que agregara a la query que actualiza los datos de la cama SN
$infoActualiza = ", tipoTrasladoSN = 2,
				fechaIngresoSN = '$hoy',
				horaIngresoSN = '$hora_egreso',
				nomProcedenciaSN = '$nom_serv_ant', 
				codProcedenciaSN ='$cod_serv_ant' ";
}

//DESBLOQUEA CAMA ANTIGUAMENTE UTILIZADA
$sqlDesbloq = "UPDATE camas SET
				diagnostico1 = '$causa_anterior',
				estado = $estado_antiguo,
				fecha_ingreso = '$hoy'
				WHERE id = $id_antigua";
				
$queryDesbloq = mysql_query($sqlDesbloq) or die( $sqlDesbloq. " ERROR AL DESBLOQUEAR CAMA ". mysql_error());

//REALIZA MOVIMIENTO EN HOSPITALIZACIONES POR DESBLOQUEO DE CAMA ANTERIORMENTE UTILIZADA COMO SN
//
//$movimSN = mysql_query( "INSERT INTO hospitalizaciones
//						(tipo_traslado, 
//						cod_servicio, 
//						servicio, 
//						sala, 
//						cama, 
//						diagnostico1, 
//						nom_paciente, 
//						fecha_ingreso, 
//						fecha_egreso,
//						censo_anio )
//						VALUES
//						( 3, 
//						'$cod_serv_ant', 
//						'$nom_serv_ant', 
//						'$sala_ant', 
//						'$cama_ant',
//						'UTILIZADA COMO SUPER NUMERARIA', 
//						'CAMA BLOQUEADA', 
//						'$fechaing_ant', 
//						'$hoy',
//						'$anio_actual') ") or die(mysql_error());
//						


//ACTUALIZA EL ESTADO DE LA CAMA UTILIZADA COMO SUPER NUMERARIA
$estadoBloq = "UTILIZADA COMO SUPER NUMERARIA";
$actualizaCamas = mysql_query("UPDATE camas 
								SET estado='5', 
								fecha_ingreso = '$hoy', 
								diagnostico1 = '$estadoBloq'
								WHERE (id=$que_idcama)") or die("ERROR AL ACTUALIZAR ESTADO DE NUEVA CAMA SN ".mysql_error());

//REEMPLAZA DATOS DE LA NUEVA CAMA SN
$sqlreemplazaSN = "UPDATE listasn SET 
				que_codServSN = $que_codServ,
				que_nomServSN = '$que_nomServ',
				que_idcamaSN = $que_idcama,
				que_camaSN = $que_cama,
				que_salaSN = '$que_sala',
				estadoAnteriorSN = $que_estado,
				causaAnteriorSN = '$que_causa' ".$infoActualiza.$sqlBarthel."			
				WHERE idListaSN = $idCamaSN ";

$reemplazaSN = mysql_query($sqlreemplazaSN) or die($sqlreemplazaSN. " ERROR AL REEMPLAZAR CAMA SN ". mysql_error());

}else{
	$mensajeError = "ERROR AL TRATAR DE INGRESAR PACIENTE,<br/> YA QUE LA CAMA ACABA DE SER UTILIZADA";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<title>Paciente registrado</title>
</head>

<table width="394" border="0" style="border:1px solid #000000;" align="center" cellpadding="2" cellspacing="2" background="../ingresos/img/fondo.jpg">
    <tr>
        <th width="384" height="25" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Asignación de Cama</th>
    </tr>
    <tr>
        <td>
        	<? if($actualizaCamas){ ?>
        	<table width="86%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                
            <tr>
            	<td>
                  	<fieldset class="titulocampo">
                    <legend class="titulos_menu">Mensaje</legend>
                    <table align="center" width="88%">
                        <tr>
							<td height="51" colspan="2" align="center" >
                            <strong>Se ha bloqueado la siguiente cama, para ser<br /> utilizada como &quot;Super Numeraria&quot;:</strong>
                            </td>
                        </tr>
                        <tr>
							<td width="35%" height="31" align="left">
                            <strong>Servicio </strong>
                            </td>
                            <td width="65%">
                            : <? echo $que_nomServ; ?>
                          </td>
                        </tr>
                        <tr>
							<td width="35%" height="31" align="left">
                            <strong>Cama </strong>
                            </td>
                            <td width="65%">
                            : <? echo $que_cama; ?> 
                          </td>
                        </tr> 
                        <tr>
							<td width="35%" height="36" align="left">
                            <strong>Sala </strong>
                            </td>
                            <td width="65%">
                            : <? echo $que_sala; ?>
                            </td>
                        </tr>                 
                    </table>
                    </fieldset>
					</td>
				</tr>
                <tr>
                   <td align="center"><input type="button" name="registrar" id="registrar" value="         Aceptar         " onclick="javascript: document.location.href='camaSuperNum.php'" /></td>
                </tr>
			</table>
            <? }else{ ?>
        	<fieldset class="titulos_menu"><legend>Mensaje</legend>
        	<div align="center" class="folio"><? echo $mensajeError; ?>
            <br />
            <input type="button" name="registrar" id="registrar" value="         Aceptar         " onclick="javascript: document.location.href='camaSuperNum.php'" />
            </div>
            </fieldset>
        <? } ?>
		</td>
	</tr>
</table>
</html>