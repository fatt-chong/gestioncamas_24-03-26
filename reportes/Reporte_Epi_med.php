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
                     <td height="40" colspan="2" align="left" >FECHA EGRESO: &nbsp;   DESDE&nbsp;<input name="fechaD1" type="text" id="fechaD1" readonly="readonly" size="7" value="<? if ($fechaD1) echo $fechaD1; else echo date('d-m-Y');?>" /> <a id="verD1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a> &nbsp; HASTA&nbsp;<input name="fechaH1" type="text" id="fechaH1" readonly="readonly" size="7" value="<? if ($fechaH1) echo $fechaH1; else echo date('d-m-Y'); ?>" /> <a id="verH1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a>
                  &nbsp;<img src="../img/search2.gif" width="24" height="24" align="absmiddle" onclick="javascript:frm_info_gcamas.act.value='2'; document.frm_info_gcamas.submit()" style="cursor:pointer"/></td>
                <td align="right">&nbsp;</td>
            </tr>

  
            </table>
            </fieldset>
        </td>
     </tr>
        <tr><td colspan="3" align="right">&nbsp;</td></tr> 
     <tr >
        <td  align="center" colspan="3" style="font-size:18px">REPORTE DIARIO  EPICRISIS M&Eacute;DICA<br /></td>
     </tr>
    <tr><td colspan="3" align="center" style="color:#3DB8B8; "><strong>CUMPLIMIENTO HOSPITAL<BR />&nbsp;&nbsp;EGRESOS:  <? echo $total_hospital; ?>&nbsp; | &nbsp;EPICRISIS:  <? echo $total_epi; ?> &nbsp;= <? echo number_format($por_cumplimiento,1,",",".");  ?> %</strong></td></tr> 
    <tr><td>
    <table width="1184" border="0" align="center" cellpadding="0" cellspacing="0"> 	
        
        <tr>
        <? if($rows > 0){ ?>
        <td width="244"  align="left" id="texto">*SE ENCONTRARON <strong><? echo $rows; ?></strong> REGISTROS</td>
        <td width="761" colspan="2" align="left"><img src="../reportes/css/no.png" width="16" height="16" style="vertical-align:middle" />&nbsp; = Epicrisis no realizada</td>
        <? } ?>
      </tr>
      
        <tr>
            <td colspan="3">
                  <table width="1184" border="0" cellspacing="1">
                 
                      <tr  style="font:bold; background-color:#3DB8B8; color:#FFF; font-size:12px;">
                        <td width="7%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>RUT</strong></td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>NOMBRE</strong></td>
                        <td width="4%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>FICHA</strong></td>  
                        <td width="11%" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>SERVICIO</strong></td>
                        <td width="6%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>FECHA<BR />INGRESO</strong></td>
                        <td width="5%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>FECHA<BR />EGRESO</strong></td>
                        <td width="5%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>DIAS EN<BR />SERV.</strong></td>
                        <td width="5%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>DIAS<BR />HOSP.</strong></td>
                        <td width="6%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>ID <br />EPICRISIS</strong></td>
                        <td width="8%"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>USUARIO<br />QUE EGRESA</strong></td>
                        <td width="21%" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><strong>EPICRISIS<BR />ENFERMERA</strong></td>
                        <td width="3%"  style="font:bold; background-color:#fff; color:#FFF; font-size:13px;" ><img src="../reportes/css/change.png" width="32" height="32" /></td>
                      </tr>
                    </table>
                    
                    <fieldset style=" height:500px; overflow:auto; width:97%"> 

              		<table width="1199" border="0" id="demo_table" cellspacing="1" align="center">
                     <? if($rows > 0){
                      while($arr_epi = mysql_fetch_array($query)){ ?>
                      <tr style="border-top-color:#3DB8B8; border-top-style:solid; font-size:11px"> 
                        <td width="65"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo ($arr_epi['rut_paciente']); ?></td>
                        <td width="223" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo strtoupper($arr_epi['nom_paciente']);?></td>
                        <td width="27"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo ($arr_epi['ficha_paciente']);?></td>
                        <td width="127" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo strtoupper($arr_epi['SERVICIO']);?></td>
                        <td width="67"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo cambiarFormatoFecha($arr_epi['fecha_ingreso']); ?></td>
                        <td width="66"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo cambiarFormatoFecha($arr_epi['fecha_egreso']); ?></td>
                        <td width="46"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo strtoupper($arr_epi['DIAS_EN_SERVICIO']);?></td>
                        <td width="41"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $arr_epi['DIAS_HOSPITALIZADO']; ?></td>
                        <td width="77"  align="right" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? if(!$arr_epi['IDEPICRISIS']) echo '<img src="../reportes/css/no.png" width="16" height="16" style="vertical-align:middle" />'; else echo $arr_epi['IDEPICRISIS'];?></td>
                        <td width="97"  style="border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo strtoupper($arr_epi['usuario_que_egresa']); ?></td>
                        <td width="292" style="border-bottom-color:#3DB8B8; border-bottom-style:solid;">&nbsp; <? echo strtoupper($arr_epi['PERSONAL']); ?></td>
                     </tr><? }  }else{ ?>
                     <tr><td colspan="15" style="border-bottom-color:#3DB8B8; border-bottom-style:solid; font:bold">No existen registros para el periodo seleccionado</td></tr>
                      <? } ?>
                   </table>
                   </fieldset>
               </td>
        </tr> 
          </table>
          </td>
          </tr>

    <tr><td>
    <table width="1184" border="0" align="center" cellpadding="0" cellspacing="0">    
         <tr><td colspan="3">&nbsp;</td> </tr>
         <tr><td colspan="3">&nbsp;</td> </tr>
         <? if($rows > 0){ ?>
        <tr>
            <td align="center" width="50%" style="font-size:12px">
                <table width="100%" border="0" >
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - MEDICINA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'MEDICINA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_medicina;  ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_medicina_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_medicina_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - ONCOLOGIA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'ONCOLOGIA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_oncologia; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_oncologia_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_oncologia_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - CIRUGIA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'CIRUGIA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_cirugia; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_cirugia_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_cirugia_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - CIRUGIA AISLAMIENTO</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'CIR. AIS'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_cirugia_ais; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_cirugia_ais_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_cirugia_ais_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - TRAUMATOLOGIA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'TRAUMATOLOGIA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_traumatologia; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_traumatologia_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_traumatologia_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - UCI</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF;" align="right">
                        <td align="left"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'UCI'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_UCI; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_UCI_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_UCI_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
        <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - SAI</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'SAI'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_SAI; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_SAI_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_SAI_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - PARTOS</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'PARTOS'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_partos; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_partos_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_partos_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
        </tr>  
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>   
       <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - PEDIATRIA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'PEDIATRIA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_pediatria; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_pediatria_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_pediatria_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td  width="50%"align="center">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - NEONATOLOGÍA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left"  style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'NEONATOLOGÍA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_neonatologia; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_neonatologia_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_neonatologia_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>  
           <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - PSIQUIATRÍA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'PSIQUIATRIA'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_psiquiatria; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_psiquiatria_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_psiquiatria_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            <td>&nbsp;</td>
             <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - CMI</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo 'CMI'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_CMI; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_CMI_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_CMI_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            </tr>  
                <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - 6TO PISO</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo '6TO PISO'; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_6to_piso; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_6to_piso_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_6to_piso_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            	<td>&nbsp;</td>
             <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - PUERPERIO</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;">PUERPERIO</td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_puerperio; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_puerperio_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_puerperio_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
                  <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - GINECOLOGIA</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;">GINECOLOGIA</td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_ginecologia; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_ginecologia_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_ginecologia_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            	<td>&nbsp;</td>
             <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - EMB. PATOLOGICO</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="27%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="26%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="22%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="25%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;">EMB. PATOLOGICO</td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_embarazo; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_embarazo_si ; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_embarazo_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            </tr>
                  <tr>
            <td align="center" width="50%">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="4" style="background-color:#3DB8B8; color:#FFF" align="center" id="title">RESUMEN POR SERVICIO - PENSIONADO</td>
                    </tr>
                      <tr style="background-color:#3DB8B8; color:#FFF" align="center" >
                        <td width="15%" style="border-top-color:#3DB8B8; border-top-style:solid;">SERVICIO</td>
                        <td width="19%" style="border-top-color:#3DB8B8; border-top-style:solid;">TOTAL EGRESOS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">C/ EPICRISIS</td>
                        <td width="18%" style="border-top-color:#3DB8B8; border-top-style:solid;">% EPICRISIS</td>
                      </tr>
                      <tr style="background-color:#FFF; " align="right">
                        <td align="left" style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;">PENSIONADO</td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $rows_pensionado; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo $cont_pensionado_si; ?></td>
                        <td style="border-top-color:#3DB8B8; border-top-style:solid;border-bottom-color:#3DB8B8; border-bottom-style:solid;"><? echo number_format($por_pensionado_si,1,",",".");  ?></td>
                      </tr>
                </table>
            </td>
            	<td>&nbsp;</td>
             	<td>&nbsp;</td>
            </tr>
         <? } ?>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
           <? if($rows > 0){ ?>
      <tr class='noprint'>
	<td colspan="3" align="left"><a href="javascript: PDF()" style="text-decoration:none;color:#666" class="input">GENERAR PDF <img src="../reportes/css/pdf.png" width="48" height="48" title="PDF" style="cursor:pointer; border:none; text-decoration:none"  align="absmiddle" class="input"/></a></td>
  	</tr> 
    <? } ?>
         <tr>
            <td colspan="3">&nbsp;</td>
        </tr> 
       
 </table> 
 </td>
 </tr>
 </table>
     <script>
 		function PDF(){
        window.open('../reportes/prueba_medica.php?desde=<? echo cambiarFormatoFecha2($fechaD1); ?>&hasta=<? echo cambiarFormatoFecha2($fechaH1);?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
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
          cal.manageFields("verH1", "fechaH1", "%d-%m-%Y");
    </script>
   
