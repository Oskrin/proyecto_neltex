<?php

function conectarse() {
    if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=ventas_catalogo user=postgres password=rootdow"))) {
        exit();
    } else {
        
    }
    return $conexion;
}

conectarse();
?>
