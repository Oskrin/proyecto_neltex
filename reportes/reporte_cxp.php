<?php
    require('../fpdf/fpdf.php');
    include '../procesos/base.php';
    include '../procesos/funciones.php';
    conectarse();    
    date_default_timezone_set('America/Guayaquil'); 
    session_start()   ;
    class PDF extends FPDF{   
        var $widths;
        var $aligns;       
        function SetWidths($w){            
            $this->widths=$w;
        }                       
        function Header(){                         
            $this->AddFont('Amble-Regular');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa'], 0,1, 'C',0);                                
            $this->Image('../images/logo_empresa.jpg',5,8,35,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);                                
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);                                                                                                    
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.4);            
            $this->Line(1,45,210,45);            
            $this->SetFont('Arial','B',12);                                                                            
            $this->Cell(190, 5, utf8_decode("RECIBO DE PAGO "),0,1, 'C',0);                                                                                                                            
            $this->SetFont('Amble-Regular','',10);        
            $this->Ln(3);
            $this->SetFillColor(255,255,225);            
            $this->SetLineWidth(0.2);                                        
        }
        function Footer(){            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    $pdf = new PDF('P','mm','a4');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Amble-Regular');                    
    $pdf->SetFont('Amble-Regular','',10);       
    $pdf->SetFont('Arial','B',9);   
    $pdf->SetX(5);    
    $pdf->SetFont('Amble-Regular','',9); 
    

    $saldo=0;
    $repetido=0;    
    if ($_GET['tipo_pago'] == "EXTERNA") {        
        $sql=pg_query("select * from c_pagarexternas,proveedores,usuario,empresa where c_pagarexternas.id_proveedor=proveedores.id_proveedor and c_pagarexternas.id_usuario=usuario.id_usuario and empresa.id_empresa=c_pagarexternas.id_empresa and num_factura='$_GET[id]'");        
        while($row=pg_fetch_row($sql)){
            if($repetido==0){
                $pdf->SetX(1); 
                $pdf->SetFillColor(187, 179, 180);            
                $pdf->Cell(50, 6, maxCaracter(utf8_decode('RUC/CI:'.$row[14]),35),1,0, 'L',1);                                     
                $pdf->Cell(80, 6, maxCaracter(utf8_decode('NOMBRES:'.$row[15]),35),1,0, 'L',1);                                     
                $pdf->Cell(75, 6, maxCaracter(utf8_decode('SECCIÓN:'.$row[43]),50),1,1, 'L',1);                                             
                $pdf->Ln(3);

                $pdf->SetX(1); 
                $pdf->Cell(30, 6, utf8_decode('Comprobante'),1,0, 'C',0);                                     
                $pdf->Cell(30, 6, utf8_decode('Tipo Documento'),1,0, 'C',0);                                     
                $pdf->Cell(50, 6, utf8_decode('Nro. Factura'),1,0, 'C',0);                                     
                $pdf->Cell(25, 6, utf8_decode('Total'),1,0, 'C',0);                                             
                $pdf->Cell(25, 6, utf8_decode('Valor Pago'),1,0, 'C',0);                                             
                $pdf->Cell(20, 6, utf8_decode('Saldo'),1,0, 'C',0);                                             
                $pdf->Cell(25, 6, utf8_decode('Fecha Pago'),1,1, 'C',0);                    
                $repetido=1;                   
            }                          
            $sql1=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and id_cuentas_pagar='$_GET[comprobante]'");
            while($row1=pg_fetch_row($sql1)){
                $pdf->Cell(30, 6, utf8_decode($row1[0]),0,0, 'C',0);                                         
                $pdf->Cell(30, 6, utf8_decode($row[9]),0,0, 'C',0);                                         
                $pdf->Cell(50, 6, utf8_decode($row[8]),0,0, 'C',0);                                         
                $pdf->Cell(25, 6, utf8_decode($row1[12] + $row1[13]),0,0, 'C',0);                                         
                $pdf->Cell(25, 6, utf8_decode($row1[12]),0,0, 'C',0);                                         
                $pdf->Cell(20, 6, utf8_decode($row1[13]),0,0, 'C',0);                                         
                $pdf->Cell(25, 6, utf8_decode($row1[4]),0,1, 'C',0);                 
                $saldo=$row1[13];
            }  
            $pdf->Ln(2);
            $pdf->Cell(205, 0, utf8_decode(''),1,1, 'R',0);                                     
            $pdf->Cell(187, 6, utf8_decode('Total Saldo'),0,0, 'R',0);                                     
            $pdf->Cell(20, 6,(number_format($saldo,2,',','.')) ,0,0, 'C',0);         
        }
    }
    else{        
        $sql=pg_query("select * from factura_compra,proveedores,usuario,empresa where factura_compra.id_proveedor=proveedores.id_proveedor and factura_compra.id_usuario=usuario.id_usuario and factura_compra.id_empresa=empresa.id_empresa and num_serie='$_GET[id]' and proveedores.id_proveedor='$_GET[proveedor]'");        
        while($row=pg_fetch_row($sql)){
            $pdf->SetX(1); 
            $pdf->SetFillColor(187, 179, 180);            
            $pdf->Cell(50, 6, maxCaracter(utf8_decode('RUC/CI:'.$row[23]),35),1,0, 'L',1);                                     
            $pdf->Cell(80, 6, maxCaracter(utf8_decode('NOMBRES:'.$row[24]),35),1,0, 'L',1);                                     
            $pdf->Cell(75, 6, maxCaracter(utf8_decode('SECCIÓN:'.$row[52]),50),1,1, 'L',1);                                             
            $pdf->Ln(3);
            
             $pdf->SetX(1); 
            $pdf->Cell(30, 6, utf8_decode('Comprobante'),1,0, 'C',0);                                     
            $pdf->Cell(30, 6, utf8_decode('Tipo Documento'),1,0, 'C',0);                                     
            $pdf->Cell(50, 6, utf8_decode('Nro. Factura'),1,0, 'C',0);                                     
            $pdf->Cell(25, 6, utf8_decode('Total'),1,0, 'C',0);                                             
            $pdf->Cell(25, 6, utf8_decode('Valor Pago'),1,0, 'C',0);                                             
            $pdf->Cell(20, 6, utf8_decode('Saldo'),1,0, 'C',0);                                             
            $pdf->Cell(25, 6, utf8_decode('Fecha Pago'),1,1, 'C',0);                    
        }        
        $sql=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and comprobante='$_GET[comprobante]'");
        $meses=0;
        $id_pv=0;
        while($row=pg_fetch_row($sql)){                        
            $pdf->Cell(30, 6, utf8_decode($row[3]),0,0, 'C',0);                                         
            $pdf->Cell(30, 6, utf8_decode($row[9]),0,0, 'C',0);                                         
            $pdf->Cell(50, 6, utf8_decode($_GET['id']),0,0, 'C',0);                                         
            $pdf->Cell(25, 6, utf8_decode($row[12] + $row[13]),0,0, 'C',0);                                         
            $pdf->Cell(25, 6, utf8_decode($row[12]),0,0, 'C',0);                                         
            $pdf->Cell(20, 6, utf8_decode($row[13]),0,0, 'C',0);                                         
            $pdf->Cell(25, 6, utf8_decode($row[4]),0,1, 'C',0);                         
            $saldo=$row[13];            
        }
        $pdf->Ln(2);
        $pdf->Cell(205, 0, utf8_decode(''),1,1, 'R',0);                                     
        $pdf->Cell(187, 6, utf8_decode('Total Saldo'),0,0, 'R',0);                                     
        $pdf->Cell(20, 6,(number_format($saldo,2,',','.')) ,0,0, 'C',0);         
    }    
    $pdf->Output();
?>
<?php
require('../dompdf/dompdf_config.inc.php');
session_start();
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
        <h3>RECIBO DE PAGO </h3>
    </div>';
    include '../../procesos/base.php';
    conectarse();    
    $saldo=0;
    $repetido=0;    
    if ($_GET['tipo_pago'] == "EXTERNA") {        
        $sql=pg_query("select * from c_pagarexternas,proveedores,usuario,empresa where c_pagarexternas.id_proveedor=proveedores.id_proveedor and c_pagarexternas.id_usuario=usuario.id_usuario and empresa.id_empresa=c_pagarexternas.id_empresa and num_factura='$_GET[id]'");        
        while($row=pg_fetch_row($sql)){
            if($repetido==0){
                $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[14].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[15].'</h2>
                <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[41].'</h2> ';
                $codigo.='<table>';                      
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">Comprobante</td>    
                <td style="width:100px;text-align:center;">Tipo Documento</td>
                <td style="width:150px;text-align:center;">Nro Factura</td>    
                <td style="width:100px;text-align:center;">Total</td>
                <td style="width:100px;text-align:center;">Valor Pago</td>
                <td style="width:100px;text-align:center;">Saldo</td>
                <td style="width:100px;text-align:center;">Fecha Pago</td></tr><hr>';
                $repetido=1;   
                $codigo.='</table>';         
            }
            $codigo.='<table>';                                                           
            $sql1=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and id_cuentas_pagar='$_GET[comprobante]'");
            while($row1=pg_fetch_row($sql1)){
                $codigo.='<tr>                
                <td style="width:100px;text-align:center;">'.$row1[0].'</td>
                <td style="width:100px;text-align:center;">'.$row[9].'</td>
                <td style="width:150px;text-align:center;">'.$row[8].'</td>';

                $codigo.=' <td style="width:100px;text-align:center;">'.($row1[12]+$row1[13]).'</td>
                <td style="width:100px;text-align:center;">'.$row1[12].'</td>
                <td style="width:100px;text-align:center;">'.$row1[13].'</td>
                <td style="width:100px;text-align:center;">'.$row1[4].'</td>';     
                $saldo=$row1[13];
            }
           
            $codigo.='</tr></table>'; 

            $codigo.='<hr>';
            $codigo.='<br/>';
            $codigo.='<table>';                                                
            $codigo.='<tr>
            <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
            <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($saldo,2,',','.')).'</td>';
            $codigo.='</tr>';                           
            $codigo.='</table>'; 
        }
    }
    else{        
        $sql=pg_query("select * from factura_compra,proveedores,usuario,empresa where factura_compra.id_proveedor=proveedores.id_proveedor and factura_compra.id_usuario=usuario.id_usuario and factura_compra.id_empresa=empresa.id_empresa and num_serie='$_GET[id]' and proveedores.id_proveedor='$_GET[proveedor]'");        
        while($row=pg_fetch_row($sql)){
            $codigo.='<h2 style="font-size:14px; color:#1B8D72;font-weight: bold;">RUC/CI: '.$row[23].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row[24].'</h2>
            <h2 style="color:#1B8D72;font-size:14px;font-weight: bold;">Sección: '.$row[50].'</h2> ';
            $codigo.='<table border=0>';                      
            $codigo.='<tr>                
            <td style="width:100px;text-align:center;">Comprobante</td>    
            <td style="width:100px;text-align:center;">Tipo Documento</td>
            <td style="width:150px;text-align:center;">Nro Factura</td>                
            <td style="width:100px;text-align:center;">Total</td>            
            <td style="width:100px;text-align:center;">Valor Pago</td>
            <td style="width:100px;text-align:center;">Saldo</td>
            <td style="width:10px;text-align:center;">Fecha Pago</td></tr><hr>';
            $codigo.='</table>';                         
        }        
        $sql=pg_query("select * from pagos_pagar where num_factura='$_GET[id]' and comprobante='$_GET[comprobante]'");
        $meses=0;
        $id_pv=0;
        while($row=pg_fetch_row($sql)){                        
            $codigo.='<table border=0><tr>
            <td style="width:100px;text-align:center;">'.$row[3].'</td>
            <td style="width:100px;text-align:center;">'.$row[9].'</td>
            <td style="width:150px;text-align:center;">'.$_GET['id'].'</td>
            <td style="width:100px;text-align:center;">'.($row[12]+$row[13]).'</td>
            <td style="width:100px;text-align:center;">'.$row[12].'</td>
            <td style="width:100px;text-align:center;">'.$row[13].'</td>            
            <td style="width:100px;text-align:center;">'.$row[4].'</td>';
            $saldo=$row[13];
            $codigo.='</table></tr>';            
        }
       
        $codigo.='<hr>';
        $codigo.='<br/>';
        $codigo.='<table>';                                                
        $codigo.='<tr>
        <td style="width:500px;text-align:left;font-weight:bold">'."Total Saldo".'</td>
        <td style="width:200px;text-align:right;font-weight:bold">'.(number_format($saldo,2,',','.')).'</td>';
        $codigo.='</tr>';                           
        $codigo.='</table>'; 
    }
    $codigo.='</body></html>';                           
    $codigo=utf8_decode($codigo);

    $dompdf= new DOMPDF();
    $dompdf->load_html($codigo);
    ini_set("memory_limit","100M");
    $dompdf->set_paper("A4","portrait");
    $dompdf->render();
    //$dompdf->stream("reporteRegistro.pdf");
    $dompdf->stream('reporte_cxp.pdf',array('Attachment'=>0));
?>