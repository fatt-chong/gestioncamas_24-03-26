<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Categorizaci�n de Camas.</title>

<script type="text/javascript">
function procesa(){
//	document.formulario.btn_aceptar.disabled = false
	
	if (document.formulario.ev_1[0].checked) { var ev_1 = 0 }
	if (document.formulario.ev_1[1].checked) { var ev_1 = 1 }
	if (document.formulario.ev_1[2].checked) { var ev_1 = 2 }
	if (document.formulario.ev_1[3].checked) { var ev_1 = 3 }
	
	if (document.formulario.ev_2[0].checked) { var ev_2 = 0 }
	if (document.formulario.ev_2[1].checked) { var ev_2 = 1 }
	if (document.formulario.ev_2[2].checked) { var ev_2 = 2 }
	if (document.formulario.ev_2[3].checked) { var ev_2 = 3 }
	
	if (document.formulario.ev_3[0].checked) { var ev_3 = 0 }
	if (document.formulario.ev_3[1].checked) { var ev_3 = 1 }
	if (document.formulario.ev_3[2].checked) { var ev_3 = 2 }
	if (document.formulario.ev_3[3].checked) { var ev_3 = 3 }
	
	if (document.formulario.ev_4[0].checked) { var ev_4 = 0 }
	if (document.formulario.ev_4[1].checked) { var ev_4 = 1 }
	if (document.formulario.ev_4[2].checked) { var ev_4 = 2 }
	if (document.formulario.ev_4[3].checked) { var ev_4 = 3 }
	
	if (document.formulario.ev_5[0].checked) { var ev_5 = 0 }
	if (document.formulario.ev_5[1].checked) { var ev_5 = 1 }
	if (document.formulario.ev_5[2].checked) { var ev_5 = 2 }
	if (document.formulario.ev_5[3].checked) { var ev_5 = 3 }
	
	if (document.formulario.ev_6[0].checked) { var ev_6 = 0 }
	if (document.formulario.ev_6[1].checked) { var ev_6 = 1 }
	if (document.formulario.ev_6[2].checked) { var ev_6 = 2 }
	if (document.formulario.ev_6[3].checked) { var ev_6 = 3 }
	
	if (document.formulario.ev_7[0].checked) { var ev_7 = 0 }
	if (document.formulario.ev_7[1].checked) { var ev_7 = 1 }
	if (document.formulario.ev_7[2].checked) { var ev_7 = 2 }
	if (document.formulario.ev_7[3].checked) { var ev_7 = 3 }
	
	if (document.formulario.ev_8[0].checked) { var ev_8 = 0 }
	if (document.formulario.ev_8[1].checked) { var ev_8 = 1 }
	if (document.formulario.ev_8[2].checked) { var ev_8 = 2 }
	if (document.formulario.ev_8[3].checked) { var ev_8 = 3 }
	
	var total_riesgo = ev_1 + ev_2 + ev_3 + ev_4 + ev_5 + ev_6 + ev_7 + ev_8
	document.formulario.total_riesgo.value = total_riesgo
   
	if (total_riesgo < 6) { var categorizacion_riesgo = 'D' }
	if (total_riesgo > 5 && total_riesgo < 12) { var categorizacion_riesgo = 'C' } 
	if (total_riesgo > 11 && total_riesgo < 19) { var categorizacion_riesgo = 'B' }
	if (total_riesgo > 18) { var categorizacion_riesgo = 'A' }

	if (document.formulario.ev_9[0].checked) { var ev_9 = 0 }
	if (document.formulario.ev_9[1].checked) { var ev_9 = 1 }
	if (document.formulario.ev_9[2].checked) { var ev_9 = 2 }
	if (document.formulario.ev_9[3].checked) { var ev_9 = 3 }
	
	if (document.formulario.ev_10[0].checked) { var ev_10 = 0 }
	if (document.formulario.ev_10[1].checked) { var ev_10 = 1 }
	if (document.formulario.ev_10[2].checked) { var ev_10 = 2 }
	if (document.formulario.ev_10[3].checked) { var ev_10 = 3 }
	
	if (document.formulario.ev_11[0].checked) { var ev_11 = 0 }
	if (document.formulario.ev_11[1].checked) { var ev_11 = 1 }
	if (document.formulario.ev_11[2].checked) { var ev_11 = 2 }
	if (document.formulario.ev_11[3].checked) { var ev_11 = 3 }
	
	if (document.formulario.ev_12[0].checked) { var ev_12 = 0 }
	if (document.formulario.ev_12[1].checked) { var ev_12 = 1 }
	if (document.formulario.ev_12[2].checked) { var ev_12 = 2 }
	if (document.formulario.ev_12[3].checked) { var ev_12 = 3 }
	
	if (document.formulario.ev_13[0].checked) { var ev_13 = 0 }
	if (document.formulario.ev_13[1].checked) { var ev_13 = 1 }
	if (document.formulario.ev_13[2].checked) { var ev_13 = 2 }
	if (document.formulario.ev_13[3].checked) { var ev_13 = 3 }
	
	if (document.formulario.ev_14[0].checked) { var ev_14 = 0 }
	if (document.formulario.ev_14[1].checked) { var ev_14 = 1 }
	if (document.formulario.ev_14[2].checked) { var ev_14 = 2 }
	if (document.formulario.ev_14[3].checked) { var ev_14 = 3 }
	
	var total_dependencia = ev_9 + ev_10 + ev_11 + ev_12 + ev_13 + ev_14
	document.formulario.total_dependencia.value = total_dependencia

	if (total_dependencia < 7) { var categorizacion_dependencia = '3'; }
	if (total_dependencia > 6 && total_dependencia < 13) { var categorizacion_dependencia = '2'; } 
	if (total_dependencia > 12) { var categorizacion_dependencia = '1'; }

	document.formulario.categorizacion_riesgo.value = categorizacion_riesgo
	document.formulario.categorizacion_dependencia.value = categorizacion_dependencia
	document.formulario.categorizacion_final.value = categorizacion_riesgo+categorizacion_dependencia
   
   
}
</script>

