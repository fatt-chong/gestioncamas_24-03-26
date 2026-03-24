<?php

if (!isset($_SESSION)) {
  session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Busqueda de Pacientes</title>
    <link type="text/css" rel="stylesheet" href="css/estilo.css" />
    
    <script language="JavaScript" src="../tablas/tigra_tables.js"></script>

	<script type="text/javascript">
        onload = focusIt;
        function focusIt()
        {
          document.busca_paciente.apellidopat.focus();
        }
    </script>

</head>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" background="img/fondo.jpg" bgcolor="#EAF5FF">

<div align="center">

	<?

//	<a class='titulo'> Hospitalización de Paciente </a>


    if ($desde == '')
    {
    $desde = 0;
    }

	$largo = 10;
    
	$nropagina = ($desde / $largo) + 1;

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];

    
	?>
	<form name="busca_paciente" method="get" action="busquedapacientes2.php">
	
	    <fieldset class="fieldset_det2"><legend>Busqueda de Paciente</legend>

        	<table width="90%" border="0" cellspacing="1" cellpadding="1" align="center">
            	<tr height="5px">

            	</tr>
            	<tr>
                	<td width="20px">&nbsp;</td>
                	<td> Apellido Paterno </td>
    	            <td> Apellido Materno </td>
                    <td> Nombres </td>
                </tr>
                <tr>
                	<td> </td>
                	<td> <input type="text" size="27" name="apellidopat" value="<? echo $apellidopat ?>" /> </td>
    	            <td> <input type="text" size="27" name="apellidomat" value="<? echo $apellidomat ?>" /> </td>
                    <td> <input type="text" size="40" name="nombres" value="<? echo $nombres ?>" /> </td> 
					<td> <input type="submit" value="  Buscar  "  /> </td>
				</tr>
            	<tr height="9px">

            	</tr>

            </table>
	
			<?
        
            if ($apellidopat <> '' or $apellidomat <> '' or $nombres <> '')
            {
            
            $desdemas = $desde + $largo;
            $desdemenos = $desde - $largo;
            
            $sqltot = "SELECT * FROM paciente where apellidopat LIKE '$apellidopat%' and apellidomat LIKE '$apellidomat%' and nombres LIKE '$nombres%'";
            
            $sql = "SELECT * FROM paciente where apellidopat LIKE '$apellidopat%' and apellidomat LIKE '$apellidomat%' and nombres LIKE '$nombres%' LIMIT $desde, $largo";
            
            mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
            mysql_select_db('paciente') or die('Cannot select database');
            $query = mysql_query($sql) or die(mysql_error());
            $querytot = mysql_query($sqltot) or die(mysql_error());
            
            $totalreg = mysql_num_rows($querytot);
			
			if ($totalreg == $largo)
			{
				$totalpag = 1;
						
			}
			else
			{
				$totalpag = $totalreg/$largo;
				$totalpag=floor($totalpag)+1;
            }
            ?>
            
                <table id="demo_table" cellpadding="3" cellspacing="0" border="1" width="90%" align="center">
                
                    	<th colspan="5">
                        	<input type="button" value=" << " onClick="window.location.href='<? echo"busquedapacientes2.php?apellidopat=$apellidopat&apellidomat=$apellidomat&nombres=$nombres&desde=$desdemenos&totalreg=$totalreg"; ?>'; parent.GB_hide(); " <? if ($desde == 0) {  echo "disabled='disabled'";  }   ?> > 
                        	Indice de Pacientes Página <? echo $nropagina."/".$totalpag ?>
                        	<input type="button" value=" >> " onClick="window.location.href='<? echo"busquedapacientes2.php?apellidopat=$apellidopat&apellidomat=$apellidomat&nombres=$nombres&desde=$desdemas&totalreg=$totalreg"; ?>'; parent.GB_hide(); " <? if ($totalpag == $nropagina) { echo "disabled='disabled'"; }   ?> >
                        </th>
                    </tr>
            
                    <tr style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif"><th>Nro</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombres</th><th>Rut</th></tr>
            
                        <?
                        while($pacientes = mysql_fetch_array($query)){
                            $desde++;
            
                            $rut = $pacientes['rut'];
                            $idpaciente = $pacientes['id'];
                            ?>
                            
                            <tr style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
                            onClick="window.location.href='<? echo"../ingresos/pro2_modificapaciente.php?tipodocumento=5&doc_paciente=$idpaciente"; ?>'; parent.GB_hide(); ">
                            
                            <?
                                echo "<td>".$desde."</td>";
                                echo "<td>".$pacientes['apellidopat']."</td>";
                                echo "<td>".$pacientes['apellidomat']."</td>";
                                echo "<td>".$pacientes['nombres']."</td>";
                                echo "<td>".$pacientes['rut']."</td>";
                            echo "</tr>";
            //				window.location.href='pro1_ingresopaciente.php?id_cama=$id_cama&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado%rut=$pacientes['rut']'; '; parent.parent.GB_hide();
                            
                        } 
                        ?>       
            
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                </table>
				<table width="90%" align="center">
                	<tr>
	               	<td style="text-align:center"> <? echo $totalreg ?> Registros encontrados , en <? echo $totalpag ?> Páginas.- </td>
            		</tr>
                </table>

        
                <script language="JavaScript">
                <!--
                    tigra_tables('demo_table', 2, 1, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                // -->
                </script>
            
            <? } ?>


        </fieldset>
                    
		<input type="Button" value="        Cancelar        " onClick="window.location.href='<? echo"../ingresos/pro1_modificapaciente.php"; ?>'; parent.GB_hide(); " >	
        
	</form>



</div>

</body>
        
</html>
