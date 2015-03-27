<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
include '../../procesos/base.php';
conectarse(); 
     $total=0;
    $total1 = 0;
    $concepto ="";
    $consulta1=pg_query("select  T.fecha_actual, T.hora_actual, U.nombre_usuario, U.apellido_usuario, T.tipo_transaccion, T.num_transaccion, T.abreviatura, T.concepto, T.total_debe, T.total_haber, T.diferencia from transacciones T, usuario U where T.id_usuario=U.id_usuario and T.comprobante='$_GET[id]'");
    while($row=pg_fetch_row($consulta1)){
         $tipo = $row[4];
         $fecha= $row[0];
         $num = $row[5];
         $total=$row[8];
         $total1 = $row[9];
         $concepto = $row[7];
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['empresa'].'</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['slogan'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['propietario'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">'.$_SESSION['direccion'].'</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: '.$_SESSION['telefono'].' Cel:  '.$_SESSION['celular'].' '.$_SESSION['pais_ciudad'].'</h4>
            </div>            
    </header>        
    <hr>
    
    <div id="linea">
        <h3>COMPROBANTE DE: '.$tipo.'</h3>
    </div>';
    }
    $codigo.='<h2 style="color:#1B8D72;font-weight: bold;font-size:13px;">Transación Nro: 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nro de Documento: '.$num.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha: '.$fecha.'</h2>';

    $repetido=0;         
    $sql1=pg_query("select P.id_plan_cuentas, P.codigo_plan, P.descripcion, D.tipo_referencia, D.num_referencia, D.debito, D.credito  from transacciones T, detalle_transaccion D, plan_cuentas P where T.id_transacciones = D.id_transacciones and D.id_plan_cuentas = P.id_plan_cuentas and  T.comprobante='$_GET[id]' order by P.id_plan_cuentas asc");
    if(pg_num_rows($sql1)){
        while($row1=pg_fetch_row($sql1)){                
            if($repetido==0){                        
                $codigo.='<table>'; 
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">Cod. Cuenta</td>    
                <td style="width:170px;text-align:center;">Descripcion</td>
                <td style="width:100px;text-align:center;">Tipo Ref</td>    
                <td style="width:150px;text-align:center;"># Ref</td>
                <td style="width:100px;text-align:center;">Debito</td>
                <td style="width:100px;text-align:center;">Credito</td></tr><hr>';                           
                $repetido=1;
                $contador=1;
                $codigo.='</table>'; 
            }  
            $codigo.='<table border = 0 style ="font-size :10px;">';             
            $codigo.='<tr>                
            <td style="width:100px;text-align:center;">'.$row1[1].'</td>    
            <td style="width:170px;text-align:center;">'.$row1[2].'</td>    
            <td style="width:100px;text-align:center;">'.$row1[3].'</td>    
            <td style="width:150px;text-align:center;">'.$row1[4].'</td>
            <td style="width:100px;text-align:center;">'.$row1[5].'</td>            
            <td style="width:100px;text-align:center;">'.$row1[6].'</td></tr>';
            $repetido=1;   
            
            $codigo.='</table>';                
                 
        }                 
    }
    if($contador>0){
        $codigo.='<hr>';
        $codigo.='<table border = 0>';                                                
        $codigo.='<tr>
        <td style="width:530px;text-align:left;font-weight:bold">'."Totales".'</td>
        <td style="width:100px;text-align:center;font-weight:bold">'.$total.'</td>
        <td style="width:100px;text-align:center;font-weight:bold">'.$total1.'</td>';
        $codigo.='</tr>';          
        $codigo.='</table>'; 
        
        $codigo.='<table border = 0>';                                                
        $codigo.='<tr>         
        <td style="width:100px;text-align:left;font-weight:bold">'."CONCEPTO: ".'</td>        
        <td style="width:650px;text-align:left;font-weight:bold">'.$concepto.'</td>';
        $codigo.='</tr>';          
        $codigo.='</tr>';          
        $codigo.='</table>'; 
        $codigo.='<br/>';
    }      
    
               
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","1000M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('facturas_canceladas.pdf',array('Attachment'=>0));
?>