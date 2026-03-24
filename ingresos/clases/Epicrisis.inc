<? class Epicrisis{
	
	function traslados($link){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("acceso",$link);
	
	$sql = "SELECT 
				idcentro,
				nombre
				FROM centro
				ORDER BY nombre ASC";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER CENTROS DE TRASLADOS<br>".mysql_error());
	return ($query);

	}
	
	function hogares($link,$idServicio){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	if(($idServicio == 7) or ($idServicio == 6)){
	$conTipo = " WHERE hogarTipo = 'P'";
		}else{
			$conTipo = " WHERE hogarTipo = 'A'";
			}		
	
	$sql = "SELECT * FROM hogares".$conTipo;
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." Error al seleccionar Hogares ".mysql_error());
	return ($query);
		}
		
	function educaciones($link,$tipo){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	switch($tipo){
		case '6':
			$conEduc = " WHERE educaTipo = 'N' or educaTipo = 'AN'";
		break;
		case '7':
			$conEduc = " WHERE educaTipo = 'A' or educaTipo = 'AN' or educaTipo = 'P' ";
		break;
		case '12':
			$conEduc = " WHERE educaTipo = 'PS'";
		break;
		case 'MA':
			$conEduc = " WHERE educaTipo = 'MA'";
		break;
		default:
			$conEduc = " WHERE educaTipo = 'A' or educaTipo = 'AN' ";
		break;
		}	
	$sql = "SELECT *
			FROM
			educapac".$conEduc;
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." ERROR AL SELECCIONAR EDUCACIONES ".mysql_error());
	return ($query);

	}
	
	function seleccionYeso($link){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT *
			FROM
			tipoyeso";
	mysql_query("SET NAMES utf8");		
	$query = mysql_query($sql,$link) or die($sql." ERROR AL SELECCIONAR YESO".mysql_error());
	return ($query);	
		}
	
	function educacionesSelect($link,$idEpicrisis){//,$idEduca
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT
			epienf_has_educapac.educaId,
			educapac.educaNom
			FROM
			epienf_has_educapac
			LEFT JOIN educapac ON epienf_has_educapac.educaId = educapac.educaId
			WHERE epienf_has_educapac.epienfId = $idEpicrisis ";//AND educaId = $idEduca
	
	mysql_query("SET NAMES utf8");				
	$query = mysql_query($sql,$link) or die("ERROR AL SELECCIONAR EDUCACIONES DEL educacionesSelect ". mysql_error());
	
	return ($query);	
	}
	
	function consejeriaSelect($link,$idEpicrisis){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT
			epimat_has_consejo.consejoId,
			consejerias.consejoDesc
			FROM
			epimat_has_consejo
			INNER JOIN consejerias ON epimat_has_consejo.consejoId = consejerias.consejoId
			WHERE
			epimat_has_consejo.epimatId = $idEpicrisis";
	
	mysql_query("SET NAMES utf8");				
	$query = mysql_query($sql,$link) or die("ERROR AL SELECCIONAR EDUCACIONES DEL consejeriaSelect ". mysql_error());
	return ($query);	
	}
	
	function educacionesSelectMat($link,$idEpicrisis){//,$idEduca
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT
			epimat_has_educa.educaId,
			educapac.educaNom
			FROM
			epimat_has_educa
			LEFT JOIN educapac ON epimat_has_educa.educaId = educapac.educaId
			WHERE epimat_has_educa.epimatId = $idEpicrisis ";//AND educaId = $idEduca
	
	mysql_query("SET NAMES utf8");				
	$query = mysql_query($sql,$link) or die("ERROR AL SELECCIONAR EDUCACIONES DEL educacionesSelectMat ". mysql_error());
	
	return ($query);	
	}
	
	function buscaRayos($link, $id_paciente, $fecha_hospitaliza){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("rayos",$link);
	
	$sql = "SELECT DISTINCT
				rayos.examen.EXAcorrelativo,
				rayos.atencion.ATEfecha,
				paciente.prestacion.preNombre,
				rayos.examen.EXAinforme_estado,
				rayos.examen.EXTIcod,
				serv.nombre AS servicio,
				esp.nombre AS especialidad
				FROM rayos.atencion
				Left Join rayos.examen ON rayos.examen.ATEcorrelativo = rayos.atencion.ATEcorrelativo
				Left Join paciente.prestacion ON paciente.prestacion.preCod = rayos.examen.PREcod
				Inner Join acceso.servicio AS serv ON rayos.atencion.ATEservicio = serv.idservicio
				Inner Join acceso.servicio AS esp ON rayos.atencion.ATEespecialidad = esp.idservicio
				WHERE rayos.atencion.PACid = $id_paciente and ATEfecha >= '$fecha_hospitaliza'
				order by ATEfecha DESC";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die("Error al seleccionar examenes de rayos ". mysql_error());
	return ($query); 
	}
