<?

include "../funciones/epicrisis_funciones.php";

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");
$fechaHoy = date("Y-m-d H:i:s");
$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);
$digitoR = ValidaDVRut($rutPaciente);

if($idEpicrisis == ''){
	
$sqlInsertar = "INSERT INTO epicrisismatrona
								(epimatFechaIng,
								epimatFechaEgr,
								epimatDestino,
								epimatRut,
								epimatEdad,
								epimatPacId,
								epimatFono,
								epimatPrevision,
								epimatIndica,
								epimatOtroexam,
								epimatExamen,
								epimatPend,
								epimatPendexam,
								epimatIdCama,
								epimatUsuario,
								epimatCtacte,
								epimatServicio,
								epimatDias,
								epimatDiagn,
								epimatInterv,
								epimatMatrona,
								epimatTipoParto,
								epimatEpisio,
								epimatDesg,
								epimatEstadorn,
								epimatHosprn,
								epimatMalrn,
								epimatMalrncausa,
								epimatInfec,
								epimatMulti,
								epimatVdrl,
								epimatHema,
								epimatUro,
								epimatEndo,
								epimatLoqui,
								epimatResp,
								epimatRespNom,
								epimatIdparto)
								VALUES
								('$fechaIng',
								'$fechaEgr',
								'$destinoPaciente',
								'$rutPaciente',
								'$fechaNac',
								'$id_paciente',
								'$fonoCont',
								'$cod_prev',
								'$detalleEpi',
								'$otroExamen',
								'$examenes',
								'$pendExamen',
								'$examenPend',
								'$id_cama',
								'$idUsuario',
								$ctaCte,
								'$idServicio',
								$difDias,
								'$matronaDiag',
								'$matronaInter',
								'$matronas',
								'$tipoParto',
								'$episio',
								'$desgarro',
								'$estadoRN',
								'$hospita',
								'$malforma',
								'$detalleMalfoma',
								'$infeccion',
								'$multires',
								'$vdrl',
								'$hemato',
								'$urocu',
								'$endocer',
								'$loquio',
								'$responsable',
								'$nomResp',
								'$idParto'
								)";
								
$insertEpicrisis = mysql_query($sqlInsertar) or die($sqlInsertar. " No se logro realizar el Insert de la epicrisis ". mysql_error());

//Recupera el id de la epicrisis creada
$idEpicrisis = mysql_insert_id();

//Hace ciclo para guardar las educaciones
	if(count($educaArray)>0){
	
		foreach($educaArray as $valor){
			
				$sqlInsEdu = "INSERT INTO 
								epimat_has_educa
								(epimatId,
								educaId)
								VALUES
								($idEpicrisis,
								$valor)";
				$queryInsEdu = mysql_query($sqlInsEdu) or die($sqlInsEdu." Error al insertar tipo de educaciones");			
			}
	}
	
//Hace ciclo para guardar las consejerias
if(count($consejoArray)>0){

	foreach($consejoArray as $valorCons){
		
			$sqlInsCon = "INSERT INTO 
							epimat_has_consejo
							(epimatId,
							consejoId)
							VALUES
							($idEpicrisis,
							$valorCons)";
			$queryInsCon = mysql_query($sqlInsCon) or die($sqlInsCon." Error al insertar tipo de educaciones");
		}
}

}else{

$sqlPregunta = mysql_query("SELECT epimatEstado FROM epicrisismatrona WHERE epimatId = $idEpicrisis") or die("Error al seleccionar estado".mysql_error());
$arrayPregunta = mysql_fetch_array($sqlPregunta);
$estadoEpi = $arrayPregunta['epimatEstado'];
	
	if(($cierra == 1) or ($estadoEpi == 1)){
		$cierra = 1;
		}else{
			$cierra = 0;
			}	
	
$sqlActualizar = "UPDATE epicrisismatrona 
					SET epimatFechaIng = '$fechaIng',
						epimatFechaEgr = '$fechaEgr',
						epimatEstado = '$cierra',
						epimatDestino = $destinoPaciente,
						epimatRut = $rutPaciente,
						epimatEdad = '$fechaNac',
						epimatPacId = '$id_paciente',
						epimatFono = '$fonoCont',
						epimatPrevision = '$cod_prev',
						epimatIndica = '$detalleEpi',
						epimatOtroexam = '$otroExamen',
						epimatExamen = '$examenes',
						epimatPend = '$pendExamen',
						epimatPendexam = '$examenPend',
						epimatIdCama = '$id_cama',
						epimatUsuario = '$idUsuario',
						epimatCtacte = $ctaCte,
						epimatServicio = '$idServicio',
						epimatDias = $difDias,
						epimatDiagn = '$matronaDiag',
						epimatInterv = '$matronaInter',
						epimatMatrona = '$matronas',
						epimatTipoParto = '$tipoParto',
						epimatEpisio = '$episio',
						epimatDesg = '$desgarro',
						epimatEstadorn = '$estadoRN',
						epimatHosprn = '$hospita',
						epimatMalrn = '$malforma',
						epimatMalrncausa = '$detalleMalfoma',
						epimatInfec = '$infeccion',
						epimatMulti = '$multires',
						epimatVdrl = '$vdrl',
						epimatHema = '$hemato',
						epimatUro = '$urocu',
						epimatEndo = '$endocer',
						epimatLoqui = '$loquio',
						epimatResp = '$responsable',
						epimatRespNom = '$nomResp',
						epimatIdparto = '$idParto' 	
						WHERE epimatId = $idEpicrisis";

$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());
	
	//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epimat_has_educa WHERE epimatId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		
	if(count($educaArray)>0){
		
		//Y VUELVE A GUADAR LO NUEVO
		
		//Hace ciclo para guardar las educaciones
		
		foreach($educaArray as $valor){
			
				$sqlInsEdu = "INSERT INTO 
								epimat_has_educa
								(epimatId,
								educaId)
								VALUES
								($idEpicrisis,
								$valor)";
				$queryInsEdu = mysql_query($sqlInsEdu) or die("Error al actualizar tipo de educaciones");			
			}
	}
	//BORRA LO ANTES GUARDADO
	$sqlBorra2 = "DELETE FROM epimat_has_consejo WHERE epimatId = $idEpicrisis ";
	$queryBorra2 = mysql_query($sqlBorra2) or die("Error al eliminar consejos");
		
	//Hace ciclo para guardar las consejerias
	if(count($consejoArray)>0){
	
		foreach($consejoArray as $valorCons){
			
				$sqlInsCon = "INSERT INTO 
								epimat_has_consejo
								(epimatId,
								consejoId)
								VALUES
								($idEpicrisis,
								$valorCons)";
				$queryInsCon = mysql_query($sqlInsCon) or die($sqlInsCon." Error al insertar tipo de educaciones");
			}
	}

}

if(($act == 1) or ($visualiza == 1)){ 
	if($cama_sn == ''){
		$cama_sn = 0;
		}else{
			$cama_sn = 1;
			}

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
			'matrona')";
$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());

?>
	
    <script>
        window.open('epicrisisDoc/epicrisisMatPDF.php?idEpicrisis=<? echo $idEpicrisis; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $id_paciente; ?>&hospitaliza=<? echo $fecha_sep; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPaciente; ?>&fechaNac=<? echo $fechaNac; ?>&nacimiento=<? echo $nacimiento; ?>&prevPaciente=<? echo $prev_paciente; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&cama_sn=<? echo $cama_sn; ?>&desde=<? echo $desde; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>   
    
	<meta http-equiv='refresh' content='0; url=epicrisisMatronas.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>&idParto=<? echo $idParto; ?>&desde=<? echo $desde; ?>'>
	
	<? }else{ ?>
		<meta http-equiv='refresh' content='0; url=epicrisisMatronas.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>&idParto=<? echo $idParto; ?>&desde=<? echo $desde; ?>'>

<?		}
	
?>