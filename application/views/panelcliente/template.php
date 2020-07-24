
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>miCasita Hipotecaria - Área de Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 


    <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
  </head>

  <body>

    <!--Header-part-->
    <div id="header">
      <h1><a href="dashboard.html">micasita Hipotecaria </a></h1>
    </div>
    <!--close-Header-part--> 

    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
      <ul class="nav">
        <li class=""><a><i class="icon icon-user"></i><span class="text"> <?php echo $this->session->userdata('nombre'). " - " .$this->session->userdata('ruc')  ?> </span></a></li>
     <!--   <li class=""><a title="" href="<?php echo base_url()?>index.php/panelcliente/conta"><i class="icon icon-star"></i> <span class="text"> Mi Cuenta</span></a></li>
        <li class=""><a title="" href="<?php echo base_url()?>index.php/panelcliente/sair"><i class="icon icon-share-alt"></i> <span class="text"> Cerrar sesión</span></a></li>-->
        
      </ul>
    </div>


    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
      <ul>
        <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/panelcliente/painel"><i class="icon icon-home"></i> <span>Panel</span></a></li>
        <li class="<?php if(isset($menuConta)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/panelcliente/conta"><i class="icon icon-star"></i> <span>Mi Cuenta</span></a></li>
       <!-- <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/conecte/os"><i class="icon icon-tags"></i> <span>Archivos</span></a></li>-->
        <!--<li class="<?php if(isset($menua)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/conecte/aparatos"><i class="icon icon-tasks"></i> <span>Mis Equipos</span></a></li>-->
       <!-- <li class="<?php if(isset($menuVendas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/conecte/compras"><i class="icon icon-shopping-cart"></i> <span>Solicitudes Vinculadas</span></a></li>-->
        <li class=""><a href="<?php echo base_url()?>index.php/panelcliente/sair"><i class="icon icon-share-alt"></i> <span>Salir</span></a></li>
        
      </ul>
    </div>


   
    <div id="content" style="min-height:550px;">
      <div id="content-header">
        <div id="breadcrumb"><a href="#" title="" class="tip-bottom"> <i class="icon-home"></i> Panel Cliente</a></div>
      </div>
 
      <div class="container-fluid">
        <div class="row-fluid">
          
          <div class="span12">
              <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
            
              <?php if(isset($output)){ $this->load->view($output);} ?>            
            
          </div>
        </div>
      
      </div>
    </div>



    <!--Footer-part-->
    <div class="row-fluid">
      <div id="footer" class="span12" style="color:white;font-size:18px;"> 2020 &copy;  miCasita Hipotecaria </div>
    </div>



    <!-- javascript
    ================================================== -->

    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


  </body>
</html>
