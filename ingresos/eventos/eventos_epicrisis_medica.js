$(document).ready(function(){
	
	tinyMCE.execCommand('mceRemoveControl', false, "detalleEpi");
	
	tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
			
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			forced_root_block : false,
			force_p_newlines : false,
			force_br_newlines : true,
			table_inline_editing : true,
			height : "350",
			width : 840		
	});
	daysBetween($("#ingFecha").val(),$("#altFecha").val())
	


  $("#ingFecha").datepicker({
	  
  numberOfMonths: 1,
  firstDay: 1,
  showOn: "both",
  buttonImageOnly: true,
  buttonImage: "img/calendar.png",
  showButtonPanel: true, 
  onSelect: function (){
	  daysBetween($("#ingFecha").val(),$("#altFecha").val())
	  
	  }
 });
 
   $("#altFecha").datepicker({
  numberOfMonths: 1,
  firstDay: 1,
  showOn: "both",
  buttonImageOnly: true,
  buttonImage: "img/calendar.png",
  showButtonPanel: true,
  onSelect: function (){
	  daysBetween($("#ingFecha").val(),$("#altFecha").val())
  }
 });
 
	 $(".fechaControl1").datepicker({
	  numberOfMonths: 1,
	  firstDay: 1,
	  showOn: "both",
	  buttonImageOnly: true,
	  buttonImage: "img/calendar.png",
	  showButtonPanel: true
	 });
	
	$(".fechaControl2").datepicker({
	  numberOfMonths: 1,
	  firstDay: 1,
	  showOn: "both",
	  buttonImageOnly: true,
	  buttonImage: "img/calendar.png",
	  showButtonPanel: true
	 });
	 
	 $(".fechaControl3").datepicker({
	  numberOfMonths: 1,
	  firstDay: 1,
	  showOn: "both",
	  buttonImageOnly: true,
	  buttonImage: "img/calendar.png",
	  showButtonPanel: true
	 });
	 
	 $(".fechaControl4").datepicker({
	  numberOfMonths: 1,
	  firstDay: 1,
	  showOn: "both",
	  buttonImageOnly: true,
	  buttonImage: "img/calendar.png",
	  showButtonPanel: true
	 });
 
 
  //ENTREGA LA FUNCIONALIDAD AL INPUT	
	$("#medico_nom").combogrid({
		width: "400px",
		showOn:true,
		resetButton:true,
		/*searchButton:true,*/
		colModel: [{'columnName':'nombre_medico','width':'80','align':'left','label':'Medico'}],
		url: 'controlador/sensitivas/sensitivaMedicosEpicrisis.php',
		select: function( event, ui ) {
			$("#medico_nom").val( ui.item.nombre_medico);
			$("#medico_id").val( ui.item.id_medico);
			return false;
		}
	});
	//ELIMINA LAS VARIABLES AL BORRAR EL TEXTO DEL INPUT
	$("#medico_nom").on('keyup', function(){
			if($( "#medico_nom" ).val().length==0){
				$('#medico_id').val("");
			}
	});
	
	//HABILITA GES , SEGUN CONDICION
	if($("input:radio[name='opcionGes']:checked").val()=='si'){
		$("#tiposGes").prop("disabled",false);
	}else if($("input:radio[name='opcionGes']:checked").val()=='no'){
			$("#tiposGes").prop("disabled",true);
		}else{
			$("#tiposGes").prop("disabled",true);
			}
			
	//HABILITA GES , SEGUN CONDICION
	$("input:radio[name='opcionGes']").click(function(e) {
        switch ($("input:radio[name='opcionGes']:checked").val()){
			case 'si':
					$("#tiposGes").prop("disabled",false);
			break;
			case 'no':
					$("#tiposGes").prop("disabled",true);
			break;
			
			}		
    });
    $("input:radio[name='condEgreso']").click(function(e){
    	switch ($("input:radio[name='condEgreso']:checked").val()){
			case 'V':
					document.getElementById("divcontrolesespecialidad").removeAttribute("hidden");
			break;
			case 'F':
					document.getElementById("divcontrolesespecialidad").setAttribute("hidden","true");
			break;
			
			}
    });
	
	$("#destinoPaciente").change(function() {
  		if($("#destinoPaciente").val()==2){
			
			$("#trasladoPaciente").prop("disabled",false);
			$("#hogarPaciente").prop("disabled",true);
			
			}else if($("#destinoPaciente").val()==4){
				
				$("#hogarPaciente").prop("disabled",false);
				$("#trasladoPaciente").prop("disabled",true);
				
				}else{
					
					$("#trasladoPaciente").prop("disabled",true);
					$("#hogarPaciente").prop("disabled",true);
					}
	});
	$("#controlEspecialidad").change(function(){
			if(($('#controlEspecialidad').is(':checked'))){
				document.getElementById("grilla").removeAttribute("hidden");
			}else{
				document.getElementById("grilla").setAttribute("hidden","true");
			}
	});
	if(($('#controlEspecialidad').is(':checked'))){
		document.getElementById("grilla").removeAttribute("hidden");
	}else{
		document.getElementById("grilla").setAttribute("hidden","true");
	}

	
 $("#listaFavoritos").change(function(){
		var respuesta = retornarJson('../../gestionCamas2/controlador/servidor/control_favoritos.php','idFav='+$("#listaFavoritos").val());
		//alert(respuesta.descripcion);
		//tinyMCE.triggerSave();
//		  var variable_favorito = $('.editorFav').val();
//		  var test_indicacionesEpi = encodeURIComponent(variable_favorito);
//		tinyMCE.init({
//			mode : "none"});
		
		tinyMCE.execCommand('mceRemoveControl', false, "detalleEpi");
		if(respuesta.descripcion==null){
			$('#detalleEpi').val("<p ><strong>1.Evolucion y Resultado :</strong> &nbsp; </p><p><br /><hr></p><p ><strong>2.Indicaciones :</strong> &nbsp; </p><br /><br /><hr><p ><strong>3.Observaciones :</strong> &nbsp; </p><br /><br />");
			}else{
				$('#detalleEpi').val(respuesta.descripcion);
				}
		tinyMCE.execCommand('mceAddControl', false, "detalleEpi");
		
		
 });
});