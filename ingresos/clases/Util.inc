<? class Util{
	//METODOS HORAS Y FECHAS
	function eliminaEspacios($string){ //EGS
			
			$cadena = preg_replace('/\s+/', ' ', trim($string));
			return $cadena;
	}//EGS
	//METODOS HORAS Y FECHAS
	function fechaPalabra(){
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
		$fechaHoy = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		
		return $fechaHoy;
		}
	
	function getHora(){ //OBTENER HORA ACTUAL
		date_default_timezone_set("America/Santiago");
		setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M");
		return $Time;
	}
	function getHoraBD(){ //OBTENER LA HORA CORRECTA DE LA ZONA
		date_default_timezone_set("America/Santiago");
		setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M:%S");
		return $Time;
	}
	function getTimeStamp(){ //OBTENER LA TIMESTAMP CORRECTA DE LA ZONA
		date_default_timezone_set("America/Santiago");
		setlocale(LC_TIME, "spanish");
		$Time = strftime("%H:%M:%S");
		$fecha = date('Y-m-d');
		$resultado = $fecha." ".$Time;
		return $resultado;
	}
	function fechasAnteriores($fecha, $cantidad, $formato){
		$fecha_ultima = strtotime($fecha); 
		$dias =($cantidad * 86400); 
		if($formato == 'n')
			$fecha_proxima = date("d-m",$fecha_ultima - $dias);
		if($formato == 'i')
			$fecha_proxima = date("Y-m-d",$fecha_ultima - $dias);
		return $fecha_proxima;
	}
	function fechasSiguientes($fecha, $cantidad, $formato){
		$fecha_ultima = strtotime($fecha); 
		$dias =($cantidad * 86400); 
		if($formato == 'n')
			$fecha_proxima = date("d-m",$fecha_ultima + $dias);
		if($formato == 'i')
			$fecha_proxima = date("Y-m-d",$fecha_ultima + $dias);
		if($formato == 's')
			$fecha_proxima = date("j",$fecha_ultima + $dias);
		if($formato == 'm')
			$fecha_proxima = date("n",$fecha_ultima + $dias);
		if($formato == 'y')
			$fecha_proxima = date("Y",$fecha_ultima + $dias);
		return $fecha_proxima;
	}
	function getPrimerDiaMes($anio,$mes) {
  		return date("Y-m-d",(mktime(0,0,0,$mes,1,$anio)));
	}
	function getUltimoDiaMes($anio,$mes) {
  		return date("Y-m-d",(mktime(0,0,0,$mes+1,1,$anio)-1));
	}	
	//METODOS CONVERSION FECHAS
	function fechaNormal($fecha){
		if($fecha=='')
		return $fecha;
		list($anio,$mes,$dia)=explode("-",$fecha); 
		return $dia."-".$mes."-".$anio; 
	}
	function fechaInvertida($fecha){ 
		list($dia,$mes,$anio)=explode("-",$fecha); 
		return $anio."-".$mes."-".$dia; 
	}
	function edadActual($fecha) { 
		list($anio,$mes,$dia) = explode("-",$fecha);
       $anio_dif = date("Y") - $anio;
       $mes_dif = date("m") - $mes;
       $dia_dif = date("d") - $dia;
       if ($dia_dif < 0 || $mes_dif < 0)
               $anio_dif--;
       return $anio_dif;
	}	
	//GENERA DIGITO RUT
	function generaDigito($rut){
		if($rut == '')
			return '';
		$tur = strrev($rut);
		$mult = 2;
		for ($i = 0; $i <= strlen($tur); $i++) { 
			if ($mult > 7)
				$mult = 2; 
		
		$suma = $mult * substr($tur, $i, 1) + $suma;
		$mult = $mult + 1;
		}
		
		$valor = 11 - ($suma % 11);
		
		if ($valor == 11) { 
		$codigo_veri = "0";
		} elseif ($valor == 10) {
		$codigo_veri = "K";
		} else { 
		$codigo_veri = $valor;
		}
		return $codigo_veri;
	}
	//FORMATEAR SALIDAS
	function formatearNumero($numero){
		return number_format($numero, 0, "", ".");
	}
	function truncarTexto($string, $limit) {
		$break=" ";//CARACTER QUE USA PARA CORTAR LA CADENA
		$pad="...";//AGREGA ESTO AL FINAL DE LA CADENA DE SALIDA
		if(strlen($string) <= $limit)// RETORNA SIN CAMBIOS SI LA CADENA ES MAS CORTA QUE EL LIMITE ESTABLECIDO
			return $string;
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}
	function ocultarTexto($string){
		$string = substr($string, 0, -3)."xxx";
		return $string;
	}
	function getMesPalabra($MEScod){
		$meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
		$datos['mes'] = $meses[$MEScod];
		return ($datos);		
	}		
	function getFechaPalabra($fecha){
		$DIAcod = date('N',strtotime($fecha));
		$DIAdesc = date('d',strtotime($fecha));
		$MEScod = date('n',strtotime($fecha));
		$ANIOcod = date('Y',strtotime($fecha));
		$dias = array(1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo');
		$meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
		$datos = $dias[$DIAcod]." ".$DIAdesc." de ".$meses[$MEScod]." de ".$ANIOcod;
		//$datos = strtoupper($datos);
		return ($datos);		
	}
	//VALIDACIONES 
	function isFile($datos){
		$tmp = tempnam("tmp","tmp").".pdf";
		$fp = fopen($tmp,"w");
		fputs($fp,$datos);
		fclose($datos);
		return $tmp;
	}
	function calcularMinutos($hora1,$hora2){ 
		list($horas_1,$minutos_1) = explode(':',$hora1); 
		list($horas_2,$minutos_2) = explode(':',$hora2);
		$total_minutos_1 = ($horas_1 * 60)+ $minutos_1; 
		$total_minutos_2 = ($horas_2 * 60)+ $minutos_2;
		$total_minutos_trasncurridos = $total_minutos_2 - $total_minutos_1; 
		return $total_minutos_trasncurridos;
	}
	function filtroQuery($variable, $tipo_dato, $valorDefinido="", $valorNoDefinido=""){
		$variable = get_magic_quotes_gpc() ? stripslashes($variable) : $variable;
		$variable = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($variable) : mysql_escape_string($variable);
		switch ($tipo_dato) {
			case "text":
								$variable = ($variable != "") ? "'" . $variable . "'" : "NULL";
								break;    
			case "long":
								break; 
			case "int":
								$variable = ($variable != "") ? intval($variable) : "NULL";
								break;
			case "double":
								$variable = ($variable != "") ? "'" . doubleval($variable) . "'" : "NULL";
								break;
			case "date":
								$variable = ($variable != "") ? "'" . $variable . "'" : "NULL";
								break;
			case "defined":
								$variable = ($variable != "") ? $valorDefinido : $valorNoDefinido;
								break;
		}
		return $variable;
	}
	function queSexo($sexo){
		if($sexo == 'M'){
			$sexoCm = "Masculino";
			}else if($sexo == 'F'){
				$sexoCm = "Femenino";
				}else{
					$sexoCm = "Indefinido";
					}
		return $sexoCm;
	}
	
	function quePrevision($link,$cod_prevision){
		require_once('Conectar.inc'); 
		$objConectar = new Conectar; 
		$objConectar->db_select("paciente",$link);
		$sql = "SELECT id, prevision
				FROM prevision
				WHERE id = '$cod_prevision'";
		$query = mysql_query($sql) or die("ERROR AL SELECCIONAR DATOS DE PREVISION");
		$RSprevision = mysql_fetch_assoc($query);
		$previsionNom = $RSprevision['prevision'];
		return ($previsionNom);
		}
		
	function daysDifference($endDate, $beginDate){
	 $date_parts1=explode("-", $beginDate);
	 $date_parts2=explode("-", $endDate);
	 $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
	 $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	 return $end_date - $start_date;
	}
	
	function soloanios($fecha_de_nacimiento){
	$fecha_actual = date ("Y-m-d"); 

	// separamos en partes las fechas 
	$array_nacimiento = explode ( "-", $fecha_de_nacimiento ); 
	$array_actual = explode ( "-", $fecha_actual ); 
	
	if($array_nacimiento[0] > 1900){
		
	$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
		}
	
	return($anos);
	}
	
	function calculoAMD($fecha_de_nacimiento){ 

	$fecha_actual = date ("Y-m-d"); 
	
	// separamos en partes las fechas 
	$array_nacimiento = explode ( "-", $fecha_de_nacimiento ); 
	$array_actual = explode ( "-", $fecha_actual ); 
	
	if($array_nacimiento[0] > 1900){
		
	$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
	$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
	$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 
	
	
		
	//ajuste de posible negativo en $días 
	if ($dias < 0) 
	{ 
		--$meses; 
	
		//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
		switch ($array_actual[1]) { 
			   case 1:     $dias_mes_anterior=31; break; 
			   case 2:     $dias_mes_anterior=31; break; 
			   case 3:  
					/*if (bisiesto($array_actual[0])) 
					{ 
						$dias_mes_anterior=29; break; 
					} else { 
						$dias_mes_anterior=28; break; 
					} */
					$dias_mes_anterior=29; break;
			   case 4:     $dias_mes_anterior=31; break; 
			   case 5:     $dias_mes_anterior=30; break; 
			   case 6:     $dias_mes_anterior=31; break; 
			   case 7:     $dias_mes_anterior=30; break; 
			   case 8:     $dias_mes_anterior=31; break; 
			   case 9:     $dias_mes_anterior=31; break; 
			   case 10:     $dias_mes_anterior=30; break; 
			   case 11:     $dias_mes_anterior=31; break; 
			   case 12:     $dias_mes_anterior=30; break; 
		} 
	
		$dias=$dias + $dias_mes_anterior; 
	} 
	
	//ajuste de posible negativo en $meses 
	if ($meses < 0) 
	{ 
		--$anos; 
		$meses=$meses + 12; 
	} 
	
	$edadCompleta = "$anos (a), $meses (m) y $dias (d)"; 
	return($edadCompleta);
	
	}else{
		
		return("* Verificar Fecha de Nacimiento");
		}
	}
	
	 function arrayAJson($arrayQR){
		$i=0;
		if(mysql_num_rows($arrayQR)){
		while($RSdatos = mysql_fetch_array($arrayQR)){
		$datos[$i] = array("id"=>$RSdatos['0'],"valor"=>$RSdatos['1']);
		$i++;
		}
		}else{
		$datos[0] = array("id"=>'',"valor"=>'SIN DATOS...');
		}
		return json_encode($datos);
	}
	
	function queFormato($tipo){
		switch($tipo){
			case 2:
				$textoFormato = "<strong>- <u>Otros Examenes</u></strong> &nbsp;<br/>
								<table border='1'>
								  <tr>
									<td width='180'>Examen</td>
									<td width='100'>Fecha</td>
									<td width='100'>Resultados</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>		
								  </tr>
								</table>
								<br/>";
				
			break;
			case 3:
				$textoFormato = "<strong>- <u>Examenes Pendientes</u></strong> &nbsp;<br/>
								<table border='1'>
								  <tr>
									<td width='180'>Examen</td>
									<td width='100'>Fecha</td>
									<td width='100'>Lugar</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>		
								  </tr>
								</table>
								<br/>
								<strong>Existencia de exámenes con resultado pendiente señalando claramente de cuales se trata, cuándo y dónde deben retirarse y/o informarse. </strong>";
			break;
			
			}
			return ($textoFormato);
		}	
		
function cual_tipo($cod_serv){

	switch($cod_serv){
		
		case(1):
			$tipo_1 = 2;
			$d_tipo_1 = "MEDICINA";
			break;
		case(2):
			$tipo_1 = 2;
			$d_tipo_1 = "MEDICINA";
			break;
		case(3):
			$tipo_1 = 1;
			$d_tipo_1 = "CIRUGIA"; 
			break;
		case(4):
			$tipo_1 = 1;
			$d_tipo_1 = "CIRUGIA"; 
			break;
		case(5):
			$tipo_1 = 7;
			$d_tipo_1 = "TRAUMATOLOGIA"; 
			break;
		case(6):
			$tipo_1 = 15;
			$d_tipo_1 = "NEONATOLOGIA CUNA BASICA"; 
			break;
		case(7):
			$tipo_1 = 5;
			$d_tipo_1 = "PEDIATRIA INDIFERENCIADA";
			break;
		case(8):
			$tipo_1 = 11;
			$d_tipo_1 = "UCI"; 
			break;
		case(9):
			$tipo_1 = 12;
			$d_tipo_1 = "SAI"; 
			break;
		case(10):
			$tipo_1 = 8;
			$d_tipo_1 = "GINECOLOGIA"; 
			break;
		case(11):
			$tipo_1 = 9;
			$d_tipo_1 = "OBSTETRICIA"; 
			break;
		case(12):
			$tipo_1 = 10;
			$d_tipo_1 = "PSIQUIATRIA"; 
			break;	
		case(14):
			$tipo_1 = 9;
			$d_tipo_1 = "OBSTETRICIA"; 
			break;
		case(45):
			$tipo_1 = 45;
			$d_tipo_1 = "PARTOS"; 
			break;
		case(46):
			$tipo_1 = 46;
			$d_tipo_1 = "PENSIONADO"; 
			break;	
		}
		return $tipo_1."-".$d_tipo_1;
	}
	function hacecuanto($date1,$date2){ 
		
		$s = strtotime($date1)-strtotime($date2); 
		$d = intval($s/86400); 
		$s -= $d*86400; 
		$h = intval($s/3600); 
		$s -= $h*3600; 
		$m = intval($s/60); 
		$s -= $m*60; 
		
		// convertir a positivo 
		if($d < 0){ 
		$d=$d*-1; 
		} 
		if($h < 0){ 
		$h=$h*-1; 
		} 
		if($m < 0){ 
		$m=$m*-1; 
		} 
		if($s < 0){ 
		$s=$s*-1; 
		} 
		
		
		// Solo mostrar si no es 0 
		if($d > 0){ 
		$dias=$d." dias "; 
		} 
		if($h > 0){ 
		$horas=$h."hs. "; 
		} 
		if($m > 0){ 
		$minutos=$m."min. "; 
		} 
		
		//si se envio hoy 
		if($d == 0){ 
		$dias=""; 
		} 
		
		$diferencia=$dias."".$horas.$minutos.$segundos.""; 
		
		
		return $diferencia; 
		}

}?>