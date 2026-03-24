<?php 
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header
include "../gestion/funciones/funciones.php";

if (!isset($_SESSION)) {
	session_start();
}
$permisos = $_SESSION['permiso'];

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$servicio_activo = $_REQUEST['servicio_activo'];
$desde = $_REQUEST['desde'];
$GC2 = $_REQUEST['GC2'];

$fecha_hoy = date('Y-m-d');
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

//VERIFICA SI EXISTE UN ID_TURNO

$sqlVerifica = "SELECT id_turno,
				a_medico_turno,
				de_medico_turno,
				desde_hora_turno,
				hasta_hora_turno,
				detalle_turno,
				ingresos_turno,
				egresos_turno
				FROM entrega_turno
				WHERE 
				fecha_turno = '$fecha_hoy' AND
				servicio_turno = $servicio_activo";
$queryVerifica = mysql_query($sqlVerifica) or die ($sqlVerifica." Error al seleccionar datos del turno ".mysql_error());

$arrayVerifica = mysql_fetch_array($queryVerifica);
$idTurno = $arrayVerifica['id_turno'];
$a_medico = $arrayVerifica['a_medico_turno'];
$de_medico = $arrayVerifica['de_medico_turno'];
$desde_hora = explode(':',$arrayVerifica['desde_hora_turno']);
$hasta_hora = explode(':',$arrayVerifica['hasta_hora_turno']);
$det_turno = $arrayVerifica['detalle_turno'];
$in_turno = $arrayVerifica['ingresos_turno'];
$out_turno = $arrayVerifica['egresos_turno'];


//MEDICOS
/*
$sqlMedicos = "SELECT
				medicos.medico,
				medicos.id
				FROM medicos
				WHERE
				medicos.id <> 172
				AND
				upc_turno = 'S'
				ORDER BY
				medicos.medico ASC ";
*/
               // echo $servicio_activo;
$sqlMedicos="SELECT
                parametros_clinicos.profesional.PROid_medico_camas as id,
                parametros_clinicos.profesional.PROdescripcion as medico
                FROM
                camas.sscc
                INNER JOIN acceso.usuario_has_servicio ON camas.sscc.id_rau = acceso.usuario_has_servicio.idservicio
                INNER JOIN acceso.usuario ON acceso.usuario_has_servicio.idusuario = acceso.usuario.idusuario
                INNER JOIN parametros_clinicos.profesional ON acceso.usuario.rutusuario = parametros_clinicos.profesional.PROcodigo
                WHERE
                camas.sscc.id = '$servicio_activo' and parametros_clinicos.profesional.PROid_medico_camas <> ''
                and acceso.usuario_has_servicio.entregaturno='S'
                ";
$queryMedicos = mysql_query($sqlMedicos) or die ($sqlMedicos." Error al seleccionar medicos ".mysql_error());

