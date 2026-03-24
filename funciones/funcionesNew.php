<? 

function primerDiaMes(){
    $date = date("01-m-Y");
    return $date;		
}
function HrSistem(){ //OBTENER LA HORA CORRECTA DE LA ZONA
    date_default_timezone_set("America/Santiago");
    setlocale(LC_TIME, "spanish");
    $Time = strftime("%H:%M:%S");
    return $Time;
}
function soloHora(){ //OBTENER HORA ACTUAL
    date_default_timezone_set("America/Santiago");
    setlocale(LC_TIME, "spanish");
    $Time = strftime("%H");
    return $Time;
}
function soloMinuto(){ //OBTENER MINUTO ACTUAL
    date_default_timezone_set("America/Santiago");
    setlocale(LC_TIME, "spanish");
    $Time = strftime("%M");
    return $Time;
}

function generaDigito($rut){
	if($rut == '')
		return '';
 	$tur = strrev($rut);
    $mult = 2;
 
    for ($i = 0; $i <= strlen($tur); $i++) { 
       if ($mult > 7) $mult = 2;
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
function Edad($fechaNac){
	list($anio,$mes,$dia) = explode("-",$fechaNac);
	$anio_dif = date("Y") - $anio;
	$mes_dif = date("m") - $mes;
	$dia_dif = date("d") - $dia;
	if ($dia_dif < 0 && $mes_dif < 0)
		$anio_dif--;
	return $anio_dif;
}
function calculaEdad($fechaNac){ 
	//Esta funcion toma una fecha de nacimiento  
	//desde una base de datos mysql 
	//en formato aaaa/mm/dd y calcula la edad en números enteros 
	
	$dia=date("j"); 
	$mes=date("n"); 
	$anno=date("Y"); 
	
	//descomponer fecha de nacimiento 
	$dia_nac=substr($fechaNac, 8, 2); 
	$mes_nac=substr($fechaNac, 5, 2); 
	$anno_nac=substr($fechaNac, 0, 4); 
	
	
	if($mes_nac>$mes){ 
		$calc_edad= $anno-$anno_nac-1; 
	}else{ 
		if($mes==$mes_nac AND $dia_nac>$dia){ 
			$calc_edad= $anno-$anno_nac-1;  
		}else{ 
			$calc_edad= $anno-$anno_nac; 
		} 
	} 
	return $calc_edad; 
}

function nombrePrevision($previson){
	switch($previson){
	case(0):
	return	"FONASA A";
	break;
	case(1):
	return "FONASA B";
	break;
	case(2):
	return	"FONASA C";
	break;
	case(3):
	return "FONASA D";
	break;
	case(4):	
	return "PARTICULAR2";
	break;
	case(5):
	return "Alemana Salud S.A.";
	break;
	case(6):	
	return "Banmédica S.A.";
	break;
	case(7):	
	return "Chuquicamata Ltda.";
	break;
	case(8):	
	return "Colmena Golden Cross S.A.";
	break;
	case(9):	
	return "Consalud S.A.";
	break;
	case(10):	
	return "Cruz del Norte Ltda.";
	break;
	case(11):	
	return "Ferrosalud S.A.";
	break;
	case(12):	
	return "Fundación Ltda.";
	break;
	case(13):	
	return "Fusat Ltda.";
	break;
	case(14):	
	return "ING Salud S.A.";
	break;
	case(15):	
	return "Mas Vida S.A.";
	break;
	case(16):	
	return "Normédica S.A.";
	break;
	case(17):	
	return "Río Blanco Ltda.";
	break;
	case(18):	
	return "San Lorenzo Ltda.";
	break;
	case(19):	
	return "Vida Tres S.A.";
	break;
	case(22):	
	return "Aetna Salud S.A.";
	break;
	case(25):	
	return "Cigna Salud Prevision S.A";
	break;
	case(26):	
	return "Compensacion S.A.";
	break;
	case(27):	
	return "Crisol S.A.";
	break;
	case(28):	
	return "Cruz Blanca S.A.";
	break;
	case(30):	
	return "F.a.s.t Bco Del Estado";
	break;
	case(31):
	return "Fdacion.salud Shell Chile";
	break;
	case(32):	
	return "Fund.salud El Teniente";
	break;
	case(34):	
	return "Genesis S.A.";
	break;
	case(35):	
	return "Instsalud S.A.";
	break;
	case(36):	
	return "Isagas S.A.";
	break;
	case(37):	
	return "Isamedica S.A.";
	break;
	case(38):	
	return "Iscar S.A.";
	break;
	case(39):	
	return "Ismed S.A.";
	break;
	case(40):	
	return "Ispen Ltda.";
	break;
	case(41):	
	return "Istel S.A.";
	break;
	case(42):	
	return "Master Salud S.A.";
	break;
	case(43):	
	return "Naturmed S.A.";
	break;
	case(44):	
	return "Optima Salud S.A.";
	break;
	case(45):	
	return "Promepart";
	break;
	case(46):	
	return "Sfera S.A.";
	break;
	case(47):	
	return "Umbral S.A.";
	break;
	case(48):	
	return "Unimed S.A.";
	break;
	case(49):	
	return "Vida Plena S.A.";
	break;
	}
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
		}
		return $tipo_1." ".$d_tipo_1;
	}

function clasificaPrevision($prevision, $convenio){
	switch($convenio){
		//CASO SIN PREVISION
		case '':	return 9;
					break;
		case 0:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE 
					break; //SIN CONVENIO
		//CASOS PREVISION FONASAS
		case 1:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE
					break;
		//CASO PREVISION ISAPRE
		case 2:		return 6; // ISAPRE
					break;
		//CASO PREVISION PARTICULAR
		case 3:		return 8; //PARTICULAR
					break;
		//CASO DE OTROS ERAN ACCIDENTES
		case 4:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE 
					break; //ACC TRABAJO
		case 13:	return 2; //ACC ESCOLAR - RETORNA FONASA A
					break;
		case 14:	if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE  
					break;//ACC TRANSITO
		//CASO SUBSIDIOS
		case 5:		return 2; //AUGE - RETORNA FONASA A
					break;	
		case 6:		return 2; //ADULTO MAYOR - RETORNA FONASA A
					break;
		case 12:	return 2; //PRAIS - RETORNA FONASA A
					break;
		//CASO DE CONVENIOS FUERZAS ARMADAS
		case 7:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE
					break; //ARMADA
		case 8:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE
					break; //EJERCITO
		case 9:		if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE
					break; //CAPREDENA
		case 10:	if($prevision == 0) return 2; //FONASA A
					else if($prevision == -1) return 9; //S/Prev
					else if($prevision == 1) return 3; //FONASA B
					else if($prevision == 2) return 4; //FONASA C
					else if($prevision == 3) return 5; //FONASA D
					else if($prevision == 4) return 8; //PARTICULAR
					else if($prevision > 4) return 2; //ISAPRE
					break; //FFAA
		case 11:	return 2; //FONASA A
					break; //DIPRECA					
	}
}?> 