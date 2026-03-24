<? 
//CARGA EL LISTADO GENERAL DE HOSPITALIZACIONES
$bd->db_select("camas",$link);
$listado = $objPaciente->getHistorial($link, $pacId, $porCorrelativo, $anio);
//echo $listado;

?>
<fieldset class="titulocampo">
<legend class="titulos_menu">Hospitalizaciones</legend>
<table width="98%" border="1" cellpadding="2" cellspacing="0">
    <tr bgcolor="#999999" style="color:#FFF">
      <th width="4%" height="21" align="center" valign="middle">N°</th>
      <th width="16%" align="center" valign="middle">HOSPITALIZADO</th>
      <th width="13%" align="center" valign="middle">RUT</th>
      <th width="23%" align="center" valign="middle">PACIENTE</th>
      <th width="15%" align="center" valign="middle">EGRESO</th>
      <th width="29%" align="center" valign="middle">CORRELATIVO DE EGRESO</th>
     </tr>
  </table>
<div style="width:100%px;height:415px;overflow:auto;">
<table width="98%" border="1" cellpadding="2" cellspacing="0">
    
			<? $i=1; 
			if(@mysql_num_rows($listado)){
				while($resListado = mysql_fetch_array($listado)){
					$fecha_hospitalizado = $objPaciente->invierteFecha($resListado['fecha_ingreso']);
					$fecha_egreso = $objPaciente->invierteFecha($resListado['fecha_egreso']);
					
					$id_paciente = $resListado['id_paciente'];
					$correlativo = $resListado['censo_correlativo'];
					$hospitalizado = $resListado['hospitalizado'];
					list($fecha_hosp) = explode(" ",$hospitalizado);
					$fecha_hosp = $objPaciente->invierteFecha($fecha_hosp);?>
					<tr height="35" <? if (array_search(267, $permisos) != NULL or $correlativo > 0) {?>onclick="window.location.href='<? echo "listadoCensoDiario.php?id_paciente=$id_paciente&hospitalizado=$hospitalizado&act=pac&que_pag=det&tipo_doc=$tipo_doc&busca=$busca&correlativo=$correlativo";?>';"<? }?> style="cursor:pointer;">
                        <td width="4%" align="center" valign="middle"><? echo $i;?></td>
                        <td width="16%" align="center" valign="middle"><? echo $fecha_hosp;?></td>
                        <td width="13%" align="center" valign="middle"><? echo formatoNum($resListado['rut_paciente'])."-".generaDigito($resListado['rut_paciente']);?></td>
                        <td width="23%" align="center" valign="middle"><? echo $resListado['nom_paciente'];?></td>
                        <td width="15%" align="center" valign="middle"><? echo $fecha_egreso;?></td>
                        <td width="29%" align="center" valign="middle"><? if($resListado['censo_correlativo'] != 0) echo "#".$resListado['censo_correlativo']; else echo "NO DEFINIDO";?></td>
		  			</tr>
				<? $i++; 
				}
			}else{ ?>
				<tr>
					  <td width="4%" colspan="6" height="40" align="center" valign="middle" style="size:16px;">¡Paciente no posee egresos Hospitalarios!</td>
	  </tr>
			<? }?>
</table>
</div>
</fieldset>