<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


    <script>setTimeout('document.location.reload()',1000000); </script>


</head>

<body>



<?


$fecha_hoy = date('d-m-Y');

$hora_hoy = date('H:i');

$p_ok = 0;
$p_mal = 0;

$o_ok = 0;
$o_mal = 0;

$r_ok = 0;
$r_mal = 0;




//definimos el path de acceso
$path = "../omega/txt/";

//abrimos el directorio
$dir = opendir($path);


//Mostramos las informaciones
while ($elemento = readdir($dir))
{
	if ($elemento <> "." and $elemento <> "..")
	{
		$archivo_plano = $elemento;

//		echo $archivo_plano;
		
		$row = 1; 
		$fp = fopen ("../omega/txt/".$archivo_plano,"r"); 
		while ($data = fgetcsv ($fp, 1000, "|"))
		
		{ 
		
			if ($data[0] == "P")
			{
		
				$solicitud_examen = $data[2];
		
				$rut              = explode("-", $data[3]);
				$rut_paciente     = $rut[0];
				
				$medico           = explode("^", $data[13]);
				$cod_medico       = $medico[0]; 
				$nomb_medico      = $medico[1];
		
				$f_regis_f_extrac = explode("^", $data[23]);
				$fecha_registro   = $f_regis_f_extrac[0]; 
				$fecha_extraccion = $f_regis_f_extrac[1];
				
				$prioridad        = $data[24];
		
				$solicitante      = explode("^", $data[27]);
				$cod1_solicitante  = $solicitante[0];
				$cod2_solicitante  = $solicitante[1];
				$desc_solicitante  = $solicitante[2];
				$tipo_solicitante  = $solicitante[3];
		
				$servicio          = explode("^", $data[33]);
				$cod_servicio      = $servicio[0];
				$desc_servicio     = $servicio[2];
		
		
				/*
				echo "entre a P";
				echo "<br>";
				echo "solicitud Examen: ".$solicitud_examen;
				echo "<br>";
				echo "Rut Paciente: ".$rut_paciente;
				echo "<br>";
				echo "Codigo Medico: ".$cod_medico;
				echo "<br>";
				echo "Nombre Medico: ".$nomb_medico;
				echo "<br>";
				echo "Fecha Registro y Extraccion: ".$f_regis_f_extrac;
				echo "<br>";
				echo "Fecha Registro: ".$fecha_registro; 
				echo "<br>";
				echo "Fecha Extraccion: ".$fecha_extraccion;
				echo "<br>";
				echo "Prioridad: ".$prioridad;
				echo "<br>";
				echo "Codigo 1 Solicitante: ".$cod1_solicitante;
				echo "<br>";
				echo "Codigo 2 Solicitante: ".$cod2_solicitante;
				echo "<br>";
				echo "Descripcion Solicitante: ".$desc_solicitante;
				echo "<br>";
				echo "tipo_solicitante: ".$tipo_solicitante;
				echo "<br>";
				echo "Codigo Servicio: ".$cod_servicio;
				echo "<br>";
				echo "Descripcion Servicio: ".$desc_servicio;
				echo "<br>";
				*/
				
				$sql = "SELECT * FROM controllaboratorio where solicitud_examen = '".$solicitud_examen."'";
				mysql_connect ('10.6.21.29','usuario','hospital');
				mysql_select_db('paciente') or die('Cannot select database');
				$query = mysql_query($sql) or die(mysql_error());
				
				$examen = mysql_fetch_array($query);
				
				if ($examen)
				{
					$resultado_p = mysql_query( "UPDATE controllaboratorio SET
					rut_paciente     = $rut_paciente,
					cod_medico       = $cod_medico,
					nomb_medico      = '$nomb_medico',
					fecha_registro   = '$fecha_registro',
					fecha_extraccion = '$fecha_extraccion',
					prioridad        = '$prioridad',
					cod1_solicitante = '$cod1_solicitante',
					cod2_solicitante = '$cod2_solicitante',
					desc_solicitante = '$desc_solicitante',
					tipo_solicitante = '$tipo_solicitante',
					cod_servicio     = '$cod_servicio',
					desc_servicio    = '$desc_servicio',
					archivo_plano    = '$archivo_plano'
					WHERE solicitud_examen = $solicitud_examen "  );
				}
				else
				{
					$resultado_p = mysql_query( "INSERT INTO controllaboratorio
					( 
					solicitud_examen, 
					rut_paciente,
					cod_medico, 
					nomb_medico,
					fecha_registro,
					fecha_extraccion,
					prioridad,
					cod1_solicitante,
					cod2_solicitante,
					desc_solicitante,
					tipo_solicitante,
					cod_servicio,
					desc_servicio,
					archivo_plano
					)
					VALUES
					( 
					$solicitud_examen,
					$rut_paciente,
					$cod_medico,
					'$nomb_medico',
					'$fecha_registro',
					'$fecha_extraccion',
					'$prioridad',
					'$cod1_solicitante',
					'$cod2_solicitante',
					'$desc_solicitante',
					'$tipo_solicitante',
					'$cod_servicio',
					'$desc_servicio',
					'$archivo_plano'
					) ");
				}
				
				if ($resultado_p) { $p_ok++; }	else { $p_mal++;
					echo "<br>";
					echo "(solicitud_examen : ".$solicitud_examen.")-
					(Rut Paciente : ".$rut_paciente.")-
					(cod_medico : ".$cod_medico.")-
					(nomb_medico : ".$nomb_medico.")-
					(fecha_registro : ".$fecha_registro.")-
					(fecha_extraccion : ".$fecha_extraccion.")-
					(prioridad : ".$prioridad.")-
					(cod1_solicitante : ".$cod1_solicitante.")-
					(cod2_solicitante : ".$cod2_solicitante.")-
					(desc_solicitante : ".$desc_solicitante.")-
					(tipo_solicitante : ".$tipo_solicitante.")-
					(cod_servicio : ".$cod_servicio.")-
					(desc_servicio : ".$desc_servicio.")-
					(archivo_plano : ".$archivo_plano.")";


					mysql_connect ('10.6.21.29','usuario','hospital');
					mysql_select_db('paciente') or die('Cannot select database');
					$resultado_p = mysql_query( "INSERT INTO errores_omega
					( archivo_plano	) VALUES ( '$archivo_plano'	) ");


				}
//			echo "<br>";
			
			}
		
			if ($data[0] == "O")
			{
		
				$numero_orden = $data[1];
				$prueba           = explode("^", $data[4]);
				$prestacion       = $prueba[3];
				$tipo_prueba      = $prueba[7];
				$desc_prestacion  = $prueba[9];
				
				$prueba           = explode("^", $data[15]);
				$cod_muestra      = $prueba[0];
				$desc_muestra     = $prueba[1];
				
				$prueba           = explode("^", $data[18]);
				$cod_seccion      = $prueba[0];
				$desc_seccion     = $prueba[1];
				
				$prueba           = explode("^", $data[20]);
				$cod_tiposeccion  = $prueba[0];
				$desc_tiposeccion = $prueba[1];
				
				$estado_prueba    = $data[25];
				
		
				/*
				echo "entre a O";
				echo "<br>";
				echo "solicitud Examen: ".$solicitud_examen;
				echo "<br>";
				echo "Numero Orden: ".$numero_orden;
				echo "<br>";
				echo "Prestacion: ".$prestacion;
				echo "<br>";
				echo "Tipo Prueba: ".$tipo_prueba;
				echo "<br>";
				echo "Descrip. Prestacion: ".$desc_prestacion;
				echo "<br>";
				echo "Codigo Muestra: ".$cod_muestra; 
				echo "<br>";
				echo "Codigo Seccion: ".$cod_seccion;
				echo "<br>";
				echo "Estado de Prueba: ".$estado_prueba;
				echo "<br>";
				*/
				
				
				$sql = "SELECT * FROM prestacioneslaboratorio where solicitud_examen = '".$solicitud_examen."' and numero_orden = '".$numero_orden."'";
				mysql_connect ('10.6.21.29','usuario','hospital');
				mysql_select_db('paciente') or die('Cannot select database');
				$query = mysql_query($sql) or die(mysql_error());
				
				$examen = mysql_fetch_array($query);
				
				if ($examen)
				{
					$resultado_o = mysql_query( "UPDATE prestacioneslaboratorio SET 
					prestacion      = $prestacion,
					tipo_prueba     = '$tipo_prueba',
					desc_prestacion = '$desc_prestacion',
					cod_muestra     = $cod_muestra,
					desc_muestra    = '$desc_muestra',
					cod_seccion     = '$cod_seccion',
					desc_seccion    = '$desc_seccion',
					cod_tiposeccion = '$cod_tiposeccion',
					desc_tiposeccion= '$desc_tiposeccion',
					estado_prueba   = '$estado_prueba'
					WHERE solicitud_examen = $solicitud_examen and numero_orden = $numero_orden"  );
				}
				else
				{
					$resultado_o = mysql_query( "INSERT INTO prestacioneslaboratorio
					( 
					solicitud_examen, 
					numero_orden,
					prestacion,
					tipo_prueba,
					desc_prestacion,
					cod_muestra,
					desc_muestra,
					cod_seccion,
					desc_seccion,
					cod_tiposeccion,
					desc_tiposeccion,
					estado_prueba
					)
					VALUES
					(
					$solicitud_examen,
					$numero_orden,
					$prestacion,
					'$tipo_prueba',
					'$desc_prestacion',
					$cod_muestra,
					'$desc_muestra',
					'$cod_seccion',
					'$desc_seccion',
					'$cod_tiposeccion',
					'$desc_tiposeccion',
					'$estado_prueba'
					) ");
				}
				
				if ($resultado_o) { $o_ok++; }	else { $o_mal++;

					echo "<br>";
					echo "(solicitud_examen : ".$solicitud_examen.")-
					(numero_orden : ".$numero_orden.")-
					(prestacion : ".$prestacion.")-
					(tipo_prueba : ".$tipo_prueba.")-
					(desc_prestacion : ".$desc_prestacion.")-
					(cod_muestra : ".$cod_muestra.")-
					(desc_muestra : ".$desc_muestra.")-
					(cod_seccion : ".$cod_seccion.")-
					(desc_seccion : ".$desc_seccion.")-
					(cod_tiposeccion : ".$cod_tiposeccion.")-
					(desc_tiposeccion : ".$desc_tiposeccion.")-
					(estado_prueba : ".$estado_prueba.")";
					
					mysql_connect ('10.6.21.29','usuario','hospital');
					mysql_select_db('paciente') or die('Cannot select database');
					$resultado_p = mysql_query( "INSERT INTO errores_omega
					( archivo_plano	) VALUES ( '$archivo_plano'	) ");
					
				}
//			echo "<br>";
		
			}
		
			if ($data[0] == "R")
			{
		
				$numero_resultado   = $data[1];
				$resultado          = $data[3];
				$unidades           = $data[4];
				$referencia         = $data[5];
				$marca_patologia    = $data[6];
				$tipo_resultado     = $data[8];
				$usuario_validacion = $data[10];
				$fecha              = $data[11];
		
				/*
				echo "entre a R";
				echo "<br>";
				echo "Resultado: ".$resultado;
				echo "<br>";
				echo "Unidades: ".$unidades;
				echo "<br>";
				echo "Referencia: ".$referencia;
				echo "<br>";
				echo "Marca Patologia: ".$marca_patologia;
				echo "<br>";
				echo "Tipo Resultado: ".$tipo_resultado;
				echo "<br>";
				echo "Usuario Validacion: ".$usuario_validacion; 
				echo "<br>";
				echo "Fecha: ".$fecha; 
				echo "<br>";
		
				*/
		
				$sql = "SELECT * FROM resultadoslaboratorio where solicitud_examen = '".$solicitud_examen."' and numero_orden = '".$numero_orden."' and numero_resultado = '".$numero_resultado."'";
				mysql_connect ('10.6.21.29','usuario','hospital');
				mysql_select_db('paciente') or die('Cannot select database');
				$query = mysql_query($sql) or die(mysql_error());
				
				$examen = mysql_fetch_array($query);
				
				if ($examen)
				{
					$resultado_r = mysql_query( "UPDATE resultadoslaboratorio SET 
					resultado          = '$resultado',
					unidades           = '$unidades',
					referencia         = '$referencia',
					marca_patologia    = '$marca_patologia',
					tipo_resultado     = '$tipo_resultado',
					usuario_validacion = '$usuario_validacion',
					fecha              = '$fecha'
					WHERE solicitud_examen = $solicitud_examen and numero_orden = $numero_orden and numero_resultado = $numero_resultado"  );
				}
				else
				{
					$resultado_r = mysql_query( "INSERT INTO resultadoslaboratorio
					( 
					solicitud_examen, 
					numero_orden,
					numero_resultado,
					resultado,
					unidades,
					referencia,
					marca_patologia,
					tipo_resultado,
					usuario_validacion,
					fecha
					)
					VALUES
					(
					$solicitud_examen,
					$numero_orden,
					$numero_resultado,
					'$resultado',
					'$unidades',
					'$referencia',
					'$marca_patologia',
					'$tipo_resultado',
					'$usuario_validacion',
					'$fecha'
					) ");
				}

				if ($resultado_r) { $r_ok++; }	else { $r_mal++;
				
					echo "<br>";
					echo "(solicitud_examen : ".$solicitud_examen.")-
					(numero_orden : ".$numero_orden.")-
					(numero_resultado : ".$numero_resultado.")-
					(resultado : ".$resultado.")-
					(unidades : ".$unidades.")-
					(referencia : ".$referencia.")-
					(marca_patologia : ".$marca_patologia.")-
					(tipo_resultado : ".$tipo_resultado.")-
					(usuario_validacion : ".$usuario_validacion.")-
					(fecha : ".$fecha.")";

					mysql_connect ('10.6.21.29','usuario','hospital');
					mysql_select_db('paciente') or die('Cannot select database');
					$resultado_p = mysql_query( "INSERT INTO errores_omega
					( archivo_plano	) VALUES ( '$archivo_plano'	) ");

				}
//			echo "<br>";
		
			}

/*

				?>
				<tr>
				<td>
				<?
				
				$num = count ($data); 
				print "<p> $num fields in line $row: <br />"; 
				$row++; 
				
				?>
				</td>
				<?
				
				for ($c=0; $c<$num; $c++) { 
				
					?>
					<td>
					<?
					print $data[$c] . "<br />"; 
					
					?>
					</td>
					<?
					
				}
				
				?>
				</tr>
				<?
*/			
			
		} 
		



		fclose ($fp);
		
		unlink("../omega/txt/".$archivo_plano);
		
		
//		echo "</table>";

	}
}

echo $fecha_hoy;
echo "<br>";
echo $hora_hoy;
echo "<br>";

echo "P OK  = ".$p_ok;
echo "<br>";
echo "P MAL = ".$p_mal;
echo "<br>";
echo "O OK  = ".$o_ok;
echo "<br>";
echo "O MAL = ".$o_mal;
echo "<br>";
echo "R OK  = ".$r_ok;
echo "<br>";
echo "R MAL = ".$r_mal;
echo "<br>";


//Cerramos el directorio
closedir($dir);

?>

</body>
</html>