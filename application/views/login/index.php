<br><br>
<div align="center"><img src="<?php echo base_url()?>/images/logomininter.JPG"></div>
<h1 align="center">SISTEMA RENTESEG</h1>
<br>
<p class="bg-info" align="center">
<?PHP echo $this->session->flashdata('mensaje');?>
</p>
<div class="container">
    <div class="row">                
        <div class="col-md-3">
        </div>
        <div class="col-md-6">

            <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/acceso/login">
                <h5 class="form-signin-heading">Usuaro</h5>
                <input class="form-control" type="text" autofocus="" required="" placeholder="Usuario" name="usuario" id="usuario">                
                <h5 class="form-signin-heading">Password</h5>
                <input class="form-control" type="password" autofocus="" required="" placeholder="Password" name="password" id="password">
                <br><br>
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Ingresar"/>
            </form>
        </div>
    </div>
    <div class="col-md-3">
    </div>
</div>