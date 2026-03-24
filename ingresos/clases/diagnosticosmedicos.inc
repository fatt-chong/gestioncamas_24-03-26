<? 
class diagnosticosmedicos
{
	
	function nuevodiagnostico($link, $diagnostico, $ctacte, $usuario)
	{
		$sql="INSERT INTO epicrisis.diagnostico_medico (dm_ctacte, dm_diagnostico, dm_fecha, dm_usuario) values($ctacte, '".$diagnostico."', NOW(), '".$usuario."')";
		mysql_query("SET NAMES utf8"); //echo $sql;
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL insertar registro<br>");
	}
	function buscadiagnosticos($link, $ctacte)
	{
		$sql="SELECT dm_id, dm_diagnostico, dm_principal FROM epicrisis.diagnostico_medico WHERE dm_ctacte = $ctacte";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL buscar diagnostico<br>$sql");
		return ($query);
	}
	function eliminadiagnostico($link, $idelimina, $usuario)
	{
		//insertamos en la bd log
		$sql="INSERT INTO bdlog.logdiagnostico_medico (ldm_fecha, ldm_usuario, ldm_tipo, ldm_dm_id, ldm_dm_ctacte, ldm_dm_diagnostico, ldm_dmfecha, ldm_dm_usuario) 
		SELECT NOW() as ldm_fecha, '".$usuario."' as ldm_usuario, 'E' as ldm_tipo, $idelimina as ldm_dm_id, dm_ctacte, dm_diagnostico, dm_fecha, dm_usuario FROM epicrisis.diagnostico_medico WHERE dm_id = $idelimina";
		mysql_query("SET NAMES utf8"); //echo $sql;
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL guardar en log al actualizar<br>");

		//elimina diagnostico de control_agenda
		$sql3="UPDATE epicrisis.control_agenda SET CA_Diagnostico = NULL WHERE control_agenda.CA_Id IN(
																					SELECT CA_Id FROM(
																					SELECT
																					control_agenda.CA_Id
																					FROM
																					epicrisis.control_agenda
																					INNER JOIN epicrisis.diagnostico_medico ON control_agenda.CA_Ctacte = diagnostico_medico.dm_ctacte AND diagnostico_medico.dm_ctacte <> '' AND control_agenda.CA_Diagnostico = diagnostico_medico.dm_diagnostico
																					WHERE diagnostico_medico.dm_id = $idelimina) as consulta)";
		mysql_query("SET NAMES utf8");
		$query3 = mysql_query($sql3,$link) or die(mysql_error()."<br>ERROR AL eliminar eliminadiagnostico control<br>");
		
