<td>
    <fieldset><legend>Camas SN</legend>
    <table>
    <tr>
    <? 							
		$cont = 1;
		
		mysql_data_seek($queryMuestraSN, 0);
		while($arrayCamas = mysql_fetch_array($queryMuestraSN)){
			$codCama = $arrayCamas['codCamaSN'];
			$idSN = $arrayCamas['idListaSN'];
			$idPAc = $arrayCamas['idPacienteSN'];
			$catRiesgo = $arrayCamas['categorizaRiesgoSN'];
			$catDep = $arrayCamas['categorizaDepSN'];
			$categorizacion = $catRiesgo.$catDep;
			$nombreMedico = $arrayCamas['nomMedicoSN'];
			$que_servicio = $arrayCamas['desde_nomServSN'];
			
			
			$ingreso = $arrayCamas['fechaIngresoSN'].' '.$arrayCamas['horaIngresoSN'];
			$ingreso_hosp = $arrayCamas['hospitalizadoSN'];
			$egreso = date("Y-m-d").' '.date("H:i:s");
			$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
			
			$dias_espera = ($tiempo_espera / 24);
			$decimales = explode(".",$dias_espera);
			$dias_espera = $decimales[0];
			$horas_espera = ($tiempo_espera - ($dias_espera*24));
			
			$tiempo_espera_hosp = intval((strtotime($egreso)-strtotime($ingreso_hosp))/3600);
	
			$dias_espera_hosp = ($tiempo_espera_hosp / 24);
			$decimales = explode(".",$dias_espera_hosp);
			$dias_espera_hosp = $decimales[0];
			$horas_espera_hosp = ($tiempo_espera_hosp - ($dias_espera_hosp*24));
			
			//SE DEFINE QUE ENLACE E IMAGEN MOSTRAR EN LA CAMA
			if($arrayCamas['idListaSN']){
				if($arrayCamas['estadoctacteSN'] == 4){
					$class = " class ='td_sscc_dealta' ";
					}else{
						$class = " class='td_sscc'";
						}
				//llamar funcion que calcule el tiempo
				$time = 0;
				//SE LLENA EL ARRAY CON LOS DATOS DE PACIENTES EN HINTS 
				$inf_paciente = "<b>- Paciente</b> : ".$arrayCamas['nomPacienteSN']."<br /> <b>- Ingreso Hospital</b> &nbsp;&nbsp;: ".cambiarFormatoFecha2(substr($ingreso_hosp,0,10))." - ".substr($ingreso_hosp,11,5)." Hrs. <br /> <b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /> <b>- Ingreso Servicio</b> &nbsp;&nbsp; : ".cambiarFormatoFecha2($arrayCamas['fechaIngresoSN'])." - ".substr($arrayCamas['horaIngresoSN'],0,5)." Hrs. <br /> <b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$nombreMedico."<br /> <b>- Categorizacion</b> : ".$categorizacion." <br /> <b>- Servicio</b> : ".$que_servicio;
				
				
							
				switch($catRiesgo){
					
					case 'A';
					$bgImagen = "cama-a";
					break;
					
					case 'B';
					$bgImagen = "cama-b";
					break;
					
					case 'C';
					$bgImagen = "cama-c";
					break;
					
					case 'D';
					$bgImagen = "cama-d";
					break;
					
					case '';
					$bgImagen = "cama-sc";
					break;
					}
				
				if($arrayCamas['sexoPacienteSN'] == 'M'){
					$imgSex = "-h";
				}else{
					$imgSex = "-m";
					}
				if($arrayCamas['esta_fichaSN'] == 1){
					$imgFicha = "-f";
					}else{
						$imgFicha = "";
						}
				if($arrayCamas['multiresSN'] == 1){
					$class = " class='td_sscc_multires'";
					}
			$imagenFinal = $bgImagen.$imgSex.$imgFicha;									
			$enlace = "href='../superNumeraria/detalleCamaSN.php?HOSid=$idSN&PACid=$idPAc&desde=sscc'";
			}
			//FIN DEFINICION
			if($cont < 3){
				if($cont == 1){?>
					<td valign="top">
					<table>
				<? }?>
				<tr >
					<td height="70" width="60" align="center" <?= $class;?>  style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/<?= $imagenFinal; ?>.gif" width="52" height="51" onmouseover="" onmouseout ="" /><br>Cama <? echo $arrayCamas['nomCamaSN']; ?></a></td>
				</tr>
			<? 
			$cont++; 
			}else{?>
				<tr >
					<td height="70" width="60" align="center" <?= $class;?> style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/<?= $imagenFinal; ?>.gif" width="52" height="51" onmouseover="" onmouseout ="" /><br>Cama <? echo $arrayCamas['nomCamaSN']; ?></a></td>
				</tr>
				</table>
				</td>
			<? $cont = 1;
			}
		//CREA ARREGLO CON LAS VARIABLES DE LOS HINTS
		$inf_paciente = str_replace("\"", " ", $inf_paciente);
		$inf_paciente = str_replace("'", " ", $inf_paciente);

		$arreglo_camas[$i_mens_todos] = $inf_paciente;
		$i_mens_todos++;
		
		
		
	   }//FIN WHILE
	   if($cont==3) {echo "</table></td>";}
	   if($cont==2) echo "<tr><td>&nbsp;</td></tr></table></td>";
	   ?>
		</tr>
	</table>
	</fieldset>
	<!--FIN TABLA QUE REPRESENTAN LAS SALAS-->
	</td>
	
    </tr>
    </table>
    </fieldset>
    </td>