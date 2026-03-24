<?

// include "../funciones/epicrisis_funciones.php";
require_once("../funciones/epicrisis_funciones.php");
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");
$act= $_POST['act'];
$cama_sn= $_POST['cama_sn'];
$cierra= $_POST['cierra'];

$ingFecha = $_REQUEST['ingFecha'];
$altFecha = $_REQUEST['altFecha'];
$difDias = $_REQUEST['difDias'];
$fechaNac = $_REQUEST['fechaNac'];

$rutPac = $_REQUEST['rutPac'];
$id_cama = $_REQUEST['id_cama'];
$id_paciente = $_REQUEST['id_paciente'];
$cod_prev = $_REQUEST['cod_prev'];
$fonoCont = $_REQUEST['fonoCont'];
$epiRut = $_REQUEST['epiRut'];
$herida = $_REQUEST['herida'];
$pieDiab = $_REQUEST['pieDiab'];
$multiRes = $_REQUEST['multiRes'];
$escaras = $_REQUEST['escaras'];
$tipoYeso = $_REQUEST['tipoYeso'];
$diagnosticos = $_REQUEST['diagnosticos'];
$barthel = $_REQUEST['barthel'];
$detalleEpi = $_REQUEST['detalleEpi'];
$destinoPaciente = $_REQUEST['destinoPaciente'];
$trasladoPaciente = $_REQUEST['trasladoPaciente'];
$idUsuario = $_REQUEST['idUsuario'];
$ctaCte = $_REQUEST['ctaCte'];
$condEgreso = $_REQUEST['condEgreso'];
$idServicio = $_REQUEST['idServicio'];
$enfermeras = $_REQUEST['enfermeras'];
$hospDom = $_REQUEST['hospDom'];
$hogarPaciente = $_REQUEST['hogarPaciente'];
$cierra = $_REQUEST['cierra'];
$responsable = $_REQUEST['responsable'];
$rutResp = $_REQUEST['rutResp'];
$nomResp = $_REQUEST['nomResp'];
$pesoNac = $_REQUEST['pesoNac'];
$pesoAlta = $_REQUEST['pesoAlta'];
$otroResponsable = $_REQUEST['otroResponsable'];
$derivadoa = $_POST['derivadoa'];
$barthele = $_REQUEST['barthele'];
$educaArray = $_POST['educaArray']; 

$valorBart		= $_REQUEST['valorBart'];
$valorBartele	= $_REQUEST['valorBartele'];
$fecha_sep		= $_REQUEST['fecha_sep'];

$nombrePaciente = $_REQUEST['nombrePaciente'];
$fichaPaciente  = $_REQUEST['fichaPaciente'];
$direccion	= $_REQUEST['direccion'];

$generoPaciente	= $_REQUEST['generoPaciente'];
$serv_paciente	= $_REQUEST['serv_paciente'];
$rutPaciente	= $_REQUEST['rutPaciente'];
$nacimiento		= $_REQUEST['nacimiento'];
$prev_paciente	= $_REQUEST['prev_paciente'];
$visualiza		= $_REQUEST['visualiza'];
$cama_sn		= $_REQUEST['cama_sn'];
$desde			= $_REQUEST['desde'];


								
$fechaHoy = date("Y-m-d H:i:s");
$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);
$digitoRut = ValidaDVRut($epiRut);



