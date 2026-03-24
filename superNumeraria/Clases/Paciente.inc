<? class Paciente{
	function getPaciente($link, $pacId){
		$sql = "SELECT pac.id, pac.rut, pac.nombres, pac.apellidopat, pac.apellidomat, pac.fechanac, pac.sexo,
				pac.nroficha, pac.prevision, pac.conveniopago, pac.direccion, com.comuna, pac.fono1, pac.fono2, pac.fono3, prev.prevision AS nom_prev
				FROM paciente AS pac 
				LEFT JOIN prevision AS prev ON pac.prevision = prev.id
				LEFT JOIN comuna AS com ON pac.idcomuna = com.id
				WHERE pac.id = '$pacId'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER DATOS PACIENTE<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getPacienteTransito($link, $PACid){
		$sql = "SELECT transito_paciente.id_paciente, transito_paciente.cta_cte, transito_paciente.cod_sscc_desde,
				transito_paciente.desc_sscc_desde, transito_paciente.cod_sscc_hasta, transito_paciente.desc_sscc_hasta,
				transito_paciente.hospitalizado, transito_paciente.diagnostico1, transito_paciente.diagnostico2, transito_paciente.fecha
				FROM transito_paciente
				WHERE id_paciente = '$PACid'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER CTA CTE<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
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
	//FIN FUNCIONES CENSO DIARIO
}
?>