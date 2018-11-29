<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>SISTEMA RENTESEG</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">                
        <link rel="stylesheet" href="<?PHP echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?PHP echo base_url(); ?>assets/css/themes-smoothness-jquery-ui.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?PHP echo base_url(); ?>assets/js/jquery-ui-1.11.0.js"></script>
    </head>
    <body>
        <div class="container"  style="width:100%;">
            <!-- Example row of columns -->
            <div class="row">                        
                <div class="col-xs-12">                    
                    <nav class="navbar navbar-abogado" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Sistema RENTESEG</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>                    
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <img src="<?PHP echo base_url() . $this->session->userdata('ruta_foto'); ?>" title="<?PHP echo $this->session->userdata('title'); ?>" height="60" width="60">
                                </ul>
                                <ul class="nav navbar-nav">
                                    <li><a id="menu-1" href="<?PHP echo base_url(); ?>index.php/equipos/index">Celulares</a></li>
                                    <li><a id="menu-2" href="<?PHP echo base_url(); ?>index.php/equipos/verAlmacen">Almacén</a></li>
                                    <li><a id="menu-3" href="<?PHP echo base_url(); ?>index.php/cargas/index">Carga Diaria</a></li>
                                    <li><a id="menu-4" href="<?PHP echo base_url(); ?>index.php/entidad_entregantes/index">Entidad Entregable</a></li>
                                    <li><a id="menu-5" href="<?PHP echo base_url(); ?>index.php/marcas/index">Marca</a></li>
                                    <li><a id="menu-6" href="<?PHP echo base_url(); ?>index.php/modelos/index">Modelo</a></li>
                                    <li><a id="menu-7" href="<?PHP echo base_url(); ?>index.php/colores/index">Color</a></li> 
                                    <li><a id="menu-8" href="<?PHP echo base_url(); ?>index.php/estado_conservacion/index">Estado de Conservación</a></li>
                                    <li><a href="<?PHP echo base_url(); ?>index.php/acceso/logout">Cerrar Sesión</a></li>
                                    <li>
                                        <div style="padding-top: 5px"><b>Carga:</b><?PHP echo " " .$this->session->userdata('CARGA_CANTIDAD') . " Equipos"; ?></div>
                                        <div>Ingresados: <?php echo $this->session->userdata('CELULARES_GUARDADOS'); ?></div>
                                    </li>
                                </ul>                                
                                <ul class="nav navbar-nav navbar-right">
                                    <img src="<?PHP echo base_url() . 'images/logomininter.JPG' ?>">                                    
                                    <li><strong>Sesión:</strong><?PHP echo " ".$this->session->userdata('nivel_descripcion'); ?><?PHP echo "&nbsp;&nbsp;&nbsp;<br> ".$this->session->userdata('nombres')." ".$this->session->userdata('apellido_paterno'); ?>&nbsp;&nbsp;&nbsp;</li>                                    
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>                
            </div>
        </div>
        
        <script>
        
        $(function(){
            
            var menu = "<?php echo $this->session->userdata('menu');?>";
            console.log(menu);
            $("#menu-"+menu).css("background-color","rgba(0, 0, 0, 0.2)");
            $("#menu-"+menu).css("color","#fff");
    
        })
        
        </script>
        
        