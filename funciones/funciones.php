<?php
// valida_rut($r) v0.001
// No importa si el RUT esta con punto (.), comas (,),
// guion (-),k (minuscula | mayuscula) da igual.
// ----------------------------------------------------
// Autor: Juan Pablo Aqueveque <jp [arroba] juque [punto] cl >
// Script completamente gratis, eso si! mándame un email si lo ocupas
// o si encuentras algún problema :-)
//
// Temuco, 31 octubre 2002 11:48:00

function mostrar()
{
	if(document.getElementById("contenido").style.display == 'none')
		document.getElementById("contenido").style.display == 'block';
		document.getElementById("mensaje").style.display == 'none';
}

function valida_rut()
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*//llamada de la funcion

if ( valida_rut($_GET['rut']) )
{
	echo 'el rut es CORRECTO :-)';
}
else
{
	 echo 'el rut es incorrecto :-(';
}*/
?>







<?php  
/********************************************************* 
Función Validador de Dígito verificador RUT, by HiperJP - 2003 
Ult. Modificación: 26-08-2003 7:58 AM 
Convertido originalmente de una versión en ASP. 
*********************************************************/ 
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




function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
} 

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
} 
function diferenciaFechas($date1, $date2){

$s = strtotime($date1)-strtotime($date2);
$d = intval($s/86400);
$s -= $d*86400;
$h = intval($s/3600);
$s -= $h*3600;
$m = intval($s/60);
$s -= $m*60;

$dif= (($d*24)+$h).hrs." ".$m."min";
$diferencia = $d;
return $diferencia;
}
function redondear_dos_decimal($valor) { 
   $float_redondeado = number_format((round($valor * 100) / 100),2,",",".");
   return $float_redondeado; 
} 



function sumaDia($fecha,$dia)
{	
	list($year,$mon,$day) = explode('-',$fecha);
	return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));
}
function truncarTexto($string, $limit) {
	$break=" ";//CARACTER QUE USA PARA CORTAR LA CADENA
	$pad="...";//AGREGA ESTO AL FINAL DE LA CADENA DE SALIDA
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
?> 