//OBTIENE INFORMACION DE LOS EXAMENES DE AP
	function buscaAnatomia($link,$id_paciente,$fecha_hospitaliza){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("anatomia",$link);
	
	$sql = "SELECT
			anatomia.controlanatomiadetalle.regAOrganos,
			anatomia.controlanatomiadetalle.preCod2,
			paciente.prestacion.preCod,
			paciente.prestacion.preNombre,
			paciente.organos.orgdescripcion
			FROM
			anatomia.controlanatomiadetalle
			INNER JOIN anatomia.controlanatomia ON anatomia.controlanatomia.regAId = anatomia.controlanatomiadetalle.regAId
			INNER JOIN paciente.prestacion ON anatomia.controlanatomiadetalle.preCod2 = paciente.prestacion.preCod
			INNER JOIN paciente.organos ON anatomia.controlanatomiadetalle.regAOrganos = paciente.organos.orgId
			WHERE
			anatomia.controlanatomia.regAtipoExamen = 'B' AND
			anatomia.controlanatomia.pacId = $id_paciente AND
			anatomia.controlanatomia.regAFechaRecepcion >= '$fecha_hospitaliza'";
				
	$query = mysql_query($sql) or die ("ERROR AL SELECCIONAR EXAMENES DE ANATOMIA ".mysql_error());
	return ($query); 
	}
	
	function buscaEpicrisis($link,$ctaCte){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT * 
			FROM epicrisisenf
			WHERE epienfctaCte = '$ctaCte'";
	
	mysql_query("SET NAMES utf8");	
	$query = mysql_query($sql) or die($sql." Error al seleccionar la epicrisis ".mysql_error());
	$arrayEpicrisis = mysql_fetch_assoc($query);
	return($arrayEpicrisis);
		}
		
	function insertaEpicrisisEnfermera($link,$fechaIng,$fechaEgr,$difDias,$fechaNac,$id_paciente,$cod_prev,$fonoCont,$diagnosticos,$epiRut,$herida,$pieDiab,$multiRes,$escaras,$tipoYeso,$barthel,$indicaEpicrisis,$id_cama,$destinoPaciente,$trasladoPaciente,$idUsuario,$ctaCte,$condEgreso,$idServicio,$enfermeras_id,$enfermeras,$hospDom,$hogarPaciente,$cierra,$responsable,$rutResp,$nomResp,$pesoNac,$pesoAlta,$otroResponsable,$reingreso,$derivado){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	if($barthel != ''){
		$sqlBarthel = ",epienfBarthel = '$barthel',";
		$sqlBarthel2 = ", $barthel,";
		}else{
			$sqlBarthel = ",epienfBarthel = NULL,";
			$sqlBarthel2 = ", NULL,";
			}
		
		$sql = "INSERT INTO 
					epicrisisEnf
					(epienfFechaIng,
					epienfFechaEgr,
					epienfDias,
					epienfEdad,
					epienfPacId,
					epienfPrevision,
					epienfFono,
					epienfCie10,
					epienfRut,
					epienfHerida,
					epienfPie,
					epienfMr,
					epienfEscara,
					epienfYeso,
					epienfBarthel,
					epienfIndica,
					epienfIdCama,
					epienfDestino,
					epienfTraslado,
					epienfUsuario,
					epienfCtacte,
					epienfCond,
					epienfServicio,
					epienfEnfermeraId,
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
					'$herida',
					'$pieDiab',
					'$multiRes',
					'$escaras',
					'$tipoYeso'
					".$sqlBarthel2."
					'$indicaEpicrisis',
					'$id_cama',
					'$destinoPaciente',
					'$trasladoPaciente',
					'$idUsuario',
					'$ctaCte',
					'$condEgreso',
					'$idServicio',
					'$enfermera_id',
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
					'$reingreso',
					'$derivado')";
					
		mysql_query("SET NAMES utf8");								
		$query = mysql_query($sql) or die($sql. " No se logro realizar el Insert de la epicrisis ". mysql_error());
		$resQuery = mysql_affected_rows();
		$idEpicrisis = mysql_insert_id();
		return($idEpicrisis);
		}
	
	function actualizaEpicrisisEnfermera($link,$fechaIng,$fechaEgr,$difDias,$fechaNac,$id_paciente,$cod_prev,$fonoCont,$diagnosticos,$epiRut,$herida,$pieDiab,$multiRes,$escaras,$tipoYeso,$barthel,$indicaEpicrisis,$id_cama,$destinoPaciente,$trasladoPaciente,$idUsuario,$ctaCte,$condEgreso,$idServicio,$enfermeras_id,$enfermeras,$hospDom,$hogarPaciente,$cierra,$responsable,$rutResp,$nomResp,$pesoNac,$pesoAlta,$otroResponsable,$idEpicrisis,$reIng,$derivadoPaciente){
		
		if($barthel != ''){
		$sqlBarthel = ",epienfBarthel = '$barthel',";
		$sqlBarthel2 = ", $barthel,";
		}else{
			$sqlBarthel = ",epienfBarthel = NULL,";
			$sqlBarthel2 = ", NULL,";
			}
		
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
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
						epienfHerida = '$herida',
						epienfPie = '$pieDiab',
						epienfMr = '$multiRes',
						epienfEscara = '$escaras',
						epienfYeso = '$tipoYeso'
						".$sqlBarthel."
						epienfIndica = '$indicaEpicrisis',
						epienfIdCama = $id_cama,
						epienfDestino = '$destinoPaciente',
						epienfTraslado = '$trasladoPaciente',
						epienfCtacte = $ctaCte,
						epienfCond = '$condEgreso',
						epienfServicio = $idServicio,
						epienfEnfermeraId = '$enfermera_id',
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
		mysql_query("SET NAMES utf8");
		$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());
		$resQuery = mysql_affected_rows();
		return($resQuery);
		}
		
	function insertaEducaciones($link,$idEpicrisis,$educaciones){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sqlBorra = "DELETE FROM epienf_has_educapac WHERE epienfId = '$idEpicrisis'";
		$queryBorra = mysql_query($sqlBorra) or die($idEpicrisis." Error al eliminar educaciones de enfermeria ".mysql_error());
		
		$educa_array = explode(",",$educaciones);
			$cont=0;
			foreach($educa_array as $valor){
				
				if($valor){
					$sqlInsEdu = "INSERT INTO 
									epienf_has_educapac
									(epienfId,
									educaId)
									VALUES
									($idEpicrisis,
									$valor)";
					mysql_query("SET NAMES utf8");
					$queryInsEdu = mysql_query($sqlInsEdu) or die($sqlInsEdu." Error al insertar tipo de educaciones ".mysql_error());
					$cont++;
				}
			}
		return($valor);
	}
	
	function logepicrisis($link,$idEpicrisis,$id_paciente,$ctaCte,$idUsuario){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$fechaHoy = date("Y-m-d H:i:s");
		
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
			mysql_query("SET NAMES utf8");
			$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());
		}
	
	function datosEpicrisis($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);

		$sql = "SELECT
				paciente.paciente.rut,
				paciente.paciente.nombres,
				paciente.paciente.apellidopat,
				paciente.paciente.apellidomat,
				paciente.paciente.fechanac,
				paciente.paciente.sexo,
				paciente.paciente.direccion,
				paciente.paciente.nroficha,
				epicrisis.epicrisisenf.epienfId,
				epicrisis.epicrisisenf.epienfFechaIng,
				epicrisis.epicrisisenf.epienfFechaEgr,
				epicrisis.epicrisisenf.epienfRut,
				epicrisis.epicrisisenf.epienfEdad,
				epicrisis.epicrisisenf.epienfPacId,
				epicrisis.epicrisisenf.epienfFono,
				epicrisis.epicrisisenf.epienfPrevision,
				epicrisis.epicrisisenf.epienfCie10,
				epicrisis.epicrisisenf.epienfHerida,
				epicrisis.epicrisisenf.epienfPie,
				epicrisis.epicrisisenf.epienfMr,
				epicrisis.epicrisisenf.epienfEscara,
				epicrisis.epicrisisenf.epienfYeso,
				epicrisis.epicrisisenf.epienfBarthel,
				epicrisis.epicrisisenf.epienfIndica,
				epicrisis.epicrisisenf.epienfIdCama,
				epicrisis.epicrisisenf.epienfDestino,
				epicrisis.epicrisisenf.epienfTraslado,
				epicrisis.epicrisisenf.epienfUsuario,
				epicrisis.epicrisisenf.epienfCtacte,
				epicrisis.epicrisisenf.epienfCond,
				epicrisis.epicrisisenf.epienfServicio,
				epicrisis.epicrisisenf.epienfDias,
				epicrisis.epicrisisenf.epienfEnfermeraId,
				epicrisis.epicrisisenf.epienfEnfermera,
				epicrisis.epicrisisenf.epienfHogar,
				epicrisis.epicrisisenf.epienfHosdom,
				epicrisis.epicrisisenf.epienfEstado,
				epicrisis.epicrisisenf.epienfResp,
				epicrisis.epicrisisenf.epienfRespRut,
				epicrisis.epicrisisenf.epienfRespNom,
				epicrisis.epicrisisenf.epienfPesoNac,
				epicrisis.epicrisisenf.epienfPesoAlta,
				epicrisis.epicrisisenf.epienfRespOtro,
				epicrisis.epicrisisenf.epienfReingreso,
				epicrisis.epicrisisenf.epienfDerivado
				FROM
				epicrisis.epicrisisenf
				INNER JOIN paciente.paciente ON epicrisis.epicrisisenf.epienfPacId = paciente.paciente.id
				WHERE
				epicrisis.epicrisisenf.epienfId = '$idEpicrisis'";
		
		mysql_query("SET NAMES utf8");								
		$query = mysql_query($sql) or die($sql. " ERROR AL SELECCIONAR DATOS DE EPICRISIS ". mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
	
	function datosEpicrisisMedica($link,$idEpicrisis){
		$sql = "SELECT
				paciente.paciente.rut,
				paciente.paciente.nombres,
				paciente.paciente.apellidopat,
				paciente.paciente.apellidomat,
				paciente.paciente.fechanac,
				paciente.paciente.sexo,
				paciente.paciente.direccion,
				paciente.paciente.nroficha,
				epicrisis.epicrisismedica.epimedId,
				epicrisis.epicrisismedica.epimedFechaIng,
				epicrisis.epicrisismedica.epimedFechaEgr,
				epicrisis.epicrisismedica.epimedEdad,
				epicrisis.epicrisismedica.epimedPacId,
				epicrisis.epicrisismedica.epimedFono,
				epicrisis.epicrisismedica.epimedPrevision,
				epicrisis.epicrisismedica.epimedFund,
				epicrisis.epicrisismedica.epimedDiag,
				epicrisis.epicrisismedica.epimedIndica,
				epicrisis.epicrisismedica.epimedUsuario,
				epicrisis.epicrisismedica.epimedCtacte,
				epicrisis.epicrisismedica.epimedCond,
				epicrisis.epicrisismedica.epimedDestino,
				epicrisis.epicrisismedica.epimedDestinodet2,
				epicrisis.epicrisismedica.epimedDestinodet,
				epicrisis.epicrisismedica.epimedServicio,
				epicrisis.epicrisismedica.epimedDias,
				epicrisis.epicrisismedica.epimedIdMedico,
				epicrisis.epicrisismedica.epimedMedico,
				epicrisis.epicrisismedica.idFav,
				epicrisis.epicrisismedica.epimedGes,
				epicrisis.epicrisismedica.epimedGesNom,
				epicrisis.epicrisismedica.epimedPesoIn,
				epicrisis.epicrisismedica.epimedPesoEg,
				epicrisis.epicrisismedica.epimedNutricion
				FROM
				epicrisis.epicrisismedica
				INNER JOIN paciente.paciente ON epicrisis.epicrisismedica.epimedPacId = paciente.paciente.id
				WHERE
				epicrisis.epicrisismedica.epimedId = $idEpicrisis";
				
		mysql_query("SET NAMES utf8");								
		$query = mysql_query($sql) or die($sql. " ERROR AL SELECCIONAR DATOS DE EPICRISIS ". mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
		
	function datosEpicrisisMatrona($link,$idEpicrisis){
		$sql = "SELECT
				paciente.paciente.rut,
				paciente.paciente.nombres,
				paciente.paciente.apellidopat,
				paciente.paciente.apellidomat,
				paciente.paciente.fechanac,
				paciente.paciente.sexo,
				paciente.paciente.direccion,
				paciente.paciente.nroficha,
				epicrisis.epicrisismatrona.epimatId,
				epicrisis.epicrisismatrona.epimatEstado,
				epicrisis.epicrisismatrona.epimatFechaIng,
				epicrisis.epicrisismatrona.epimatFechaEgr,
				epicrisis.epicrisismatrona.epimatDestino,
				epicrisis.epicrisismatrona.epimatRut,
				epicrisis.epicrisismatrona.epimatEdad,
				epicrisis.epicrisismatrona.epimatPacId,
				epicrisis.epicrisismatrona.epimatFono,
				epicrisis.epicrisismatrona.epimatPrevision,
				epicrisis.epicrisismatrona.epimatIndica,
				epicrisis.epicrisismatrona.epimatExamen,
				epicrisis.epicrisismatrona.epimatOtroexam,
				epicrisis.epicrisismatrona.epimatPend,
				epicrisis.epicrisismatrona.epimatPendexam,
				epicrisis.epicrisismatrona.epimatIdCama,
				epicrisis.epicrisismatrona.epimatUsuario,
				epicrisis.epicrisismatrona.epimatCtacte,
				epicrisis.epicrisismatrona.epimatServicio,
				epicrisis.epicrisismatrona.epimatDias,
				epicrisis.epicrisismatrona.epimatDiagn,
				epicrisis.epicrisismatrona.epimatInterv,
				epicrisis.epicrisismatrona.epimatMatrona,
				epicrisis.epicrisismatrona.epimatTipoParto,
				epicrisis.epicrisismatrona.epimatEpisio,
				epicrisis.epicrisismatrona.epimatDesg,
				epicrisis.epicrisismatrona.epimatEstadorn,
				epicrisis.epicrisismatrona.epimatHosprn,
				epicrisis.epicrisismatrona.epimatMalrn,
				epicrisis.epicrisismatrona.epimatMalrncausa,
				epicrisis.epicrisismatrona.epimatInfec,
				epicrisis.epicrisismatrona.epimatMulti,
				epicrisis.epicrisismatrona.epimatVdrl,
				epicrisis.epicrisismatrona.epimatHema,
				epicrisis.epicrisismatrona.epimatUro,
				epicrisis.epicrisismatrona.epimatEndo,
				epicrisis.epicrisismatrona.epimatLoqui,
				epicrisis.epicrisismatrona.epimatResp,
				epicrisis.epicrisismatrona.epimatRespNom,
				epicrisis.epicrisismatrona.epimatIdparto,
				epicrisis.epicrisismatrona.epimatBarthelIngreso
				FROM
				paciente.paciente
				INNER JOIN epicrisis.epicrisismatrona ON epicrisis.epicrisismatrona.epimatPacId = paciente.paciente.id
				WHERE epimatId = $idEpicrisis" ;
				
		mysql_query("SET NAMES utf8");								
		$query = mysql_query($sql) or die($sql. " ERROR AL SELECCIONAR DATOS DE EPICRISIS ". mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
		
	function nomDestino($link,$destino){
		switch ($destino){
			case 1:
				$nombreDestino = "Domicilio";
			break;
			case 2:
				$nombreDestino = "Traslado";
			break;
			case 3:
				$nombreDestino = "CONIN";
			break;
			case 4:
				$nombreDestino = "Otros";
			break;
			case 5:
				$nombreDestino = "Anatomia Patologica";
			break;
			case 6:
				$nombreDestino = "Servicio Medico Legal";
			break;
			}
		return ($nombreDestino);
		}
		
	function nomTraslado($link,$traslado){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("acceso",$link);
		
		$sql = "SELECT 
				idcentro,
				nombre
				FROM centro
				WHERE
				centro.idcentro = $traslado";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER CENTROS DE TRASLADOS<br>".mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
	function nomHogares($link,$hogar){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT
				hogares.hogarId,
				hogares.hogarNom
				FROM hogares
				WHERE hogarId = $hogar";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER CENTROS DE TRASLADOS<br>".mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
	function nomYeso($link,$idyeso){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT 
				tipoyeso.yesoId,
				tipoyeso.yesoNombre
				FROM
				tipoyeso
				WHERE yesoId = $idyeso";
				
		mysql_query("SET NAMES utf8");		
		$query = mysql_query($sql,$link) or die($sql." ERROR AL SELECCIONAR YESO".mysql_error());
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}
		
	//BUSCA LOS SUBPROGRAMAS (GES)
	function gesPrograma($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("acceso",$link);
		
		$sql = "SELECT *
				FROM ppvsubprogramas
				WHERE
				ppvsubprogramas.subprogPediatrica = 1
				ORDER BY
				ppvsubprogramas.subprogNombre ASC";
		mysql_query("SET NAMES utf8");				
		$query = mysql_query($sql) or die("ERROR AL SELECCIONAR SUBPROGRAMAS ".mysql_error());
		return($query);
	}
	
	function queGes($link,$idGes){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("acceso",$link);
		$sql= "SELECT *
				FROM ppvsubprogramas
				WHERE
				ppvsubprogramas.subprogPediatrica = 1 
				AND subprogCod = $idGes
				ORDER BY
				ppvsubprogramas.subprogNombre ASC";
		mysql_query("SET NAMES utf8");				
		$query = mysql_query($sql) or die("ERROR AL SELECCIONAR SUBPROGRAMAS ".mysql_error());
		$nomGes = mysql_fetch_assoc($query);
		return($nomGes['subprogNombre']);
		}
	
	function controles($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT * FROM control ORDER BY nom_control ASC";
		mysql_query("SET NAMES utf8");		
		$query = mysql_query($sql) or die("ERROR AL CARGAR LISTA DE CONTROLES". mysql_error());
		return($query);
		}
		
	function buscaControles($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT
				epimed_has_control.controlFecha,
				epimed_has_control.controlTipo
				FROM
				epimed_has_control
				WHERE
				epimed_has_control.epimedId = $idEpicrisis
				ORDER BY
				epimed_has_control.controlFecha ASC";
		
		mysql_query("SET NAMES utf8");	
		$query = mysql_query($sql) or die ($sql."Error al buscar controles ");
		return($query);
		}
		
	function controlesEpicrisis($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT
				control.id_control,
				control.nom_control,
				epimed_has_control.controlFecha
				FROM
				control
				INNER JOIN epimed_has_control ON control.id_control = epimed_has_control.controlTipo
				WHERE
				epimed_has_control.epimedId = '$idEpicrisis'";
		
		mysql_query("SET NAMES utf8");			
		$query = mysql_query($sql) or die ("ERROR AL SELECCIONAR CONTROLES ".mysql_error());
		return($query);
		}
		
	function buscaEpicrisisMedica($link,$ctaCte){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT * 
			FROM epicrisismedica
			WHERE epimedctaCte = '$ctaCte'";
	
	mysql_query("SET NAMES utf8");	
	$query = mysql_query($sql) or die($sql." Error al seleccionar la epicrisis ".mysql_error());
	$arrayEpicrisis = mysql_fetch_assoc($query);
	return($arrayEpicrisis);
		}
	
	function listaFavorito($link,$usuario){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT 
			idFav,
			nombreFav 
			FROM favoritos
			WHERE
			favoritos.idMedico = '$usuario'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql) or die ($sql. " ERROR AL SELECCIONAR FAVORITOS ".mysql_error());
	return($query);
	}
	
	function buscaFavorito($link,$idFav){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sql = "SELECT * 
			FROM favoritos
			WHERE
			favoritos.idFav = '$idFav'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql) or die ($sql. " ERROR AL SELECCIONAR FAVORITOS ".mysql_error());
	
	$RSdatos = mysql_fetch_assoc($query);
    $datos = array("id"=>$RSdatos['idFav'],"descripcion"=>$RSdatos['descFav'],"nombre"=>$RSdatos['nombreFav'],"medico"=>$RSdatos['idMedico']);
   
  	return ($datos);
	}
	
	function insertaEpicrisisMedica($link,$fechaIng,$fechaEgr,$epiRut,$fechaNac,$id_paciente,$fonoCont,$cod_prev,$diagnosticos,$fundamentos,$id_cama,$idUsuario,$ctaCte,$condEgreso,$idServicio,$difDias,$idmedico,$medico,$cierra,$idFavorito,$opcionGes,$tiposGes,$pesoIngreso,$pesoEgreso,$tipoNutri,$destinoPaciente,$trasladoPaciente,$hogarPaciente,$indicaEpicrisis,$controlEspecialidad){
	
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
		$sql = "INSERT INTO epicrisismedica
				(epimedFechaIng,
				epimedFechaEgr,
				epimedRut,
				epimedEdad,
				epimedPacId,
				epimedFono,
				epimedPrevision,
				epimedDiag,
				epimedFund,
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
				idFav,
				epimedGes,
				epimedGesNom,
				epimedPesoIn,
				epimedPesoEg,
				epimedNutricion,
				epimedDestino,
				epimedDestinodet,
				epimedDestinodet2,
				epimedControlEspecialista
				)
				VALUES
				('$fechaIng',
				'$fechaEgr',
				'$epiRut',
				'$fechaNac',
				'$id_paciente',
				'$fonoCont',
				'$cod_prev',
				'$diagnosticos',
				'$fundamentos',
				'$indicaEpicrisis',
				'$id_cama',
				'$idUsuario',
				$ctaCte,
				'$condEgreso',
				'$idServicio',
				$difDias,
				'$idmedico',
				'$medico',
				'$cierra',
				'$idFavorito',
				'$opcionGes',
				'$tiposGes',
				'$pesoIngreso',
				'$pesoEgreso',
				'$tipoNutri',
				'$destinoPaciente',
				'$trasladoPaciente',
				'$hogarPaciente',
				'$controlEspecialidad'
				)";
	mysql_query("SET NAMES utf8");								
	$query = mysql_query($sql) or die($sql. " No se logro realizar el Insert de la epicrisis medica ". mysql_error());
	$idEpicrisis = mysql_insert_id();
	return ($idEpicrisis);
		}
		
	function insertaControles($link,$idEpicrisis,$control,$fechacontrol){
	
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);

	require_once("Util.inc");
	$objUtil = new Util;
	
	$sqlBorraControles = "DELETE FROM epimed_has_control WHERE epimedId = $idEpicrisis ";
	$queryBorraControles = mysql_query($sqlBorraControles) or die("Error al eliminar controles");
	
	$a=0;
		for($i=1;$i<=4;$i++){
		$fechaPrueba = $fechacontrol[$i];
			if($fechaPrueba <> ''){
	
				$controlFecha =  $objUtil->fechaInvertida($fechaPrueba);
				
				$sqlInsControl = "INSERT INTO 
								epimed_has_control
								(epimedId,
								controlFecha,
								controlTipo)
								VALUES
								($idEpicrisis,
								'$controlFecha',
								'$control[$i]')";
				mysql_query("SET NAMES utf8");				
				$queryInsControl = mysql_query($sqlInsControl) or die($sqlInsControl." ERROR AL INSERTAR CONTROLES ".mysql_error());
			$a++;
			}
		}
	return($a);		

	}
	
	function actualizaEpicrisisMedica($link,$idEpicrisis,$fechaIng,$fechaEgr,$epiRut,$fechaNac,$id_paciente,$fonoCont,$cod_prev,$diagnosticos,$fundamentos,$id_cama,$idUsuario,$ctaCte,$condEgreso,$idServicio,$difDias,$idmedico,$medico,$cierra,$idFavorito,$opcionGes,$tiposGes,$pesoIngreso,$pesoEgreso,$tipoNutri,$destinoPaciente,$trasladoPaciente,$hogarPaciente,$indicaEpicrisis,$controlEspecialidad){
	
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
		
		$sql = "UPDATE epicrisismedica 
				SET epimedFechaIng = '$fechaIng',
				epimedFechaEgr = '$fechaEgr',
				epimedRut = '$epiRut',
				epimedEdad = '$fechaNac',
				epimedPacId = '$id_paciente',
				epimedFono = '$fonoCont',
				epimedPrevision = '$cod_prev',
				epimedDiag = '$diagnosticos',
				epimedFund = '$fundamentos',
				epimedIndica = '$indicaEpicrisis',
				epimedCama = '$id_cama',
				epimedUsuario = '$idUsuario',
				epimedCtacte = $ctaCte,
				epimedCond = '$condEgreso',
				epimedServicio = '$idServicio',
				epimedDias = $difDias,
				epimedIdMedico = '$idmedico',
				epimedMedico = '$medico',
				epimedEstado = '$cierra',
				idFav = '$idFavorito',
				epimedGes = '$opcionGes',
				epimedGesNom = '$tiposGes',
				epimedPesoIn = '$pesoIngreso',
				epimedPesoEg = '$pesoEgreso',
				epimedNutricion = '$tipoNutri',
				epimedDestino = '$destinoPaciente',
				epimedDestinodet = '$trasladoPaciente',
				epimedDestinodet2 = '$hogarPaciente',
				epimedControlEspecialista = '$controlEspecialidad'
				WHERE epimedId = $idEpicrisis";
		
	mysql_query("SET NAMES utf8");								
	$query = mysql_query($sql) or die($sql. " No se logro realizar el UPDATE de la epicrisis medica ". mysql_error());
	$resQuery = mysql_affected_rows();
	return ($resQuery);
		
		}
		
	function guardaEpiOperacion($link,$operacion,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epimed_has_operacion WHERE epimedId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar operaciones");

		if(count($operacion)>0){
			$i = 0;
			$cod_opera = (array_keys($operacion));
			
				foreach($operacion as $valor){
					$opCodigo = $cod_opera[$i];
						$sqlInsOp = "INSERT INTO 
										epimed_has_operacion
										(epimedId,
										opNombre,
										opCod)
										VALUES
										($idEpicrisis,
										'$valor',
										$opCodigo)";
						mysql_query("SET NAMES utf8");
						$queryInsOp = mysql_query($sqlInsOp) or die($sqlInsOp." Error al insertar Operaciones".mysql_error());			
					$i++;
					}
			}
		}
		
	function actualizaFav($link,$detalleEpi,$listaFavoritos){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
	
		$sql = "UPDATE favoritos 
				SET 
				descFav = '$detalleEpi' 
				WHERE (idFav = '$listaFavoritos')";
		$query = mysql_query($sql) or die($sql." ERROR AL ACTUALIZAR FAVORITO");
		$resQuery = mysql_affected_rows();
		return ($resQuery);
		}
		
	function insertaFav($link,$nombreFav,$indicaEpicrisis,$idUsuario){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
	
		$sql = "INSERT INTO favoritos
				(descFav,
				nombreFav,
				idMedico)
				VALUES 
				('$indicaEpicrisis',
				'$nombreFav',
				'$idUsuario')";
		$query = mysql_query($sql) or die($sql." ERROR AL INSERTAR FAVORITO");
		$idFavorito = mysql_insert_id();
		return ($idFavorito);
		}
		
	function clasNutricional($epiNutri){
		switch($epiNutri){
			case '1':
				$nutriPac = "Eutrofico";
			break;
			case '2':
				$nutriPac = "Obeso";
			break;
			case '3':
				$nutriPac = "Riesgo";
			break;
			case '4':
				$nutriPac = "Desnutrido";
			break;
			}
		return ($nutriPac);
		}
		
	function buscaepicrisisMatrona($link,$ctacte){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
		$sql = "SELECT
				epicrisismatrona.epimatId,
				epicrisismatrona.epimatFechaIng,
				epicrisismatrona.epimatFechaEgr,
				epicrisismatrona.epimatDestino,
				epicrisismatrona.epimatRut,
				epicrisismatrona.epimatEdad,
				epicrisismatrona.epimatFono,
				epicrisismatrona.epimatPrevision,
				epicrisismatrona.epimatIndica,
				epicrisismatrona.epimatExamen,
				epicrisismatrona.epimatOtroexam,
				epicrisismatrona.epimatPend,
				epicrisismatrona.epimatPendexam,
				epicrisismatrona.epimatCtacte,
				epicrisismatrona.epimatServicio,
				epicrisismatrona.epimatDias,
				epicrisismatrona.epimatDiagn,
				epicrisismatrona.epimatInterv,
				epicrisismatrona.epimatMatrona,
				epicrisismatrona.epimatTipoParto,
				epicrisismatrona.epimatEpisio,
				epicrisismatrona.epimatDesg,
				epicrisismatrona.epimatEstadorn,
				epicrisismatrona.epimatHosprn,
				epicrisismatrona.epimatMalrn,
				epicrisismatrona.epimatMalrncausa,
				epicrisismatrona.epimatInfec,
				epicrisismatrona.epimatMulti,
				epicrisismatrona.epimatVdrl,
				epicrisismatrona.epimatHema,
				epicrisismatrona.epimatUro,
				epicrisismatrona.epimatEndo,
				epicrisismatrona.epimatLoqui,
				epicrisismatrona.epimatResp,
				epicrisismatrona.epimatRespNom,
				epicrisismatrona.epimatIdparto,
				epicrisismatrona.epimatBarthelIngreso
				FROM
				epicrisismatrona
				WHERE
				epicrisismatrona.epimatCtacte = $ctacte
				";
		mysql_query("SET NAMES utf8");	
		$query = mysql_query($sql) or die($sql." Error al seleccionar la epicrisis de matronas".mysql_error());
		$arrayEpicrisis = mysql_fetch_assoc($query);
		return($arrayEpicrisis);
		}
		
	function consejeriaMatrona($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT 
				consejoId,
				consejoDesc
				FROM
				consejerias";
		mysql_query("SET NAMES utf8");	
		$query = mysql_query($sql) or die($sql." Error al seleccionar la epicrisis de matronas".mysql_error());
		return($query);
		}
		
	function insertaEpicrisisMatrona($link,$fechaIng,$fechaEgr,$destinoPaciente,$rutPaciente,$fechaNac,$id_paciente,$fonoCont,$cod_prev,$detalleEpi,$otroExamen,$examenes,$pendExamen,$examenPend,$id_cama,$idUsuario,$ctaCte,$idServicio,$difDias,$matronaDiag,$matronaInter,$matronas,$tipoParto,$episio,$desgarro,$estadoRN,$hospita,$malforma,$detalleMalfoma,$infeccion,$multires,$vdrl,$hemato,$urocu,$endocer,$loquio,$responsable,$nomResp,$idParto,$barthel){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "INSERT INTO epicrisismatrona
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
								epimatIdparto,
								epimatBarthelIngreso)
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
								'$idParto',
								'$barthel'
								)";
								
		mysql_query("SET NAMES utf8");	
		$query = mysql_query($sql) or die($sql." Error al insertar la epicrisis de matronas".mysql_error());
		$idEpicrisis = mysql_insert_id();

		return($idEpicrisis);
		}
	
	function actualizaEpicrisisMatrona($link,$fechaIng,$fechaEgr,$cierra,$destinoPaciente,$rutPaciente,$fechaNac,$id_paciente,$fonoCont,$cod_prev,$detalleEpi,$otroExamen,$examenes,$pendExamen,$examenPend,$id_cama,$idUsuario,$ctaCte,$idServicio,$difDias,$matronaDiag,$matronaInter,$matronas,$tipoParto,$episio,$desgarro,$estadoRN,$hospita,$malforma,$detalleMalfoma,$infeccion,$multires,$vdrl,$hemato,$urocu,$endocer,$loquio,$responsable,$nomResp,$idParto,$idEpicrisis,$barthel){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "UPDATE epicrisismatrona 
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
				epimatIdparto = '$idParto',
				epimatBarthelIngreso = '$barthel'	
				WHERE epimatId = $idEpicrisis";

		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." Error al actualizar la epicrisis de matronas".mysql_error());
		return $sql;	
		}
		
	function insertaEducacionesMatrona($link,$idEpicrisis,$educaciones){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sqlBorra = "DELETE FROM epimat_has_educa WHERE epimatId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		
		$educa_array = explode(",",$educaciones);
			$cont=0;
			foreach($educa_array as $valor){
				
				if($valor){
					$sqlInsEdu = "INSERT INTO 
									epimat_has_educa
									(epimatId,
									educaId)
									VALUES
									($idEpicrisis,
									$valor)";
					mysql_query("SET NAMES utf8");
					$queryInsEdu = mysql_query($sqlInsEdu) or die($sqlInsEdu." Error al insertar tipo de educaciones ".mysql_error());
					$cont++;
				}
			}
	}
	
	function insertaConsejoMatrona($link,$idEpicrisis,$consejos){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sqlBorra = "DELETE FROM epimat_has_consejo WHERE epimatId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		
		$consejo_array = explode(",",$consejos);
			$cont=0;
			foreach($consejo_array as $valor){
				
				if($valor){
					$sql = "INSERT INTO 
									epimat_has_consejo
									(epimatId,
									consejoId)
									VALUES
									($idEpicrisis,
									$valor)";
					mysql_query("SET NAMES utf8");
					$query = mysql_query($sql) or die($sql." Error al insertar tipo de consejos ".mysql_error());
					$cont++;
				}
			}
		}
		
	function autocuidados($link){		
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT *
				FROM
				autocuidado";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
	}
	
	function autocuidadoSelect($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT
				epienf_has_autocuidado.epienfId,
				epienf_has_autocuidado.cuidadoId,
				epienf_has_autocuidado.cuidadoValor,
				epienf_has_autocuidado.cuidadoTipo,
				autocuidado.cuidadoNom
				FROM
				epienf_has_autocuidado
				LEFT JOIN autocuidado ON epienf_has_autocuidado.cuidadoId = autocuidado.cuidadoId
				WHERE epienf_has_autocuidado.epienfId = $idEpicrisis";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}
	
	function autocuidadoDistinto($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT DISTINCT autocuidado.cuidadoNom,
				(SELECT epienf_has_autocuidado.cuidadoValor
				FROM
				epienf_has_autocuidado
				WHERE epienf_has_autocuidado.epienfId = $idEpicrisis AND epienf_has_autocuidado.cuidadoTipo = 'I' and epienf_has_autocuidado.cuidadoId=autocuidado.cuidadoId) as IngresoCuidado,
				(SELECT epienf_has_autocuidado.cuidadoValor
				FROM
				epienf_has_autocuidado
				WHERE epienf_has_autocuidado.epienfId = $idEpicrisis AND cuidadoTipo = 'A' and epienf_has_autocuidado.cuidadoId=autocuidado.cuidadoId) as AltaCuidado
				from autocuidado
				INNER JOIN epienf_has_autocuidado ON epienf_has_autocuidado.cuidadoId = autocuidado.cuidadoId
				WHERE epienf_has_autocuidado.epienfId = $idEpicrisis";

		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}	
		
	function planificacion($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT *
				FROM
				planificacion";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}
		
	function planificacionSelect($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT
				epienf_has_planificacion.epienfId,
				epienf_has_planificacion.planId,
				epienf_has_planificacion.planTipo,
				planificacion.planNom
				FROM
				epienf_has_planificacion
				INNER JOIN planificacion ON epienf_has_planificacion.planId = planificacion.planId
				WHERE epienf_has_planificacion.epienfId = $idEpicrisis";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}
	
	function planificaDistinto($link,$idEpicrisis){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT DISTINCT planificacion.planNom,
				(SELECT epienf_has_planificacion.planTipo
				FROM
				epienf_has_planificacion
				WHERE epienf_has_planificacion.epienfId = $idEpicrisis AND epienf_has_planificacion.planTipo = 'A' and epienf_has_planificacion.planId=planificacion.planId) as IngresoPlan,
				(SELECT epienf_has_planificacion.planTipo
				FROM
				epienf_has_planificacion
				WHERE epienf_has_planificacion.epienfId = $idEpicrisis AND epienf_has_planificacion.planTipo = 'I' and epienf_has_planificacion.planId=planificacion.planId) as AltaPlan
				FROM
				planificacion
				INNER JOIN epienf_has_planificacion ON planificacion.planId = epienf_has_planificacion.planId
				WHERE
				epienf_has_planificacion.epienfId = $idEpicrisis";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}
		
	function derivado($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("epicrisis",$link);
		
		$sql = "SELECT *
				FROM
				derivaciones";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql." ERROR AL SELECCIONAR VARIABLES DE AUTOCUIDADO ".mysql_error());
		return($query);
		}
		
	function insertaAutocuidados($link,$cuidadosIng,$cuidadosAlt,$idEpicrisis){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sqlBorra = "DELETE FROM epienf_has_autocuidado WHERE epienfId = $idEpicrisis ";
	$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		if($cuidadosIng != ""){
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
		if($cuidadosAlt != ""){				
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
	}
	
	function insertaPlanificaciones($link,$planI,$planA,$idEpicrisis){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("epicrisis",$link);
	
	$sqlBorra = "DELETE FROM epienf_has_planificacion WHERE epienfId = $idEpicrisis ";
	$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
	
		if($planI != ""){
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
		if($planA != ""){
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
	function listarderivacionesa($link){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("parametros_clinicos",$link);
	
	$sql = "SELECT establecimiento.ESTAabreviado FROM establecimiento WHERE establecimiento.ESTAabreviado NOT IN ('HJNC')";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER listarderivacionesa<br>".mysql_error());
	return ($query);
	}

	function insertarderivacionesa($link, $ctacte, $derivadoa){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("camas",$link);
	
	$sql = "INSERT INTO derivada(der_ctacte, der_descripcion) values ('$ctacte', '$derivadoa')";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER insertarderivacionesa<br>".mysql_error());
	return ($query);
	}
	function actualizaderivacionesa($link, $ctacte, $derivadoa){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("camas",$link);
	
	$sql = "UPDATE derivada SET der_ctacte = '$ctacte', der_descripcion ='$derivadoa' WHERE der_ctacte = '$ctacte'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER actualizaderivacionesa<br>".mysql_error());
	return ($query);
	}
	
	function traederivacionesa($link, $ctacte){
	require_once('Conectar.inc'); 
	$objConectar = new Conectar; 
	$objConectar->db_select("camas",$link);
	
	$sql = "SELECT der_descripcion from derivada where der_ctacte = '$ctacte'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql,$link) or die($sql." <br>ERROR AL OBTENER traederivacionesa<br>".mysql_error());
	$query = mysql_fetch_array($query);
	return ($query);
	}
}
?>