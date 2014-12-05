<?php
require('../reportes/dompdf/dompdf_config.inc.php');
session_start();
    $codigo='<html> 
    <head> 
        <link rel="stylesheet" href="../css/estilosAgrupados.css" type="text/css" /> 
          <style>
          @page { margin: 0px 0px 0px 0px; }
          </style>
    </head> 
    <body>
        <header style="height:170px;border:solid 0px;">            
            <div id="me">
                
            </div>        
    </header>';
    include '../procesos/base.php';
    conectarse();    
    $total=0;
    $repetido=0;    
    $sql=pg_query("select id_factura_venta,num_factura,nombre_empresa,telefono_empresa,direccion_empresa,email_empresa,pagina_web,ruc_empresa,nombres_cli,identificacion,direccion_cli,telefono,ciudad,fecha_actual,forma_pago,fecha_cancelacion,nombre_usuario,apellido_usuario from factura_venta,clientes,empresa,usuario where factura_venta.id_cliente=clientes.id_cliente and empresa.id_empresa=factura_venta.id_empresa and factura_venta.id_usuario=usuario.id_usuario and factura_venta.id_factura_venta='$_GET[id]'");
    while($row=pg_fetch_row($sql)){        
        $codigo.='<table border=0>';
        $codigo.='<tr>                
            <td style="width:105px;text-align:center;font-size:8px;height:25px;">&nbsp;</td>                
            <td style="width:300px;font-size:10px;">'.$row[8].'</td>            
            <td style="width:55px;text-align:center;font-size:10px;height:25px;">DIR:</td>                
            <td style="width:640px;font-size:10px;">'.$row[8].'</td>            
        </tr>';        
        $codigo.='</table>';             
        $codigo.='<table border=0>';
        $codigo.='<tr>                
            <td style="width:105px;text-align:center;height:24px;">&nbsp;</td>                
            <td style="width:380px;font-size:10px;">'.$row[13].'</td>            
            <td style="width:60px;text-align:left;">&nbsp;</td>                
            <td style="width:300px;font-size:10px;">'.$row[9].'</td>            
        </tr>';        
        $codigo.='</table>';             
        $codigo.='<table border=0>';
        $codigo.='<tr>                
            <td style="width:115px;text-align:center;height:25px;">&nbsp;</td>                
            <td style="width:370px;font-size:10px;">'.$row[10].'</td>            
            <td style="width:110px;text-align:center;">&nbsp;</td>                
            <td style="width:300px;font-size:10px;">'.$row[11].'</td>            
        </tr>';        
        $codigo.='</table>';                                     
    }
    $sql = pg_query("select detalle_factura_venta.cantidad,productos.articulo,detalle_factura_venta.precio_venta,detalle_factura_venta.total_venta,codigo from factura_venta,detalle_factura_venta,productos where factura_venta.id_factura_venta=detalle_factura_venta.id_factura_venta and detalle_factura_venta.cod_productos=productos.cod_productos and detalle_factura_venta.id_factura_venta='$_GET[id]'");
    $codigo.='<br /><br /><br /> <br /><br /><table border=0>';
    while($row=pg_fetch_row($sql)){ 
        $codigo.='<tr>                
            <td style="width:90px;text-align:center;height:19px;font-size:10px;">'.$row[0].'</td> 
            <td style="width:400px;height:19px;font-size:10px;">'.$row[4].' '. $row[1].'</td>             
		<td style="width:40px;height:19px;font-size:10px;">'.$row[2].'</td>             
            <td style="width:110px;text-align:center;height:19px;font-size:10px;">'.(number_format(($row[3] / 1.12),2,',','.')).'</td> 
            <td style="width:100px;text-align:center;height:19px;font-size:10px;">'.(number_format(($row[3] / 1.12) * $row[0],2,',','.')) .'</td> 
        </tr>';
                                       
    }    
    $codigo.='</table>';

    $sql = pg_query("select factura_venta.descuento_venta,factura_venta.tarifa0,factura_venta.tarifa12,factura_venta.iva_venta,factura_venta.total_venta from factura_venta where factura_venta.id_factura_venta='$_GET[id]'");      
    $codigo.='<div id="footer">';
    $codigo.='<table border=0">';    
    while($row=pg_fetch_row($sql)){ 
        $codigo.='<tr>                
            <td style="width:660px;text-align:center;height:27px;font-size:10px;">&nbsp;</td> 
            <td style="width:90px;text-align:center;height:27px;font-size:10px;">'.$row[2].'</td>             
        </tr>';
        $codigo.='<tr>                
            <td style="width:660px;text-align:center;height:29px;font-size:10px;">&nbsp;</td> 
            <td style="width:90px;text-align:center;height:29px;font-size:10px;">'.$row[0].'</td>             
        </tr>';
        $codigo.='<tr>                
            <td style="width:660px;text-align:center;height:29px;font-size:10px;">&nbsp;</td> 
            <td style="width:90px;text-align:center;height:29px;font-size:10px;">'.$row[3].'</td>             
        </tr>';
        $codigo.='<tr>                
            <td style="width:660px;text-align:center;height:29px;font-size:10px;">&nbsp;</td> 
            <td style="width:90px;text-align:center;height:29px;font-size:10px;">'.$row[4].'</td>             
        </tr>';   
    }     
    $codigo.='</table>';                            
    $codigo.='</div>';

    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    $pdf = $dompdf->output();    
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_agrupados_prov.pdf',array('Attachment'=>0));
?>