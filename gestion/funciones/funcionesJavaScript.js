// JavaScript Document

/*
 * Calcula digito verificador
 */
function formatoHoraIngreso(hora_ingreso){
	var hora_ingreso = hora_ingreso.value;
	if(hora_ingreso < 10 && document.getElementById('hora_ingreso').value.length == 1)
		document.getElementById('hora_ingreso').value = '0'+ hora_ingreso;
	if(hora_ingreso > 23)
		document.getElementById('hora_ingreso').value = '00';
}
function formatoHoraEgreso(hora_egreso){
	var hora_egreso = hora_egreso.value;
	if(hora_egreso < 10 && document.getElementById('hora_egreso').value.length == 1)
		document.getElementById('hora_egreso').value = '0'+ hora_egreso;
	if(hora_egreso > 23)
		document.getElementById('hora_egreso').value = '00';
}
function formatoMinutoIngreso(minuto_ingreso){
	var minuto_ingreso = minuto_ingreso.value;
	if(minuto_ingreso < 10 && document.getElementById('minuto_ingreso').value.length == 1)
		document.getElementById('minuto_ingreso').value = '0'+ minuto_ingreso;	
	if(minuto_ingreso > 59)
		document.getElementById('minuto_ingreso').value = '00';
}
function formatoMinutoEgreso(minuto_egreso){
	var minuto_egreso = minuto_egreso.value;
	if(minuto_egreso < 10 && document.getElementById('minuto_egreso').value.length == 1)
		document.getElementById('minuto_egreso').value = '0'+ minuto_egreso;	
	if(minuto_egreso > 59)
		document.getElementById('minuto_egreso').value = '00';
}
 
 
function digitoVerificador(rut) {
	// type check
	// serie numerica
	var rut = String(rut.value);
	var largo = rut.length;
	if(largo == 0)
		return;
	var secuencia = [2,3,4,5,6,7,2,3];
	var sum = 0;
	//
	for (var i = largo - 1; i >= 0; i--) {
		var d = rut.charAt(i);
		var d = parseInt(d);
		sum += new Number(d) * secuencia[largo - (i + 1)];
	};
	// sum mod 11
	var sum = parseInt(sum);
	var rest = 11 - (sum % 11);
	// si es 11, retorna 0, sino si es 10 retorna K,
	// en caso contrario retorna el numero
	switch(rest){
		case 11: 	document.getElementById('digito').value = 0;
					break;
		case 10: 	document.getElementById('digito').value = 'K';
					break;
		default: 	document.getElementById('digito').value = rest;
					break;
	}
<!--	window.alert('Valor de rut = ' + rut + '\nValor de sum = ' + sum + '\nValor de rest = ' +rest + '\nValor de d = ' + d + '\nValor de largo = ' + largo);
-->
}

function suma(control){
var valor = control.value;
valor = parseInt(valor);
var sum = valor + 1;
control.value = sum;
}

function resta(control){
var valor = control.value;
valor = parseInt(valor);
var sum = valor - 1;
if(sum < 1)
sum = 1;
control.value = sum;
}

function calcula(){
	var buenas = parseInt(document.getElementById('buenas').value);
	var malas = parseInt(document.getElementById('malas').value);
	if(buenas < 0){
		buenas = 0;
		document.getElementById('buenas').value=0;
	}
	if(malas < 0){
		malas = 0;
		document.getElementById('malas').value=0;
	}
	document.getElementById('total').value = buenas + malas;
}
function soloNumeros(evt){
	var buenas = parseInt(document.getElementById('buenas').value);
	var malas = parseInt(document.getElementById('malas').value);
	if(buenas < 0){
		buenas = 0;
		document.getElementById('buenas').value=0;
	}
	if(malas < 0){
		malas = 0;
		document.getElementById('malas').value=0;
	}
	document.getElementById('total').value = buenas + malas;
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
function submitCorrelativo(evt){
	//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum == 13){
		document.form1.act.value='pac'; 
		document.form1.pacId.value=''; 
		document.form1.busca.value=''; 
		document.form1.que_pag.value='lis'; 
		document.form1.borra_session.value='si'; 
		document.form1.submit();
	}else{
		return true;
	}
}
function submitDocumento(evt){
	//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum == 13){
		document.form1.act.value='pac'; 
		document.form1.pacId.value=''; 
		document.form1.porCorrelativo.value=''; 
		document.form1.que_pag.value='lis'; 
		document.form1.borra_session.value='si'; 
		document.form1.submit();
	}else{
		return true;
	}
}
function validaCuatro(evt){
//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum>48 && keynum<53){
		return true;
	}else{
		return false;
	}
}
function validaSeis(evt){
	//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum>48 && keynum<55){
		return true;
	}else{
		return false;
	}
}

function show_tooltip(current_event,this_link,tip_text){

var my_tooltip = document.getElementById("tooltip")

var cursor_position_x 
var cursor_position_y

if(document.all){

cursor_position_x = event.clientX
cursor_position_y = event.clientY

}

else if(document.getElementById){

cursor_position_x = current_event.pageX
cursor_position_y = current_event.pageY


}

var text_tooltip = "<div style='font-size:10pt;width:250px;font-family:Arial,Helvetica;"+
"border:1px solid;padding:5px;'>"+tip_text+"</div>"

with( my_tooltip){
innerHTML = text_tooltip
style.left = cursor_position_x
style.top = cursor_position_y + 15
style.backgroundColor ="#FFFFDD"
style.visibility = "visible"
}
this_link.onmouseout = hide_tooltip

}

function hide_tooltip(){

document.getElementById("tooltip").style.visibility ="hidden"

}

//DIGITO VERIFICADOR

function digitoVerificador(rut) {
	if(document.buscaParto.tipoDocumento.value==1){
	// type check
	// serie numerica
	var rut = String(rut.value);
	var largo = rut.length;
	if(largo == 0)
		return;
	var secuencia = [2,3,4,5,6,7,2,3];
	var sum = 0;
	//
	for (var i = largo - 1; i >= 0; i--) {
		var d = rut.charAt(i);
		var d = parseInt(d);
		sum += new Number(d) * secuencia[largo - (i + 1)];
	};
	// sum mod 11
	var sum = parseInt(sum);
	var rest = 11 - (sum % 11);
	// si es 11, retorna 0, sino si es 10 retorna K,
	// en caso contrario retorna el numero
	switch(rest){
		case 11: 	document.getElementById('digito').value = 0;
					break;
		case 10: 	document.getElementById('digito').value = 'K';
					break;
		default: 	document.getElementById('digito').value = rest;
					break;
	}

	}else{
	document.getElementById('digito').value = '';	
	}
}