<table width="929">
<tr>
  	<td width="287" valign="top">
		<table>
            	<tr valign="top">
                	<td valign="top">
                    <fieldset>
                      <legend class="titulos_menu"> Pacientes en Espera</legend>
                      <div align="center" style="width:230px;height:330px;overflow:auto ">
               	    <table width="203" id="tabla">
                    	<tr bgcolor="#66B3FF">
                          <td width="36" >N° RAU</td>
                          <td width="128" >Paciente</td>
                          <td width="23">Cat.</td>
                        </tr>
                        <?
						
						 while($arrayEspera = mysql_fetch_array($sqlEspera)){
								$idRauLista = $arrayEspera['id_EspRau'];
								$nomPacienteLista = $arrayEspera['paciente_EspRau'];
								$catPacienteLista = $arrayEspera['cat_EspRau'];	
						?>
                        <tr bgcolor="#BFEBFF" style="cursor:pointer"
                    onclick="javascript:document.location.href='lista_rau.php?idrau=<? echo $idRauLista; ?>&atencion=G';">
                        	<td><? echo $idRauLista; ?></td>
                            <td><? echo $nomPacienteLista; ?></td>
                            <td><? echo $catPacienteLista; ?></td>
                        </tr>
						<? } ?>
                      </table> 
                      </div>
                    </fieldset>
                    </td>
                </tr>
  		</table>
       <?	if($idrau){
       		$sqlPaciente = "SELECT
							rau.lista_salaespera.id_EspRau,
							rau.lista_salaespera.idPac_EspRau,
							rau.lista_salaespera.ctacte_EspRau,
							rau.lista_salaespera.fechaCat_EspRau,
							rau.lista_salaespera.fecha_EspRau,
							rau.lista_salaespera.hora_EspRau,
							rau.lista_salaespera.horaCat_EspRau,
							rau.lista_salaespera.prevision_EspRau,
							rau.lista_salaespera.descCons_EspRau,
							rau.lista_salaespera.paciente_EspRau,
							rau.lista_salaespera.cat_EspRau,
							paciente.paciente.rut,
							paciente.paciente.fechanac,
							paciente.paciente.direccion,
							paciente.paciente.nroficha
							FROM
							rau.lista_salaespera
							INNER JOIN paciente.paciente ON rau.lista_salaespera.idPac_EspRau = paciente.paciente.id
							WHERE id_EspRau = '$idrau'";

			$queryPaciente = mysql_query($sqlPaciente) or die("ERROR AL SELECCIONAR DATOS DEL PACIENTE " . mysql_error());
			$arrayPaciente = mysql_fetch_array($queryPaciente);
			$categ_paciente = $arrayPaciente['cat_EspRau'];
	   		}
			
	   ?>
       </td>
        <td width="617" valign="top">
        	<table width="627">
            	<tr> 
    	<td width="596">
        <fieldset><legend class="titulos_menu">Datos del Paciente</legend>
        <input type="hidden" name="id_paciente" value="<? echo $arrayPaciente['idPac_EspRau']; ?>" />
        <input type="hidden" name="cta_cte" value="<? echo $arrayPaciente['ctacte_EspRau']; ?>" />
        
        <table width="100%" class="titulocampo" >
        	<tr>
            	<td colspan="4" align="right">N° Rau <input size="5" type="text" readonly="readonly" name="idrau" value="<? echo $idrau; ?>" /></td>
            </tr>
        	<tr>
            	<td width="69">Nombre :
                </td>
                <td width="247">
                <input readonly="readonly" size="40" type="text" name="nom_paciente" value="<? echo $arrayPaciente['paciente_EspRau']; ?>" />
                </td>
                
          </tr>
          <tr>
            	<td>Rut :
                </td>
                <td>
            	  <input readonly="readonly" size="9" type="text" name="rut_paciente" value="<? echo $arrayPaciente['rut']; ?>" />-
                  <input readonly="readonly" size="1" type="text" name="digito" value="<? echo ValidaDVRut($arrayPaciente['rut']); ?>" />
                </td>
                <td>Ficha:
                </td>
                <td>
                  <input readonly="readonly" size="10" type="text" name="ficha_paciente" value="<? echo $arrayPaciente['nroficha']; ?>" /></td>

          </tr>
          <tr>
            	<td>Direccion :</td>
                <td>
                <input readonly="readonly" size="40" type="text" name="direc_paciente" value="<? echo $arrayPaciente['direccion']; ?>" />
                </td>
                <td>Prevision:</td>
                <td>
                <input readonly="readonly" size="15" type="text" name="prev_paciente" value="<? echo nombrePrevision($arrayPaciente['prevision']); ?>" /></td>

          </tr>
          
        </table>
        </fieldset>
        <fieldset><legend class="titulos_menu">Datos Urgencia</legend>
       	<table width="618" class="titulocampo">
        	<tr>
            	<td width="120">
                Causa:
                </td>
                <td colspan="4">
                <input size="50" readonly="readonly" type="text" name="causa" value="<? echo $arrayPaciente['descCons_EspRau'];?>" />
                </td>
            </tr>
            <tr>
                <td>Fecha RAU :
                </td>
                <td width="136"><input size="8" type="text" readonly="readonly" name="fecha_ing" value="<? echo cambiarFormatoFecha($arrayPaciente['fecha_EspRau']); ?>" />
                </td>
                <td width="45">Hora :
                </td>
                <td width="90">
                
                <input size="4" type="text" readonly="readonly" name="hora_ing" value="<? echo $arrayPaciente['hora_EspRau']; ?>" />
                </td>
          </tr>
          
          <tr>
                <td>Fecha Categ. :
                <? if(($arrayPaciente['fechaCat_EspRau']) == '1000-01-01'){ 
					$fecha_categ = date('d-m-Y');
                	 }else{
						 $fecha_categ = cambiarFormatoFecha($arrayPaciente['fechaCat_EspRau']);
						 } 
					 ?>
                </td>
                <td><input size="8" type="text" readonly="readonly" id="f_date" name="fecha_cat" value="<? echo $fecha_categ; ?>" /><input type="Button" id="f_btn" class="botonimagen" value="&nbsp;" />
                </td>
                <td>Hora :
                </td>
                <td>
                <? $hora_categorizacion = substr($arrayPaciente['horaCat_EspRau'], 0, 5); ?>
                <span id="spry_hora_cat">
    	            <input size="4"  id="hora_cat" type="text" name="hora_cat" value="<? echo $hora_categorizacion ; ?>" /><br />
                <span class="textfieldRequiredMsg">Ingrese Hora!</span>
                <span class="textfieldInvalidFormatMsg">Hora Inválida</span>
                </span>
                
                </td>
                <td width="97"> Categorizacion: 
                </td>
                <td width="102">
                <select name="categoriza">
                	<option value="0" <? if($categ_paciente == 'N/C'){ ?> selected="selected" <? } ?>>Seleccione</option>
                    <option value="1" <? if($categ_paciente == 'C1'){ ?> selected="selected" <? } ?>>C1</option>
                    <option value="2" <? if($categ_paciente == 'C2'){ ?> selected="selected" <? } ?>>C2</option>
                    <option value="3" <? if($categ_paciente == 'C3'){ ?> selected="selected" <? } ?>>C3</option>
                    <option value="4" <? if($categ_paciente == 'C4'){ ?> selected="selected" <? } ?>>C4</option>
                    <option value="5" <? if($categ_paciente == 'C5'){ ?> selected="selected" <? } ?>>C5</option>
                    <option value="6" <? if($categ_paciente == 'S/I'){ ?> selected="selected" <? } ?>>S/I</option>
                </select>
                
                </td>
          </tr>
          
            <tr>
                <td>Fecha Ingreso :
                </td>
                <td><input size="8" type="text" readonly="readonly" id="f_date2" name="fecha_ing" value="<? echo date('d-m-Y'); ?>" /><input type="Button" id="f_btn2" value="&nbsp;" class="botonimagen"  />
                </td>
                <td>Hora :
                </td>
                <td>
                <span id="spry_hora_ingreso">
    	            <input size="4"  id="hora_ingreso" type="text" name="hora_ingreso" value="" /><br />
                <span class="textfieldRequiredMsg">Ingrese Hora!</span>
                <span class="textfieldInvalidFormatMsg">Hora Inválida</span>
                </span>
                
                </td>
          </tr>
          
          <tr>
                <td>Fecha Indicacion :
                </td>
                <td><input size="8" type="text" readonly="readonly" id="f_date3" name="fecha_ind" value="<? echo date('d-m-Y'); ?>" /><input type="Button" id="f_btn3" value="&nbsp;" class="botonimagen"  />
                </td>
                <td>Hora :
                </td>
                <td>
                 <span id="spry_hora_ind">
    	            <input size="4"  id="hora_ind" type="text" name="hora_ind" value="" /><br />
                <span class="textfieldRequiredMsg">Ingrese Hora!</span>
                <span class="textfieldInvalidFormatMsg">Hora Inválida</span>
                </span>
                </td>
          </tr>
          <tr>
          	<td>
            Indicacion Egreso:
            </td>
            <td>
            	<select name="estado" id="estado" onchange="disableCombos()">
                	<option value="2" <? if($arrayPaciente['estado'] == 2){ ?> selected="selected" <? } ?> >Seleccione</option>
                	<option value="3" <? if($arrayPaciente['estado'] == 3){ ?> selected="selected" <? } ?> >Alta Hogar</option>
                    <option value="7" <? if($arrayPaciente['estado'] == 7){ ?> selected="selected" <? } ?>>Alta Urgencia</option>
                    <option value="4" <? if($arrayPaciente['estado'] == 4){ ?> selected="selected" <? } ?>>Hospitalizacion</option>
                    <option value="5" <? if($arrayPaciente['estado'] == 5){ ?> selected="selected" <? } ?>>Rechaza Hospt.</option>
                    <option value="6" <? if($arrayPaciente['estado'] == 6){ ?> selected="selected" <? } ?>>Defuncion</option>
                </select>
            </td>
          </tr>
          
          <tr>
          	<td>
            Servicio Destino:
            </td>
            <td>
            <select name="servicio_tras" id="servicio_tras">
           
            <? 
			//SELECCIONA LOS SERVICIOS PARA HACER EL TRASLADO
			mysql_select_db('camas') or die(mysql_error());
			$sqlServicio = mysql_query("SELECT * FROM sscc WHERE id < 50 ") or die("ERROR AL SELECCIONAR SERVICIO ".mysql_error());
			while($arrayServicios = mysql_fetch_array($sqlServicio)){
				$id_servicio = $arrayServicios['id_rau'];
				$nom_servicio = $arrayServicios['servicio'];
				
				?>
                <option value="<? echo $id_servicio; ?>" <? if($servicio==$id_servicio){?> selected="selected" <? } ?>><? echo $nom_servicio; ?></option>
            <? }?>
            </select>
            </td>
          </tr>
         
        </table>
        </fieldset>
         <fieldset><legend class="titulos_menu">Operaciones</legend>
       	<table class="titulocampo" align="right">
            <tr>
            	                
                <td>
                    <input type="button" name="aceptar" id="aceptar" value="   Aceptar   " <? if($idrau == ''){ ?>  disabled="disabled" <? } ?> onclick="document.urgencia.action='alta_ginecologica.php'; document.urgencia.submit();" />
					
                </td>
                
          </tr>
          
        </table>
        </fieldset>
        </td>   
    </tr>
            </table>
   	</td>
</tr>
</table>
