<? class Camas{
	
	function listarSalas($link,$servicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT DISTINCT
				camas.sala
				FROM
				camas
				WHERE
				camas.cod_servicio = $servicio";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER SALAS<br>");
		return ($query);
	}
	
	function infoCama($link,$ctacte){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				listasn.idListaSN,
				listasn.tipoTrasladoSN,
				listasn.idCamaSN,
				listasn.nomProcedenciaSN,
				listasn.codProcedenciaSN,
				listasn.que_codServSN,
				listasn.que_nomServSN,
				listasn.que_idcamaSN,
				listasn.que_camaSN,
				listasn.que_salaSN,
				listasn.desde_codServSN,
				listasn.desde_nomServSN,
				listasn.tipo1SN,
				listasn.d_tipo1SN,
				listasn.tipo2SN,
				listasn.d_tipo2SN,
				listasn.ctaCteSN,
				listasn.codMedicoSN,
				listasn.nomMedicoSN,
				listasn.codAugeSN,
				listasn.nomAugeSN,
				listasn.diagnostico1SN,
				listasn.diagnostico2SN,
				listasn.accTranSN,
				listasn.multiresSN,
				listasn.idPacienteSN,
				listasn.sexoPacienteSN,
				listasn.rutPacienteSN,
				listasn.nacPacienteSN,
				listasn.fichaPacienteSN,
				listasn.esta_fichaSN,
				listasn.nomPacienteSN,
				listasn.direcPacienteSN,
				listasn.codComunaSN,
				listasn.nomComunaSN,
				listasn.fono1SN,
				listasn.fono2SN,
				listasn.fono3SN,
				listasn.fechaCatSN,
				listasn.categorizaRiesgoSN,
				listasn.categorizaDepSN,
				listasn.pabellonSN,
				listasn.estadoSN,
				listasn.hospitalizadoSN,
				listasn.fechaIngresoSN,
				listasn.horaIngresoSN,
				listasn.codPrevisionSN,
				listasn.nomPrevisionSN,
				listasn.estadoctacteSN,
				listasn.estadoAnteriorSN,
				listasn.causaAnteriorSN,
				listasn.barthelSN,
				listasn.barthelegreso
				FROM
				listasn
				WHERE ctaCteSN = '$ctacte'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER INFORMACION DE CAMA<br>");
		return ($query);				
		}
	
	function detalleCamas($link,$sala,$servicio){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT 
				camas.id,
				camas.cod_servicio,
				camas.que_cod_servicio,
				camas.que_servicio,
				camas.servicio,
				camas.prevision,
				camas.cama,
				camas.sala,
				camas.cta_cte,
				camas.id_paciente,
				camas.rut_paciente,
				camas.ficha_paciente,
				camas.nom_paciente,
				camas.edad_paciente,
				camas.sexo_paciente,
				camas.hospitalizado,
				camas.fecha_ingreso,
				camas.hora_ingreso,
				camas.fecha_categorizacion,
				camas.categorizacion_riesgo,
				camas.categorizacion_dependencia,
				camas.diagnostico1,
				camas.diagnostico2,
				camas.medico,
				camas.cod_medico,
				camas.estado,
				camas.esta_ficha,
				camas.cod_prevision,
				camas.tipo_paciente,
				camas.multires
				FROM
				camas
				WHERE
				camas.sala = '$sala' and
				camas.cod_servicio = '$servicio'
				ORDER BY cama asc";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL DETALLE DE LAS CAMAS<br>");
		return ($query);
	}
		
	function detallePaciente($nom_paciente,$fecha_ing,$hora_ingreso,$fecha_hosp,$pre_diagn,$diagnostico,$medico,$nom_serv,$categorizacion,$nom_que_servicio,$fecha_categ,$nom_prevision){
		$Time = strftime("%H:%M:%S");
		$fecha = date('Y-m-d');
		$hoy = $fecha." ".$Time;		
		$ingreso = $fecha_ing.' '.$hora_ingreso;
		
		$ingreso_hosp = $fecha_hosp;
		$egreso = $fecha.' '.$time;
		
		$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
		
		$dias_espera = ($tiempo_espera / 24);
		$decimales = explode(".",$dias_espera);
		$dias_espera = $decimales[0];
		$horas_espera = ($tiempo_espera - ($dias_espera*24));
		
		$tiempo_espera_hosp = intval((strtotime($egreso)-strtotime($ingreso_hosp))/3600);

		$dias_espera_hosp = ($tiempo_espera_hosp / 24);
		$decimales = explode(".",$dias_espera_hosp);
		$dias_espera_hosp = $decimales[0];
		$horas_espera_hosp = ($tiempo_espera_hosp - ($dias_espera_hosp*24));
		
		$infoCama = "<table width='350' border='0'>
					  <tr>
						<td><b>Paciente: </b>".$nom_paciente."</td>
					  </tr>
					  <tr>
						<td><b>Ing. Hospital: </b>".$fecha_hosp."</td>
					  </tr>
					  <tr>
						<td><b>Dias Hospitalizado: </b>".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas </td>
					  </tr>
					  <tr>
						<td><b>Ingreso Servicio: </b>".$fecha_ing."</td>
					  </tr>
					  <tr>
						<td><b>Dias en servicio: </b>".$dias_espera." dias y ".$horas_espera." horas </td>
					  </tr>
					  <tr>
						<td><b>Pre-Diagnostico: </b>".$pre_diagn."</td>
					  </tr>
					  <tr>
						<td><b>Diagnostico: </b>".$diagnostico."</td>
					  </tr>
					  <tr>
						<td><b>Medico: </b>".$medico."</td>
					  </tr>
					  <tr>
						<td><b>Categorizacion: </b>".$categorizacion."(".$fecha_categ.")</td>
					  </tr>
					  <tr>
						<td><b>Servicio: </b>".$nom_que_servicio."</td>
					  </tr>
                      <tr>
						<td><b>Prevision: </b>".$nom_prevision."</td>
					  </tr>
					</table>";
		return($infoCama);
	}
	
	function minidetallePaciente($nom_paciente,$fecha_ing,$hora_ingreso,$fecha_hosp,$pre_diagn,$diagnostico,$medico,$nom_serv,$categorizacion){
		$Time = strftime("%H:%M:%S");
		$fecha = date('Y-m-d');
		$hoy = $fecha." ".$Time;		
		$ingreso = $fecha_ing.' '.$hora_ingreso;
		
		$ingreso_hosp = $fecha_hosp;
		$egreso = $fecha.' '.$time;
		
		$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
		
		$dias_espera = ($tiempo_espera / 24);
		$decimales = explode(".",$dias_espera);
		$dias_espera = $decimales[0];
		$horas_espera = ($tiempo_espera - ($dias_espera*24));
		
		$tiempo_espera_hosp = intval((strtotime($egreso)-strtotime($ingreso_hosp))/3600);

		$dias_espera_hosp = ($tiempo_espera_hosp / 24);
		$decimales = explode(".",$dias_espera_hosp);
		$dias_espera_hosp = $decimales[0];
		$horas_espera_hosp = ($tiempo_espera_hosp - ($dias_espera_hosp*24));
		
		$infoCama = "<table width='350' border='0'>
					  <tr>
						<td><b>Paciente: </b>".$nom_paciente."</td>
					  </tr>
					  <tr>
						<td><b>Ingreso Servicio: </b>".$fecha_ing."</td>
					  </tr>
					  <tr>
						<td><b>Diagnostico: </b>".$diagnostico."</td>
					  </tr>
					  <tr>
						<td><b>Categorizacion: </b>".$categorizacion."</td>
					  </tr>
					  
					</table>";
		return($infoCama);
	}
	
	function validarEstadoCama($link,$idCama){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT *
				FROM
				camas
				WHERE
				camas.id = $idCama";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR VERIFICAR ESTADO DE LA CAMA<br>");
		$RSestado = mysql_fetch_assoc($query);
		$estadoCama = $RSestado['estado'];
		
		return ($estadoCama);
	}
	function ocupaCama($link,$idCama,$tipo_traslado,$ctacte,$tipo_1,$d_tipo_1,$tipo_2,$d_tipo_2,$que_cod_servicio,$que_servicio,$cod_procedencia,$procedencia,$medicos,$nom_medico,$auge,$nom_auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$id_paciente,$run,$ficha,$esta_ficha,$nombres,$sexo,$edad,$cod_prevision,$prevision,$direccion,$id_comuna,$comuna,$fono1,$fono2,$fono3,$estado_cama,$categorizacion_riesgo,$categorizacion_dependencia,$hospitalizado,$fechaIngreso,$horaIngreso,$ibarthel,$idTransito,$id_parto,$folio_pad,$tipo_cama,$tipo_paciente,$codPad,$pacNeuro,$barthelegreso){
		$usuario = $_SESSION['MM_Username'];
		$fecha_actual = date("Y-m-d H:i:s");
		require_once('Conectar.inc'); 
		$objConectar = new Conectar;
		$objConectar->db_select("camas",$link);
		if($ibarthel==''){
			$varBarthel = " barthel = NULL ";
			}else{
				$varBarthel = " barthel = '$ibarthel'";
				}
		if($barthelegreso==''){
			$barthelegreso = "NULL";
		}else{
			$barthelegreso = $barthelegreso;
		}
		$sql = "UPDATE camas 
				SET 
				tipo_traslado = '$tipo_traslado',
				cta_cte = '$ctacte',
				que_cod_servicio = '$que_cod_servicio',
				que_servicio = '$que_servicio',
				tipo_1 = '$tipo_1',
				d_tipo_1 = '$d_tipo_1',
				tipo_2 = '$tipo_2',
				d_tipo_2 = '$d_tipo_2',
				cod_procedencia = '$cod_procedencia',
				procedencia = '$procedencia',
				cod_medico = '$medicos',
				medico = '$nom_medico',
				cod_auge = '$auge', 
				auge = '$nom_auge',
				acctransito = '$acctransito',
				multires = '$multires',
				diagnostico1 = '$diagnostico1',
				diagnostico2 = '$diagnostico2',
				id_paciente = '$id_paciente',
				rut_paciente = '$run',
				ficha_paciente = '$ficha',
				nom_paciente = '$nombres',
				sexo_paciente = '$sexo',
				edad_paciente = '$edad',
				cod_prevision = '$cod_prevision',
				prevision = '$prevision',
				direc_paciente = '$direccion',
				cod_comuna = '$id_comuna',
				comuna = '$comuna', 
				fono1_paciente = '$fono1', 
				fono2_paciente = '$fono2', 
				fono3_paciente = '$fono3', 
				estado = '$estado_cama',
				categorizacion_riesgo = '$categorizacion_riesgo',
				categorizacion_dependencia = '$categorizacion_dependencia',
				hospitalizado = '$hospitalizado',
				fecha_ingreso = '$fechaIngreso',
				hora_ingreso = '$horaIngreso',
				usuario_que_ingresa = '$usuario',
				fecha_usuario_ingresa = '$fecha_actual',
				".$varBarthel.",
				neurologico = '$pacNeuro',
				tipo_paciente = '$tipo_paciente',
				cod_pad = '$cod_pad',
				tipo_cama = '$tipo_cama',
				folio_pad = '$folio_pad',
				id_parto = '$id_parto',
				barthelegreso = ".$barthelegreso."
				WHERE (id = '$idCama') ";
				
		$queryFinal = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR VERIFICAR ESTADO DE LA CAMA<br>".$sql);
		$resQuery = mysql_affected_rows();
		
		return ($resQuery);
		}
		
		function bloquearCama($link,$idCama,$fechaBloqueo,$causaBloqueo){
			require_once('Conectar.inc');
			$objConectar = new Conectar; 
			$objConectar->db_select("camas",$link);
			$usuario = $_SESSION['MM_Username'];
			$fecha_completa = date('Y-m-d H:i:s');
			
			$sql = "UPDATE camas 
					SET 
					estado='3',
					fecha_ingreso='$fechaBloqueo',
					diagnostico1='$causaBloqueo',
					usuario_que_ingresa='$usuario',
					fecha_usuario_ingresa='$fecha_completa' 
					WHERE (id='$idCama') ";
			
			$queryFinal = mysql_query($sql,$link) or die (mysql_error()."<br> ERROR AL ACTUALIZAR CAMA ");
			$resQuery = mysql_affected_rows();
			return ($resQuery);
			}
			
		function desbloquearCama($link,$idCama,$servicio,$cod_servicio,$sala,$cama,$tipo_1,$d_tipo_1,$c_bloqueo,$c_desbloqueo,$fecha_ingreso,$fecha_egreso,$usuario_bloqueo,$fecha_que_bloqueo){
			require_once('Conectar.inc');
			$objConectar = new Conectar; 
			
			$objConectar->db_select("camas",$link);
			$usuario = $_SESSION['MM_Username'];
			$fecha_completa = date('Y-m-d H:i:s');
			
			$sql = "INSERT INTO hospitalizaciones
					(tipo_traslado,
					servicio,
					cod_servicio,
					id_cama,
					sala,
					cama,
					tipo_1,
					d_tipo_1,
					diagnostico1,
					nom_paciente,
					fecha_ingreso,
					fecha_egreso,
					usuario_que_egresa,
					fecha_usuario_egreso,
					usuario_que_ingresa,
					fecha_usuario_ingreso)
					VALUES
					(3,
					'$servicio',
					$cod_servicio,
					$idCama,
					'$sala',
					'$cama',
					'$tipo_1',
					'$d_tipo_1',
					'$c_bloqueo',
					'$c_desbloqueo',
					'$fecha_ingreso',
					'$fecha_egreso',
					'$usuario',
					'$fecha_completa',
					'$usuario_bloqueo',
					'$fecha_que_bloqueo')";
			
			$query = mysql_query($sql,$link) or die(mysql_error()."ERROR AL REALIZAR INSERT DE BLOQUEO EN HOSPITALIZACION");
			$resQuery = mysql_affected_rows();
			$camaVacia = $this->vaciarCama($link,$idCama,$cod_servicio,$servicio);
				
				if(($resQuery == 1) and ($camaVacia == 1)){
					$resultado = 1;
					}else{
						$resultado = 0;
						}		
			return ($resultado);
			}
			
		function vaciarCama($link,$idCama,$idServicio,$nomServicio){
			require_once('Conectar.inc');
			$objConectar = new Conectar; 
			$objConectar->db_select("camas",$link);
			$usuario = $_SESSION['MM_Username'];
			$fecha_completa = date('Y-m-d H:i:s');
			
			$sql = "UPDATE camas 
					SET
					tipo_traslado = 1,
					cta_cte = 0,
					cod_procedencia = 0,
					que_cod_servicio = '$idServicio',
					que_servicio = '',
					procedencia = NULL,
					cod_medico = 0,
					medico = NULL,
					cod_auge = 0,
					auge = NULL,
					acctransito = 0,
					multires = 0,
					epiId = 0,
					diagnostico1 = NULL,
					diagnostico2 = NULL,
					id_paciente = 0,
					rut_paciente = 0,
					ficha_paciente = 0,
					esta_ficha = 0,
					nom_paciente = NULL,
					sexo_paciente = NULL,
					edad_paciente = NULL,
					cod_prevision = NULL,
					prevision = NULL,
					direc_paciente = NULL,
					cod_comuna = 0,
					comuna = NULL,
					fono1_paciente = NULL,
					fono2_paciente = NULL,
					fono3_paciente = NULL,
					fecha_categorizacion = NULL,
					categorizacion_riesgo = NULL,
					categorizacion_dependencia = NULL,
					pabellon = 0,
					estado = 1,
					hospitalizado = NULL,
					fecha_ingreso = NULL,
					hora_ingreso = NULL,
					usuario_que_ingresa = NULL,
					fecha_usuario_ingresa = NULL,
					id_parto = 0,
					folio_pad = NULL,
					tipo_cama = NULL,
					tipo_paciente = NULL,
					cod_pad = NULL,
					barthel = NULL,
					neurologico = NULL,
					tipo_paciente = NULL,
					cod_pad = NULL,
					tipo_cama = NULL,
					folio_pad	 = NULL,
					barthelegreso = NULL				  
					WHERE (id='$idCama') ";
			
			$queryFinal = mysql_query($sql,$link) or die (mysql_error()."<br> ERROR AL VACIAR CAMA ");
			$resQuery = mysql_affected_rows();
			return ($resQuery);
			}
			
	function historialCama($link,$idCama){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$sql = "SELECT
				hospitalizaciones.id,
				hospitalizaciones.id_cama,
				hospitalizaciones.servicio,
				hospitalizaciones.sala,
				hospitalizaciones.cama,
				hospitalizaciones.cta_cte,
				hospitalizaciones.destino,
				hospitalizaciones.medico,
				hospitalizaciones.auge,
				hospitalizaciones.acctransito,
				hospitalizaciones.multires,
				hospitalizaciones.diagnostico1,
				hospitalizaciones.diagnostico2,
				hospitalizaciones.nom_paciente,
				hospitalizaciones.prevision,
				hospitalizaciones.fono1_paciente,
				hospitalizaciones.fono2_paciente,
				hospitalizaciones.fono3_paciente,
				hospitalizaciones.categorizacion_riesgo,
				hospitalizaciones.categorizacion_dependencia,
				hospitalizaciones.fecha_ingreso,
				hospitalizaciones.fecha_egreso
				FROM hospitalizaciones
				WHERE id_cama = '$idCama'
				ORDER BY fecha_ingreso DESC";
		$query = mysql_query($sql) or die("ERROR AL SELECCIONAR HISTORIAL DE LA CAMA".mysql_error());
		return($query);
		}
		
	function infoHistorial($link,$idHospitalizacion){
		require_once('Conectar.inc'); 
		require_once('Util.inc');
		
		$objUtil = new Util;
		$objConectar = new Conectar;
		 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT
				hospitalizaciones.id,
				hospitalizaciones.rut_paciente,
				hospitalizaciones.ficha_paciente,
				hospitalizaciones.prevision,
				hospitalizaciones.nom_paciente,
				hospitalizaciones.edad_paciente,
				hospitalizaciones.direc_paciente,
				hospitalizaciones.fono1_paciente,
				hospitalizaciones.fono2_paciente,
				hospitalizaciones.fono3_paciente,
				hospitalizaciones.fecha_ingreso,
				hospitalizaciones.cta_cte,
				hospitalizaciones.d_tipo_1,
				hospitalizaciones.medico,
				hospitalizaciones.diagnostico1,
				hospitalizaciones.diagnostico2,
				hospitalizaciones.barthel,
				CONCAT(categorizacion_riesgo,categorizacion_dependencia) as categorizacion,
				hospitalizaciones.servicio,
				hospitalizaciones.sala,
				hospitalizaciones.cama,
				hospitalizaciones.auge,
				hospitalizaciones.destino,
				hospitalizaciones.acctransito,
				hospitalizaciones.multires
				FROM
				hospitalizaciones
				WHERE
				hospitalizaciones.id = $idHospitalizacion";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER INFORMACION DE CAMA<br>");
		$RScama = mysql_fetch_assoc($query);
		$digito = $objUtil->generaDigito($RScama['rut_paciente']);
		$response->rutPaciente = $RScama['rut_paciente']."-".$digito;
		$response->fichaPaciente = $RScama['ficha_paciente'];
		$response->previsionPaciente = $RScama['prevision'];
		$response->nombrePaciente = $RScama['nom_paciente'];
		$response->edadPaciente = $RScama['edad_paciente'];
		$response->direccionPaciente = $RScama['direc_paciente'];
		$response->fono1Paciente = $RScama['fono1_paciente'];
		$response->fono2Paciente = $RScama['fono2_paciente'];
		$response->fono3Paciente = $RScama['fono3_paciente'];
		$response->ctactePaciente = $RScama['cta_cte'];
		$response->tipo1Paciente = $RScama['d_tipo_1'];
		$response->medicoPaciente = $RScama['medico'];
		$response->diagnostico1Paciente = $RScama['diagnostico1'];
		$response->diagnostico2Paciente = $RScama['diagnostico2'];
		$response->barthelPaciente = $RScama['barthel'];
		$response->ingresoPaciente = $RScama['fecha_ingreso'];
		$response->categPaciente = $RScama['categorizacion'];
		$response->servicioPaciente = $RScama['servicio'];
		$response->salaPaciente = $RScama['sala'];
		$response->camaPaciente = $RScama['cama'];
		$response->augePaciente = $RScama['auge'];
		$response->destinoPaciente = $RScama['destino'];
		$response->acctransitoPaciente = $RScama['acctransito'];
		$response->multiresPaciente = $RScama['multires'];
		return ($response);
		}
		
		function modificaIngreso($link,$que_cod_servicio,$que_nom_servicio,$cod_medico,$nom_medico,$cod_auge,$nom_auge,$acctransito,$multires,$diagnostico1,$diagnostico2,$fechaIngreso,$horaIngreso,$ibarthel,$idCama,$pacNeuro,$tipo_1,$d_tipo_1,$tipo_2,$d_tipo_2){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		if($ibarthel==''){
			$varBarthel = " barthel = NULL ";
			}else{
				$varBarthel = " barthel = '$ibarthel'";
				}
			$sql = "UPDATE camas 
					SET
					que_cod_servicio = '$que_cod_servicio',
					que_servicio = '$que_nom_servicio',
					tipo_1 = '$tipo_1',
					d_tipo_1 = '$d_tipo_1',
					tipo_2 = '$tipo_2',
					d_tipo_2 = '$d_tipo_2',
					cod_medico = '$cod_medico',
					medico = '$nom_medico',
					cod_auge = '$cod_auge',
					auge = '$nom_auge',
					acctransito = $acctransito,
					multires = $multires,
					diagnostico1 = '$diagnostico1',
					diagnostico2 = '$diagnostico2',
					fecha_ingreso = '$fechaIngreso',
					hora_ingreso = '$horaIngreso',
					".$varBarthel.",
					neurologico = '$pacNeuro'					  
					WHERE (id='$idCama')";
			mysql_query("SET NAMES utf8");
			$queryFinal = mysql_query($sql,$link) or die (mysql_error()."<br> ERROR ACTUALIZAR INFORMACION DE CAMA ".$sql);
			$resQuery = mysql_affected_rows();
			return ($sql);
			
			}
		
		function desc_tipo1($tipo_1){
			switch($tipo_1){
				case 4:
					$descripcion = "UTI";
				break;
				case 13:
					$descripcion = "UTI";
				break;
				case 14:
					$descripcion = "INTERMEDIO (INCUBADORA)";
				break;
				case 15:
					$descripcion = "CUNA BASICA";
				break;
				case 51:
					$descripcion = "INDIFERENCIADO MINIMO";
				break;
				case 52:
					$descripcion = "INDIFERENCIADO INTERMEDIO";
				break;
				default:
					$descripcion = "";
				break;
				}
				
			return $descripcion;
			}
		
		function desc_tipo2($tipo_1){
			switch($tipo_1){
				case 51:
					$tipo_2=1;
					$d_tipo_2="MINIMO";
				break;
					
				case 52:
					$tipo_2=2;
					$d_tipo_2="INTERMEDIO";
				break;
				default:
					$tipo_2="0";
					$d_tipo_2="";
				break;
				}
				
			return ($tipo_2."-".$d_tipo_2);
			}
		
		
		function actualizaDatosNN($link,$rutPac,$fichaPac,$nombrePac,$sexoPac,$edadPac,$codPrevPac,$nomPrevPac,$direccionPac,$codComunaPac,$nomComunaPac,$fono1Pac,$fono2Pac,$fono3Pac,$idPaciente,$idCamaNN){
			require_once('Conectar.inc');
			$objConectar = new Conectar; 
			$objConectar->db_select("camas",$link);
			
			$sql = "UPDATE camas SET
					id_paciente = '$idPaciente',
					rut_paciente = '$rutPac',
					ficha_paciente = '$fichaPac',
					nom_paciente = '$nombrePac',
					sexo_paciente = '$sexoPac',
					edad_paciente = '$edadPac',
					cod_prevision = '$codPrevPac',
					prevision = '$nomPrevPac',
					direc_paciente = '$direccionPac',
					cod_comuna = '$codComunaPac',
					comuna = '$nomComunaPac',
					fono1_paciente = '$fono1Pac',
					fono2_paciente = '$fon21Pac',
					fono3_paciente = '$fono3Pac'
					WHERE id = '$idCamaNN'";
					
			$query = mysql_query($sql,$link) or die ($sql." ERROR AL ACTUALIZAR DATOS EN CAMAS DE PACIENTE NN ".mysql_error());
			$resQuery = mysql_affected_rows();
			return ($resQuery);
			
			}
			
		function buscaPacienteEspera($link,$idServicio){
			require_once('Conectar.inc');
			$objConectar = new Conectar; 
			$objConectar->db_select("camas",$link);
			
			$sql = "SELECT * 
					FROM transito_paciente 
					WHERE (cod_sscc_hasta = $idServicio ) 
					OR (cod_sscc_desde = $idServicio )";
					
			$query = mysql_query($sql) or die($sql." ERROR AL BUSCAR PACIENTE EN LA LISTA DE ESPERA DE HOSPITALIZACION ".mysql_error());
			
			return ($query);
			}
			
		function muestraError($queryTransito){
			
		$warning=0;
		$error=0;
		$nada=0;

		while($arrayTransito = mysql_fetch_array($queryTransito)){
			$dia_transito = $arrayTransito['fecha'];
			$hora_transito = $arrayTransito['hora'];
			
			$fecha_completa = $dia_transito.' '.$hora_transito;
			$hoy = date("Y-m-d").' '.date("H:i:s");
			//DIFERENCIA TIEMPO EN HORAS
			$tiempo_espera = intval((strtotime($hoy)-strtotime($fecha_completa))/3600);
			
			$dias_espera = ($tiempo_espera / 24);
			$decimales = explode(".",$dias_espera);
			$dias_espera = $decimales[0];
			$horas_espera = ($tiempo_espera - ($dias_espera*24));
			$total_horas = (($dias_espera*24)+($horas_espera));
					
				if(($total_horas >= 25) and ($total_horas <= 72)){
					$warning = $warning+1;
					}else if($total_horas >= 73){
						$error = $error+1;
						}else{
							$nada = $nada+1;
							}
			}
			
		return ($warning.",".$error);
		}
	function listarNeuro($link){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		$sql = "SELECT DISTINCT
				camas.cod_servicio,
				camas.servicio
				FROM
				camas
				WHERE
				camas.neurologico = 'si'";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR BUSCAR PACIENTE NEURO<br>");
		return ($query);
		}
		
	function detalleNeuro($link,$servicio,$tipo){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		if($tipo==1){
			$variable = " and camas.cod_servicio = '$servicio' ";
			}else{
				$variable = " ";
				}
		$sql = "SELECT 
				*
				FROM
				camas
				WHERE
				camas.neurologico = 'si'".$variable."
				ORDER BY cama asc";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL OBTENER DETALLE DE NEURO<br>");
		return ($query);
		}	
	
	function bloqueoSN($link,$idPensio){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$sql = "UPDATE camassn SET estadoCamaSN='2' WHERE (idPensio=$idPensio)";
		
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HABILITAR CAMA CMI<br>");
		return ($query);
		}	
		
	function desbloqueoSN($link,$idPensio){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$sql = "UPDATE camassn SET estadoCamaSN='1' WHERE (idPensio=$idPensio)";
		
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HABILITAR CAMA CMI<br>");
		return ($query);
		}
	function infoPacienteSN($link,$idCama){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$sql = "SELECT
				listasn.nomPacienteSN,
				listasn.rutPacienteSN
				FROM
				listasn
				WHERE
				listasn.que_idcamaSN = $idCama";
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HABILITAR CAMA CMI<br>");
		$rs = mysql_fetch_assoc($query);
		return ($rs);
		}	
	
	function tipo1_tipo2($tipo_1){
			switch ($tipo_1) {
			case 1:
				$tipo_1 = 1;
				$d_tipo_1 = "CIRUGIA";
				$tipo_2 = '';
				$d_tipo_2 = '';
				
				break;
			case 2:
				$tipo_1 = 2;
				$d_tipo_1 ="MEDICINA";
				$tipo_2 = '';
				$d_tipo_2 = '';
				break;
			case 3:
				$tipo_1 = 3;
				$d_tipo_1 ="ONCOLOGIA";
				$tipo_2 = '';
				$d_tipo_2 = '';
				break;
			case 4:
				$tipo_1 = 4;
				$d_tipo_1 ="PEDIATRIA UTI";
				$tipo_2 ="";
				$d_tipo_2 ="";
				break;
			case 51:
				$tipo_1 = 5;
				$d_tipo_1 = "PEDIATRIA INDIFERENCIADA";
				$tipo_2 = 1;
				$d_tipo_2 = "MINIMO";
				break;
			case 52:
				$tipo_1 = 5;
				$d_tipo_1 = "PEDIATRIA INDIFERENCIADA";
				$tipo_2 = 2;
				$d_tipo_2 = "INTERMEDIO";
				break;
			case 61:
				$tipo_1 = 6;
				$d_tipo_1 = "PEDIATRIA LACTANTES";
				$tipo_2 = 1;
				$d_tipo_2 = "MINIMO";
				break;
			case 62:
				$tipo_1=6;
				$d_tipo_1="PEDIATRIA LACTANTES";
				$tipo_2=2;
				$d_tipo_2="INTERMEDIO";
				break;
			case 7:
				$tipo_1= '7';
				$d_tipo_1="TRAUMATOLOGIA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 8:
				$tipo_1= '8';
				$d_tipo_1="GINECOLOGIA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 9:
				$tipo_1= '9';
				$d_tipo_1="OBSTETRICIA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 10:
				$tipo_1= '10';
				$d_tipo_1="PSIQUIATRIA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 11:
				$tipo_1= '11';
				$d_tipo_1="UCI";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 12:
				$tipo_1="12";
				$d_tipo_1="SAI";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 13:
				$tipo_1= '13';
				$d_tipo_1= "NEONATOLOGIA UCI";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 14:
				$tipo_1= '14';
				$d_tipo_1="NEONATOLOGIA INTERMEDIO (INCUBADORA)";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 15:
				$tipo_1= '15';
				$d_tipo_1="NEONATOLOGIA CUNA BASICA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 45:
				$tipo_1= '45';
				$d_tipo_1="PARTOS";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 46:
				$tipo_1= '46';
				$d_tipo_1="ALTA PRECOZ";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			case 50:
				$tipo_1="50";
				$d_tipo_1="URGENCIA";
				$tipo_2= '';
				$d_tipo_2= '';
				break;
			}
		return ($tipo_1."-".$d_tipo_1."-".$tipo_2."-".$d_tipo_2);
		}
		
	function altaPrecoz($link){
		require_once('Conectar.inc');
		$objConectar = new Conectar; 
		$objConectar->db_select("camas",$link);
		
		$hora = date('H');
		if($hora>12){
			$queorden = "movil_n";
			}else{
				$queorden = "movil_m";
				}
		$sql = "SELECT * FROM altaprecoz where cod_servicio = 106 order by ".$queorden;
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HABILITAR CAMA CMI<br>");
		return ($query);
		}
	function buscabarthelegreso($link, $cta_cte){
		$sql="SELECT
				paciente.ctacte.idctacte,
				camas.camas.barthelegreso as barthelegresocama,
				camas.listasn.barthelegreso as barthelegresosn
				FROM
				paciente.ctacte
				LEFT JOIN camas.camas ON paciente.ctacte.idctacte = camas.camas.cta_cte
				LEFT JOIN camas.listasn ON paciente.ctacte.idctacte = camas.listasn.ctaCteSN
				WHERE
				paciente.ctacte.idctacte = '$cta_cte'"; //echo $sql;
		mysql_query("SET NAMES utf8");
		$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL HABILITAR CAMA CMI<br>");
		$rs = mysql_fetch_assoc($query);
		if($rs['barthelegresocama'] != ""){
			$respuesta = $rs['barthelegresocama'];
			return ($respuesta);
		}elseif($rs['barthelegresosn'] != ""){
			$respuesta = $rs['barthelegresosn'];
			return ($respuesta);
		}else{
			$respuesta = "";
			return ($respuesta);
		}
	}

	function insertasolicitudalta($link, $SAL_usuario, $SAL_fecha, $SAL_ctacte, $SAL_estado, $SAL_idalta){
		if($SAL_estado == "1"){
			$sql="SELECT SAL_ctacte FROM camas.solicitud_alta WHERE SAL_ctacte = $SAL_ctacte";
			mysql_query("SET NAMES utf8");
			$query = mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL seleccionar insertasolicitudalta<br>");
			$compara = mysql_fetch_array($query);
			if($compara['SAL_ctacte'] == ""){
				$sql="INSERT into camas.solicitud_alta (SAL_ctacte, SAL_usuario, SAL_fecha, SAL_estado)values($SAL_ctacte,'$SAL_usuario','$SAL_fecha',$SAL_estado)";
				mysql_query("SET NAMES utf8");
				mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL insertar insertasolicitudalta<br>");
			}
		}else{
			$sql="UPDATE camas.solicitud_alta SET SAL_estado = $SAL_estado, SAL_idalta = $SAL_idalta WHERE SAL_ctacte = $SAL_ctacte";
			mysql_query("SET NAMES utf8");
			mysql_query($sql,$link) or die(mysql_error()."<br>ERROR AL actualizar insertasolicitudalta<br>");
		}
	}	
		
}
?>