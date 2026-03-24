<? class Atencion{
	function getListadoDia($link){
		$sql = "SELECT dia.HOSid, dia.id_paciente, pac.rut, pac.nombres, pac.apellidopat,
				pac.apellidomat, dia.HOSfecha_hospitalizado,
				DATE_FORMAT(dia.HOSingreso,'%d-%m-%Y %H:%i') AS HOSingreso, DATE_FORMAT(dia.HOSsalida,'%d-%m-%Y %H:%i') AS HOSsalida
				FROM cma.atencion AS dia
				LEFT JOIN paciente.paciente AS pac ON pac.id = dia.id_paciente
				RIGHT JOIN camas ON camas.CAMcod = dia.CAMcod
				ORDER BY dia.HOSid";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER LISTADO PACIENTES<br><br>$sql");
		return ($datos);
	}
	function agregaAtencion($link,$cama,$PACid,$hospitalizado,$PACedad,$idservicio,$medico,$cta_cte,$cod_procedencia,$diagnostico1,$diagnostico2,$PACprevision,$fecha,$hora_ingreso,$auge,$accidente,$multires){
		$fecha_ingreso = $fecha." ".$hora_ingreso;
		$sql = "INSERT INTO atencion (id_paciente, PACedad, idservicio, cta_cte, cod_procedencia, HOSmedico,HOSdiagnostico1, HOSdiagnostico2,
										PACprevision, HOSfecha_hospitalizado, CAMcod, HOSingreso, HOSauge, HOSaccidente, HOSmultires)
								VALUES('$PACid','$PACedad','$idservicio','$cta_cte','$cod_procedencia','$medico','$diagnostico1','$diagnostico2',
										'$PACprevision','$hospitalizado','$cama','$fecha_ingreso','$auge','$accidente','$multires')";
		mysql_query("SET NAMES utf8");
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL INGRESAR PACIENTE A REGISTRO DE HOSPITAL DIA<br><br>$sql");
		require_once("Cama.inc");
		$objCama = new Cama;
		$objCama->ocupaCama($link,$cama);
	}
	function getAtencion($link,$HOSid){
		$sql = "SELECT hos.HOSid, hos.id_paciente, pac.rut, pac.nombres, pac.apellidopat, pac.apellidomat, ser.nombre, cam.CAMnombre,
				DATE_FORMAT(pac.fechanac, '%d-%m-%Y') AS fechanac, pac.sexo, pac.idcomuna, pac.direccion, hos.cta_cte, pac.nroficha, prev.prevision, med.medico, hos.HOSdiagnostico1,
				hos.HOSdiagnostico2, DATE_FORMAT(hos.HOSingreso, '%d-%m-%Y') AS HOSingreso_hora, TIME_FORMAT(hos.HOSingreso,'%H:%i') AS HOSingreso,
				DATE_FORMAT(hos.HOSsalida,'%d-%m-%Y') AS HOSsalida_fecha, TIME_FORMAT(hos.HOSsalida,'%H:%i') AS HOSsalida, 
				hos.PACedad, hos.idservicio, hos.PACprevision, hos.cod_procedencia, hos.HOSpabellon, hos.HOSauge, hos.HOSaccidente, hos.HOSmultires, aug.pauge
				FROM cma.atencion AS hos
				LEFT JOIN paciente.paciente AS pac ON pac.id = hos.id_paciente
				LEFT JOIN camas.medicos AS med ON hos.HOSmedico = med.id
				LEFT JOIN camas.pauge AS aug ON hos.HOSauge = aug.id
				LEFT JOIN paciente.prevision AS prev ON prev.id = hos.PACprevision
				LEFT JOIN acceso.servicio AS ser ON ser.idservicio = hos.idservicio
				LEFT JOIN cma.camas AS cam ON cam.CAMcod = hos.CAMcod
				WHERE hos.HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER DETALLE ATENCION<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function enviaPabellon($link, $HOSid){
		$sql = "UPDATE atencion SET HOSpabellon = 'S' WHERE HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL ENVIAR A PACIENTE A PABELLON<br><br>$sql");
	}
	function regresaPabellon($link, $HOSid){
		$sql = "UPDATE atencion SET HOSpabellon = NULL WHERE HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL ENVIAR A PACIENTE A PABELLON<br><br>$sql");
	}
	function darAlta($link, $HOSid, $destino, $fecha, $hora_ingreso, $minuto_egreso){
		$HOSsalida = $fecha." ".$hora_ingreso.":".$minuto_egreso;
		$sql = "UPDATE atencion SET HOSpabellon = NULL, HOSsalida = '$HOSsalida' WHERE HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL DAR ALTA AL PACIENTE<br><br>$sql");
		$sql = "SELECT * FROM atencion WHERE HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL LEER DATOS ATENCION<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		$sql = "INSERT INTO historial(HOSid, HOSfecha_hospitalizado, CAMcod, id_paciente, PACedad, idservicio, cta_cte,
										cod_procedencia, cod_destino, HOSmedico, HOSdiagnostico1, HOSdiagnostico2, PACprevision,
										HOSingreso, HOSsalida, HOSauge, HOSaccidente, HOSmultires)
								VALUES('$datos[HOSid]','$datos[HOSfecha_hospitalizado]','$datos[CAMcod]','$datos[id_paciente]','$datos[PACedad]','$datos[idservicio]','$datos[cta_cte]',
										'$datos[cod_procedencia]','$destino','$datos[HOSmedico]','$datos[HOSdiagnostico1]','$datos[HOSdiagnostico2]','$datos[PACprevision]',
										'$datos[HOSingreso]','$datos[HOSsalida]','$datos[HOSauge]','$datos[HOSaccidente]','$datos[HOSmultires]')";
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL INSERTAR EN HISTORIAL<br><br>$sql");
		mysql_query("DELETE FROM atencion WHERE HOSid = '$HOSid'") or die(mysql_error("ERROR AL BORRAR REGISTRO DE LA CAMA"));
		mysql_query("UPDATE camas SET CAMestado = 'L'  WHERE CAMcod = '$datos[CAMcod]'") or die(mysql_error("ERROR AL LIBERAR CAMA"));					
	}
	function trasladarPaciente($link, $HOSid, $origen, $origen_desc, $destino, $destino_desc, $fecha, $hora_ingreso, $minuto_egreso){
		$this->darAlta($link, $HOSid, $destino, $fecha, $hora_ingreso, $minuto_egreso);	
		$sql = "SELECT * FROM historial WHERE HOSid = '$HOSid'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL LEER DATOS ATENCION<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		require_once("Conectar.inc");
		$bd = new Conectar; $link = $bd->db_connect();
		$bd->db_select("paciente",$link);
		$sql = "SELECT * FROM paciente WHERE id = '$datos[id_paciente]'";
		mysql_query("SET NAMES utf8");
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL LEER DATOS ATENCION<br><br>$sql");
		$paciente = mysql_fetch_array($resultado);
		$bd->db_select("camas",$link);
		$sql = "INSERT INTO transito_paciente(cta_cte, cod_sscc_desde, desc_sscc_desde, cod_sscc_hasta, desc_sscc_hasta, id_paciente, 
												rut_paciente, ficha_paciente, nom_paciente, tipo_traslado, hospitalizado, fecha, hora, 
												cod_medico, cod_auge, acctransito, multires, diagnostico1, diagnostico2, estado)
										VALUES('$datos[cta_cte]','$origen','$origen_desc','$destino','$destino_desc','$datos[id_paciente]',
												'$paciente[rut]','$paciente[nroficha]','$paciente[nombres] $paciente[apellidopat] $paciente[apellidomat]',
												1,'$datos[HOSfecha_hospitalizado]','$fecha','$hora_ingreso:$minuto_egreso','$datos[HOSmedico]',
												'$datos[HOSauge]','$datos[HOSaccidente]','$datos[HOSmultires]','$datos[HOSdiagnostico1]','$datos[HOSdiagnostico2]',0)";	
		mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL INSERTAR TRANSITO PACIENTES<br><br>$sql");		
	}
	//FIN FUNCIONES HOSPITAL DIA
}
?>