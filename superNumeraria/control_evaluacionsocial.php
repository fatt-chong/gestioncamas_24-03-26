<? session_start();
$usuario = $_SESSION['MM_Username'];
//RECEPCION DE VARIABLES
$idCama = $_POST['idCama'];
$accion = $_POST['accion'];
$fechaHoy = date('Y-m-d');

require_once('../../gestionCamas2/clases/Conectar.inc'); $objConectar = new Conectar; $link = $objConectar->db_connect();
require_once("../../gestionCamas2/clases/Evaluacionsocial.inc"); $objEvaluacionsocial = new Evaluacionsocial;
//CONSULTA SI YA EXISTE CATEGORIZACION DEL PACIENTE
$ctacte = $_POST["ctacte"];
$validaEvaluacionsocial= $objEvaluacionsocial->buscarEvaluacionsocial($link,$ctacte);
$idvalidaEvaluacionsocial = $validaEvaluacionsocial['ED_ctacte'];
if($idvalidaEvaluacionsocial == ''){
	$valor = 0;
}else{
	$valor = $idvalidaEvaluacionsocial;
}
if($valor==0){		//INSERTA UNA NUEVA CATEGORIZACION PARA PACIENTE
	$ED_recidencia = $_POST["ED_recidencia"];
	$ED_economica = $_POST["ED_economica"];
	$ED_mental = $_POST["ED_mental"];
	$ED_familiar = $_POST["ED_familiar"];
	$ED_cuidador = $_POST["ED_cuidador"];
	$ED_fecha = $fechaHoy;
	$idPaciente = $_POST["idPaciente"];
	$CAT_id = $objEvaluacionsocial->buscarCategorizacion($link,$ctacte,$idPaciente);
	$objEvaluacionsocial->insertaEvaluacionsocial($link,$ctacte,$usuario,$ED_recidencia,$ED_economica,$ED_mental,$ED_familiar,$ED_cuidador,$ED_fecha,$CAT_id);
}else{	//ACTUALIZA CATEGORIZACION DE PACIENTE
	$ED_recidencia = $_POST["ED_recidencia"];
	$ED_economica = $_POST["ED_economica"];
	$ED_mental = $_POST["ED_mental"];
	$ED_familiar = $_POST["ED_familiar"];
	$ED_cuidador = $_POST["ED_cuidador"];
	$ED_fecha = $fechaHoy;
	$objEvaluacionsocial-> actualizaEvaluacionsocial($link,$ctacte,$usuario,$ED_recidencia,$ED_economica,$ED_mental,$ED_familiar,$ED_cuidador,$ED_fecha);
}
?>
<script>
	window.location.href="camaSuperNum.php";
</script>
