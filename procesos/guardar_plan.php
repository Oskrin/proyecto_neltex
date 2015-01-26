<?php

session_start();
include 'base.php';
conectarse();
error_reporting(0);

///////////////////contador clientes////////////////////////
$cont = 0;
$consulta = pg_query("select max(id_plan_cuentas) from plan_cuentas");
while ($row = pg_fetch_row($consulta)) {
    $cont = $row[0];
}
$cont++;
/////////////////////////////////////////////////////////

if (pg_query("insert into plan_cuentas values('$cont','$_POST[codigo_cuenta]','$_POST[descripcion]','$_POST[tipo]','$_POST[cuenta]','$_POST[ruc]','Activo')")) {
    $data = 1;
}

echo $data;
?>
