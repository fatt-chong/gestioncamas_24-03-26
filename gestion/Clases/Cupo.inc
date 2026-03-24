<? class Cupo{
	function getResumen($servicio, $link){
		$sql = "SELECT CUPtotal,CUPocupado
				FROM cupo
				WHERE CUPservicio = '$servicio'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER DATOS CUPOS ATENCION<br><br>$sql");
		$datos = mysql_fetch_array($query);
		$sql = "SELECT Count(cma.atencion.HOSid) AS CUPocupado
				FROM cma.atencion";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER CUPOS ocupados ATENCION<br><br>$sql");
		$cupo = mysql_fetch_array($query);
		//CANTIDADES
		$CANtotal = $datos['CUPtotal'];
		$CANocupado = $cupo['CUPocupado'];
		$CANlibre = $CANtotal - $CANocupado;
		//PORCENTAJES
		$PCTtotal = ($CANtotal*100)/$CANtotal;
		$PCTocupado = ($CANocupado*100)/$CANtotal;
		$PCTlibre = (($CANlibre)*100)/$CANtotal;
		$array = array('CANtotal'=>$CANtotal,'PCTtotal'=>$PCTtotal,'CANocupado'=>$CANocupado,'PCTocupado'=>$PCTocupado,'CANlibre'=>$CANlibre,'PCTlibre'=>$PCTlibre);
		return ($array);
	}
	function actualizaCupo($servicio, $link, $operacion){
		$sql = "SELECT CUPtotal, CUPocupado
				FROM cupo
				WHERE CUPservicio = '$servicio'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL CUPOS OCUPADOS<br><br>$sql");
		$datos = mysql_fetch_array($query);
		$CANocupado = $datos['CUPocupado'];
		if($operacion == "agrega")
			$CANocupado++;
		else
			$CANocupado--;
		$sql = "UPDATE cupo SET CUPocupado = '$CANocupado'
				WHERE CUPservicio = '$servicio'";
		$query = mysql_query($sql, $link) or die(mysql_error()."<br><br>ERROR AL ACTUALIZAR CUPOS<br><br>$sql");
	}
}
?>