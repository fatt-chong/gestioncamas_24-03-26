<? 
include "../funciones/epicrisis_funciones.php";

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('epicrisis') or die('Cannot select database');
//mysql_query("SET NAMES 'utf8'");

$fechaIng = cambiarFormatoFecha2($ingFecha);
$fechaEgr = cambiarFormatoFecha2($altFecha);


//INGRESA LAS INDICACIONES A UNA NUEVA TABLA CON LOS FAVORITOS DE CADA MEDICO

if($fav == 1){
	
	$sqlactFavorito = "UPDATE favoritos 
						SET 
						nombreFav ='$nomFav',
						descFav = '$detalleEpi' 
						WHERE (idFav = '$listaFavoritos')";
	
	$updateFavoritos = mysql_query($sqlactFavorito) or die($sqlactFavorito." No se logro realizar el Update de favorito ".mysql_error());
	
$idFavorito = $listaFavoritos;
	}
else if($fav == 2){
	
	$sqlagrFavorito = "INSERT INTO favoritos
								(descFav,
								nombreFav,
								idMedico)
								VALUES 
								('$detalleEpi',
								'$nomFav',
								'$idUsuario')";
								
	$insertFavorito = mysql_query($sqlagrFavorito) or die($sqlagrFavorito. " No se logro realizar el Insert de favorito". mysql_error());


//Recupera el id de la epicrisis creada
$idFavorito = mysql_insert_id();
}
?>
<meta http-equiv='refresh' content='0; url=epicrisisMedica.php?graba=1&idEpicrisis=<? echo $idEpicrisis; ?>&id_cama=<? echo $id_cama; ?>&ctaCte=<? echo $ctaCte; ?>&id_paciente=<? echo $id_paciente; ?>&idServicio=<? echo $idServicio; ?>&prev_paciente=<? echo $prev_paciente; ?>&cod_prev=<? echo $cod_prev; ?>&ing_paciente=<? echo $ing_paciente; ?>&cama_sn=<? echo $cama_sn; ?>&hospitaliza=<? echo $hospitaliza; ?>&diagnosticos=<? echo $diagnosticos; ?>&fundamentos=<? echo $fundamentos; ?>&medico=<? echo $medico; ?>&condEgreso=<? echo $condEgreso; ?>'>