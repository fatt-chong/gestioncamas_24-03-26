<? class Censo{
	function cargaDatosSession($identificador){
		$lista = $_SESSION['censo_diario'];
		$resultado = $lista[md5($identificador)];
		return ($resultado);
	}
	function marcarEliminado($link, $HOSid){
		$lista = $_SESSION['censo_diario'];
		unset($lista[md5($HOSid)]);
		$_SESSION['censo_diario']=$lista;
		$user_name = $_SESSION['MM_Username'];
		$sql = "UPDATE hospitalizaciones SET censo_eliminado = 'S', usuario_que_elimina = '$user_name'
				WHERE id = '$HOSid'";
		mysql_query($sql) or die("ERROR AL MARCAR COMO ELIMINADO<br> $sql <br>".mysql_error());		
	}
	function actualizaDatosSession($link, $HOSid, $cod_servicio, $servicio, $tipo_cama_cod, $cod_procedencia, $procedencia, $cod_destino, $destino, $fecha_ingreso, $hora_ingreso, $minuto_ingreso, $fecha_egreso, $hora_egreso, $minuto_egreso){
		if(isset($_SESSION['censo_diario']))
			$lista=$_SESSION['censo_diario'];
		else
			$lista = false;
		$fecha_ingreso = cambiarFormatoFecha2($fecha_ingreso);
		$fecha_egreso = cambiarFormatoFecha2($fecha_egreso);
		$hora_1 = $hora_ingreso.":".$minuto_ingreso.":00";
		$hora_2 = $hora_egreso.":".$minuto_egreso.":00";
		require_once("Servicio.inc");
		$objServicio = new Servicio;
		mysql_select_db('acceso');
		$servicio = $objServicio->getServicioEspecifico($link, $cod_servicio);
		mysql_select_db('camas');
		$procedencia = $objServicio->getServicioSSCCEspecifico($link, $cod_procedencia);
		$destino = $objServicio->getServicioSSCCEspecifico($link, $cod_destino);
		require_once("Cama.inc");
		$objCama = new Cama;
		$d_tipo_1 = $objCama->getTipoCamaEspecifico($link, $tipo_cama_cod);
		$lista[md5($HOSid)]=array('identificador'=>md5($HOSid),'HOSid'=>$HOSid,'cod_servicio'=>$cod_servicio,'servicio'=>$servicio,'tipo_1'=>$tipo_cama_cod,'d_tipo_1'=>$d_tipo_1,'cod_procedencia'=>$cod_procedencia,'procedencia'=>$procedencia,
									'fecha_ingreso'=>$fecha_ingreso,'hora_ingreso'=>$hora_1,'cod_destino'=>$cod_destino,'destino'=>$destino,'fecha_egreso'=>$fecha_egreso,
									'hora_egreso'=>$hora_2,'chekeado'=>'SI'); 
		$_SESSION['censo_diario']=$lista;
	}
	function chekeaAltaUltimo(){
		$lista = $_SESSION['censo_diario'];
		$HOSid = end($lista);
		if($lista[md5($HOSid['HOSid'])]['cod_destino'] > 100)
			return true;
		else 
			return false;
	}
	function chekeaMovimiento($link, $HOSid){
		if(isset($_SESSION['censo_diario']))
			$lista=$_SESSION['censo_diario'];
		else
			$lista = false;	
		$objCenso = new Censo;	
		$rowDato = $objCenso->cargaDatosSession($HOSid);
		if($rowDato['chekeado'] == 'SI'){
			$cheked = 'NO';
		}else{
			$cheked = 'SI';
		}
		$lista[md5($HOSid)]=array('identificador'=>md5($HOSid),'HOSid'=>$HOSid,'cod_servicio'=>$rowDato['cod_servicio'],'servicio'=>$rowDato['servicio'],'tipo_1'=>$rowDato['tipo_1'],'d_tipo_1'=>$rowDato['d_tipo_1'],'cod_procedencia'=>$rowDato['cod_procedencia'],'procedencia'=>$rowDato['procedencia'],
									'fecha_ingreso'=>$rowDato['fecha_ingreso'],'hora_ingreso'=>$rowDato['hora_ingreso'],'cod_destino'=>$rowDato['cod_destino'],'destino'=>$rowDato['destino'],'fecha_egreso'=>$rowDato['fecha_egreso'],
									'hora_egreso'=>$rowDato['hora_egreso'],'chekeado'=>$cheked); 
		$_SESSION['censo_diario']=$lista;
	}
	function getUltimoCenso($link, $anio_egreso){
		$anio = $anio_egreso;
		$sql = "SELECT MAX(censo_correlativo) AS max
				FROM hospitalizaciones
				WHERE censo_anio = '$anio'";
		$datos = mysql_query($sql,$link) or die(mysql_error()."<br><br>ERROR AL OBTENER ULTIMO CORRELATIVO<br><br>$sql");
		$resultado = mysql_fetch_array($datos);
		if($resultado['max'] == NULL)
			$resultado['max']=1;
		else
			$resultado['max']+=1;
		return ($resultado['max']);
	}
	function cargaSoloMarcados(){
		if(isset($_SESSION['censo_diario']))
			$lista = $_SESSION['censo_diario'];
		else
			$lista = false;
		foreach($lista as $k => $v){
			if($v['chekeado'] == 'SI')
				$lista_chekeada[] = $v;
		}
		return ($lista_chekeada);
	}
	function verificaOcupado(){
		$lista = $this->cargaSoloMarcados();
		if($lista)
			foreach($lista as $key => $v){
				$HOSid = $v['HOSid'];
				$sql = "SELECT censo_correlativo FROM hospitalizaciones WHERE id = '$HOSid'";
				$datos = mysql_query($sql) or die("ERROR AL CHEKEAR SI EGRESO TIENE CORRELATIVO ASIGNADO<br>$sql<br>".mysql_error());
				$RScorrelativo = mysql_fetch_array($datos);
				if($RScorrelativo['censo_correlativo'] > 0)
					return true;
			}
	}
	function generaCorrelativo($link, $anio_egreso){
		$ultimoCenso = $this->getUltimoCenso($link, $anio_egreso);
		$lista = $this->cargaSoloMarcados();
		if($this->verificaOcupado())
			return false;
		if($lista)
			foreach($lista as $key => $v){
				if($flag_primero != 1){
					$hospitalizado = $v['fecha_ingreso']." ".$v['hora_ingreso'];
					$flag_primero = 1;
				}
				$HOSid = $v['HOSid'];
				$tipo_1=$v['tipo_1'];
				$d_tipo_1=$v['d_tipo_1'];
				$cod_procedencia = $v['cod_procedencia'];
				$procedencia = $v['procedencia'];
				$fecha_ingreso = $v['fecha_ingreso'];
				$hora_ingreso = $v['hora_ingreso'];
				$cod_destino = $v['cod_destino'];
				$destino = $v['destino'];
				$fecha_egreso = $v['fecha_egreso'];
				$hora_egreso = $v['hora_egreso'];
				$user_name = $_SESSION['MM_Username'];
				$sql = "UPDATE hospitalizaciones SET tipo_1 = '$tipo_1', d_tipo_1 = '$d_tipo_1',
												cod_procedencia = '$cod_procedencia', procedencia = '$procedencia', 
												fecha_ingreso = '$fecha_ingreso', hora_ingreso = '$hora_ingreso', cod_destino = '$cod_destino', 
												destino = '$destino', fecha_egreso = '$fecha_egreso', hora_egreso = '$hora_egreso', 
												hospitalizado = '$hospitalizado', censo_correlativo = '$ultimoCenso', usuario_censo = '$user_name'
												WHERE id = '$HOSid'";
				mysql_query($sql) or die("ERROR AL CORRELATIVO<br> $sql <br>".mysql_error());
				/*	
				$sqldos = "UPDATE hospitalizaciones, (
					SELECT
					h.cta_cte
					FROM
					camas.hospitalizaciones as h
					WHERE
					h.id = '$HOSid'
				) as datos
				SET camas.hospitalizaciones.censo_anio = YEAR(curdate())
				WHERE
				hospitalizaciones.cta_cte IN (datos.cta_cte)";	
				mysql_query($sqldos) or die("ERROR AL CORRELATIVO<br> $sqldos <br>".mysql_error());		
				*/										
			}
			$arrayDatos['correlativoGenerado'] = $ultimoCenso;
			$arrayDatos['hospitalizadoActualizado'] = $hospitalizado;
		return ($arrayDatos);
	}
	function grabarEnProduccion($correlativo, $link){
		require_once("Produccion.inc");
		$objProduccion = new Produccion;
		$sql = "SELECT id, que_cod_servicio, que_servicio, tipo_1, tipo_2 FROM hospitalizaciones WHERE censo_correlativo = '$correlativo'";
		$datos = mysql_query($sql, $link) or die("ERROR AL OBTENER DATOS DE HOSPITALICACION CON CORRELATIVO<br>$sql<br>".mysql_error());
		while($RScorrelativo = mysql_fetch_array($datos)){
			$PREcod = $objProduccion->getCodigoPrestacion($RScorrelativo['tipo_1'], $RScorrelativo['tipo_2']);
			$objProduccion->cargaDiaCama($RScorrelativo['id'], $PREcod, $link);
		}
	}
	function getCorrelativo($id_paciente, $hospitalizado){
		$sql = "SELECT censo_correlativo 
				FROM hospitalizaciones
				WHERE id_paciente = '$id_paciente'
				AND hospitalizado = '$hospitalizado'";
		$resultado = mysql_query($sql) or die("ERROR AL OBTENER CORRELATIVO<br> $sql <br>".mysql_error());
		$datos = mysql_fetch_array($resultado);
		return ($datos);
	}
	function getRangoFechasCenso($link, $correlativo, $hospitalizado){
		$sql = "SELECT censo_correlativo, id, fecha_ingreso, fecha_egreso 
				FROM hospitalizaciones
				WHERE censo_correlativo = '$correlativo' and YEAR(fecha_ingreso) = YEAR(LEFT('$hospitalizado', 10)) ";
		$resultado = mysql_query($sql, $link) or die("ERROR AL OBTENER CORRELATIVO<br> $sql <br>".mysql_error());
		$cantidad_registro = mysql_num_rows($resultado);
		$cont=1;
		while($datos = mysql_fetch_array($resultado)){
			if($cont == 1)
				$arrayFechas['inicio'] = $datos['fecha_ingreso'];
			if($cont == $cantidad_registro)
				$arrayFechas['final'] = $datos['fecha_egreso'];
			$cont++;
		}
		return ($arrayFechas);
	}
}
?>