<?php

require('../dompdf/dompdf_config.inc.php');
session_start();
$codigo = '<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['empresa'] . '</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['slogan'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['propietario'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['direccion'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: ' . $_SESSION['telefono'] . ' Cel:  ' . $_SESSION['celular'] . ' ' . $_SESSION['pais_ciudad'] . '</h4>
                <h4 style="text-align: center;width:50%;display: inline-block;">Desde el : ' . $_GET['inicio'] . '</h4>
                <h4 style="text-align: center;width:45%;display: inline-block;">Hasta el : ' . $_GET['fin'] . '</h4>
        
            </div>
    </header>        
    <hr>
    <div id="linea">
        <h3>REPORTE DE VENTAS POR DIRECTOR </h3>
    </div>';
include '../../procesos/base.php';
conectarse();
$consulta = pg_query("select id_director, identificacion_dire ,nombres from directores where id_director='$_GET[id]'");
while ($row = pg_fetch_row($consulta)) {
    $codigo.='<h2 style="font-weight: bold;font-size:12px;padding:5;margin:0px;border:solid 1px #000;color:blue;background:beige">DIRECTOR: ' . $row[2] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CI/RUC: ' . $row[1] . '</h2>';
}
$codigo.='<br /><table border=0>';
$codigo.='<tr>                    
    <td style="width:160px;text-align:left;">CI/RUC</td>
    <td style="width:400px;text-align:left;">Cliente</td>
    <td style="width:50px;text-align:left;">Nro Facturas</td>
    <td style="width:100px;text-align:center;">Total Factura</td></tr><hr></table>';
$codigo.='<table border = 0>';
$sql = pg_query("select id_cliente, identificacion, nombres_cli from clientes where id_director = '$_GET[id]' order by id_cliente asc;");
$cont1 = 0;
$cont2 = 0;
while ($row = pg_fetch_row($sql)) {
    $temp = 0;
    $temp1 = 0;
    $sql1 = pg_query("select count(id_factura_venta) as contador, SUM(total_venta::float) as total_venta from factura_venta where id_cliente ='$row[0]' and estado ='Activo'");
    while ($row1 = pg_fetch_row($sql1)) {
        $temp = $row1[0];
        if ($row1[1] == "") {
            $temp1 = "$ 0";
        } else {
            $temp1 = "$ " . $row1[1];
        }
        $cont1 = $cont1 + $row1[0];
        $cont2 = $cont2 + $row1[1];
    }
    $codigo.='<tr>
        <td style="width:160px;text-align:left;">' . $row[1] . '</td>    
        <td style="width:400px;text-align:left;">' . $row[2] . '</td>
        <td style="width:70px;text-align:center;">' . $temp . '</td>
        <td style="width:100px;text-align:center;">' . $temp1 . '</td>';
    $codigo.='</tr>';
}
$codigo.='</table>';
$codigo.='<table border=0>';
$codigo.='<tr><hr></tr></table>';
$codigo.='<table border=0>';
$codigo.='<tr>
        <td style="width:545px;text-align:left;">Totales</td>    
        <td style="width:95px;text-align:center;">' . $cont1 . '</td>    
        <td style="width:100px;text-align:center;">$ ' . $cont2 . '</td>    
    </tr></table>';
$codigo = utf8_decode($codigo);
$dompdf = new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit", "1000M");
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
//$dompdf->stream("reporteRegistro.pdf");
$dompdf->stream('diario_caja.pdf', array('Attachment' => 0));
?>