</head>

<body bgcolor="#FFFFFF">

<?

include "../funciones/funciones.php";

$fecha_hoy = date('d-m-Y');

$fecha_categoriza = cambiarFormatoFecha($fecha_hoy);

$cod_usuario = 1;
$usuario = 'Usuario de Prueba';




	$sql = "SELECT * FROM camas where id = '".$id_cama."'";
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);
	
	$cod_servicio = $paciente['cod_servicio'];
	$desc_servicio = $paciente['servicio'];
	$sala = $paciente['sala'];
	$cama = $paciente['cama'];
	$nom_paciente = $paciente['nom_paciente'];
	$id_paciente = $paciente['id_paciente'];
	$diagnostico2 = $paciente['diagnostico2'];
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;


$sql = "SELECT * FROM categorizacion where cod_servicio = '".$cod_servicio."' and sala = '".$sala."' and cama = '".$cama."' and fecha = '".$fecha_categoriza."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$categoriza = mysql_fetch_array($query);

$total_riesgo = 0;

$total_dependencia = 0;


if ($categoriza)
{

	$ev_1 = $categoriza['ev_1'];
	$ev_2 = $categoriza['ev_2'];
	$ev_3 = $categoriza['ev_3'];
	$ev_4 = $categoriza['ev_4'];
	$ev_5 = $categoriza['ev_5'];
	$ev_6 = $categoriza['ev_6'];
	$ev_7 = $categoriza['ev_7'];
	$ev_8 = $categoriza['ev_8'];
	$ev_9 = $categoriza['ev_9'];
	$ev_10 = $categoriza['ev_10'];
	$ev_11 = $categoriza['ev_11'];
	$ev_12 = $categoriza['ev_12'];
	$ev_13 = $categoriza['ev_13'];
	$ev_14 = $categoriza['ev_14'];
	$observacion = $categoriza['observacion'];


	$total_riesgo = $ev_1 + $ev_2 + $ev_3 + $ev_4 + $ev_5 + $ev_6 + $ev_7 + $ev_8;
	$total_dependencia = $ev_9 + $ev_10 + $ev_11 + $ev_12 + $ev_13 + $ev_14;
	
}

if ($total_riesgo < 6) { $categorizacion_riesgo = 'D'; }

