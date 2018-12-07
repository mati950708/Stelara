<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-type, X-Auth-Token');
header('Content-Type: application/json');
$host = 'localhost';
$port = 5432;
$db = 'Stelara';
$user = 'postgres';
$pass = 'postgres';
$json;

$cadena = "host='$host' port='$port' dbname='$db' user='$user' password='$pass'";
$con = pg_connect($cadena) or die("Error de conexión ".pg_last_error());


$query = 'SELECT producto.nombre as producto_nombre, categoria_p.nombre as categoria_nombre, producto.precio_unit, producto.cantidad_actual, producto.observaciones FROM producto INNER JOIN categoria_p on producto.category_id = categoria_p.id';
$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

// Imprimiendo los resultados en HTML

  $i=0;
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

	$rawdata[$i] = $line;
        $i++;
 
}

  $myArray = $rawdata;
        echo json_encode($myArray);
?>