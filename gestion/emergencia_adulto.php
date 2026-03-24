<table cellpadding="0" cellspacing="0">
<tr valign="top">
  	<td>
    <table cellpadding="0" cellspacing="0">
            	<tr valign="top">
                	<td valign="top">
                    <fieldset>
                      <legend class="titulos_menu"> Pacientes en Espera</legend>
                      <div align="center" style="width:230px;height:330px;overflow:auto ">
               	    <table width="203" id="tabla" >
                    	<tr valign="top" bgcolor="#66B3FF">
                          <td width="36" >N° RAU</td>
                          <td width="128" >Paciente</td>
                          <td width="23">Cat.</td>
                          <td width="40">Espera.</td>
                        </tr>
                        <?
						$cat_c1 = 0;
						$cat_c2 = 0;
						$cat_c3 = 0;
						$cat_c4 = 0;
						$cat_c5 = 0;
						$cat_si = 0;
						$cat_nc = 0;
						$total_cat_1 = 0;
						$total_cat_2 = 0;
						
						 while($arrayEspera = mysql_fetch_array($sqlEspera)){
								$idRauLista = $arrayEspera['id_EspRau'];
								$nomPacienteLista = $arrayEspera['paciente_EspRau'];
								$catPacienteLista = $arrayEspera['cat_EspRau'];
								
								
								$ingreso = $arrayEspera['fechaCat_EspRau'].' '.$arrayEspera['horaCat_EspRau'];
								$egreso = date("Y-m-d").' '.date("H:m:s");
								
								if ($catPacienteLista <> 'N/C')
								{
								//TIEMPO CATEGORIZACION
								    $tiempo_espera_categ = hacecuanto($ingreso, $egreso);
								}else
								{
									$tiempo_espera_categ = "";
								}
								
								
								
								switch($catPacienteLista){
									case('C1'):
										$cat_c1++;
									break;
									case('C2'):
										$cat_c2++;
									break;
									case('C3'):
										$cat_c3++;
									break;
									case('C4'):
										$cat_c4++;
									break;
									case('C5'):
										$cat_c5++;
									break;
									case('S/I'):
										$cat_si++;
									break;
									case('N/C'):
										$cat_nc++;
									break;
								}
								$total_cat_1 = $cat_c1+$cat_c2+$cat_c3+$cat_c4+$cat_c5+$cat_si;
								$total_cat_2 = $cat_c1+$cat_c2+$cat_c3+$cat_c4+$cat_c5+$cat_si+$cat_nc;	
						?>
                        <tr bgcolor="#BFEBFF">
                        	<td><? echo $idRauLista; ?></td>
                            <td><? echo $nomPacienteLista; ?></td>
                            <td><? echo $catPacienteLista; ?></td>
                            <td><? echo $tiempo_espera_categ; ?></td>
                        </tr>
						<? } ?>
                      </table> 
                      </div>
                     <table width="100%"  id="tabla">
                     	
                     	<tr align="center" bgcolor="#66B3FF">
                        	<td width="34%">C1 : <? echo $cat_c1; ?></td>
                        	<td width="32%">C2 : <? echo $cat_c2; ?></td>
                        	<td width="34%">C3 : <? echo $cat_c3; ?></td>
                        </tr>
                        <tr align="center" bgcolor="#66B3FF">
                        	<td>C4 : <? echo $cat_c4; ?></td>
                        	<td>C5 : <? echo $cat_c5; ?></td>
                            <td>S/I : <? echo $cat_si; ?></td>
                        	
                        </tr>
                        <tr align="center" bgcolor="#66B3FF">
                        	<td>Cat: <? echo $total_cat_1; ?></td>
                        	<td>N/C : <? echo $cat_nc; ?></td>
                            <td>Total : <? echo $total_cat_2; ?></td>
                        	
                        </tr>
                     </table>
                    </fieldset>
                    </td>
                </tr>
        </table>
       
       
        </td>
        <td width="589" valign="top">
        <div align="center" style="width:750px;overflow:auto ">
        <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        	<tr valign="top">
            	<td valign="top">
                	<!--COLUMNA DE LA TABLA DATOS PACIENTE-->
                	<fieldset>
                    <legend class="titulos_menu">Salas Unidad de Emergencia</legend>
                    <table width="50%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr valign="top">
                            <? 
							$i_detalleCama = 0;
							while($arraySalas = mysql_fetch_array($sqlSala)){
								$codSala = $arraySalas['sala'];
								
								?>
                            <td>
                            <!--TABLA QUE REPRESENTAN LAS SALAS-->
                            <fieldset>
                            <legend class="titulos_sesion"><? echo $codSala; ?></legend>
                            <table align="center">
                            	<tr valign="top" >
                            	<? $sqlCamas ="SELECT *
												FROM
												camas_urgencia
												WHERE
												camas_urgencia.sala = '$codSala'
												ORDER BY cama ASC"; 
																			
								$queryCamas = mysql_query($sqlCamas) or die("ERROR AL SELECCIONAR CAMAS ". mysql_error());
								$cont = 1;
								while($arrayCamas = mysql_fetch_array($queryCamas)){
									
									$nomPaciente = $arrayCamas['nom_paciente'];
									$categorizacion = $arrayCamas['categorizacion'];
									$fecha_cat = cambiarFormatoFecha($arrayCamas['fecha_categ']);
									$hora_cat = $arrayCamas['hora_categ'];
									$descripcion = $arrayCamas['descConsulta'];
									$nomCama = $arrayCamas['cama'];
									$sexoPac = $arrayCamas['sexo_paciente'];
									$estado = $arrayCamas['estado'];
									$id_rau = $arrayCamas['id_rau'];
									$id_cama = $arrayCamas['id_camaUrg'];
									$tipo_indicacion = $arrayCamas['estado'];
									$id_servicio = $arrayCamas['id_servicio'];
									
									
									$fecha_ingreso = cambiarFormatoFecha($arrayCamas['fecha_ingreso']);
									$hora_ingreso = $arrayCamas['hora_ingreso'];
									$hora_indicacion = $arrayCamas['hora_indicacion'];
									$fecha_indicacion = cambiarFormatoFecha($arrayCamas['fecha_indicacion']);
									
									// TIEMPOS
									$ingreso = $arrayCamas['fecha_ingreso'].' '.$arrayCamas['hora_ingreso'];
									$indicacion = $arrayCamas['fecha_indicacion'].' '.$arrayCamas['hora_indicacion'];
									$ingreso_hosp = $arrayCamas['fecha_rau'].' '.$arrayCamas['hora_rau'];
									$egreso = date("Y-m-d").' '.date("H:m:s");
									
									//TIEMPO INDICACION
									$tiempo_espera_ind = intval((strtotime($egreso)-strtotime($indicacion))/3600);
									
									$dias_espera_ind = ($tiempo_espera_ind / 24);
									$decimales_ind = explode(".",$dias_espera_ind);
									$dias_espera_ind = $decimales_ind[0];
									$horas_espera_ind = ($tiempo_espera_ind - ($dias_espera_ind*24));
									$total_horas_ind = (($dias_espera_ind*24)+($horas_espera_ind));
									
									//TIEMPO DE ESPERA 
									$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
									
									$dias_espera = ($tiempo_espera / 24);
									$decimales = explode(".",$dias_espera);
									$dias_espera = $decimales[0];
									$horas_espera = ($tiempo_espera - ($dias_espera*24));
									$total_horas = (($dias_espera*24)+($horas_espera));
									$minutos_espera = ($tiempo_espera - ($dias_espera*24));
									$total_horas = (($dias_espera*24)+($horas_espera));
																							
									
									if($id_rau){
									//SE LLENA EL ARRAY CON LOS DATOS DE PACIENTES EN HINTS 
									
										//CAMBIA ICONO DEL PACIENTE SEGUN SU SEXO
											if($sexoPac == 'F'){
											$imgCama = "cama-m";
											}
											else{
												$imgCama = "cama-h";
												}
											$enlace = "href='detalle_paciente.php?id_cama=$id_cama&idRau=$id_rau'";
										
											//CAMBIARA COLOR DE FONDO DEL ICONO SEGUN LA ESPERA DE LA INDICACION DEL PACIENTE
											$indImg = "";
											$masInfo = "";
											if(($estado > 1) and ($indicacion != "0000-00-00 00:00:00")){
												if($tipo_indicacion == 3){
													$nombre_indicacion = "Alta Hogar";
													
													}else if($tipo_indicacion ==4 ){
														$nombre_indicacion = "Hospitalizado";
														}else if($tipo_indicacion ==5 ){
															$nombre_indicacion = "Rechaza Hospitalizacion";
															}else if($tipo_indicacion ==6 ){
																$nombre_indicacion = "Defuncion";
																}
																
												//SELECCIONA LOS SERVICIOS PARA MOSTRAR LA INFO
												$nom_servicio = "";
												if($id_servicio != 0){
													
												mysql_select_db('camas') or die(mysql_error());
												$sqlServicio = mysql_query("SELECT * FROM sscc WHERE id_rau = $id_servicio ") or die($id_servicio." ERROR AL SELECCIONAR SERVICIO ".mysql_error());
												$arrayServicio = mysql_fetch_array($sqlServicio);
												$nom_servicio = $arrayServicio['servicio'];
												}
												mysql_select_db('rau') or die(mysql_error());
												$masInfo = "<b>- Indicacion Egreso</b> : ".$nombre_indicacion." ".$nom_servicio." ( ".$fecha_indicacion." - ".$hora_indicacion." ) <br/><b>- Tiempo Espera Ind </b> : ".$dias_espera_ind. " dias, ".$horas_espera_ind. " horas  <br/>";
												if(($total_horas_ind < 6)){
													$indImg = "-1"; //VERDE
													}else if(($total_horas_ind > 5) and ($total_horas_ind < 13)){
														$indImg = "-2";//AMARILLO
														}else if(($total_horas_ind > 12) and ($total_horas_ind < 25)){
															$indImg = "-3";// NARANJA
															}else if($total_horas_ind > 24){
															$indImg = "-4";// ROJO
															}
											}
									
									$infPaciente = "<b>- Paciente</b> : ".$nomPaciente."<br/><b>- Consulta : </b> ".$descripcion."<br/><b>- Categorizacion</b> : ".$categorizacion." ( ".$fecha_cat." - ".$hora_cat." )<br/><b>- Ingreso a Box</b> : ".$fecha_ingreso." - ".$hora_ingreso."<br/><b>- Tiempo Atencion</b> : ".$dias_espera." dias, ".$horas_espera." horas <br/>".$masInfo."<b>- N° Rau</b> : ".$id_rau."<br/>";	
									}else{
										$infPaciente = "<b>- Cama ".$nomCama." : </b> Vacia <br/>";
										$imgCama = "cama-vacia";
										
										$enlace = "";
										
										$indImg = "";
										}
										
									$imgFinal = $imgCama.$indImg;
									//FIN DEFINICION
									if($cont < 6){
										if($cont == 1){?>
                                            <td valign="top">
                                            <table width="42" cellpadding="0" cellspacing="0" >
                                    	<? }?>
                                        <tr >
                                            <td <? if($tipo_indicacion == 3) {?> bgcolor='#CCCCCC' <? } ?> height="55" align="center" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onMouseOut="myHint.hide()" <?=  $enlace;  ?> ><img style="border:none;" src="img/<?= $imgFinal; ?>.gif" width="35" height="35" onMouseOver="" onmouseout ="" /><br>C - <? echo $nomCama; ?> </a></td>
                                        </tr>
                                    <? 
									$cont++; 
									}else{?>
										<tr >
                                            <td <? if($tipo_indicacion == 3) {?> bgcolor='#CCCCCC' <? } ?> height="55" align="center" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onMouseOver="myHint.show(<? echo $i_detalleCama; ?>)" onMouseOut="myHint.hide()" <?= $enlace; ?> ><img style="border:none;" src="img/<?= $imgFinal; ?>.gif" width="35" height="35" onMouseOver="" onmouseout ="" /><br>C - <? echo $nomCama; ?></a></td>
                                        </tr>
                                        </table>
                                        </td>
									<? $cont = 1;
									}
								//CREA ARREGLO CON LAS VARIABLES DE LOS HINTS
							   	$infPaciente = str_replace("\"", " ", $infPaciente);
								$infPaciente = str_replace("'", " ", $infPaciente);
								$arreglo_camas[$i_detalleCama] = $infPaciente;
								$i_detalleCama++;
                               }//FIN WHILE
							   if($cont==6) echo "</table></td>";
							   if($cont==5) echo "<tr><td>&nbsp;</td></tr></table></td>";
							   if($cont==4) echo "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table></td>";
							   if($cont==3) echo "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table></td>";
							   if($cont==2) echo "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table></td>";
							   ?>
                                </tr>
                            </table>
                            </fieldset>
                            <!--FIN TABLA QUE REPRESENTAN LAS SALAS-->
                            </td>
                            <? }?>  
                        </tr>
                    </table>
                    </fieldset>
                    <!--FIN COLUMNA DE LA TABLA DATOS PACIENTE-->
                </td>
    </tr>
    </table>
    </div>
    </td>
</tr>
</table>
