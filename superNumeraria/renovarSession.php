<? ob_start();
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
</head>
<?
if (isset($_POST['urlOrigen'])) 
	$urlOrigen = $_POST['urlOrigen'];
if (isset($_GET['urlOrigen'])) 
	$urlOrigen = $_GET['urlOrigen'];

if (isset($_POST['user'])) {
$login = $_POST['user'];
$password = $_POST['password'];
$MM_redirecttoReferrer = true;
$dbhost = $_SESSION['BD_SERVER'];
$a=mysql_connect($dbhost,'gestioncamas','123gestioncamas',true);
mysql_select_db('acceso',$a) or die(mysql_error());
  	
$query="SELECT usuario.idusuario, usuario.claveacceso, usuario.nombreusuario, usuario_has_servicio.idservicio
                FROM usuario
                Inner Join usuario_has_servicio ON usuario.idusuario = usuario_has_servicio.idusuario
                WHERE usuario.idusuario='$login' AND usuario_has_servicio.estado = 'A' 
				AND AES_DECRYPT(claveacceso,'idusuario')= '$password'"; 
  
$LoginRS = mysql_query($query, $a) or die(mysql_error());
$row_LoginRS = mysql_fetch_assoc($LoginRS);
$loginFoundUser = mysql_num_rows($LoginRS);
  
if ($loginFoundUser > 0) {
	//declare two session variables and assign them
  	$_SESSION['MM_Username'] = $login;
	$_SESSION['MM_UsernameName'] = $row_LoginRS['nombreusuario'];
	$_SESSION['MM_Servicio'] = $row_LoginRS['idservicio'];
	$query_rs_AplicacionesxUsuarios = "SELECT rol_idrol FROM usuario_has_rol WHERE usuario_idusuario = '$_SESSION[MM_Username]' ORDER BY rol_idrol ASC";

  	$insertGoTo = $urlOrigen;
  	header(sprintf("Location: %s", $insertGoTo)); 
  }
}
?>
<body>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" id="id" name="id" value="<? echo $id;?>" />
<input type="hidden" id="id" name="id" value="<? echo $id;?>" />

<table width="450" height="139" border="0" style="border:1px solid #000000;" align="center" cellpadding="4" cellspacing="4" background="../gestioncamas/ingresos/img/fondo.jpg">
  <tr>
    <th width="372" height="30px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF;">Renovar Sesión en el Sistema</th>
  </tr>
  <tr>
    <td height="110" align="left">
    	<fieldset class="fieldset_det2">
        <legend class="titulos">Ingrese datos</legend>
        <table width="100%" border="0">
          <tr>
            <td width="50%" align="right">Usuario:</td>
            <td width="50%"><label for="user"></label>
              <input type="text" name="user" id="user" /></td>
          </tr>
          <tr>
            <td align="right">Contraseña:</td>
            <td><label for="password"></label>
              <input type="password" name="password" id="password" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="enviar" id="enviar" value="   Acceder al sistema   " />
           </td>
            </tr>
        </table>
        </fieldset>
    </td>
  </tr>
</table>
</form>
</body>
</html>