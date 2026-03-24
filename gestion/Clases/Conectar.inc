<?
class conectar{
	private $lnk; //puntero a la BD
	private $user;
	private $pass;
	private $server; //nombre del servidor
	private $database; //nombre de la base de datos
	private $rs; //resultado de la consulta.
	
	function __construct(){
		$this->user = "gestioncamas";
		$this->pass = "123gestioncamas";
		$this->server = "10.6.21.29";
	}
	
	function db_connect(){
		$this->lnk = mysql_connect($this->server,$this->user,$this->pass) or die("Error de conexion a BD");
		return ($this->lnk);
	}
	
	function db_select($base,$link){
		mysql_select_db($base,$link) or die("Error al Seleccionar BD $base");
	}
	
	function db_close($link){
		mysql_close($link);
	}
}
?>

