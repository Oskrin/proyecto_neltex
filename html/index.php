<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.:INGRESO AL SISTEMA:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 

        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.4.custom.css"/> 


        <link href="../css/font-awesome.css" rel="stylesheet">

        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../css/pages/signin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link rel="stylesheet" href="../css/logo.css" id="dclogo" />
        <link rel="stylesheet" type="text/css" href="../css/dccolor.css"/> 

        <!--<script src="js/jquery-1.7.2.min.js"></script>-->
        <link rel="dns-prefetch" href="//fonts.googleapis.com" />
  <!-- <link rel="dns-prefetch" href="//code.jquery.com" /> -->

        <script src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/index.js"></script>
        <script type="text/javascript" src="../js/signin.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
    </head>

    <body style="background: url(../images/fondo.fw.png)no-repeat fixed center;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;"> 
          <header class="site__header island">
                                  <div class="wrap">
                                   <span id="animationSandbox" style="display: block;"><h1 class="site__title mega">Acceder</h1></span>
                                  </div>
                                </header><!-- /.site__header -->

        <div class="row-fluid">
            <div class="span4">
                <img src="../images/usuario.fw.png" width="100%">
            </div>
            <div class="span8">
            
                        <form action="" method="post" name="form_admin">                           
                            <div class="row-fluid">
                                 <div class="login-fields">                                    
                                    <div class="field">
                                        <label for="username">Usuario:</label>
                                        <input type="text" id="txt_usuario" name="txt_usuario" placeholder="Usuario" class="login username-field" />
                                    </div> <!-- /field -->

                                    <div class="field">
                                        <label for="password">Password:</label>
                                        <input type="password" id="txt_contra" name="txt_contra" placeholder="Constraseña" class="login password-field"/>
                                    </div>
                                </div>
                            </div>                          

                            <div class="login-actions pull-left">    
                                <button class="butt js--triggerAnimation" id="btnRetornar">Retornar</button>                                                      
                                <button class="butt js--triggerAnimation" id="btnIngreso">Ingresar</button>                                
                            </div>
                        </form>
                       
                        
            </div>
        </div>       

      
    </body>
</html>