<? class Cama{
	
	function getTipoCama($link){
		$sql = "SELECT TIPCid, TIPCnombre
				FROM tipo_cama
				WHERE TIPgine = 'S'";
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR TIPO DE CAMA <br> $sql <br>".mysql_error());
		return($datos);
	}
	function getTipoCamaEspecifico($link, $codigo){
		$sql = "SELECT TIPCid, TIPCnombre
				FROM tipo_cama
				WHERE TIPCid = '$codigo'";
		$datos = mysql_query($sql) or die ("ERROR AL CARGAR TIPO DE CAMA <br> $sql <br>".mysql_error());
		$resultado = mysql_fetch_array($datos);
		$res = $resultado['TIPCnombre'];	
		return($res);
	}
}
?>