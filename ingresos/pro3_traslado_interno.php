<?php 
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$fecha_actual = date("Y-m-d H:i:s");
$usuario_salida = $_SESSION['MM_Username'];

//VERIFICA SI LA CAMA SELECCIONADA NO HA SIDO UTILIZADA COMO SN
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$sqlVerifica = "SELECT * FROM camas where id = '".$t_id_cama."'";
$queryVerifica = mysql_query($sqlVerifica) or die(mysql_error());
$arrayVerifica = mysql_fetch_array($queryVerifica);
$estadoCama = $arrayVerifica['estado'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Categorizaci&oacute;n de Pacientes.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
				<? if($estadoCama == 1){ ?>
                <div class="titulo" align="center">
                
                <?
                include "../funciones/funciones.php";
                
                    mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
                    mysql_select_db('camas') or die('Cannot select database');
                
					if($barthel != ''){
						$sqlBarthel = ",barthel = '$barthel'";
						}
						
                    $resultado1 = mysql_query( "UPDATE camas SET
                    tipo_traslado   = $tipo_traslado,
                    tipo_1         = $tipo_1,
                    d_tipo_1       = '$d_tipo_1',
                    tipo_2         = $tipo_2,
                    d_tipo_2       = '$d_tipo_2',
                    cta_cte         = $cta_cte,
                    cod_procedencia = $cod_procedencia,
                    procedencia     = '$procedencia',
                    cod_medico      = $cod_medico,
                    medico          = '$medico',
                    cod_auge        = $cod_auge,
                    auge            = '$auge',
                    acctransito     = $acctransito,
                    diagnostico1    = '$diagnostico1',
                    diagnostico2    = '$diagnostico2',
                    id_paciente     = $id_paciente, 
                    rut_paciente    = $rut_paciente, 
                    ficha_paciente  = $ficha_paciente, 
                    esta_ficha	  	= $esta_ficha, 
                    nom_paciente    = '$nom_paciente', 
                    sexo_paciente   = '$sexo_paciente', 
                    edad_paciente   = 0, 
                    cod_prevision   = $cod_prevision, 
                    prevision       = '$prevision', 
                    direc_paciente  = '$direc_paciente', 
                    cod_comuna      = $cod_comuna, 
                    comuna          = '$comuna', 
                    fono1_paciente  = '$fono1_paciente', 
                    fono2_paciente  = '$fono2_paciente',
                    fono3_paciente  = '$fono3_paciente',
                    fecha_categorizacion = '$fecha_categorizacion',
                    categorizacion_riesgo = '$categorizacion_riesgo',
                    categorizacion_dependencia = '$categorizacion_dependencia',
                    pabellon        = $pabellon,
                    estado          = $estado,
                    hospitalizado = '$hospitalizado',
                    fecha_ingreso   = '$fecha_ingreso',
                    hora_ingreso   = '$hora_ingreso',
					id_parto	= '$id_parto',
					usuario_que_ingresa = '$usuario_que_ingresa',
					fecha_usuario_ingresa = '$fecha_usuario_ingresa'".$sqlBarthel."
                    WHERE id = $t_id_cama "  ) or die(mysql_error()); echo $resultado1;
                
                if ($resultado1)
                {
                
                    mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
                    mysql_select_db('camas') or die('Cannot select database');
                    
                    $resultado2 = mysql_query( "UPDATE camas SET
                    tipo_traslado   = 0,
                    cta_cte         = 0,
                    cod_procedencia = 0, 
                    procedencia     = '',
                    cod_medico      = 0,
                    medico          = '',
                    cod_auge        = 0, 
                    auge            = '', 
                    acctransito     = 0, 
                    diagnostico1    = '',
                    diagnostico2    = '',
                    id_paciente     = 0, 
                    rut_paciente    = 0, 
                    ficha_paciente  = 0, 
                    esta_ficha		= 0, 
                    nom_paciente    = '', 
                    sexo_paciente   = '', 
                    edad_paciente   = 0, 
                    cod_prevision   = 0, 
                    prevision       = '', 
                    direc_paciente  = '', 
                    cod_comuna      = 0, 
                    comuna          = '', 
                    fono1_paciente  = '', 
                    fono2_paciente  = '', 
                    fono3_paciente  = '',
                    fecha_categorizacion = '0000-00-00',
                    categorizacion_riesgo  = '',
                    categorizacion_dependencia  = '',
                    pabellon        = 0,
                    estado          = 1,
                    hospitalizado   = '0000-00-00 00:00:00',
                    fecha_ingreso   = '0000-00-00',
                    hora_ingreso    = '00:00:00',
					id_parto		= '0',
					usuario_que_ingresa = '',
					fecha_usuario_ingresa = '0000-00-00 00:00:00',
					barthel = NULL
                    WHERE id = $id_cama "  ) or die(mysql_error());
                    
                    $fallo_o_no = 0;
                
                }
                else
                {
                    $fallo_o_no = 1;
                }
                
                
                echo "<form>";
                echo "</br>";
                echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
                echo "<tr align='center'>";
                
                if ($fallo_o_no == 0)
                    {
                        echo "<td>";
                        echo "<fieldset style='padding:30px'>";
                        echo "La Traslado se Realizó con Exito </br></br>";
                        ?>
                        <input type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
                        parent.parent.GB_hide(); " >
                        <?
                    }
                else
                    {
                        echo "<td style='font-size:18px; color: #F00;'>";
                        echo "<fieldset style='padding:30px'>";
                        echo "Inconsistencia en los datos el proceso no termino con exito, comuniquesde con el administrador </br></br>";
                        ?>
                        <input type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
                        parent.parent.GB_hide(); " >
                        <?
                    }
                
                    echo "</fieldset>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "</br>";
                
                ?>
                
                </form>
                
                
                </div>
                <? }else { ?>
                
                <fieldset class="fieldset_det2"><legend>Error</legend>
                <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr height="25px">
                        </tr>
                        <tr>
                            <td align="center">La cama selecciona ha cambiado de </td>
                        </tr>
                        <tr>
                            <td align="center"> estado, y ya no se encuentra disponible.</td>
                        </tr>
                        <tr>
                            <td align="center">Recargue pagina de informacion de Servicio.</td>
                        </tr>
                        <tr height="25px">
                        </tr>
                    </table>
                
                </fieldset> 
                <fieldset class="fieldset_det2"><legend>Opciones</legend>
                  <div align="center">
                  <input type="Button" value=    "       Volver       " onClick="window.location.href='<? echo"sscc.php"; ?>'; parent.GB_hide(); " >
                  </div>
                </fieldset>
                <? } ?>
                </fieldset>
            </td>
       </tr>
  </table>


</body>
</html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>
