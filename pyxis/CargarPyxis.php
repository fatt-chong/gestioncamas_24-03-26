<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carga Pyxis</title>

    <script>setTimeout('document.location.reload()',1000000); </script>

</head>
<body>

<?php 
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

	  switch ($theType) {
	    case "text":
	      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	      break;    
	    case "long":
	    case "int":
	      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	      break;
	    case "double":
	      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	      break;
	    case "date":
	      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	      break;
	    case "defined":
	      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
    	  break;
	  }
	  return $theValue;
	}

	// ------------------------------------ Datos del Servidor
    $ftp_server = "10.6.18.95";
    $conn_id = ftp_connect($ftp_server, 21, 1) or die("N"); 
	$login_result = ftp_login($conn_id, "pyxis", "b4uleave!2");
	// --------------------------------------------------------

	// Recupero la lista de los archivos contenidos en el directorio
	$archivos = ftp_nlist($conn_id, ".");

	for( $i = 0; $i < count($archivos); $i ++) {
		
		$extension = substr($archivos[$i],18,3);
		if ($extension == 'unl'){
			// sacamos el archivo y lo copiamos en nuestra carpeta local
			ftp_get($conn_id, "d:/pyxis/".$archivos[$i], $archivos[$i], FTP_BINARY);
			
			// Leemos cada archivo y lo procesamos
			$fp = fopen ("d:/pyxis/".$archivos[$i],"r");

    		$flag = 1;
			while ($data = fgetcsv ($fp, 1000, "|")) {
			
				$cabecera = $data[0];
				$correlativo = $data[1];
				$rutpaciente = $data[2];
				$ctacte = $data[3];
				$paciecod = $data[4];
				$fechatransferencia =  $data[5];
				$codigoproducto =  $data[6];
				$cantidad =  $data[7];
				$nombremaquina = $data[8];
				$correlativotransaccion =  $data[9];
				$tipo =  $data[10];
				$codservicio =  $data[14];
				
				
				if($codservicio == 10322){

					$bodega = 'P001';
					$tipoegreso = 'U';
										
					// Recuperamos el RAU asociado a la Cuenta Corriente del Paciente
					$rau = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
					mysql_select_db('rau', $rau);
					$query_rs_rau = sprintf("SELECT rau.idrau FROM rau WHERE rau.idctacte = %s", GetSQLValueString($ctacte, "int"));
					$rs_rau = mysql_query($query_rs_rau, $rau) or die(mysql_error());
					$row_rs_rau = mysql_fetch_assoc($rs_rau);
					$totalRowsrsrau = mysql_num_rows($rs_rau);
					$numeroreceta = $row_rs_rau['idrau'];
				}
				else
				{
					$tipoegreso = 'C';
					// Recuperamos el ultimo Id de farmacos
					if(($codservicio == 10320) || ($codservicio == 10321)){
						$bodega = 'P002';
					}
					
					if($codservicio == 10341){
						$bodega = 'P003';
					}
										
					$farmacos = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
					mysql_select_db('farmacos', $farmacos);
					$query_rs_farmacos = sprintf("SELECT Max(egreId) as id FROM egresos WHERE tipoEgreId = 'C'");
					$rs_farmacos = mysql_query($query_rs_farmacos, $farmacos) or die(mysql_error());
					$row_rs_farmacos = mysql_fetch_assoc($rs_farmacos);
					
					$numeroreceta = $row_rs_farmacos['id'] + 1;
					$flag = 0;
				}
					

					// Extraemos el nombre del producto utilizado mas adelante para insertalo en egredetalle
					$aba = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
					mysql_select_db('aba', $aba);
				
					$query_rs_producto = sprintf("SELECT producto.produNombre, producto.umediCod, producto.produprecio FROM producto WHERE producto.produCodInt = %s",
					                              GetSQLValueString($codigoproducto, "text"));
					$rs_producto = mysql_query($query_rs_producto, $aba) or die(mysql_error());
					$row_rs_producto = mysql_fetch_assoc($rs_producto);
					$nombreproducto = $row_rs_producto['produNombre'];
					$umedida = $row_rs_producto['umediCod'];
					$produprecio = $row_rs_producto['produprecio'];
					$produvalor = $produprecio * $cantidad;
			

					// Cargo de farmaco para el paciente
					if ($tipo == 'C') {
									
						// Revisamos si existe Cabecera de la Receta para el RAU en proceso
						$farmacos = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
						mysql_select_db('farmacos', $farmacos);
						
						$query_rs_farmaco = sprintf("SELECT egresos.egreId FROM egresos WHERE egresos.egreId = %s AND egresos.tipoEgreId = %s",
									GetSQLValueString($numeroreceta, "int"),
									GetSQLValueString($tipoegreso, "text"));

						$rs_farmaco = mysql_query($query_rs_farmaco, $farmacos) or die(mysql_error());
						$row_rs_farmaco = mysql_fetch_assoc($rs_farmaco);
						$totalRowsrsfarmaco = mysql_num_rows($rs_farmaco);
				
						// Si no existe cabecera se debe crear la cabecera de la Receta de Farmacia.
						if ($totalRowsrsfarmaco == 0) {
						
							// Insertamos la Cabecera de la Receta
							$query_rs_insert_receta = sprintf("insert into egresos(egresos.egreId,egresos.tipoEgreId,egresos.egrepreCod,egresos.egrefechaQuimio,egresos.egreObservacion,egresos.egreGes,
													   egresos.egrepacRut,egresos.egreFicha,egresos.egreCtaCte,egresos.pacId,egresos.egreFecha,egresos.egrebodegCod,egresos.egreserviCod,egresos.egrecentrCod,
													   egresos.camasid,egresos.egrepatCodigo,egresos.pabellon,egresos.egrePrevid,egresos.egreFolioGes) 
													   values(%s,%s,'','1000-01-01',0,'',%s,0,%s,%s,%s,%s,%s,103,0,0,0,0,0)",
											  GetSQLValueString($numeroreceta, "int"),
											  GetSQLValueString($tipoegreso, "text"),
											  GetSQLValueString($rutpaciente, "int"),
											  GetSQLValueString($ctacte, "int"),
											  GetSQLValueString($paciecod, "int"),
											  GetSQLValueString($fechatransferencia, "date"),
											  GetSQLValueString($bodega, "text"),
											  GetSQLValueString($codservicio, "int"));
							$rs_receta = mysql_query($query_rs_insert_receta, $farmacos) or die(mysql_error());	
						
						} 
				
						// Insertamos el farmaco en egresodetalle
						$egresodetalle = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
						mysql_select_db('farmacos', $egresodetalle);
						
						
						// Reviso primero si ya existe el farmaco en la receta
						$query_rs_egreso = sprintf("SELECT egresosdetalle.egreId FROM egresosdetalle 
				                             WHERE egresosdetalle.egreId = %s AND egresosdetalle.tipoEgreId = %s AND egresosdetalle.produCodInt = %s",
									GetSQLValueString($numeroreceta, "int"),
									GetSQLValueString($tipoegreso, "text"),
									GetSQLValueString($codigoproducto, "text"));

						$rs_egreso = mysql_query($query_rs_egreso, $egresodetalle) or die(mysql_error());
						$row_rs_egreso = mysql_fetch_assoc($rs_egreso);
						$totalRowsrsegreso = mysql_num_rows($rs_egreso);												

						// agregamos el farmaco
						if ($totalRowsrsegreso == 0 ) {  
						
							if ( $tipoegreso == 'U' ) {
								$produvalor = 0;
							}
						 
							$query_rs_insert_farmaco = sprintf("insert into egresosdetalle(egresosdetalle.egreId,egresosdetalle.tipoEgreId,egresosdetalle.produCodInt,egresosdetalle.produCodEmb,
					                                    egresosdetalle.egreciclo,egresosdetalle.egreDosis,egresosdetalle.egreSuero,egresosdetalle.egrePreparacion,egresosdetalle.egrevolumen,
														egresosdetalle.egreDevuelto,egresosdetalle.egreCantidad,egresosdetalle.bodegCod,egresosdetalle.serviCod,egresosdetalle.centrCod,
														egresosdetalle.egreSolicitado,egresosdetalle.egreDespachado,egresosdetalle.egrePacId,egresosdetalle.egreCtacteCod,egresosdetalle.egreValor,
														egresosdetalle.egreTipoAtencion,egresosdetalle.egreCancelado,egresosdetalle.egreproduNombre,egresosdetalle.egreumediCod,egresosdetalle.egreFecha2,
														egresosdetalle.egreserviCod2,egresosdetalle.egrepreciototal1,egresosdetalle.egreFechaCancelacion,egresosdetalle.egreRecCod,egresosdetalle.egreSaldo,
														egresosdetalle.egreDevolucion,egresosdetalle.egreAbonoRec,egresosdetalle.egreFechaDetalle,egresosdetalle.egreLaboratorio) 
														values(%s,%s,%s,'',0,0,0,0,0,0,%s,%s,%s,103,%s,%s,%s,%s,%s,%s,'N',%s,%s,'1000-01-01',0,0,'1000-01-01',0,0,0,0,'1000-01-01',0)",			
							 GetSQLValueString($numeroreceta, "int"),
							 GetSQLValueString($tipoegreso, "text"),
							 GetSQLValueString($codigoproducto, "text"),
							 GetSQLValueString($cantidad, "int"),
							 GetSQLValueString($bodega, "text"),
							 GetSQLValueString($codservicio, "int"),
							 GetSQLValueString($cantidad, "int"),
							 GetSQLValueString($cantidad, "int"),
							 GetSQLValueString($paciecod, "int"),
							 GetSQLValueString($ctacte, "int"),
							 GetSQLValueString($produvalor, "int"),
							 GetSQLValueString($tipoegreso, "text"),
							 GetSQLValueString($nombreproducto, "text"),
							 GetSQLValueString($umedida, "text"));
							$rs_farmaco = mysql_query($query_rs_insert_farmaco, $egresodetalle) or die(mysql_error());	
							
						} else {   // Actualizamos la cantidad

							$update_egreso = sprintf("update egresosdetalle 
							                          Set egresosdetalle.egreCantidad =  egresosdetalle.egreCantidad + %s,
							                              egresosdetalle.egreSolicitado = egresosdetalle.egreSolicitado + %s 
				                                      WHERE egresosdetalle.egreId = %s AND egresosdetalle.tipoEgreId = %s AND egresosdetalle.produCodInt = %s",
									GetSQLValueString($cantidad, "int"),
									GetSQLValueString($cantidad, "int"),
									GetSQLValueString($numeroreceta, "int"),
									GetSQLValueString($tipoegreso, "text"),
									GetSQLValueString($codigoproducto, "text"));		
							$rs_update = mysql_query($update_egreso, $egresodetalle) or die(mysql_error());					
						}

						//Rebajar stock bodega
						ActualizarStockBodega($cantidad * -1, $codigoproducto, $bodega, $codservicio);
						
						//Obtener Correlativo para SALIDA
						$Anio_Numero = ObtenerCorrelativo('BINCARD');
						$separar = explode('|',$Anio_Numero);
						$paramAnio = $separar[0];
						$salidNumero = $separar[1];						
						
						//Generar Bincard Bodega Destino
						GenerarBincard($codigoproducto, $umedida, $fechatransferencia, '07', 103, $paramAnio, $salidNumero, '', 0, 0, 0, $bodega, 'Reposicion automatica', 1000, 0, $cantidad, 0, 'S', 0, 103, $bodega, 10333, date("h:i"), 'admin');	
											
									
					} else {  // No es Cargo, es Devolución, en ese caso se debe eliminar el farmaco de la receta del paciente
				
						$delete = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
						mysql_select_db('farmacos', $delete);				
						$query_rs_delete_farmaco = sprintf("delete from egresosdetalle where egresosdetalle.egreId = %s AND egresosdetalle.tipoEgreId = %s AND egresosdetalle.produCodInt = %s",
								 GetSQLValueString($numeroreceta, "int"),
								 GetSQLValueString($tipoegreso, "text"),
								 GetSQLValueString($codigoproducto, "text"));
						$rs_delete_farmaco = mysql_query($query_rs_delete_farmaco, $delete) or die(mysql_error());			 					
							
						//Devolver stock bodega
						ActualizarStockBodega($cantidad, $codigoproducto, $bodega, $codservicio);
													
						//Obtener Correlativo para SALIDA
						$Anio_Numero = ObtenerCorrelativo('BINCARD');
						$separar = explode('|',$Anio_Numero);
						$paramAnio = $separar[0];
						$salidNumero = $separar[1];		
													
						GenerarBincard($codigoproducto, $umedida, $fechatransferencia, '04', 103, $paramAnio, $salidNumero, '', 0, 0, 0, $bodega, 'Reposicion automatica', 1000, $cantidad, 0, 0, 'E', 0, 103, $bodega, 10333, date("h:i"), 'admin');									
					} // fin tipo
 

			} // fin while
			
			// al final se debe borrar el archivo en el ftp
			ftp_delete($conn_id, $archivos[$i]);
		} // fin if extencion
	} // fin for
	
		
	// --------------------------------------------------------------------- Funciones para Abastecimiento - Generamos Bincard
	
	
	function GenerarBincard($bincaProduCodInt_, $bincaUmediCod_, $bincaFecha_, $tmoviCod_, $bincaDocGenMovCentro_, $bincaDocGenMovAnio_, $bincaDocGenMov_, $bincaDocGenTipo_, $bincaDocAsoMovCentro_, $bincaDocAsoMovAnio_, $bincaDocAsoMov_, $bincaBodegCod_, $bincaObs_, $bincaVUnitario_, $bincaEntradas_, $bincaSalidas_, $bincaSaldos_, $bincaTipo_, $proveRUT_, $bincaCentrCod_, $bincaBodegCodOri_, $bincaServiCod_, $bincaHora_, $bincaUsuarCod_){

		$Anio_Numero = ObtenerCorrelativo('BINCARD');
		$separar = explode('|',$Anio_Numero);
		$bincaAnio = $separar[0];
		$bincaNumMov = $separar[1];		
        $bincaUmediCod_ = ($bincaUmediCod_ != "") ? "'" . $bincaUmediCod_ . "'" : "UD";		
		
		$aba = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_select_db('aba', $aba);

		$query_rs_bincard = sprintf("INSERT INTO bincard(bincaAnio, bincaNumMov, bincaProduCodInt, bincaUmediCod, bincaFecha, tmoviCod, bincaDocGenMovCentro, bincaDocGenMovAnio, bincaDocGenMov, bincaDocGenTipo, bincaDocAsoMovCentro, bincaDocAsoMovAnio, bincaDocAsoMov, bincaBodegCod, bincaObs, bincaVUnitario, bincaEntradas, bincaSalidas, bincaSaldos, bincaTipo, proveRUT, bincaCentrCod, bincaBodegCodOri, bincaServiCod, bincaHora, bincaUsuarCod) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
															GetSQLValueString($bincaAnio, "int"),
															GetSQLValueString($bincaNumMov, "int"),
															GetSQLValueString($bincaProduCodInt_, "text"),
															GetSQLValueString($bincaUmediCod_, "text"),
															GetSQLValueString($bincaFecha_, "date"),
															GetSQLValueString($tmoviCod_, "text"),
    														GetSQLValueString($bincaDocGenMovCentro_, "int"),
															GetSQLValueString($bincaDocGenMovAnio_, "int"),
															GetSQLValueString($bincaDocGenMov_, "int"),
															GetSQLValueString($bincaDocGenTipo_, "text"),
															GetSQLValueString($bincaDocAsoMovCentro_, "int"),
															GetSQLValueString($bincaDocAsoMovAnio_, "int"),
															GetSQLValueString($bincaDocAsoMov_, "int"),
															GetSQLValueString($bincaBodegCod_, "text"),
															GetSQLValueString($bincaObs_, "text"),
															GetSQLValueString($bincaVUnitario_, "text"),
															GetSQLValueString($bincaEntradas_, "text"),
															GetSQLValueString($bincaSalidas_, "text"),
															GetSQLValueString($bincaSaldos_, "text"),
															GetSQLValueString($bincaTipo_, "text"),
															GetSQLValueString($proveRUT_, "text"),
															GetSQLValueString($bincaCentrCod_, "text"),
															GetSQLValueString($bincaBodegCodOri_, "text"),
															GetSQLValueString($bincaServiCod_, "text"),
															GetSQLValueString($bincaHora_, "text"),
															GetSQLValueString($bincaUsuarCod_, "text"));				
		$rs_query_rs_bincard = mysql_query($query_rs_bincard, $aba) or die(mysql_error());
//echo "<br>".$query_rs_bincard;
 	}
	
	// --------------------------------------------------------------------- Funciones para Abastecimiento - Generamos Bincard
	
	function ObtenerCorrelativo($documCod_){

		$aba = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_select_db('aba', $aba);
		
		//Obtener Año Activo para correlativos en ABA			
		$query_rs_anio_get = "SELECT paramAnio FROM parametros WHERE centrCod=103 AND paramEstado='A'";
		$rs_anio_get = mysql_query($query_rs_anio_get, $aba) or die(mysql_error());
		$row_rs_anio_get = mysql_fetch_assoc($rs_anio_get);	
		$paramAnio_ = $row_rs_anio_get['paramAnio'];		
		
		//Obtener correlativo 
		$query_rs_correlativo_get = sprintf("SELECT MAX(paramFolio) FROM parametrosdocumentos WHERE paramAnio=%s AND centrCod=103 AND documCod=%s",
											GetSQLValueString($paramAnio_, "int"), 
											GetSQLValueString($documCod_, "text"));
		$rs_correlativo_get = mysql_query($query_rs_correlativo_get, $aba) or die(mysql_error());
		$row_rs_correlativo_get = mysql_fetch_assoc($rs_correlativo_get);
				
		//incrementar correlativo
		$paramFolio_ = $row_rs_correlativo_get['MAX(paramFolio)'] + 1;
		$query_rs_correlativo_set = sprintf("UPDATE parametrosdocumentos SET paramFolio=%s WHERE paramAnio=%s AND centrCod=103 AND documCod=%s",
											GetSQLValueString($paramFolio_, "int"),
											GetSQLValueString($paramAnio_, "int"),
											GetSQLValueString($documCod_, "text"));
		$rs_correlativo_set = mysql_query($query_rs_correlativo_set, $aba) or die(mysql_error());		
		
		return $paramAnio_."|".$paramFolio_;
	}

	// --------------------------------------------------------------------- Funciones para Abastecimiento - Generamos Bincard
		
	function ActualizarStockBodega($cantidad_, $codproducto_, $bodega_, $servicio_){

		$aba = mysql_pconnect('10.6.21.12', 'gestioncamas', '123gestioncamas') or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_select_db('aba', $aba);
		
		$query_rs_update_productobodega = sprintf("UPDATE productobodega SET produStkReal=produStkReal + %s WHERE produCodInt=%s AND bodegCod=%s AND serviCod=%s AND centrCod=103",
												GetSQLValueString($cantidad_, "int"),
												GetSQLValueString($codproducto_, "text"),
												GetSQLValueString($bodega_, "text"),					
												GetSQLValueString($servicio_, "int"));
		$rs_update_productobodega = mysql_query($query_rs_update_productobodega, $aba) or die(mysql_error());
	}

	ftp_close($conn_id);
?>
</body>
</html>