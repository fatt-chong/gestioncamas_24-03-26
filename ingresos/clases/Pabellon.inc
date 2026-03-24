<? class Pabellon{
	
	function buscaIntervencion($link,$id_paciente,$fecha){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("pabellon",$link);
		
		$sql = "SELECT
				pabellon.cirugia.ciruCod,
				pabellon.cirugia.ciruHora,
				pabellon.cirugia.ciruFecha,
				pabellon.cirugia.ciruInter1Glosa,
				pabellon.medicospab.mpNombre,
				epicrisis.epimed_has_operacion.opNombre as ciruEpicrisis
				FROM
				pabellon.cirugia
				INNER JOIN pabellon.medicospab ON pabellon.cirugia.ciruCirujano1 = pabellon.medicospab.mpCod
				LEFT JOIN epicrisis.epimed_has_operacion ON pabellon.cirugia.ciruCod = epicrisis.epimed_has_operacion.opCod
				WHERE
				pabellon.cirugia.pacieCod = '$id_paciente' AND
				pabellon.cirugia.ciruFecha >= '$fecha' AND
				(pabellon.cirugia.ciruEstado = 'REALIZADA' OR
				pabellon.cirugia.ciruEstado = 'EN PROCESO')";
		
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link);
		return $query;
		}
	function codigoPabellones($link,$fecha){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("pabellon",$link);
				
		$sql = "SELECT
				DISTINCT pabCod
				FROM cirugia
				WHERE ciruFecha = '$fecha' AND pabCod <> ''
				ORDER BY
				pabCod ASC";
		
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link);
		return $query;		
	}
	
	function listaCirugia($link,$pabellon,$fecha){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("pabellon",$link);
		
		$sql = "SELECT
				pabellon.cirugia.ciruCod,
				pabellon.cirugia.ciruHora,
				pabellon.cirugia.ciruFecha,
				pabellon.cirugia.ciruEstado,
				pabellon.cirugia.ciruPacieRut,
				pabellon.cirugia.ciruPacieNombre,
				pabellon.cirugia.ciruPacieFicha,
				pabellon.cirugia.serviCod,
				pabellon.cirugia.pacieCod,
				pabellon.cirugia.ciruMotSuspencion,
				pabellon.cirugia.ciruHLlegada,
				pabellon.cirugia.ciruHAnest,
				pabellon.cirugia.ciruHICirugia,
				pabellon.cirugia.ciruHTCirugia,
				pabellon.cirugia.ciruObservacion,
				pabellon.cirugia.ciruNroSolic,
				pabellon.cirugia.ciruHSalida,
				pabellon.cirugia.pabCod,
				pabellon.cirugia.ciruMotSuspCod,
				pabellon.cirugia.ciruUrgencia,
				pabellon.cirugia.ciruCompServ,
				pabellon.cirugia.ciruInter1Glosa,
				pabellon.cirugia.ciruInter2Cod,
				pabellon.cirugia.ciruInter2Glosa,
				pabellon.cirugia.ciruInter3Cod,
				pabellon.cirugia.ciruInter3Glosa,
				pabellon.cirugia.ciruInter1Cod,
				pabellon.cirugia.interCod,
				pabellon.cirugia.interNombre,
				pabellon.cirugia.ciruServOrigCod,
				pabellon.cirugia.ciruServDestCod,
				pabellon.cirugia.ciruDiagPre,
				pabellon.cirugia.ciruDiagPos,
				pabellon.cirugia.ciruFechaDigit,
				pabellon.cirugia.ciruCirujano1,
				pabellon.cirugia.ciruCirujano2,
				pabellon.cirugia.ciruCirujano3,
				pabellon.cirugia.ciruAnestesista,
				pabellon.cirugia.ciruArsenalero,
				pabellon.cirugia.ciruPabellonero,
				pabellon.cirugia.ciruAuxAnestesista,
				pabellon.cirugia.ciruCCCiru1,
				pabellon.cirugia.ciruCCCiru2,
				pabellon.cirugia.ciruCCCiru3,
				pabellon.cirugia.ciruCCAnest,
				pabellon.cirugia.ciruTipo,
				pabellon.cirugia.ciruSecuencia,
				pabellon.cirugia.ciruFechaSol,
				pabellon.cirugia.ciruHoraSol,
				pabellon.cirugia.ciruEstadoSol,
				pabellon.cirugia.anestCod,
				pabellon.cirugia.anulaCod,
				pabellon.cirugia.ciruCintas,
				pabellon.cirugia.ciruValor,
				pabellon.cirugia.ciruTipoAtencion,
				pabellon.cirugia.ciruCtacteCod,
				pabellon.cirugia.ciruSala,
				pabellon.cirugia.ciruCama,
				pabellon.cirugia.ciruCancelado,
				pabellon.cirugia.ciruValorInter3,
				pabellon.cirugia.ciruValorInter2,
				pabellon.cirugia.ciruValorInter1,
				pabellon.cirugia.ciruProcAnestesia,
				pabellon.cirugia.cc1,
				pabellon.cirugia.cc2,
				pabellon.cirugia.cc3,
				pabellon.cirugia.ccanest,
				pabellon.cirugia.ciruMedicacionOper,
				pabellon.cirugia.ciruIndicacionesPostOper,
				pabellon.cirugia.ciruDescripOper,
				pabellon.cirugia.ciruTipoHerida,
				pabellon.cirugia.ciruOperacionSolic,
				pabellon.cirugia.ciruOperacionRealizada,
				pabellon.cirugia.ciruEntregaInformacion,
				pabellon.cirugia.ciruEstadoProtocolo,
				pabellon.cirugia.ciruMedicoSolicScanner,
				pabellon.cirugia.ciruFolioLE,
				pabellon.cirugia.ciruCierre,
				pabellon.cirugia.ciruServicioCirujano1,
				pabellon.cirugia.ciruCobroTotal,
				pabellon.cirugia.ciruCobroSaldo,
				pabellon.cirugia.ciruCobroCancelada,
				pabellon.cirugia.ciruHoraTermino,
				pabellon.cirugia.ciruSituacionEstado,
				pabellon.cirugia.ciruSituacionIngresoUrpaF,
				pabellon.cirugia.ciruSituacionIngresoUrpaH,
				pabellon.cirugia.ciruSituacionIngresoPabF,
				pabellon.cirugia.ciruSituacionIngresoPabH,
				pabellon.cirugia.ciruSituacionPreanestF,
				pabellon.cirugia.ciruSituacionPreanestH,
				pabellon.cirugia.ciruSituacionPausaF,
				pabellon.cirugia.ciruSituacionPausaH,
				pabellon.cirugia.ciruSituacionProtocoloF,
				pabellon.cirugia.ciruSituacionProtocoloH,
				pabellon.cirugia.ciruSituacionEgresoUrpaF,
				pabellon.cirugia.ciruSituacionEgresoUrpaH,
				pabellon.cirugia.ciruSituacionPostanestF,
				pabellon.cirugia.ciruSituacionPostanestH,
				pabellon.cirugia.ciruSituacionEgresoPabF,
				pabellon.cirugia.ciruSituacionEgresoPabH,
				pabellon.cirugia.ciruSituacionServiTraslado,
				pabellon.cirugia.ciruSituacionAdmisionF,
				pabellon.cirugia.ciruSituacionAdmisionH,
				pabellon.cirugia.ciruSituacionPyxisF,
				pabellon.cirugia.ciruSituacionPyxisH,
				tab1.medico as 'cirujano',
				tab2.medico as 'anestesista',
				acceso.servicio.nombre,
				pabellon.motivosuspencion.motsusGlosa
				FROM
				pabellon.cirugia
				INNER JOIN acceso.medico as tab1 ON pabellon.cirugia.ciruCirujano1 = tab1.id
				INNER JOIN acceso.medico as tab2 ON pabellon.cirugia.ciruAnestesista = tab2.id
				INNER JOIN acceso.servicio ON pabellon.cirugia.serviCod = acceso.servicio.idservicio
				LEFT JOIN pabellon.motivosuspencion ON pabellon.cirugia.ciruMotSuspencion = pabellon.motivosuspencion.motsusCod
				WHERE
				pabellon.cirugia.pabCod = '$pabellon' AND
				pabellon.cirugia.ciruFecha = '$fecha' AND
				pabellon.cirugia.ciruEstado <> 'ANULADA'
				ORDER BY
				pabellon.cirugia.ciruHLlegada ASC";
		//echo $sql;
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link);
		return $query;
	}
	
} ?>