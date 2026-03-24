<?php 
	// Recopilamos las prestaciones de Rayos según fecha de corte del mes de proceso de imagenologia
	$paciente = mysql_pconnect('10.6.21.29', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db('camas', $paciente);
	
	//$fecha_inicial = $ano_proceso . '-' . $mes_proceso . '-01';
	//$fecha_final = ultimoDiaMes($mes_proceso,$ano_proceso);

	$query_rs_diacama = sprintf("SELECT hospitalizaciones.cod_servicio,
                                        hospitalizaciones.servicio,
                                        hospitalizaciones.id_paciente,
                                        hospitalizaciones.ficha_paciente,
                                        hospitalizaciones.sexo_paciente,
                                        hospitalizaciones.edad_paciente,
                                        hospitalizaciones.cod_prevision,
                                        hospitalizaciones.prevision,
                                        hospitalizaciones.fecha_ingreso,
                                        hospitalizaciones.fecha_egreso,
                                        hospitalizaciones.censo_correlativo,
                                        hospitalizaciones.sala,
                                        hospitalizaciones.cta_cte,
                                        hospitalizaciones.nom_paciente,
                                        hospitalizaciones.rut_paciente
                                  FROM hospitalizaciones
                                  WHERE camas.hospitalizaciones.fecha_egreso BETWEEN %s AND %s AND
                                        camas.hospitalizaciones.censo_correlativo > 0 AND
                                        camas.hospitalizaciones.cod_prevision < 4 AND
										hospitalizaciones.cod_servicio <> 50
                                  order by hospitalizaciones.id_paciente",
							    GetSQLValueString($fecha_inicial, "date"),
								GetSQLValueString($fecha_final, "date"));
	$rs_diacama = mysql_query($query_rs_diacama, $paciente) or die(mysql_error());
	$row_rs_diacama = mysql_fetch_assoc($rs_diacama);
	$totalRowsrsdiacama = mysql_num_rows($rs_diacama);

	$idpaciente = 0;
	$PatologiaCodigo = 0;
		
	if ( $totalRowsrsdiacama > 0 ) {
	// Recorremos las prestaciones de Urgencia.
	do {	
		// Revisamos si es un nuevo paciente
		if ($idpaciente <> $row_rs_diacama['id_paciente']) {
		  $idpaciente = $row_rs_diacama['id_paciente'];
		  $paciente_con_prestacion_ges = 1;
		  $compromiso = 0;
		}	
	
		// Vemos primero si el funcionario es beneficiario
		if ( $row_rs_diacama['cod_prevision'] < 4 ) {

			$diacama = 	recupera_diacama($row_rs_diacama['cod_servicio'], $row_rs_diacama['sala']);
			$numero_dias = DiferenciaFecha($row_rs_diacama['fecha_egreso'], $row_rs_diacama['fecha_ingreso']);
			if ( $numero_dias == 0 ) { $numero_dias = 1; }

			// Revisamos si el paciente tiene alguna patologia GES Vigente
			mysql_select_db('paciente', $paciente);
			$query_rs_patologiavigente = sprintf("SELECT paciente.pacienteges.pacgesCod, paciente.pacienteges.pacgesPatoCod, paciente.pacienteges.pacgesPatoNombre, paciente.pacienteges.pacgesFechaInicio, paciente.pacienteges.pacgesFechaFin
                                          FROM paciente.pacienteges WHERE paciente.pacienteges.pacgesCod = %s ORDER BY paciente.pacienteges.pacgesFechaFin DESC", GetSQLValueString($row_rs_diacama['id_paciente'],"int"));
			$rs_patologiavigente = mysql_query($query_rs_patologiavigente, $paciente) or die(mysql_error());
			$row_rs_patologiavigente = mysql_fetch_assoc($rs_patologiavigente);
			$totalRowsrspatologiavigente = mysql_num_rows($rs_patologiavigente);
			
			// Recuperamos el nombre de la prestacion
			$query_rs_nombrediacama = sprintf("SELECT prestacion.preNombre FROM prestacion WHERE prestacion.preCod = %s", GetSQLValueString($diacama,"text"));
			$rs_nombrediacama = mysql_query($query_rs_nombrediacama, $paciente) or die(mysql_error());
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
			
				mysql_select_db('acceso', $paciente);				
				for ($j=0 ; $j < count($patologiasvigentes)  ; $j++){

					if (($patologiasvigentes[$j]['pacgesFechaInicio'] <= $row_rs_diacama['fecha_egreso']) && ($patologiasvigentes[$j]['pacgesFechaFin'] >= $row_rs_diacama['fecha_egreso'])) {
						
						$query_rs_prestacionges = sprintf("SELECT ppvprestaciones.progCod, ppvprestaciones.subprogCod, ppvprestaciones.compromiso, ppvprestaciones.prestacion, ppvcompromisos.valor,
                                                          ppvcompromisos.cantidad, ppvcompromisos.descripcion, ppvsubprogramas.subprogNombre, ppvprogramas.progDescripcion
												   FROM ppvprestaciones
                                                        INNER JOIN ppvcompromisos ON ppvcompromisos.progCod = ppvprestaciones.progCod AND ppvcompromisos.subprogCod = ppvprestaciones.subprogCod AND ppvcompromisos.compromiso = ppvprestaciones.compromiso
                                                        LEFT JOIN ppvsubprogramas ON ppvcompromisos.progCod = ppvsubprogramas.progCod AND ppvcompromisos.subprogCod = ppvsubprogramas.subprogCod
														INNER JOIN ppvprogramas ON ppvcompromisos.progCod = ppvprogramas.progCod
                                                   WHERE ppvprestaciones.progCod = 4 AND ppvprestaciones.subprogCod = %s AND ppvprestaciones.prestacion = %s",
												   GetSQLValueString($patologiasvigentes[$j]['pacgesPatoCod'],"int"), GetSQLValueString($diacama,"text"));
						$rs_prestacionges = mysql_query($query_rs_prestacionges, $paciente) or die(mysql_error());
						$row_rs_prestacionges = mysql_fetch_assoc($rs_prestacionges);
						$totalRowsrsprestacionges = mysql_num_rows($rs_prestacionges);
				
						if ( $totalRowsrsprestacionges > 0 ) {
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
					
					//echo "PPV Auge-PacId:".$row_rs_diacama['id_paciente']."-Nombre:".$row_rs_diacama['nom_paciente']."-Prestacion:".$diacama."-Valor:".$valor."<br/>";
					mysql_select_db('estadistica', $paciente);
					$query_insert_matriz = sprintf("insert into matrizppvppi(matrizppvppi.matrizCodPrestacion,
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
																			 matrizCodCompromiso) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
											GetSQLValueString($diacama,"text"),
											GetSQLValueString('V',"text"),
											GetSQLValueString($row_rs_prestacionges['progCod'],"int"),
											GetSQLValueString($numero_dias,"int"),
											GetSQLValueString($row_rs_nombrediacama['preNombre'],"text"),
											GetSQLValueString('P',"text"),
											GetSQLValueString($row_rs_prestacionges['subprogCod'],"int"),
											GetSQLValueString($row_rs_prestacionges['subprogNombre'],"text"),
											GetSQLValueString($valor,"int"),
											GetSQLValueString($row_rs_diacama['id_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['rut_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['nom_paciente'],"text"),
											GetSQLValueString($row_rs_diacama['ficha_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['sexo_paciente'],"text"),
											GetSQLValueString('1000-01-01',"date"),
											GetSQLValueString($row_rs_diacama['prevision'],"int"),
											GetSQLValueString(0,"int"),
											GetSQLValueString($row_rs_diacama['cod_servicio'],"int"),
											GetSQLValueString($row_rs_diacama['servicio'],"text"),
											GetSQLValueString($row_rs_diacama['fecha_egreso'],"date"),
											GetSQLValueString($fecha_actual,"date"),
											GetSQLValueString(3,"int"),
											GetSQLValueString('hospitalizaciones',"text"),
					                        GetSQLValueString($row_rs_prestacionges['cantidad'],"int"),
											GetSQLValueString($row_rs_diacama['edad_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['prevision'],"text"),
											GetSQLValueString('',"text"),
											GetSQLValueString($row_rs_prestacionges['progDescripcion'],"text"),
											GetSQLValueString($row_rs_prestacionges['descripcion'],"text"),
											GetSQLValueString($row_rs_prestacionges['compromiso'],"int"));												
					$rs_insert_matriz = mysql_query($query_insert_matriz, $paciente) or die(mysql_error());	
				}
			} else { // paciente no Auge pero es beneficiario
			
				// Revisamos si la prestacion de rayos pertenece a una de los programas NO Auge PPV
				mysql_select_db('acceso', $paciente);
				$query_rs_prestacionPPV = sprintf("SELECT ppvprestaciones.progCod, ppvprestaciones.subprogCod, ppvprestaciones.compromiso, ppvprestaciones.prestacion, ppvcompromisos.valor,
                                                          ppvcompromisos.cantidad, ppvcompromisos.descripcion, ppvsubprogramas.subprogNombre, ppvprogramas.progDescripcion
												   FROM ppvprestaciones
                                                        INNER JOIN ppvcompromisos ON ppvcompromisos.progCod = ppvprestaciones.progCod AND ppvcompromisos.subprogCod = ppvprestaciones.subprogCod AND ppvcompromisos.compromiso = ppvprestaciones.compromiso
                                                        LEFT JOIN ppvsubprogramas ON ppvcompromisos.progCod = ppvsubprogramas.progCod AND ppvcompromisos.subprogCod = ppvsubprogramas.subprogCod
														INNER JOIN ppvprogramas ON ppvcompromisos.progCod = ppvprogramas.progCod
                                                   WHERE ppvprestaciones.progCod <> 4 AND ppvprestaciones.prestacion = %s",
										   GetSQLValueString($diacama,"text"));
				$rs_prestacionPPV = mysql_query($query_rs_prestacionPPV, $paciente) or die(mysql_error());
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
										
					//echo "PPV NO Auge-PacId:".$row_rs_diacama['id_paciente']."-Nombre:".$row_rs_diacama['nom_paciente']."-Prestacion:".$diacama."-Valor:".$valor."<br/>";
					mysql_select_db('estadistica', $paciente);
					$query_insert_matriz = sprintf("insert into matrizppvppi(matrizppvppi.matrizCodPrestacion,
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
																			 matrizCodCompromiso) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
											GetSQLValueString($diacama,"text"),
											GetSQLValueString('V',"text"),
											GetSQLValueString($row_rs_prestacionPPV['progCod'],"int"),
											GetSQLValueString($numero_dias,"int"),
											GetSQLValueString($row_rs_nombrediacama['preNombre'],"text"),
											GetSQLValueString('P',"text"),
											GetSQLValueString($row_rs_prestacionPPV['subprogCod'],"int"),
											GetSQLValueString($row_rs_prestacionPPV['subprogNombre'],"text"),
											GetSQLValueString($valor,"int"),
											GetSQLValueString($row_rs_diacama['id_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['rut_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['nom_paciente'],"text"),
											GetSQLValueString($row_rs_diacama['ficha_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['sexo_paciente'],"text"),
											GetSQLValueString('1000-01-01',"date"),
											GetSQLValueString($row_rs_diacama['prevision'],"int"),
											GetSQLValueString(0,"int"),
											GetSQLValueString($row_rs_diacama['cod_servicio'],"int"),
											GetSQLValueString($row_rs_diacama['servicio'],"text"),
											GetSQLValueString($row_rs_diacama['fecha_egreso'],"date"),
											GetSQLValueString($fecha_actual,"date"),
											GetSQLValueString(3,"int"),
											GetSQLValueString('hospitalizaciones',"text"),
					                        GetSQLValueString($row_rs_prestacionPPV['cantidad'],"int"),
											GetSQLValueString($row_rs_diacama['edad_paciente'],"int"),
											GetSQLValueString($row_rs_diacama['prevision'],"text"),
											GetSQLValueString('',"text"),
											GetSQLValueString($row_rs_prestacionPPV['progDescripcion'],"text"),
											GetSQLValueString($row_rs_prestacionPPV['descripcion'],"text"),
											GetSQLValueString($row_rs_prestacionPPV['compromiso'],"int"));											
					$rs_insert_matriz = mysql_query($query_insert_matriz, $paciente) or die(mysql_error());	
									
				} //else { // No se encontro la prestacion para un programa por lo tanto es PPI
//					
//					mysql_select_db('paciente', $paciente);
//					$query_rs_prestacionMAI = sprintf("SELECT prestacion.preFacturacion FROM prestacion WHERE prestacion.preCod = %s",GetSQLValueString($diacama,"text"));
//					$rs_prestacionMAI = mysql_query($query_rs_prestacionMAI, $paciente) or die(mysql_error());
//					$row_rs_prestacionMAI = mysql_fetch_assoc($rs_prestacionMAI);
//
//					//echo "PPI";
//					mysql_select_db('estadistica', $paciente);
//					$query_insert_matriz = sprintf("insert into matrizppvppi(matrizppvppi.matrizCodPrestacion,
//					                                                         matrizppvppi.matrizTipoPrestacionValorada,
//																			 matrizppvppi.matrizCodPrograma,
//                                                                             matrizppvppi.matrizCantPrestacion,
//																			 matrizppvppi.matrizNombrePrestacion,
//																			 matrizppvppi.matrizTipoPrestacion,
//																			 matrizppvppi.matrizCodPatologia,
//																			 matrizppvppi.matrizNombrePatologia,
//                                                                             matrizppvppi.matrizValorPrestacion,
//																		     matrizppvppi.matrizPacieCod,
//																			 matrizppvppi.matrizRutPaciente,
//																			 matrizppvppi.matrizNombrePacie,
//																			 matrizppvppi.matrizFichaPacie,
//																			 matrizppvppi.matrizSexoPacie,
//                                                                             matrizppvppi.matrizFNacPacie,
//													                         matrizppvppi.matrizPreviCod,
//																			 matrizppvppi.matrizConvenio,
//																			 matrizppvppi.matrizCodServicio,
//																			 matrizppvppi.matrizNomServicio,
//																			 matrizppvppi.matrizFRegPrestacion,
//                                                                             matrizppvppi.matrizFDigitacion,
// 													                         matrizppvppi.matrizOrigenAtPrestacion,
//																			 matrizppvppi.matrizTablaOrigen,
//													                         matrizppvppi.matrizCantidadComprometida,
//																			 matrizEdadPaciente,
//																			 matrizPreviNombre,
//																			 matrizConvenioNombre,
//																		     matrizNombrePrograma,
//																			 matrizNombreCompromiso,
//																			 matrizCodCompromiso) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
//											GetSQLValueString($diacama,"text"),
//											GetSQLValueString('I',"text"),
//											GetSQLValueString(0,"int"),
//											GetSQLValueString($numero_dias,"int"),
//											GetSQLValueString($row_rs_nombrediacama['preNombre'],"text"),
//											GetSQLValueString('P',"text"),
//											GetSQLValueString(0,"int"),
//											GetSQLValueString('',"text"),
//											GetSQLValueString($row_rs_prestacionMAI['preFacturacion'],"int"),
//											GetSQLValueString($row_rs_diacama['id_paciente'],"int"),
//											GetSQLValueString($row_rs_diacama['rut_paciente'],"int"),
//											GetSQLValueString($row_rs_diacama['nom_paciente'],"text"),
//											GetSQLValueString($row_rs_diacama['ficha_paciente'],"int"),
//											GetSQLValueString($row_rs_diacama['sexo_paciente'],"text"),
//											GetSQLValueString('1000-01-01',"date"),
//											GetSQLValueString($row_rs_diacama['prevision'],"int"),
//											GetSQLValueString(0,"int"),
//											GetSQLValueString($row_rs_diacama['cod_servicio'],"int"),
//											GetSQLValueString($row_rs_diacama['servicio'],"text"),
//											GetSQLValueString($row_rs_diacama['fecha_egreso'],"date"),
//											GetSQLValueString($fecha_actual,"date"),
//											GetSQLValueString(3,"int"),
//											GetSQLValueString('hospitalizaciones',"text"),
//					                        GetSQLValueString(0,"int"),
//											GetSQLValueString($row_rs_diacama['edad_paciente'],"int"),
//											GetSQLValueString($row_rs_diacama['prevision'],"text"),
//											GetSQLValueString('',"text"),
//											GetSQLValueString('',"text"),
//											GetSQLValueString('',"text"),
//											GetSQLValueString(0,"int"));												
//					$rs_insert_matriz = mysql_query($query_insert_matriz, $paciente) or die(mysql_error());
//					
//				} // fin prestacion PPI

			} // fin paciente no Auge
			
		} // fin beneficiario
	
	} while($row_rs_diacama = mysql_fetch_assoc($rs_diacama));	
	}
?>