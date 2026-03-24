<?php

function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
} 

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
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
                if (bisiesto($array_actual[0])) 
                { 
                    $dias_mes_anterior=29; break; 
                } else { 
                    $dias_mes_anterior=28; break; 
                } 
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

function bisiesto($anio_actual){ 
    $bisiesto=false; 
    //probamos si el mes de febrero del año actual tiene 29 días 
      if (checkdate(2,29,$anio_actual)) 
      { 
        $bisiesto=true; 
    } 
    return $bisiesto; 
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

//function limpiar_caracteres_especiales($s) {
//	$s = ereg_replace("[áàâãª]","a",$s);
//	$s = ereg_replace("[ÁÀÂÃ]","A",$s);
//	$s = ereg_replace("[éèê]","e",$s);
//	$s = ereg_replace("[ÉÈÊ]","E",$s);
//	$s = ereg_replace("[íìî]","i",$s);
//	$s = ereg_replace("[ÍÌÎ]","I",$s);
//	$s = ereg_replace("[óòôõº]","o",$s);
//	$s = ereg_replace("[ÓÒÔÕ]","O",$s);
//	$s = ereg_replace("[úùû]","u",$s);
//	$s = ereg_replace("[ÚÙÛ]","U",$s);
//	$s = str_replace(" ","-",$s);
//	$s = str_replace("ñ","n",$s);
//	$s = str_replace("Ñ","N",$s);
//	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
//	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
//	return $s;
//}

function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ":"),
        '',
        $string
    );
 
 
    return $string;
}

/**
* stripAccents()
* @description Esta función remplaza todos los caracteres especiales de un texto dado por su equivalente
* @author      Esteban Novo
* @link        http://www.notasdelprogramador.com/2011/01/13/php-funcion-para-quitar-acentos-y-caracteres-especiales/
* @access      public
* @copyright   Todos los Derechos Reservados
* @param       string $String
* @return      Retorna el nuevo String sin caracteres especiales
*/

?> 

<script language="javascript" type="text/javascript">
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com
//
//	Version 1
//	03/02/2001

function DiferenciaFechas(formulario) {

   //Obtiene los datos del formulario
   CadenaFecha1 = formulario.f_date1.value
   CadenaFecha2 = formulario.f_date.value
   
   //Obtiene dia, mes y año
   var fecha1 = new fecha( CadenaFecha1 )   
   var fecha2 = new fecha( CadenaFecha2 )
   
   //Obtiene objetos Date
   var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia )
   var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia )

   //Resta fechas y redondea
   var diferencia = miFecha1.getTime() - miFecha2.getTime()
   var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))
   var segundos = Math.floor(diferencia / 1000)
   //alert ('La diferencia es de ' + dias + ' dias,\no ' + segundos + ' segundos.')
   
   document.getElementById('difDias').value = dias;
}

function getNumeroDeNits(){ 
	
    var d1 = $('#f_date').val().split("-");  
    var dat1 = new Date(d1[2], parseFloat(d1[1])-1, parseFloat(d1[0]));  
    var d2 = $('#f_date1').val().split("-");  
    var dat2 = new Date(d2[2], parseFloat(d2[1])-1, parseFloat(d2[0]));  
  
    var fin = dat2.getTime() - dat1.getTime();  
    var dias = Math.floor(fin / (1000 * 60 * 60 * 24))    
  
    //return dias;  
	document.getElementById('difDias').value = dias;
}  

