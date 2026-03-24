<? if (!isset($_SESSION)) {
	session_start();
}
$bd = $_SESSION['BD_SERVER'];
include "../funciones/epicrisis_funciones.php";

$id_cama = $_REQUEST["id_cama"];
$idPaciente = $_REQUEST["idPaciente"];
$cod_prevision = $_REQUEST["cod_prevision"];
$idCama = $_REQUEST["idCama"];
$ctaCte = $_REQUEST["ctaCte"];
$idServicio = $_REQUEST["idServicio"];
$idEpicrisis = $_REQUEST["idEpicrisis"];
$posicionX = $_REQUEST["posicionX"];
$nomCR = $_REQUEST["nomCR"];
$fechaHosp = $_REQUEST["fechaHosp"];
$edadPac = $_REQUEST["edadPac"];
$nombrePaciente = $_REQUEST["nombrePaciente"];
$fichaPaciente = $_REQUEST["fichaPaciente"];
$generoPaciente = $_REQUEST["generoPaciente"];
$serv_paciente = $_REQUEST["serv_paciente"];
$multiRes = $_REQUEST["multiRes"];
$epimedica  = $_REQUEST["epimedica"]; 
$rutPac = $_REQUEST["rutPac"];
$nomPrevision = $_REQUEST["nomPrevision"];
$direccion = $_REQUEST["direccion"];
$nomServicio  = $_REQUEST["nomServicio"]; 
$fechaNac = $_REQUEST["fechaNac"];
$fonoCont = $_REQUEST["fonoCont"];
$ingFecha = $_REQUEST["ingFecha"];
$altFecha = $_REQUEST["altFecha"];
$difDias = $_REQUEST["difDias"];
$destinoPaciente = $_REQUEST["destinoPaciente"];
$condEgreso = $_REQUEST["condEgreso"];
$diagnosticos = $_REQUEST["diagnosticos"];
$fundamentos  = $_REQUEST["fundamentos"]; 
$medico_nom = $_REQUEST["medico_nom"];
$medico_id = $_REQUEST["medico_id"];
$idUsuario = $_REQUEST["idUsuario"];
$especialidad = $_REQUEST["especialidad"];
$detalleEpi = $_REQUEST["detalleEpi"];
$nombreFav = $_REQUEST["nombreFav"];
$epimedFono = $_REQUEST["epimedFono"];

// $detalleEpi = $_POST['detalleEpi'];
// $nombreFav = $_POST['nombreFav'];
// $idUsuario = $_POST['idUsuario'];

 $fechaIng = $_REQUEST['fechaIng'];
 $fechaEgr = $_REQUEST['fechaEgr'];
// $ingFecha = $_REQUEST['ingFecha'];
// $altFecha = $_REQUEST['altFecha'];
// $rutPac = $_REQUEST['rutPac'];
// $fechaNac = $_REQUEST['fechaNac'];
// $idPaciente = $_REQUEST['idPaciente'];
// $fonoCont = $_REQUEST['fonoCont'];
// $cod_prevision = $_REQUEST['cod_prevision'];
// $diagnosticos = $_REQUEST['diagnosticos'];
// $fundamentos = $_REQUEST['fundamentos'];
// $detalleEpi = $_REQUEST['detalleEpi'];
// $id_cama = $_REQUEST['id_cama'];
// $idUsuario = $_REQUEST['idUsuario'];
// $ctaCte = $_REQUEST['ctaCte'];
// $condEgreso = $_REQUEST['condEgreso'];
// $idServicio = $_REQUEST['idServicio'];
// $difDias = $_REQUEST['difDias'];
// $medico_id = $_REQUEST['medico_id'];
// $medico_nom = $_REQUEST['medico_nom'];
$cierra = $_REQUEST['cierra'];
$idFavorito = $_REQUEST['idFavorito'];
$opcionGes = $_REQUEST['opcionGes'];
$tiposGes = $_REQUEST['tiposGes'];
$pesoNac = $_REQUEST['pesoNac'];
$pesoAlta = $_REQUEST['pesoAlta'];
$tipoNutri = $_REQUEST['tipoNutri'];
// $destinoPaciente = $_REQUEST['destinoPaciente'];
$trasladoPaciente = $_REQUEST['trasladoPaciente'];
$hogarPaciente = $_REQUEST['hogarPaciente'];
$controlEspecialidad = $_REQUEST['controlEspecialidad'];

