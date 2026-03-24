<? class Paciente{
	function buscaPacienteDocumento($link, $tipo_doc, $busca){
		require_once("Conectar.inc");
		$bd = new Conectar;
		require_once("Paciente.inc");
		$objPaciente = new Paciente;
		
		//echo 'tipo_doc: '.$tipo_doc;
		
		switch($tipo_doc){
			case 'rut_paciente':		
							$bd->db_select("paciente",$link);
							$rowRetorna = $objPaciente->getRut($link, $busca);
							//$resultado = $rowRetorna['id'];
							break;
			case 'ficha_paciente':	
							$bd->db_select("paciente",$link);
							$rowRetorna = $objPaciente->getFicha($link, $busca);
							//$resultado = $rowRetorna['id'];
							break;
			case 'cta_cte':	
							$bd->db_select("camas",$link);
							$rowRetorna = $objPaciente->getCta_cte($link, $busca);
							//$resultado = $rowRetorna['id_paciente'];
							break;
		}
		return ($rowRetorna);
	}
	function getHistorial($link, &$tipo_doc, &$valor, &$estado,&$totalPag, &$total){
		if ($_SESSION['pagina_actual'] < 1){
		   $_SESSION['pagina_actual'] = 1;
		}
		$limit = 10;
		$offset = ($_SESSION['pagina_actual']-1) * $limit;
   		 
		    $sql = "
			SELECT 	SQL_CALC_FOUND_ROWS 	hospitalizaciones.id,
			hospitalizaciones.cta_cte,
			hospitalizaciones.procedencia,
			hospitalizaciones.id_paciente,
			hospitalizaciones.rut_paciente,
			hospitalizaciones.nom_paciente,
			hospitalizaciones.ficha_paciente,
			hospitalizaciones.hospitalizado,
			hospitalizaciones.fecha_ingreso,
			Max(hospitalizaciones.fecha_egreso) AS fecha_egreso,
			hospitalizaciones.d_tipo_1,
			hospitalizaciones.medico
			FROM hospitalizaciones
			WHERE censo_anio >= '2012' AND cod_destino >= 48 AND cod_servicio <> 47 AND hospitalizaciones.id_paciente <> 0 
			AND hospitalizaciones.censo_eliminado IS NULL AND ".$tipo_doc." = ".$valor."
			GROUP BY cta_cte
			ORDER BY fecha_egreso DESC  ";	
 			$sqlTot = "SELECT FOUND_ROWS() as total";
			mysql_query("SET NAMES utf8"); //echo $sql;
			$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL BUSCAR LISTADO DE HOSPITALIZACIONES<br>");
			$rsTotal = mysql_query($sqlTot,$link);
			$rowTotal = mysql_fetch_assoc($rsTotal);
			$total = $rowTotal["total"];
			if($total>0){
				$totalPag = ceil($total/$limit);
				return $query;
			}else{
				$sql = "
					SELECT SQL_CALC_FOUND_ROWS camas.cta_cte, 
					camas.procedencia, 
					camas.id_paciente, 
					camas.rut_paciente, 
					camas.nom_paciente, 
					camas.ficha_paciente, 
					camas.hospitalizado, 
					camas.fecha_ingreso, 
					camas.d_tipo_1, 
					camas.medico
					FROM camas
					WHERE cod_servicio <> 47 AND camas.id_paciente <> 0 
					AND ".$tipo_doc." = ".$valor."
					GROUP BY cta_cte
					";	
		 			$sqlTot = "SELECT FOUND_ROWS() as total";
					mysql_query("SET NAMES utf8"); //echo $sql;
					$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL BUSCAR LISTADO DE HOSPITALIZACIONES<br>");
					$rsTotal = mysql_query($sqlTot,$link);
					$rowTotal = mysql_fetch_assoc($rsTotal);
					$total = $rowTotal["total"];
					$totalPag = ceil($total/$limit);
				return $query;
			}
	}
		function getHistorialHospitaliza($link, $cta_cte){
 
 		    $sql = " SELECT SQL_CALC_FOUND_ROWS MIN(hospitalizaciones.fecha_ingreso) AS Ingreso,  MAX(hospitalizaciones.fecha_egreso) AS Egreso FROM hospitalizaciones WHERE  hospitalizaciones.cta_cte = ".$cta_cte;	
 		    $sqlTot = "SELECT FOUND_ROWS() as total";
 			mysql_query("SET NAMES utf8");
			$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL BUSCAR LISTADO DE HOSPITALIZACIONES<br>");
			$rsTotal = mysql_query($sqlTot,$link);
			$rowTotal = mysql_fetch_assoc($rsTotal);
			$total = $rowTotal["total"];
			if($total>0){
 				return $query;
 			}else{
 				$sql="SELECT date(camas.hospitalizado) FROM camas WHERE  camas.cta_cte = ".$cta_cte;
 				mysql_query("SET NAMES utf8");
				$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL BUSCAR LISTADO DE HOSPITALIZACIONES<br>");
				return $query;
 			}
	}
	function getHistorialHospitalizaXid($link, $id){
 
 		    $sql = " SELECT * FROM  hospitalizaciones WHERE hospitalizaciones.id = ".$id;	
 			mysql_query("SET NAMES utf8");
			$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL BUSCAR LISTADO DE HOSPITALIZACIONES<br>");
 			return $query;
	}
	function obtenerPaciente($link,$PACidentificador){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		$sql = "SELECT
				paciente.paciente.id,
				paciente.paciente.rut,
				paciente.paciente.nombres,
				paciente.paciente.apellidopat,
				paciente.paciente.apellidomat,
				paciente.paciente.fechanac,
				CONCAT(paciente.nombres,' ',paciente.apellidopat,' ',paciente.apellidomat) AS nombre_completo,
				paciente.paciente.sexo,
				paciente.paciente.direccion,
				paciente.paciente.prevision,
				paciente.paciente.nroficha,
				paciente.paciente.idcomuna,
				paciente.paciente.email,
				paciente.paciente.fono1,
				paciente.paciente.fono2,
				paciente.paciente.fono3,
				paciente.paciente.centroatencionprimaria,
				paciente.paciente.conveniopago,
				paciente.paciente.prais,
				paciente.comuna.comuna,
				camas.camas.cta_cte,
				camas.camas.que_cod_servicio,
				camas.camas.que_servicio,
				camas.camas.cod_servicio,
				camas.camas.servicio
				,camas.camas.prevision AS nom_prevision
				FROM
				paciente.paciente
				LEFT JOIN paciente.comuna ON paciente.comuna.id = paciente.paciente.idcomuna
				LEFT JOIN camas.camas ON paciente.paciente.id = camas.camas.id_paciente
				WHERE
				paciente.paciente.id = '$PACidentificador'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link);
		$result = mysql_fetch_assoc($query);
		return $result;
	}
	
	function sexoPac($sexo){
		switch($sexo){
			case 'M':
					$logoSexo = "-h";
				break;
			case 'F':
					$logoSexo = "-m";
				break;
			}
		return ($logoSexo);
		}
		
	function fichaPac($ficha_esta){
		switch($ficha_esta){
			case '0':
					$logoFicha = "";
				break;
			case '1':
					$logoFicha = "-f";
				break;
			}
		return ($logoFicha);
		}
	function getRut($link, $busca){
		$sql = "SELECT id, rut, CONCAT(paciente.nombres,' ',paciente.apellidopat,' ',paciente.apellidomat) AS nombre_completo,nroficha
				FROM paciente 
				WHERE rut = '$busca'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getFicha($link, $busca){
		$sql = "SELECT id, rut,CONCAT(paciente.nombres,' ',paciente.apellidopat,' ',paciente.apellidomat) AS nombre_completo,nroficha
				FROM paciente 
				WHERE nroficha = '$busca'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getCta_cte($link, $busca){
		$sql = "SELECT SQL_CALC_FOUND_ROWS id_paciente, rut_paciente AS rut, hospitalizaciones.nom_paciente AS nombre_completo, hospitalizaciones.ficha_paciente AS nroficha 
				FROM hospitalizaciones 
				WHERE cta_cte = '$busca'";
		$sqlTot = "SELECT FOUND_ROWS() as total";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		$rsTotal = mysql_query($sqlTot,$link);
			$rowTotal = mysql_fetch_assoc($rsTotal);
			$total = $rowTotal["total"];
			if($total>0){
 				return $datos;
 			}else{
 				$sql = "SELECT id_paciente, rut_paciente AS rut, camas.nom_paciente AS nombre_completo, camas.ficha_paciente AS nroficha 
				FROM camas 
				WHERE cta_cte = '$busca'";
				$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
				$datos = mysql_fetch_array($resultado);
				return $datos;
 			}
	}			
	function transito_paciente($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				transito_paciente.id,
				transito_paciente.cta_cte,
				transito_paciente.desc_sscc_desde,
				transito_paciente.desc_sscc_hasta,
				transito_paciente.cama_sn,
				transito_paciente.id_paciente,
				transito_paciente.rut_paciente,
				transito_paciente.nom_paciente,
				transito_paciente.fecha,
				transito_paciente.hospitalizado
				FROM
				transito_paciente
				ORDER BY
				transito_paciente.nom_paciente ASC";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER PACIENTES DE TRANSITO PACIENTE TOTALES<br>");
		return ($query);
		
		}
	
	function lista_espera_servicio($link,$servicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "(SELECT
				camas.transito_paciente.id,
				camas.transito_paciente.cta_cte,
				camas.transito_paciente.desc_sscc_desde,
				camas.transito_paciente.desc_sscc_hasta,
				camas.transito_paciente.cama_sn,
				camas.transito_paciente.id_paciente,
				camas.transito_paciente.rut_paciente,
				camas.transito_paciente.nom_paciente,
				camas.transito_paciente.fecha,
				camas.transito_paciente.hospitalizado
				FROM
				camas.transito_paciente
				WHERE
				camas.transito_paciente.cod_sscc_hasta = '$servicio'
				ORDER BY
				camas.transito_paciente.fecha ASC)
				UNION
				(SELECT
				pensionado.transito_pensionado.id,
				pensionado.transito_pensionado.cta_cte,
				pensionado.transito_pensionado.desc_sscc_desde,
				pensionado.transito_pensionado.desc_sscc_hasta,
				'',
				pensionado.transito_pensionado.id_paciente,
				pensionado.transito_pensionado.rut_paciente,
				pensionado.transito_pensionado.nom_paciente,
				pensionado.transito_pensionado.fecha,
				pensionado.transito_pensionado.hospitalizado
				FROM
				pensionado.transito_pensionado
				WHERE
				pensionado.transito_pensionado.cod_sscc_hasta = '$servicio')";
				
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER PACIENTES DE TRANSITO PACIENTE DE LISTA DE ESPERA<br>");
		return ($query);
		
		}
		
	function lista_traslado_servicio($link,$servicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "(SELECT
				camas.transito_paciente.id,
				camas.transito_paciente.cta_cte,
				camas.transito_paciente.desc_sscc_desde,
				camas.transito_paciente.desc_sscc_hasta,
				camas.transito_paciente.cama_sn,
				camas.transito_paciente.id_paciente,
				camas.transito_paciente.rut_paciente,
				camas.transito_paciente.nom_paciente,
				camas.transito_paciente.fecha,
				camas.transito_paciente.hospitalizado
				FROM
				camas.transito_paciente
				WHERE
				camas.transito_paciente.cod_sscc_desde = '$servicio'
				ORDER BY
				camas.transito_paciente.fecha ASC)
				UNION
				(SELECT
				pensionado.transito_pensionado.id,
				pensionado.transito_pensionado.cta_cte,
				pensionado.transito_pensionado.desc_sscc_desde,
				pensionado.transito_pensionado.desc_sscc_hasta,
				'',
				pensionado.transito_pensionado.id_paciente,
				pensionado.transito_pensionado.rut_paciente,
				pensionado.transito_pensionado.nom_paciente,
				pensionado.transito_pensionado.fecha,
				pensionado.transito_pensionado.hospitalizado
				FROM
				pensionado.transito_pensionado
				WHERE
				pensionado.transito_pensionado.cod_sscc_desde = '$servicio')";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER PACIENTES DE TRANSITO PACIENTE DE TRASLADO SERVICIO<br>");
		return ($query);
		
		}
		
	function detalle_transito_paciente($idTransito, $link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "(SELECT
				camas.transito_paciente.id,
				camas.transito_paciente.cta_cte,
				camas.transito_paciente.que_cod_servicio,
				camas.transito_paciente.cod_sscc_desde,
				camas.transito_paciente.desc_sscc_desde,
				camas.transito_paciente.cama_sn,
				camas.transito_paciente.cod_sscc_hasta,
				camas.transito_paciente.desc_sscc_hasta,
				camas.transito_paciente.id_paciente,
				camas.transito_paciente.rut_paciente,
				camas.transito_paciente.ficha_paciente,
				camas.transito_paciente.nom_paciente,
				camas.transito_paciente.tipo_traslado,
				camas.transito_paciente.hospitalizado,
				camas.transito_paciente.fecha,
				camas.transito_paciente.hora,
				camas.transito_paciente.diagnostico1,
				camas.transito_paciente.diagnostico2,
				camas.transito_paciente.id_solicitud,
				camas.transito_paciente.barthel,
				camas.transito_paciente.neurologico,
				camas.transito_paciente.acctransito,
				camas.transito_paciente.multires,
				camas.transito_paciente.cod_medico,
				'camas' as 'Tipo',
				camas.transito_paciente.tipo_paciente,
				camas.transito_paciente.cod_pad,
				camas.transito_paciente.tipo_cama,
				camas.transito_paciente.folio_pad,
				camas.transito_paciente.id_parto,
				camas.transito_paciente.barthelegreso
				FROM camas.transito_paciente
				WHERE camas.transito_paciente.id = '$idTransito')
				UNION ALL
				(SELECT
				pensionado.transito_pensionado.id,
				pensionado.transito_pensionado.cta_cte,
				'',
				pensionado.transito_pensionado.cod_sscc_desde,
				pensionado.transito_pensionado.desc_sscc_desde,
				'',
				pensionado.transito_pensionado.cod_sscc_hasta,
				pensionado.transito_pensionado.desc_sscc_hasta,
				pensionado.transito_pensionado.id_paciente,
				pensionado.transito_pensionado.rut_paciente,
				pensionado.transito_pensionado.ficha_paciente,
				pensionado.transito_pensionado.nom_paciente,
				pensionado.transito_pensionado.tipo_traslado,
				pensionado.transito_pensionado.hospitalizado,
				pensionado.transito_pensionado.fecha,
				pensionado.transito_pensionado.hora,
				pensionado.transito_pensionado.diagnostico1,
				pensionado.transito_pensionado.diagnostico2,
				'',
				NULL,
				'',
				'',
				'',
				'',
				'pensionado' as 'Tipo',
				pensionado.transito_pensionado.tipo_paciente,
				pensionado.transito_pensionado.cod_pad,
				pensionado.transito_pensionado.tipo_cama,
				pensionado.transito_pensionado.folio_pad,
				'',
				''
				FROM
				pensionado.transito_pensionado
				WHERE pensionado.transito_pensionado.id = '$idTransito')";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER PACIENTES DE TRANSITO PACIENTE DETALLADO<br>".$sql);
		return ($query);
		}
		
	function eliminaTransitoPaciente($link,$idTransito,$tipo){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		
		if($tipo == 'pensionado'){
		
		$objConectar->db_select("pensionado",$link);		
		$sql = "DELETE FROM transito_pensionado
				WHERE (id='$idTransito')";
		}else{
		$objConectar->db_select("camas",$link);
		$sql = "DELETE FROM transito_paciente 
				WHERE (id='$idTransito')";
		}
		mysql_query("SET NAMES utf8");
		mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL ELIMINAR PACIENTE DEL TRANSITO PACIENTE<br>");
				
		}
	function insertaTransitoPaciente($link,$cod_destino,$nom_destino,$que_cod_servicio,$que_servicio,$servicio,$cod_servicio,$cta_cte,$cod_procedencia,$procedencia,$cama_sn,$cod_medico,$medico,$cod_auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$rut_paciente,$ficha_paciente,$nom_paciente,$tipoTraslado,$hospitalizado,$fechaEgreso,$horaEgreso,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$codPad,$barthel,$idSolicitud,$tipoNeuro,$barthelegreso){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		require_once('Servicios.inc'); 
		$objServicios = new Servicios; 
		$arr_que_servicio = $objServicios->homologaServicio2($link,$que_cod_servicio);
		$que_cod_servicio = $arr_que_servicio['id_rau'];
		
		$arr_servicio = $objServicios->homologaServicio2($link,$cod_servicio);
		$cod_servicio = $arr_servicio['id_rau'];
		
		$arr_destino = $objServicios->homologaServicio2($link,$cod_destino);
		$cod_destino = $arr_destino['id_rau'];
		
		if($barthel==''){
			$varBarthel = "NULL";
			}else{
				$varBarthel = "$barthel";
				}
		if($barthelegreso == ''){
			$barthelegreso = "NULL";
		}else{
			$barthelegreso = $barthelegreso;
		}
		
		$sql = "INSERT INTO transito_paciente
				(cta_cte,
				que_cod_servicio,
				que_servicio,
				cod_sscc_desde,
				desc_sscc_desde,
				cama_sn,
				cod_sscc_hasta,
				desc_sscc_hasta,
				id_paciente,
				rut_paciente,
				ficha_paciente,
				nom_paciente,
				tipo_traslado,
				hospitalizado,
				fecha,
				hora,
				cod_medico,
				medico,
				cod_auge,
				acctransito,
				multires,
				diagnostico1,
				diagnostico2,
				id_parto,
				id_solicitud,
				barthel,
				neurologico,
				barthelegreso)
				VALUES
				($cta_cte,
				$que_cod_servicio,
				'$que_servicio',
				$cod_servicio,
				'$servicio',
				'$cama_sn',
				$cod_destino,
				'$nom_destino',
				$id_paciente,
				$rut_paciente,
				$ficha_paciente,
				'$nom_paciente',
				$tipoTraslado,
				'$hospitalizado',
				'$fechaEgreso',
				'$horaEgreso',
				'$cod_medico',
				'$medico',
				'$cod_auge',
				$acctransito,
				$multires,
				'$diagnostico1',
				'$diagnostico2',
				'$id_parto',
				'$idSolicitud',
				".$varBarthel.",
				'$tipoNeuro',
				'$barthelegreso')";
				mysql_query("SET NAMES utf8");
				$query = mysql_query($sql) or die("ERROR AL INSERTAR EN TRANSITO PACIENTE".mysql_error());
				return ($query);
		}	
		
	function pacientesHospitalizados($link,$rut,$nombre){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		if($nombre != ''){
			$varBusqueda = "AND nom_paciente like '%$nombre%'";
			$varBusqueda2 = "WHERE nomPacienteSN like '%$nombre%'";
			}
		$sql = "SELECT
				camas.id as IDcama,
				camas.rut_paciente AS RUT,
				camas.nom_paciente AS NOMBRE,
				camas.servicio AS SERVICIO,
				1 as TIPO,
				camas.sala AS SALA,
				camas.cama AS CAMA
				FROM
				camas
				WHERE
				camas.estado IN (2, 4) ".$varBusqueda." 
				UNION
				SELECT
				listasn.idCamaSN as IDcama,
				listasn.rutPacienteSN AS RUT,
				listasn.nomPacienteSN AS NOMBRE,
				listasn.desde_nomServSN AS SERVICIO,
				2 AS TIPO,
				camassn.salaCamaSN AS SALA,
				camassn.nomCamaSN AS CAMA
				FROM
				listasn
				LEFT JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
				".$varBusqueda2."
				ORDER BY SERVICIO ASC";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql."ERROR AL BUSCAR PACIENTES HOSPITALIZADOS ".mysql_error());
		return ($query);
		
		}
		function pacientesCosulta($link,$tipo_doc,$estado,$valor){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		// de alta o cama
		switch($estado){
			case 1: $tabla.=' FROM hospitalizaciones' ; break;
			case 2: $tabla.=' FROM camas' ;  ; break;
		}
		
		// rut, ficha y ctacte
 		 $busqueda.=' WHERE "'.$tipo_doc.'" = '.$valor.'' ; ; break;
			 
 	     $sql = "SELECT
			camas.id as IDcama,
			camas.rut_paciente AS RUT,
			camas.nom_paciente AS NOMBRE,
			camas.servicio AS SERVICIO,
			1 as TIPO,
			camas.sala AS SALA,
			camas.cama AS CAMA
			FROM
			camas
			WHERE
			camas.estado IN (4) ".$busqueda." 
			UNION
			SELECT
			listasn.idCamaSN as IDcama,
			listasn.rutPacienteSN AS RUT,
			listasn.nomPacienteSN AS NOMBRE,
			listasn.desde_nomServSN AS SERVICIO,
			2 AS TIPO,
			camassn.salaCamaSN AS SALA,
			camassn.nomCamaSN AS CAMA
			FROM
			listasn
			LEFT JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
			".$busqueda."
			ORDER BY SERVICIO ASC";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die($sql."ERROR AL BUSCAR PACIENTES HOSPITALIZADOS ".mysql_error());
		return ($query);
		
		}
	function historialPaciente($link,$idPaciente){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$sql = "SELECT
				hospitalizaciones.id,
				hospitalizaciones.servicio,
				hospitalizaciones.sala,
				hospitalizaciones.cama,
				hospitalizaciones.cta_cte,
				hospitalizaciones.destino,
				hospitalizaciones.medico,
				hospitalizaciones.auge,
				hospitalizaciones.acctransito,
				hospitalizaciones.multires,
				hospitalizaciones.diagnostico1,
				hospitalizaciones.diagnostico2,
				hospitalizaciones.rut_paciente,
				hospitalizaciones.ficha_paciente,
				hospitalizaciones.nom_paciente,
				hospitalizaciones.prevision,
				hospitalizaciones.fono1_paciente,
				hospitalizaciones.fono2_paciente,
				hospitalizaciones.fono3_paciente,
				hospitalizaciones.categorizacion_riesgo,
				hospitalizaciones.categorizacion_dependencia,
				hospitalizaciones.fecha_ingreso,
				hospitalizaciones.hora_ingreso,
				hospitalizaciones.fecha_egreso,
				hospitalizaciones.hora_egreso
				FROM
				hospitalizaciones
				WHERE
				hospitalizaciones.id_paciente = '$idPaciente'
				ORDER BY hospitalizado DESC";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql) or die("ERROR AL SELECCIONAR HISTORIAL DEL PACIENTE ".mysql_error());
		return ($query);
		}
	
	function validaPacienteNN($link,$rut){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		
		$sql = "SELECT
				paciente.id
				FROM paciente
				where paciente.rut = '$rut'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die("Error al seleccionar datos de paciente NN ".mysql_error());
		return ($query);
		
		}
		
	function guardaDatosNN($link,$rut,$nombre,$apellidoPat,$apellidoMat,$direccion,$fono,$usuario,$fecha){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		
		$sql = "INSERT INTO nn_datos 
				(NN_rut,
				 NN_nombre,
				 NN_apellidoPat,
				 NN_apellidoMat,
				 NN_direccion,
				 NN_fono1,
				 NN_usuarioIngreso,
				 NN_fecha) 
				VALUES 
				('$rut',
				 '$nombre',
				 '$apellidoPat',
				 '$apellidoMat',
				 '$direccion',
				 '$fono',
				 '$usuario',
				 '$fecha')";
		mysql_query("SET NAMES utf8");		 
		$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR DATOS A TABLA NN_DATOS".mysql_error());
		return ($query);
		}
		
	function insertaPacienteRN($link,$nombreRN,$apellidoPatRN,$apellidoMatRN,$fechaNac,$sexoRN,$direccionRN,$previsionRN,$comunaRN,$fonoRN,$consultorioRN,$convenioRN,$usuario_actual){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		
		$sql = "INSERT INTO paciente
			 (rut,
			  nombres,
			  apellidopat,
			  apellidomat,
			  fechanac,
			  sexo,
			  direccion,
			  prevision,
			  idcomuna,
			  fono1,
			  centroatencionprimaria,
			  conveniopago,
			  idusuario) 
			 VALUES 
			 ('0',
			 '$nombreRN',
			 '$apellidoPatRN',
			 '$apellidoMatRN',
			 '$fechaNac',
			 '$sexoRN',
			 '$direccionRN',
			 '$previsionRN',
			 '$comunaRN',
			 '$fonoRN',
			 '$consultorioRN',
			 '$convenioRN',
			 '$usuario_actual')";
			 
		mysql_query("SET NAMES utf8");		 
		$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR DATOS A TABLA NN_DATOS".mysql_error());
		$idPacienteRN = mysql_insert_id();
		return ($idPacienteRN);
		}
		
	function insertaLogPaciente($link,$fechaRN ,$horaRN,$usuarioRN,$tipoRN,$id_pacienteRN,$rutRN,$paternoRN,$maternoRN,$nombresRN,$nacimientoRN,$sexoRN,$previsionRN,$fono3RN,$fono2RN,$fono1RN,$direccionRN,$convenioRN,$nro_fichaRN,$sistemasRN){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		
		$sql = "INSERT INTO log_paciente 
				(fecha,
				hora,
				usuario,
				tipo,
				id_paciente,
				rut,
				paterno,
				materno,
				nombres,
				nacimiento,
				sexo,
				prevision,
				fono3,
				fono2,
				fono1,
				direccion,
				convenio,
				nro_ficha,
				sistemas) 
				VALUES 
				('$fechaRN',
				'$horaRN',
				'$usuarioRN',
				'$tipoRN',
				$id_pacienteRN,
				$rutRN,
				'$paternoRN',
				'$maternoRN',
				'$nombresRN',
				'$nacimientoRN',
				'$sexoRN',
				$previsionRN,
				'$fono3RN',
				'$fono2RN',
				'$fono1RN',
				'$direccionRN',
				$convenioRN,
				$nro_fichaRN,
				'$sistemasRN')";
		mysql_query("SET NAMES utf8");		 
		$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR DATOS A TABLA NN_DATOS".mysql_error());
		$idLog = mysql_insert_id();
		return ($idLog);
		}
		
		
}?>