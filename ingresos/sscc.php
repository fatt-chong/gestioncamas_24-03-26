<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header
$cod_servicio = $_GET['cod_servicio'];
if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}


include "../funciones/funciones.php";	

$fecha_hoy = date('Y-m-d');

$i_mens_todos = 0;

//$id_rau = $_SESSION['MM_Servicio'];

$servicios_rau = $_SESSION['serviciousuario'];
$permisos = $_SESSION['permiso'];

//$servicios_rau[0] = 10311;
//$servicios_rau[0] = 10314;
//$servicios_rau[2] = 10320;

if ($cod_servicio == '') { $cod_servicio = $_SESSION['MM_Servicio_activo']; } else { $_SESSION['MM_Servicio_activo'] = $cod_servicio; }

mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM sscc where id = $cod_servicio") or die(mysql_error());
$query_servicio = mysql_fetch_array($query);
$servicio = $query_servicio['id'];
$desc_servicio= $query_servicio['servicio'];
$codigo_rau = $query_servicio['id_rau'];

	
	$_SESSION['MM_Servicio_activo'] = $cod_servicio;
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>

<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css"/>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link type="text/css" rel="stylesheet" href="css/cssDiv.css" />
<style> 
	a{text-decoration:none} 
</style> 

	<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
	<script language="JavaScript" src="../tablas/tigra_hints.js"></script>

<style>
		.hintsClass {
			font-family: tahoma, verdana, arial;
			font-size: 12px;
			background-color: #f0f0f0;
			color: #000000;
			border: 1px solid #808080;
			padding: 5px;
		}
	</style>
    
<style> 
	a{text-decoration:none} 
</style> 


</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

<DIV ID="midiv" STYLE="position:absolute; left:50%; top:50%; height:100px; margin-top: -50px; width:100px; margin-left:-50px">
	<img src="../../estandar/img/cargando.gif" />
</DIV> 
<? 
//MOSTRARA ALERTA CUANDO SE ENCUENTREN PACIENTES EN TRANSITO DESDE O HACIA EL SERVICIO SELECCIONADO
$sqlTransito = "SELECT * FROM transito_paciente where (cod_sscc_hasta = $codigo_rau ) OR (cod_sscc_desde = $codigo_rau )";
$queryTransito = mysql_query($sqlTransito) or die( "ERROR AL SELECCIONAR PACIENTES EN TRANSITO ". mysql_error());

$warning=0;
$error=0;
$nada=0;

while($arrayTransito = mysql_fetch_array($queryTransito)){
	$dia_transito = $arrayTransito['fecha'];
	$hora_transito = $arrayTransito['hora'];
	
	$fecha_completa = $dia_transito.' '.$hora_transito;
	$hoy = date("Y-m-d").' '.date("H:i:s");
	//DIFERENCIA TIEMPO EN HORAS
	$tiempo_espera = intval((strtotime($hoy)-strtotime($fecha_completa))/3600);
	
	$dias_espera = ($tiempo_espera / 24);
	$decimales = explode(".",$dias_espera);
	$dias_espera = $decimales[0];
	$horas_espera = ($tiempo_espera - ($dias_espera*24));
	$total_horas = (($dias_espera*24)+($horas_espera));
			
	if(($total_horas > 25) and ($total_horas < 101)){
		$warning = $warning+1;
		}else if($total_horas > 100){
			$error = $error+1;
			}else{
				$nada = $nada+1;
				}
	}

if(($warning > 0) and ($error == 0)){
?>
<div class="warning"><strong>AVISO!</strong><br />  Existen pacientes en espera de ser ingresados por su servicio o de ser recepcionados por servicio destino.<br />
Favor revise listado que se encuentra al final de la pagina con  pacientes trasladados y/o en espera.
Si este problema persiste por mas de tres días, el sistema impedirá ingresar mas pacientes en camas.<br />
Favor solucionar problemas o contactarse con <strong>unidad de informática al 584612 o 584477</strong> o al correo <strong>informatica@hjnc.cl .</strong></div>
<? } else if($error > 0){ 
$bandera = 1;
?>
<div class="error"><strong>ADVERTENCIA !</strong><br /> Existen pacientes en espera de ser ingresados por su servicio o de ser recepcionados por servicio destino, <strong>por mas de tres dias.</strong><br /> 
El sistema impedirá ingresar más pacientes en camas hasta solucionar la situación de estos pacientes. Favor solucionar estos problemas o contactarse con <strong>unidad de informática al 584612 o 584477 </strong> o al correo <strong>informatica@hjnc.cl.</strong>
</div>
<? }?>

<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    
  <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp;Administración de Pacientes.</th>

        <tr>
            <td class="encabezadoscentro" background="img/fondo.jpg">
            	<fieldset>
					<table>
						<tr>
							<td>



	<table align='center' style='vertical-align:top'>
	<tr><td>
	<fieldset>
	<table align='center' border='0'>
	<tr style='vertical-align:top'>
	
	<td align='right'><img width="23" height="23" src="../../estandar/iconos/alert.png" alt="Informacion" style="cursor:pointer" onClick="window.open('../informes/GC_2.0.pdf', 'gc_ayuda', 'toolbar=0,location=0, directories=0,status=0,menubar=0,scrollbars=1,resizable=1,left=1,top=1,fullscreen=0')" /> &nbsp;
	<a class='titulo'> Ingreso y Alta de Pacientes Servicio Cl&iacute;nico de </a>
	</td>
	<td> 
    

