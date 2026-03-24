<?
if (!isset($_SESSION)) {
  session_start();
}

require_once('../../acceso/Connections/acceso.php');
require_once('../../acceso/cargarpermiso.php');
require_once('include/funciones/funciones.php');

	$botonactivado = "disabled=\"disabled\"";

	if (isset($HTTP_POST_VARS['tipo_salida'])) {
		$tipo_salida = $HTTP_POST_VARS['tipo_salida'];
	} else if (isset($HTTP_GET_VARS['tipo_salida'])) {
		$tipo_salida = $HTTP_GET_VARS['tipo_salida'];	
	} else {
		$tipo_salida = 0;
	}	
	
	$rut = $_GET['rut'];
	$nroficha = $_GET['nroficha'];
	$apellidopat = $_GET['apellidopat'];
	$apellidomat = $_GET['apellidomat'];
	$nombres = $_GET['nombres'];
	$totalreg = $_GET['totalreg'];
	$pacId = $_GET['pacId'];
    $desde = $_GET['desde'];
    $urlLlamada = $_GET['urlLlamada'];

    $act = $_GET['act'];

    if ($desde == '')
    {
    $desde = 0;
    }

	$largo = 10;
	$nropagina = ($desde / $largo) + 1;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Busqueda de Pacientes</title>
    <link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css" />
    
    <script language="JavaScript" src="src/tigra_tables.js"></script>

</head>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;">
<table width="866" border="1" align="center" cellpadding="5" cellspacing="0">
    <th width="860" height="30px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Buscar Paciente</th>
 <tr bgcolor="#FFFFFF">
   <td align="center">
	<form name="busca_paciente" method="get" action="buscarPaciente.php">
    	<input type="hidden" name="urlLlamada" id="urlLlamada" value="<? echo $urlLlamada;?>" />
	
        
	    <fieldset class="fieldset_det2"><legend>INGRESE DATOS DEL PACIENTE</legend>
	      <table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
            	<tr height="5px">

            	</tr>
            	<tr>
                	<td>Apellido Paterno </td>
    	            <td> Apellido Materno </td>
                    <td> Nombres </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td><input type="text" size="20" name="apellidopat" value="<? echo $apellidopat ?>" /></td>
    	            <td> <input type="text" size="20" name="apellidomat" value="<? echo $apellidomat ?>" /> </td>
                    <td> <input type="text" size="35" name="nombres" value="<? echo $nombres ?>" /> </td> 
					<td> <input type="submit" value="Buscar"  /> </td>
					<td>&nbsp;</td>
				</tr>
            	<tr height="9px">

            	</tr>

          </table>
	
			<?
        
            if ($apellidopat <> '' or $apellidomat <> '' or $nombres <> '' or $rut <> '' or $nroficha <> '')
            {
            	$botonactivado = "";
            	$desdemas = $desde + $largo;
            	$desdemenos = $desde - $largo;
            
				if ($apellidopat <> '' or $apellidomat <> '' or $nombres <> ''){
			
            		$sqltot = "SELECT * FROM paciente where apellidopat LIKE '$apellidopat%' and apellidomat LIKE '$apellidomat%' and nombres LIKE '$nombres%'";
                	$sql = "SELECT * FROM paciente where apellidopat LIKE '$apellidopat%' and apellidomat LIKE '$apellidomat%' and nombres LIKE '$nombres%' LIMIT $desde, $largo";
				} else if ($rut <> '') {
					$sqltot = "SELECT * FROM paciente where rut = ".$rut;
					$sql = "SELECT * FROM paciente where rut = ".$rut. " LIMIT $desde, $largo";
				} else if ($nroficha <> '') {
					$sqltot = "SELECT * FROM paciente where nroficha = ".$nroficha;
					$sql = "SELECT * FROM paciente where nroficha = ".$nroficha. " LIMIT $desde, $largo";
				}
				
            	mysql_connect ('10.6.21.29','usuario','hospital');
            	mysql_select_db('paciente') or die('Cannot select database');
            	$query = mysql_query($sql) or die(mysql_error());
            	$querytot = mysql_query($sqltot) or die(mysql_error());
            
            	$totalreg = mysql_num_rows($querytot);
			
				if ($totalreg == $largo) {
					$totalpag = 1;
				} else {
					$totalpag = $totalreg/$largo;
					$totalpag=floor($totalpag)+1;
            	}
			
				if ($totalreg > 0 ) {
					
            ?>
            
			<table id="demo_table" cellpadding="3" cellspacing="0" border="1" width="100%" align="center">
                
                    	<th colspan="5">
                        	<input type="button" value=" << " onClick="window.location.href='<? echo"buscarPaciente.php?apellidopat=$apellidopat&apellidomat=$apellidomat&nombres=$nombres&desde=$desdemenos&totalreg=$totalreg&urlLlamada=$urlLlamada"; ?>'; parent.GB_hide(); " <? if ($desde == 0) {  echo "disabled='disabled'";  }   ?> > 
                        	Indice de Pacientes Página <? echo $nropagina."/".$totalpag ?>
                        	<input type="button" value=" >> " onClick="window.location.href='<? echo"buscarPaciente.php?apellidopat=$apellidopat&apellidomat=$apellidomat&nombres=$nombres&desde=$desdemas&totalreg=$totalreg&urlLlamada=$urlLlamada"; ?>'" <? if ($totalpag == $nropagina) { echo "disabled='disabled'"; }   ?> >
                            
                            
                        </th>
                    </tr>
            
                    <tr bgcolor="#666666" style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif">
                    	<th width="4%" >Nro</th>
                        <th width="37%">Apellido Paterno</th>
                        <th width="33%">Apellido Materno</th>
                        <th width="18%">Nombres</th>
                    	<th width="8%">Rut</th>
                    </tr>
            
                        <?
                        while($pacientes = mysql_fetch_array($query)){
                            $desde++;
            
                            $rut = $pacientes['rut'];
							$id = $pacientes['id'];
                            ?>
                            
                            <tr style="font-size:10px; cursor:pointer; font-family:Verdana, Arial, Helvetica, sans-serif" onClick="javascript: window.location.href='<? echo "$urlLlamada?pacId=$id&act=pac"; ?>';">
                            
                            <?
                                echo "<td align=\"right\">".$desde."</td>";
                                echo "<td>".$pacientes['apellidopat']."</td>";
                                echo "<td>".$pacientes['apellidomat']."</td>";
                                echo "<td>".$pacientes['nombres']."</td>";
                                echo "<td>".$pacientes['rut']."</td>";
                            echo "</tr>";
                                  
                        } 
                        ?>       
            
                    <tr><td align="right">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
				<table width="100%" align="center">
                	<tr>
	               	<td width="92%" style="text-align:center"> <? echo $totalreg ?> Registros encontrados , en <? echo $totalpag ?> Páginas.-	               	  </td>
	               	<td width="8%" align="center" style="text-align:center">&nbsp;</td>

            		</tr>
                </table>

        
              <script language="JavaScript">
                <!--
                    tigra_tables('demo_table', 2, 1, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                // -->
                </script>
            
            <? }
			 } ?>


          <input name="tipo_salida" type="hidden" id="tipo_salida" value="<?php echo $tipo_salida; ?>" />
	      <span style="text-align:center">
	      <?php /*?><input type="button" value="Nuevo" <?php echo $botonactivado; ?> 
                    onclick="javascript:document.location.href='indicepacientes2.php?act=2&tipo_salida=<?php echo $tipo_salida; ?>';" /><?php */?>
	      </span>
	    </fieldset>
	</form>
	</td>
   </tr>
  </table>
</body>
       
</html>
