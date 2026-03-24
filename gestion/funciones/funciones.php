<? 

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

function ValidaDVRut($rut) { 

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
        $codigo_veri = "k"; 
      } else {  
        $codigo_veri = $valor; 
    } 
  return $codigo_veri; 
} 

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
function mostrar(){
	if(document.getElementById("contenido").style.display == 'none')
		document.getElementById("contenido").style.display == 'block';
		document.getElementById("mensaje").style.display == 'none';
}
function cambiarFormatoFecha($fecha){
	if($fecha=='')
		return $fecha;
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio;
}
function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha);
    return $anio."-".$mes."-".$dia;
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
function redondear_dos_decimal($valor){ 
   $float_redondeado = number_format((round($valor * 100) / 100),2,",",".");
   return $float_redondeado; 
} 
function sumaDia($fecha,$dia){
	list($year,$mon,$day) = explode('-',$fecha);
	return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));
}
function formatoNum($numero){
	return number_format($numero, 0, "", ".");
}
function separarInventario($inventario){// GENERA UN NUMERO DE INVENTARIO CON FORMATO 2-XXXXXX
	$num = explode("-",$inventario );
	$numero = $num[1] + 1;
	$numero = str_pad($numero, 6, "0", STR_PAD_LEFT);
	return $num[0]."-".$numero;
}
function generarCorrelativo($numeroCod){
	if($numeroCod==NULL){
		$numeroCod=1;
	}else{
		$numeroCod = $numeroCod+1;
	}
	return $numeroCod;
}
function truncarTexto($string, $limit) {
	$break=" ";//CARACTER QUE USA PARA CORTAR LA CADENA
	$pad="…";//AGREGA ESTO AL FINAL DE LA CADENA DE SALIDA
	if(strlen($string) <= $limit)// RETORNA SIN CAMBIOS SI LA CADENA ES MAS CORTA QUE EL LIMITE ESTABLECIDO
		return $string;
	
	// is $break present between $limit and the end of the string? 
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	}
	return $string;
}

function date_diff($date1, $date2) { 
    $current = $date1; 
    $datetime2 = date_create($date2); 
    $count = 0; 
    while(date_create($current) < $datetime2){ 
        $current = gmdate("Y-m-d", strtotime("+1 day", strtotime($current))); 
        $count++; 
    } 
    return $count; 
}
function diff_dte($date1, $date2){
       if (!is_integer($date1)) $date1 = strtotime($date1);
       if (!is_integer($date2)) $date2 = strtotime($date2);  
       return floor(abs($date1 - $date2) / 60 / 60 / 24);
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
function nombreCat($cat){
	switch($cat){
	case(1):
	return	"C1";
	break;
	case(2):
	return	"C2";
	break;
	case(3):
	return	"C3";
	break;
	case(4):
	return	"C4";
	break;
	case(5):
	return	"C5";
	break;
	case(6):
	return	"S/I";
	break;
	}
}
?> 
<script>
function disableCombos()
{
 oCombo = document.getElementById('estado');
 oComboOrigen = document.getElementById('servicio_tras');
 oComboOrigen2 = document.getElementById('preDiagnostico');

 if (oCombo.options[oCombo.selectedIndex].value == '4')
 {
  //Desaparece
  // oComboOrigen.style.display = 'none';
  //Deshabilita
  oComboOrigen.disabled = false;
  oComboOrigen2.disabled = false;
  //Repetir lo mismo para oComboDestino
 }else{
	  oComboOrigen.disabled = true;
	  oComboOrigen2.disabled = true;
	 }
}

function disableBoton()
{
 oCombo1 = document.getElementById('estado');
 oBotonOrigen = document.getElementById('vaciar');
 

 if (oCombo.options[oCombo.selectedIndex].value != '2')
 {
  //Desaparece
  // oComboOrigen.style.display = 'none';
  //Deshabilita
  oBotonOrigen.disabled = false;
  
  //Repetir lo mismo para oComboDestino
 }else{
	  oBotonOrigen.disabled = true;
	  
	 }
}

function disableBoton2()
{
 oCombo1 = document.getElementById('estado');
 oBotonOrigen2 = document.getElementById('aceptar');

 if (oCombo.options[oCombo.selectedIndex].value != '2')
 {
  //Desaparece
  // oComboOrigen.style.display = 'none';
  //Deshabilita
  oBotonOrigen2.disabled = false;
  //Repetir lo mismo para oComboDestino
 }else{
	  oBotonOrigen2.disabled = true;
	 }
}

function soloNumeros(evt){
//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
			}else{
				keynum = evt.which;
			}
	//comprobamos si se encuentra en el rango
	if(keynum>47 && keynum<58){
		return true;
			}else{
				return false;
			}
}

function soloDecimales(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[/^\d+(\.\d+)?$/]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function calcula(p,t,i){
	if((t != "" ) && (p != "" )){
	var peso =  parseInt(p);
	var talla =  parseFloat(t);
	var talla2 = (talla/100);
	var calculo = (p/(talla2*talla2))
	
		/*alert(calculo.toFixed(2));*/
		i.value=calculo.toFixed(2);
	}else{
		
		i.value = '--';
		}		
}

function DiferenciaFechas(fechaH, fechaI, difdias) {

   //Obtiene los datos del formulario
   CadenaFecha = fechaH
   CadenaFecha2 = fechaI
   
   //Obtiene dia, mes y año
   var f1 = new fecha( CadenaFecha )   
   var f2 = new fecha( CadenaFecha2 )
   
   //Obtiene objetos Date
   var miFecha = new Date( f1.anio, f1.mes, f1.dia )
   var miFecha2 = new Date( f2.anio, f2.mes, f2.dia )

   //Resta fechas y redondea
   var diferencia = miFecha.getTime() - miFecha2.getTime()
   var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))
   var segundos = Math.floor(diferencia / 1000)
   //alert ('La diferencia es de ' + dias + ' dias,\no ' + segundos + ' segundos.')
   
   difdias.value = dias;
}

function fecha( cadena ) {

   //Separador para la introduccion de las fechas
   var separador = "-"

   //Separa por dia, mes y año
   if ( cadena.indexOf( separador ) != -1 ) {
        var posi1 = 0
        var posi2 = cadena.indexOf( separador, posi1 + 1 )
        var posi3 = cadena.indexOf( separador, posi2 + 1 )
        this.dia = cadena.substring( posi1, posi2 )
        this.mes = cadena.substring( posi2 + 1, posi3 )
        this.anio = cadena.substring( posi3 + 1, cadena.length )
   } else {
        this.dia = 0
        this.mes = 0
        this.anio = 0   
   }
}

function calculaSC(p,t,sc){
	if((t != "" ) && (p != "" )){
	var peso =  parseFloat(p);
	var talla =  parseFloat(t);
	var peso2 = Math.pow(peso,0.425);
	var talla2 = Math.pow(talla,0.725);
	var calculo = ((peso2*talla2)*71.84)/10000
	
		sc.value=calculo.toFixed(2);
	}else{
		
		sc.value = '--';
		}		
}

function calculaPE(t,s,pcp){
	if(t != "" ){
	var talla =  parseFloat(t);
	var sexo =  new String(s);
	
	if(s=='F'){
		var sexo2 = 45;
		}else{
			var sexo2 = 50;
			}
	var calculo = ((talla-152.4)*0.91)+sexo2;
	
		pcp.value=calculo.toFixed(2);
	}else{
		
		pcp.value = '--';
		}		
}

</script>