function barthel(formulario){
	
	  var valorBarthel = formulario.barthel.value;
	  	if(valorBarthel == ""){
			var variable = "";
		}else if((valorBarthel >= 0) & (valorBarthel < 20)){
			var variable = "Dependiente";
		}else if((valorBarthel >= 20) & (valorBarthel <= 35)){
			var variable = "Grave";
			}else if((valorBarthel >= 40) & (valorBarthel <= 55)){
				var variable = "Moderado";
				}else if((valorBarthel >= 60) & (valorBarthel < 100)){
					var variable = "Leve";
					}else if(valorBarthel == 100){
						var variable = "Independiente";
						}else{
							var variable = "Valor invalido";
							}
		document.getElementById('valorBart').value = variable;
}
function barthele(formulario){
  
    var valorBarthel = formulario.barthele.value;
      if(valorBarthel == ""){
      var variable = "";
    }else if((valorBarthel >= 0) & (valorBarthel < 20)){
      var variable = "Dependiente";
    }else if((valorBarthel >= 20) & (valorBarthel <= 35)){
      var variable = "Grave";
      }else if((valorBarthel >= 40) & (valorBarthel <= 55)){
        var variable = "Moderado";
        }else if((valorBarthel >= 60) & (valorBarthel < 100)){
          var variable = "Leve";
          }else if(valorBarthel == 100){
            var variable = "Independiente";
            }else if(valorBarthel == "F"){
              var variable = "";
              }else{
              var variable = "Valor invalido";
              }
    document.getElementById('valorBartele').value = variable;
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


function habilitar()
 {
 document.forms[0].docGes.disabled=true;

  for(var i=0;i<document.forms[0].elements.length;i++)
  {
    if(document.forms[0].elements[i].name=="condGES")
    {
     if(document.forms[0].elements[i].value=="N")
     {
       if(document.forms[0].elements[i].checked==true)
	   {

        document.forms[0].docGes.disabled=true;
        
       }
     }
     else if(document.forms[0].elements[i].value=="S")
     {
       if(document.forms[0].elements[i].checked==true)
	   {
		document.forms[0].docGes.disabled=false;
		
       }
     }
	}
  }
 }

function disableRadio()
{ 
 //document.forms[0].otroResponsable.disabled='true';

  for(var i=0;i<document.forms[0].elements.length;i++)
  {
    if(document.forms[0].elements[i].name=="responsable")
    {
     if(document.forms[0].elements[i].value=="Otro")
     {
       if(document.forms[0].elements[i].checked==true)
	   {

        document.forms[0].otroResponsable.disabled=false;
        
       }
     }
     else if(document.forms[0].elements[i].value!="Otro")
     {
       if(document.forms[0].elements[i].checked==true)
	   {
		//document.forms[0].otroResponsable.disabled='true';
		
       }
     }
	}
  }
}

function disableCombos()
{
 oCombo = document.getElementById('destinoPaciente');
 oComboOrigen = document.getElementById('trasladoPaciente');
 
 if (oCombo.options[oCombo.selectedIndex].value == 2)
 {
  //Desaparece
  // oComboOrigen.style.display = 'none';
  //Deshabilita
  oComboOrigen.disabled = false;
  //Repetir lo mismo para oComboDestino
 }else{
	  oComboOrigen.disabled = true;
	 }
}

function disableCombos2()
{
 oCombo = document.getElementById('destinoPaciente');
 oComboOrigen = document.getElementById('hogarPaciente');
 
 if (oCombo.options[oCombo.selectedIndex].value == 4)
 {
  //Desaparece
  // oComboOrigen.style.display = 'none';
  //Deshabilita
  oComboOrigen.disabled = false;
  //Repetir lo mismo para oComboDestino
 }else{
	  oComboOrigen.disabled = true;
	 }
}

function isNumberKey(evt)// acepta solo numeros
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

function validaNumeros2(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[/^\d+(\.\d+)?$/]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function validaNumeros(evt){
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

function romanize (num) {
	
	if (!+num)
		return false;
	var	digits = String(+num).split(""),
		key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
		       "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
		       "","I","II","III","IV","V","VI","VII","VIII","IX"],
		roman = "",
		i = 3;
	while (i--)
		roman = (key[+digits.pop() + (i * 10)] || "") + roman;
	return Array(+digits.join("") + 1).join("M") + roman;
}


 /* Abrimos etiqueta de código */
function validar_formulario(){ /* Abrimos la función validar_formulario */
/* Partimos por validar que se haya ingresado un valor para el nombre, esto lo hacemos mediante un if y preguntamos si el campo es igual a 0, si es así, desplegamos un mensaje para que se ingrese el nombre y volvemos al formulario. */
if (document.epiMedica.enfermeras.value==''){
alert('Debe ingresar nombre de Enfermera')
document.epiMedica.enfermeras.focus()
return 0;
}else{
	
 if(document.epiMedica.idServicio.value == 12 ){
		if(document.epiMedica.cama_sn.value == 1){
		/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
		alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
		document.epiMedica.action='grabaEpicrisis.php?act=1&cierra=1&cama_sn=1';document.epiMedica.submit();
		}else{
		/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
		alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
		document.epiMedica.action='grabaEpiPsiq.php?act=1&cierra=1';document.epiMedica.submit();
		}
	}else{
	/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
	alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
	document.epiMedica.action='grabaEpicrisis.php?act=1&cama_sn=0&cierra=1';document.epiMedica.submit();
	}
}
}

 /* Abrimos etiqueta de código */
function validar_formulario_matrona(){ /* Abrimos la función validar_formulario */
/* Partimos por validar que se haya ingresado un valor para el nombre, esto lo hacemos mediante un if y preguntamos si el campo es igual a 0, si es así, desplegamos un mensaje para que se ingrese el nombre y volvemos al formulario. */
if (document.epiMedica.matronas.value==''){
alert('Debe ingresar el nombre de una Matrona')
document.epiMedica.matronas.focus()
return 0;
}else{
	/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
	alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
	document.epiMedica.action='grabaEpicrisisMat.php?act=1&cierra=1';document.epiMedica.submit();
	}
}

function validar_favorito(valor){ 
/* Partimos por validar que se haya ingresado un valor para el nombre, esto lo hacemos mediante un if y preguntamos si el campo es igual a 0, si es así, desplegamos un mensaje para que se ingrese el nombre y volvemos al formulario. */
/* OJO... para concatenar un String se debe anteponer un signo + */
var muestra = valor;
if (document.epiMedica.nomFav.value==''){
	
	alert('Debe ingresar un nombre para favorito')
	
	document.epiMedica.nomFav.focus()
	return 0;
		}else{
		/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
			if(muestra == 'actualiza'){
					document.epiMedica.action='agregaFavoritos.php?fav=1';document.epiMedica.submit();
				}else if(muestra == 'agrega'){
							document.epiMedica.action='agregaFavoritos.php?fav=2';document.epiMedica.submit();
					}
		}
}

function verificaMedico(){
	valor = document.frm_epicrisis_medica.medico_nom.value.split(" - ");
    num = parseInt(valor[0]) 
	
     	//Compruebo si es un valor numérico 
     	if (isNaN(num)) { 
           	  document.frm_epicrisis_medica.medico_id.value = '';
     	}else{ 
           	 //En caso contrario (Si era un número) devuelvo el valor 
           	 document.frm_epicrisis_medica.medico_id.value = num;
		}
	}

 /* Abrimos etiqueta de código */
function validar_medico(){ /* Abrimos la función validar_formulario */
/* Partimos por validar que se haya ingresado un valor para el nombre, esto lo hacemos mediante un if y preguntamos si el campo es igual a 0, si es así, desplegamos un mensaje para que se ingrese el nombre y volvemos al formulario. */
if ((document.frm_epicrisis_medica.medico_nom.value=='') || (document.frm_epicrisis_medica.medico_id.value == '')){
alert('Debe ingresar nombre valido del Medico')
document.frm_epicrisis_medica.medico_nom.value = '';
document.frm_epicrisis_medica.medico_nom.focus()
return 0;
}else{
	/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
	alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
	document.frm_epicrisis_medica.action='grabaEpicrisisMed.php?act=1&cierra=1';document.frm_epicrisis_medica.submit();
}
}

function validar_medico_neo(){ /* Abrimos la función validar_formulario */
/* Partimos por validar que se haya ingresado un valor para el nombre, esto lo hacemos mediante un if y preguntamos si el campo es igual a 0, si es así, desplegamos un mensaje para que se ingrese el nombre y volvemos al formulario. */
if ((document.frm_epicrisis_medica.medico_nom.value=='') || (document.frm_epicrisis_medica.medico_id.value == '')){
alert('Debe ingresar nombre valido del Medico')
document.frm_epicrisis_medica.medico_nom.value = '';
document.frm_epicrisis_medica.medico_nom.focus()
return 0;
}else{
	/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */
	alert('Los datos fueron ingresados correctamente y la epicrisis sera Cerrada');
	document.frm_epicrisis_medica.action='grabaEpicrisisMedNeo.php?act=1&cierra=1';document.frm_epicrisis_medica.submit();
}
}

function validaNumeros2(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[/^\d+(\.\d+)?$/]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function alpha(e) {
      var k;
      document.all ? k = e.keyCode : k = e.which;
      return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
      }
      
      function popUp(URL) {
      day = new Date();
      id = day.getTime();
      eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=1,statusbar=0,menubar=0,resizable=0,width=640,height=400,left = 640,top = 340');");
      }

function mostrarOcultarTablas()
 {
  // initialize form with empty field
  //document.forms[0].matronaAt.disabled=false;
  //document.forms[0].medicoAt.disabled=false;
  elem = document.getElementById('tablaExamen');
  elem2 = document.getElementById('tablaExamen2');

  for(var i=0;i<document.forms[0].elements.length;i++)
  {
    if(document.forms[0].elements[i].name=="otroExamen")
    {
     if(document.forms[0].elements[i].value=="SI")
     {
       if(document.forms[0].elements[i].checked==true){

        elem.style.display="block";
		
		document.epiMedica.tablaOculta.value = 1;
		        
       }
     }
     else if(document.forms[0].elements[i].value=="NO")
     {
       if(document.forms[0].elements[i].checked==true){
		elem.style.display="none";
		
		document.epiMedica.tablaOculta.value = 0;
		
       }
     }     
    }
  }
  for(var i=0;i<document.forms[0].elements.length;i++)
  {
    if(document.forms[0].elements[i].name=="pendExamen")
    {
     if(document.forms[0].elements[i].value=="SI")
     {
       if(document.forms[0].elements[i].checked==true){

		elem2.style.display="block";
		document.epiMedica.tablaOculta.value = 1;
		        
       }
     }
     else if(document.forms[0].elements[i].value=="NO")
     {
       if(document.forms[0].elements[i].checked==true){

		elem2.style.display="none";
		document.epiMedica.tablaOculta.value = 0;
		
       }
     }     
    }
  }
 }	  

function disableResponsable()
{ 
 document.forms[0].nomResp.disabled=true;

  for(var i=0;i<document.forms[0].elements.length;i++)
  {
    if(document.forms[0].elements[i].name=="responsable")
    {
     if(document.forms[0].elements[i].value=="paciente")
     {
       if(document.forms[0].elements[i].checked==true)
	   {
        document.forms[0].nomResp.disabled=true;
        
       }
     }
     else if(document.forms[0].elements[i].value!="paciente")
     {
       if(document.forms[0].elements[i].checked==true)
	   {
		document.forms[0].nomResp.disabled=false;
		
       }
     }
	}
  }
}
function soloLetrasSinCaracteresEespeciales(e){
		var k;
      document.all ? k = e.keyCode : k = e.which;
      //*return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " 1234567890abcdefghijklmnopqrstuvwxyz/+-:.,%";
       especiales = [8];// 46 es el punto 

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57),false);
        }
    }

function dar_formato(num){

	var cadena = ""; var aux;
	var cont = 1,m,k;
		if(num<0) aux=1; else aux=0;
		num=num.toString();
			for(m=num.length-1; m>=0; m--){
			 cadena = num.charAt(m) + cadena;
				 if(cont%3 == 0 && m >aux)  cadena = "." + cadena; else cadena = cadena;
				 	if(cont== 3) cont = 1; else cont++;
			}
		cadena = cadena.replace(/.,/,",");
		return cadena;
	}
function getDV(){
	var numero = document.getElementById('madreRut').value
	nuevo_numero = numero.toString().split("").reverse().join("");
	for(i=0,j=2,suma=0; i < nuevo_numero.length; i++, ((j==7) ? j=2 : j++)) {
		suma += (parseInt(nuevo_numero.charAt(i)) * j); 
	}
	n_dv = 11 - (suma % 11);
	var digitoRut = ((n_dv == 11) ? 0 : ((n_dv == 10) ? "K" : n_dv));
	document.getElementById('digito').value = digitoRut;
}
</script>