		// elimina dato de la bd epicrisis
		$sql2="DELETE FROM epicrisis.diagnostico_medico WHERE dm_id = $idelimina";
		mysql_query("SET NAMES utf8");
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL eliminar diagnostico<br>");
		return ($query2);
		
	}
	function actualizadiagnostico($link, $idactualiza, $diagnosticoactualiza, $usuario)
	{
		// guarda registro lantiguo en la BD log
		$sql="INSERT INTO bdlog.logdiagnostico_medico (ldm_fecha, ldm_usuario, ldm_tipo, ldm_dm_id, ldm_dm_ctacte, ldm_dm_diagnostico, ldm_dmfecha, ldm_dm_usuario) 
		SELECT NOW() as ldm_fecha, '".$usuario."' as ldm_usuario, 'M' as ldm_tipo, $idactualiza as ldm_dm_id, dm_ctacte, dm_diagnostico, dm_fecha, dm_usuario FROM epicrisis.diagnostico_medico WHERE dm_id = $idactualiza";
		mysql_query("SET NAMES utf8"); //echo $sql;
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL guardar en log al actualizar<br>");

		//actualiza datos en la tabla BD de epicrisis	
		$sql2="UPDATE epicrisis.diagnostico_medico SET dm_diagnostico = '".$diagnosticoactualiza."', dm_fecha = NOW(), dm_usuario = '".$usuario."' WHERE dm_id = $idactualiza";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL actualizar diagnostico<br>");
	}
	function asignardiagnosticoprincipal($link, $idactualiza, $diagnosticoactualiza, $usuario, $ctacte)
	{
		$sql="UPDATE epicrisis.epicrisismedica SET epimedDiag = '".$diagnosticoactualiza."' WHERE epimedCtacte = $ctacte";
		mysql_query("SET NAMES utf8"); //echo $sql;
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL actualizar diagnostico<br>");

		//actualiza datos en la tabla BD de epicrisis	
		$sql1="UPDATE epicrisis.diagnostico_medico SET dm_principal = NULL WHERE dm_ctacte = $ctacte";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query1 = mysql_query($sql1,$link) or die(mysql_error()."<br>ERROR AL actualizar diagnostico<br>");
		
		$sql2="UPDATE epicrisis.diagnostico_medico SET dm_principal = 'P' WHERE dm_id = $idactualiza";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL actualizar diagnostico<br>");
	}
	function nuevocontrolinterconsulta($link, $CA_Ctacte, $CA_Diagnostico, $CA_Fundamento, $CA_INTespecialidad_destino, $CA_INTperiodo_control, $CA_IdPaciente, $CA_INTmedico_tratante, $CA_UsuarioDigita, $usuario_actual){
		$sql="INSERT INTO epicrisis.control_agenda(CA_Ctacte,CA_Diagnostico,CA_Fundamento,CA_INTespecialidad_destino,CA_INTperiodo_control,CA_IdPaciente,CA_INTmedico_tratante,CA_UsuarioDigita,CA_FechaDigita,CA_idUsuarioDigita)values('$CA_Ctacte','$CA_Diagnostico','$CA_Fundamento','$CA_INTespecialidad_destino','$CA_INTperiodo_control','$CA_IdPaciente','$CA_INTmedico_tratante','$CA_UsuarioDigita',NOW(),'$usuario_actual')";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL guardar nuevocontrol<br>");
	}
	function buscarcontroles($link, $ctacte){
		$sql="SELECT
				epicrisis.control_agenda.CA_Id,
				epicrisis.control_agenda.CA_Diagnostico,
				CASE				
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '1' THEN '1 Semana'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '2' THEN '2 Semana'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '3' THEN '3 Semana'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '4' THEN '1 Mes'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '8' THEN '2 Meses'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '12' THEN '3 Meses'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '16' THEN '4 Meses'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '20' THEN '5 Meses'
					WHEN epicrisis.control_agenda.CA_INTperiodo_control = '24' THEN '6 Meses'
				END
				AS 'CA_INTperiodo_control',
				parametros_clinicos.especialidad.ESPdescripcion,
				parametros_clinicos.especialidad.ESPcodigo
				FROM
				epicrisis.control_agenda
				INNER JOIN parametros_clinicos.especialidad ON epicrisis.control_agenda.CA_INTespecialidad_destino = parametros_clinicos.especialidad.ESPcodigo
				WHERE
				epicrisis.control_agenda.CA_Ctacte = '$ctacte'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL buscar buscarcontroles<br>");
		return ($query);
	}
	function buscarcontrolescompletos($link, $ctacte){
		$sql="SELECT *
				FROM
				epicrisis.control_agenda
				INNER JOIN parametros_clinicos.especialidad ON epicrisis.control_agenda.CA_INTespecialidad_destino = parametros_clinicos.especialidad.ESPcodigo
				INNER JOIN parametros_clinicos.profesional ON epicrisis.control_agenda.CA_INTmedico_tratante = parametros_clinicos.profesional.PROcodigo AND epicrisis.control_agenda.CA_INTmedico_tratante<>''
				WHERE
				epicrisis.control_agenda.CA_Ctacte = '$ctacte'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL buscar buscarcontrolescompletos<br>");
		return ($query);
	}
	function eliminacontrolinterconsulta($link, $idelimina, $usuario){

		$sql2="DELETE FROM epicrisis.control_agenda WHERE CA_Id = $idelimina";
		mysql_query("SET NAMES utf8");
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL eliminar eliminacontrolinterconsulta<br>");
		return ($query2);
	}
	function eliminarcontrolesinterconsultas($link, $ctacte){

		$sql2="DELETE FROM epicrisis.control_agenda WHERE CA_Ctacte = $ctacte";
		mysql_query("SET NAMES utf8");
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL eliminar eliminarcontrolesinterconsultas<br>");
		return ($query2);
	}
	function actualizacontrolinterconsulta($link, $CA_Id, $diagnosticoactualiza){
		$sql2="UPDATE epicrisis.control_agenda SET CA_Diagnostico = '".$diagnosticoactualiza."' WHERE CA_Id = $CA_Id";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL actualizar actualizacontrolinterconsulta<br>");
	}
	function registraidinterconsulta($link, $CA_Id, $CA_IdInterconsulta, $CA_UsuarioAlta, $usuario_actual){
		$sql2="UPDATE epicrisis.control_agenda SET CA_INTcodigo = '".$CA_IdInterconsulta."', CA_UsuarioAlta = '".$CA_UsuarioAlta."', CA_FechaAlta = NOW(), CA_idUsuarioAlta = '".$usuario_actual."' WHERE CA_Id = $CA_Id";
		mysql_query("SET NAMES utf8"); //echo $sql2;
		$query2 = mysql_query($sql2,$link) or die(mysql_error()."<br>ERROR AL actualizar registraidinterconsulta<br>");
	}
}
?>