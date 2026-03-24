<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../gestioncamas/superNumeraria/camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
// $CAMcod= $_GET['CAMcod'];
// $SALcod= $_GET['SALcod']; 
// $CAMnom= $_GET['CAMnom'];
// $idPensio= $_GET['idPensio'];

$CAMcod= $_GET['CAMcod'];
$idPaciente= $_GET['idPaciente'];
$idTransito= $_GET['idTransito'];
$SALcod= $_GET['SALcod']; 
$CAMnom= $_GET['CAMnom'];
$idPensio= $_GET['idPensio'];
$tipodocumento= $_GET['tipodocumento'];
$doc_paciente= $_GET['doc_paciente'];
$digito= $_GET['digito'];
$buscar= $_GET['buscar'];

$dbhost = $_SESSION['BD_SERVER'];
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");

if(($buscar == 1) && ($doc_paciente)){
	if ($tipodocumento == 1) {
			$sqlTransito = "SELECT 
							*
							FROM transito_paciente
							WHERE
							cta_cte = '$doc_paciente'
							AND cod_sscc_hasta <> 10371";
			$queryTransito = mysql_query($sqlTransito) or die ("ERROR AL SELECCIONAR INFORMACION X CTA CTE ".mysql_error());
			$array1 = mysql_fetch_array($queryTransito);
			
		}
	if ($tipodocumento == 2) { 
		$sqlTransito = "SELECT 
						*
						FROM transito_paciente
						WHERE
						rut_paciente = '$doc_paciente'
						AND cod_sscc_hasta <> 10371";
		$queryTransito = mysql_query($sqlTransito) or die ("ERROR AL SELECCIONAR INFORMACION X RUT ".mysql_error()); 
		$array1 = mysql_fetch_array($queryTransito);
		}
	if ($tipodocumento == 3) { 
		$sqlTransito = "SELECT 
						*
						FROM transito_paciente
						WHERE
						ficha_paciente = '$doc_paciente'
						AND cod_sscc_hasta <> 10371";
		$queryTransito = mysql_query($sqlTransito) or die ("ERROR AL SELECCIONAR INFORMACION X FICHA ".mysql_error()); 	
		$array1 = mysql_fetch_array($queryTransito);		   
		}

}else{
$sqlTransito = "SELECT
				*
				FROM
				transito_paciente
				WHERE 
				cod_sscc_hasta <> 10371
				ORDER BY
				transito_paciente.nom_paciente ASC";
				
$queryTransito = mysql_query($sqlTransito) or die ("ERROR AL SELECCIONAR INFORMACION DE TRANSITO PACIENTE ".mysql_error());
$array1 = mysql_fetch_array($queryTransito);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Listado Pacientes</title>
</head>
<? 
require_once("include/funciones/funciones.php");

?>
<body>
<form id="form_ingresa" name="form_ingresa" method="get">
<input type="hidden" name="CAMcod" id="CAMcod" value="<? echo $CAMcod; ?>" />
<input type="hidden" name="idPaciente" id="idPaciente" value="<? echo $idPaciente; ?>" />
<input type="hidden" name="idTransito" id="idTransito" value="<? echo $idTransito; ?>" />
<input type="hidden" name="SALcod" id="SALcod" value="<? echo $SALcod; ?>" />
<input type="hidden" name="CAMnom" id="CAMnom" value="<? echo $CAMnom; ?>" />
<input type="hidden" name="idPensio" id="idPensio" value="<? echo $idPensio; ?>" />

<table width="750" border="0" style="border:1px solid #000000;" align="center" cellpadding="4" cellspacing="4" background="../ingresos/img/fondo.jpg">
    <tr>
        <th height="25" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Asignar paciente a cupo</th>
    </tr>
    <tr>
    	<td>
        	<fieldset><legend class="titulos_menu">Buscar Paciente</legend>
            <table>
            	<tr>
                	<td>
                    <select name="tipodocumento">
                        <option value=2 <? if ($tipodocumento == 2) { echo "selected"; } ?> />Rut</option>
                        <option value=1 <? if ($tipodocumento == 1) { echo "selected"; } ?> />Cta-Cte</option>
                        <option value=3 <? if ($tipodocumento == 3) { echo "selected"; } ?> />Ficha</option>
                    </select>                    
					</td>
                    <td>
                    
           	      	<input size="9" type="text" id="doc_paciente" name="doc_paciente" onBlur="digitoVerificador(document.getElementById('doc_paciente'));" value="<? echo $doc_paciente; ?>" />
                  	
       	        	<input style="width:10px" type="text" name="digito" id="digito" readonly="readonly" value="<? echo $digito; ?>" >
                    <input type="hidden" name="buscar" id="buscar" value="1" />				    
					<input type="button" value="Aceptar" onclick="document.form_ingresa.action='ingresarPacienteSN.php'; document.form_ingresa.submit();" >
                    </td>
                </tr>
            </table> 
            </fieldset>
        </td>
    </tr>
    
    <tr>
        <td>
        	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <? if($array1){?>
                <tr>
                               
    				<td>
                        <fieldset>
						<legend class="titulos_menu">Pacientes en Espera	de	atenciÓn</legend>
						<table width="100%">
						  <tr>
                                <td>
                                <div align="center" style="width:800px;height:330px;overflow:auto ">
                                <table width="84%" align="center" cellpadding="5" cellspacing="3" id="tabla">
                                    <tr bgcolor="#ACACAC">
                                        <td width="34%">Nombre</td>
                                        <td width="14%">Rut</td>
                                        <td width="20%">Desde</td>
                                        <td width="19%">Hasta</td>
                                        <td width="13%" align="center">Fecha</td>
                                    </tr>
                                    <?
									mysql_data_seek($queryTransito,0);
									 while($RSlistado = mysql_fetch_array($queryTransito)){
										$idPaciente = $RSlistado['id_paciente'];
										$idTransito = $RSlistado['id'];
										
										if(($SALcod == 'Pensionado') or ($SALcod == 'CMI 3')){ ?>
											
										<tr bgcolor="#B9DCFF" style="cursor:pointer;" onclick="javascript: window.location.href='agregarPacienteSN.php?idPaciente=<? echo $idPaciente; ?>&idTransito=<? echo $idTransito; ?>&SALcod=<? echo $SALcod; ?>&CAMcod=<? echo $CAMcod; ?>&CAMnom=<? echo $CAMnom; ?>&idServicio=46&que_sala=1&que_cama=1&que_idcama=<? echo $idPensio; ?>'">	
										<? }else{ ?>
										
										<tr bgcolor="#B9DCFF" style="cursor:pointer;" onclick="javascript: window.location.href='elegirCamaSN.php?idPaciente=<? echo $idPaciente; ?>&idTransito=<? echo $idTransito; ?>&CAMcod=<? echo $CAMcod;?>&SALcod=<? echo $SALcod; ?>&CAMnom=<? echo $CAMnom;?>'">
                                    	
										<? } ?>
                                        
                                        <td><? echo $RSlistado['nom_paciente'];?></td>
                                        <td><? echo $RSlistado['rut_paciente'];?></td>
                                        <td><? echo $RSlistado['desc_sscc_desde'];?></td>
                                        <td><? echo $RSlistado['desc_sscc_hasta']; ?></td>
                                        <td align="center"><? echo cambiarFormatoFecha($RSlistado['fecha']);?></td>
                                    </tr>
                                    <? 
									 
									}?>
                                </table>
                                </div>
                                </td>
                          </tr>
                        </table>
						</fieldset>
					</td>
                				
				</tr>
				<? }else{ ?>
                <tr>
                    <td align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#000;">
                    <fieldset><legend class="titulos_menu">Mensaje</legend>
                    
                        <strong>El paciente no se encuentra en la lista de Traslados. </strong>
                    </fieldset>	
                    </td>
                </tr>
              <? } ?>
                <tr>
    				<td>
                        <fieldset class="titulocampo">
						<legend class="titulos_menu">Operaciones
						</legend><table width="100%">
							<tr>
                                <td align="right"><input type="button" name="atras" id="atras" value="   Atras   " onclick="javascript: document.location.href='camaSuperNum.php'" /></td>
                            </tr>
                        </table>
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>
    
</table>
</form>
</body>
</html>