<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
$id_cama=$_GET['id_cama'];
$tipo=$_GET['tipo'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<?

	include "../funciones/funciones.php";
	
	$fecha_hoy = date('d-m-Y');


	$fecha_categoriza = cambiarFormatoFecha($fecha_hoy);


	//$_SESSION['MM_pro_id_cama'] = $id_cama;
	
	mysql_connect ('10.6.21.29','usuario','hospital');
	
	
	//if($PEN){
//		mysql_select_db('pensionado') or die('Cannot select database');
//		$sql = "SELECT *
//				FROM
//				camas
//				INNER JOIN lista ON camas.idPensio = lista.idPensio
//				WHERE camas.idPensio = '".$id_cama."'";
//		
//		$query = mysql_query($sql) or die(mysql_error());
//		
//		$paciente = mysql_fetch_array($query);
//		
//		$sala = $paciente['salaPensio'];
//		$cama = $paciente['numPensio'];
//		$desc_servicio = "Pensionado";
//		$nom_paciente = $paciente['nombrePensio'];
//		$rut_paciente = $paciente['rutPensio'];
//		$ficha_paciente = $paciente['fichaPensio'];
//		$fono1 = $paciente['fono1Pensio'];
//		$fono2 = $paciente['fono2Pensio'];
//		$medico = $paciente['n_medicoPensio'];
//		$fecha_ingreso = cambiarFormatoFecha($paciente['fechaIngresoPensio']);
//		$id_paciente = $paciente['idPaciente'];
//		$diagnostico2 = $paciente['diagn2Pensio'];
//		$procedencia = "Admision";
//		$cod_auge = "";
//		$nom_auge = "";
//		$acc_transito = "";
//		$prevision = $paciente['n_previsionPensio'];
//		$categorizacion_riesgo = $paciente['cat_riesgoPensio'];
//		$categorizacion_dependencia = $paciente['cat_depPensio'];
//		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
//		$hospitalizado = substr($paciente['hospPensio'],0,10);
//		
//		}else 
		if($tipo=='cmi'){
		mysql_select_db('camas') or die('Cannot select database');
		$sql = "SELECT * FROM listasn 
				INNER JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN 
				WHERE idCamaSN = '".$id_cama."'";
		
		$query = mysql_query($sql) or die(mysql_error());
		
		$paciente = mysql_fetch_array($query);
		
		$sala = $paciente['salaCamaSN'];
		$cama = $paciente['nomCamaSN'];
		$desc_servicio = "Indiferenciadas";
		$nom_paciente = $paciente['nomPacienteSN'];
		$rut_paciente = $paciente['rutPacienteSN'];
		$ficha_paciente = $paciente['fichaPacienteSN'];
		$fono1 = $paciente['fono1SN'];
		$fono2 = $paciente['fono2SN'];
		$medico = $paciente['nomMedicoSN'];
		$fecha_ingreso = cambiarFormatoFecha($paciente['fechaIngresoSN']);
		$id_paciente = $paciente['idPacienteSN'];
		$diagnostico2 = $paciente['diagnostico1SN'];
		$procedencia = $paciente['nomProcedenciaSN'];
		$cod_auge = $paciente['codAugeSN'];
		$nom_auge = $paciente['nomAugeSN'];
		$acc_transito = $paciente['accTranSN'];
		$prevision = $paciente['nomPrevisionSN'];
		$categorizacion_riesgo = $paciente['categorizaRiesgoSN'];
		$categorizacion_dependencia = $paciente['categorizaDepSN'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$hospitalizado = substr($paciente['hospitalizadoSN'],0,10);
		$hospitalizadohora = substr($paciente['hospitalizadoSN'],11,19);
			
		}else{
		mysql_select_db('camas') or die('Cannot select database');
			$sql = "SELECT * FROM camas WHERE id = '".$id_cama."'";
			
			$query = mysql_query($sql) or die(mysql_error());
		
			$paciente = mysql_fetch_array($query);
			
			$cod_servicio = $paciente['cod_servicio'];
			$desc_servicio = $paciente['servicio'];
			$sala = $paciente['sala'];
			$cama = $paciente['cama'];
			$nom_paciente = $paciente['nom_paciente'];
			$rut_paciente = $paciente['rut_paciente'];
			$ficha_paciente = $paciente['ficha_paciente'];
			$fecha_ingreso = cambiarFormatoFecha($paciente['fecha_ingreso']);
			$fono1 = $paciente['fono1_paciente'];
			$fono2 = $paciente['fono2_paciente'];
			$medico = $paciente['medico'];
			$id_paciente = $paciente['id_paciente'];
			$diagnostico2 = $paciente['diagnostico2'];
			$procedencia = $paciente['procedencia'];
			$cod_auge = $paciente['cod_auge'];
			$nom_auge = $paciente['auge'];
			$acc_transito = $paciente['acctransito'];
			$prevision = $paciente['prevision'];
			$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
			$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
			$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
			$hospitalizado = substr($paciente['hospitalizado'],0,10);
			$hospitalizadohora = substr($paciente['hospitalizado'],11,19);
		}
		
	?>

<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="img/fondo.jpg">

		<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Consulta Estado de Pacientes.</th>

        <tr>
            <td class="encabezadoscentro" background="img/fondo.jpg">
			
	       <fieldset>
          
			<br />
	
        <fieldset class="fieldset_det2">
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="20px">&nbsp;</td> 
					<td>Servicio Clinico : <input size="25" type="text" name="pservicio" value="<?= $desc_servicio; ?>" readonly="readonly"/> Sala : <input size="15" type="text" name="pcama" value="<? echo $sala; ?>" readonly="readonly" /> Cama N� : <input size="3" type="text" name="pcama" value="<?php echo $cama; ?>" readonly="readonly" /> Categorizaci�n : <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
                    <td align="right">
                    	<!--<a href="consultapacientes.php"><img src="img/close.gif" border="0" style="padding-left:5px" title="Salir a Consulta Pacientes" /></a>-->
					</td>
                </tr>
            </table>
        </fieldset>

		<fieldset class="fieldset_det2"><legend>Paciente</legend>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="20px">&nbsp;</td>
                    <td>Rut</td>
                    <td> 
                      <input size="9" type="text" name="prut" value="<?php echo $rut_paciente; ?>" readonly="readonly" />
                    <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($rut_paciente); ?>" readonly="readonly" /> 
                    N&deg; Ficha 
                    <input size="10" type="text" name="pficha" value="<?php echo $ficha_paciente; ?>" readonly="readonly" /> Prevision <input size="25" type="text" name="pprevision" value="<?php echo $prevision; ?>" readonly="readonly" />
                    </td>
                    <td>
                        Fono1 <input size="12" type="text" name="pfono1" value="<?php echo $fono1; ?>" readonly="readonly" />
                    </td>
                    <td width="20px">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>        
                    <td>Nombre</td>
                    <td>
                        <input size="79" type="text" name="pnombre" value="<?php echo $nom_paciente; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        Fono2 <input size="12" type="text" name="pfono2" value="<?php echo $fono2; ?>" readonly="readonly" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr height="10px">
                </tr>
            </table>
        </fieldset>
    
        <fieldset class="fieldset_det2"><legend>Hospitalizaci&oacute;n</A></legend>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="20px"></td>
                	<td>Fecha de Ingreso</td>
                    <td><input size="9" type="text" name="pfecha" value="<?php echo $fecha_ingreso; ?>" readonly="readonly" /> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Hospitalizacion <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($hospitalizado); ?>" readonly="readonly" /> <input size="9" type="text" name="pfechah" value="<?php echo $hospitalizadohora; ?>" readonly="readonly" />
                    </td>
                </tr>
                <tr>
                    <td></td>                
                    <td>Medico Tratante</td>
					<td><input size="59" type="text" name="pmedico" value="<?php echo $medico; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $procedencia; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
	
                    <td><input size='25' type='checkbox' <? if($cod_auge <> 0){ ?> checked <? } ?> name='pauge' value="<? echo $cod_auge; ?>" disabled='disabled' />Patologia Auge </td>
                    
                     <td><input size="74" type="text" name="pdesauge" value="<?php echo $nom_auge; ?>" readonly='readonly' /><input type='checkbox' <? if($acc_transito == 1){ ?> checked <? } ?> name='pacctransito' disabled='disabled' />Accidente de Transito.</td>

                </tr>
              <tr height="10px"> </tr>                
            </table>
        </fieldset>

		<fieldset><legend>Historial Cl&iacute;nico</legend>
	
			<div align="center" style="width:823px;height:140px;overflow:auto">
	
			<table id="table_detallecama" border="2px" cellpadding="1px" cellspacing="0px">
				<tr>
					<td width="70px">Fecha</td>
					<td width="120px">Servicio</td>
					<td width="120px">Sala</td>
					<td width="40px">Cama</td>
   					<td width="50px">Categ.</td>
					<td width="185px">Estado Paciente</td>
					<td width="185px">Visitas Paciente</td>
				</tr>
	
	
				<?php

				
					$sql = "SELECT * FROM categorizacion where id_paciente = '".$id_paciente."' and fecha >= '".$hospitalizado."' order by fecha DESC";
					mysql_connect ('10.6.21.29','usuario','hospital');
					mysql_select_db('camas') or die('Cannot select database');
					$query = mysql_query($sql) or die(mysql_error());

					while($list_paciente = mysql_fetch_array($query)){

						if($list_paciente['estado_1']=="0") { $estado_pac = "No-Registrado"; }
						if($list_paciente['estado_1']=="1") { $estado_pac = "Estable"; }
						if($list_paciente['estado_1']=="2") { $estado_pac = "De Cuidado"; }
						if($list_paciente['estado_1']=="3") { $estado_pac = "Grave"; }
						if($list_paciente['estado_1']=="4") { $estado_pac = "Muy Grave"; }
						if($list_paciente['estado_1']=="5") { $estado_pac = "De Alta"; }
						
						if($list_paciente['estado_2']=="0") { $visitas_pac = "No-Registrado"; }
						if($list_paciente['estado_2']=="1") { $visitas_pac = "Sin Acompa�amiento"; }
						if($list_paciente['estado_2']=="2") { $visitas_pac = "12 Horas"; }
						if($list_paciente['estado_2']=="3") { $visitas_pac = "24 Horas"; }


						?>

						<tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
		
						<td><? echo cambiarFormatoFecha($list_paciente['fecha']); ?>				</td>
						<td><? echo $list_paciente['servicio']; ?></td>
						<td><? echo $list_paciente['sala']; ?></td>
						<td><? echo $list_paciente['cama']; ?></td>
   						<td><? echo $list_paciente['categorizacion_riesgo']."".$list_paciente['categorizacion_dependencia']; ?></td>
						<td> <strong> <? echo $estado_pac; ?> </strong></td>
						<td> <strong> <? echo $visitas_pac; ?> </strong></td>
						</tr>
				<?	}
				?>
	
			</table>
	
			</div>
	
		</fieldset>

		<fieldset><legend>Historial Hospitalizaciones</legend>
	
			<div align="center" style="width:823px;height:140px;overflow:auto">
	
			<table id="table_detallecama2" border="2px" cellpadding="1px" cellspacing="0px">
				<tr>
					<td width="70px">Desde</td>
					<td width="70px">Hasta</td>
					<td width="120px">Servicio</td>
					<td width="120px">Sala</td>
					<td width="40px">Cama</td>
					<td width="370px">Diagnostico</td>
				</tr>
	
	
				<?php

				if ($id_paciente <> 0)
					{
		
					$rut_paciente = $paciente['rut_paciente'];
					$sql = "SELECT * FROM hospitalizaciones where id_paciente = '".$id_paciente."' order by fecha_ingreso DESC";
					
					//$sql = "SELECT * FROM hospitalizaciones where rut_paciente = '".$rut_paciente."'";
					mysql_connect ('10.6.21.29','usuario','hospital');
					mysql_select_db('camas') or die('Cannot select database');
					$query2 = mysql_query($sql) or die(mysql_error());

					while($list_paciente = mysql_fetch_array($query2)){
						 ?>
			
						<tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
		
						<td><? echo cambiarFormatoFecha($list_paciente['fecha_ingreso']); ?></td>
						<td><? echo cambiarFormatoFecha($list_paciente['fecha_egreso']); ?></td>
						<td><? echo $list_paciente['servicio']; ?></td>
						<td><? echo $list_paciente['sala']; ?></td>
						<td><? echo $list_paciente['cama']; ?></td>
						<td>&nbsp;</td>
						</tr>
				<?	}
				}
				?>
	
			</table>
	
			</div>
	
		</fieldset>

            </fieldset>          
        </td>
    </tr>
    
</table>


	<script language="JavaScript">
    <!--
        tigra_tables('table_detallecama', 1, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
		tigra_tables('table_detallecama2', 1, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
    // -->
    </script>

</body>
</html>

<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>

