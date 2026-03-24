<? class Cama{
	function getPacientesTransito($link){
		$sql = "SELECT id, cta_cte, que_cod_servicio, que_servicio, cod_sscc_desde, cod_sscc_hasta,
				desc_sscc_desde, desc_sscc_hasta, id_paciente, rut_paciente, nom_paciente, fecha
				FROM transito_paciente
				WHERE cod_sscc_hasta = 10371";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO PACIENTES EN TRANSITO<br><br>$sql");
		return ($datos);
	}
	function deletePacienteTransito($link,$TRAid){
		$sql = "DELETE FROM transito_paciente 
				WHERE id = '$TRAid'";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO PACIENTES EN TRANSITO<br><br>$sql");
		return ($datos);
	}
	function getPaciente_cta_cte($link, $pacId){
		$sql = "SELECT cta_cte, cod_sscc_desde
				FROM transito_paciente
				WHERE transito_paciente.id_paciente = '$pacId'";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER CTA CTE<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getMedicos($link){
		$sql = "SELECT id, medico
				FROM medicos
				ORDER BY medico";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER MEDICOS<br><br>$sql");
		return ($datos);
	}	
	function getPatologias($link){
		$sql = "SELECT id, pauge
				FROM pauge
				ORDER BY pauge";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER PATOLOGIAS<br><br>$sql");
		return ($datos);
	}
	function getSalas($link){
		$sql = "SELECT SALcod, SALnombre
				FROM sala
				ORDER BY SALcod";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO DE SALAS<br><br>$sql");
		return ($datos);
	}
	function getCamas($link,$sala){
		$sql = "SELECT CAMcod, CAMnombre, CAMestado
				FROM camas 
				WHERE SALcod = '$sala'
				AND CAMestado = 'L'
				ORDER BY camas.CAMcod";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO DE CAMAS<br><br>$sql");
		return ($datos);
	}
	function getMapaCamas($link,$sala){
		$sql = "SELECT atencion.HOSid, atencion.HOSfecha_hospitalizado, atencion.id_paciente, DATE_FORMAT(atencion.HOSingreso,'%d-%m-%Y') AS fecha_ing, 
				DATE_FORMAT(atencion.HOSingreso,'%H:%i') AS hora_ing, atencion.HOSingreso, NOW() AS actual, camas.CAMcod, 
				camas.CAMnombre, camas.CAMestado, CONCAT(pac.nombres, ' ', pac.apellidopat, ' ', pac.apellidomat) AS nom_pac, 
				pac.sexo, atencion.HOSdiagnostico1, atencion.HOSdiagnostico2, atencion.HOSpabellon, atencion.HOSmultires, med.medico
				FROM atencion
				RIGHT JOIN camas ON camas.CAMcod = atencion.CAMcod
				LEFT JOIN paciente.paciente AS pac ON pac.id = atencion.id_paciente
				LEFT JOIN camas.medicos AS med ON atencion.HOSmedico = med.id
				WHERE camas.SALcod = '$sala'
				ORDER BY camas.CAMcod";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO DE CAMAS<br><br>$sql");
		return ($datos);
	}
	function calculaTiempo($HOSingreso, $fecha){
		$dias_diff = intval((strtotime($fecha)-strtotime($HOSingreso))/86400);
		$horas_diff = intval(((strtotime($fecha)-strtotime($HOSingreso))/3600)-($dias_diff*24));
		$minutos_diff = intval(((strtotime($fecha)-strtotime($HOSingreso))/60)-($dias_diff*24*60)-($horas_diff*60));
		$resultado = array('dias'=>$dias_diff,'horas'=>$horas_diff,'minutos'=>$minutos_diff);
		return $resultado;
	}
	function chekeaCama($link,$cama){
		$sql = "SELECT * FROM camas WHERE CAMcod = '$cama' AND CAMestado = 'L'";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CHEKEAR ESTADO DE CAMA<br><br>$sql");
		$respuesta = mysql_num_rows($datos);
		return ($respuesta);		
	}
	function ocupaCama($link,$cama){
		$sql = "UPDATE camas SET CAMestado = 'O' WHERE CAMcod = '$cama'";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL ACTUALIZAR ESTADO DE CAMAS<br><br>$sql");
		return ($datos);
	}
}
?>