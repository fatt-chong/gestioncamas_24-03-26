<? class Servicio{
	function getDestino($link){
		$sql = "SELECT id, servicio FROM sscc WHERE id > 100";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CARGAR DESTINO DE ALTA<br><br>$sql");
		return $datos;	
	}
	function getTraslados($link){
		$sql = "SELECT id, servicio FROM sscc WHERE id < 45";
		mysql_query("SET NAMES utf8");
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CARGAR DESTINO DE ALTA<br><br>$sql");
		return $datos;	
	}
	function getServicio($link, $servicio){
		$sql = "SELECT id, id_rau, servicio FROM sscc WHERE id = '$servicio'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CARGAR DESTINO DE ALTA<br><br>$sql");
		$datos = mysql_fetch_array($query);
		return $datos;	
	}
	function getServicio_opc($link, $servicio){
		$sql = "SELECT id, id_rau, servicio FROM sscc WHERE id_rau = '$servicio'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CARGAR DESTINO DE ALTA<br><br>$sql");
		$resultado = mysql_fetch_array($query);
		return $resultado;
	}
}
?>