if ($total_riesgo > 5 and $total_riesgo < 12) { $categorizacion_riesgo = 'C'; } 

if ($total_riesgo > 11 and $total_riesgo < 19) { $categorizacion_riesgo = 'B'; }

if ($total_riesgo > 18) { $categorizacion_riesgo = 'A'; }


if ($total_dependencia < 7) { $categorizacion_dependencia = '3'; }

if ($total_dependencia > 6 and $total_dependencia < 13) { $categorizacion_dependencia = '2'; } 

if ($total_dependencia > 12) { $categorizacion_dependencia = '1'; }

$categorizacion_final = $categorizacion_riesgo.''. $categorizacion_dependencia;

?>

<div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
<form method="get" name="formulario" action="pro2_categoriza.php">

    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
    <input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
    <input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
    <input type="hidden" name="sala" value="<? echo $sala ?>" />
    <input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
    <input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
    <input type="hidden" name="cama" value="<? echo $cama ?>" />
    <input type="hidden" name="cod_usuario" value="<? echo $cod_usuario ?>" />
    <input type="hidden" name="usuario" value="<? echo $usuario ?>" />
    <input type="hidden" name="observacion" value="<? echo $observacion ?>" />

    <table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td bgcolor="#99CCFF" style="font-size:16px"><strong>Informacion de Paciente</strong></td></tr>    
	    <tr><td><? echo $nom_paciente ?> </td></tr>    
		<tr><td>Serv.Cl�nico <? echo $desc_servicio ?> </td></tr>
        <tr><td>Sala <? echo $sala ?> - Cama N� <? echo $cama ?> </td></tr>
	</table>
    <br>
    
    <table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td colspan="5" bgcolor="#99CCFF" style="font-size:16px"><strong>Evaluaci�n de Riesgo</strong></td></tr>    
        <tr align="center">
        	<td align="left">Evaluaci�n</td><td>0</td><td>1</td><td>2</td><td>3</td>
        </tr>
        <tr>
            <td align="left">Med. Signos Vitales</td>
            <td> <input type="radio" name="ev_1" value="0" <? if ($ev_1 == 0) { echo "checked='checked'"; } ?> 
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_1" value="1" <? if ($ev_1 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_1" value="2" <? if ($ev_1 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_1" value="3" <? if ($ev_1 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
        </tr>
        <tr>
            <td align="left">Balance Hidrico</td>
            <td> <input type="radio" name="ev_2" value="0" <? if ($ev_2 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_2" value="1" <? if ($ev_2 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_2" value="2" <? if ($ev_2 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
            <td> <input type="radio" name="ev_2" value="3" <? if ($ev_2 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /></td>
        </tr>
        <tr>
            <td align="left">Cuid. Oxigenoterapia</td>
            <td> <input type="radio" name="ev_3" value="0" <? if ($ev_3 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_3" value="1" <? if ($ev_3 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_3" value="2" <? if ($ev_3 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_3" value="3" <? if ($ev_3 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Cuid. Diarios V. Aerea</td>
            <td> <input type="radio" name="ev_4" value="0" <? if ($ev_4 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_4" value="1" <? if ($ev_4 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_4" value="2" <? if ($ev_4 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_4" value="3" <? if ($ev_4 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Interv. Profesionales</td>
            <td> <input type="radio" name="ev_5" value="0" <? if ($ev_5 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_5" value="1" <? if ($ev_5 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_5" value="2" <? if ($ev_5 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_5" value="3" <? if ($ev_5 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Cuid. Piel y Curaciones</td>
            <td> <input type="radio" name="ev_6" value="0" <? if ($ev_6 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_6" value="1" <? if ($ev_6 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_6" value="2" <? if ($ev_6 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_6" value="3" <? if ($ev_6 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Adm.Trat.Farmacolog.</td>
            <td> <input type="radio" name="ev_7" value="0" <? if ($ev_7 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_7" value="1" <? if ($ev_7 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_7" value="2" <? if ($ev_7 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_7" value="3" <? if ($ev_7 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Presen.Elem.Invasivos</td>
            <td> <input type="radio" name="ev_8" value="0" <? if ($ev_8 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_8" value="1" <? if ($ev_8 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_8" value="2" <? if ($ev_8 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_8" value="3" <? if ($ev_8 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        
        <tr>
            <td align="left">Total Puntos y Categorizaci�n</td>
            <td colspan="2"> <input type="text" size="4" name="total_riesgo" value="<? echo $total_riesgo ?>" readonly="readonly" /> </td>
            <td colspan="2"> <input type="text" size="4" name="categorizacion_riesgo" value="<? echo $categorizacion_riesgo ?>" readonly="readonly" /> </td>
        </tr>
    </table>
    <br>
    
    <table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td colspan="5" bgcolor="#99CCFF" style="font-size:16px"><strong>Evaluaci�n Dependencia</strong></td></tr>    
        <tr align="center">
        	<td align="left">Evaluaci�n</td><td>0</td><td>1</td><td>2</td><td>3</td>
        </tr>
        <tr>
            <td align="left">Cuid.Confort,Bienestar</td>
            <td> <input type="radio" name="ev_9" value="0" <? if ($ev_9 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_9" value="1" <? if ($ev_9 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_9" value="2" <? if ($ev_9 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_9" value="3" <? if ($ev_9 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Cuid.Confort,Bienestar</td>
            <td> <input type="radio" name="ev_10" value="0" <? if ($ev_10 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_10" value="1" <? if ($ev_10 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_10" value="2" <? if ($ev_10 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_10" value="3" <? if ($ev_10 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Cuid. de Alimentaci�n</td>
            <td> <input type="radio" name="ev_11" value="0" <? if ($ev_11 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_11" value="1" <? if ($ev_11 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_11" value="2" <? if ($ev_11 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_11" value="3" <? if ($ev_11 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Cuid. de Eliminaci�n</td>
            <td> <input type="radio" name="ev_12" value="0" <? if ($ev_12 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_12" value="1" <? if ($ev_12 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_12" value="2" <? if ($ev_12 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_12" value="3" <? if ($ev_12 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Ap.Psicos./Emocional</td>
            <td> <input type="radio" name="ev_13" value="0" <? if ($ev_13 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_13" value="1" <? if ($ev_13 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_13" value="2" <? if ($ev_13 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_13" value="3" <? if ($ev_13 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Vigilancia</td>
            <td> <input type="radio" name="ev_14" value="0" <? if ($ev_14 == 0) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_14" value="1" <? if ($ev_14 == 1) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_14" value="2" <? if ($ev_14 == 2) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
            <td> <input type="radio" name="ev_14" value="3" <? if ($ev_14 == 3) { echo "checked='checked'"; } ?>
            onclick="procesa()" /> </td>
        </tr>
        <tr>
            <td align="left">Total Puntos y Categorizaci�n</td>
            <td colspan="2"> <input type="text" size="4" name="total_dependencia" value="<? echo $total_dependencia ?>" readonly="readonly" /> </td>
            <td colspan="2"> <input type="text" size="4" name="categorizacion_dependencia" value="<? echo $categorizacion_dependencia ?>" readonly="readonly" /> </td>
        </tr>

        <tr>
	        <td colspan="5">Observaci�n <input type="text" size="40" maxlength="50" name="observacion" value="<? echo $observacion ?>" > </td>
        </tr>
    </table>
	<br>    

    <table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td colspan="5" bgcolor="#99CCFF" style="font-size:16px"><strong>Categorizaci�n</strong></td></tr>    
        <tr align="center">
	        <td colspan="5" > <input style="font-size:20px; text-align:center" type="text" size="2" name="categorizacion_final" value="<? echo $categorizacion_final ?>" readonly="readonly" /> </td>
		</tr>
	</table>
	<br>    

	<table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td colspan="5" bgcolor="#99CCFF" style="font-size:16px"><strong>Opciones</strong></td></tr>    
        <tr align="center">
			<td colspan="5" align="center"> <input type="submit" name="btn_aceptar" value="     Grabar     " > <input type="Button" value= "   Cancelar   " onClick="window.location.href='<? echo"sscc.php?servicio=$cod_servicio&desc_servcio=$desc_servicio"; ?>';" ></td>
		</tr>
    </table>

</form>

 
</div>

</body>
</html>
