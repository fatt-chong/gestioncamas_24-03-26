<? 
//CHECKEAR O UNCHECKEAR EL INCLUIR EN CORRELATIVO
$borra = $_POST['borra'];
if($borra == 'si'){
	require_once("clases/Censo.inc");
	$objCenso = new Censo;
	$bd->db_select("camas",$link);
	$objCenso->marcarEliminado($link, $HOSid);
}
if(isset($_SESSION['censo_diario']))
	$lista = $_SESSION['censo_diario'];
$bd->db_select("paciente",$link);
$rowPaciente = $objPaciente->getPaciente($link, $id_paciente);
$digito = $objPaciente->generaDigito($rowPaciente['rut']);
$fecha_nac = $objPaciente->invierteFecha($rowPaciente['fechanac']);	
$bd->db_select("camas",$link);
$rowDiagnostico = $objPaciente->getUltimoDiagnostico($link, $id_paciente, $hospitalizado);
//CARGA LOS SERVICIOS
require_once("clases/Servicio.inc");
$objServicio = new Servicio;
$bd->db_select("acceso",$link);
$rowPertenece = $objServicio->getServicioCerrada($link);
$bd->db_select("camas",$link);
$rowPerteneceBD = $objServicio->getServicioPertenece($link, $id_paciente, $hospitalizado, $correlativo);
//OBTIENE LOS DATOS DE LOS INSUMOS DE UN REGISTRO EN BD Y LOS CARGA EN UN ARREGLO DE SESSION 'INSUMOS'
if(!isset($_SESSION['censo_diario'])){
	
	$listado = $objPaciente->getDetalleHistorial($link, $id_paciente, $hospitalizado, $correlativo);
	//CARGAR DATOS BD EN ARREGLO SESSION
	while($arrObtieneCenso = mysql_fetch_array($listado)){
		if($arrObtieneCenso['camaSN'] == 'S'){
			$cod_servicio = $arrObtieneCenso['que_cod_servicio'];
			$servicio = $arrObtieneCenso['que_servicio']." (SN)";
		}else{
			$cod_servicio = $arrObtieneCenso['cod_servicio'];
			$servicio = $arrObtieneCenso['servicio'];
		}
		if($arrObtieneCenso['cod_servicio'] == 6){
			if($arrObtieneCenso['tipo_1'] == 13)
				$servicio = $arrObtieneCenso['servicio']." (UCI)";			
			if($arrObtieneCenso['tipo_1'] == 14)
				$servicio = $arrObtieneCenso['servicio']." (INCUBADORA)";
			if($arrObtieneCenso['tipo_1'] == 15)
				$servicio = $arrObtieneCenso['servicio']." (CUNA-BASICA)";
		}
		if($arrObtieneCenso['cod_servicio'] == 7){
			if($arrObtieneCenso['tipo_1'] == 4)
				$servicio = $arrObtieneCenso['servicio']." (UTI)";
			if($arrObtieneCenso['tipo_1'] == 5)
				if($arrObtieneCenso['tipo_2'] == 1)
					$servicio = $arrObtieneCenso['servicio']." (INDIF-MINIMO)";
				if($arrObtieneCenso['tipo_2'] == 2)
					$servicio = $arrObtieneCenso['servicio']." (INDIF-INTERMED)";
			if($arrObtieneCenso['tipo_1'] == 6){
				if($arrObtieneCenso['tipo_2'] == 1)
					$servicio = $arrObtieneCenso['servicio']." (LACTANTES-MINIMO)";
				if($arrObtieneCenso['tipo_2'] == 2)
					$servicio = $arrObtieneCenso['servicio']." (LACTANTES-INTERMED)";
			}
		}
		$HOSid = $arrObtieneCenso['id'];
		$PACid = $arrObtieneCenso['id_paciente'];
		$PACcta_cte = $arrObtieneCenso['cta_cte'];
		//$cod_servicio = $arrObtieneCenso['cod_servicio'];
		//$servicio = $arrObtieneCenso['servicio'];
		$tipo_1 = $arrObtieneCenso['tipo_1'];
		$d_tipo_1 = $arrObtieneCenso['d_tipo_1'];
		$cod_procedencia = $arrObtieneCenso['cod_procedencia'];
		$procedencia = $arrObtieneCenso['procedencia'];
		$fecha_ingreso = $arrObtieneCenso['fecha_ingreso'];
		$hora_ingreso = $arrObtieneCenso['hora_ingreso'];
		$cod_destino = $arrObtieneCenso['cod_destino'];
		$destino = $arrObtieneCenso['destino'];
		$fecha_egreso = $arrObtieneCenso['fecha_egreso'];
		$hora_egreso = $arrObtieneCenso['hora_egreso'];
		$lista[md5($HOSid)]=array('identificador'=>md5($HOSid),'HOSid'=>$HOSid,'cod_servicio'=>$cod_servicio,'servicio'=>$servicio,'tipo_1'=>$tipo_1,'d_tipo_1'=>$d_tipo_1,'cod_procedencia'=>$cod_procedencia,'procedencia'=>$procedencia,
									'fecha_ingreso'=>$fecha_ingreso,'hora_ingreso'=>$hora_ingreso,'cod_destino'=>$cod_destino,'destino'=>$destino,'fecha_egreso'=>$fecha_egreso,
									'hora_egreso'=>$hora_egreso,'chekeado'=>'SI');
	}
	$_SESSION['censo_diario'] = $lista;
}?>
<fieldset class="titulocampo">
    <legend class="titulos_menu">paciente</legend>
    <table width="100%">
    <tr>
        <td width="10%" align="left" valign="middle">Rut</td>
        <td width="90%" align="left" valign="middle"><input name="pacRut" type="text" id="pacRut" value="<? echo $rowPaciente['rut'];?>" size="8" readonly="readonly"/>
          -
            <input name="digito" type="text" class="casilla_chica" id="digito" value="<? echo $digito;?>" size="1" readonly="readonly" />
            Ficha
            
          <input name="ficha" type="text" id="ficha" value="<? echo $rowPaciente['nroficha']; ?>" size="10" readonly="readonly" />
            Cta Cte
            <input name="ficha2" type="text" id="ficha2" value="<? echo $rowDiagnostico['cta_cte']; ?>" size="10" readonly="readonly" />
          Previsión
