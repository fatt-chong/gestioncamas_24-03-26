<? class Paciente{
	function buscaPacienteDocumento($link, $tipo_doc, $busca){
		require_once("Conectar.inc");
		$bd = new Conectar;
		require_once("Paciente.inc");
		$objPaciente = new Paciente;
		switch($tipo_doc){
			case 'rut':		$bd->db_select("paciente",$link);
							$rowRetorna = $objPaciente->getRut($link, $busca);
							$resultado = $rowRetorna['id'];
							break;
			case 'ficha':	$bd->db_select("paciente",$link);
							$rowRetorna = $objPaciente->getFicha($link, $busca);
							$resultado = $rowRetorna['id'];
							break;
			case 'cta_cte':	$bd->db_select("camas",$link);
							$rowRetorna = $objPaciente->getCta_cte($link, $busca);
							$resultado = $rowRetorna['id_paciente'];
							break;
		}
		return ($resultado);
	}
	function buscaPacienteCorrelativo($link, $correlativo, $anio){
		require_once("Conectar.inc");
		$bd = new Conectar;
		$bd->db_select("camas",$link);
		$sql = "SELECT id_paciente, rut_paciente
				FROM hospitalizaciones 
				WHERE censo_correlativo = '$correlativo'
				AND censo_anio = '$anio'
				GROUP BY id_paciente";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR PACIENTE POR EL CORRELATIVO DE CENSO<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		$resultado = $datos['id_paciente'];
		return ($resultado);
	}
	
	function getRut($link, $busca){
		$sql = "SELECT id, rut
				FROM paciente 
				WHERE rut = '$busca'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getFicha($link, $busca){
		$sql = "SELECT id, rut
				FROM paciente 
				WHERE nroficha = '$busca'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getCta_cte($link, $busca){
		$sql = "SELECT id_paciente, rut_paciente
				FROM hospitalizaciones 
				WHERE cta_cte = '$busca'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL BUSCAR POR RUT<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}		
	
	
	function getPaciente($link, $pacId){
		$sql = "SELECT pac.id, pac.rut, pac.nombres, pac.apellidopat, pac.apellidomat, pac.fechanac, pac.sexo,
				pac.nroficha, pac.prevision, pac.conveniopago, pac.direccion, com.comuna, pac.fono1, pac.fono2, pac.fono3, prev.prevision AS nom_prev
				FROM paciente AS pac 
				LEFT JOIN prevision AS prev ON pac.prevision = prev.id
				LEFT JOIN comuna AS com ON pac.idcomuna = com.id
				WHERE pac.id = '$pacId'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER DATOS PACIENTE<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getUltimoDiagnostico($link, $pacId, $hospitalizado){
		$sql = "SELECT MAX(h.id) AS id, h.hospitalizado
				FROM hospitalizaciones AS h
				WHERE h.id_paciente = '$pacId'
				AND h.hospitalizado = '$hospitalizado'
				GROUP BY h.hospitalizado";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL LEER EL ULTIMO ID HOSPITALIZACION<br><br>$sql");
		$ultimo = mysql_fetch_array($resultado);
		$id = $ultimo['id'];
		$sql2 = "SELECT hospitalizaciones.id, hospitalizaciones.cta_cte,hospitalizaciones.diagnostico1, hospitalizaciones.diagnostico2, hospitalizaciones.medico, med.medico, med.rut
				FROM hospitalizaciones
				LEFT JOIN medicos AS med ON med.id = hospitalizaciones.cod_medico
				WHERE hospitalizaciones.id = '$id'";
		$resultado = mysql_query($sql2,$link) or die(mysql_error()."<br><br>ERROR AL LEER DATOS HOSPITALIZACION DIAGNOSTICO, MEDICO<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getHistorial($link, $pacId, $correlativo, $anio){
		if($correlativo == '')
			$correlativo = 0;
		else
			$criterioAnio = " AND censo_anio = '$anio'";
		$criterioCorrelativo = " AND censo_correlativo = '$correlativo'";
		if($pacId != ''){
			$criterioPacId = " AND hospitalizaciones.id_paciente = '$pacId'";
			$criterioCorrelativo = "";
		}
		$sql = "SELECT hospitalizaciones.id, hospitalizaciones.cta_cte, hospitalizaciones.procedencia, hospitalizaciones.id_paciente, 
				hospitalizaciones.rut_paciente, hospitalizaciones.nom_paciente, hospitalizaciones.ficha_paciente, hospitalizaciones.hospitalizado, hospitalizaciones.fecha_ingreso, MAX(fecha_egreso) AS fecha_egreso,
				hospitalizaciones.censo_anio, hospitalizaciones.censo_correlativo 
				FROM hospitalizaciones 
				WHERE censo_anio >= '2012'
				AND cod_destino >= 49
				AND cod_servicio <> 47
				AND hospitalizaciones.id_paciente <> 0
				AND hospitalizaciones.censo_eliminado IS NULL".$criterioPacId.$criterioCorrelativo.$criterioAnio."
				GROUP BY hospitalizado, id_paciente
				ORDER BY fecha_egreso";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER HISTORIAL DE HOSPITALIZACIONES1<br><br>$sql");
		return ($datos);
	}
	function getDetalleHistorial($link, $pacId, $hospitalizado, $correlativo){
		$sql = "SELECT h.id, h.id_paciente, h.cta_cte, h.camaSN, h.que_cod_servicio, h.que_servicio, h.cod_servicio, h.servicio, h.cod_procedencia, h.procedencia, h.tipo_1, h.d_tipo_1,
				h.fecha_ingreso, h.hora_ingreso, h.cod_destino, h.destino, h.fecha_egreso, h.hora_egreso, h.censo_correlativo, h.tipo_2, h.d_tipo_2
				FROM hospitalizaciones AS h
				WHERE h.id_paciente = '$pacId'
				AND h.censo_eliminado IS NULL
				AND h.hospitalizado = '$hospitalizado'
				AND h.censo_correlativo = $correlativo
				ORDER BY h.id";
		
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER HISTORIAL DE HOSPITALIZACIONES2<br><br>$sql");
		return ($datos);
	}
	function getDetalleEspecifico($link, $HOSid){
		$sql = "SELECT h.id, h.id_paciente, h.cta_cte, h.sala, h.cama, h.categorizacion_riesgo, h.categorizacion_dependencia, h.cod_servicio, h.servicio, h.cod_procedencia, h.procedencia,
				h.fecha_ingreso, h.hora_ingreso, h.cod_destino, h.destino, h.fecha_egreso, h.hora_egreso, h.censo_correlativo
				FROM hospitalizaciones AS h
				WHERE h.id = '$HOSid'";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER HISTORIAL DE HOSPITALIZACIONES3<br><br>$sql");
		$resultado = mysql_fetch_array($datos);
		return ($resultado);
	}
	function getIntervenciones($link, $id_paciente, $rango_fechas){
		$inicio = $rango_fechas['inicio'];
		$final = $rango_fechas['final'];
		$sql = "SELECT cir.ciruFecha, cir.ciruInter1Cod, pre.preNombre
				FROM cirugia AS cir
				LEFT JOIN paciente.prestacion AS pre ON cir.ciruInter1Cod = pre.preCod
				WHERE pacieCod = '$id_paciente'
				AND ciruFecha BETWEEN '$inicio' AND '$final'
				AND cir.ciruEstado = 'REALIZADA'
				# ORDER BY ciruFecha DESC
				UNION ALL
				SELECT
				pabnet.solicitudes.sol_fecha_pabellon,
				pabnet.protocolo_has_prestacion.prestacion_id,
				le.intervencion.nom_intervencion
				FROM
				pabnet.tabla_quirurgica
				INNER JOIN pabnet.protocolo ON pabnet.tabla_quirurgica.tq_id = pabnet.protocolo.tabla_quirurgica_tq_id
				INNER JOIN pabnet.protocolo_has_prestacion ON pabnet.protocolo.tabla_quirurgica_tq_id = pabnet.protocolo_has_prestacion.tabla_quirurgica_tq_id
				INNER JOIN pabnet.solicitudes ON pabnet.tabla_quirurgica.sol_id = pabnet.solicitudes.sol_id
				INNER JOIN le.intervencion ON pabnet.protocolo_has_prestacion.prestacion_id = le.intervencion.id_intervencion AND le.intervencion.anio = year(sol_fecha_pabellon)
				WHERE
				pabnet.solicitudes.sol_id_paciente = '$id_paciente'
				AND pabnet.solicitudes.sol_fecha_pabellon BETWEEN '$inicio' AND '$final' AND pabnet.solicitudes.sol_estado = 6 #ORDER BY pabnet.solicitudes.sol_fecha_pabellon DESC";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER HISTORIAL DE INTERVENCIONES<br><br>$sql");
		return ($datos);
	}
	function getPartos($link, $id_paciente, $rango_fechas){
		$inicio = $rango_fechas['inicio'];
		$final = $rango_fechas['final'];
		$sql = "SELECT rn_datos.RNfecha, rn_datos.RNestado, rn_datos.RNsexo,
				rn_datos.RNpeso, rn_datos.RNapgar5
				FROM libro_partos
				LEFT JOIN rn_datos ON rn_datos.PAidparto = libro_partos.PAidparto
				WHERE libro_partos.idPaciente =  '$id_paciente' 
				AND rn_datos.RNfecha BETWEEN  '$inicio' AND '$final'";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER PARTOS DEL PACIENTE<br><br>$sql");
		return ($datos);
	}	
	function generaDigito($fecha){
		require_once("include/funciones/funciones.php");
		$valor = generaDigito($fecha);
		return ($valor);
	}
	function invierteFecha($fecha){
		$valor = cambiarFormatoFecha($fecha);
		return ($valor);
	}	
}
?>