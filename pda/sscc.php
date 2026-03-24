<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>

<style type="text/css">
A:link, A:visited, A:hover { text-decoration: none; color:#666666; }
</style>

</head>

<body bgcolor="#F6F6F6" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">

<?
include "../funciones/funciones.php";	


$fecha_hoy = date('d-m-Y');

	
	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database');
 
	$query = mysql_query("SELECT * FROM camas where cod_servicio = $servicio order by sala, cama") or die(mysql_error());

	echo"<a style='font-size:16px'>Pacientes Servicio Clinico de ".$desc_servicio."</a>";
	?>
 
 
    <?
	$sala = '0';
	
	$nro_salas = 0;
 	
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

	echo"<table width='220px' border='1' cellspacing='0' cellpadding='0' style='vertical-align:top'>";
	echo"<tr style='vertical-align:top'>";	
	
    while($camas = mysql_fetch_array($query)){
	
		if ($sala <> $camas['sala']){
			$nro_salas++;

			if ($sala <>'0'){
				echo"</table>";
				echo"<table width='220px' border='1' cellspacing='0' cellpadding='0' style='vertical-align:top'>";
				echo"<tr style='vertical-align:top'>";	
			}
			echo"<td bgcolor='#99CCFF'><a style='font-size:15px' >SALA ".$camas['sala']."</a></td>";

			$sala = $camas['sala'];
        }


		$id_cama = $camas['id'];
		$cama = $camas['cama'];
		$servicio = $camas['cod_servicio'];
		$sala = $camas['sala'];
		$desc_servicio = $camas['servicio'];
		$categorizacion_riesgo = $camas['categorizacion_riesgo'];
		$categorizacion_dependencia = $camas['categorizacion_dependencia'];
		$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;
		$sexo_paciente = $camas['sexo_paciente'];
		$estado = $camas['estado'];
		
		switch ($camas['estado']) {
			case 1:
				echo "<tr><td><a ><img src='img/cama-vacia.gif' /></a>";
				echo "Cama Desocupada <br>" ;
				echo "Cama ".$cama." </td></tr>";
				$camas_desocupadas ++;
 				break;
			case 2:
				$logo_cama = 'cama-sc';
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
				
				if ($sexo_paciente == 'F') { $logo_cama = $logo_cama.'-m.gif'; }
				else { $logo_cama = $logo_cama.'-h.gif'; }
							
				echo"<tr><td> <a href='pro1_categoriza.php?id_cama=$id_cama'><img border='0' src='img/".$logo_cama."' />";
				echo $camas['nom_paciente']."<br>" ;
				echo "Cama ".$cama." - Ingreso : ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br>" ;
				echo "Categorizacion : ".$categorizacion." ( ".cambiarFormatoFecha2($camas['fecha_categorizacion'])." )";
				echo "</a></td></tr>";
				$camas_ocupadas ++;
 				break;
			case 3:
				echo"<tr><td><img src='img/icono-sn.gif' /><br>";
				echo "Cama Bloqueada Desde: ".cambiarFormatoFecha2($camas['fecha_ingreso'])."<br>" ;
				echo "Cama ".$cama ;
				echo "Motivo : ".$camas['diagnostico1'] ;
				echo "</td></tr>";
				$camas_bloqueadas ++;
 				break;
		}
	}


	?> 

		<tr>
            <td>
                <table align='center' border="1" cellpadding="7px" cellspacing="2px">
                    <tr>
                        <td colspan="2">Detalle de Ocupaci�n</td>
                    </tr>
                    <tr>
                        <td align="left">Camas Ocupadas</td>
                        <td><? echo $camas_ocupadas ?></td>
                    </tr>
                    <tr>
                        <td align="left">Camas Desocuparas</td>
                        <td><? echo $camas_desocupadas ?></td>
                    </tr>
                    <tr>
                        <td align="left">Camas Bloqueadas</td>
                        <td><? echo $camas_bloqueadas ?></td>
                    </tr>
                </table>
        	</td>
        </tr>
        <tr>
        	<td>
                <table align='center' border="1" cellpadding="7px" cellspacing="2px">
                    <tr>
                        <td colspan="4">Resumen de Categorizaci�n</td>
                    </tr>
                    <tr>
                        <td bgcolor="#00CC33">A1=<? echo $tot_cat_a1 ?></td>
                        <td bgcolor="#FFFF00">B1=<? echo $tot_cat_b1 ?></td>
                        <td bgcolor="#FFCC33">C1=<? echo $tot_cat_c1 ?></td>
                        <td bgcolor="#FF0000">D1=<? echo $tot_cat_d1 ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#00CC33">A2=<? echo $tot_cat_a2 ?></td>
                        <td bgcolor="#FFFF00">B2=<? echo $tot_cat_b2 ?></td>
                        <td bgcolor="#FFCC33">C2=<? echo $tot_cat_c2 ?></td>
                        <td bgcolor="#FF0000">D2=<? echo $tot_cat_d2 ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#00CC33">A3=<? echo $tot_cat_a3 ?></td>
                        <td bgcolor="#FFFF00">B3=<? echo $tot_cat_b3 ?></td>
                        <td bgcolor="#FFCC33">C3=<? echo $tot_cat_c3 ?></td>
                        <td bgcolor="#FF0000">D3=<? echo $tot_cat_d3 ?></td>
                    </tr>
                </table>
			</td>
		</tr>
    </table>

</body>
</html>


