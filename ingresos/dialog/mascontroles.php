<? session_start();
$usuariorun = $_SESSION['MM_RUNUSU'];
$usuario_actual = $_SESSION['MM_Username'];
//$accion = 1 : Grabar
//$accion = 0 : buscar

$accion = $_POST['accion'];
$ctacte = $_POST['ctaCte_epicrisis'];
require_once('../clases/Conectar.inc'); 
	$objConectar = new Conectar; 
	$link = $objConectar->db_connect();
require_once('../clases/diagnosticosmedicos.inc'); 
	$objdiagnosticomedico = new diagnosticosmedicos;
include('../include/funciones.php');


if($accion == 1){ //insertar nuevo registro de control
	$caracteres = $_POST['diagnosticos'];
	$CA_Fundamento = $_POST['fundamentos'];
	$CA_INTespecialidad_destino = $_POST['especialidad'];
	$CA_INTperiodo_control = $_POST['periodo'];
	$CA_IdPaciente = $_POST['idPaciente'];
	$CA_INTmedico_tratante = $_POST['medico_id'];

	$diagnosticoold = EstandarLetras($caracteres);
	$diagnosticoold = str_replace('"',"´",$diagnosticoold);
	$diagnosticoold = str_replace('<',"menor que",$diagnosticoold);
	$diagnosticoold = str_replace('>',"mayor que",$diagnosticoold);
	$diagnosticoold = str_replace(''," ",$diagnosticoold);
	$paso = '0';
	$RSresultadocontrolx = $objdiagnosticomedico->buscarcontroles($link, $ctacte);
	if(mysql_num_rows($RSresultadocontrolx)>0){
		mysql_data_seek($RSresultadocontrolx,0);
		while($arraycontrolinterconsultax = mysql_fetch_assoc($RSresultadocontrolx)){
			if($arraycontrolinterconsultax['ESPcodigo'] == $CA_INTespecialidad_destino){
				$paso = '1';
			}
		}
	}
	if($CA_INTperiodo_control <> '0' and $CA_INTespecialidad_destino <> '0' and $paso == '0'){
		$objdiagnosticomedico->nuevocontrolinterconsulta($link, $ctacte, $diagnosticoold, $CA_Fundamento, $CA_INTespecialidad_destino, $CA_INTperiodo_control, $CA_IdPaciente, $CA_INTmedico_tratante, $usuariorun, $usuario_actual);
	}
}elseif($accion == 0){ //busqueda todas las opciones realizan busqueda se establecio 0 como valor por defecto
	
}elseif($accion == 3){ // eliminar por id
	$idelimina = $_POST['idelimina'];
	$objdiagnosticomedico->eliminacontrolinterconsulta($link, $idelimina, $usuariorun);
}elseif($accion == 4){ //actualizar por id
	$idactualiza = $_POST['idactualiza'];
	$diagnosticoactualiza = $_POST['diagnosticoactualiza'];
	if($diagnosticoactualiza != ""){
		$diagnosticoactualiza = str_replace('"',"`",$diagnosticoactualiza);
		$diagnosticoactualiza = str_replace("'","`",$diagnosticoactualiza);
		$objdiagnosticomedico->actualizacontrolinterconsulta($link, $idactualiza, $diagnosticoactualiza);
	}
}

$RSresultadocontrol = $objdiagnosticomedico->buscarcontroles($link, $ctacte);
if(mysql_num_rows($RSresultadocontrol)>0){
?>
<input type="hidden" name="validacontrolagenda" id="validacontrolagenda" value="1">
<style type="text/css">
	.tabla2{
		font-family: verdana, Helvica, sans-serif;
		font-size: 12px;
		font-style: normal;
		font-weight: normal;
	}
</style>
<div class="tabla2">
	<table width="100%" class="tabla2">
		<tr>
			<td>ID</td>
			<td>Especialidad</td>
			<td>Periodo de control</td>
			<td>Diagnostico</td>
		</tr>
<?
	$i=1;
	mysql_data_seek($RSresultadocontrol,0);
	while($arraycontrolinterconsulta = mysql_fetch_assoc($RSresultadocontrol))
	{
?>
		<tr>
			<td><?=$i;?></td>
			<td><?=$arraycontrolinterconsulta['ESPdescripcion'];?></td>
			<td><?=$arraycontrolinterconsulta['CA_INTperiodo_control'];?></td>
			<td>
<? 	//if($arraycontrolinterconsulta['CA_Diagnostico']<>""){
		//echo $arraycontrolinterconsulta['CA_Diagnostico'];
	//}else{
		$RSresultado = $objdiagnosticomedico->buscadiagnosticos($link, $ctacte);
		if(mysql_num_rows($RSresultado)>0){
			mysql_data_seek($RSresultado,0);
?>
			<select id="diagnosticoseleccionado<?=$i;?>" name="diagnosticoseleccionado<?=$i;?>">
				<option value="">Seleccione...</option>
<?
			while($arraydiagnosticos = mysql_fetch_assoc($RSresultado)){
?>
				<option value="<?=$arraydiagnosticos['dm_diagnostico'];?>" <?if($arraycontrolinterconsulta['CA_Diagnostico']==$arraydiagnosticos['dm_diagnostico']){?> selected<? }?>><?=$arraydiagnosticos['dm_diagnostico'];?></option>
<?			
			}
?>
			</select>
<?
//}
}else{
	echo $arraycontrolinterconsulta['CA_Diagnostico'];
}
?>
			</td>
			<td>
				<img src="img/trash-can-32.png" title="Eliminar" onclick="cargarContenido('dialog/mascontroles.php','accion=3&idelimina=<?=$arraycontrolinterconsulta['CA_Id'];?>&ctaCte_epicrisis=<?=$ctacte?>','#masgrilla');" height="22" width="22">
				<img src="img/EDIT2.png" title="Actualizar" onclick="cargarContenido('dialog/mascontroles','accion=4&idactualiza=<?=$arraycontrolinterconsulta['CA_Id'];?>&diagnosticoactualiza='+$('#diagnosticoseleccionado<?=$i;?>').val()+'&ctaCte_epicrisis=<?=$ctacte?>','#masgrilla');" height="22" width="22">
			</td>
		</tr>
<?
	$i++;
	}
?>
	</table>
</div>
<? }?>
