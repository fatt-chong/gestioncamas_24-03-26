<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
 
require_once("../superNumeraria/include/funciones/funciones.php");

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('camas') or die('Cannot select database');

//VERIFICA SI LA CAMA AUN SE ENCUENTRA DESOCUPADA
$sqlVerifica = mysql_query("SELECT * FROM camas WHERE id = $que_idcama") or die(" ERROR AL VERIFICAR CAMA ".mysql_error());
$arrayVerifica = mysql_fetch_array($sqlVerifica);
$verifica_estado = $arrayVerifica['estado'];
$fecha_nacimiento = cambiarFormatoFecha2($fecha_nac);

if(($verifica_estado == 1) or ($verifica_estado == 3)){

	$sqlMedico = mysql_query("SELECT * FROM medicos WHERE id = '$medico'") or die("ERROR AL SELECCIONAR LOS MEDICOS ". mysql_error());
	$arrayMedico = mysql_fetch_array($sqlMedico);
	$nomMedico = $arrayMedico['medico'];
	
	if($multires == 'on')
		$multiresId = 1;
	if($accidente == 'on')
		$accidenteId = 1;
		
	$fechaIng = cambiarFormatoFecha2($fecha);
	$hora_ingreso = $hora_ingreso.":".$minuto_ingreso;
	$hoy = date('y-m-d');
	$fecha_menos24hs = date('Y-m-d',time()-(24*60*60));
	
	if(($que_estado == 3) and ($que_fechaBloq < $fechaIng)){
	//AGREGA MOVIMIENTO EN HOSPITALIZACIONES CUANDO LA CAMA BLOQUEADA ES UTILIZADA COMO SN	
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
							$idServicio, 
							'$bloqServicio', 
							'$bloqSala', 
							$bloqCama, 
							'$que_causa', 
							'CAMA BLOQUEADA', 
							'$que_fechaBloq', 
							'$fecha_menos24hs')") or die(mysql_error());
		
		}
	 $llama_tipo1 = cual_tipo($desde_codServ);
	 $array_tipo1 = explode(" ", $llama_tipo1);
	 $cod_tipo_1 = $array_tipo1[0];
	 $desc_tipo_1 = $array_tipo1[1];
	
	//SELECCIONA NOMBRE DE LA CAMA
	$sqlnomCama = mysql_query("SELECT
							Max(camassn.nomCamaSN) as maxCama
							FROM camassn
							WHERE
							camassn.tipoCamaSN = 'G'");
	$arraynomCama = mysql_fetch_array($sqlnomCama);
	$ultCama = $arraynomCama['maxCama'];
	
	if($ultCama){
		$ultCama = $ultCama+1; 
		}else{
			$ultCama = 1;
			}
	
	//INGRESA UN NUEVO REGISTRO EN TABLA CAMASN
	$servicioLlama = $_SESSION['MM_Servicio_activo'];
	$sqlinsertaCama = mysql_query("INSERT INTO camassn
						(nomCamaSN,
						salaCamaSN,
						tipoCamaSN,
						servicioCamaSN)
						VALUES
						($ultCama,
						1,
						'G',
						'$servicioLlama')") or die("ERROR AL INSERTAR EN CAMASN ". mysql_error());
	$idCamaSN = mysql_insert_id();
	
	//REGISTRA USO DE CAMA SUPER NUMERARIA	
	$sqlinsertarSN = "INSERT INTO listasn
					(idCamaSN,
					tipoTrasladoSN,
					nomProcedenciaSN,
					codProcedenciaSN,
					que_codServSN,
					que_nomServSN,
					que_camaSN,
					que_salaSN,
					que_idcamaSN,
					desde_codServSN,
					desde_nomServSN,
					ctaCteSN,
					codMedicoSN,
					nomMedicoSN,
					codAugeSN,
					diagnostico1SN,
					diagnostico2SN,
					accTranSN,
					multiresSN,
					idPacienteSN,
					sexoPacienteSN,
					rutPacienteSN,
					fichaPacienteSN,
					nomPacienteSN,
					nacPacienteSN,
					direcPacienteSN,
					codComunaSN,
					nomComunaSN,
					fono1SN,
					fono2SN,
					fono3SN,
					hospitalizadoSN,
					fechaIngresoSN,
					horaIngresoSN,
					codPrevisionSN,
					nomPrevisionSN,
					estadoAnteriorSN,
					causaAnteriorSN,
					tipo1SN,
					d_tipo1SN)
					VALUES
					('$idCamaSN',
					'$tipo_traslado',
					'$descProcedencia',
					'$cod_procedencia',
					'$idServicio',
					'$bloqServicio',
					'$bloqCama',
					'$bloqSala',
					'$que_idcama',
					'$desde_codServ',
					'$pacServicio',
					'$cta_cte',
					'$medico',
					'$nomMedico',
					'$auge',
					'$PACdiagnostico1',
					'$PACdiagnostico2',
					'$accidenteId',
					'$multiresId',
					'$idPaciente',
					'$pacSexo',
					'$rut_paciente',
					'$ficha_paciente',
					'$nom_paciente',
					'$fecha_nacimiento',
					'$pacDireccion',
					'$codComuna',
					'$nomComuna',
					'$fono1_paciente',
					'$fono2_paciente',
					'$fono3_paciente',
					'$fecha_hospitalizacion',
					'$fechaIng',
					'$hora_ingreso',
					'$cod_pacprevision',
					'$pacPrevision',
					$que_estado,
					'$que_causa',
					'$cod_tipo_1',
					'$desc_tipo_1')";
					
	$insertarSN = mysql_query($sqlinsertarSN) or die("ERROR AL INSERTAR CAMA SN ". mysql_error());
	
	//ELIMINA A PACIENTE DE LISTA DE TRANSITO PACIENTE
	$sqlElimina = mysql_query("DELETE FROM transito_paciente WHERE (id=$idTransito)");
	
	//ACTUALIZA EL ESTADO DE LA CAMA UTILIZADA COMO SUPER NUMERARIA
	$estadoBloq = "UTILIZADA COMO SUPER NUMERARIA";
	
	$actualizaCamas = mysql_query("UPDATE camas SET estado='5', fecha_ingreso = '$hoy', diagnostico1 = '$estadoBloq' WHERE (id=$que_idcama)");

}else{
	$mensajeError = "ERROR AL TRATAR DE INGRESAR PACIENTE,<br/> YA QUE LA CAMA ACABA DE SER UTILIZADA";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../superNumeraria/css/estilo.css" />
<title>Paciente registrado</title>
</head>

<table width="565" border="0" style="border:1px solid #000000;" align="center" cellpadding="2" cellspacing="2" background="../ingresos/img/fondo.jpg">
    <tr>
        <th width="628" height="25" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Asignación de Cama
</th>
    </tr>
    <tr>
        <td>
        	<table width="70%" height="100%" border="0" align="center" cellpadding="5" cellspacing="5">
                
            <tr>
            	<td>
				<? if ($actualizaCamas){ ?>
                  	<fieldset class="titulocampo">
                    <legend class="titulos_menu">Mensaje</legend>
                    
                  <table align="center" width="75%">
                        <tr>
							<td height="51" colspan="2" align="center" >
                            <strong>Se ha bloqueado la siguiente cama, para ser<br /> utilizada como &quot;Super Numeraria&quot;:</strong>
                            </td>
                        </tr>
                        <tr>
							<td width="29%" height="31" align="left">
                            <strong>Servicio </strong>
                            </td>
                            <td width="71%">
                            <strong>: </strong><? echo $bloqServicio; ?>
                          </td>
                        </tr>
                        <tr>
							<td width="29%" height="31" align="left">
                            <strong>Cama </strong>
                            </td>
                            <td width="71%">
                            : <? echo $bloqCama; ?> 
                          </td>
                        </tr> 
                        <tr>
							<td width="29%" height="36" align="left">
                            <strong>Sala </strong>
                            </td>
                            <td width="71%">
                            : <? echo $bloqSala; ?>
                            </td>
                        </tr> 
                        <tr>
							<td width="29%" height="31" align="left">
                            <strong>Paciente </strong>
                            </td>
                            <td width="71%">
                            : <? echo $nom_paciente; ?>
                          </td>
                        </tr>                
                    </table>
                    
                    </fieldset>
					</td>
				</tr>
                <tr>
                   <td align="center"><input type="button" name="registrar" id="registrar" value="         Aceptar         " onclick="javascript: document.location.href='sscc.php'" /></td>
                </tr>
			</table>
            <? } else {?>
            	<fieldset class="titulocampo">
                    <legend class="titulos_menu">Mensaje</legend>
                    <div align="center" class="folio"><? echo $mensajeError; ?>
                    <br />
                    <input type="button" name="registrar" id="registrar" value="         Volver         " onclick="javascript: document.location.href='sscc.php'" />
                    </div>
                 </fieldset>
                    <? } ?>
		</td>
	</tr>
</table>
</html>