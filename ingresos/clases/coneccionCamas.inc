<?
class coneccionCamas{
private $lnk; // puntero a la BD
private $user;
private $pass;
private $server; // nombre del servidor
private $database; // nombre de la base de datos
private $rs; // resultado de la consulta

function __construct(){
        $this->user = "gestioncamas";
        $this->pass = "123gestioncamas";
        $this->server = "localhost";
        $this->database = "camas";
}
function db_connect(){
  $this->lnk = mysql_connect($this->server,$this->user,$this->pass) or die ("ERROR EN LA CONEXION A LA BASE DE DATOS PACIENTES ...");
  mysql_select_db($this->database,$this->lnk) or die ("ERROR EN LA BASE DE DATOS PACIENTES");
  return($this->lnk);
}
function db_close($link){
        mysql_close($link);
}
}
?>