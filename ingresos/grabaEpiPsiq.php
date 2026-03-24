<?

include "../funciones/epicrisis_funciones.php";

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");

$fechaHoy = date("Y-m-d H:i:s");
$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);

if($barthel == ''){
	$barthel = "NULL";
}
if($barthele == ''){
	$barthele = "NULL";
}

if($idEpicrisis == ''){
	
$sqlInsertar = "INSERT INTO epicrisisEnf
								(epienfFechaIng,
								epienfFechaEgr,
								epienfDias,
								epienfEdad,
								epienfPacId,
								epienfPrevision,
								epienfFono,
								epienfCie10,
								epienfRut,
								epienfMr,
								epienfIndica,
								epienfIdCama,
								epienfDestino,
								epienfTraslado,
								epienfUsuario,
								epienfCtacte,
								epienfCond,
								epienfServicio,
								epienfEnfermera,
								epienfHosdom,
								epienfHogar,
								epienfEstado,
								epienfResp,
								epienfRespRut,
								epienfRespNom,
								epienfPesoNac,
								epienfPesoAlta,
								epienfRespOtro,
								epienfReingreso,
								epienfDerivado)
								VALUES
								('$fechaIng',
								'$fechaEgr',
								$difDias,
								'$fechaNac',
								'$id_paciente',
								'$cod_prev',
								'$fonoCont',
								'$diagnosticos',
								'$epiRut',
								'$multiRes',
								'$detalleEpi',
								'$id_cama',
								'$destinoPaciente',
								'$trasladoPaciente',
								'$idUsuario',
								$ctaCte,
								'$condEgreso',
								'$idServicio',
								'$enfermeras',
								'$hospDom',
								'$hogarPaciente',
								'$cierra',
								'$responsable',
								'$rutResp',
								'$nomResp',
								'$pesoNac',
								'$pesoAlta',
								'$otroResponsable',
								'$reIng',
								'$derivadoPaciente')";
								
$insertEpicrisis = mysql_query($sqlInsertar) or die($sqlInsertar. " No se logro realizar el Insert de la epicrisis ". mysql_error());

//Recupera el id de la epicrisis creada
$idEpicrisis = mysql_insert_id();
$sqlbarthel="UPDATE camas.listasn SET listasn.barthelegreso= '$barthele' WHERE listasn.ctaCteSN = '$ctaCte'";
mysql_query("SET NAMES utf8");
mysql_query($sqlbarthel) or die($sqlbarthel. " No se logro realizar el update del barthel ". mysql_error());
	
	if(count($educaArray)>0){ // INTERVENCIONES
		
		//Y VUELVE A GUADAR LO NUEVO
		
		//Hace ciclo para guardar las educaciones
		
		foreach($educaArray as $valor){
			
				$sqlInsEdu = "INSERT INTO 
								epienf_has_educapac
								(epienfId,
								educaId)
								VALUES
								($idEpicrisis,
								$valor)";
				$queryInsEdu = mysql_query($sqlInsEdu) or die("Error al insertar tipo de educaciones");			
			}
	}
	
	if(count($cuidadosIng)>0){ //AUTOCUIDADOS INGRESO
		
		foreach($cuidadosIng as $var_ci){
			
				$e_var_ci = explode(" ",$var_ci);
				
				$var_ci_id = $e_var_ci[0];
				
				$var_ci_tipo = $e_var_ci[1];
								
				$sqlInsCuiI = "INSERT INTO 
								epienf_has_autocuidado
								(epienfId,
								cuidadoId,
								cuidadoValor,
								cuidadoTipo)
								VALUES
								($idEpicrisis,
								$var_ci_id,
								'$var_ci_tipo',
								'I')";
				$queryInsCuiI = mysql_query($sqlInsCuiI) or die($sqlInsCuiI." Error al insertar tipo de cuidados ".mysql_error());			
			}
	}
	if(count($cuidadosAlt)>0){ //AUTOCUIDADOS AL ALTA
		
		foreach($cuidadosAlt as $var_ca){
			
				$e_var_ca = explode(" ",$var_ca);
				
				$var_ca_id = $e_var_ca[0];
				
				$var_ca_tipo = $e_var_ca[1];
								
				$sqlInsCuiA = "INSERT INTO 
								epienf_has_autocuidado
								(epienfId,
								cuidadoId,
								cuidadoValor,
								cuidadoTipo)
								VALUES
								($idEpicrisis,
								$var_ca_id,
								'$var_ca_tipo',
								'A')";
				$queryInsCuiA = mysql_query($sqlInsCuiA) or die($sqlInsCuiA." Error al insertar tipo de cuidados ".mysql_error());			
			}
	}
		
	if(count($planI)>0){ // PLANIFICACIONES EVALUATIVAS AL INGRESO
	
		foreach($planI as $var_i){
			
				$sqlInsPlanI = "INSERT INTO 
								epienf_has_planificacion
								(epienfId,
								planId,
								planTipo)
								VALUES
								($idEpicrisis,
								$var_i,
								'I')";
				$queryInsPlanI = mysql_query($sqlInsPlanI) or die($sqlInsPlanI." Error al insertar tipo de planificaciones ".mysql_error());	
						
			}
	}
	
	if(count($planA)>0){ // PLANIFICACIONES EVALUATIVAS AL ALTA
	
		foreach($planA as $var_a){
			
				$sqlInsPlanA = "INSERT INTO 
								epienf_has_planificacion
								(epienfId,
								planId,
								planTipo)
								VALUES
								($idEpicrisis,
								$var_a,
								'A')";
				$queryInsPlanA = mysql_query($sqlInsPlanA) or die($sqlInsPlanA." Error al insertar tipo de planificaciones ".mysql_error());	
						
			}
	}

}else{
	$sqlbarthel="UPDATE camas.listasn SET listasn.barthelegreso= '$barthele' WHERE listasn.ctaCteSN = '$ctaCte'";
mysql_query("SET NAMES utf8");
mysql_query($sqlbarthel) or die($sqlbarthel. " No se logro realizar el update del barthel ". mysql_error());
$sqlActualizar = "UPDATE epicrisisEnf 
					SET epienfFechaIng = '$fechaIng',
						epienfFechaEgr = '$fechaEgr',
						epienfDias = $difDias,
						epienfEdad = '$fechaNac',
						epienfPacId = $id_paciente,
						epienfPrevision = '$cod_prev',
						epienfFono = '$fonoCont',
						epienfCie10 = '$diagnosticos',
						epienfRut = '$epiRut',
						epienfMr = '$multiRes',
						epienfIndica = '$detalleEpi',
						epienfIdCama = $id_cama,
						epienfDestino = '$destinoPaciente',
						epienfTraslado = '$trasladoPaciente',
						epienfCtacte = $ctaCte,
						epienfCond = '$condEgreso',
						epienfServicio = $idServicio,
						epienfEnfermera = '$enfermeras',
						epienfHosdom = '$hospDom',
						epienfUsuario = '$idUsuario',
						epienfHogar = '$hogarPaciente',
						epienfEstado = '$cierra',
						epienfResp = '$responsable',
						epienfRespRut = '$rutResp',
						epienfRespNom ='$nomResp',
						epienfPesoNac = '$pesoNac',
						epienfPesoAlta = '$pesoAlta',
						epienfRespOtro = '$otroResponsable',
						epienfReingreso = '$reIng',
						epienfDerivado = '$derivadoPaciente'	
						WHERE epienfId = $idEpicrisis";

$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());
	
	//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epienf_has_educapac WHERE epienfId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		
	if(count($educaArray)>0){ // INTERVENCIONES
		
		//Y VUELVE A GUADAR LO NUEVO
		
		//Hace ciclo para guardar las educaciones
		
		foreach($educaArray as $valor){
			
				$sqlInsEdu = "INSERT INTO 
								epienf_has_educapac
								(epienfId,
								educaId)
								VALUES
								($idEpicrisis,
								$valor)";
				$queryInsEdu = mysql_query($sqlInsEdu) or die("Error al insertar tipo de educaciones");			
			}
	}
	//BORRA LO ANTES GUARDADO
		$sqlBorraCI = "DELETE FROM epienf_has_autocuidado WHERE epienfId = $idEpicrisis";
		$queryBorraCI = mysql_query($sqlBorraCI) or die("Error al eliminar planificaciones");
		
	if(count($cuidadosIng)>0){ //AUTOCUIDADOS INGRESO
		
		foreach($cuidadosIng as $var_ci){
			
				$e_var_ci = explode(" ",$var_ci);
				
				$var_ci_id = $e_var_ci[0];
				
				$var_ci_tipo = $e_var_ci[1];
								
				$sqlInsCuiI = "INSERT INTO 
								epienf_has_autocuidado
								(epienfId,
								cuidadoId,
								cuidadoValor,
								cuidadoTipo)
								VALUES
								($idEpicrisis,
								$var_ci_id,
								'$var_ci_tipo',
								'I')";
				$queryInsCuiI = mysql_query($sqlInsCuiI) or die($sqlInsCuiI." Error al insertar tipo de cuidados ".mysql_error());			
			}
	}
	if(count($cuidadosAlt)>0){ //AUTOCUIDADOS AL ALTA
		
		foreach($cuidadosAlt as $var_ca){
			
				$e_var_ca = explode(" ",$var_ca);
				
				$var_ca_id = $e_var_ca[0];
				
				$var_ca_tipo = $e_var_ca[1];
								
				$sqlInsCuiA = "INSERT INTO 
								epienf_has_autocuidado
								(epienfId,
								cuidadoId,
								cuidadoValor,
								cuidadoTipo)
								VALUES
								($idEpicrisis,
								$var_ca_id,
								'$var_ca_tipo',
								'A')";
				$queryInsCuiA = mysql_query($sqlInsCuiA) or die($sqlInsCuiA." Error al insertar tipo de cuidados ".mysql_error());			
			}
	}
	//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epienf_has_planificacion WHERE epienfId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar planificaciones");
		
	if(count($planI)>0){ // PLANIFICACIONES EVALUATIVAS AL INGRESO
	
		foreach($planI as $var_i){
			
				$sqlInsPlanI = "INSERT INTO 
								epienf_has_planificacion
								(epienfId,
								planId,
								planTipo)
								VALUES
								($idEpicrisis,
								$var_i,
								'I')";
				$queryInsPlanI = mysql_query($sqlInsPlanI) or die($sqlInsPlanI." Error al insertar tipo de planificaciones ".mysql_error());	
						
			}
	}
	
	if(count($planA)>0){ // PLANIFICACIONES EVALUATIVAS AL ALTA
	
		foreach($planA as $var_a){
			
				$sqlInsPlanA = "INSERT INTO 
								epienf_has_planificacion
								(epienfId,
								planId,
								planTipo)
								VALUES
								($idEpicrisis,
								$var_a,
								'A')";
				$queryInsPlanA = mysql_query($sqlInsPlanA) or die($sqlInsPlanA." Error al insertar tipo de planificaciones ".mysql_error());	
						
			}
	}
	

}
if(($act == 1) or ($visualiza == 1)){ 
	if($cama_sn == ''){
		$cama_sn = 0;
		}else{
			$cama_sn = 1;
			}

//INSERTA REGISTRO CADA VEZ QUE SE CIERRE LA EPICRISIS

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
			'enfermera')";
$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());

?>
	
    <script>
        window.open('epicrisisDoc/epicrisisEnfPsiPDF.php?idEpicrisis=<? echo $idEpicrisis; ?>&vbarthel=<? echo $valorBart; ?>&barthel=<? echo $barthel; ?>&vbarthele=<? echo $valorBartele; ?>&barthele=<? echo $barthele; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $id_paciente; ?>&hospitaliza=<? echo $fecha_sep; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPaciente; ?>&fechaNac=<? echo $fechaNac; ?>&prevPaciente=<? echo $prev_paciente; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>   
    
	<meta http-equiv='refresh' content='0; url=epicrisisPsiquiatria.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>'>
	
	<? }else{ ?>
		<meta http-equiv='refresh' content='0; url=epicrisisPsiquiatria.php?graba=1&idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>'>

<?		}

?>