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


$query = 'SELECT registro.fecha as fecha, producto.nombre as nombre_producto, registro.cantidad as cantidad_registro, registro.precio_venta as registro_pv, registro.precio_costo as registro_pc, cliente.nombre as nombre_cliente, cliente.apaterno, cliente.amaterno, tipo_r.nombre as tipo_r_nombre FROM registro
INNER JOIN cliente  on "registro"."cliente_id" = "cliente"."id"
INNER JOIN tipo_r  on registro.tipo_r_id = tipo_r.id
	INNER JOIN producto   on registro.producto_id = producto.id
ORDER BY fecha DESC;';
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