// $nombrePaciente = $_REQUEST['nombrePaciente'];
// $fichaPaciente = $_REQUEST['fichaPaciente'];
$direccionPac = $_REQUEST['direccionPac'];
// $generoPaciente = $_REQUEST['generoPaciente'];
// $serv_paciente = $_REQUEST['serv_paciente'];
$rutPaciente = $_REQUEST['rutPaciente'];
// $fechaNac = $_REQUEST['fechaNac'];
$prevPaciente = $_REQUEST['prevPaciente'];
$visualiza = $_REQUEST['visualiza'];
// $ctaCte = $_REQUEST['ctaCte'];
// $idServicio =$_REQUEST['idServicio'];
// $controlEspecialidad =$_REQUEST['controlEspecialidad'];
// $controlEspecialidad = $_REQUEST['controlEspecialidad'];
// $id_cama=$_GET['id_cama'];
// $idPaciente=$_GET['idPaciente'];
// $cod_prevision=$_GET['cod_prevision'];
// $idCama=$_GET['idCama'];
// $ctaCte=$_GET['ctaCte'];
// $idServicio=$_GET['idServicio'];
// $idEpicrisis=$_GET['idEpicrisis'];
// $posicionX=$_GET['posicionX'];
// $nomCR=$_GET['nomCR']; 
// $fechaHosp=$_GET['fechaHosp'];
// $edadPac=$_GET['edadPac'];
// $nombrePaciente=$_GET['nombrePaciente'];
// $fichaPaciente=$_GET['fichaPaciente'];
// $generoPaciente=$_GET['generoPaciente'];
// $serv_paciente=$_GET['serv_paciente'];
// $multiRes=$_GET['multiRes'];
// $epimedica=$_GET['epimedica'];
// $rutPac=$_GET['rutPac'];
// $nomPrevision=$_GET['nomPrevision'];
// $direccion=$_GET['direccion']; 
// $nomServicio=$_GET['nomServicio'];
// $fechaNac=$_GET['fechaNac'];
// $fonoCont=$_GET['fonoCont'];
// $ingFecha=$_GET['ingFecha'];
// $altFecha=$_GET['altFecha'];
// $difDias=$_GET['difDias'];
// $destinoPaciente=$_GET['destinoPaciente'];
// $diagnosticos=$_GET['diagnosticos'];
// $fundamentos=$_GET['fundamentos'];
// $medico_nom=$_GET['medico_nom'];
// $medico_id=$_GET['medico_id'];
// $idUsuario=$_GET['idUsuario'];
// $especialidad=$_GET['especialidad'];
// $detalleEpi=$_GET['detalleEpi'];




require_once('clases/Conectar.inc'); 
$objConectar = new Conectar; 
$link = $objConectar->db_connect();
require_once('clases/diagnosticosmedicos.inc'); 
	$objdiagnosticomedico = new diagnosticosmedicos;

mysql_connect ($bd,'gestioncamas','123gestioncamas');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");
$fechaHoy = date("Y-m-d H:i:s");
$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);

//INGRESA LAS INDICACIONES A UNA NUEVA TABLA CON LOS FAVORITOS DE CADA MEDICO

if($fav == 1){
	$sqlFavorito = "INSERT INTO favoritos
								(descFav,
								nombreFav,
								idMedico)
								VALUES 
								('$detalleEpi',
								'$nombreFav',
								'$idUsuario')";
	mysql_query("SET NAMES utf8");							
	$insertFavorito = mysql_query($sqlFavorito) or die($sqlFavorito. " No se logro realizar el Insert de favorito". mysql_error());

//Recupera el id de la epicrisis creada
$idFavorito = mysql_insert_id();

	}else{
		$idFavorito = $listaFavoritos;
	}


