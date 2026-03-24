<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header
include "../gestion/funciones/funciones.php";

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$buscaPDF = $_GET['buscaPDF'];
$servicio_activo = $_REQUEST['servicio_activo'];
$nomServicio = $_POST['nomServicio'];
$fechabusca = $_POST['fechabusca'];
$fechahasta = $_POST['fechahasta'];
$fechade = $_POST['fechade'];
// $servicio_activo = $_REQUEST['servicio_activo'];


$usuario = $_SESSION['MM_Username'];




$medico1 = $_POST['medico1'];
$medico2 = $_POST['medico2'];

$horade = $_POST['horade'];
$minde = $_POST['minde'];

$horahasta = $_POST['horahasta'];
$minhasta = $_POST['minhasta'];
$totIngresos = $_POST['totIngresos'];
$totEgresos = $_POST['totEgresos'];
$detalle_turno = $_POST['detalle_turno'];


$fecha_hoy = date('Y-m-d');
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

$fechade = cambiarFormatoFecha2($fechade);
$fechahasta = cambiarFormatoFecha2($fechahasta);
$fechabusca = cambiarFormatoFecha2($fechabusca);
$desdeHora = $horade.':'.$minde;
$hastaHora = $horahasta.':'.$minhasta;

if($buscaPDF == 1){
	// $servicio_activo = $_POST['servicio_activo'];
	$sqlBuscaPDF = "SELECT id_turno
					FROM entrega_turno
					WHERE fecha_turno='$fechabusca'
					AND
					servicio_turno=$servicio_activo";
	$queryBuscaPDF = mysql_query($sqlBuscaPDF) or die($sqlBuscaPDF." Error al seleccionar turno ".mysql_error());
	$arrayBuscaPDF = mysql_fetch_array($queryBuscaPDF);
	$id_turno = $arrayBuscaPDF['id_turno'];
	?>
	<script>
        window.open('turnoDocs/entrega_turno_pdf.php?servicio=<?= $servicio_activo; ?>&fecha_turno=<?= $fecha_hoy; ?>&idTurno=<?= $id_turno; ?>&nomservicio=<?= $nomServicio; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
	</script>

	<meta http-equiv='refresh' content='0; url=entrega_turno.php?desde=<? echo $desde; ?>&servicio_activo=<?= $servicio_activo; ?>'>
<?	}else{

$sqlVerifica = "SELECT id_turno 
				FROM entrega_turno
				WHERE 
				desde_fecha_turno = '$fechade' AND 
				hasta_fecha_turno = '$fechahasta' AND
				servicio_turno = $servicio_activo";
$queryVerifica = mysql_query($sqlVerifica) or die ($sqlVerifica." Error al seleccionar datos del turno ".mysql_error());

$arrayVerifica = mysql_fetch_array($queryVerifica);
$idTurno = $arrayVerifica['id_turno'];

if($idTurno){// id turno existe!
	//ACTUALIZA EL TURNO
	
	$detalle_turno = htmlentities($detalle_turno);
	
	 $sql_actTurno = "UPDATE entrega_turno
	 					SET 
	 					desde_fecha_turno = '$fechade',
	 					hasta_fecha_turno = '$fechahasta',
	 					desde_hora_turno = '$desdeHora',
	 					hasta_hora_turno = '$hastaHora',
	 					usuario_turno = '$usuario',
	 					a_medico_turno = '$medico2',
	 					de_medico_turno = '$medico1',
	 					detalle_turno = '$detalle_turno',
	 					ingresos_turno = '$totIngresos',
	 					egresos_turno = '$totEgresos' 
	 					WHERE id_turno = $idTurno
	 					AND fecha_turno = '$fecha_hoy'";
	 $query_actTurno = mysql_query($sql_actTurno) or die($sql_actTurno."<br/> Error al actualizar entrega de turno <br/>".mysql_error());
	
	// //BORRA LO ANTES GUARDADO
	 $sqlBorra = "DELETE FROM turno_has_paciente WHERE id_turno = $idTurno ";
	 $queryBorra = mysql_query($sqlBorra) or die($sqlBorra."<br/>Error al eliminar educaciones<br/>".mysql_error());
	
	 foreach($_POST['id_pac'] as $clave => $valor){
			
			$evento[$clave] = cambiarFormatoFecha2($_POST['evento'][$clave]);
			$hospitaliza[$clave] = cambiarFormatoFecha2($_POST['hospitaliza'][$clave]);
			$ingreso[$clave] =  cambiarFormatoFecha2($_POST['ingreso'][$clave]);
			
			$diangs[$clave] = htmlentities($_POST['diangs'][$clave]);
			$bact[$clave] = htmlentities($_POST['bact'][$clave]);
			$planes[$clave] = htmlentities($_POST['planes'][$clave]);
			
			$sqlPacienteTurno = "INSERT INTO turno_has_paciente
								(id_turno,
								pac_turnopac,
								prev_turnopac,
								proc_turnopac,
								evento_turnopac,
								hosp_turnopac,
								ing_turnopac,
								edad_turnopac,
								talla_turnopac,
								peso_turnopac,
								pcp_turnopac,
								sc_turnopac,
								imc_turnopac,
								diagn_turnopac,
								bact_turnopac,
								planes_turnopac,
								diaupc_turnopac)
								VALUES
								($idTurno,
								$valor,
								'".$_POST['prev_pac'][$clave]."',
								'".$_POST['cod_proc_pac'][$clave]."',
								'".$evento[$clave]."',
								'".$hospitaliza[$clave]."',
								'".$ingreso[$clave]."',
								'".$_POST['edad_pac'][$clave]."',
								'".$_POST['talla'][$clave]."',
								'".$_POST['peso'][$clave]."',
								'".$_POST['pcp'][$clave]."',
								'".$_POST['sc'][$clave]."',
								'".$_POST['imc'][$clave]."',
								'".$diangs[$clave]."',
								'".$bact[$clave]."',
								'".$planes[$clave]."',
								'".$_POST['diauci'][$clave]."')";
				$queryPacienteTurno = mysql_query($sqlPacienteTurno) or die($sqlPacienteTurno." Error al insertar pacientes del turno ".mysql_error());
		 }
	
	
	echo "Repetido, pero actualizo!"; 
	}else{ // id turno no existe
	
	$detalle_turno = htmlentities($detalle_turno);
		$insertaTurno = "INSERT INTO entrega_turno
							(fecha_turno,
							desde_fecha_turno,
							hasta_fecha_turno,
							desde_hora_turno,
							hasta_hora_turno,
							usuario_turno,
							servicio_turno,
							a_medico_turno,
							de_medico_turno,
							ingresos_turno,
							egresos_turno,
							detalle_turno ) 
							VALUES
							('$fecha_hoy',
							'$fechade',
							'$fechahasta',
							'$desdeHora',
							'$hastaHora',
							'$usuario',
							$servicio_activo,
							'$medico2',
							'$medico1',
							'$totIngresos',
							'$totEgresos',
							'$detalle_turno')";
		$queryInsertaTurno = mysql_query($insertaTurno) or die($insertaTurno." Error al insertar nuevo turno ".mysql_error());

		// //Recupera el id del turno guardado
		$id_turno = mysql_insert_id();

		foreach($_POST['id_pac'] as $clave => $valor){
			
			$evento[$clave] = cambiarFormatoFecha2($_POST['evento'][$clave]);
			$hospitaliza[$clave] = cambiarFormatoFecha2($_POST['hospitaliza'][$clave]);
			$ingreso[$clave] =  cambiarFormatoFecha2($_POST['ingreso'][$clave]);
			
			$diangs[$clave] = htmlentities($_POST['diangs'][$clave]);
			$bact[$clave] = htmlentities($_POST['bact'][$clave]);
			$planes[$clave] = htmlentities($_POST['planes'][$clave]);
			
			$sqlPacienteTurno = "INSERT INTO turno_has_paciente
								(id_turno,
								pac_turnopac,
								prev_turnopac,
								proc_turnopac,
								evento_turnopac,
								hosp_turnopac,
								ing_turnopac,
								edad_turnopac,
								talla_turnopac,
								peso_turnopac,
								pcp_turnopac,
								sc_turnopac,
								imc_turnopac,
								diagn_turnopac,
								bact_turnopac,
								planes_turnopac,
								diaupc_turnopac)
								VALUES
								($id_turno,
								$valor,
								'".$_POST['prev_pac'][$clave]."',
								'".$_POST['cod_proc_pac'][$clave]."',
								'".$evento[$clave]."',
								'".$hospitaliza[$clave]."',
								'".$ingreso[$clave]."',
								'".$_POST['edad_pac'][$clave]."',
								'".$_POST['talla'][$clave]."',
								'".$_POST['peso'][$clave]."',
								'".$_POST['pcp'][$clave]."',
								'".$_POST['sc'][$clave]."',
								'".$_POST['imc'][$clave]."',
								'".$diangs[$clave]."',
								'".$bact[$clave]."',
								'".$planes[$clave]."',
								'".$_POST['diauci'][$clave]."')";


				$queryPacienteTurno = mysql_query($sqlPacienteTurno) or die($sqlPacienteTurno." Error al insertar pacientes del turno ".mysql_error());
			
								
			}
		}

	if($id_turno == ''){
		$id_turno = $idTurno;
		} ?>
<script>
        window.open('turnoDocs/entrega_turno_pdf.php?servicio=<?= $servicio_activo; ?>&fecha_turno=<?= $fecha_hoy; ?>&idTurno=<?= $id_turno; ?>&nomservicio=<?= $nomServicio; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
</script>

<meta http-equiv='refresh' content='0; url=entrega_turno.php?servicio_activo=<?= $servicio_activo; ?>&desde=<? echo $desde; ?>'>
<? }
?>
