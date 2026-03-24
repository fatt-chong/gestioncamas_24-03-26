<?

include "../../funciones/epicrisis_funciones.php";

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");
$fechaHoy = date("Y-m-d H:i:s");
$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);


if($idEpicrisis == ''){
	
$sqlInsertar = "INSERT INTO epicrisismedica
								(epimedFechaIng,
								epimedFechaEgr,
								epimedRut,
								epimedEdad,
								epimedPacId,
								epimedPrevision,
								epimedDiag,
								epimedIndica,
								epimedCama,
								epimedUsuario,
								epimedCtacte,
								epimedCond,
								epimedServicio,
								epimedDias,
								epimedIdMedico,
								epimedMedico,
								epimedEstado,
								epimedPesoIn,
								epimedPesoEg,
								epimedODiagn,
								epimedEvolucion,
								epimedApgar1,
								epimedApgar5,
								epimedVent,
								epimedVentDias,
								epimedRNtipo,
								epimedRNsem,
								epimedRNEG,
								epimedMadre,
								epimedRutMadre)
								VALUES
								('$fechaIng',
								'$fechaEgr',
								'$epiRut',
								'$fechaNac',
								'$id_paciente',
								'$cod_prev',
								'$diagnosticoEpi',
								'$indicaEpi',
								'$id_cama',
								'$idUsuario',
								$ctaCte,
								'$condEgreso',
								'$idServicio',
								$difDias,
								'$idmedico',
								'$medico',
								'$cierra',
								'$pesoIngreso',
								'$pesoEgreso',
								'$otrodiagnosticoEpi',
								'$evolucionEpi',
								'$apgar1',
								'$apgar5',
								'$ventMec',
								'$diasVentmec',
								'$tipoRN',
								'$semanaRN',
								'$edadGes',
								'$madreNom',
								'$madreRut'
								)";
								
$insertEpicrisis = mysql_query($sqlInsertar) or die($sqlInsertar. " No se logro realizar el Insert de la epicrisis ". mysql_error());

//inserta los controles del paciente

for($i=1;$i<=4;$i++){
	$fechaPrueba = $fechacontrol[$i];
		if($fechaPrueba <> ''){

			$controlFecha = cambiarFormatoFecha2($fechaPrueba);
			echo $controlFecha;
			$sqlInsControl = "INSERT INTO 
							epimed_has_control
							(epimedId,
							controlFecha,
							controlTipo)
							VALUES
							($idEpicrisis,
							'$controlFecha',
							'$control[$i]')";
							
			$queryInsControl = mysql_query($sqlInsControl) or die($sqlInsControl." ERROR AL INSERTAR CONTROLES ".mysql_error());
		}
	}	
	
/*--->*/}else{
$sqlActualizar = "UPDATE epicrisismedica 
					SET epimedFechaIng = '$fechaIng',
						epimedFechaEgr = '$fechaEgr',
						epimedRut = '$epiRut',
						epimedEdad = '$fechaNac',
						epimedPacId = '$id_paciente',
						epimedFono = '$fonoCont',
						epimedPrevision = '$cod_prev',
						epimedDiag = '$diagnosticoEpi',
						epimedIndica = '$indicaEpi',
						epimedCama = '$id_cama',
						epimedUsuario = '$idUsuario',
						epimedCtacte = $ctaCte,
						epimedCond = '$condEgreso',
						epimedServicio = '$idServicio',
						epimedDias = $difDias,
						epimedIdMedico = '$idmedico',
						epimedMedico = '$medico',
						epimedEstado = '$cierra',
						epimedPesoIn = '$pesoIngreso',
						epimedPesoEg = '$pesoEgreso',
						epimedODiagn = '$otrodiagnosticoEpi',
						epimedEvolucion = '$evolucionEpi',
						epimedApgar1 = '$apgar1',
						epimedApgar5 = '$apgar5',
						epimedVent = '$ventMec',
						epimedVentDias = '$diasVentmec',
						epimedRNtipo = '$tipoRN',
						epimedRNsem = '$semanaRN',
						epimedRNEG = '$edadGes',
						epimedMadre = '$madreNom',
						epimedRutMadre = '$madreRut'	
						WHERE epimedId = $idEpicrisis";

$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());


//BORRA LOS CONTROLES ANTES INGRESADOS

		$sqlBorraControles = "DELETE FROM epimed_has_control WHERE epimedId = $idEpicrisis ";
		$queryBorraControles = mysql_query($sqlBorraControles) or die("Error al eliminar controles");

//GUARDA LOS CONTROLES	
		for($i=1;$i<=4;$i++){
			$fechaPrueba = $fechacontrol[$i];
				if($fechaPrueba <> ''){
		
					$controlFecha = cambiarFormatoFecha2($fechaPrueba);
					echo $controlFecha;
					$sqlInsControl = "INSERT INTO 
									epimed_has_control
									(epimedId,
									controlFecha,
									controlTipo)
									VALUES
									($idEpicrisis,
									'$controlFecha',
									'$control[$i]')";
									
					$queryInsControl = mysql_query($sqlInsControl) or die($sqlInsControl." ERROR AL INSERTAR CONTROLES ".mysql_error());
				}
			}	

}

if($act == 1){ 
	
$sqlLog = "INSERT INTO 
			logEpicrisis
			(logEpiId,
			logPac,
			logCtacte,
			logUsuario,
			logFecha,
			logTipo)
			VALUES
			($idEpicrisis,
			$id_paciente,
			$ctaCte,
			'$idUsuario',
			'$fechaHoy',
			'medica')";
$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());

?>
	
    <script>
        window.open('../epicrisisDoc/epicrisisMedNeoPDF.php?idEpicrisis=<? echo $idEpicrisis; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $id_paciente; ?>&hospitaliza=<? echo $fecha_sep; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPaciente; ?>&fechaNac=<? echo $fechaNac; ?>&prevPaciente=<? echo $prev_paciente; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&idServicio=<? echo $idServicio; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>   
    
	<meta http-equiv='refresh' content='0; url=../epicrisisNeo/epicrisisMedicaNeo.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&hospitaliza=<? echo $hospitaliza; ?>&epimedica=<? echo $epimedica; ?>'>
	
	<? }else{ ?>
		<meta http-equiv='refresh' content='0; url=../epicrisisNeo/epicrisisMedicaNeo.php?graba=1&idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&hospitaliza=<? echo $hospitaliza; ?>&epimedica=<? echo $epimedica; ?>'>

<?	}
	
?>