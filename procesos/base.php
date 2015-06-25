<?php

function conectarse() {
<<<<<<< HEAD
    if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=sis_web user=postgres password=rootdow"))) {
=======
    if (!($conexion = pg_pconnect("host=localhost port=5432 dbname=sisweb user=postgres password=sisweb"))) {
>>>>>>> origin/master
        exit();
    } else {
        
    }
    return $conexion;
}

conectarse();
?>