//VERIFICA SI EXISTE ALGUNA EPICRISIS CREADA
$sqlEpicrisis = mysql_query("SELECT * 
				FROM epicrisisenf
				WHERE epienfctaCte = '$ctaCte'") or die("Error al seleccionar la epicrisis ".mysql_error());
				
$arrayEpicrisis = mysql_fetch_array($sqlEpicrisis);

$idEpicrisis = $arrayEpicrisis['epienfId'];

if($barthel == ''){
	$barthel = "NULL";
}
if($barthele == ''){
	$barthele = "NULL";
}

if($idServicio == 7){
	$enlace = 'epicrisisEnfPedPDF';
	}else if($idServicio == 6){
		$enlace = 'epicrisisEnfNeoPDF';
		}else{
			$enlace = 'epicrisisEnfPDF';
			}

if($idEpicrisis == ''){
	
$sqlInsertar = "INSERT INTO epicrisisEnf
								(epienfFechaIng,
								epienfFechaEgr,
								epienfDias,
								epienfEdad,
								epienfPacId,
								epienfPrevision,
								epienfFono,
								epienfCie10,
								epienfRut,
								epienfHerida,
								epienfPie,
								epienfMr,
								epienfEscara,
								epienfYeso,
								epienfBarthel,
								epienfIndica,
								epienfIdCama,
								epienfDestino,
								epienfTraslado,
								epienfUsuario,
								epienfCtacte,
								epienfCond,
								epienfServicio,
								epienfEnfermera,
								epienfHosdom,
								epienfHogar,
								epienfEstado,
								epienfResp,
								epienfRespRut,
								epienfRespNom,
								epienfPesoNac,
								epienfPesoAlta,
								epienfRespOtro)
								VALUES
								('$fechaIng',
								'$fechaEgr',
								$difDias,
								'$fechaNac',
								'$id_paciente',
								'$cod_prev',
								'$fonoCont',
								'$diagnosticos',
								'$epiRut',
								'$herida',
								'$pieDiab',
								'$multiRes',
								'$escaras',
								'$tipoYeso',
								$barthel,
								'$detalleEpi',
								'$id_cama',
								'$destinoPaciente',
								'$trasladoPaciente',
								'$idUsuario',
								$ctaCte,
								'$condEgreso',
								'$idServicio',
								'$enfermeras',
								'$hospDom',
								'$hogarPaciente',
								'$cierra',
								'$responsable',
								'$rutResp',
								'$nomResp',
								'$pesoNac',
								'$pesoAlta',
								'$otroResponsable')";
mysql_query("SET NAMES utf8");								
$insertEpicrisis = mysql_query($sqlInsertar) or die($sqlInsertar. " No se logro realizar el Insert de la epicrisis ". mysql_error());
$idEpicrisis = mysql_insert_id();//Recupera el id de la epicrisis creada
$sqlbarthel="UPDATE camas.listasn SET listasn.barthelegreso= '$barthele' WHERE listasn.ctaCteSN = '$ctaCte'";
mysql_query("SET NAMES utf8");
mysql_query($sqlbarthel) or die($sqlbarthel. " No se logro realizar el update del barthel ". mysql_error());
	if(count($educaArray)>0){ //Hace ciclo para guardar las educaciones
		foreach($educaArray as $valor){
			$sqlInsEdu = "INSERT INTO 
						epienf_has_educapac
						(epienfId,
						educaId)
						VALUES
						($idEpicrisis,
						$valor)";
			$queryInsEdu = mysql_query($sqlInsEdu) or die("Error al insertar tipo de educaciones 1");			
		}
	}
	$sqlderivada="INSERT INTO camas.derivada(der_ctacte, der_descripcion) values($ctaCte, '$derivadoa')"; echo $sqlderivada;
	mysql_query($sqlderivada) or die("Error al insertar tipo de educaciones 2");

}else{
	$sqlbarthel="UPDATE camas.listasn SET listasn.barthelegreso= '$barthele' WHERE listasn.ctaCteSN = '$ctaCte'";
mysql_query("SET NAMES utf8");
mysql_query($sqlbarthel) or die($sqlbarthel. " No se logro realizar el update del barthel ". mysql_error());
$sqlPregunta = mysql_query("SELECT epienfEstado FROM epicrisisenf WHERE epienfId = $idEpicrisis") or die("Error al seleccionar estado".mysql_error());
$arrayPregunta = mysql_fetch_array($sqlPregunta);
$estadoEpi = $arrayPregunta['epienfEstado'];
	
	if(($cierra == 1) or ($estadoEpi == 1)){
		$cierra = 1;
		}else{
			$cierra = 0;
			}
$sql = "SELECT der_descripcion from camas.derivada where der_ctacte = '$ctaCte'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sql) or die($sql." <br>ERROR AL OBTENER traederivacionesa<br>".mysql_error());
	$query = mysql_fetch_array($query);
if($query['der_descripcion'] != ""){
	$sqlup = "UPDATE camas.derivada SET der_ctacte = '$ctaCte', der_descripcion ='$derivadoa' WHERE der_ctacte = '$ctaCte'";
	mysql_query("SET NAMES utf8"); //echo $sqlup;
	mysql_query($sqlup) or die($sqlup." <br>ERROR AL OBTENER actualizaderivacionesasn<br>".mysql_error());
}else{
	$sqlderivada="INSERT INTO camas.derivada(der_ctacte, der_descripcion) values($ctaCte, '$derivadoa')"; echo $sqlderivada;
	mysql_query($sqlderivada) or die("Error al insertar tipo de camas derivadas");
}
$sqlActualizar = "UPDATE epicrisisEnf 
					SET epienfFechaIng = '$fechaIng',
						epienfFechaEgr = '$fechaEgr',
						epienfDias = $difDias,
						epienfEdad = '$fechaNac',
						epienfPacId = $id_paciente,
						epienfPrevision = '$cod_prev',
						epienfFono = '$fonoCont',
						epienfCie10 = '$diagnosticos',
						epienfRut = '$epiRut',
						epienfHerida = '$herida',
						epienfPie = '$pieDiab',
						epienfMr = '$multiRes',
						epienfEscara = '$escaras',
						epienfYeso = '$tipoYeso',
						epienfBarthel = $barthel,
						epienfIndica = '$detalleEpi',
						epienfIdCama = $id_cama,
						epienfDestino = '$destinoPaciente',
						epienfTraslado = '$trasladoPaciente',
						epienfCtacte = $ctaCte,
						epienfCond = '$condEgreso',
						epienfServicio = $idServicio,
						epienfEnfermera = '$enfermeras',
						epienfHosdom = '$hospDom',
						epienfUsuario = '$idUsuario',
						epienfHogar = '$hogarPaciente',
						epienfEstado = '$cierra',
						epienfResp = '$responsable',
						epienfRespRut = '$rutResp',
						epienfRespNom ='$nomResp',
						epienfPesoNac = '$pesoNac',
						epienfPesoAlta = '$pesoAlta',
						epienfRespOtro = '$otroResponsable'	
						WHERE epienfId = $idEpicrisis";
mysql_query("SET NAMES utf8");
$updateEpicrisis = mysql_query($sqlActualizar) or die($sqlActualizar. " No se logro realizar el Update de la epicrisis ". mysql_error());
	
	//BORRA LO ANTES GUARDADO
		$sqlBorra = "DELETE FROM epienf_has_educapac WHERE epienfId = $idEpicrisis ";
		$queryBorra = mysql_query($sqlBorra) or die("Error al eliminar educaciones");
		
	if(count($educaArray)>0){
		
		//Y VUELVE A GUADAR LO NUEVO
		
		//Hace ciclo para guardar las educaciones
		
		foreach($educaArray as $valor){
			
				$sqlInsEdu = "INSERT INTO 
								epienf_has_educapac
								(epienfId,
								educaId)
								VALUES
								($idEpicrisis,
								$valor)";
				$queryInsEdu = mysql_query($sqlInsEdu) or die("Error al insertar tipo de educaciones");			
			}
	}

}

if($act == 1){ 
	if(($cama_sn == '') or ($cama_sn == 0)){
		$cama_sn = 0;
	}else{
		$cama_sn = 1;
	}
			
//INSERTA REGISTRO CADA VEZ QUE SE CIERRE LA EPICRISIS

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
			$id_paciente,
			$ctaCte,
			'$idUsuario',
			'$fechaHoy',
			'enfermera')";
			mysql_query("SET NAMES utf8");
$queryLog = mysql_query($sqlLog) or die ("Error al insertar nuevo registro en Logepicrisis ".mysql_error());

?>
	
    <script>
    	// alert("prueba");
        window.open('epicrisisDoc/<? echo $enlace; ?>.php?idEpicrisis=<? echo $idEpicrisis; ?>&vbarthel=<? echo $valorBart; ?>&barthel=<? echo $barthel; ?>&vbarthele=<? echo $valorBartele; ?>&barthele=<? echo $barthele; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $id_paciente; ?>&hospitaliza=<? echo $fecha_sep; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPaciente; ?>&fechaNac=<? echo $fechaNac; ?>&nacimiento=<? echo $nacimiento; ?>&prevPaciente=<? echo $prev_paciente; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&cama_sn=<? echo $cama_sn; ?>&digitoR=<? echo $digitoRut; ?>&desde=<? echo $desde; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script>   

	<meta http-equiv='refresh' content='0; url=epicrisisEnfermera.php?idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>&desde=<? echo $desde; ?>'>

	
	<? }else{ ?>
    	    
    	     <script>
    	// alert("prueba");
        window.open('epicrisisDoc/<? echo $enlace; ?>.php?idEpicrisis=<? echo $idEpicrisis; ?>&vbarthel=<? echo $valorBart; ?>&barthel=<? echo $barthel; ?>&vbarthele=<? echo $valorBartele; ?>&barthele=<? echo $barthele; ?>&nomCR=<? echo $nomCR;?>&id_paciente=<? echo $id_paciente; ?>&hospitaliza=<? echo $fecha_sep; ?>&nombrePaciente=<? echo $nombrePaciente; ?>&fichaPaciente=<? echo $fichaPaciente; ?>&direccionPac=<? echo $direccion; ?>&generoPaciente=<? echo $generoPaciente; ?>&serv_paciente=<? echo $serv_paciente; ?>&rutPaciente=<? echo $rutPaciente; ?>&fechaNac=<? echo $fechaNac; ?>&nacimiento=<? echo $nacimiento; ?>&prevPaciente=<? echo $prev_paciente; ?>&visualiza=<? echo $visualiza; ?>&ctaCte=<? echo $ctaCte; ?>&cama_sn=<? echo $cama_sn; ?>&digitoR=<? echo $digitoRut; ?>&desde=<? echo $desde; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    </script> 
		<meta http-equiv='refresh' content='0; url=epicrisisEnfermera.php?graba=1&idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&multiRes=<? echo $multiRes; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>&desde=<? echo $desde; ?>'>

<?		}
	
?>