<? session_start();
$usuariorun = $_SESSION['MM_RUNUSU'];
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


if($accion == 1){ //insertar nuevo registro de diagnostico
	$caracteres = $_POST['diagnosticolisto'];
	$diagnosticoold = EstandarLetras($caracteres);
	$diagnosticoold = str_replace('"',"´",$diagnosticoold);
	$objdiagnosticomedico->nuevodiagnostico($link, $diagnosticoold, $ctacte, $usuariorun);
}elseif($accion == 0){ //busqueda todas las opciones realizan busqueda se establecio 0 como valor por defecto
	
}elseif($accion == 3){ // eliminar por id
	$idelimina = $_POST['idelimina'];
	$objdiagnosticomedico->eliminadiagnostico($link, $idelimina, $usuariorun);
}elseif($accion == 4){ //actualizar por id
	$idactualiza = $_POST['idactualiza'];
	$diagnosticoactualiza = $_POST['diagnosticoactualiza'];
	$diagnosticoactualiza = str_replace('"',"`",$diagnosticoactualiza);
	$diagnosticoactualiza = str_replace("'","`",$diagnosticoactualiza);
	$objdiagnosticomedico->actualizadiagnostico($link, $idactualiza, $diagnosticoactualiza, $usuariorun);
}elseif($accion == 5){ //Establece diagnostico Principal
	$idactualiza = $_POST['idactualiza'];
	$diagnosticoactualiza = $_POST['diagnosticoactualiza'];
	//$diagnosticoactualiza = str_replace('"',"'",$diagnosticoactualiza);
	$objdiagnosticomedico->asignardiagnosticoprincipal($link, $idactualiza, $diagnosticoactualiza, $usuariorun, $ctaCte_epicrisis);
}
$RSresultado = $objdiagnosticomedico->buscadiagnosticos($link, $ctacte);
if(mysql_num_rows($RSresultado)>0){
?>
<script type="text/javascript">
cargarContenido('dialog/mascontroles.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masgrilla');
</script>
<div class="tabla">
	<table>
		<tr>
			<td>ID</td>
			<td>Diagnostico</td>
			<td>Acciones</td>
		</tr>
<?
	$i=1;
	mysql_data_seek($RSresultado,0);
	while($arraydiagnosticos = mysql_fetch_assoc($RSresultado))
	{
?>
		<tr>
			<td><?=$i;?></td>
			<td <? if($arraydiagnosticos['dm_principal'] == "P"){ ?> bgcolor="#c5dbec" <? } ?>><input type="text" value="<?=$arraydiagnosticos['dm_diagnostico'];?>" size="90px" width="400px" id="<?=$arraydiagnosticos['dm_id'];?>" name="<?=$arraydiagnosticos['dm_id'];?>"></td>
			<td>
				<img src="img/trash-can-32.png" title="Eliminar" onclick="cargarContenido('dialog/masdiagnosticosmedicos','accion=3&idelimina=<?=$arraydiagnosticos['dm_id'];?>&ctaCte_epicrisis=<?=$ctacte?>','#masdiagnosticos');" height="22" width="22">
				<img src="img/EDIT2.png" title="Actualizar" onclick="cargarContenido('dialog/masdiagnosticosmedicos','accion=4&idactualiza=<?=$arraydiagnosticos['dm_id'];?>&diagnosticoactualiza='+$('#<?=$arraydiagnosticos['dm_id']?>').val()+'&ctaCte_epicrisis=<?=$ctacte?>','#masdiagnosticos');" height="22" width="22">
				<img src="img/diagnosticoprincipal.png" title="Establecer Diagnostico Principal" onclick="cargarContenido('dialog/masdiagnosticosmedicos','accion=5&idactualiza=<?=$arraydiagnosticos['dm_id'];?>&diagnosticoactualiza='+$('#<?=$arraydiagnosticos['dm_id']?>').val()+'&ctaCte_epicrisis=<?=$ctacte?>','#masdiagnosticos');$('#diagnosticos').val('<?=$arraydiagnosticos['dm_diagnostico'];?>')" height="20" width="18">
			</td>
		</tr>
<?
	$i++;
	}
?>
	</table>
</div>
<? }?>
