<? 
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0); 
?>
<table width="auto" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr>
    <td>
      <fieldset>
        <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0"> 
          <tr class='noprint'>
            <td height="40" colspan="2" align="left" >FECHA INICIO
              <input name="fechaD1" type="text" id="fechaD1" readonly="readonly" size="7" value="<? if ($fechaD1) echo $fechaD1; else echo date('d-m-Y');?>" /> 
              <a id="verD1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a> &nbsp;&nbsp; FECHA FIN
              <input name="fechaF1" type="text" id="fechaF1" readonly="readonly" size="7" value="<? if ($fechaF1) echo $fechaF1; else echo date('d-m-Y');?>" /> 
              <a id="verF1" class="mouse" title="Abrir Calendario"><img src="../img/calen.png" align="absmiddle" /></a>
              <img src="../img/search2.gif" width="24" height="24" align="absmiddle" onclick="javascript:frm_info_gcamas.act.value='1'; document.frm_info_gcamas.submit()" style="cursor:pointer"/>
            </td>
            <td align="right"></td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="right">&nbsp;</td>
  </tr> 
  <tr>
    <td  align="center" colspan="3" style="font-size:18px">REM A-03<br /></td>
  </tr>
</table>
<table id="Exportar_a_Excel" align="center" border="1px" cellpadding="5" cellspacing="0">
  <tr>
    <td>
      <table>
        <tr>
          <td>SERVICIO DE SALUD</td>
        </tr>
        <tr>
          <td>COMUNA: Arica</td>
        </tr>
        <tr>
          <td>ESTABLECIMIENTO/ESTRATEGIA: (Hospital Regional de arica Dr. Juan Noe)</td>
        </tr>
        <tr>
          <td>Mes <?=date('m', strtotime($fechaF1));?></td>
        </tr>
        <tr>
          <td>a&ntilde;o <?=date('Y', strtotime($fechaF1));?></td>
        </tr>
      </table>
    </td>
    <td colspan="17">REM-A03. APLICACION Y RESULTADOS DE ESCALAS DE EVALUACION</td>
  </tr>
  <tr>
    <td colspan="18">SECCION D.5 VARIACION DE RESULTADO DE APLICACION DEL INDICE DE BARTHEL ENTRE EL INGRESO Y EGRESO HOSPITALARIO</td>
  </tr>
  <tr>
    <td rowspan="3">INDICE DE BARTHEL</td>
    <td colspan="3"><center>TOTAL</center></td>
    <td colspan="14"><center>POR EDAD</center></td>
  </tr>
  <tr>
    <td rowspan="2">Ambos Sexos</td>
    <td rowspan="2">Hombres</td>
    <td rowspan="2">mujeres</td>
    <td colspan="2">60 a 64</td>
    <td colspan="2">65 a 69</td>
    <td colspan="2">70 a 74</td>
    <td colspan="2">75 a 79</td>
    <td colspan="2">80 a 84</td>
    <td colspan="2">85 a 89</td>
    <td colspan="2">90 a mas a&ntilde;os</td>
  </tr>
  <tr>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
    <td>Hombres</td>
    <td>Mujeres</td>
  </tr>
  <tr>
    <td>MEJORA INDICE DE BARTHEL</td>
    <td><? echo ($datos["60a64Mme"]+$datos["65a69Mme"]+$datos["70a74Mme"]+$datos["75a79Mme"]+$datos["80a84Mme"]+$datos["85a89Mme"]+$datos["90Mme"]+$datos["60a64Fme"]+$datos["65a69Fme"]+$datos["70a74Fme"]+$datos["75a79Fme"]+$datos["80a84Fme"]+$datos["85a89Fme"]+$datos["90Fme"]);?></td>
    <td><? echo ($datos["60a64Mme"]+$datos["65a69Mme"]+$datos["70a74Mme"]+$datos["75a79Mme"]+$datos["80a84Mme"]+$datos["85a89Mme"]+$datos["90Mme"]);?></td>
    <td><? echo ($datos["60a64Fme"]+$datos["65a69Fme"]+$datos["70a74Fme"]+$datos["75a79Fme"]+$datos["80a84Fme"]+$datos["85a89Fme"]+$datos["90Fme"]);?></td>
    <td><?=$datos["60a64Mme"];?></td>
    <td><?=$datos["60a64Fme"];?></td>
    <td><?=$datos["65a69Mme"];?></td>
    <td><?=$datos["65a69Fme"];?></td>
    <td><?=$datos["70a74Mme"];?></td>
    <td><?=$datos["70a74Fme"];?></td>
    <td><?=$datos["75a79Mme"];?></td>
    <td><?=$datos["75a79Fme"];?></td>
    <td><?=$datos["80a84Mme"];?></td>
    <td><?=$datos["80a84Fme"];?></td>
    <td><?=$datos["85a89Mme"];?></td>
    <td><?=$datos["85a89Fme"];?></td>
    <td><?=$datos["90Mme"];?></td>
    <td><?=$datos["90Fme"];?></td>
  </tr>
  <tr>
    <td>MANTIENE INDICE DE BARTHEL</td>
    <td><? echo ($datos["60a64Mma"]+$datos["65a69Mma"]+$datos["70a74Mma"]+$datos["75a79Mma"]+$datos["80a84Mma"]+$datos["85a89Mma"]+$datos["90Mma"]+$datos["60a64Fma"]+$datos["65a69Fma"]+$datos["70a74Fma"]+$datos["75a79Fma"]+$datos["80a84Fma"]+$datos["85a89Fma"]+$datos["90Fma"]);?></td>
    <td><? echo ($datos["60a64Mma"]+$datos["65a69Mma"]+$datos["70a74Mma"]+$datos["75a79Mma"]+$datos["80a84Mma"]+$datos["85a89Mma"]+$datos["90Mma"]);?></td>
    <td><? echo ($datos["60a64Fma"]+$datos["65a69Fma"]+$datos["70a74Fma"]+$datos["75a79Fma"]+$datos["80a84Fma"]+$datos["85a89Fma"]+$datos["90Fma"]);?></td>
    <td><?=$datos["60a64Mma"];?></td>
    <td><?=$datos["60a64Fma"];?></td>
    <td><?=$datos["65a69Mma"];?></td>
    <td><?=$datos["65a69Fma"];?></td>
    <td><?=$datos["70a74Mma"];?></td>
    <td><?=$datos["70a74Fma"];?></td>
    <td><?=$datos["75a79Mma"];?></td>
    <td><?=$datos["75a79Fma"];?></td>
    <td><?=$datos["80a84Mma"];?></td>
    <td><?=$datos["80a84Fma"];?></td>
    <td><?=$datos["85a89Mma"];?></td>
    <td><?=$datos["85a89Fma"];?></td>
    <td><?=$datos["90Mma"];?></td>
    <td><?=$datos["90Fma"];?></td>
  </tr>
  <tr>
    <td>DISMINUYE INDICE DE BARTHEL</td>
    <td><? echo ($datos["60a64Mem"]+$datos["65a69Mem"]+$datos["70a74Mem"]+$datos["75a79Mem"]+$datos["80a84Mem"]+$datos["85a89Mem"]+$datos["90Mem"]+$datos["60a64Fem"]+$datos["65a69Fem"]+$datos["70a74Fem"]+$datos["75a79Fem"]+$datos["80a84Fem"]+$datos["85a89Fem"]+$datos["90Fem"]);?></td>
    <td><? echo ($datos["60a64Mem"]+$datos["65a69Mem"]+$datos["70a74Mem"]+$datos["75a79Mem"]+$datos["80a84Mem"]+$datos["85a89Mem"]+$datos["90Mem"]);?></td>
    <td><? echo ($datos["60a64Fem"]+$datos["65a69Fem"]+$datos["70a74Fem"]+$datos["75a79Fem"]+$datos["80a84Fem"]+$datos["85a89Fem"]+$datos["90Fem"]);?></td>
    <td><?=$datos["60a64Mem"];?></td>
    <td><?=$datos["60a64Fem"];?></td>
    <td><?=$datos["65a69Mem"];?></td>
    <td><?=$datos["65a69Fem"];?></td>
    <td><?=$datos["70a74Mem"];?></td>
    <td><?=$datos["70a74Fem"];?></td>
    <td><?=$datos["75a79Mem"];?></td>
    <td><?=$datos["75a79Fem"];?></td>
    <td><?=$datos["80a84Mem"];?></td>
    <td><?=$datos["80a84Fem"];?></td>
    <td><?=$datos["85a89Mem"];?></td>
    <td><?=$datos["85a89Fem"];?></td>
    <td><?=$datos["90Mem"];?></td>
    <td><?=$datos["90Fem"];?></td>
  </tr>
  <tr>
    <td>PROMEDIO PUNTUACION BARTHEL BASAL</td>
    <td><? 
    $basalambosexos = ($datos["60a64Mbasal"]+$datos["60a64Fbasal"]+$datos["65a69Mbasal"]+$datos["65a69Fbasal"]+$datos["70a74Mbasal"]+$datos["70a74Fbasal"]+$datos["75a79Mbasal"]+$datos["75a79Fbasal"]+$datos["80a84Mbasal"]+$datos["80a84Fbasal"]+$datos["85a89Mbasal"]+$datos["85a89Fbasal"]+$datos["90Mbasal"]+$datos["90Fbasal"]);
    $basalambosexoscantidad = ($datos["60a64Mbasalcantidad"]+$datos["60a64Fbasalcantidad"]+$datos["65a69MbasalCantidad"]+$datos["65a69Fbasalcantidad"]+$datos["70a74Mbasalcantidad"]+$datos["70a74Fbasalcantidad"]+$datos["75a79Mbasalcantidad"]+$datos["75a79Fbasalcantidad"]+$datos["80a84Mbasalcantidad"]+$datos["80a84Fbasalcantidad"]+$datos["85a89Mbasalcantidad"]+$datos["85a89Fbasalcantidad"]+$datos["90Mbasalcantidad"]+$datos["90Fbasalcantidad"]);
    if($basalambosexos > 0 and $basalambosexoscantidad >0){
      echo number_format($basalambosexos/$basalambosexoscantidad,2,",",".");
    }
    ?></td>
    <td><? 
    $basalmasculinos = ($datos["60a64Mbasal"]+$datos["65a69Mbasal"]+$datos["70a74Mbasal"]+$datos["75a79Mbasal"]+$datos["80a84Mbasal"]+$datos["85a89Mbasal"]+$datos["90Mbasal"]);
    $basalmasculinoscantidad = ($datos["60a64Mbasalcantidad"]+$datos["65a69MbasalCantidad"]+$datos["70a74Mbasalcantidad"]+$datos["75a79Mbasalcantidad"]+$datos["80a84Mbasalcantidad"]+$datos["85a89Mbasalcantidad"]+$datos["90Mbasalcantidad"]);
    if($basalmasculinos > 0 and $basalmasculinoscantidad>0){
      echo number_format($basalmasculinos/$basalmasculinoscantidad,2,",",".");
    }
    ?></td>
    <td><? 
    $basalmujeres = ($datos["60a64Fbasal"]+$datos["65a69Fbasal"]+$datos["70a74Fbasal"]+$datos["75a79Fbasal"]+$datos["80a84Fbasal"]+$datos["85a89Fbasal"]+$datos["90Fbasal"]);
    $basalmujerescantidad = ($datos["60a64Fbasalcantidad"]+$datos["65a69Fbasalcantidad"]+$datos["70a74Fbasalcantidad"]+$datos["75a79Fbasalcantidad"]+$datos["80a84Fbasalcantidad"]+$datos["85a89Fbasalcantidad"]+$datos["90Fbasalcantidad"]);
    if($basalmujeres>0 and $basalmujerescantidad>0){
      echo number_format($basalmujeres/$basalmujerescantidad,2,",",".");
    }
    ?></td>
    <td><? if($datos["60a64Mbasal"] > 0){ echo (number_format($datos["60a64Mbasal"] / $datos["60a64Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["60a64Fbasal"] > 0){ echo (number_format($datos["60a64Fbasal"] / $datos["60a64Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["65a69Mbasal"] > 0){ echo (number_format($datos["65a69Mbasal"] / $datos["65a69MbasalCantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["65a69Fbasal"] > 0){ echo (number_format($datos["65a69Fbasal"] / $datos["65a69Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["70a74Mbasal"] > 0){ echo (number_format($datos["70a74Mbasal"] / $datos["70a74Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["70a74Fbasal"] > 0){ echo (number_format($datos["70a74Fbasal"] / $datos["70a74Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["75a79Mbasal"] > 0){ echo (number_format($datos["75a79Mbasal"] / $datos["75a79Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["75a79Fbasal"] > 0){ echo (number_format($datos["75a79Fbasal"] / $datos["75a79Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["80a84Mbasal"] > 0){ echo (number_format($datos["80a84Mbasal"] / $datos["80a84Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["80a84Fbasal"] > 0){ echo (number_format($datos["80a84Fbasal"] / $datos["80a84Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["85a89Mbasal"] > 0){ echo (number_format($datos["85a89Mbasal"] / $datos["85a89Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["85a89Fbasal"] > 0){ echo (number_format($datos["85a89Fbasal"] / $datos["85a89Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["90Mbasal"] > 0){ echo (number_format($datos["90Mbasal"] / $datos["90Mbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
    <td><? if($datos["90Fbasal"] > 0){ echo (number_format($datos["90Fbasal"] / $datos["90Fbasalcantidad"],2,",",".")); }else{ echo ""; } ?></td>
  </tr>
  <tr>
    <td>TOTAL</td>
    <td><? echo ($datos["60a64Mme"]+$datos["65a69Mme"]+$datos["70a74Mme"]+$datos["75a79Mme"]+$datos["80a84Mme"]+$datos["85a89Mme"]+$datos["90Mme"]+$datos["60a64Fme"]+$datos["65a69Fme"]+$datos["70a74Fme"]+$datos["75a79Fme"]+$datos["80a84Fme"]+$datos["85a89Fme"]+$datos["90Fme"]+$datos["60a64Mma"]+$datos["65a69Mma"]+$datos["70a74Mma"]+$datos["75a79Mma"]+$datos["80a84Mma"]+$datos["85a89Mma"]+$datos["90Mma"]+$datos["60a64Fma"]+$datos["65a69Fma"]+$datos["70a74Fma"]+$datos["75a79Fma"]+$datos["80a84Fma"]+$datos["85a89Fma"]+$datos["90Fma"]+$datos["60a64Mem"]+$datos["65a69Mem"]+$datos["70a74Mem"]+$datos["75a79Mem"]+$datos["80a84Mem"]+$datos["85a89Mem"]+$datos["90Mem"]+$datos["60a64Fem"]+$datos["65a69Fem"]+$datos["70a74Fem"]+$datos["75a79Fem"]+$datos["80a84Fem"]+$datos["85a89Fem"]+$datos["90Fem"]);?></td>
    <td><? echo ($datos["60a64Mme"]+$datos["65a69Mme"]+$datos["70a74Mme"]+$datos["75a79Mme"]+$datos["80a84Mme"]+$datos["85a89Mme"]+$datos["90Mme"]+$datos["60a64Mma"]+$datos["65a69Mma"]+$datos["70a74Mma"]+$datos["75a79Mma"]+$datos["80a84Mma"]+$datos["85a89Mma"]+$datos["90Mma"]+$datos["60a64Mem"]+$datos["65a69Mem"]+$datos["70a74Mem"]+$datos["75a79Mem"]+$datos["80a84Mem"]+$datos["85a89Mem"]+$datos["90Mem"]);?></td>
    <td><? echo ($datos["60a64Fme"]+$datos["65a69Fme"]+$datos["70a74Fme"]+$datos["75a79Fme"]+$datos["80a84Fme"]+$datos["85a89Fme"]+$datos["90Fme"]+$datos["60a64Fma"]+$datos["65a69Fma"]+$datos["70a74Fma"]+$datos["75a79Fma"]+$datos["80a84Fma"]+$datos["85a89Fma"]+$datos["90Fma"]+$datos["60a64Fem"]+$datos["65a69Fem"]+$datos["70a74Fem"]+$datos["75a79Fem"]+$datos["80a84Fem"]+$datos["85a89Fem"]+$datos["90Fem"])?></td>
    <td><? echo ($datos["60a64Mme"]+$datos["60a64Mma"]+$datos["60a64Mem"]); ?></td>
    <td><? echo ($datos["60a64Fme"]+$datos["60a64Fma"]+$datos["60a64Fem"]); ?></td>
    <td><? echo ($datos["65a69Mme"]+$datos["65a69Mma"]+$datos["65a69Mem"]); ?></td>
    <td><? echo ($datos["65a69Fme"]+$datos["65a69Fma"]+$datos["65a69Fem"]); ?></td>
    <td><? echo ($datos["70a74Mme"]+$datos["70a74Mma"]+$datos["70a74Mem"]); ?></td>
    <td><? echo ($datos["70a74Fme"]+$datos["70a74Fma"]+$datos["70a74Fem"]); ?></td>
    <td><? echo ($datos["75a79Mme"]+$datos["75a79Mma"]+$datos["75a79Mem"]); ?></td>
    <td><? echo ($datos["75a79Fme"]+$datos["75a79Fma"]+$datos["75a79Fem"]); ?></td>
    <td><? echo ($datos["80a84Mme"]+$datos["80a84Mma"]+$datos["80a84Mem"]); ?></td>
    <td><? echo ($datos["80a84Fme"]+$datos["80a84Fma"]+$datos["80a84Fem"]); ?></td>
    <td><? echo ($datos["85a89Mme"]+$datos["85a89Mma"]+$datos["85a89Mem"]); ?></td>
    <td><? echo ($datos["85a89Fme"]+$datos["85a89Fma"]+$datos["85a89Fem"]); ?></td>
    <td><? echo ($datos["90Mme"]+$datos["90Mma"]+$datos["90Mem"]); ?></td>
    <td><? echo ($datos["90Fme"]+$datos["90Fma"]+$datos["90Fem"]); ?></td>
  </tr>
</table>
     <script>
    function PDF(){
        window.open('../reportes/PDF_barthel.php?desde=<? echo cambiarFormatoFecha2($fechaD1); ?>&hasta=<? echo cambiarFormatoFecha2($fechaF1);?>','','titlebars=0, toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1440,height=780');
    }
    </script> 
    <script type="text/javascript">
    var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          cal.manageFields("verD1", "fechaD1", "%d-%m-%Y");
      cal.manageFields("verF1", "fechaF1", "%d-%m-%Y");
    </script>
   
