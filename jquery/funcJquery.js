// JavaScript Document
$(document).ready(function (){
	 
	busquedalistas('../controladores/procesarBusqueda.php',2);
	// input del calendario //
    $( "#f1" ).datepicker();
	$( "#f2" ).datepicker();
	
	// input numerico // 
	$("#rut").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});
  
  function cargarContenido(url,parametros,contenedor){ 
//FUNCION AJAX ENVIAPETICION A SERVIDOR Y CARGA CONTENIDO HTML EN CONTENEDOR(NORMALMENTE ELEMENTO DIV)
	//$(contenedor).html('<div style="position: absolute;top: 50%; left: 50%;"><img src="../img/ajax_loader_big.gif"/></div>');
	$(contenedor).fadeOut(20, function(){
		$.ajax({
			type: "POST",
			url:url,
			data:parametros,
			success: function(datos){
				//$('.validity-tooltip').remove();   
				$(contenedor).html(datos);
			}
		});
		$(contenedor).fadeIn();
	});
//FIN FUNCION AJAX
}
   
   
function busquedalistas(url,act){ 
			$.ajax({   
				type: "POST",
				url:url,
				data:"tipoExamen="+$('#tipoExamen').val()+"&act="+act+"&estado="+$('#estadoSolicitud').val()+"&rutBusqueda="+$('#rut').val()+"&apaterno="+$('#apaterno').val()+"&amaterno="+$('#amaterno').val()+"&nombres="+$('#nombres').val()+"&f1="+$('#f1').val()+"&f2="+$('#f2').val(),
				success: function(datos){       
					$('#contenido').html(datos); 
				}
			 });
		
}

function busquedaPacientes(url,act){ 
			$.ajax({   
				type: "POST",
				url:url,
				data:"rutPacineteBusqueda="+$('#rutPacienteBusuqeda').val()+"&act="+act+"&fichaPacienteBusqueda="+$('#fichaPacienteBusqueda').val()+"&apePaternoBusuqeda="+$('#apePaternoBusuqeda').val()+"&apeMaternoBusqueda="+$('#apeMaternoBusqueda').val()+"&nombresBusqueda="+$('#nombresBusqueda').val(),
				success: function(datos){       
					$('#resultadoBusquedaPaciente').html(datos); 
				}
			 });
		
}


		   
function filtroRut(url){
	if($('#rut').val()==''){alert();}
	$.ajax({   
		type: "POST",
		url:url,
		//data:"idSolicitud="+idSolicitud+"&estadoAtencion="+$('#EstSol').val()+"&motivoAnulacion="+$('#motivoAnulacion').val(),
		success: function(datos){       
			$('#contenido').html(datos); 
		}
	});
	}


