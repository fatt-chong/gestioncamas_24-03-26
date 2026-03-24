<? class Servicio{
	
	function getServicioAbierta($link){
		$sql = "SELECT servicio.idservicio,	servicio.nombre
				FROM servicio
				WHERE servicio.rayos = 'S'
				ORDER BY servicio.nombre";
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR ESPECIALIDADES <br> $sql <br>".mysql_error());
		return($datos);
	}
	function getServicioCerrada($link){
		$sql = "SELECT servicio.idservicio, servicio.nombre, servicio.id
				FROM servicio
				WHERE servicio.id IS NOT NULL
				AND id <= 45";
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR SERVICIOS CLINICOS <br> $sql <br>".mysql_error());
		return($datos);
	}
	function getServicioEspecifico($link, $cod_servicio){
		$sql = "SELECT s.id, s.nombre
				FROM servicio AS s
				WHERE s.id = '$cod_servicio'";
		mysql_query("SET NAMES utf8");//PARA ARREGLAR PROBLEMA DE ACENTOS
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR SSCC <br> $sql <br>".mysql_error());
		$resultado = mysql_fetch_array($datos);
		$servicio = $resultado['nombre'];
		return($servicio);
	}	
	function getServicioSSCC($link,$opcion){
		if($opcion == 1)
			$sql = "SELECT s.id, s.servicio	FROM sscc AS s WHERE s.id < 100 ORDER BY s.orden";
		else
			$sql = "SELECT s.id, s.servicio	FROM sscc AS s where s.id IN (101, 102) or (s.id >=110 and s.id <= 115) or  s.id <= 45 ORDER BY s.orden";
		mysql_query("SET NAMES utf8");//PARA ARREGLAR PROBLEMA DE ACENTOS
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR SSCC <br> $sql <br>".mysql_error());
		return($datos);
	}
	function getServicioSSCCEspecifico($link, $cod_servicio){
		$sql = "SELECT s.id, s.servicio
				FROM sscc AS s
				WHERE s.id = '$cod_servicio'";
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR SSCC <br> $sql <br>".mysql_error());
		$resultado = mysql_fetch_array($datos);
		$servicio = $resultado['servicio'];
		return($servicio);
	}
	function getServicioPertenece($link, $pacId, $hospitalizado, $correlativo){
		$sql = "SELECT MIN(h.id) AS id, h.que_cod_servicio
				FROM hospitalizaciones AS h
				WHERE h.id_paciente = '$pacId'
				AND h.hospitalizado = '$hospitalizado'
				AND h.censo_correlativo = '$correlativo'
				AND h.censo_eliminado IS NULL
				GROUP BY h.hospitalizado";
		$resultado = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL LEER EL PRIMER ID HOSPITALIZACION<br><br>$sql");
		$ultimo = mysql_fetch_array($resultado);
		$id = $ultimo['id'];
		$sql2 = "SELECT que_cod_servicio
				FROM hospitalizaciones AS h
				WHERE h.id = '$id'";
		$resultado = mysql_query($sql2,$link) or die(mysql_error()."<br><br>ERROR AL LEER DATOS HOSPITALIZACION PRIMER QUE COD SERVICIO<br><br>$sql");
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}	
	
}
?>