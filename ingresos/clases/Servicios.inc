<? class Servicios{
	
	function nombreCR($link,$idservicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
			camas.sscc.id,
			camas.sscc.servicio,
			acceso.cr.nombre
			FROM
			camas.sscc
			INNER JOIN acceso.cr ON camas.sscc.id_cr = acceso.cr.idcr
			WHERE 
			camas.sscc.id = $idservicio";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SERVICIOS<br>");
		$RSquery = mysql_fetch_assoc($query);
		return ($RSquery);
		}
		
	function listarServicios($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				id, servicio,id_rau,
				@curRow := @curRow + 1 AS row_number				
				FROM sscc JOIN  (SELECT @curRow := -1) r
				WHERE id <= 46 and sscc.ver = 1
				ORDER BY id";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SERVICIOS<br>");
		return ($query);
	}
	
	function listarServiciosEgreso($link){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				id, servicio			
				FROM sscc
				id IN (101, 102) or (id >=110 and id <= 115)";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SERVICIOS<br>");
		return ($query);
	}
	
	function homologaServicio($link, $idServicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				sscc.id,
				sscc.id_rau,
				sscc.servicio
				FROM sscc
				WHERE id_rau = $idServicio";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HOMOLOGAR SERVICIOS<br>");
		$RSquery = mysql_fetch_assoc($query);
		$servicioId = $RSquery['id'];
		return ($servicioId);
		}
		
	function queServicio($link,$idServicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				id, servicio
				FROM sscc
				WHERE id = $idServicio";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die($sql."<br>ERROR AL OBTENER EL QUE SERVICIOS<br>".mysql_error());
		$RSquery = mysql_fetch_assoc($query);
		$servicioNom = $RSquery['servicio'];
		return ($servicioNom);
		}
		
	function homologaServicio2($link,$idServicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				sscc.id,
				sscc.id_rau,
				sscc.servicio
				FROM sscc
				WHERE id = '$idServicio'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HOMOLOGAR2 SERVICIOS<br>".$sql);
		$RSquery = mysql_fetch_assoc($query);
		return ($RSquery);
		}
	function trasladoServicio($link,$idCama,$cod_destino,$nom_destino,$fechaEgreso,$horaEgreso,$infoEgreso,$que_cod_servicio,$que_servicio,$servicio,$cod_servicio,$sala,$cama,$tipo_1,$d_tipo_1,$tipo_2,$d_tipo_2,$cta_cte,$cod_procedencia,$procedencia,$cod_medico,$medico,$cod_auge,$auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$rut_paciente,$ficha_paciente,$esta_ficha,$nom_paciente,$sexo_paciente,$edad_paciente,$cod_prevision,$prevision,$direc_paciente,$cod_comuna,$comuna,$fono1_paciente,$fono2_paciente,$fono3_paciente,$categorizacion_riesgo,$categorizacion_dependencia,$hospitalizado,$fecha_ingreso,$hora_ingreso,$usuario_que_ingresa,$usuario_que_egresa,$fecha_usuario_ingresa,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$cod_pad,$barthel,$tipoNeuro,$barthelegreso){
		
		require_once('Conectar.inc'); 
		
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		require_once('Paciente.inc'); 
		$objPaciente = new Paciente;
		
		require_once('Camas.inc');
		$objCamas = new Camas;
		
		$anio_actual = date('Y');
		$fecha_actual = date("Y-m-d H:i:s");
		
		if($barthel==''){
			$varBarthel = "NULL";
		}else{
			$varBarthel = "$barthel";
		}
		if($barthelegreso==''){
			$barthelegreso = "NULL";
		}else{
			$barthelegreso = $barthelegreso;
		}
		
		$sql = "INSERT INTO hospitalizaciones
					(tipo_traslado,
					que_cod_servicio,
					que_servicio,
					servicio,
					cod_servicio,
					id_cama,
					sala,
					cama,
					tipo_1,
					d_tipo_1,
					tipo_2,
					d_tipo_2,
					cta_cte,
					cod_procedencia,
					procedencia,
					cod_destino,
					destino,
					cod_medico,
					medico,
					cod_auge,
					auge,
					acctransito,
					multires,
					diagnostico1,
					diagnostico2,
					id_paciente,
					rut_paciente,
					ficha_paciente,
					esta_ficha,
					nom_paciente,
					sexo_paciente,
					edad_paciente,
					cod_prevision,
					prevision,
					direc_paciente,
					cod_comuna,
					comuna,
					fono1_paciente,
					fono2_paciente,
					fono3_paciente,
					categorizacion_riesgo,
					categorizacion_dependencia,
					hospitalizado,
					fecha_ingreso,
					hora_ingreso,
					fecha_egreso,
					hora_egreso,
					info_egreso,
					censo_anio,
					usuario_que_ingresa,
					usuario_que_egresa,
					fecha_usuario_ingreso,
					fecha_usuario_egreso,
					id_parto,
					folio_pad,
					tipo_cama,
					tipo_paciente,
					cod_pad,
					barthel,
					neurologico,
					barthelegreso)
					VALUES
					(2,
					$que_cod_servicio,
					'$que_servicio',
					'$servicio',
					$cod_servicio,
					$idCama,
					'$sala',
					'$cama',
					'$tipo_1',
					'$d_tipo_1',
					'$tipo_1',
					'$d_tipo_2',
					$cta_cte,
					$cod_procedencia,
					'$procedencia',
					$cod_destino,
					'$nom_destino',
					$cod_medico,
					'$medico',
					$cod_auge,
					'$auge',
					'$acctransito',
					'$multires',
					'$diagnostico1',
					'$diagnostico2',
					'$id_paciente',
					'$rut_paciente',
					$ficha_paciente,
					$esta_ficha,
					'$nom_paciente',
					'$sexo_paciente',
					'$edad_paciente',
					$cod_prevision,
					'$prevision',
					'$direc_paciente',
					$cod_comuna,
					'$comuna',
					'$fono1_paciente',
					'$fono2_paciente',
					'$fono3_paciente',
					'$categorizacion_riesgo',
					'$categorizacion_dependencia',
					'$hospitalizado',
					'$fecha_ingreso',
					'$hora_ingreso',
					'$fechaEgreso',
					'$horaEgreso',
					'$infoEgreso',
					'$anio_actual',
					'$usuario_que_ingresa',
					'$usuario_que_egresa',
					'$fecha_usuario_ingresa',
					'$fecha_actual',
					$id_parto,
					'$folio_pad',
					'$tipo_cama',
					'$tipo_paciente',
					'$cod_pad',
					".$varBarthel.",
					'$tipoNeuro',
					".$barthelegreso.")"; //echo $sql;
				$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR EN TABLA HOSPITALIZACIONES, TRASLADO PACIENTE ".mysql_error());
				
				$pacienteTransito = $objPaciente->insertaTransitoPaciente($link,$cod_destino,$nom_destino,$que_cod_servicio,$que_servicio,$servicio,$cod_servicio,$cta_cte,$cod_procedencia,$procedencia,'',$cod_medico,$medico,$cod_auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$rut_paciente,$ficha_paciente,$nom_paciente,2,$hospitalizado,$fechaEgreso,$horaEgreso,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$codPad,$barthel,'',$tipoNeuro,$barthelegreso);
				
				$desocupaCama = $objCamas->vaciarCama($link,$idCama,$cod_servicio,$servicio);
				
				return ($desocupaCama.$pacienteTransito.$query);
		}	
		
		function insertHospitaliza(
	$link,$idCama,$cod_destino,$nom_destino,$fechaEgreso,$horaEgreso,$infoEgreso,$que_cod_servicio,$que_servicio,$servicio,$cod_servicio,$sala,$cama,$tipo_1,$d_tipo_1,$tipo_2,$d_tipo_2,$cta_cte,$cod_procedencia,$procedencia,$cod_medico,$medico,$cod_auge,$auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$rut_paciente,$ficha_paciente,$esta_ficha,$nom_paciente,$sexo_paciente,$edad_paciente,$cod_prevision,$prevision,$direc_paciente,$cod_comuna,$comuna,$fono1_paciente,$fono2_paciente,$fono3_paciente,$categorizacion_riesgo,$categorizacion_dependencia,$hospitalizado,$fecha_ingreso,$hora_ingreso,$usuario_que_ingresa,$usuario_que_egresa,$fecha_usuario_ingresa,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$cod_pad,$barthel,$tipoNeuro){
		
		require_once('Conectar.inc'); 
		
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
				
		$anio_actual = date('Y');
		$fecha_actual = date("Y-m-d H:i:s");
		
		if($barthel==''){
			$varBarthel = "NULL";
			}else{
				$varBarthel = "$barthel";
				}
		
		$sql = "INSERT INTO hospitalizaciones
					(tipo_traslado,
					que_cod_servicio,
					que_servicio,
					servicio,
					cod_servicio,
					id_cama,
					sala,
					cama,
					tipo_1,
					d_tipo_1,
					tipo_2,
					d_tipo_2,
					cta_cte,
					cod_procedencia,
					procedencia,
					cod_destino,
					destino,
					cod_medico,
					medico,
					cod_auge,
					auge,
					acctransito,
					multires,
					diagnostico1,
					diagnostico2,
					id_paciente,
					rut_paciente,
					ficha_paciente,
					esta_ficha,
					nom_paciente,
					sexo_paciente,
					edad_paciente,
					cod_prevision,
					prevision,
					direc_paciente,
					cod_comuna,
					comuna,
					fono1_paciente,
					fono2_paciente,
					fono3_paciente,
					categorizacion_riesgo,
					categorizacion_dependencia,
					hospitalizado,
					fecha_ingreso,
					hora_ingreso,
					fecha_egreso,
					hora_egreso,
					info_egreso,
					censo_anio,
					usuario_que_ingresa,
					usuario_que_egresa,
					fecha_usuario_ingreso,
					fecha_usuario_egreso,
					id_parto,
					folio_pad,
					tipo_cama,
					tipo_paciente,
					cod_pad,
					barthel,
					neurologico)
					VALUES
					(2,
					$que_cod_servicio,
					'$que_servicio',
					'$servicio',
					$cod_servicio,
					$idCama,
					'$sala',
					'$cama',
					'$tipo_1',
					'$d_tipo_1',
					'$tipo_1',
					'$d_tipo_2',
					$cta_cte,
					$cod_procedencia,
					'$procedencia',
					$cod_destino,
					'$nom_destino',
					$cod_medico,
					'$medico',
					$cod_auge,
					'$auge',
					'$acctransito',
					'$multires',
					'$diagnostico1',
					'$diagnostico2',
					'$id_paciente',
					'$rut_paciente',
					$ficha_paciente,
					$esta_ficha,
					'$nom_paciente',
					'$sexo_paciente',
					'$edad_paciente',
					$cod_prevision,
					'$prevision',
					'$direc_paciente',
					$cod_comuna,
					'$comuna',
					'$fono1_paciente',
					'$fono2_paciente',
					'$fono3_paciente',
					'$categorizacion_riesgo',
					'$categorizacion_dependencia',
					'$hospitalizado',
					'$fecha_ingreso',
					'$hora_ingreso',
					'$fechaEgreso',
					'$horaEgreso',
					'$infoEgreso',
					'$anio_actual',
					'$usuario_que_ingresa',
					'$usuario_que_egresa',
					'$fecha_usuario_ingresa',
					'$fecha_actual',
					$id_parto,
					'$folio_pad',
					'$tipo_cama',
					'$tipo_paciente',
					'$cod_pad',
					".$varBarthel.",
					'$tipoNeuro')";
				$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR EN TABLA HOSPITALIZACIONES, TRASLADO PACIENTE ".mysql_error());
			}	
		
		function egresoServicio(
	$link,$idCama,$cod_destino,$nom_destino,$fechaEgreso,$horaEgreso,$infoEgreso,$que_cod_servicio,$que_servicio,$servicio,$cod_servicio,$sala,$cama,$tipo_1,$d_tipo_1,$tipo_2,$d_tipo_2,$cta_cte,$cod_procedencia,$procedencia,$cod_medico,$medico,$cod_auge,$auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$rut_paciente,$ficha_paciente,$esta_ficha,$nom_paciente,$sexo_paciente,$edad_paciente,$cod_prevision,$prevision,$direc_paciente,$cod_comuna,$comuna,$fono1_paciente,$fono2_paciente,$fono3_paciente,$categorizacion_riesgo,$categorizacion_dependencia,$hospitalizado,$fecha_ingreso,$hora_ingreso,$usuario_que_ingresa,$usuario_que_egresa,$fecha_usuario_ingresa,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$cod_pad,$barthel,$tipoNeuro,$barthelegreso){
		
		require_once('Conectar.inc'); 
		
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		require_once('Paciente.inc'); 
		$objPaciente = new Paciente;
		
		require_once('Camas.inc');
		$objCamas = new Camas;
		
		$anio_actual = date('Y');
		$fecha_actual = date("Y-m-d H:i:s");
		
		if($barthel==''){
			$varBarthel = "NULL";
			}else{
				$varBarthel = "$barthel";
				}
		if($barthelegreso==''){
			$barthelegreso = "NULL";
		}else{
			$barthelegreso = $barthelegreso;
		}
		
		$sql = "INSERT INTO hospitalizaciones
					(tipo_traslado,
					que_cod_servicio,
					que_servicio,
					servicio,
					cod_servicio,
					id_cama,
					sala,
					cama,
					tipo_1,
					d_tipo_1,
					tipo_2,
					d_tipo_2,
					cta_cte,
					cod_procedencia,
					procedencia,
					cod_destino,
					destino,
					cod_medico,
					medico,
					cod_auge,
					auge,
					acctransito,
					multires,
					diagnostico1,
					diagnostico2,
					id_paciente,
					rut_paciente,
					ficha_paciente,
					esta_ficha,
					nom_paciente,
					sexo_paciente,
					edad_paciente,
					cod_prevision,
					prevision,
					direc_paciente,
					cod_comuna,
					comuna,
					fono1_paciente,
					fono2_paciente,
					fono3_paciente,
					categorizacion_riesgo,
					categorizacion_dependencia,
					hospitalizado,
					fecha_ingreso,
					hora_ingreso,
					fecha_egreso,
					hora_egreso,
					info_egreso,
					censo_anio,
					usuario_que_ingresa,
					usuario_que_egresa,
					fecha_usuario_ingreso,
					fecha_usuario_egreso,
					id_parto,
					folio_pad,
					tipo_cama,
					tipo_paciente,
					cod_pad,
					barthel,
					neurologico,
					barthelegreso)
					VALUES
					($cod_destino,
					$que_cod_servicio,
					'$que_servicio',
					'$servicio',
					$cod_servicio,
					$idCama,
					'$sala',
					'$cama',
					'$tipo_1',
					'$d_tipo_1',
					'$tipo_1',
					'$d_tipo_2',
					$cta_cte,
					$cod_procedencia,
					'$procedencia',
					$cod_destino,
					'$nom_destino',
					$cod_medico,
					'$medico',
					$cod_auge,
					'$auge',
					'$acctransito',
					'$multires',
					'$diagnostico1',
					'$diagnostico2',
					'$id_paciente',
					'$rut_paciente',
					$ficha_paciente,
					'$esta_ficha',
					'$nom_paciente',
					'$sexo_paciente',
					'$edad_paciente',
					$cod_prevision,
					'$prevision',
					'$direc_paciente',
					$cod_comuna,
					'$comuna',
					'$fono1_paciente',
					'$fono2_paciente',
					'$fono3_paciente',
					'$categorizacion_riesgo',
					'$categorizacion_dependencia',
					'$hospitalizado',
					'$fecha_ingreso',
					'$hora_ingreso',
					'$fechaEgreso',
					'$horaEgreso',
					'$infoEgreso',
					'$anio_actual',
					'$usuario_que_ingresa',
					'$usuario_que_egresa',
					'$fecha_usuario_ingresa',
					'$fecha_actual',
					$id_parto,
					'$folio_pad',
					'$tipo_cama',
					'$tipo_paciente',
					'$cod_pad',
					".$varBarthel.",
					'$tipoNeuro',
					'".$barthelegreso."')";
				$query = mysql_query($sql,$link) or die("ERROR AL INSERTAR EN TABLA HOSPITALIZACIONES, EGRESO PACIENTE".mysql_error());

				$desocupaCama = $objCamas->vaciarCama($link,$idCama,$cod_servicio,$servicio);
				
				return ($desocupaCama.$query);
		}	
		
}
?>