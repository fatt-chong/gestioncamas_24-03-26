<? 

function cambiarFormatoFecha2($fecha){ 
    list($dia,$mes,$anio)=explode("-",$fecha); 
    return $anio."-".$mes."-".$dia; 
}
function cambiarFormatoFecha($fecha){ 
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio; 
}
if($anio_ini == ''){
	$anio_ini = 2013;
}
mysql_connect ($_SESSION['BD_SERVER'],'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');  // Reporte Pabellon

if($act == 1 and $anio_ini != ''){	
		
	$sql_s = "SELECT 
		CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN IN (3,6) THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIOX
		FROM camas.hospitalizaciones
		LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
		LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
		WHERE MONTH(camas.hospitalizaciones.fecha_egreso) BETWEEN  ".$mes1."  AND ".$mes2."
		AND YEAR(camas.hospitalizaciones.fecha_egreso) = ".$anio_ini."
		AND camas.hospitalizaciones.tipo_traslado > 100
		AND camas.hospitalizaciones.tipo_traslado <> 107
		GROUP BY SERVICIOX
		ORDER BY   SERVICIOX  ASC";	
	mysql_query("SET NAMES 'utf8'");		
	$query_s = mysql_query($sql_s) or die("Error<br>$sql_s<br><br>".mysql_error());	
	
	$servicios = array();
	$a = 0;
	
	while($arr_s = mysql_fetch_array($query_s)){ 

		$servicios[$a]['servicio'] = ($arr_s['SERVICIOX']);
		//echo '<br>';
		$a++;
	}	
		

	$sql = "SELECT MONTH(camas.hospitalizaciones.fecha_egreso) AS Mes_Egreso,
		CASE
		WHEN camas.hospitalizaciones.camaSN = 'S' AND camas.hospitalizaciones.cod_servicio NOT IN (10,11,14) AND camas.hospitalizaciones.nomSalaSN IN (3,6) THEN 'CMI'
		ELSE camas.hospitalizaciones.servicio
		END AS SERVICIOX,
		count(servicio) as Total_egresos,
		count(epicrisis.epicrisisenf.epienfId) as total_epi1,
	  count(epicrisis.epicrisismatrona.epimatId) as total_epi2
		FROM camas.hospitalizaciones
		LEFT JOIN epicrisis.epicrisisenf ON epicrisis.epicrisisenf.epienfCtacte = camas.hospitalizaciones.cta_cte
		LEFT JOIN epicrisis.epicrisismatrona ON camas.hospitalizaciones.cta_cte = epicrisis.epicrisismatrona.epimatCtacte
		WHERE MONTH(camas.hospitalizaciones.fecha_egreso) BETWEEN  ".$mes1."  AND ".$mes2."
		AND YEAR(camas.hospitalizaciones.fecha_egreso) = ".$anio_ini."
		AND camas.hospitalizaciones.tipo_traslado > 100
		AND camas.hospitalizaciones.tipo_traslado <> 107
		GROUP BY MONTH(camas.hospitalizaciones.fecha_egreso), SERVICIOX
		ORDER BY   SERVICIOX, MONTH(camas.hospitalizaciones.fecha_egreso)  ASC";
	mysql_query("SET NAMES 'utf8'");
	$query = mysql_query($sql) or die("Error<br>$sql<br><br>".mysql_error());
	$rows = mysql_num_rows($query);
	
	$meses 		= array();

	$i = 0;
	$l = 0;
				
	
		 for($i=0;$i<count($servicios);$i++){
			
			mysql_data_seek($query, 0); 
			while($arr = mysql_fetch_array($query)){  
				if($servicios[$i]['servicio'] == $arr['SERVICIOX']){
						  if($arr['Mes_Egreso'] == 1){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['01_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['01_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['01_c_epi'] > 0){
									  $meses[$l]['01_por_epi']  =  (($meses[$l]['01_c_epi'] * 100)/($meses[$l]['01_total'])); 
								  }else{
									  $meses[$l]['01_por_epi'] = 0;
								  }
						  }
						  if($arr['Mes_Egreso'] == 2){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['02_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['02_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['02_c_epi'] > 0){
									  $meses[$l]['02_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['02_por_epi'] = 0;
								  }											
						  }
						  if($arr['Mes_Egreso'] == 3){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['03_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['03_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['03_c_epi'] > 0){
									  $meses[$l]['03_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['03_por_epi'] = 0;
								  }											
						  }
						  if($arr['Mes_Egreso'] == 4){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['04_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['04_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['04_c_epi'] > 0){
									  $meses[$l]['04_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['04_por_epi'] = 0;
								  }											
						  }						  
						  if($arr['Mes_Egreso'] == 5){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['05_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['05_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['05_c_epi'] > 0){
									  $meses[$l]['05_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['05_por_epi'] = 0;
								  }											
						  }					 
						  if($arr['Mes_Egreso'] == 6){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['06_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['06_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['06_c_epi'] > 0){
									  $meses[$l]['06_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['06_por_epi'] = 0;
								  }											
						  }						
						  if($arr['Mes_Egreso'] == 7){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['07_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['07_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['07_c_epi'] > 0){
									  $meses[$l]['07_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['07_por_epi'] = 0;
								  }											
						  }			
						  if($arr['Mes_Egreso'] == 8){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['08_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['08_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['08_c_epi'] > 0){
									  $meses[$l]['08_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['08_por_epi'] = 0;
								  }											
						  }							  
						  if($arr['Mes_Egreso'] == 9){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['09_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['09_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['09_c_epi'] > 0){
									  $meses[$l]['09_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['09_por_epi'] = 0;
								  }											
						  }							  
						  if($arr['Mes_Egreso'] == 10){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['10_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['10_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['10_c_epi'] > 0){
									  $meses[$l]['10_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['10_por_epi'] = 0;
								  }											
						  }							  
						  if($arr['Mes_Egreso'] == 11){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['11_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['11_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  
								  if($meses[$l]['11_c_epi'] > 0){
									  $meses[$l]['11_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['11_por_epi'] = 0;
								  }											
						  }							  
						  if($arr['Mes_Egreso'] == 12){
								  $meses[$l]['servicio'] 	= $arr['SERVICIOX'];
								  $meses[$l]['12_total'] 	= $arr['Total_egresos'];
								  $meses[$l]['12_c_epi'] 	= ($arr['total_epi1'] + $arr['total_epi2']);
								  if($meses[$l]['12_c_epi'] > 0){
									  $meses[$l]['12_por_epi']  =  ((($arr['total_epi1'] + $arr['total_epi2']) * 100)/($arr['Total_egresos'])); 
								  }else{
									  $meses[$l]['12_por_epi'] = 0;
								  }											
						  }							  
				}//END IF
				
		 }// END WHILE
		 $l++;
	}//END FOR
}// END ACT

function valida($var,$tipo){
	if($var == ''){
		$res = '-';
	}else if($var != '' && $tipo == 'total'){
		$res = $var;	
	}else if($var != '' && $tipo == 'porcentaje'){
		$res = number_format($var,1,",",".");
		$res.=" %";
	}
	
	return  $res;
}
?>
<!DOCTYPE html PUBLIC "-//W3CON/DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Reporte Epicrisis Semanal:.</title>
<link type="text/css" rel="stylesheet" href="css/estilo_tania.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css"/>
<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>
<script language="JavaScript" src="../../estandar/tigra/tigra_tables.js"></script>
</head>
<style media='screen'>
.input{display:block;} /* muestra los input en la pantalla */
</style>
<style type="text/css">
  @media print {
.noprint { display: none; }
}
#element{
    background-color:#FFF;
    cursor: pointer;
}

#element:hover{
    background-color: #E0E0E0;
	color:#333;
    cursor: pointer;	
}
</style>
<body style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:10px; color:#333">
<form name="form1" id="form1" method="post">
<input type="hidden" name="act" id="act"/>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0"> 
	<tr >
      <td ><img src='css/logo.jpg' width='146' height='119' /></td>
	  <td   align="center"><strong id="subtituloGRANDE2">REPORTE MENSUAL <BR /> CUMPLIMIENTO EPICRISIS </strong><br /><br /><strong id="subtituloGRANDE">Fecha Reporte : <? echo date("d-m-Y - H:i:s"); ?>&nbsp;Hrs.</strong><br /> </td>
      <td  align="right"><img src="css/logo_regional.jpg" /></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr> 
    <tr>
    	<td colspan="3">
        <table width="950" border="0" align="center" cellpadding="0" cellspacing="0"> 	
            <tr>
                <td align="center" width="100%" colspan="9">
                    <table width="100%" border="0">
                        <tr>
                            <td width="5%"  align="right">MES DESDE</td>
                            <td width="13%" align="left">&nbsp;<select name="mes1" id="mes1">
                                  <option value="01" <? if($mes1 == '01'){echo "selected='selected'";} ?>>Enero</option>
                                  <option value="02" <? if($mes1 == '02'){echo "selected='selected'";} ?>>Febrero</option>
                                  <option value="03" <? if($mes1 == '03'){echo "selected='selected'";} ?>>Marzo</option>
                                  <option value="04" <? if($mes1 == '04'){echo "selected='selected'";} ?>>Abril</option>        
                                  <option value="05" <? if($mes1 == '05'){echo "selected='selected'";} ?>>Mayo</option>        
                                  <option value="06" <? if($mes1 == '06'){echo "selected='selected'";} ?>>Junio</option>        
                                  <option value="07" <? if($mes1 == '07'){echo "selected='selected'";} ?>>Julio</option>        
                                  <option value="08" <? if($mes1 == '08'){echo "selected='selected'";} ?>>Agosto</option>        
                                  <option value="09" <? if($mes1 == '09'){echo "selected='selected'";} ?>>Septiembre</option>        
                                  <option value="10" <? if($mes1 == '10'){echo "selected='selected'";} ?>>Octubre</option>        
                                  <option value="11" <? if($mes1 == '11'){echo "selected='selected'";} ?>>Noviembre</option>        
                                  <option value="12" <? if($mes1 == '12'){echo "selected='selected'";} ?>>Diciembre</option>              
                              </select></td>
                              <td width="6%"  align="right">MES HASTA</td>
                            <td width="12%" align="left">&nbsp;<select name="mes2" id="mes2">
                                  <option value="01" <? if($mes2 == '01'){echo "selected='selected'";} ?>>Enero</option>
                                  <option value="02" <? if($mes2 == '02'){echo "selected='selected'";} ?>>Febrero</option>
                                  <option value="03" <? if($mes2 == '03'){echo "selected='selected'";} ?>>Marzo</option>
                                  <option value="04" <? if($mes2 == '04'){echo "selected='selected'";} ?>>Abril</option>        
                                  <option value="05" <? if($mes2 == '05'){echo "selected='selected'";} ?>>Mayo</option>        
                                  <option value="06" <? if($mes2 == '06'){echo "selected='selected'";} ?>>Junio</option>        
                                  <option value="07" <? if($mes2 == '07'){echo "selected='selected'";} ?>>Julio</option>        
                                  <option value="08" <? if($mes2 == '08'){echo "selected='selected'";} ?>>Agosto</option>        
                                  <option value="09" <? if($mes2 == '09'){echo "selected='selected'";} ?>>Septiembre</option>        
                                  <option value="10" <? if($mes2 == '10'){echo "selected='selected'";} ?>>Octubre</option>        
                                  <option value="11" <? if($mes2 == '11'){echo "selected='selected'";} ?>>Noviembre</option>        
                                  <option value="12" <? if($mes2 == '12'){echo "selected='selected'";} ?>>Diciembre</option>              
                              </select></td>
                            <td width="7%"  align="right">A&Ntilde;O EGRESO</td>
                            <td align="center" width="7%"> <select name="anio_ini" id="anio_ini">
                              <option value="" >...</option>
                              <option value="2012" <? if($anio_ini == 2012){echo "selected='selected'";} ?>>2012</option>
                              <option value="2013" <? if($anio_ini == 2013){echo "selected='selected'";} ?>>2013</option>
                               <option value="2014" <? if($anio_ini == 2014){echo "selected='selected'";} ?>>2014</option>
                          </select></td> 
                          <td width="38%" align="left"><img src="../img/search2.gif" width="24" height="24" align="absmiddle" onclick="javascript:document.getElementById('act').value='1';document.form1.submit()" style="cursor:pointer"/></td>
                        	<? if($rows > 99999999999999999999){ ?>
   						 	<td align="right"><a href="javascript: EXCEL()" style="text-decoration:none;color:#666" class="input"><img src="css/excel.png" width="48" height="48" title="Excel" style="cursor:pointer; border:none"  align="absmiddle" class="input"/></a></td>
    						<? } ?>
                        </tr>
                     </table>
               </td>
            </tr>
            <tr>
                <td width="136" colspan="3" align="center" id="subtituloGRANDE2">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" width="100%" colspan="3">
                    <table width="100%" border="0">

                        <tr style="background-color:#4682b4; color:#FFF" align="center" >
                            <td width="28%" rowspan="2" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">SERVICIO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">ENERO</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid; background-color:#E0E0E0; color:#333">FEBRERO</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">MARZO</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">ABRIL</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">MAYO</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">JUNIO</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">JULIO</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">AGOSTO</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">SEPTIEMBRE</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">OCTUBRE</td>
                            <td width="6%" colspan="3" style="border-top-color:#4682b4; border-top-style:solid;">NOVIEMBRE</td>
                            <td width="6%" colspan="3" style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">DICIEMBRE</td>
                            <td width="6%" colspan="3" style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF">TOTAL POR SERVICIO</td>
                          </tr>
                          <tr style="background-color:#4682b4; color:#FFF" align="center" >
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                            
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                          
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">TOTAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">TOTAL</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>                          
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF">TOTAL</td>
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF">&nbsp;&nbsp;CON<BR>&nbsp;EPI&nbsp;</td>
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF">&nbsp;%&nbsp;EPI&nbsp;&nbsp;&nbsp;</td>  						
                        </tr>
                          
                          
                        <? if($rows > 0){                         
                           for($j=0;$j<count($meses);$j++){ ?>
                          <tr  align="right" id="element">
                              <td align="left" style="border-left: 1px solid #E0E0E0;border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo strtoupper($meses[$j]['servicio']); ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_01 	= valida($meses[$j]['01_total'],'total'); 			$total_egre_01 	= $total_egre_01 	+	$egre_01;  	?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_01 	= valida($meses[$j]['01_c_epi'],'total');  			$total_epi_01 	= $total_epi_01 	+	$epi_01; 	?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_01 	= valida($meses[$j]['01_por_epi'],'porcentaje');    //$total_por_01 	= $total_por_01 	+  	$por_01;?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_02 	= valida($meses[$j]['02_total'],'total'); 			$total_egre_02 	= $total_egre_02 	+  	$egre_02;	?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_02 	= valida($meses[$j]['02_c_epi'],'total'); 			$total_epi_02 	= $total_epi_02 	+ 	$epi_02; 	?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_02 	= valida($meses[$j]['02_por_epi'],'porcentaje'); 	//$total_por_02 	= $total_por_02 	+  	$por_02; ?></td>  
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_03 	= valida($meses[$j]['03_total'],'total'); 			$total_egre_03 	= $total_egre_03 	+  	$egre_03; 	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_03 	= valida($meses[$j]['03_c_epi'],'total');  			$total_epi_03 	= $total_epi_03 	+ 	$epi_03; 	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_03 	= valida($meses[$j]['03_por_epi'],'porcentaje'); 	//$total_por_03 	= $total_por_03 	+  	$por_03; ?></td> 
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_04	= valida($meses[$j]['04_total'],'total'); 			$total_egre_04 	= $total_egre_04 	+  	$egre_04;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_04	= valida($meses[$j]['04_c_epi'],'total'); 			$total_epi_04 	= $total_epi_04 	+ 	$epi_04;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_04	= valida($meses[$j]['04_por_epi'],'porcentaje');  	//$total_por_04 	= $total_por_04 	+  	$por_04; ?></td> 
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_05	= valida($meses[$j]['05_total'],'total'); 			$total_egre_05 	= $total_egre_05 	+  	$egre_05;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_05	= valida($meses[$j]['05_c_epi'],'total'); 			$total_epi_05 	= $total_epi_05 	+ 	$epi_05;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_05	= valida($meses[$j]['05_por_epi'],'porcentaje');  	//$total_por_05 	= $total_por_05 	+  	$por_05; ?></td> 
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_06	= valida($meses[$j]['06_total'],'total'); 			$total_egre_06 	= $total_egre_06 	+  	$egre_06;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_06	= valida($meses[$j]['06_c_epi'],'total'); 			$total_epi_06 	= $total_epi_06 	+ 	$epi_06;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_06	= valida($meses[$j]['06_por_epi'],'porcentaje');  	//$total_por_06 	= $total_por_06 	+  	$por_06; ?></td> 
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_07	= valida($meses[$j]['07_total'],'total'); 			$total_egre_07 	= $total_egre_07 	+  	$egre_07;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_07	= valida($meses[$j]['07_c_epi'],'total'); 			$total_epi_07 	= $total_epi_07 	+ 	$epi_07;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_07	= valida($meses[$j]['07_por_epi'],'porcentaje');  	//$total_por_07 	= $total_por_07 	+  	$por_07; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_08 	= valida($meses[$j]['08_total'],'total'); 			$total_egre_08 	= $total_egre_08 	+  	$egre_08;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_08	= valida($meses[$j]['08_c_epi'],'total'); 			$total_epi_08 	= $total_epi_08 	+ 	$epi_08;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_08	= valida($meses[$j]['08_por_epi'],'porcentaje');  	//$total_por_08 	= $total_por_08 	+  	$por_08; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_09	= valida($meses[$j]['09_total'],'total'); 			$total_egre_09 	= $total_egre_09 	+  	$egre_09;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_09	= valida($meses[$j]['09_c_epi'],'total'); 			$total_epi_09 	= $total_epi_09 	+ 	$epi_09;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_09	= valida($meses[$j]['09_por_epi'],'porcentaje');  	//$total_por_09 	= $total_por_09 	+  	$por_09; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_10	= valida($meses[$j]['10_total'],'total'); 			$total_egre_10 	= $total_egre_10 	+  	$egre_10;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_10	= valida($meses[$j]['10_c_epi'],'total'); 			$total_epi_10 	= $total_epi_10 	+ 	$epi_10;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_10	= valida($meses[$j]['10_por_epi'],'porcentaje');  	//$total_por_10 	= $total_por_10 	+  	$por_10; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_11	= valida($meses[$j]['11_total'],'total'); 			$total_egre_11 	= $total_egre_11 	+  	$egre_11;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_11	= valida($meses[$j]['11_c_epi'],'total'); 			$total_epi_11 	= $total_epi_11 	+ 	$epi_11;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_11	= valida($meses[$j]['11_por_epi'],'porcentaje');  	//$total_por_11 	= $total_por_11 	+  	$por_11; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $egre_12	= valida($meses[$j]['12_total'],'total'); 			$total_egre_12 	= $total_egre_12 	+  	$egre_12;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $epi_12	= valida($meses[$j]['12_c_epi'],'total'); 			$total_epi_12 	= $total_epi_12 	+ 	$epi_12;	 ?></td>
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? echo $por_12	= valida($meses[$j]['12_por_epi'],'porcentaje');  	//$total_por_12 	= $total_por_12 	+  	$por_12; ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;">&nbsp;&nbsp;&nbsp;&nbsp;<?  $serv_t = ($egre_01 + $egre_02 + $egre_03 + $egre_04 + $egre_05 + $egre_06 + $egre_07 + $egre_08 + $egre_09 + $egre_10 + $egre_11 + $egre_12); $total_gral = $total_gral + $serv_t;  echo number_format($serv_t, 0,",","."); ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;">&nbsp;&nbsp;&nbsp;&nbsp;<?  $epi_t = ($epi_01 + $epi_02 + $epi_03 + $epi_04 + $epi_05 + $epi_06 + $epi_07 + $epi_08 + $epi_09 + $epi_10 + $epi_11 + $epi_12);  $epi_gral = $epi_gral + $epi_t; echo number_format($epi_t, 0,",","."); ?></td>                               
                              <td style="border-bottom: 1px solid #E0E0E0; border-right: 1px solid #E0E0E0;"><? if($serv_t > 0 && $epi_t > 0 ){ $por_t = (($epi_t * 100)/($serv_t)); echo number_format($por_t,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>                               
                            <? }  ?>
							<tr style="background-color:#4682b4; color:#FFF" align="right" >
                            <td align="left">TOTAL MENSUAL</td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_01, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_01, 0,",",".");   ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_01 > 0 && $total_egre_01 > 0 ){ $total_porc_01 = (($total_epi_01 * 100)/($total_egre_01)); echo number_format($total_porc_01,1,",",".")." %";  } else { echo '0,0 %'; } ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_02, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_02, 0,",",".");  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? if($total_epi_02 > 0 && $total_egre_02 > 0 ){  $total_porc_02 = (($total_epi_02 * 100)/($total_egre_02)); echo number_format($total_porc_02,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_03, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_03, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_03 > 0 && $total_egre_03 > 0 ){ $total_porc_03 = (($total_epi_03 * 100)/($total_egre_03)); echo number_format($total_porc_03,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_04, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_04, 0,",",".");  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? if($total_epi_04 > 0 && $total_egre_04 > 0 ){ $total_porc_04 = (($total_epi_04 * 100)/($total_egre_04)); echo number_format($total_porc_04,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_05, 0,",",".");   ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_05, 0,",","."); ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_05 > 0 && $total_egre_05 > 0 ){ $total_porc_05 = (($total_epi_05 * 100)/($total_egre_05)); echo number_format($total_porc_05,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_06, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_06, 0,",",".");  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? if($total_epi_06 > 0 && $total_egre_06 > 0 ){ $total_porc_06 = (($total_epi_06 * 100)/($total_egre_06)); echo number_format($total_porc_06,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_07, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_07, 0,",","."); ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_07 > 0 && $total_egre_07 > 0 ){ $total_porc_07 = (($total_epi_07 * 100)/($total_egre_07)); echo number_format($total_porc_07,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_08, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_08, 0,",",".");  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? if($total_epi_08 > 0 && $total_egre_08 > 0 ){ $total_porc_08 = (($total_epi_08 * 100)/($total_egre_08)); echo number_format($total_porc_08,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>                            
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_09, 0,",",".");   ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_09, 0,",","."); ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_09 > 0 && $total_egre_09 > 0 ){ $total_porc_09 = (($total_epi_09 * 100)/($total_egre_09)); echo number_format($total_porc_09,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_10, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_10, 0,",",".");  ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? if($total_epi_10 > 0 && $total_egre_10 > 0 ){ $total_porc_10 = (($total_epi_10 * 100)/($total_egre_10)); echo number_format($total_porc_10,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>                          
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_egre_11, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? echo number_format($total_epi_11, 0,",",".");  ?></td>
                            <td   style="border-top-color:#4682b4; border-top-style:solid;"><? if($total_epi_11 > 0 && $total_egre_11 > 0 ){ $total_porc_11 = (($total_epi_11 * 100)/($total_egre_11)); echo number_format($total_porc_11,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>                            
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_egre_12, 0,",",".");   ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><? echo number_format($total_epi_12, 0,",","."); ?></td>
                            <td   style="border-top-color:#E0E0E0; border-top-style:solid;background-color:#E0E0E0; color:#333"><?  if($total_epi_12 > 0 && $total_egre_12 > 0 ){ $total_porc_12 = (($total_epi_12 * 100)/($total_egre_12)); echo number_format($total_porc_12,1,",",".")." %"; } else { echo '0,0 %'; } ?></td>                          
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF"><? echo  number_format($total_gral, 0,",","."); ?></td> 
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF"><? echo  number_format($epi_gral, 0,",","."); ?></td>                          
                            <td   style="border-top-color:#666; border-top-style:solid;background-color:#666; color:#FFF"><? if($total_gral > 0 && $epi_gral > 0 ){ $por_gral = (($epi_gral * 100)/($total_gral)); echo number_format($por_gral,1,",",".")." %"; } else { echo '0,0 %'; }  ?></td>                          
                                                    
                        </tr>
							
							 <?  }else{?>
                         <tr><td colspan="41" style="border-bottom-color:#E0E0E0; border-bottom-style:solid; font:bold">Seleccione periodo</td></tr>
    
                         <? } ?>
                    </table>
              </td>
           </tr>
        </table>
    	</td>
    </tr>
     <tr><td colspan="3">&nbsp;</td></tr>
     <tr><td colspan="3">&nbsp;</td></tr> 
     <tr>
          <td colspan="3">&nbsp;</td>
     </tr> 

     <tr>
        <td colspan="3">&nbsp;</td>
    </tr> 
 </table> 
     <script>
 		function EXCEL(){
        window.open('reportes/deuda_padre_EXCEL.php?rango=<? echo $rango; ?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
		}
    </script>  
   
    <script type="text/javascript">
    var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("verD1", "fechaD1", "%d-%m-%Y");
          cal.manageFields("verH1", "fechaH1", "%d-%m-%Y");
    </script>
   
    </form>
</body>
</html>