if($idEpicrisis == ''){
	
			if($controlEspecialidad=="on"){
				if($condEgreso<>"F"){
					$controlEspecialidad = "1";
				}else{
					$controlEspecialidad = "0";
					$objdiagnosticomedico->eliminarcontrolesinterconsultas($link,$ctaCte);	
				}
			}else{
				$controlEspecialidad = "0";
				$objdiagnosticomedico->eliminarcontrolesinterconsultas($link,$ctaCte);
			}
	

$sqlInsertar = "INSERT INTO epicrisismedica
								(epimedFechaIng,
								epimedFechaEgr,
								epimedRut,
								epimedEdad,
								epimedPacId,
								epimedFono,
								epimedPrevision,
								epimedDiag,
								epimedFund,
								epimedIndica,
								epimedCama,
								epimedUsuario,
								epimedCtacte,
								epimedCond,
								epimedServicio,
								epimedDias,
								epimedIdMedico,
								epimedMedico,
								epimedEstado,
								idFav,
								epimedGes,
								epimedGesNom,
								epimedPesoIn,
								epimedPesoEg,
								epimedNutricion,
								epimedDestino,
								epimedDestinodet,
								epimedDestinodet2,
								epimedControlEspecialista)
								VALUES
								('$fechaIng',
								'$fechaEgr',
								'$rutPac',
								'$fechaNac',
								'$idPaciente',
								'$fonoCont',
								'$cod_prevision',
								'$diagnosticos',
								'$fundamentos',
								'$detalleEpi',
								'$id_cama',
								'$idUsuario',
								$ctaCte,
								'$condEgreso',
								'$idServicio',
								$difDias,
								'$medico_id',
								'$medico_nom',
								'$cierra',
								'$idFavorito',
								'$opcionGes',
								'$tiposGes',
								'$pesoNac',
								'$pesoAlta',
								'$tipoNutri',
								'$destinoPaciente',
								'$trasladoPaciente',
								'$hogarPaciente',
								'$controlEspecialidad'
								)";
mysql_query("SET NAMES utf8");								
$insertEpicrisis = mysql_query($sqlInsertar) or die($sqlInsertar. " No se logro realizar el Insert de la epicrisis ". mysql_error());

//Recupera el id de la epicrisis creada
$idEpicrisis = mysql_insert_id();

	if(count($operacion)>0){
	$i = 0;
	$cod_opera = (array_keys($operacion));
		foreach($operacion as $valor){
			$opCodigo = $cod_opera[$i];
				$sqlInsOp = "INSERT INTO 
								epimed_has_operacion
								(epimedId,
								opNombre,
								opCod)
								VALUES
								($idEpicrisis,
								'$valor',
								$opCodigo)";
				mysql_query("SET NAMES utf8");
				$queryInsOp = mysql_query($sqlInsOp) or die($sqlInsOp." Error al insertar Operaciones".mysql_error());			
			$i++;
			}
	}

//inserta los controles del paciente

for($i=1;$i<=4;$i++){
	$fechaPrueba = $fechacontrol[$i];
		if($fechaPrueba <> ''){

			$controlFecha = cambiarFormatoFecha2($fechaPrueba);
			echo $controlFecha;
			$sqlInsControl = "INSERT INTO 
							epimed_has_control
							(epimedId,
							controlFecha,
							controlTipo)
							VALUES
							($idEpicrisis,
							'$controlFecha',
							'$control[$i]')";
			mysql_query("SET NAMES utf8");				
			$queryInsControl = mysql_query($sqlInsControl) or die($sqlInsControl." ERROR AL INSERTAR CONTROLES ".mysql_error());
		}
	}	
	
}else{

			if($controlEspecialidad=="on"){
				if($condEgreso<>"F"){
					$controlEspecialidad = "1";
				}else{
					$controlEspecialidad = "0";
					$objdiagnosticomedico->eliminarcontrolesinterconsultas($link,$ctaCte);	
				}
			}else{
				$controlEspecialidad = "0";
				$objdiagnosticomedico->eliminarcontrolesinterconsultas($link,$ctaCte);
			}


// str_replace("world","Peter","Hello world!");
$detalleEpi =str_replace("'","''",$detalleEpi);
$sqlActualizar = "UPDATE epicrisismedica 
					SET epimedFechaIng = '$fechaIng',
						epimedFechaEgr = '$fechaEgr',
						epimedRut = '$rutPac',
						epimedEdad = '$fechaNac',
						epimedPacId = '$idPaciente',
						epimedFono = '$epimedFono',
						epimedPrevision = '$cod_prevision',
						epimedDiag = '$diagnosticos',
						epimedFund = '$fundamentos',
						epimedIndica = '$detalleEpi',
						epimedCama = '$id_cama',
						epimedUsuario = '$idUsuario',
						epimedCtacte = $ctaCte,
						epimedCond = '$condEgreso',
						epimedServicio = '$idServicio',
						epimedDias = $difDias,
						epimedIdMedico = '$medico_id',
						epimedMedico = '$medico_nom',
						epimedEstado = '$cierra',
						idFav = '$idFavorito',
						epimedGes = '$opcionGes',
						epimedGesNom = '$tiposGes',
						epimedPesoIn = '$pesoNac',
						epimedPesoEg = '$pesoAlta',
						epimedNutricion = '$tipoNutri',
						epimedDestino = '$destinoPaciente',
						epimedDestinodet = '$trasladoPaciente',
						epimedDestinodet2 = '$hogarPaciente',
						epimedControlEspecialista = '$controlEspecialidad'
						WHERE epimedId = $idEpicrisis";
mysql_query("SET NAMES utf8");
$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());

