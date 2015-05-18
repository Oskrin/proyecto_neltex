<?php
    session_start();
    include '../../menus/menu.php';
    include '../../procesos/base.php';
    conectarse();
    error_reporting(0);

    $cont1 = 0;
    $consulta = pg_query("select max(id_factura_compra) from factura_compra");
    while ($row = pg_fetch_row($consulta)) {
        $cont1 = $row[0];
    }
    $cont1++;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:FACTURA COMPRA:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <link rel="stylesheet" type="text/css" href="../../css/buttons.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.10.4.custom.css"/>    
        <link rel="stylesheet" type="text/css" href="../../css/normalize.css"/>    
        <link rel="stylesheet" type="text/css" href="../../css/ui.jqgrid.css"/> 
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="../../css/font-awesome.css" rel="stylesheet">
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../css/link_top.css" rel="stylesheet" />
        <link rel="stylesheet" href="../../css/alertify.core.css" />
        <link rel="stylesheet" href="../../css/alertify.default.css" id="toggleCSS" />
        <link href="../../css/sm-core-css.css" rel="stylesheet" type="text/css" />
        <link href="../../css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />
        <link href="../../css/jquery.idealforms.css" rel="stylesheet">

        <script type="text/javascript" src="../../js/bootstrap.js"></script>
        <script type="text/javascript" src="../../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../../js/buttons.js" ></script>
        <script type="text/javascript" src="../../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="factura_compra.js"></script>
        <script type="text/javascript" src="../../js/datosUser.js"></script>
        <script type="text/javascript" src="../../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../../js/easing.js" ></script>
        <script type="text/javascript" src="../../js/jquery.ui.totop.js" ></script>
        <script type="text/javascript" src="../../js/jquery.smartmenus.js"></script>
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="">
                        <h1><?php echo $_SESSION['empresa']; ?></h1>				
                    </a>
                </div>
            </div>
        </div> 

        <!-- /Inicio  Menu Principal -->
        <div class="subnavbar">
            <div class="subnavbar-inner">
                <?Php
                // Cabecera Menu 
                if ($_SESSION['cargo'] == '1') {
                    print menu_1();
                }
                if ($_SESSION['cargo'] == '2') {
                    print menu_2();
                }
                if ($_SESSION['cargo'] == '3') {
                    print menu_3();
                }
                ?> 
            </div> 
        </div> 

        <!-- /Fin  Menu Principal -->

        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">      		
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-list-alt"></i>
                                    <h3>FACTURA COMPRA</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="formularios_fac" name="formularios_fac" method="post" class="form-horizontal">
                                                    <fieldset>
                                                        <section class="columna_1">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="comprobante">Comprobante:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="comprobante" id="comprobante" readonly class="campo" value="<?php echo $cont1 ?>" style="width: 80px"/>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_2">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="fecha_actual">Fecha Actual:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="fecha_actual" id="fecha_actual" readonly value="" class="campo" style="width: 100px" />
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_3">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="hora_actual">Hora Actual:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="hora_actual" id="hora_actual" readonly class="campo" style="width: 100px"/>
                                                                </div>
                                                            </div>
                                                        </section>

                                                        <section class="columna_4">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="digitador"> Digitad@r:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="digitador" id="digitador" value="<?php echo $_SESSION['nombres'] ?>" class="campo" style="width: 200px" readonly/>
                                                                    <input type="hidden" name="comprobante2" id="comprobante2" class="campo" style="width: 100px" value="<?php echo $cont1 ?>" />
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </fieldset>
                                                    <br/>
                                                    <fieldset>
                                                        <legend></legend>
                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Proveedor: <font color="red">*</font></label></td>
                                                                <td><select name="tipo_docu" id="tipo_docu" required style="width: 170px">
                                                                        <option value="">......Seleccione......</option>
                                                                        <option value="Cedula">Cedula</option>
                                                                        <option value="Ruc">Ruc</option>
                                                                        <option value="Pasaporte">Pasaporte</option>  
                                                                    </select></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Nro de Identificación: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="ruc_ci" id="ruc_ci" class="campo" style="width: 150px; margin-left: 5px"/></td>
                                                                <td><input type="text" name="empresa" id="empresa" class="campo" style="width: 180px" /></td>
                                                                <td><input type="hidden" name="id_proveedor" id="id_proveedor" class="campo" style="width: 180px" /></td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Tipo de comprobante: <font color="red">*</font></label></td>  
                                                                <td><select name="tipo_comprobante" id="tipo_comprobante" style="width: 300px">
                                                                        <option value="">......Seleccione comprobante......</option>  
                                                                        <option value="Factura"> Factura</option>
                                                                        <option value="Nota_venta"> Nota o boleta de venta</option>
                                                                    </select></td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Fecha registro: </label></td>  
                                                                <td><input type="text" name="fecha_registro" id="fecha_registro" class="campo" style="width: 120px" value="" readonly /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Fecha emisón: </label></td>  
                                                                <td><input type="text" name="fecha_emision" id="fecha_emision" class="campo" style="width: 120px; margin-left: 5px" value="" readonly /></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Fecha caducidad: </label></td>  
                                                                <td><input type="text" name="fecha_caducidad" id="fecha_caducidad" class="campo" style="width: 120px; margin-left: 5px" value="" readonly /></td>
                                                            </tr>
                                                        </table>

                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Nro. de serie: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="serie1" id="serie1" class="campo" style="width: 150px"/></td>
                                                                <td><label> - </label></td>
                                                                <td><input type="text" name="serie2" id="serie2" class="campo" style="width: 150px"/></td>
                                                                <td><label> - </label></td>
                                                                <td><input type="text" name="serie3" id="serie3" class="campo" style="width: 200px"/></td>
                                                            </tr>
                                                        </table>

                                                        <table cellpadding="2" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label style="width: 100%">Nro. de Autorización: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="autorizacion" id="autorizacion" class="campo" maxlength="45"/></td>
                                                                <td><label style="width: 100%; margin-left: 10px">Fecha Cancelación: <font color="red">*</font></label></td>
                                                                <td><input type="text" name="cancelacion" id="cancelacion" class="campo" style="width: 150px" value="" readonly/></td>
                                                                <td><label for="formas"  style="width: 100%">Formas de Pago:</label></td>
                                                                <td><select name="formas" id="formas">
                                                                        <option value="Contado">Contado</option>
                                                                        <option value="Credito">Crédito</option>
                                                                    </select> </td>
                                                            </tr>  
                                                        </table>

                                                        <table cellpadding="2" style="margin-left: 10px; display: none">
                                                            <tr>
                                                                <td><label for="adelanto" style="margin-left: 10px">Adelanto:</label></td>
                                                                <td><input type="text" name="adelanto" id="adelanto" class="campo" placeholder="$0.00" style="width: 120px"/></td>
                                                                <td><label for="meses" style="margin-left: 10px">Meses:</label></td>
                                                                <td><input type="text" name="meses" id="meses"  class="campo" style="width: 100px" min="1" max="3"/></td>
                                                                <td><label for="cuotas" style="margin-left: 10px">Cuotas:</label></td>
                                                                <td><select id="cuotas" name="cuotas" style="width: 100px"></select></td>
                                                            </tr>
                                                        </table>
                                                    </fieldset>
                                                    <br/>

                                                    <fieldset>
                                                        <legend>Detalle Factura</legend>
                                                        <table cellpadding="2" border="0" style="margin-left: 10px">
                                                            <tr>
                                                                <td><label>Código Barras:</label></td>
                                                                <td><label>Código:</label></td>   
                                                                <td><label>Producto:</label></td>   
                                                                <td><label>Cantidad:</label></td>   
                                                                <td><label>Precio:</label></td>
                                                                <td><label>Descuento:</label></td>
                                                                <!--<td><label>Iva:</label></td>-->
                                                                <!--<td><label>Series:</label></td>-->
                                                            </tr>

                                                            <tr>
                                                                <td><input type="text" name="codigo_barras" id="codigo_barras" class="campo" style="width: 170px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="codigo" id="codigo" class="campo" style="width: 180px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="producto" id="producto" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="cantidad" id="cantidad" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                <td><input type="text" name="precio" id="precio" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                <td><input type="number" name="descuento" id="descuento" class="campo" style="width: 60px" maxlength="10" value="" placeholder="%" min="0"/></td>
                                                                <td><select id="iva_producto" name="iva_producto" style="width: 80px; display: none" class="campo" >
                                                                        <option value="Elija">Elija</option>
                                                                        <option value="Si">Si</option> 
                                                                        <option value="No">No</option> 
                                                                    </select></td>
                                                                <!--<td><input type="button" class="btn btn-primary" id='btncargar' style="margin-top: -10px" value="Cargar"></td>-->
                                                                <td><input type="hidden" name="carga_series" id="carga_series" class="campo" style="width: 100px" maxlength="10"/></td>
                                                                <td><input type="hidden" name="cod_producto" id="cod_producto" class="campo" style="width: 100px" maxlength="10"/></td>
                                                            </tr>
                                                        </table>

                                                        <div style="margin-left: 10px">
                                                            <table id="list" align="center"></table>
                                                        </div>

                                                        <table border="0" cellspacing="2" style="margin-left: 655px">
                                                            <tr>
                                                                <td><label for="total_p" style="width: 100%">Tarifa 0:</label></td>
                                                                <td><input type="text" style="width:80px" name="total_p" id="total_p" readonly value="0.00" class="campo"/></td>
                                                            </tr>    
                                                            <tr>
                                                                <td><label for="total_p2" style="width: 100%" >Tarifa  12:</label></td>
                                                                <td><input type="text" style="width: 80px" name="total_p2" id="total_p2" readonly value="0.00" class="campo"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="iva" style="width:100%" >12 %Iva:</label></td>
                                                                <td><input type="text" style="width:80px" name="iva" id="iva" readonly value="0.00" class="campo"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="desc" style="width: 100%" >Descuentos:</label></td>
                                                                <td><input type="text" style="width: 80px" name="desc" id="desc" value="0.00" readonly class="campo"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label for="tot" style="width:100%" >Total:</label></td>
                                                                <td><input type="text" style="width:80px" name="tot" id="tot" readonly value="0.00" class="campo" /></td>
                                                            </tr>
                                                        </table> 
                                                        <br />
                                                    </fieldset>
                                                </form>

                                                <div class="form-actions">
                                                    <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                                    <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                                    <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                                    <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                                    <button class="btn btn-primary" id='btnImprimir'><i class="icon-print"></i> Imprimir</button>
                                                    <button class="btn btn-primary" id='btnAtras'><i class="icon-step-backward"></i> Atras</button>
                                                    <button class="btn btn-primary" id='btnAdelante'>Adelante <i class="icon-step-forward"></i></button>
                                                </div>

                                                <div id="buscar_facturas_compras" title="BUSCAR FACTURAS COMPRAS">
                                                    <table id="list3"><tr><td></td></tr></table>
                                                    <div id="pager3"></div>
                                                </div> 

                                            </div>
                                        </div>

                                        <div id="series" title="AGREGAR SERIES">
                                            <table cellpadding="2" border="0" style="margin-left: 10px">
                                                <tr>
                                                    <td><label>Series: <font color="red">*</font></label></td>
                                                    <td><input type="text" name="serie" id="serie" class="campo" /></td>
                                                    <td><button class="btn btn-primary" id='btnAgregar' style="margin-top: -10px"><i class="icon-list"></i> Agregar</button></td>
                                                </tr>
                                            </table>
                                            <hr style="color: #0056b2;" /> 
                                            <div align="center">
                                                <table id="list2"><tr><td></td></tr></table>
                                                <div class="form-actions">
                                                    <button class="btn btn-primary" id='btnGuardarSeries'><i class="icon-save"></i> Guardar</button>
                                                    <button class="btn btn-primary" id='btnCancelarSeries'><i class="icon-remove-sign"></i> Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body">
               

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript" src="../../js/base.js"></script>
        <script type="text/javascript" src="../../js/jquery.ui.datepicker-es.js"></script>
        <script type="text/javascript" src="../../js/bootstrap_modal.js"></script>
        <script type="text/javascript" src="../../js/jquery.idealforms.js"></script>
         <form action="" novalidate autocomplete="off" class="idealforms">

                    <div class="idealsteps-wrap">
                        <style type="text/css">
                              .field.buttons button {
                            margin-right: .5em;
                          }

                          #invalid {
                            display: none;
                            float: left;
                            width: 290px;
                            margin-left: 120px;
                            margin-top: .5em;
                            color: #CC2A18;
                            font-size: 130%;
                            font-weight: bold;
                          }

                          .idealforms.adaptive #invalid {
                            margin-left: 0 !important;
                          }

                          .idealforms.adaptive .field.buttons label {
                            height: 0;
                          }
                        </style>
                      <!-- Step 1 -->

                      <section class="idealsteps-step">

                        <div class="field">
                          <label class="main">Username:</label>
                          <input name="username" type="text" data-idealforms-ajax="ajax.php">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">E-Mail:</label>
                          <input name="email" type="email">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Password:</label>
                          <input name="password" type="password">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Confirm:</label>
                          <input name="confirmpass" type="password">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Date:</label>
                          <input name="date" type="text" placeholder="mm/dd/yyyy" class="datepicker">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Picture:</label>
                          <input id="picture" name="picture" type="file" multiple>
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Website:</label>
                          <input name="website" type="text">
                          <span class="error"></span>
                        </div>

                        <div class="field buttons">
                          <label class="main">&nbsp;</label>
                          <button type="button" class="next">Next &raquo;</button>
                        </div>

                      </section>

                      <!-- Step 2 -->

                      <section class="idealsteps-step">

                        <div class="field">
                          <label class="main">Sex:</label>
                          <p class="group">
                            <label><input name="sex" type="radio" value="male">Male</label>
                            <label><input name="sex" type="radio" value="female">Female</label>
                          </p>
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Hobbies:</label>
                          <p class="group">
                            <label><input name="hobbies[]" type="checkbox" value="football">Football</label>
                            <label><input name="hobbies[]" type="checkbox" value="basketball">Basketball</label>
                            <label><input name="hobbies[]" type="checkbox" value="dancing">Dancing</label>
                            <label><input name="hobbies[]" type="checkbox" value="dancing">Parkour</label>
                            <label><input name="hobbies[]" type="checkbox" value="dancing">Videogames</label>
                          </p>
                          <span class="error"></span>
                        </div>

                        <div class="field buttons">
                          <label class="main">&nbsp;</label>
                          <button type="button" class="prev">&laquo; Prev</button>
                          <button type="button" class="next">Next &raquo;</button>
                        </div>

                      </section>

                      <!-- Step 3 -->

                      <section class="idealsteps-step">

                        <div class="field">
                          <label class="main">Phone:</label>
                          <input name="phone" type="text" placeholder="000-000-0000">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Zip:</label>
                          <input name="zip" type="text" placeholder="00000">
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Options:</label>
                          <select name="options" id="">
                            <option value="default">&ndash; Select an option &ndash;</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                          </select>
                          <span class="error"></span>
                        </div>

                        <div class="field">
                          <label class="main">Comments:</label>
                          <textarea name="comments" cols="30" rows="10"></textarea>
                          <span class="error"></span>
                        </div>

                        <div class="field buttons">
                          <label class="main">&nbsp;</label>
                          <button type="button" class="prev">&laquo; Prev</button>
                          <button type="submit" class="submit">Submit</button>
                        </div>

                      </section>

                    </div>

                    <span id="invalid"></span>

                  </form>
        <script type="text/javascript">
        // inicializacion proceso
        $(function(){
            $('form.idealforms').idealforms({

              silentLoad: false,

              rules: {
                'username': 'required username ajax',
                'email': 'required email',
                'password': 'required pass',
                'confirmpass': 'required equalto:password',
                'date': 'required date',
                'picture': 'required extension:jpg:png',
                'website': 'url',
                'hobbies[]': 'minoption:2 maxoption:3',
                'phone': 'required phone',
                'zip': 'required zip',
                'options': 'select:default',
              },

              errors: {
                'username': {
                  ajaxError: 'Username not available'
                }
              },

              onSubmit: function(invalid, e) {
                e.preventDefault();
                $('#invalid')
                  .show()
                  .toggleClass('valid', ! invalid)
                  .text(invalid ? (invalid +' invalid fields') : 'All good!');
              }
            });

            $('form.idealforms').find('input, select, textarea').on('change keyup', function() {
              $('#invalid').hide();
            });

            $('form.idealforms').idealforms('addRules', {
              'comments': 'required minmax:50:200'
            });

            $('.prev').click(function(){
              $('.prev').show();
              $('form.idealforms').idealforms('prevStep');
            });
            $('.next').click(function(){
              $('.next').show();
              $('form.idealforms').idealforms('nextStep');
            });
        });
        </script>
        <div class="footer">
            <div class="footer-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            &copy; 2014 <a href=""> <?php echo $_SESSION['empresa']; ?></a>.
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </body>
</html>