<?		//echo 'AQUI--------> '.$cod_servicio;
	if (count($servicios_rau) > 1)
	{
		?>
        
		<form method="get" action="sscc.php" name="frm_sscc" id="frm_sscc">
					<select class='titulo' name="cod_servicio" onchange="document.frm_sscc.submit()">
					<?php
						$i = 0;
						mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
						mysql_select_db('camas') or die('Cannot select database');
					
						for($i=0; $i<count($servicios_rau); $i++)
						{
							$query = mysql_query("SELECT * FROM sscc where id_rau = $servicios_rau[$i]") or die(mysql_error());
							$query_servicio = mysql_fetch_array($query);
							if ( $query_servicio['ver'] == 1) {
								if( $query_servicio['id'] == $cod_servicio )
								{
									echo "<option value='".$query_servicio['id']."' selected>".$query_servicio['servicio']."</option>";
									$id_rau=$query_servicio['id_rau'];
								}
								else
								{
									echo "<option value='".$query_servicio['id']."'>".$query_servicio['servicio']."</option>";
								}
							}
						}
						?>
					</select>
		</form>
		<?
	}
	else
	{
		$id_rau = $servicios_rau[0];
		?>
		<a class='titulo'><? echo $desc_servicio; ?></a>
	<? } ?>
            
                
	</td>
	
	<td align='right'  width='120px'>
	<?
    $ruta = "../../equipos/Interfaz/muralEquipos.php?codigoServicio=".$_SESSION['MM_Servicio_activo'];

	?>
    
 	<img width="25" height="25" src="../../estandar/iconos/equipos_med.png" alt="Equipos Medicos" onClick="window.open('<? echo $ruta; ?>', 'ventana_eq_med', 'toolbar=0,location=0, directories=0,status=0,menubar=0,scrollbars=1,resizable=1,left=1,top=1,fullscreen=0')" />

 	<img width="25" height="25" src="../../estandar/iconos/icono-ayuda.jpg" alt="Ayuda" onClick="window.open('../help.php', 'ventana_ayuda', 'toolbar=0,location=0, directories=0,status=0,menubar=0,scrollbars=1,resizable=1,left=1,top=1,fullscreen=0')" />
    
    
    
    
    &nbsp;
    <? if(($cod_servicio == 8) or ($cod_servicio == 9)){ 
		 if (array_search(425, $permisos) != null ){ ?>

    <input type="button" name="turno" id="turno" value="Entrega Turno" onclick="window.location.href='<? echo "../entregaTurno/entrega_turno.php"?>'" style="b"  />
    <?
		}
	} ?>    
    
	</td>
    <!--CODIGO CAMAS SUPERNUMERARIAS PARA GINECOLOGIA, PUERPERIO Y EMB. PATOLOGICO-->
    <? 
	$sqlVerifica = mysql_query("SELECT
					Count(camas.id) as NumCama
					FROM
					camas
					WHERE
					camas.cod_servicio = $cod_servicio AND
					camas.estado = 1") or die ("ERROR AL CONTAR CAMAS DEL SERVICIO ".mysql_error());
	$arryVerifica = mysql_fetch_array($sqlVerifica);
	if($arryVerifica['NumCama'] > 0){
		$flagCama = 1;
		}else{
			$flagCama = 0;
			}
					
	if(($cod_servicio == 14) or ($cod_servicio == 11)){ ?>
    <td>
    <input type="button" name="agregarSN" id="agregarSN" value="Cama SN" <? if($flagCama==1){ ?> disabled="disabled" <? } ?> onclick="window.location.href='<? echo "ingresopacienteSN.php?"?>'" />
    
    </td>
    <? } ?>
    <!--FIN CODIGO SN-->
	</tr>
	</table>
	</fieldset>
	</tr>
    </td>
	</table>

</div>


</td>
</tr>

<tr>
<td>

<div align='center'>

<?
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');


if ($servicio == 51) 
{
	$sql = "SELECT * FROM pabellon where fecha_ingreso = '$fecha_hoy' order by sala, cama";
//	echo $sql;
}
else
{
	$sql = "SELECT * FROM camas where cod_servicio = $servicio order by sala, cama";
//	echo $sql;
}

$query = mysql_query( $sql ) or die(mysql_error());

	$sala = '0';
	$nro_salas = 0;
	$max_largo = 0;
 	
	$camas_ocupadas = 0;
	$camas_desocupadas = 0;
	$camas_bloqueadas = 0;
	$tot_cat_a1 = 0;
	$tot_cat_a2 = 0;
	$tot_cat_a3 = 0;
	$tot_cat_b1 = 0;
	$tot_cat_b2 = 0;
	$tot_cat_b3 = 0;
	$tot_cat_c1 = 0;
	$tot_cat_c2 = 0;
	$tot_cat_c3 = 0;
	$tot_cat_d1 = 0;
	$tot_cat_d2 = 0;
	$tot_cat_d3 = 0;
	$camas_categorizadas = 0;
	$camas_x_categorizar = 0;


			$t_cma_ocupadas = 0;
			$t_cma_desocupadas = 0;
			$t_cma_bloqueadas = 0;
			$t_urg_ocupadas = 0;
			$t_urg_desocupadas = 0;
			$t_urg_bloqueadas = 0;


			$total_b_00_03 = 0;
			$total_b_03_08 = 0;
			$total_b_08_12 = 0;
			$total_b_12_ms = 0;
?>
	<table align='center' border='0'>
	<tr style='vertical-align:top'>
	
<?    while($camas = mysql_fetch_array($query)){
	
		if ($sala <> $camas['sala']){
		
			$nro_salas++;
		 	$max_largo = 0;
			
			if ($sala =='0'){
				?>
				<td>
                <div align="center" style="width:950px;height:310px;overflow:auto; border:groove ">

                <table>
                <tr style="vertical-align:top">

                <?
			}

			if ($sala <>'0'){
				?>
				</td>
				</tr>
				</table>
				</td>
				</tr>
				</table>
				</fieldset>
			<? } ?>

			<td>
			<fieldset>
			<? 
			if ($servicio == 51) { ?>
            <legend style='font-size:12px' >PABELLON <? echo $camas['sala']; ?></legend>
            <? } else { ?>
            <legend style='font-size:12px' >SALA <? echo $camas['sala']; ?></legend>
            <? } ?>
			<table align='center'>
  			<tr style='vertical-align:top'>
			<td>
			<table align='center'>
			<?
			$sala = $camas['sala'];
        }
		else
		{
			if ($max_largo == 3) {
		 		$max_largo = 0;
			?>
				</table>
				<td>
				<table align='center'>
		 <?	}
		 }

		$max_largo++;

		$id_cama = $camas['id'];
		$cama = $camas['cama'];
		$que_cod_servicio = $camas['que_cod_servicio'];
		$que_servicio = $camas['que_servicio'];
		$servicio = $camas['cod_servicio'];
		$sala = $camas['sala'];
		$desc_servicio = $camas['servicio'];
		$categorizacion_riesgo = $camas['categorizacion_riesgo'];
		$categorizacion_dependencia = $camas['categorizacion_dependencia'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$sexo_paciente = $camas['sexo_paciente'];
		$multires = $camas['multires'];
		$id_paciente = $camas['id_paciente'];
		$esta_ficha = $camas['esta_ficha'];
		$estado = $camas['estado'];
		$pabellon = $camas['pabellon'];
		$prevision = $camas['prevision'];

		$ingreso = $camas['fecha_ingreso'].' '.$camas['hora_ingreso'];
		$ingreso_hosp = $camas['hospitalizado'];
		$egreso = $camas['fecha_hoy'].' '.$camas['hora_hoy'];
		
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
	
		switch ($camas['estado']) {
			case 1:
				$inf_paciente = "Cama N&uacute;mero : ".$cama;
				echo "<tr><td class='td_sscc'><a ";
				?>
				onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
				<?
				if (( array_search(19, $permisos) != null ) and ($bandera != 1)) {
				echo " href='ingresopaciente.php?id_cama=$id_cama'; ";
				}
				echo "><img class='img_sscc' src='img/cama-vacia.gif' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				if ($servicio <> 50)
				{
					$camas_desocupadas ++;
					$arr_camas_desocupadas[$i] ++;
				}
				else
				{
					if ($sala == " CAMAS HOSP CMA")
					{
						$t_cma_desocupadas++;
					}
					else
					{
						$t_urg_desocupadas++;
					}
				}

 				break;
			case 2:

//						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Tiempo Desde Ingreso</b> : ".$dias_espera." dias y ".$horas_espera." horas";
						
						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso Hospital</b> &nbsp;&nbsp;: ".cambiarFormatoFecha2(substr($camas['hospitalizado'],0,10))." - ".substr($camas['hospitalizado'],11,5)." Hrs. <br /> <b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /> <b>- Ingreso Servicio</b> &nbsp;&nbsp; : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Prevision</b> : ".$prevision."<br />";


//				$inf_paciente = "Paciente: ***************************&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Pre-Diagnostico : ".$camas['diagnostico1']."&#13;&#10;Diagnostico : ".$camas['diagnostico2']."&#13;&#10;Medico : ".$camas['medico']."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";



				$logo_cama = 'cama-sc';
				
				if ($servicio <> 50)
				{
					if ($categorizacion == 'A1') { $logo_cama = 'cama-a'; $tot_cat_a1++; }
					if ($categorizacion == 'A2') { $logo_cama = 'cama-a'; $tot_cat_a2++; }
					if ($categorizacion == 'A3') { $logo_cama = 'cama-a'; $tot_cat_a3++; }
					if ($categorizacion == 'B1') { $logo_cama = 'cama-b'; $tot_cat_b1++; }
					if ($categorizacion == 'B2') { $logo_cama = 'cama-b'; $tot_cat_b2++; }
					if ($categorizacion == 'B3') { $logo_cama = 'cama-b'; $tot_cat_b3++; }
					if ($categorizacion == 'C1') { $logo_cama = 'cama-c'; $tot_cat_c1++; }
					if ($categorizacion == 'C2') { $logo_cama = 'cama-c'; $tot_cat_c2++; }
					if ($categorizacion == 'C3') { $logo_cama = 'cama-c'; $tot_cat_c3++; }
					if ($categorizacion == 'D1') { $logo_cama = 'cama-d'; $tot_cat_d1++; }
					if ($categorizacion == 'D2') { $logo_cama = 'cama-d'; $tot_cat_d2++; }
					if ($categorizacion == 'D3') { $logo_cama = 'cama-d'; $tot_cat_d3++; }
				}
				else
				{
					if ($sala == " CAMAS HOSP CMA")
					{
						$t_cma_ocupadas++;

						$logo_cama = 'cama-sc';
					}
					else
					{
						$t_urg_ocupadas++;
						
						if ($tiempo_espera <= 3) { $logo_cama = 'cama-a'; $total_b_00_03++; }
						if ($tiempo_espera > 3 and $tiempo_espera <= 8) { $logo_cama = 'cama-b'; $total_b_03_08++; }
						if ($tiempo_espera > 8 and $tiempo_espera <= 12) { $logo_cama = 'cama-c'; $total_b_08_12++; }
						if ($tiempo_espera > 12) { $logo_cama = 'cama-d'; $total_b_12_ms++; }

					}

				}



				if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m'; }
				else { $logo_cama = $logo_cama.'-h'; }
				
				if($esta_ficha == 1){
					$logo_cama = $logo_cama.'-f';
					}else{
						$logo_cama = $logo_cama;
						}
				

				$sql = "SELECT * FROM transito_fichas where id_paciente = $id_paciente";
				mysql_select_db('camas') or die('Cannot select database');
				
				$query_tf = mysql_query($sql) or die(mysql_error());
				$query_tf = mysql_fetch_array($query_tf);
				
				//if ($query_tf)
//				{
//					if ($query_tf['estado'] == 2) { $logo_cama = $logo_cama.'-f.gif'; }
//					else { $logo_cama = $logo_cama.'.gif'; }
//				}
//				else
//				{
//					$logo_cama = $logo_cama.'.gif';
//				}



				$que_color_paciente = "td_sscc";
				
				if ($cod_servicio <> $que_cod_servicio and $cod_servicio < 50 )
				{
					$que_color_paciente = "td_sscc_otroservicio";
				}
				
				if ($multires == 1)
				{
					$que_color_paciente = "td_sscc_multires";
				}
				
				if ($pabellon == 1){ $logo_cama = str_replace("cama","pabe",$logo_cama);}
				
				if(($camas['cod_prevision'] >= 2) && ($pabellon <> 1)){
					$logo_cama.= "_prev";
					}
				$logo_cama.=".gif";
				
				echo"<tr><td class=$que_color_paciente><a ";
				?>
				onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
				<?
			
				echo" href='altapaciente.php?id_cama=$id_cama' ><img class='img_sscc' src='img/".$logo_cama."' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				$camas_ocupadas ++;
				
				if ($camas['fecha_ingreso'] < $fecha_hoy)
				{
					$camas_x_categorizar ++;
					$arr_camas_x_categorizar[$i] ++;
					
				}
				if ($camas['fecha_categorizacion'] == $fecha_hoy)
				{
					$camas_categorizadas ++;
					$arr_camas_categorizadas[$i] ++;
				}
				
				
 				break;
			case 3:
				$inf_paciente = "<b>- Cama Bloqueada Desde</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Motivo</b> : ".$camas['diagnostico1'];			
				echo"<tr><td class='td_sscc'><a ";
				
				?>
				onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
				<?

				echo " href='desbloqueocama.php?id_cama=$id_cama&id_hosp=0&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado' rel='gb_page_center[820, 525]'><img class='img_sscc' src='img/icono-sn.gif' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				if ($servicio <> 50)
				{
					$camas_bloqueadas ++;
					$arr_camas_bloqueadas[$i] ++;
				}
				else
				{
					if ($sala == " CAMAS HOSP CMA")
					{
						$t_cma_bloqueadas++;
					}
					else
					{
						$t_urg_bloqueadas++;
					}
				}

 				break;
			case 4:

						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso Hospital</b> &nbsp;&nbsp;: ".cambiarFormatoFecha2(substr($camas['hospitalizado'],0,10))." - ".substr($camas['hospitalizado'],11,5)." Hrs. <br /> <b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /> <b>- Ingreso Servicio</b> &nbsp;&nbsp; : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Prevision</b> : ".$prevision;

//						$inf_paciente = "<b>- Paciente</b> : ".$camas['nom_paciente']."<br /> <b>- Ingreso</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])." - ".substr($camas['hora_ingreso'],0,5)." Hrs. <br /> <b>- Pre-Diagnostico</b> : ".$camas['diagnostico1']."<br /> <b>- Diagnostico</b> : ".$camas['diagnostico2']."<br /> <b>- Medico :</b> ".$camas['medico']."<br /> <b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )<br /> <b>- Servicio</b> : ".$que_servicio."<br /> <b>- Tiempo Desde Ingreso</b> : ".$dias_espera." dias y ".$horas_espera." horas";


//				$inf_paciente = "Paciente: ***************************&#13;&#10;Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."&#13;&#10;Pre-Diagnostico : ".$camas['diagnostico1']."&#13;&#10;Diagnostico : ".$camas['diagnostico2']."&#13;&#10;Medico : ".$camas['medico']."&#13;&#10;Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";


				$logo_cama = 'cama-sc';
				if ($servicio <> 50)
				{
					if ($categorizacion == 'A1') { $logo_cama = 'cama-a'; $tot_cat_a1++; }
					if ($categorizacion == 'A2') { $logo_cama = 'cama-a'; $tot_cat_a2++; }
					if ($categorizacion == 'A3') { $logo_cama = 'cama-a'; $tot_cat_a3++; }
					if ($categorizacion == 'B1') { $logo_cama = 'cama-b'; $tot_cat_b1++; }
					if ($categorizacion == 'B2') { $logo_cama = 'cama-b'; $tot_cat_b2++; }
					if ($categorizacion == 'B3') { $logo_cama = 'cama-b'; $tot_cat_b3++; }
					if ($categorizacion == 'C1') { $logo_cama = 'cama-c'; $tot_cat_c1++; }
					if ($categorizacion == 'C2') { $logo_cama = 'cama-c'; $tot_cat_c2++; }
					if ($categorizacion == 'C3') { $logo_cama = 'cama-c'; $tot_cat_c3++; }
					if ($categorizacion == 'D1') { $logo_cama = 'cama-d'; $tot_cat_d1++; }
					if ($categorizacion == 'D2') { $logo_cama = 'cama-d'; $tot_cat_d2++; }
					if ($categorizacion == 'D3') { $logo_cama = 'cama-d'; $tot_cat_d3++; }
				}
				else
				{
					if ($sala == " CAMAS HOSP CMA")
					{
						$t_cma_ocupadas++;

						$logo_cama = 'cama-sc';
					}
					else
					{
						$t_urg_ocupadas++;
						
						if ($tiempo_espera <= 3) { $logo_cama = 'cama-a'; $total_b_00_03++; }
						if ($tiempo_espera > 3 and $tiempo_espera <= 8) { $logo_cama = 'cama-b'; $total_b_03_08++; }
						if ($tiempo_espera > 8 and $tiempo_espera <= 12) { $logo_cama = 'cama-c'; $total_b_08_12++; }
						if ($tiempo_espera > 12) { $logo_cama = 'cama-d'; $total_b_12_ms++; }

					}
				}
				
				if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m'; }
				else { $logo_cama = $logo_cama.'-h'; }


				$sql = "SELECT * FROM transito_fichas where id_paciente = $id_paciente";
				mysql_select_db('camas') or die('Cannot select database');
				
				$query_tf = mysql_query($sql) or die(mysql_error());
				$query_tf = mysql_fetch_array($query_tf);
				
				if ($query_tf)
				{
					if ($query_tf['estado'] == 2) { $logo_cama = $logo_cama.'-f'; }
				}
				
				if ($pabellon == 1){ $logo_cama = str_replace("cama","pabe",$logo_cama);}
				
				if(($camas['cod_prevision'] >= 2) && ($pabellon <> 1)){
					$logo_cama.= "_prev";
					}
				
				$logo_cama.= ".gif";

				echo"<tr><td class='td_sscc_dealta'><a ";
				
				?>
				onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
				<?
			
				echo" href='altapaciente.php?id_cama=$id_cama' ><img class='img_sscc' src='img/".$logo_cama."' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				$camas_ocupadas ++;
				
				if ($camas['fecha_ingreso'] < $fecha_hoy)
				{
					$camas_x_categorizar ++;
					$arr_camas_x_categorizar[$i] ++;
					
				}
				if ($camas['fecha_categorizacion'] == $fecha_hoy)
				{
					$camas_categorizadas ++;
					$arr_camas_categorizadas[$i] ++;
				}
				
				
 				break;
				
				//NUEVO ESTADO DE CAMA SUPER NUMERARIA
				
				case 5:
					$sqlCamaSN = mysql_query("SELECT *
												FROM
												listasn
												INNER JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
												WHERE que_idcamaSN = $id_cama"); 
					$arrayCamaSN = mysql_fetch_array($sqlCamaSN);
						
				$inf_paciente = "<b>- Cama Bloqueada Desde</b> : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br /> <b>- Paciente</b> : ".$arrayCamaSN['nomPacienteSN']."<br /> <b>- Sala </b> : ".$arrayCamaSN['salaCamaSN']." <b>Cama </b> : ".$arrayCamaSN['nomCamaSN']."<br /> <b>- Servicio:</b> : ".$arrayCamaSN['desde_nomServSN']."<br /> <b>- Motivo</b> : ".$camas['diagnostico1'];			
				echo"<tr><td class='td_sscc'><a ";
				
				?>
				onmouseover="myHint.show(<? echo $i_mens_todos; ?>)" onmouseout="myHint.hide()"
				<?

				echo " href='desbloqueocama.php?id_cama=$id_cama&id_hosp=0&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado' rel='gb_page_center[820, 525]'><img class='img_sscc' src='../superNumeraria/img/cama-vacia-sn.gif' /></a><br>";
				echo"Cama ".$cama." </td></tr>";
				if ($servicio <> 50)
				{
					$camas_bloqueadas ++;
					$arr_camas_bloqueadas[$i] ++;
				}
				else
				{
					if ($sala == " CAMAS HOSP CMA")
					{
						$t_cma_bloqueadas++;
					}
					else
					{
						$t_urg_bloqueadas++;
					}
				}

 				break;


		}
		
		$inf_paciente = str_replace("\"", " ", $inf_paciente);
		$inf_paciente = str_replace("'", " ", $inf_paciente);

		$arreglo_camas[$i_mens_todos] = $inf_paciente;
		$i_mens_todos++;
		
	}
	
	?>
    </td>
    </tr>
    </table>
    
    </div>
    
	</td>
    
	</tr>
	</table>
	</td>
    <!--CODIGO CAMAS SUPERNUMERARIAS PARA GINECOLOGIA, PUERPERIO Y EMB. PATOLOGICO-->
    <? if(($cod_servicio == 14) or ($cod_servicio == 11)){ 
	
		$sqlMuestraSN = "SELECT *
						FROM
						camassn
						INNER JOIN listasn ON camassn.codCamaSN = listasn.idCamaSN
						WHERE
						camassn.tipoCamaSN = 'G'
						and camassn.servicioCamaSN = $cod_servicio
						ORDER BY nomCamaSN ASC";
		$queryMuestraSN = mysql_query($sqlMuestraSN) or die("ERROR AL MOSTRAR CAMAS SN ".mysql_error());
		$arrayMuestraSN = mysql_fetch_array($queryMuestraSN);
				
		if($arrayMuestraSN){
			include('mostrarCamaSN.php');
			}
	
	 } ?>
    
	</tr>
	</table>

    </td>
<?
	$total_categorizado = $tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2+$tot_cat_b3+$tot_cat_c1+$tot_cat_c2+$tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3;
	$total_cat_a = $tot_cat_a1+$tot_cat_a2+$tot_cat_a3;
	$total_cat_b = $tot_cat_b1+$tot_cat_b2+$tot_cat_b3;
	$total_cat_c = $tot_cat_c1+$tot_cat_c2+$tot_cat_c3;
	$total_cat_d = $tot_cat_d1+$tot_cat_d2+$tot_cat_d3;

	$total_general_camas = $camas_ocupadas+$camas_desocupadas+$camas_bloqueadas;

	if ($camas_x_categorizar <> 0)
	{
		$resumen =	"Resumen de Categorizaci&oacute;n Diaria (".$camas_categorizadas." / ".$camas_x_categorizar.") - ".number_format((($camas_categorizadas*100)/$camas_x_categorizar),2,",",".")." %";
	}
	else
	{
		$resumen =	"Resumen de Categorizaci&oacute;n Diaria (".$camas_categorizadas." / ".$camas_x_categorizar.") - 0.00 %";
	}

/*
                                <td colspan="2" align="left">Camas x Categorizar</td>
                                <td align="right"><? echo $camas_x_categorizar ?></td>
                                <td align="right"><? echo number_format((($camas_x_categorizar*100)/$camas_ocupadas),2,",",".") ?>%</td>
                                <td colspan="2" align="left">Camas Categorizadas</td>
                                <td align="right"><? echo $camas_categorizadas ?></td>
                                <td align="right"><? echo number_format((($camas_categorizadas*100)/$camas_x_categorizar),2,",",".") ?>%</td>
                                
*/                                

if ($servicio <> 51) 
{
	?> 

    <tr>
		<td colspan="<? echo $nro_salas; ?>">
          <fieldset style="padding-left:15px"> <legend style="font-size:15px"><? echo $resumen; ?></legend>

				<?            
				if 	($servicio == 50)

				{
					
					
               	$total_cma_camas = $t_cma_ocupadas+$t_cma_desocupadas+$t_cma_bloqueadas;
               	$total_urg_camas = $t_urg_ocupadas+$t_urg_desocupadas+$t_urg_bloqueadas;
					
				?>
                
				<table align="left" border="0">
                <tr>
                <td>
                    <table width="100%" align="left" border="1" cellpadding="0px" cellspacing="0px">
                        <tr align="right">
                            <td colspan="3" align="center">Camas Transitorias Hospitalizacion CMA.</td>
                        </tr>

                        <tr align="right">
                            <td colspan="1" align="left">Camas Ocupadas</td>
                            <td align="right"><? echo $t_cma_ocupadas ?></td>
                            <td align="right"><? echo number_format((($t_cma_ocupadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Camas Libres</td>
                            <td align="right"><? echo $t_cma_desocupadas ?></td>
                            <td align="right"><? echo number_format((($t_cma_desocupadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Camas Bloqueadas</td>
                            <td align="right"><? echo $t_cma_bloqueadas ?></td>
                            <td align="right"><? echo number_format((($t_cma_bloqueadas*100)/$total_cma_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Total Camas</td>
                            <td align="right"><? echo $total_cma_camas ?></td>
                            <td align="right">100%</td>
                        </tr>
                        <tr align="right" height="5">
                            <td colspan="3" align="center"></td>
                        </tr>
                        <tr align="right">
                            <td colspan="3" align="center">Pacientes Hosp. en Box de Urgencia.</td>
                        </tr>

                        <tr align="right">
                            <td colspan="1" align="left">Ocupacion</td>
                            <td align="right"><? echo $t_urg_ocupadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_ocupadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Disponibilidad</td>
                            <td align="right"><? echo $t_urg_desocupadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_desocupadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Bloqueos</td>
                            <td align="right"><? echo $t_urg_bloqueadas ?></td>
                            <td align="right"><? echo number_format((($t_urg_bloqueadas*100)/$total_urg_camas),1,",",".") ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left">Total Camas</td>
                            <td align="right"><? echo $total_urg_camas ?></td>
                            <td align="right">100%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" bgcolor="#00CC33" >Espera Menos de 3 Hrs.</td>
                            <td align="right" bgcolor="#00CC33" ><? echo number_format(($total_b_00_03),0,",",".") ?></td>
                            <td align="right" bgcolor="#00CC33" ><? if ($total_urg_camas <> 0) { echo number_format((($total_b_00_03*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" bgcolor="#FFFF00" >Espera Entre 3 y 8 Hrs.</td>
                            <td align="right" bgcolor="#FFFF00" ><? echo number_format(($total_b_03_08),0,",",".") ?></td>
                            <td align="right" bgcolor="#FFFF00" ><? if ($total_urg_camas <> 0) { echo number_format((($total_b_03_08*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" bgcolor="#FFCC33" >Espera Entre 8 y 12 Hrs.</td>
                            <td align="right" bgcolor="#FFCC33" ><? echo number_format(($total_b_08_12),0,",",".") ?></td>
                            <td align="right" bgcolor="#FFCC33" ><? if ($total_urg_camas <> 0) { echo number_format((($total_b_08_12*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>
                        <tr align="right">
                            <td colspan="1" align="left" bgcolor="#FF0000" >Espera Mas de 12 Hrs.</td>
                            <td align="right" bgcolor="#FF0000" ><? echo number_format(($total_b_12_ms),0,",",".") ?></td>
                            <td align="right" bgcolor="#FF0000" ><? if ($total_urg_camas <> 0) { echo number_format((($total_b_12_ms*100)/$total_urg_camas),0,",","."); } else { echo "0"; } ?>%</td>
                        </tr>

                    </table>
				</td>
                </tr>

                </table>
				<?
	
				}
				else
				{
            	?>
 
            <table align='left' border="1" cellpadding="7px" cellspacing="2px">
                    <tr>
                        <td colspan="3"><strong>Detalle de Ocupación</strong></td>
                    </tr>
                    <tr>
                        <td align="left">Camas Ocupadas</td>
                        <td align="right"><? echo $camas_ocupadas ?></td>
                        <td align="right"><? echo number_format((($camas_ocupadas*100)/$total_general_camas),2,",",".") ?>%</td>

                    </tr>
                    <tr>
                        <td align="left">Camas Libres</td>
                        <td align="right"><? echo $camas_desocupadas ?></td>
                        <td align="right"><? echo number_format((($camas_desocupadas*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left">Camas Bloqueadas</td>
                        <td align="right"><? echo $camas_bloqueadas ?></td>
                        <td align="right"><? echo number_format((($camas_bloqueadas*100)/$total_general_camas),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left">Totales</td>
                        <td align="right"><? echo $total_general_camas ?></td>
                        <td align="right">100%</td>
                    </tr>
            </table>
                <?
				}
   				if ( $total_categorizado == '0')
				{
					echo "<table align='center'>";
					echo "<tr>";
					echo "<td>Servicio Sin Categorización</td>";
					echo "</tr>";
					echo "</table>";
				}
				else
				{
				?>

        
            <table align='left' border="1" cellpadding="7px" cellspacing="2px">
                    <tr>
                        <td colspan="12"><strong>Resumen de Categorización</strong></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33">A1</td>
                        <td bgcolor="#00CC33"><? echo $tot_cat_a1 ?></td>
                        <td bgcolor="#00CC33"><? echo number_format((($tot_cat_a1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00">B1</td>
                        <td bgcolor="#FFFF00"><? echo $tot_cat_b1 ?></td>
                        <td bgcolor="#FFFF00"><? echo number_format((($tot_cat_b1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33">C1</td>
                        <td bgcolor="#FFCC33"><? echo $tot_cat_c1 ?></td>
                        <td bgcolor="#FFCC33"><? echo number_format((($tot_cat_c1*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF">D1</font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo $tot_cat_d1 ?></font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d1*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33">A2</td>
                        <td bgcolor="#00CC33"><? echo $tot_cat_a2 ?></td>
                        <td bgcolor="#00CC33"><? echo number_format((($tot_cat_a2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00">B2</td>
                        <td bgcolor="#FFFF00"><? echo $tot_cat_b2 ?></td>
                        <td bgcolor="#FFFF00"><? echo number_format((($tot_cat_b2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33">C2</td>
                        <td bgcolor="#FFCC33"><? echo $tot_cat_c2 ?></td>
                        <td bgcolor="#FFCC33"><? echo number_format((($tot_cat_c2*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF">D2</font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo $tot_cat_d2 ?></font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d2*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td bgcolor="#00CC33">A3</td>
                        <td bgcolor="#00CC33"><? echo $tot_cat_a3 ?></td>
                        <td bgcolor="#00CC33"><? echo number_format((($tot_cat_a3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFFF00">B3</td>
                        <td bgcolor="#FFFF00"><? echo $tot_cat_b3 ?></td>
                        <td bgcolor="#FFFF00"><? echo number_format((($tot_cat_b3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FFCC33">C3</td>
                        <td bgcolor="#FFCC33"><? echo $tot_cat_c3 ?></td>
                        <td bgcolor="#FFCC33"><? echo number_format((($tot_cat_c3*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF">D3</font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo $tot_cat_d3 ?></font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo number_format((($tot_cat_d3*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
                    <tr align="right">
                        <td align="left" bgcolor="#00CC33">A</td>
                        <td bgcolor="#00CC33"><? echo $total_cat_a ?></td>
                        <td bgcolor="#00CC33"><? echo number_format((($total_cat_a*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FFFF00">B</td>
                        <td bgcolor="#FFFF00"><? echo $total_cat_b ?></td>
                        <td bgcolor="#FFFF00"><? echo number_format((($total_cat_b*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FFCC33">C</td>
                        <td bgcolor="#FFCC33"><? echo $total_cat_c ?></td>
                        <td bgcolor="#FFCC33"><? echo number_format((($total_cat_c*100)/$total_categorizado),2,",",".") ?>%</td>
                        <td align="left" bgcolor="#FF0000"> <font color="#FFFFFF">D</font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo $total_cat_d ?></font></td>
                        <td bgcolor="#FF0000"> <font color="#FFFFFF"><? echo number_format((($total_cat_d*100)/$total_categorizado),2,",",".") ?>%</font></td>
                    </tr>
              </table>
              <?
/*              $sql2="SELECT nom_paciente, que_cod_servicio, que_servicio, cod_servicio, servicio, sala, cama, cta_cte,
					concat(categorizacion_riesgo , ' ' , categorizacion_dependencia) AS categoria
					FROM camas
					WHERE cta_cte is NOT NULL and que_cod_servicio <> cod_servicio and servicio = '".$desc_servicio."'
					ORDER BY que_cod_servicio, cod_servicio";

					mysql_select_db('camas') or die('Cannot select database');
					$query2 = mysql_query($sql2) or die(mysql_error());*/
			  ?>
                <!-- danny -->
                                <table height="164" align='left' border="1" cellpadding="7px" cellspacing="1px">
                  <tr>
                        <td colspan="3"><center> <strong>Resumen de Camas</strong></center></td>
                    </tr>
                    <tr>
                    	<td>Camas Cuidados</td>
                        <td>TOTAL</td>
                        <td>%</td>
                    </tr>
                    <tr>
                        <td align="left"> Criticos </td><td><? echo $tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2 ?></td>
                        <td><? echo number_format(((($tot_cat_a1+$tot_cat_a2+$tot_cat_a3+$tot_cat_b1+$tot_cat_b2)*100)/$total_categorizado),2,",",".")?>%</td>
                    </tr>
                    <tr>
                        <td align="left"> Medios </td><td><? echo $tot_cat_b3+$tot_cat_c1+$tot_cat_c2 ?></td>
                        <td><? echo number_format(((($tot_cat_b3+$tot_cat_c1+$tot_cat_c2)*100)/$total_categorizado),2,",",".") ?>%</td>
                    </tr>
                    <tr>
                        <td align="left"> Basicos </td><td><? echo $tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3 ?></td>
                        <td><? echo number_format(((($tot_cat_c3+$tot_cat_d1+$tot_cat_d2+$tot_cat_d3)*100)/$total_categorizado),2,",",".")?>%</td>
                    </tr>
                </table>
                <!-- danny -->
                                
                <? } ?>
                
            </fieldset>
		</td>
	</tr>

    <tr>
		<td colspan="<? echo $nro_salas; ?>">
        
            <fieldset style="padding-left:15px"> <legend style="font-size:16px">Pacientes En Espera</legend>
                <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <?
                        //$sql = "SELECT * FROM transito_paciente where cod_sscc_hasta = $id_rau";
//        

//                        mysql_select_db('camas') or die('Cannot select database');
//                        $query = mysql_query($sql) or die(mysql_error());
//

                        if(mysql_num_rows($queryTransito) > 0){
						mysql_data_seek($queryTransito,0);
						}
						echo "<tr>";
	                    echo "<td rowspan='2'>Fecha</td>";
                        echo "<td rowspan='2' width='200px'>Servicio Procedencia</td>";
                        echo "<td width='400px' colspan='2'>Paciente</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Rut</td>";
                        echo "<td>Nombres</td>";
                        echo "</tr>";
						
        				
                        while($traslados = mysql_fetch_array($queryTransito)){
							$servicio_hasta = $traslados['cod_sscc_hasta'];
							if($servicio_hasta == $id_rau){
								
								$id_traslado = $traslados['id'];
								$idpaciente = $traslados['id_paciente'];
								$rutpaciente = $traslados['rut_paciente'];
								$nompaciente = $traslados['nom_paciente'];
	//							$nompaciente = '******************************';
								
								echo "<tr style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif' >";
								echo "<td align='left' style='padding-left:10px; padding-right:10px' >".cambiarFormatoFecha2($traslados['fecha'])."</td>";
	
								echo "<td align='left' style='padding-left:10px; padding-right:10px' >".$traslados['desc_sscc_desde']." ".$traslados['cama_sn']."</td>";
								echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['rut_paciente']."</td>";
								echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['nom_paciente']."</td>";
								echo "</tr>";
							}
						} 
                        ?>       
                    </tr>
                </table>
                    
                <table>
                	<tr>
                    	
					</tr>                
                </table>
            </fieldset>
		</td>
	</tr>

    <tr>
		<td colspan="<? echo $nro_salas; ?>">
            <fieldset style="padding-left:15px"> <legend style="font-size:16px">Pacientes Trasladados</legend>
                <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <?
                               
                        echo "<tr>";
	                    echo "<td rowspan='2'>Fecha</td>";
                        echo "<td rowspan='2' width='200px'>Servicio Procedencia</td>";
                        echo "<td width='400px' colspan='2'>Paciente</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>Rut</td>";
                        echo "<td>Nombres</td>";
                        echo "</tr>";
        				
						if(mysql_num_rows($queryTransito) > 0){
						mysql_data_seek($queryTransito,0);
						}
                        while($traslados = mysql_fetch_array($queryTransito)){
							$servicio_desde = $traslados['cod_sscc_desde'];
							if($servicio_desde == $id_rau){
                        
								$id_traslado = $traslados['id'];
								$id_paciente = $traslados['id_paciente'];
								$rut_paciente = $traslados['rut_paciente'];
								$nom_paciente = $traslados['nom_paciente'];
	//							$nom_paciente = '******************************';
								
								echo "<tr style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif' >";
	
	echo "<td align='left' style='padding-left:10px; padding-right:10px' >".cambiarFormatoFecha2($traslados['fecha'])."</td>";                           
								echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$traslados['desc_sscc_hasta']."</td>";
								echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$rut_paciente."</td>";
								echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$nom_paciente."</td>";
								echo "</tr>";
							}
						} 
                        ?>       
                    </tr>
                </table>
            </fieldset>
		</td>
	</tr>



    <tr>
		<td colspan="<? echo $nro_salas; ?>">
       
        <? // FICHAS PENDIENTES DE DESPACHO A GRD  (RODRIGO ALTAMIRANO)
		require_once('clases/claseCamas.inc');
		$OBJcamas= new claseCamas;
		$QRYcamas=$OBJcamas->listarEgresos($cod_servicio);
		$cantidadDevolucion=$OBJcamas->canRegistro($cod_servicio);
		?>
        <fieldset style="padding-left:15px"> <legend style="font-size:16px">Fichas Pendientes Devolucion (<?=$cantidadDevolucion?>)</legend>
        <table width="621" border="0" cellspacing="0">
  <tr style="font-weight:bold; background-color:# CCC">
    <td width="68" style="border-bottom:1px solid #000;border-right:1px solid #000; border-left:1px solid #000; border-top:1px solid #000;">&nbsp;Rut</td>
    <td width="257" style="border-bottom:1px solid #000; border-right:1px solid #000; border-top:1px solid #000;">&nbsp;Nombres</td>
    <td width="63" style="border-bottom:1px solid #000; border-right:1px solid #000; border-top:1px solid #000;">&nbsp;Fichas</td>
    <td width="105" style="border-bottom:1px solid #000; border-right:1px solid #000; border-top:1px solid #000;">&nbsp;Fecha Egreso</td>
    <td width="73" style="border-bottom:1px solid #000; border-right:1px solid #000; border-top:1px solid #000;">&nbsp;Estado</td>
  </tr>
  </table>
  <div style="width:650px;height:350px;overflow:auto;" align="left">
 <table width="621" border="0" cellspacing="0">
  <? while($RSegresos = mysql_fetch_assoc($QRYcamas)){
	  $color='';
	  if($RSegresos['ficha_paciente']>0){
			if($RSegresos['estadoFicha']=='N'){
				$estadoDesc='PENDIENTE';$color='style="background-color:#FF6666;"';
				}else{$estadoDesc='RECEPCIONADA'; $color='style="background-color:#9FFF80;"';}
		}else{$estadoDesc='S/F CLINICA';$color='style="background-color:#FFFF66;"';}?>
        
  <tr <? echo $color;?>>
    <td width="68" style="border-bottom:1px solid #666;border-right:1px solid #666; border-left:1px solid #666; ">&nbsp;<?=$RSegresos['rut_paciente']?></td>
    <td width="257" style="border-bottom:1px solid #666; border-right:1px solid #666;">&nbsp;<?=$RSegresos['nom_paciente']?></td>
    <td width="63" style="border-bottom:1px solid #666; border-right:1px solid #666;">&nbsp;<?=$RSegresos['ficha_paciente']?></td>
    <td width="105" style="border-bottom:1px solid #666; border-right:1px solid #666;">&nbsp;<?=$RSegresos['fecha_egreso']?></td>
    <td width="73" style="border-bottom:1px solid #666; border-right:1px solid #666;">&nbsp;<?=$estadoDesc?></td>
  </tr>
  <? }?>
</table>
</div>
</fieldset>

          <!--  <fieldset style="padding-left:15px"> <legend style="font-size:16px">Fichas Pendientes de Devoluci&oacute;n a Archivo</legend>
           
                <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                    <tr>-->
                        <?
						//$fecha_fichas = sumadia($fecha_hoy ,-1);
//
//						$sql = "SELECT * FROM transito_fichas where cod_sscc = $id_rau and estado = 3 and fecha_alta < '$fecha_fichas' and nro_ficha <> 0";
//

//                        mysql_select_db('camas') or die('Cannot select database');
//                        $query = mysql_query($sql) or die(mysql_error());
//        
//                        echo "<tr>";
//                        echo "<td rowspan='2'>Ficha Nro.</td>";
//	                    echo "<td rowspan='2'>Fecha Alta</td>";
//                        echo "<td width='400px' colspan='2'>Paciente</td>";
//                        echo "</tr>";
//                        echo "<tr>";
//                        echo "<td>Rut</td>";
//                        echo "<td>Nombres</td>";
//                        echo "</tr>";
//        
//                        while($fichas = mysql_fetch_array($query)){
//							$nro_ficha = $fichas['nro_ficha'];
//							$rut_paciente = $fichas['rut_paciente'];
//							$nom_paciente = $fichas['nom_paciente'];
////							$nom_paciente = '******************************';
//							
//                            echo "<tr style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif' >";
//                            echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$nro_ficha."</td>";
//echo "<td align='left' style='padding-left:10px; padding-right:10px' >".cambiarFormatoFecha2($fichas['fecha_alta'])."</td>";                           
//                            echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$rut_paciente."</td>";
//                            echo "<td align='left' style='padding-left:10px; padding-right:10px'>".$nom_paciente."</td>";
//                            echo "</tr>";
//                        } 
                        ?>       
                   <!-- </tr>
                </table>
            </fieldset>-->
		</td>
	</tr>

<?
}
else
{
?>

   <tr>
		<td colspan="<? echo $nro_salas; ?>">
            <fieldset style="padding-left:15px"> <legend style="font-size:16px">Resumen de Pabellón</legend>
                <table id="traslado_table" align='left' border="1" cellpadding="0" cellspacing="0">
                    <tr>
                    Resumen
                    </tr>
                </table>
            </fieldset>
		</td>
	</tr>



<?
}

?>

</table>

</div>



</td>
</tr>

</table>

				</fieldset>          
			</td>
<td class="encabezadostablas"></td>
        </tr>
	    
	</table>
</div>


<?
$mens_todos = "'".implode("','",$arreglo_camas)."'";
?>

<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>



<script language="JavaScript">
// configuration variable for the hint object, these setting will be shared among all hints created by this object
var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 10, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : 20, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'bctl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'css'        : 'hintsClass', // a style class name for all hints, applied to DIV element (see style section in the header of the document)
	'show_delay' : 0, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 200, // a delay between closing event (mouseout for example) and hint disappearing
	'follow'     : true, // hint follows the mouse as it moves
	'z-index'    : 100, // a z-index for all hint layers
	'IEfix'      : false, // fix IE problem with windowed controls visible through hints (activate if select boxes are visible through the hints)
	'IEtrans'    : ['blendTrans(DURATION=.3)', null], // [show transition, hide transition] - nice transition effects, only work in IE5+
	'opacity'    : 95 // opacity of the hint in %%
};
// text/HTML of the hints

var HINTS_ITEMS = [ <? echo $mens_todos; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);



</script>




       <script language="JavaScript">
    <!--
        tigra_tables('traslado_table', 3, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
    // -->
    </script>
 




</body>
</html>

<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>





