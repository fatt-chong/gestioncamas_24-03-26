<? class claseCamas{
	
	function listarEgresos($servicio){
		require_once ('coneccionCamas.inc');
		$bd= new coneccionCamas; $link=$bd->db_connect();
		$sql = "SELECT
				hospitalizaciones.id,
				hospitalizaciones.id_paciente,
				hospitalizaciones.camaSN,
				hospitalizaciones.rut_paciente,
				hospitalizaciones.ficha_paciente,
				hospitalizaciones.nom_paciente,
				hospitalizaciones.sexo_paciente,
				hospitalizaciones.servicio,
				DATE_FORMAT(hospitalizaciones.fecha_egreso,'%d-%m-%Y') as fecha_egreso,
				hospitalizaciones.estadoFicha
				FROM hospitalizaciones
				WHERE
				hospitalizaciones.cod_servicio = $servicio AND
				hospitalizaciones.fecha_egreso >='2015-03-01' AND
				hospitalizaciones.cod_destino > 100
				AND hospitalizaciones.estadoFicha = 'N' AND
				hospitalizaciones.camaSN IS NULL"; //echo $sql;
		mysql_query("SET NAMES utf8"); 
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SERVICIOS<br>");
		return ($query);
	}
	function listarEgresosCamasSn(){
		require_once ('coneccionCamas.inc');
		$bd= new coneccionCamas; $link=$bd->db_connect();
		$sql = "SELECT
				hospitalizaciones.id,
				hospitalizaciones.id_paciente,
				hospitalizaciones.camaSN,
				hospitalizaciones.rut_paciente,
				hospitalizaciones.ficha_paciente,
				hospitalizaciones.nom_paciente,
				hospitalizaciones.sexo_paciente,
				hospitalizaciones.servicio,
				DATE_FORMAT(hospitalizaciones.fecha_egreso,'%d-%m-%Y') as fecha_egreso,
				hospitalizaciones.estadoFicha
				FROM hospitalizaciones
				WHERE
				hospitalizaciones.fecha_egreso >='2015-03-01' AND
				hospitalizaciones.cod_destino > 100
				AND hospitalizaciones.estadoFicha = 'N' AND
				hospitalizaciones.camaSN IS NOT NULL"; //echo $sql;
		mysql_query("SET NAMES utf8"); 
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SERVICIOS<br>");
		return ($query);
	}
	function canRegistro($servicio){
		require_once ('coneccionCamas.inc');
		$bd= new coneccionCamas; $link=$bd->db_connect();
		$sql = "SELECT
					Count(hospitalizaciones.id) as cantRegistro
					FROM `hospitalizaciones`
					WHERE
					hospitalizaciones.cod_servicio = $servicio AND
					hospitalizaciones.fecha_egreso >='2015-03-01' AND
					hospitalizaciones.cod_destino > 100 
					AND hospitalizaciones.estadoFicha = 'N' and hospitalizaciones.ficha_paciente>0
					AND hospitalizaciones.camaSN IS NULL"; //echo $sql;
		mysql_query("SET NAMES utf8"); 
		$resultado= mysql_query($sql,$link);
		 $contador= mysql_fetch_array($resultado);
		 $ban=$contador[0];
		return ($ban);
	}
	
	function canRegistroCamasSN(){
		require_once ('coneccionCamas.inc');
		$bd= new coneccionCamas; $link=$bd->db_connect();
		$sql = "SELECT
					Count(hospitalizaciones.id) as cantRegistro
					FROM `hospitalizaciones`
					WHERE
					hospitalizaciones.fecha_egreso >='2015-03-01' AND
					hospitalizaciones.cod_destino > 100 
					AND hospitalizaciones.estadoFicha = 'N' 
					and hospitalizaciones.ficha_paciente>0
					AND hospitalizaciones.camaSN IS NOT NULL"; //echo $sql;
		mysql_query("SET NAMES utf8"); 
		$resultado= mysql_query($sql,$link);
		 $contador= mysql_fetch_array($resultado);
		 $ban=$contador[0];
		return ($ban);
	}
	
	/*function actualiza_estado_ficha_camas($idCamas){
			require_once ('../coneccion/conCamas.inc');
		  $bd= new conCamas; $link=$bd->db_connect();
			$sql="UPDATE hospitalizaciones  SET 
						  hospitalizaciones.estadoFicha='R'
			              WHERE hospitalizaciones.id =$idCamas"; 	
			mysql_query($sql,$link); //echo $sql;
		
		}
	function reversa_actualiza_estado_ficha_camas($idCamas){
			require_once ('../coneccion/conCamas.inc');
		  $bd= new conCamas; $link=$bd->db_connect();
			$sql="UPDATE hospitalizaciones  SET 
						  hospitalizaciones.estadoFicha='N'
			              WHERE hospitalizaciones.id =$idCamas"; 	
			mysql_query($sql,$link); //echo $sql;
		
		}	
		
		function logAcciones($idHosp,$usuario,$accion,$fecha,$estado){
			require_once ('../coneccion/conCamas.inc');
		  $bd= new conCamas; $link=$bd->db_connect();
			$sql = "INSERT INTO  logFichasEgresos (
				          logFichasEgresos.usuario,
						  logFichasEgresos.accion,
						  logFichasEgresos.fecha,
						  logFichasEgresos.id_hospitalizacion,
						  logFichasEgresos.estado
						  )
					  VALUES ('$usuario','$accion','$fecha',$idHosp,'$estado')";	//echo $sql;
      	  	     	mysql_query("SET NAMES 'utf8'");
					mysql_query($sql,$link);
		
		}	
	*/
	
		
}
?>