//SERVICIOS
$sqlServicio = mysql_query("SELECT
				sscc.servicio
				FROM
				sscc
				WHERE
				sscc.id = $servicio_activo") or die("Error al seleccionar servicios ".mysql_error());
$arrayServicio = mysql_fetch_array($sqlServicio);
$nomServ = $arrayServicio['servicio'];				

//MUESTRA LOS PACIENTES QUE SE ENCUENTRAN EN CAMAS
$sqlPacientes = "SELECT
				camas.camas.cod_servicio,
				camas.camas.servicio,
				camas.camas.cod_procedencia,
				camas.camas.procedencia,
				camas.camas.cta_cte,
				camas.camas.id_paciente,
				camas.camas.nom_paciente,
				camas.camas.sala,
				camas.camas.cama,
				camas.camas.cta_cte,
				paciente.paciente.nroficha,
				paciente.paciente.sexo,
				paciente.paciente.fechanac,
				paciente.paciente.rut,
				camas.camas.prevision,
				SUBSTRING(camas.camas.hospitalizado,1,10) as fecha_hosp,
				camas.camas.fecha_ingreso
				FROM
				camas.camas
				left JOIN paciente.paciente ON camas.camas.id_paciente = paciente.paciente.id
				WHERE
				camas.camas.cod_servicio = $servicio_activo AND
				camas.camas.id_paciente <> 0
				ORDER BY
				camas.camas.cama ASC";
				
$queryPacientes = mysql_query($sqlPacientes) or die ($sqlPacientes." Error al seleccionar pacientes ".mysql_error());

$dia_menos = date('Y-m-d', strtotime('-1 day'));

//CALCULA LA CANTIDAD DE INGRESOS
$sqlIngresos = "SELECT
				Count(camas.id_paciente) as ingresos
				FROM
				camas
				WHERE
				camas.fecha_ingreso BETWEEN '$dia_menos' AND '$fecha_hoy'
				AND camas.cod_servicio = $servicio_activo";
$queryIngresos = mysql_query($sqlIngresos) or die($sqlIngresos." Error al seleccionar ingresos ".mysql_error());
$arrayIngresos = mysql_fetch_array($queryIngresos);
$totalIn = $arrayIngresos['ingresos'];

//CALCULA LA CANTIDAD DE EGRESOS
$sqlEgresos = "SELECT
				Count(hospitalizaciones.id_paciente) AS egresos
				FROM
				hospitalizaciones
				WHERE
				hospitalizaciones.tipo_traslado > 100 AND
				hospitalizaciones.fecha_egreso BETWEEN '$dia_menos' AND '$fecha_hoy' AND
				hospitalizaciones.cod_servicio = $servicio_activo";
$queryEgresos = mysql_query($sqlEgresos) or die($sqlEgresos." Error al seleccionar egresos ".mysql_error());
$arrayEgresos = mysql_fetch_array($queryEgresos);
$totalEg = $arrayEgresos['egresos'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pensionado Hospital Dr. Juan No� C.</title>

<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css"/>
<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="../../estandar/css/estiloBoton.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo_propio.css"/>
<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>

<script type="text/JavaScript">
	
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
	}
	//
	</script>
  	
</head>
<body>
<form name="entrega_turno" method="post" >
<input type="hidden" name="servicio_activo" id="servicio_activo" value="<?= $servicio_activo; ?>" />
<table width="950" align="center" border="0" background="../../estandar/img/fondo.jpg">
    <tr>
        <td >
        	<table width="949">
            	
            	<tr valign="bottom">
                	<td width="95"><img src="../../estandar/iconos/logo-hjnc.png" width="90" height="86" /></td>
                    <td width="59" class="tituloGrande" >&nbsp;<? echo $nomServ; ?><input type="hidden" name="nomServicio" id="nomServicio" value="<? echo $nomServ; ?>" /></td>
                    <td width="671">
                    	<table width="774" class="textoNormal">
                        	<tr>
                                <td colspan="5" align="right"><input type="text" id="fechabusca" name="fechabusca" size="8px" value="<? echo date('d-m-Y', strtotime('-1 day'));?>" readonly="readonly"  /><input type="Button" id="f_btn0" value="&nbsp;" class="botonimagen"/> <input type="button" class="botonBusca" name="busca" id="busca" value="&nbsp;" onclick="document.entrega_turno.action='pro1_entrega_turno.php?buscaPDF=1&servicio_activo=<?= $servicio_activo; ?>';document.entrega_turno.submit();" /></td>
                                
                            </tr>
                            <tr>
                            	<td width="103">Entrega:</td>
                                <td width="220">
                                <select name="medico1" id="medico1">
                                <? while($arrayMedico = mysql_fetch_array($queryMedicos)) {
										$idmedico = $arrayMedico['id'];
										$nommedico = $arrayMedico['medico'];
								?>
                                	<option value="<? echo $idmedico; ?>" <? if($de_medico == $idmedico){ ?> selected="selected" <? } ?>><? echo $nommedico; ?></option>                                <? } ?>
                                </select>
                                </td>
                                <td width="27" rowspan="2" align="center">a</td>
                                <td colspan="2">
                                <?
                                mysql_data_seek($queryMedicos, 0); ?>
								<select name="medico2" id="medico2">
                                <? while($arrayMedico = mysql_fetch_array($queryMedicos)) {
										$idmedico2 = $arrayMedico['id'];
										$nommedico2 = $arrayMedico['medico'];
								?>
                                	<option value="<? echo $idmedico2; ?>" <? if($a_medico == $idmedico2){ ?> selected="selected" <? } ?>><? echo $nommedico2; ?></option>                                <? } ?>
                                </select>
								</td>
                            </tr>
                            <tr>
                            	<td>Turno de:</td>
                                <td><input type="text" id="fechade" name="fechade" size="8px" value="<? echo date('d-m-Y', strtotime('-1 day'));?>" readonly="readonly"  /><input type="Button" id="f_btn1" value="&nbsp;" class="botonimagen"/>  <input type="text" id="horade" name="horade" value="<? if($desde_hora[0] != ''){ echo $desde_hora[0]; }else{ echo '08'; }?>" style="width:25px"  />:<input type="text" id="minde" name="minde" value="<? if($desde_hora[1] != ''){ echo $desde_hora[1]; }else{ echo '00'; }?>" style="width:25px"  /></td>
                                <td width="193"><input type="text" id="fechahasta" name="fechahasta" size="8px" value="<? echo date('d-m-Y');?>" readonly="readonly" /><input type="Button" id="f_btn2" value="&nbsp;" class="botonimagen"/>  <input type="text" id="horahasta" name="horahasta" value="<? if($hasta_hora[0] != ''){ echo $hasta_hora[0]; }else{ echo '08'; }?>" style="width:25px"  />:<input type="text" id="minhasta" name="minhasta" value="<? if($hasta_hora[1] != ''){ echo $hasta_hora[1]; }else{ echo '00'; }?>" style="width:25px"  /></td>
                                <td width="207">24 horas</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr valign="bottom">
                    <td class="titulos"><? echo date('d-m-Y'); ?></td>
                    <td class="titulos"><? echo date('H:i:s'); ?></td>
                    <td>
                    	<table class="textoNormal">
                        	<tr>
                            	<td>Ingresos:</td>
                                <td><input type="text" size="1px" name="totIngresos" id="totIngresos" value="<? if($in_turno){ echo $in_turno; }else{ echo $totalIn; } ?>" /></td>
                                
                            </tr>
                            <tr>
                            	<td>Egresos:</td>
                                <td><input type="text" size="1px" name="totEgresos" id="totEgresos" value="<? if($out_turno){ echo $out_turno; }else{ echo $totalEg; } ?>" /></td>
                                
                            </tr>
                        </table>
                    </td>
                    
                </tr>
            </table>
      </td>
    </tr>
    
    <tr>
    	<td>
        	<table class="textoNormal" border="1" cellpadding="5" cellspacing="5">
            	<tr class="tabla_tr">
                    <td >#
                    </td>
                    <td >Nombre Paciente
                    </td>
                    <td >Antropometr&iacute;a
                    </td>
                    <td >Diagnosticos
                    </td>
                    <td >Bacteriolog&iacute;a
                    </td>
                    <td >Planes y problemas
                    </td>
                </tr>           
                <? 
				$a = 0;
				while($arrayPaciente = mysql_fetch_array($queryPacientes)) {
					
					$id_pac = $arrayPaciente['id_paciente'];
					$rut_pac = $arrayPaciente['rut'];
					
					$digito = ValidaDVRut($arrayPaciente['rut']);
					$nac_pac = cambiarFormatoFecha($arrayPaciente['fechanac']);
					$ficha_pac = $arrayPaciente['nroficha'];
					$prev_pac = $arrayPaciente['prevision'];
					$proc_pac = $arrayPaciente['procedencia'];
					$hosp_pac = cambiarFormatoFecha($arrayPaciente['fecha_hosp']);
					$ingreso = $arrayPaciente['fecha_ingreso'];
					$ing_pac = cambiarFormatoFecha($arrayPaciente['fecha_ingreso']);
					$edad_pac = Edad($arrayPaciente['fechanac']);
					$sexo_pac = $arrayPaciente['sexo'];
					$cta_pac = $arrayPaciente['cta_cte'];
					$cod_proc_pac = $arrayPaciente['cod_procedencia'];
					$diferencia_dia = diff_dte($fecha_hoy, $ingreso);
										
					//if($idTurno > 0){
						
						$sqlTurnoPacientes = "SELECT * 
											FROM turno_has_paciente
											WHERE pac_turnopac = $id_pac
											ORDER BY id_turnopac DESC
											LIMIT 0,1 ";
											
						$queryTurnoPaciente = mysql_query($sqlTurnoPacientes) or die($sqlTurnoPacientes."<br/> Error al seleccionar detalle del turno <br/>".mysql_error());
						$arrayTurnoPaciente = mysql_fetch_array($queryTurnoPaciente);
						
							$talla_pac = $arrayTurnoPaciente['talla_turnopac'];
							$peso_pac = $arrayTurnoPaciente['peso_turnopac'];
							$pcp_pac = $arrayTurnoPaciente['pcp_turnopac'];
							$sc_pac = $arrayTurnoPaciente['sc_turnopac'];
							$imc_pac = $arrayTurnoPaciente['imc_turnopac'];
							$diagn_pac = $arrayTurnoPaciente['diagn_turnopac'];
							$bact_pac = $arrayTurnoPaciente['bact_turnopac'];
							$planes_pac = $arrayTurnoPaciente['planes_turnopac'];
							$evento_pac = cambiarFormatoFecha($arrayTurnoPaciente['evento_turnopac']);
							$hosp2_pac = cambiarFormatoFecha($arrayTurnoPaciente['hosp_turnopac']);
							$ing2_pac = cambiarFormatoFecha($arrayTurnoPaciente['ing_turnopac']);
						
						//}
					?>
					
					
                <input type="hidden" name="id_pac[<?= $a; ?>]" id="id_pac[<?= $a; ?>]" value="<? echo $id_pac; ?>" />
                <input type="hidden" name="cta_pac[<?= $a; ?>]" id="cta_pac[<?= $a; ?>]" value="<? echo $cta_pac; ?>" />
                <input type="hidden" name="edad_pac[<?= $a; ?>]" id="edad_pac[<?= $a; ?>]" value="<? echo $edad_pac; ?>" />
                <input type="hidden" name="prev_pac[<?= $a; ?>]" id="prev_pac[<?= $a; ?>]" value="<? echo $prev_pac; ?>" />
                <input type="hidden" name="edad_pac[<?= $a; ?>]" id="edad_pac[<?= $a; ?>]" value="<? echo $edad_pac; ?>" />
                <input type="hidden" name="cod_proc_pac[<?= $a; ?>]" id="cod_proc_pac[<?= $a; ?>]" value="<? echo $cod_proc_pac; ?>" />
                
                <tr>
                    <td><? echo $arrayPaciente['cama']; ?></td>
                    <td valign="top" class="td_estilosa" >
                   	  <table class="textoNormal" width="180" cellspacing="1" cellpadding="2" >
                        	<tr class="tabla_tr">
                            	<td colspan="2" style="font-size:12px" ><? echo ucwords(strtolower($arrayPaciente['nom_paciente']));?>&nbsp;
                                </td>
                            	
                            </tr>
                            <tr>
                            	<td width="60" align="right">Rut: 
                                </td>
                            	<td width="100"><? echo $rut_pac."-".$digito;?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td width="60" align="right">Cta Cte: 
                                </td>
                            	<td width="100"><? echo $cta_pac;?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td align="right">Nac: 
                                </td>
                            	<td><? echo $nac_pac; ?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td align="right">Ficha: 
                                </td>
                            	<td><? echo $ficha_pac; ?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td align="right">Previs: 
                                </td>
                            	<td><? echo $prev_pac; ?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td align="right">Viene de: 
                                </td>
                            	<td><? echo $proc_pac; ?>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td align="right">Evento: 
                                </td>
                            	<td><input type="text" name="evento[<?= $a; ?>]" id="evento[<?= $a; ?>]" size="7" value="<? if($evento_pac){ echo $evento_pac; }else{ echo $hosp_pac; } ?>" readonly="readonly" /><input type="Button" name="f_btn3" id="f_btn3[<?= $a; ?>]" value="&nbsp;" class="botonimagen" /></td>
                            </tr>
                            <tr>
                            	<td align="right">Hospit:
                                </td>
                            	<td><input type="text" name="hospitaliza[<?= $a; ?>]" id="hospitaliza[<?= $a; ?>]" size="7" value="<? if($hosp2_pac){ echo $hosp2_pac; }else{ echo $hosp_pac; } ?>" readonly="readonly" /><input type="Button" name="f_btn4" id="f_btn4[<?= $a; ?>]" value="&nbsp;" class="botonimagen"/></td>
                            </tr>
                            <tr>
                            	<td align="right">Ing Ud:
                                </td>
                            	<td><input type="text" name="ingreso[<?= $a; ?>]" id="ingreso[<?= $a; ?>]" size="7" value="<? if($ing2_pac){ echo $ing2_pac; }else{ echo $ing_pac; } ?>" readonly="readonly"  /><input type="Button" name="f_btn5" id="f_btn5[<?= $a; ?>]" value="&nbsp;" class="botonimagen" /></td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top" class="td_estilosa" >
                    	<table class="textoNormal">
                        	<tr class="tabla_tr">
                            	<td width="45" align="right">Sexo:</td>
                            	<td width="67"><input type="hidden" value="<?= $sexo_pac; ?>" name="sexo[<?= $a; ?>]" id="sexo[<?= $a; ?>]" /><? echo $sexo_pac; ?>&nbsp;</td>
                            	
                            </tr>
                            <tr>
                            	<td align="right">Edad</td>
                            	<td ><? echo $edad_pac; ?> a&ntilde;os</td>
                            </tr>
                            <tr>
                            
                            	<td align="right">Talla:</td>
                            	<td><input type="text" name="talla[<?= $a; ?>]" id="talla[<?= $a; ?>]" size="5" onkeypress="return soloNumeros(event)" onblur="calcula(document.getElementById('peso[<?= $a;?>]').value,document.getElementById('talla[<?= $a;?>]').value, document.getElementById('imc[<?= $a;?>]'));calculaSC(document.getElementById('peso[<?= $a;?>]').value,document.getElementById('talla[<?= $a;?>]').value, document.getElementById('sc[<?= $a;?>]'));calculaPE(document.getElementById('talla[<?= $a;?>]').value, document.getElementById('sexo[<?= $a;?>]').value, document.getElementById('pcp[<?= $a;?>]'));" value="<? echo $talla_pac; ?>" />cm</td>
                            	
                            </tr>
                            <tr>
                            	<td align="right">Peso:</td>
                            	<td><input type="text" name="peso[<?= $a; ?>]" id="peso[<?= $a; ?>]" size="5" onblur="calcula(document.getElementById('peso[<?= $a;?>]').value,document.getElementById('talla[<?= $a;?>]').value, document.getElementById('imc[<?= $a;?>]'));calculaSC(document.getElementById('peso[<?= $a;?>]').value,document.getElementById('talla[<?= $a;?>]').value, document.getElementById('sc[<?= $a;?>]'));" value="<? echo $peso_pac; ?>" />kg</td>
                            	
                            </tr>
                            <tr>
                            	<td align="right">PCP:</td>
                            	<td><input type="text" name="pcp[<?= $a; ?>]" id="pcp[<?= $a; ?>]" size="5" onKeyPress="return soloDecimales(event)" onclick="calculaPE(document.getElementById('talla[<?= $a;?>]').value, document.getElementById('sexo[<?= $a;?>]').value, document.getElementById('pcp[<?= $a;?>]'));" value="<? echo $pcp_pac; ?>" />kg</td>
                            	
                            </tr>
                            <tr>
                            	<td align="right">SC:</td>
                            	<td><input type="text" name="sc[<?= $a; ?>]" id="sc[<?= $a; ?>]" size="5" onKeyPress="return soloDecimales(event)" onclick="calculaSC(document.getElementById('peso[<?= $a;?>]').value,document.getElementById('talla[<?= $a;?>]').value, document.getElementById('sc[<?= $a;?>]'));" value="<? echo $sc_pac; ?>" />m&sup2;</td>
                            	
                            </tr>
                            <tr>
                            	<td align="right">IMC:</td>
                            	<td><input type="text" name="imc[<?= $a; ?>]" id="imc[<?= $a; ?>]" size="5" onKeyPress="return soloDecimales(event)" readonly="readonly" value="<? echo $imc_pac; ?>"/>
                            	kg/m&sup2;</td>
                            	
                            </tr>
                            <tr>
                            	<td colspan="3">&nbsp;</td>
                            	
                            </tr>
                            <tr>
                            	<input type="hidden" name="hoy[<?= $a; ?>]" id="hoy[<?= $a; ?>]" value="<? echo date('d-m-Y')?>" />
                            	<td colspan="3"><input readonly="readonly" type="text" name="diauci[<?= $a; ?>]" id="diauci[<?= $a; ?>]" size="1" onclick="DiferenciaFechas(document.getElementById('hoy[<?= $a;?>]').value, document.getElementById('ingreso[<?= $a;?>]').value, document.getElementById('diauci[<?= $a;?>]'));" value="<? echo $diferencia_dia; ?>" /> 
                            	dias de <? echo $nomServ; ?></td>
                            	
                            </tr>
                        </table>
                    </td>
                    <td valign="top" class="td_estilosa" ><textarea name="diangs[<?= $a; ?>]" id="diangs[<?= $a; ?>]" cols="15" rows="10"><? echo $diagn_pac; ?></textarea>
                    </td>
                    <td valign="top" class="td_estilosa"  ><textarea name="bact[<?= $a; ?>]" id="bact[<?= $a; ?>]" cols="6" rows="10"><? echo $bact_pac; ?></textarea>
                    </td>
                    <td valign="top" class="td_estilosa" ><textarea name="planes[<?= $a; ?>]" id="planes[<?= $a; ?>]" cols="25" rows="10"><? echo $planes_pac; ?></textarea>
                    </td> 
              </tr>
                <? 
				$a++;
				} ?>
            </table>
        </td>
    </tr>
    <tr>
    	<td>
        	<table width="100%" border="1" cellpadding="5" cellspacing="5" class="textoNormal">
            	<tr>
                	<td align="center">*</td>
                    <td ><textarea name="detalle_turno" cols="100" rows="3"><? echo $det_turno; ?></textarea></td>
                </tr>
            </table>
      </td>
    </tr>
    <tr>
    	<td align="center">
    		<?php if ( array_search(425, $permisos) != null ) { ?>
    		<input type="button" class="boton" name="guardar" id="guardar" value="Guardar" onclick="document.entrega_turno.guardar.disabled=true; document.entrega_turno.action='pro1_entrega_turno.php';document.entrega_turno.submit();" />
    		<?php } ?>
        </td>
    </tr>
</table>
</form>
</body>

<script type="text/javascript">
//<![CDATA[
        
          var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("f_btn0", "fechabusca", "%d-%m-%Y");
		  cal.manageFields("f_btn1", "fechade", "%d-%m-%Y");
		  cal.manageFields("f_btn2", "fechahasta", "%d-%m-%Y");
		  
		  <? for($i=0;$i<=$a;$i++){  ?>
		  
		  cal.manageFields("f_btn3[<?= $i; ?>]", "evento[<?= $i; ?>]", "%d-%m-%Y");
		  cal.manageFields("f_btn4[<?= $i; ?>]", "hospitaliza[<?= $i; ?>]", "%d-%m-%Y");
		  cal.manageFields("f_btn5[<?= $i; ?>]", "ingreso[<?= $i; ?>]", "%d-%m-%Y");
		<?	

		} ?>
        //]]>
</script>
</html>