<input name="pacPrevision" type="text" id="pacPrevision" value="<? echo $rowPaciente['nom_prev']; ?>" size="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>
      Nombre</td>
      <td>
        <input name="pacNombre" type="text" id="pacNombre" value="<? echo $rowPaciente['nombres']." ".$rowPaciente['apellidopat']." ".$rowPaciente['apellidomat']; ?>" size="50" readonly="readonly" />
        
        Sexo
        <input name="pacSexo" type="text" class="casilla_media" id="pacSexo" value="<? echo $rowPaciente['sexo']; ?>" size="2" readonly="readonly"/>
        
        Fecha Nac
        <input name="fecha_nac" type="text" id="fecha_nac" value="<? echo $fecha_nac; ?>" size="6" readonly="readonly"/>
        
      </td>
      </tr>
    <tr>
      <td>Dirección</td>
      <td><input name="pacDireccion" type="text" id="pacDireccion" value="<? echo $rowPaciente['direccion']; ?>" size="50" readonly="readonly" /></td>
    </tr>
</table>
</fieldset>
<fieldset class="titulocampo">
  <legend class="titulos_menu">Datos HOSPITALIZACION</legend>
    <table width="100%">
    <tr>
      <td width="19%">
      Médico Tratante</td>
      <td width="28%">
        <input name="medico" type="text" id="medico" value="<? echo $rowDiagnostico['medico']; ?>" size="50" readonly="readonly" /> </td>
      <td width="14%">Rut Médico</td>
      <td width="39%"><input name="medico2" type="text" id="medico2" value="<? echo $rowDiagnostico['rut']; ?>" size="15" readonly="readonly" /></td>
      </tr>
    <tr>
      <td>Pre-Diagnóstico</td>
      <td colspan="3"><input name="diagnostico1" type="text" id="diagnostico1" value="<? echo $rowDiagnostico['diagnostico1']; ?>" size="50" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Diagnóstico</td>
      <td colspan="3"><input name="diagnostico2" type="text" id="diagnostico2" value="<? echo $rowDiagnostico['diagnostico2']; ?>" size="50" readonly="readonly" /></td>
    </tr>    