function showUrlInDialog(url,idSolicitud){
	
  var tag = $("<div></div>");
  $.ajax({
    url: url,
	//data:"idAtencion="+idAtencion,
    success: function(data) {
	tag.html(data).dialog({
		
		title: '.:: Motivo Anulacion Solicitud ::.', 
		width: 400, 
		height: 235, 
		dialogClass: 'test',
		modal: true, draggable: false, resizable: false,
		
		
			buttons: [ 
			{
			text: "Confirmar Anulacion", 
			id: "btn1", 
			click: function() {
			procesado=estadoSolicitud(idSolicitud,'../controladores/procesarEstado.php','A');
			if(procesado='procesado'){cargarPadre('../controladores/procesarBusqueda.php','#contenido');
			tag.dialog('destroy');}
			//$("#btn1").remove();
			} 
			}, 
			{ 
			text: "Cerrar", 
			id: "btn2", 
			click: function() { 
			tag.dialog('destroy');
			$('.validity-tooltip').remove(); 
			} 
			}
			],
				
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');
    }
  });
}


function estadoSolicitud(idSolicitud,url,estado){
	$.ajax({   
		type: "POST",
		async: false,
		url:url,
		data:"idSolicitud="+idSolicitud+"&estadoAtencion="+estado+"&motivoAnulacion="+$('#motivoAnulacion').val(),
		success: function(datos){       
			procesado=datos; 
		}
	});

}



function cargarPadre(url,contenedor){
	$.ajax({   
		type: "POST",
		url:url,
				success: function(datos){       
			$(contenedor).html(datos); 
		}
	});}
function cargarPadrePop(url,contenedor,variables){ 
	$.ajax({   
		type: "POST",
		url:url,
		data:variables,
				success: function(datos){    
				$(contenedor).html(datos); 
		}
	});}	

function verDetalle(url,idSolicitud,estado,tipoExamen,procedencia,fechaSoliocitud,rut,nombre){
	
  var tag = $("<div></div>");
  
  $.ajax({
    url: url,
	data:"idSolicitud="+idSolicitud+"&estadoSolicituddetalle="+estado+"&tipoExamendetalle="+tipoExamen+"&procedenciadetalle="+procedencia+"&fechaSoliocituddetalle="+fechaSoliocitud+"&rutdetalle="+rut+"&nombredetalle="+nombre,
    success: function(data) {
	tag.html(data).dialog({
		title: '.:: Detalle Solicitud Atencion  ::.', 
		width: 1050, 
		height: 550, 
		modal: true, draggable: false, resizable: false,
		
		
			buttons: [ 
										
				{ 
					text: "Cerrar", 
					id: "btn1", 
					click: function() { 
					tag.dialog('destroy');
					$('.validity-tooltip').remove(); } 
				},
					],
			
				
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');
    }
  });$('#btn1').remove();
}

function cambiarEstadoSolicitud(url,idSolicitud,estado,tipoExamen,procedencia,fechaSoliocitud,rut,nombre){
	
  var tag = $("<div></div>");
  
  $.ajax({
    url: url,
	data:"idSolicitud="+idSolicitud+"&estadoSolicituddetalle="+estado+"&tipoExamendetalle="+tipoExamen+"&procedenciadetalle="+procedencia+"&fechaSoliocituddetalle="+fechaSoliocitud+"&rutdetalle="+rut+"&nombredetalle="+nombre,
    success: function(data) {
	tag.html(data).dialog({
		title: '.:: Detalle Solicitud Atencion  ::.', 
		width: 1050, 
		height: 550, 
		modal: true, draggable: false, resizable: false,
		
		
			buttons: [ 
			
				{ 
					text: "Recepcionar Solicitud", 
					id: "btn3", 
					click: function() { 
					procesado=estadoSolicitud(idSolicitud,'../controladores/procesarEstado.php','R');
			if(procesado='procesado'){cargarPadre('../controladores/procesarBusqueda.php','#contenido');
			
			tag.dialog('destroy');
			}
					//tag.dialog('destroy');
					} 
				}, 
				{ 
					text: "Anular Solicitud", 
					id: "btn2", 
					click: function() { 
					showUrlInDialog('solicictudEstado.php',idSolicitud);
					tag.dialog('destroy');
					} 
				},
			
				{ 
					text: "Cerrar", 
					id: "btn1", 
					click: function() { 
					tag.dialog('destroy');
					$('.validity-tooltip').remove(); } 
				},
					],
			
				
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');
    }
  });$('#btn1').remove();
}



function habilitarMotivo(estado){
	if(estado=='A'){
	$('#motivoAnulacion').attr('readonly', false);
	$('#motivoAnulacion').css('background', '#FFF');
	}else if(estado=='R')
	{
	$('#motivoAnulacion').val('');
	$('#motivoAnulacion').attr('readonly', true);
	$('#motivoAnulacion').css('background', '#CCC');
	}
	}
	
function confirmacionExamen(url,variables,sala,paramedico,profesional){
	//if($(sala).val()!='0' && $(profesional).val()!='0'){
			if(!$('#divConfirmar').length){
					    var tag = $("<div id='divConfirmar'></div>");
					    mensaje="<div id='mensaje1' class='alerta'>Desea Cambiar el estado del examen a : <select name='select' id='optEstado'><option value='A'>Examen Aplicado</option><option value='NA'>Examen No Aplicado</option></select></div><div id='mensaje2' class='alerta' style='display:none;'>Debe seleccionar al Profesional y la Sala del Examen </div>";
						tag.html(mensaje).dialog({
						title: '.:: Confirmacion ::.', 
						width: 600, 
						height: 230, 
						dialogClass: 'alertaDiv',
						modal: true, draggable: false, resizable: false,
						
							buttons: [ 
							{
							text: "Si", 
							id: "btnconfirmacionExamen1", 
							click: function() {
									if($('#optEstado').val()=='NA'){
									procesado=estadoSolicitudDetalle('../controladores/procesarEstado.php',variables+"&estadoAtencionDetalle="+$('#optEstado').val());
											if(procesado='Procesado'){  
											cargarPadrePop('detalleAtencion.php','#detalleLista','idSolicitud='+$('#idSolicitud').val()+'&rutdetalle='+$('#rutdetalle').val()+'&procedenciadetalle='+$('#procedenciadetalle').val()+'&fechaSoliocituddetalle='+$('#fechaSoliocituddetalle').val()+'&tipoExamendetalle='+$('#tipoExamendetalle').val()+'&nombredetalle='+$('#nombredetalle').val()+'&estadoSolicituddetalle='+$('#estadoSolicituddetalle').val());
											tag.dialog('destroy');}
									}else if($('#optEstado').val()=='A'){ 
									if($(sala).val()!='0' && $(profesional).val()!='0'){	
											procesado=estadoSolicitudDetalle('../controladores/procesarEstado.php',variables+"&estadoAtencionDetalle="+$('#optEstado').val());
											if(procesado='Procesado'){  
											cargarPadrePop('detalleAtencion.php','#detalleLista','idSolicitud='+$('#idSolicitud').val()+'&rutdetalle='+$('#rutdetalle').val()+'&procedenciadetalle='+$('#procedenciadetalle').val()+'&fechaSoliocituddetalle='+$('#fechaSoliocituddetalle').val()+'&tipoExamendetalle='+$('#tipoExamendetalle').val()+'&nombredetalle='+$('#nombredetalle').val()+'&estadoSolicituddetalle='+$('#estadoSolicituddetalle').val());
											tag.dialog('destroy');}
									}else{	$("#btnconfirmacionExamen1").hide();
											$(sala).css({ color: "#4D4D4D", background: "#FF9999" });
											$(profesional).css({ color: "#4D4D4D", background: "#FF9999" });
											$('#mensaje1').css('display', 'none');
											$('#mensaje2').css('display', '');
											$('#mensajeError').css('display', '');
											mensajes('#mensajeError'); 
											
										}
									}
								   } 
							},
							
							{ 
							text: "Cerrar", 
							id: "btnconfirmacionExamen2", 
							click: function() { 
							tag.dialog('destroy');
									} 
							}
							],
								
						    close: function(event, ui) { 
							tag.dialog('destroy'); 
							$('.validity-tooltip').remove(); 
						}
					}).dialog('open');
			}else{ return false;}
	//}
}	


function mensajes(contenedor){
		setTimeout(function(){ $(contenedor).fadeOut(100).fadeIn(2000).fadeOut(100).fadeIn(2000).fadeOut(100).fadeIn(2000).fadeOut(100).fadeIn(2000);}, 1500);
	}
	
	function estadoSolicitudDetalle(url,variables){
		
	$.ajax({   
		type: "POST",
		async: false,
		url:url,
		data:variables,
		success: function(datos){ 
			procesado=datos; 
		}
	});
}

function BuscarPaciente(){ 
 var tag = $("<div></div>");
  
  $.ajax({
    url: 'busquedaPaciente.php',
	//data:"idSolicitud="+idSolicitud+"&estadoSolicituddetalle="+estado+"&tipoExamendetalle="+tipoExamen+"&procedenciadetalle="+procedencia+"&fechaSoliocituddetalle="+fechaSoliocitud+"&rutdetalle="+rut+"&nombredetalle="+nombre,
    success: function(data) {
	tag.html(data).dialog({
		title: '.:: Busqueda de Pacientes ::.', 
		width: 950, 
		height: 550, 
		modal: true, draggable: false, resizable: false,
							
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');
    }
  });
}

function FormularioSolicitud(idPaciente){   
 var tag = $("<div></div>");
  
  $.ajax({
    url: '../vista/solicitud.php',
	data:"idPac="+idPaciente+'&accion=borra',
    success: function(data) {
	tag.html(data).dialog({
		title: '.:: Formulario Solicitud ::.', 
		width: 950, 
		height: 850, 
		modal: true, draggable: false, resizable: false,
			buttons: [ 
			{
			text: "Enviar Solicitud", 
			id: "btn1", 
			click: function() {
				var estadoSave;
				estadoSave=estadoSolSav();
				arrayEstado=estadoSave.split('-');
				if(arrayEstado[0] == 1){grabarSolicitud(1,arrayEstado[1]);tag.dialog('destroy');}
				if(arrayEstado[0] == 2){grabarSolicitud(2);}
				if(arrayEstado[0] == 3){grabarSolicitud(3);}
	
			} 
			}, 
			{ 
			text: "Cerrar", 
			id: "btn2", 
			click: function() { 
			tag.dialog('destroy');
			} 
			}
			],				
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');
    }
  });
}


function agregarPrestacionCarro(url,parametros,contenedor){ 
	if($('#prestacion_b').val()=='-1' || $('#cantidad_b').val()==''){
		setTimeout(function(){ $(divCarroPrestacionesMensaje).fadeIn(400).fadeOut(5000)}, 100);
		}else{ 
	$(contenedor).fadeOut(20, function(){
		$.ajax({
			type: "POST",
			url:url,
			data:parametros,
			success: function(datos){
				$(contenedor).html(datos);
			}
		});
		$(contenedor).fadeIn();
	});
	}
	}
	
function estadoSolSav(){
	var procesado;
	$('#accion').val("save");
	$.ajax({   
		type: "POST",
		async: false,
		url: '../controladores/procesarSolicitudGuarda.php',
		data:$('#form1Solicitud').serialize(),
		success: function(datos){       
			procesado=datos; 
		}
	});
	return procesado;
	}	
	
function grabarSolicitud(condicion,idsolicitud){
	var tag = $("<div></div>");
  
  $.ajax({
    url: 'SolicitudGuarda.php',
	data:'estado='+condicion+'&result_atencionID='+idsolicitud,
    success: function(data) {
		if(condicion == 2 || condicion==3){
			tag.html(data).dialog({ 
		title: '.:: SOLICITUD IMAGENOLOGÍA ::.', 
		width: 680, 
		height: 155, 
		modal: true, draggable: false, resizable: false,
						
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			}
	}).dialog('open');} 
		else{
	tag.html(data).dialog({ 
		title: '.:: SOLICITUD IMAGENOLOGÍA ::.', 
		width: 750, 
		height: 750, 
		modal: true, draggable: false, resizable: false,
			buttons: [
			{ 
			text: "Imprimir ", 
			id: "btnImprimir", 
			click: function() { 
			window.frames["recetapdf"].focus();
    window.frames["recetapdf"].print();
			} 
			}, 
			{ 
			text: "Cerrar", 
			id: "btn2", 
			click: function() { 
			tag.dialog('destroy');
			} 
			}
			],				
		  close: function(event, ui) { 
		  	tag.dialog('destroy'); 
			$('.validity-tooltip').remove(); 
		}
	}).dialog('open');}
    }
  });
	}	
	
	
