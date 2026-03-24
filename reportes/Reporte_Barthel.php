<? 
//error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0); 

?>

<table width="1184" border="0" align="center" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td>
        <fieldset>
            <table width="1184" border="0" align="center" cellpadding="0" cellspacing="0"> 
                      <tr class='noprint'>
                     <td height="40" colspan="2" align="left" >FECHA INICIO
                       <input name="fechaD1" type="text" id="fechaD1" readonly="readonly" size="7" value="<? if ($fechaD1) echo $fechaD1; else echo date('d-m-Y');?>" /> 
                       <a id="verD1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a> &nbsp;&nbsp; FECHA FIN
                       <input name="fechaF1" type="text" id="fechaF1" readonly="readonly" size="7" value="<? if ($fechaF1) echo $fechaF1; else echo date('d-m-Y');?>" /> 
                       <a id="verF1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a><img src="../img/search2.gif" width="24" height="24" align="absmiddle" onclick="javascript:frm_info_gcamas.act.value='1'; document.frm_info_gcamas.submit()" style="cursor:pointer"/></td>
                       
                <td align="right"></td>
            </tr>

  
            </table>
            </fieldset>
        </td>
     </tr>
        <tr><td colspan="3" align="right">&nbsp;</td></tr> 
     <tr >
        <td  align="center" colspan="3" style="font-size:18px">REPORTE DIARIO BARTHEL<br /></td>
     </tr>
    <tr><td>
    <table width="1184" border="0" align="center" cellpadding="0" cellspacing="0"> 	
        
        <tr>
        <? if($rows > 0){ ?>
        <td width="244"  align="left" id="texto">*SE ENCONTRARON <strong><? echo $rows; ?></strong> REGISTROS</td>
        <td width="761" colspan="2" align="left"><img src="../reportes/css/no.png" width="16" height="16" style="vertical-align:middle" />&nbsp; = Barthel no ingresado</td>
        <? } ?>
      </tr>
      
        <tr>
            <td colspan="3">
                  <table width="1200px" border="0" cellspacing="1" align="center">
                 
                      <tr  style="font:bold; background-color:#4682b4; color:#FFF; font-size:12px;">
                        <td width="6%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>RUT</strong></td>
                        <td width="15%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>NOMBRE</strong></td>
                        
                        <td width="8%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>SERVICIO</strong></td>
                        <td width="6%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>FECHA<BR />INGRESO</strong></td>
                        <td width="10%"  style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>USUARIO<br />QUE INGRESA</strong></td>
                        <td width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>BARTHEL INGRESO</strong></td>
                        <td width="5%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>BARTHEL EGRESO</strong></td>
                        <td width="10%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>EDAD</strong></td>
                        <td width="3%" style="border-top-color:#4682b4; border-top-style:solid;border-bottom-color:#4682b4; border-bottom-style:solid;"><strong>CONDICION</strong></td>
                        
                      </tr>
                    </table>
                    
                    <fieldset style=" height:500px; overflow:auto; width:1250px"> 

              		<table width="1200px" border="0" id="demo_table" cellspacing="1" align="center">
                     <? if($rows > 0){
                      while($arr_ibarthel = mysql_fetch_array($query)){ ?>
                      <tr style="border-top-color:#4682b4; border-top-style:solid; font-size:11px" > 
                        <td width="6%" style="border-bottom-color:#4682b4; border-bottom-style:solid;" ><?= $arr_ibarthel['rut_paciente']; ?></td>
                        <td width="15%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['nom_paciente']; ?></td>
                        <td width="8%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['Servicio']; if($arr_ibarthel['Desde']=='CMI'){ echo "(CMI)"; }?></td>
                        <td width="6%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['fecha']; ?></td>
                        <td width="10%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['usuario_ingresa']; ?></td>
                        <td width="5%" style="border-bottom-color:#4682b4; border-bottom-style:solid;" ><? if($arr_ibarthel['barthel'] == NULL or $arr_ibarthel['barthel'] == "NULL" or $arr_ibarthel['barthel'] == ""){ echo '<img src="../reportes/css/no.png" width="16" height="16" style="vertical-align:middle" />'; }else{ echo $arr_ibarthel['barthel']; } ?></td>
                        <td width="5%" style="border-bottom-color:#4682b4; border-bottom-style:solid;">
                          <? IF($arr_ibarthel['destino'] =="Defuncion"){
                                echo "F";
                              }else{
                                if($arr_ibarthel['destino'] == 'Fallecido'){
                                  echo "F";
                                }else{
                                  if($arr_ibarthel['barthelegreso'] == NULL or $arr_ibarthel['barthelegreso'] == "NULL" or $arr_ibarthel['barthelegreso'] == ""){
                                    if($arr_ibarthel['destino']!='sin egreso'){
                                      echo '<img src="../reportes/css/no.png" width="16" height="16" style="vertical-align:middle" />';
                                    }
                                  }else{
                                    echo $arr_ibarthel['barthelegreso'];
                                  }
                                }
                              } ?></td>
                        <td width="10%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['edad']; ?></td>
                        <td width="5%" style="border-bottom-color:#4682b4; border-bottom-style:solid;"><?= $arr_ibarthel['destino']; ?></td>
                     </tr><? }  }else{ ?>
                     <tr><td colspan="8" style="border-bottom-color:#4682b4; border-bottom-style:solid;">No existen registros para el periodo seleccionado</td></tr>
                      <? } ?>

                   </table>
                   </fieldset>
               </td>
            </tr>
             <? if($rows > 0){ ?>
            <tr class='noprint'>
            	<td colspan="3" align="left"><a href="javascript: PDF()" style="text-decoration:none;color:#666" class="input">GENERAR PDF <img src="../reportes/css/pdf.png" width="48" height="48" title="PDF" style="cursor:pointer; border:none; text-decoration:none"  align="absmiddle" class="input"/></a>
                </td>
            </tr> 
            <? } ?> 
          </table>
          </td>
          </tr>
          

    
 </table>
     <script>
 		function PDF(){
        window.open('../reportes/PDF_barthel.php?desde=<? echo cambiarFormatoFecha2($fechaD1); ?>&hasta=<? echo cambiarFormatoFecha2($fechaF1);?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
		}
    </script> 
    <script language="JavaScript">             
         tigra_tables('demo_table',0,0,'#EBF4FE','#FFF','#F7F7F7','#F7F7F7');               
    </script>
    <script type="text/javascript">
    var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("verD1", "fechaD1", "%d-%m-%Y");
		  cal.manageFields("verF1", "fechaF1", "%d-%m-%Y");
    </script>
   