</table>
</fieldset>
<fieldset class="titulocampo">
<legend class="titulos_menu">MOVIMIENTOS HOSPITALIZACION</legend>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#999999" style="color:#FFF">
      <th width="4%" height="31" rowspan="2" align="center" valign="middle">N°</th>
      <th width="23%" rowspan="2" align="center" valign="middle">SERVICIO</th>
      <th colspan="2" align="center" valign="middle">INGRESO</th>
      <th colspan="2" align="center" valign="middle">EGRESO</th>
      <? if($correlativo == 0){?>
      <th width="10%" rowspan="2" align="center" valign="middle">Incluir en Correlativo</th>
      <th width="7%" rowspan="2" align="center" valign="middle">Modificar</th>
      <th width="7%" rowspan="2" align="center" valign="middle">Eliminar</th>
      <? }?>
     </tr>
    <tr bgcolor="#999999" style="color:#FFF">
      <th width="12%" height="15" align="center" valign="middle">Fecha</th>
      <th width="13%" align="center" valign="middle">Procedencia</th>
      <th width="11%" align="center" valign="middle">Fecha</th>
      <th width="13%" align="center" valign="middle">Destino</th>
    </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<? if($act == 'pac'){
			$i=1; 
			foreach($lista as $k => $v){ 
				$fecha_ingreso = $objPaciente->invierteFecha($v['fecha_ingreso']);
				$fecha_egreso = $objPaciente->invierteFecha($v['fecha_egreso']); ?>
		  <tr <? if($v['chekeado'] != 'SI') echo "bgcolor='#EAEAEA' style='color:#999;'";?>>
                    <td width="4%" height="34" align="center" valign="middle"><? echo $i;?></td>
                    <td width="23%" align="center" valign="middle"><? echo $v['servicio'];?></td>
                    <td width="12%" align="center" valign="middle"><? echo $fecha_ingreso."<br/>".$v['hora_ingreso'];?></td>
                    <td width="13%" align="center" valign="middle"><? echo $v['procedencia'];?></td>
                    <td width="11%" align="center" valign="middle"><? echo $fecha_egreso."<br/>".$v['hora_egreso'];?></td>
                    <td width="13%" align="center" valign="middle"><? echo $v['destino'];?></td>
                    <? if($correlativo == 0){?>
                    <td width="10%" align="center" valign="middle"><input type="checkbox" name="incluye" id="incluye" <? if($v['chekeado'] == 'SI') echo "checked";?> onClick="javascript: document.form1.pacId.value='<? echo $pacId;?>'; document.form1.act.value='pac'; document.form1.busca.value='<? echo $busca;?>'; document.form1.tipo_doc.value='<? echo $tipo_doc;?>'; document.form1.chekear.value='<? echo $v['HOSid'];?>'; document.form1.submit();" /></td>
                    <td width="7%" align="center" valign="middle"><a id="<#AWBID2>;" href="modificaHospitalizacion.php?id_paciente=<? echo $id_paciente;?>&tipo_doc=<? echo $tipo_doc;?>&busca=<? echo $busca;?>&HOSid=<? echo $v['HOSid'];?>&act=leer&hospitalizado=<? echo $hospitalizado; ?>&desde=<? echo $desde;?>&totalreg=<? echo $totalreg;?>&que_cod_servicio=<? echo $que_cod_servicio; ?>" title="Modificar Hospitalización" name="m2"><img border="0" src="../../estandar/iconos/editar.jpg" width="20" height="20" alt="Modificar Hospitalización" /></a></td>
                    <td width="7%" align="center" valign="middle"><a onClick="javascript: confirmaEliminar(<? echo $v['HOSid'];?>);" title="Eliminar Registro" name="m2"><img border="0" src="../../estandar/iconos/eliminar.jpg" width="20" height="20" alt="Eliminar Registro" /></a></td>                          
					<? }?>
                </tr>
			<? $i++; 
			}
		}?>
</table>
</fieldset>
<fieldset class="titulocampo">
<legend class="titulos_menu">opciones</legend>
<table align="center" width="100%">
    <tr>
        <td align="center">
        	<? if($correlativo != 0){?>
        	<input type="button" name="volver2" id="volver2" value="   Imprimir Egreso    " onclick="javascript: window.open('imprimeEgreso.php?correlativo=<? echo $correlativo; ?>&id_paciente=<? echo $id_paciente;?>&hospitalizado=<? echo $hospitalizado;?>','','toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=1, left=0, top=0, height=700, width=1000');" />
			<? }?>
			<? if($correlativo == 0){?>
          	<input type="button" name="graba" id="graba" value="     Generar Correlativo     " onclick="javascript: document.form1.act.value='pac'; document.form1.que_pag.value='lis'; document.form1.borra_session.value='si'; document.form1.action='generaCorrelativo.php'; document.form1.submit();" />
            <? }?>
            <input type="button" name="volver" id="volver" <? if($correlativo == 0) echo "value='     Descartar Cambios     '"; else echo "value='     Volver     '";?> onclick="javascript: document.form1.act.value='pac'; document.form1.que_pag.value='lis'; document.form1.borra_session.value='si'; document.form1.submit();" />
        </td>
    </tr>
</table>
</fieldset>