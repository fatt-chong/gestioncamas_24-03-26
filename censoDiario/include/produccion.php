<? ini_set('memory_limit','256M'); ?>
<?php set_time_limit(5000); ?>
<?php
	ob_start(); 

	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

	  switch ($theType) {
	    case "text":
	      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	      break;    
	    case "long":
	    case "int":
	      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	      break;
	    case "double":
	      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	      break;
	    case "date":
	      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	      break;
	    case "defined":
	      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
    	  break;
	  }
	  return $theValue;
	}

   function ultimoDiaMes($mes,$ano) 
   { 
      for ($dia=28;$dia<=31;$dia++) 
         if(checkdate($mes,$dia,$ano)) $fecha="$ano-$mes-$dia"; 
      return $fecha;
   }

	function recupera_diacama($codigo_servicio,$sala) {
			switch ($codigo_servicio) {
					case "1":
					case "2":
					case "3":
					case "10":
					case "45":
					case "11":
					case "4":	
					case "48":
					case "14":																			
					case "5":  // Medicina, Oncologia, Cirugia, Ginecoloogia y Obstetricia, Parto, Puerperio, Cirugia Aislamiento, Pre-Alta, Embarazo Patologico, Traumatología 
						$diacama = '0203001';
						break;
					case "7":  // Pediatria
						$diacama = '0203001';
						if ( trim($sala) == 'UTI - Pediatrica') {
							$diacama = '0203003';
						}
						if ( trim($sala) == 'Aislamiento') {
							$diacama = '0203006';
						}						
						break;
					case "6":  // Neonatologia
						$diacama = '0203015';
						if ( trim($sala) == 'NEONATOLOGIA UCI') {
							$diacama = '0203004';
						}
						if ( trim($sala) == 'NEONATOLOGIA INTERMEDIO (INCUBADORA)') {
							$diacama = '0203007';
						}						
						break;
					case "12": // Psiquiatria Corta Estadia
						$diacama = '0203109';
						break;
					case "8": // UCI
						$diacama = '0203002';
						break;	
					case "9": // UTI - SAI
						$diacama = '0203005';
						break;																									
			}		
			return $diacama;
	}
	
	function DiferenciaFecha($fecha1, $fecha2){

		$s = strtotime($fecha1)-strtotime($fecha2);
		$d = intval($s/86400);
		$s -= $d*86400;
		$h = intval($s/3600);
		$s -= $h*3600;
		$m = intval($s/60);
		$s -= $m*60;

	//	$dif= (($d*24)+$h).hrs." ".$m."min";
	//	$dif2= $d.$space.dias." ".$h.hrs." ".$m."min";
		return $d;
	}	

	// Se define dia de corte
	$dia_corte = 6;
	
	$dia_proceso = date("d");
	$mes_proceso  = date("m");
	$ano_proceso = date("Y");
	$fecha_actual = date('Y-m-d');

	if ($dia_proceso <= $dia_corte) {
		if ( $mes_proceso > 1 ) {
			$mes_proceso = $mes_proceso - 1;
		} else {
			$mes_proceso = 12;
			$ano_proceso = $ano_proceso - 1;	
		}
	}
	
	//$fecha_inicial = $ano_proceso . '-' . $mes_proceso . '-01';
	$fecha_inicial = date("Y-m-d",time()-(1*(24*60*60)));
	$fecha_final = date("Y-m-d",time()-(1*(24*60*60))); //date('Y-m-d');
	// Se actualiza informacion de los montos de los registros creados desde los módulos del Cristian.
 //  require_once("actualiza_valor_prestaciones_tipoRI.php");	
	
	// Borramos los registros procesados del mes a la fecha

//	mysql_select_db('estadistica', $paciente);	
//	$query_delete_matriz = sprintf("delete from matrizppvppi where matrizppvppi.matrizFDigitacion >= %s AND ISNULL(matrizppvppi.matrizTipoRegistro)",GetSQLValueString($fecha_inicial,"date"));
//	$rs_delete_matriz = mysql_query($query_delete_matriz, $paciente) or die(mysql_error());	

	// Creamos los registros desde el 1ero del mes de proceso a la fecha
	require_once("CargaRayos.php");
	require_once("CargaAnatomia.php");
	require_once("CargaUrgencia.php");
	require_once("CargaLaboratorio.php");
	require_once("CargaDialisis.php");
	require_once("CargaPabellonInterv1.php");
	require_once("CargaPabellonInterv2.php");
    require_once("CargaInsumos.php");
	require_once("CargaDiaCama.php");
	require_once("CargaParto.php");

	$txt = fopen("log_produccion.txt","a+");
	fwrite($txt, date("d-m-Y G:i:s").chr(10));
	fclose($txt);
	
//	$GoTo = "Carga_Produccion_hora_especifica.html";
//	header(sprintf("Location: %s", $GoTo));
	
	ob_end_flush();
?>