//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epimed_has_operacion WHERE epimedId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar operaciones");

if(count($operacion)>0){
	$i = 0;
	$cod_opera = (array_keys($operacion));
	
		foreach($operacion as $valor){
			$opCodigo = $cod_opera[$i];
				$sqlInsOp = "INSERT INTO 
								epimed_has_operacion
								(epimedId,
								opNombre,
								opCod)
								VALUES
								($idEpicrisis,
								'$valor',
								$opCodigo)";
				mysql_query("SET NAMES utf8");
				$queryInsOp = mysql_query($sqlInsOp) or die($sqlInsOp." Error al insertar Operaciones".mysql_error());			
			$i++;
			}
	}
//BORRA LOS CONTROLES ANTES INGRESADOS

		$sqlBorraControles = "DELETE FROM epimed_has_control WHERE epimedId = $idEpicrisis ";
		$queryBorraControles = mysql_query($sqlBorraControles) or die("Error al eliminar controles");

//GUARDA LOS CONTROLES	
		for($i=1;$i<=4;$i++){
			$fechaPrueba = $fechacontrol[$i];
				if($fechaPrueba <> ''){
		
					$controlFecha = cambiarFormatoFecha2($fechaPrueba);
					echo $controlFecha;
					$sqlInsControl = "INSERT INTO 
									epimed_has_control
									(epimedId,
									controlFecha,
									controlTipo)
									VALUES
									($idEpicrisis,
									'$controlFecha',
									'$control[$i]')";
					mysql_query("SET NAMES utf8");				
					$queryInsControl = mysql_query($sqlInsControl) or die($sqlInsControl." ERROR AL INSERTAR CONTROLES ".mysql_error());
				}
			}	

}

if(($act == 1) or ($visualiza == 1)){ 
	if($cama_sn == ''){
		$cama_sn = 0;
		}else{
			$cama_sn = 1;
			}

$sqlLog = "INSERT INTO 
			logEpicrisis
			(logEpiId,
			logPac,
			logCtacte,
			logUsuario,
			logFecha,
			logTipo)
			VALUES
			($idEpicrisis,
			$idPaciente,
			$ctaCte,
			'$idUsuario',
			'$fechaHoy',
			'medica')";
mysql_query("SET NAMES utf8");
$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());

?>
	
    <script>
        window.open('epicrisisDoc/epicrisisMedPDF.php?idEpicrisis=<? echo $idEpicrisis; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $idPaciente; ?>&hospitaliza=<? echo $fechaHosp; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPac; ?>&fechaNac=<? echo $fechaNac; ?>&prevPaciente=<? echo $cod_prevision; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&idServicio=<? echo $idServicio; ?>&controlEspecialidad=<? echo $controlEspecialidad; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>   
    
	<meta http-equiv='refresh' content='0; url=epicrisisMedicaModificada.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $idPaciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $fechaHosp; ?>&epimedica=<? echo $epimedica; ?>'>
	
	<? }else{ ?>
	<script>
        window.open('epicrisisDoc/epicrisisMedPDF.php?idEpicrisis=<? echo $idEpicrisis; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $idPaciente; ?>&hospitaliza=<? echo $fechaHosp; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPac; ?>&fechaNac=<? echo $fechaNac; ?>&prevPaciente=<? echo $cod_prevision; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&idServicio=<? echo $idServicio; ?>&controlEspecialidad=<? echo $controlEspecialidad; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>
		<meta http-equiv='refresh' content='0; url=epicrisisMedicaModificada.php?graba=1&idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $idPaciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $fechaHosp; ?>&epimedica=<? echo $epimedica; ?>'>

<?	}
	
?>