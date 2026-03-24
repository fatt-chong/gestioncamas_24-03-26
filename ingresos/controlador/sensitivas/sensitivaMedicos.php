<?php session_start();
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$searchTerm = $_GET['searchTerm'];
if(!$sidx) $sidx = 1;
if($searchTerm == "") $searchTerm = "%"; else $searchTerm = "%" . $searchTerm . "%";
$dbhost = $_SESSION['BD_SERVER'];
$dbuser = "gestioncamas";
$dbpassword = "123gestioncamas";
$database = "parametros_clinicos";
// connect to the database
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
mysql_select_db($database) or die("Error conecting to db.");
mysql_query("SET NAMES utf8");
$result = mysql_query("SELECT count(*) as count FROM
						profesional_has_especialidad
						INNER JOIN profesional ON profesional_has_especialidad.PROcodigo = profesional.PROcodigo
						WHERE
						profesional_has_especialidad.ESPcodigo in ('07-301-0','07-300-1') AND 
						profesional.PROdescripcion like '%$searchTerm%'");
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$count = $row['count'];
if($count > 0) $total_pages = ceil($count/$limit); else $total_pages = 0;
if($page > $total_pages) $page = $total_pages;
$start = $limit * $page - $limit; // do not put $limit*($page - 1)
if($total_pages != 0){ 
	$SQL = "SELECT
			profesional.PROid_medico_camas,
			profesional.PROdescripcion,
			profesional.PROcodigo
			FROM
			profesional_has_especialidad
			INNER JOIN profesional ON profesional_has_especialidad.PROcodigo = profesional.PROcodigo
			WHERE
			profesional_has_especialidad.ESPcodigo in ('07-301-0','07-300-1') AND 
			profesional.PROdescripcion like '%$searchTerm%' ORDER BY $sidx $sord LIMIT $start , $limit";

	
}else{ 
	$SQL = "SELECT
			profesional.PROid_medico_camas,
			profesional.PROdescripcion,
			profesional.PROcodigo
			FROM
			profesional_has_especialidad
			INNER JOIN profesional ON profesional_has_especialidad.PROcodigo = profesional.PROcodigo
			WHERE
			profesional_has_especialidad.ESPcodigo in ('07-301-0','07-300-1') AND 
			profesional.PROdescripcion like '%$searchTerm%' ORDER BY $sidx $sord";
}
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$response->page = $page;
$response->total = $total_pages;
$response->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $response->rows[$i]['id_medico']=$row['PROcodigo'];
    $response->rows[$i]['nombre_medico']=$row['PROdescripcion'];
    $i++;
}        
echo json_encode($response);
?>