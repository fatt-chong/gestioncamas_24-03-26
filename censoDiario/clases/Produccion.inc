<? class Produccion{
	function getCodigoPrestacion($codigo_1, $codigo_2){
		switch ($codigo_1) {
				case "1":	$diacama = '0203001';//CIRUGIA INDIFERENCIADA
							break;
				case "2":	$diacama = '0203001';//MEDICINA INDIFERENCIADA
							break;
				case "3":	$diacama = '0203001';//ONCOLOGIA INDIFERENCIADA
							break;
				case "4":	$diacama = '0203003';//PEDIATRICA UTI
							break;
				case "5":	if($codigo_2 == 1) $diacama = '0203006';//PEDIATRIAS LACTANTES
							else if($codigo_2 == 2) $diacama = '0203001';//PEDIATRIA INDIFERENCIADA
							break;
				case "7":	$diacama = '0203001';//TRAUMATOLOGIA INDIFERENCIADA
							break;
				case "8":	$diacama = '0203001';//GINECOLOGIA INDIFERENCIADA
							break;
				case "9":	$diacama = '0203001';//OBSTETRICIA INDIFERENCIADA
							break;
				case "10":	$diacama = '0203109';//PSIQUIATRIA CORTA ESTADIA
							break;
				case "11":	$diacama = '0203002';//CAMA CRITICA UCI
							break;
				case "12":	$diacama = '0203005';//CAMA CRITICA UTI
							break;
				case "13":	$diacama = '0203004';//NEONATOLOGIA UCI
							break;																	
				case "14":	$diacama = '0203007';//NEONATOLOGIA INTERMEDIO
							break;
				case "15":	$diacama = '0203015';//NEONATOLOGIA CUNA BASICA
							break;
				case "45":	$diacama = '0203001';//NEONATOLOGIA CUNA BASICA
							break;
				case "47":	$diacama = '0203001';//NEONATOLOGIA CUNA BASICA
							break;
				case "48":	$diacama = '0203001';//NEONATOLOGIA CUNA BASICA
							break;																					
				default:	return false;//CUALQUIER OTRO CASO RETORNA FALSE																							
		}		
		return $diacama;
	}
	function DiferenciaFecha($fecha1, $fecha2){
		$s = strtotime($fecha1)-strtotime($fecha2);
		$d = intval($s/86400);
		$s -= $d*86400;
		$h = intval($s/3600);
		$s -= $h*3600;
		$m = intval($s/60);
		$s -= $m*60;
		return $d;
	}
	function cargaDiaCama($HOSid, $PREcod, $link){
		$sql = "SELECT serv.idservicio AS cod_servicio, serv.nombre AS servicio, id_paciente, ficha_paciente, sexo_paciente, edad_paciente, cod_prevision,
				prevision, fecha_ingreso, fecha_egreso, censo_correlativo, sala, cta_cte, nom_paciente, rut_paciente
				FROM hospitalizaciones
				LEFT JOIN acceso.servicio AS serv ON serv.id = hospitalizaciones.cod_servicio
				WHERE hospitalizaciones.id = '$HOSid' 
				AND cod_prevision < 4
				AND cod_servicio <> 50";
		mysql_select_db('camas', $link);
		$rs_diacama = mysql_query($sql) or die(mysql_error());
		$row_rs_diacama = mysql_fetch_assoc($rs_diacama);
		$totalRowsrsdiacama = mysql_num_rows($rs_diacama);
		$fecha_actual = date('Y-m-d');
		$idpaciente = 0;
		$PatologiaCodigo = 0;
		
	if($totalRowsrsdiacama > 0){
	// Recorremos las prestaciones de Urgencia.
		// Revisamos si es un nuevo paciente
		if ($idpaciente <> $row_rs_diacama['id_paciente']) {
		  $idpaciente = $row_rs_diacama['id_paciente'];
		  $paciente_con_prestacion_ges = 1;
		  $compromiso = 0;
		}	
	
		// Vemos primero si el funcionario es beneficiario
		if ( $row_rs_diacama['cod_prevision'] < 4 ) {

			$numero_dias = $this->DiferenciaFecha($row_rs_diacama['fecha_egreso'], $row_rs_diacama['fecha_ingreso']);
			if ( $numero_dias == 0 ) { $numero_dias = 1; }

			// Revisamos si el paciente tiene alguna patologia GES Vigente
			mysql_select_db('paciente', $link);
			$query_rs_patologiavigente = "SELECT pacgesCod, pacgesPatoCod, pacgesPatoNombre, pacgesFechaInicio, pacgesFechaFin
                                          FROM pacienteges 
										  WHERE pacgesCod = '$row_rs_diacama[id_paciente]'
										  ORDER BY pacgesFechaFin DESC";
			$rs_patologiavigente = mysql_query($query_rs_patologiavigente, $link) or die(mysql_error());
			$row_rs_patologiavigente = mysql_fetch_assoc($rs_patologiavigente);
			$totalRowsrspatologiavigente = mysql_num_rows($rs_patologiavigente);
			
			// Recuperamos el nombre de la prestacion
			$query_rs_nombrediacama = "SELECT preNombre FROM prestacion WHERE preCod = '$PREcod'";
			$rs_nombrediacama = mysql_query($query_rs_nombrediacama, $link) or die(mysql_error());
			$row_rs_nombrediacama = mysql_fetch_assoc($rs_nombrediacama);					
			
			// Si encontramos que el paciente tiene una patologia y esta es vigente, revisamos si la prestacion pertenece a la canasta de su patología
		   	if  ($totalRowsrspatologiavigente > 0) {
				
				$patologiasvigentes = array();
				$i=0;	
				do {
					$patologiasvigentes[$i]['pacgesCod'] = $row_rs_patologiavigente['pacgesCod'];
					$patologiasvigentes[$i]['pacgesPatoCod'] = $row_rs_patologiavigente['pacgesPatoCod'];
					$patologiasvigentes[$i]['pacgesFechaInicio'] = $row_rs_patologiavigente['pacgesFechaInicio'];
					$patologiasvigentes[$i++]['pacgesFechaFin'] = $row_rs_patologiavigente['pacgesFechaFin'];
				} while ($row_rs_patologiavigente = mysql_fetch_assoc($rs_patologiavigente));			
			
				mysql_select_db('acceso', $link);				
				for ($j=0 ; $j < count($patologiasvigentes)  ; $j++){

					if (($patologiasvigentes[$j]['pacgesFechaInicio'] <= $row_rs_diacama['fecha_egreso']) && ($patologiasvigentes[$j]['pacgesFechaFin'] >= $row_rs_diacama['fecha_egreso'])) {
						
						$query_rs_prestacionges = "	SELECT ppvprestaciones.progCod, ppvprestaciones.subprogCod, ppvprestaciones.compromiso, ppvprestaciones.prestacion, ppvcompromisos.valor,
													ppvcompromisos.cantidad, ppvcompromisos.descripcion, ppvsubprogramas.subprogNombre, ppvprogramas.progDescripcion
													FROM ppvprestaciones
													INNER JOIN ppvcompromisos ON ppvcompromisos.progCod = ppvprestaciones.progCod AND ppvcompromisos.subprogCod = ppvprestaciones.subprogCod AND ppvcompromisos.compromiso = ppvprestaciones.compromiso
													LEFT JOIN ppvsubprogramas ON ppvcompromisos.progCod = ppvsubprogramas.progCod AND ppvcompromisos.subprogCod = ppvsubprogramas.subprogCod
													INNER JOIN ppvprogramas ON ppvcompromisos.progCod = ppvprogramas.progCod
													WHERE ppvprestaciones.progCod = 4 AND ppvprestaciones.subprogCod = '$patologiasvigentes[$j][pacgesPatoCod]' AND ppvprestaciones.prestacion = '$PREcod'";
						$rs_prestacionges = mysql_query($query_rs_prestacionges, $link) or die(mysql_error());
						$row_rs_prestacionges = mysql_fetch_assoc($rs_prestacionges);
						$totalRowsrsprestacionges = mysql_num_rows($rs_prestacionges);
				
						if ($totalRowsrsprestacionges > 0) {
							$j = count($patologiasvigentes);	
						}
					}
				}
								
				// tiene una prestacion de la Canasta vigente
				if ( $totalRowsrsprestacionges > 0 ) {

					// controla que si el paciente tiene mas de una prestacion en el mismo compromiso, si ese es el caso el valor solo estará solo en una de las prestaciones, ya que el valor es del compromiso y no de la prestacion
					if ( $compromiso <> $row_rs_prestacionges['compromiso']) {
						$compromiso = $row_rs_prestacionges['compromiso'];
						$paciente_con_prestacion_ges = 1;
					} else {
					    $paciente_con_prestacion_ges = $paciente_con_prestacion_ges + 1;	
					}

					if ($paciente_con_prestacion_ges > 1) {
						$valor = 0;
					} else {
						$valor = $row_rs_prestacionges['valor'];
					}	
					
					mysql_select_db('estadistica', $link);
					$query_insert_matriz = "insert into matrizppvppi(matrizppvppi.matrizCodPrestacion,
																	 matrizppvppi.matrizTipoPrestacionValorada,
																	 matrizppvppi.matrizCodPrograma,
																	 matrizppvppi.matrizCantPrestacion,
																	 matrizppvppi.matrizNombrePrestacion,
																	 matrizppvppi.matrizTipoPrestacion,
																	 matrizppvppi.matrizCodPatologia,
																	 matrizppvppi.matrizNombrePatologia,
																	 matrizppvppi.matrizValorPrestacion,
																	 matrizppvppi.matrizPacieCod,
																	 matrizppvppi.matrizRutPaciente,
																	 matrizppvppi.matrizNombrePacie,
																	 matrizppvppi.matrizFichaPacie,
																	 matrizppvppi.matrizSexoPacie,
																	 matrizppvppi.matrizFNacPacie,
																	 matrizppvppi.matrizPreviCod,
																	 matrizppvppi.matrizConvenio,
																	 matrizppvppi.matrizCodServicio,
																	 matrizppvppi.matrizNomServicio,
																	 matrizppvppi.matrizFRegPrestacion,
																	 matrizppvppi.matrizFDigitacion,
																	 matrizppvppi.matrizOrigenAtPrestacion,
																	 matrizppvppi.matrizTablaOrigen,
																	 matrizppvppi.matrizCantidadComprometida,
																	 matrizEdadPaciente,
																	 matrizPreviNombre,
																	 matrizConvenioNombre,
																	 matrizNombrePrograma,
																	 matrizNombreCompromiso,
																	 matrizCodCompromiso,
																	 matrizCodSistema,
																	 matrizTipoSistema)
															 values('$PREcod',
																	'V',
																	'$row_rs_prestacionges[progCod]',
																	'$numero_dias',
																	'$row_rs_nombrediacama[preNombre]',
																	'P',
																	'$row_rs_prestacionges[subprogCod]',
																	'$row_rs_prestacionges[subprogNombre]',
																	'$valor',
																	'$row_rs_diacama[id_paciente]',
																	'$row_rs_diacama[rut_paciente]',
																	'$row_rs_diacama[nom_paciente]',
																	'$row_rs_diacama[ficha_paciente]',
																	'$row_rs_diacama[sexo_paciente]',
																	'1000-01-01',
																	'$row_rs_diacama[cod_prevision]',
																	'0',
																	'$row_rs_diacama[cod_servicio]',
																	'$row_rs_diacama[servicio]',
																	'$row_rs_diacama[fecha_egreso]',
																	'$fecha_actual',
																	'3',
																	'hospitalizaciones',
																	'$row_rs_prestacionges[cantidad]',
																	'$row_rs_diacama[edad_paciente]',
																	'$row_rs_diacama[prevision]',
																	'',
																	'$row_rs_prestacionges[progDescripcion]',
																	'$row_rs_prestacionges[descripcion]',
																	'$row_rs_prestacionges[compromiso]',
																	'$HOSid',
																	'GESCAM')";												
					$rs_insert_matriz = mysql_query($query_insert_matriz, $link) or die(mysql_error());	
				}else{
					// Revisamos si la prestacion de rayos pertenece a una de los programas NO Auge PPV
					mysql_select_db('acceso', $link);
					$query_rs_prestacionPPV = "	SELECT ppvprestaciones.progCod, ppvprestaciones.subprogCod, ppvprestaciones.compromiso, ppvprestaciones.prestacion, ppvcompromisos.valor,
												ppvcompromisos.cantidad, ppvcompromisos.descripcion, ppvsubprogramas.subprogNombre, ppvprogramas.progDescripcion
												FROM ppvprestaciones
												INNER JOIN ppvcompromisos ON ppvcompromisos.progCod = ppvprestaciones.progCod AND ppvcompromisos.subprogCod = ppvprestaciones.subprogCod AND ppvcompromisos.compromiso = ppvprestaciones.compromiso
												LEFT JOIN ppvsubprogramas ON ppvcompromisos.progCod = ppvsubprogramas.progCod AND ppvcompromisos.subprogCod = ppvsubprogramas.subprogCod
												INNER JOIN ppvprogramas ON ppvcompromisos.progCod = ppvprogramas.progCod
												WHERE ppvprestaciones.progCod <> 4 AND ppvprestaciones.prestacion = '$PREcod'";
					$rs_prestacionPPV = mysql_query($query_rs_prestacionPPV, $link) or die(mysql_error());
					$row_rs_prestacionPPV = mysql_fetch_assoc($rs_prestacionPPV);
					$totalRowsrsprestacionPPV = mysql_num_rows($rs_prestacionPPV);	
					
					if ( $totalRowsrsprestacionPPV > 0 ) { // Se encontro que la prestacion es de un programa NO Auge
	
						// controla que si el paciente tiene mas de una prestacion en el mismo compromiso, si ese es el caso el valor solo estará solo en una de las prestaciones, ya que el valor es del compromiso y no de la prestacion
						if ( $compromiso <> $row_rs_prestacionPPV['compromiso']) {
							$compromiso = $row_rs_prestacionPPV['compromiso'];
							$paciente_con_prestacion_ges = 1;
						} else {
							$paciente_con_prestacion_ges = $paciente_con_prestacion_ges + 1;	
						}
	
						if ($paciente_con_prestacion_ges > 1) {
							$valor = 0;
						} else {
							$valor = $row_rs_prestacionPPV['valor'];
						}
											
						mysql_select_db('estadistica', $link);
						$query_insert_matriz = "INSERT INTO matrizppvppi(matrizppvppi.matrizCodPrestacion,
																		 matrizppvppi.matrizTipoPrestacionValorada,
																		 matrizppvppi.matrizCodPrograma,
																		 matrizppvppi.matrizCantPrestacion,
																		 matrizppvppi.matrizNombrePrestacion,
																		 matrizppvppi.matrizTipoPrestacion,
																		 matrizppvppi.matrizCodPatologia,
																		 matrizppvppi.matrizNombrePatologia,
																		 matrizppvppi.matrizValorPrestacion,
																		 matrizppvppi.matrizPacieCod,
																		 matrizppvppi.matrizRutPaciente,
																		 matrizppvppi.matrizNombrePacie,
																		 matrizppvppi.matrizFichaPacie,
																		 matrizppvppi.matrizSexoPacie,
																		 matrizppvppi.matrizFNacPacie,
																		 matrizppvppi.matrizPreviCod,
																		 matrizppvppi.matrizConvenio,
																		 matrizppvppi.matrizCodServicio,
																		 matrizppvppi.matrizNomServicio,
																		 matrizppvppi.matrizFRegPrestacion,
																		 matrizppvppi.matrizFDigitacion,
																		 matrizppvppi.matrizOrigenAtPrestacion,
																		 matrizppvppi.matrizTablaOrigen,
																		 matrizppvppi.matrizCantidadComprometida,
																		 matrizEdadPaciente,
																		 matrizPreviNombre,
																		 matrizConvenioNombre,
																		 matrizNombrePrograma,
																		 matrizNombreCompromiso,
																		 matrizCodCompromiso,
																		 matrizCodSistema,
																		 matrizTipoSistema)
																 VALUES('$PREcod',
																		'V',
																		'$row_rs_prestacionPPV[progCod]',
																		'$numero_dias',
																		'$row_rs_nombrediacama[preNombre]',
																		'P',
																		'$row_rs_prestacionPPV[subprogCod]',
																		'$row_rs_prestacionPPV[subprogNombre]',
																		'$valor',
																		'$row_rs_diacama[id_paciente]',
																		'$row_rs_diacama[rut_paciente]',
																		'$row_rs_diacama[nom_paciente]',
																		'$row_rs_diacama[ficha_paciente]',
																		'$row_rs_diacama[sexo_paciente]',
																		'1000-01-01',
																		'$row_rs_diacama[cod_prevision]',
																		'0',
																		'$row_rs_diacama[cod_servicio]',
																		'$row_rs_diacama[servicio]',
																		'$row_rs_diacama[fecha_egreso]',
																		'$fecha_actual',
																		'3',
																		'hospitalizaciones',
																		'$row_rs_prestacionPPV[cantidad]',
																		'$row_rs_diacama[edad_paciente]',
																		'$row_rs_diacama[prevision]',
																		'',
																		'$row_rs_prestacionPPV[progDescripcion]',
																		'$row_rs_prestacionPPV[descripcion]',
																		'$row_rs_prestacionPPV[compromiso]',
																		'$HOSid',
																		'GESCAM')";											
						$rs_insert_matriz = mysql_query($query_insert_matriz, $link) or die(mysql_error());	
										
					}else{
						mysql_select_db('paciente', $link);
						$query_rs_prestacionMAI = "SELECT prestacion.preFacturacion FROM prestacion WHERE prestacion.preCod = '$PREcod'";
						$rs_prestacionMAI = mysql_query($query_rs_prestacionMAI, $link) or die(mysql_error());
						$row_rs_prestacionMAI = mysql_fetch_assoc($rs_prestacionMAI);
						mysql_select_db('estadistica', $link);
						$query_insert_matriz = "INSERT INTO matrizppvppi(matrizppvppi.matrizCodPrestacion,
																		 matrizppvppi.matrizTipoPrestacionValorada,
																		 matrizppvppi.matrizCodPrograma,
																		 matrizppvppi.matrizCantPrestacion,
																		 matrizppvppi.matrizNombrePrestacion,
																		 matrizppvppi.matrizTipoPrestacion,
																		 matrizppvppi.matrizCodPatologia,
																		 matrizppvppi.matrizNombrePatologia,
																		 matrizppvppi.matrizValorPrestacion,
																		 matrizppvppi.matrizPacieCod,
																		 matrizppvppi.matrizRutPaciente,
																		 matrizppvppi.matrizNombrePacie,
																		 matrizppvppi.matrizFichaPacie,
																		 matrizppvppi.matrizSexoPacie,
																		 matrizppvppi.matrizFNacPacie,
																		 matrizppvppi.matrizPreviCod,
																		 matrizppvppi.matrizConvenio,
																		 matrizppvppi.matrizCodServicio,
																		 matrizppvppi.matrizNomServicio,
																		 matrizppvppi.matrizFRegPrestacion,
																		 matrizppvppi.matrizFDigitacion,
																		 matrizppvppi.matrizOrigenAtPrestacion,
																		 matrizppvppi.matrizTablaOrigen,
																		 matrizppvppi.matrizCantidadComprometida,
																		 matrizEdadPaciente,
																		 matrizPreviNombre,
																		 matrizConvenioNombre,
																		 matrizNombrePrograma,
																		 matrizNombreCompromiso,
																		 matrizCodCompromiso,
																		 matrizCodSistema,
																		 matrizTipoSistema) 
																VALUES ('$PREcod',
																		'I',
																		'0',
																		'$numero_dias',
																		'$row_rs_nombrediacama[preNombre]',
																		'P',
																		'0',
																		'',
																		'$row_rs_prestacionMAI[preFacturacion]',
																		'$row_rs_diacama[id_paciente]',
																		'$row_rs_diacama[rut_paciente]',
																		'$row_rs_diacama[nom_paciente]',
																		'$row_rs_diacama[ficha_paciente]',
																		'$row_rs_diacama[sexo_paciente]',
																		'1000-01-01',
																		'$row_rs_diacama[cod_prevision]',
																		'0',
																		'$row_rs_diacama[cod_servicio]',
																		'$row_rs_diacama[servicio]',
																		'$row_rs_diacama[fecha_egreso]',
																		'$fecha_actual',
																		'3',
																		'hospitalizaciones',
																		'0',
																		'$row_rs_diacama[edad_paciente]',
																		'$row_rs_diacama[prevision]',
																		'',
																		'',
																		'',
																		'0',
																		'$HOSid',
																		'GESCAM')";												
						$rs_insert_matriz = mysql_query($query_insert_matriz, $link) or die(mysql_error());
					}
				}
			} else { // paciente no Auge pero es beneficiario
			
				// Revisamos si la prestacion de rayos pertenece a una de los programas NO Auge PPV
				mysql_select_db('acceso', $link);
				$query_rs_prestacionPPV = "	SELECT ppvprestaciones.progCod, ppvprestaciones.subprogCod, ppvprestaciones.compromiso, ppvprestaciones.prestacion, ppvcompromisos.valor,
											ppvcompromisos.cantidad, ppvcompromisos.descripcion, ppvsubprogramas.subprogNombre, ppvprogramas.progDescripcion
											FROM ppvprestaciones
											INNER JOIN ppvcompromisos ON ppvcompromisos.progCod = ppvprestaciones.progCod AND ppvcompromisos.subprogCod = ppvprestaciones.subprogCod AND ppvcompromisos.compromiso = ppvprestaciones.compromiso
											LEFT JOIN ppvsubprogramas ON ppvcompromisos.progCod = ppvsubprogramas.progCod AND ppvcompromisos.subprogCod = ppvsubprogramas.subprogCod
											INNER JOIN ppvprogramas ON ppvcompromisos.progCod = ppvprogramas.progCod
											WHERE ppvprestaciones.progCod <> 4 AND ppvprestaciones.prestacion = '$PREcod'";
				$rs_prestacionPPV = mysql_query($query_rs_prestacionPPV, $link) or die(mysql_error());
				$row_rs_prestacionPPV = mysql_fetch_assoc($rs_prestacionPPV);
				$totalRowsrsprestacionPPV = mysql_num_rows($rs_prestacionPPV);	
				
				if ( $totalRowsrsprestacionPPV > 0 ) { // Se encontro que la prestacion es de un programa NO Auge

					// controla que si el paciente tiene mas de una prestacion en el mismo compromiso, si ese es el caso el valor solo estará solo en una de las prestaciones, ya que el valor es del compromiso y no de la prestacion
					if ( $compromiso <> $row_rs_prestacionPPV['compromiso']) {
						$compromiso = $row_rs_prestacionPPV['compromiso'];
						$paciente_con_prestacion_ges = 1;
					} else {
					    $paciente_con_prestacion_ges = $paciente_con_prestacion_ges + 1;	
					}

					if ($paciente_con_prestacion_ges > 1) {
						$valor = 0;
					} else {
						$valor = $row_rs_prestacionPPV['valor'];
					}
										
					mysql_select_db('estadistica', $link);
					$query_insert_matriz = "INSERT INTO matrizppvppi(matrizppvppi.matrizCodPrestacion,
																	 matrizppvppi.matrizTipoPrestacionValorada,
																	 matrizppvppi.matrizCodPrograma,
																	 matrizppvppi.matrizCantPrestacion,
																	 matrizppvppi.matrizNombrePrestacion,
																	 matrizppvppi.matrizTipoPrestacion,
																	 matrizppvppi.matrizCodPatologia,
																	 matrizppvppi.matrizNombrePatologia,
																	 matrizppvppi.matrizValorPrestacion,
																	 matrizppvppi.matrizPacieCod,
																	 matrizppvppi.matrizRutPaciente,
																	 matrizppvppi.matrizNombrePacie,
																	 matrizppvppi.matrizFichaPacie,
																	 matrizppvppi.matrizSexoPacie,
																	 matrizppvppi.matrizFNacPacie,
																	 matrizppvppi.matrizPreviCod,
																	 matrizppvppi.matrizConvenio,
																	 matrizppvppi.matrizCodServicio,
																	 matrizppvppi.matrizNomServicio,
																	 matrizppvppi.matrizFRegPrestacion,
																	 matrizppvppi.matrizFDigitacion,
																	 matrizppvppi.matrizOrigenAtPrestacion,
																	 matrizppvppi.matrizTablaOrigen,
																	 matrizppvppi.matrizCantidadComprometida,
																	 matrizEdadPaciente,
																	 matrizPreviNombre,
																	 matrizConvenioNombre,
																	 matrizNombrePrograma,
																	 matrizNombreCompromiso,
																	 matrizCodCompromiso,
																	 matrizCodSistema,
																	 matrizTipoSistema)
															 VALUES('$PREcod',
																	'V',
																	'$row_rs_prestacionPPV[progCod]',
																	'$numero_dias',
																	'$row_rs_nombrediacama[preNombre]',
																	'P',
																	'$row_rs_prestacionPPV[subprogCod]',
																	'$row_rs_prestacionPPV[subprogNombre]',
																	'$valor',
																	'$row_rs_diacama[id_paciente]',
																	'$row_rs_diacama[rut_paciente]',
																	'$row_rs_diacama[nom_paciente]',
																	'$row_rs_diacama[ficha_paciente]',
																	'$row_rs_diacama[sexo_paciente]',
																	'1000-01-01',
																	'$row_rs_diacama[cod_prevision]',
																	'0',
																	'$row_rs_diacama[cod_servicio]',
																	'$row_rs_diacama[servicio]',
																	'$row_rs_diacama[fecha_egreso]',
																	'$fecha_actual',
																	'3',
																	'hospitalizaciones',
																	'$row_rs_prestacionPPV[cantidad]',
																	'$row_rs_diacama[edad_paciente]',
																	'$row_rs_diacama[prevision]',
																	'',
																	'$row_rs_prestacionPPV[progDescripcion]',
																	'$row_rs_prestacionPPV[descripcion]',
																	'$row_rs_prestacionPPV[compromiso]',
																	'$HOSid',
																	'GESCAM')";											
					$rs_insert_matriz = mysql_query($query_insert_matriz, $link) or die(mysql_error());	
									
				}else{
					mysql_select_db('paciente', $link);
					$query_rs_prestacionMAI = "SELECT prestacion.preFacturacion FROM prestacion WHERE prestacion.preCod = '$PREcod'";
					$rs_prestacionMAI = mysql_query($query_rs_prestacionMAI, $link) or die(mysql_error());
					$row_rs_prestacionMAI = mysql_fetch_assoc($rs_prestacionMAI);
					mysql_select_db('estadistica', $link);
					$query_insert_matriz = "INSERT INTO matrizppvppi(matrizppvppi.matrizCodPrestacion,
																	 matrizppvppi.matrizTipoPrestacionValorada,
																	 matrizppvppi.matrizCodPrograma,
																	 matrizppvppi.matrizCantPrestacion,
																	 matrizppvppi.matrizNombrePrestacion,
																	 matrizppvppi.matrizTipoPrestacion,
																	 matrizppvppi.matrizCodPatologia,
																	 matrizppvppi.matrizNombrePatologia,
																	 matrizppvppi.matrizValorPrestacion,
																	 matrizppvppi.matrizPacieCod,
																	 matrizppvppi.matrizRutPaciente,
																	 matrizppvppi.matrizNombrePacie,
																	 matrizppvppi.matrizFichaPacie,
																	 matrizppvppi.matrizSexoPacie,
																	 matrizppvppi.matrizFNacPacie,
																	 matrizppvppi.matrizPreviCod,
																	 matrizppvppi.matrizConvenio,
																	 matrizppvppi.matrizCodServicio,
																	 matrizppvppi.matrizNomServicio,
																	 matrizppvppi.matrizFRegPrestacion,
																	 matrizppvppi.matrizFDigitacion,
																	 matrizppvppi.matrizOrigenAtPrestacion,
																	 matrizppvppi.matrizTablaOrigen,
																	 matrizppvppi.matrizCantidadComprometida,
																	 matrizEdadPaciente,
																	 matrizPreviNombre,
																	 matrizConvenioNombre,
																	 matrizNombrePrograma,
																	 matrizNombreCompromiso,
																	 matrizCodCompromiso,
																	 matrizCodSistema,
																	 matrizTipoSistema) 
															VALUES ('$PREcod',
																	'I',
																	'0',
																	'$numero_dias',
																	'$row_rs_nombrediacama[preNombre]',
																	'P',
																	'0',
																	'',
																	'$row_rs_prestacionMAI[preFacturacion]',
																	'$row_rs_diacama[id_paciente]',
																	'$row_rs_diacama[rut_paciente]',
																	'$row_rs_diacama[nom_paciente]',
																	'$row_rs_diacama[ficha_paciente]',
																	'$row_rs_diacama[sexo_paciente]',
																	'1000-01-01',
																	'$row_rs_diacama[cod_prevision]',
																	'0',
																	'$row_rs_diacama[cod_servicio]',
																	'$row_rs_diacama[servicio]',
																	'$row_rs_diacama[fecha_egreso]',
																	'$fecha_actual',
																	'3',
																	'hospitalizaciones',
																	'0',
																	'$row_rs_diacama[edad_paciente]',
																	'$row_rs_diacama[prevision]',
																	'',
																	'',
																	'',
																	'0',
																	'$HOSid',
																	'GESCAM')";												
					$rs_insert_matriz = mysql_query($query_insert_matriz, $link) or die(mysql_error());
					
				}//FIN encontro que la prestacion es de un programa NO Auge
			} // fin paciente no Auge
			
		} // fin beneficiario
	
	}
	
	}
}
?>