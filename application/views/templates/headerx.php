<!DOCTYPE HTML>
<html>
    <head>
        <title>Sistema Abogados</title>        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">                
        <link rel="stylesheet" href="<?PHP echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
        
        <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/themes-smoothness-jquery-ui.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?PHP echo base_url(); ?>assets/js/jquery-ui-1.11.0.js"></script>
    </head>
    <body>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">        
                <div class="col-xs-1">                    
                </div>
                <div class="col-xs-10">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Sistema de Abogados</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>                    
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">                        
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Empleados <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?PHP echo base_url(); ?>index.php/empleados/empleado_index/1">Administrador</a></li>
                                            <li><a href="<?PHP echo base_url(); ?>index.php/empleados/empleado_index/2">Secretaria</a></li>
                                            <li><a href="<?PHP echo base_url(); ?>index.php/empleados/empleado_index/3">Abogado Socio-Jefe</a></li>
                                            <li><a href="<?PHP echo base_url(); ?>index.php/empleados/empleado_index/4">Abogado</a></li>
                                            <li><a href="<?PHP echo base_url(); ?>index.php/empleados/empleado_index/5">Practicantes</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?PHP echo base_url(); ?>index.php/clientes/index">Clientes</a></li>
                                    <li><a href="#">Actividad</a></li>
                                    <li><a href="#">Reportes</a></li>
                                    <li><a href="<?PHP echo base_url(); ?>">Salir</a></li>                        
                                    
                                </ul>
                                <ul class="nav navbar-nav navbar-right">                                    
                                    <li><strong>Sesión:</strong><?PHP echo " ".$this->session->userdata('usuario'); ?></li>                                        
                                </ul>
                            </div><!-- /.navbar-collapse -->                
                        </div><!-- /.container-fluid -->            
                    </nav>

                </div>
                <div class="col-xs-1">
                </div>
            </div>
        </div>        