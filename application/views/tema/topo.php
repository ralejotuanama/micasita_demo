
<!DOCTYPE html>
<html lang="en">
<head>
<title>miCasita Hipotecaria </title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">miCasita Hipotecaria </a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a><i class="icon icon-user"></i><span class="text"> <?php echo $this->session->userdata('nombre');?> </span></a></li>
 <!--  <li class=""><a title="" href="<?php echo base_url();?>index.php/mapos/minhaConta"><i class="icon icon-star"></i> <span class="text">Mi Cuenta</span></a></li>-->
  <!--  <li class=""><a title="" href="<?php echo base_url();?>index.php/mapos/sair"><i class="icon icon-share-alt"></i> <span class="text">Salir del Sistema</span></a></li>-->
  </ul>
</div>

<!--start-top-serch-->
<!--<div id="search">
  <form action="<?php echo base_url()?>index.php/mapos/pesquisar">
    <input type="text" name="termo" placeholder="Buscar..."/>
    <button type="submit"  class="tip-bottom" title="Buscar"><i class="icon-search icon-white"></i></button>
    
  </form>
</div>-->
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <!--<li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Panel Control</span></a></li>-->
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
        <li class="<?php if(isset($menuClientes)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/clientes"><i class="icon icon-group"></i> <span>Clientes</span></a></li>
    <?php } ?>    

    <!--<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vaparatos')){ ?>
        <li class="<?php if(isset($menuaparatos)){echo 'active';};?>"><a href="<?php echo base_url()?>aparatos"><i class="icon icon-tasks"></i> <span>Equipos</span></a></li>
    <?php } ?>-->
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){ ?>
        <li class="<?php if(isset($menuProdutos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/productos"><i class="icon icon-barcode"></i> <span>Productos</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
        <li class="<?php if(isset($menuServicos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/servicios"><i class="icon icon-wrench"></i> <span>Servicios</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
        <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os"><i class="icon icon-tags"></i> <span>Ordenes de Servicio</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
        <li class="<?php if(isset($menuVendas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/ventas"><i class="icon icon-shopping-cart"></i> <span>Ventas</span></a></li>
    <?php } ?>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){ ?>
        <li class="<?php if(isset($menuArquivos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/archivos"><i class="icon icon-hdd"></i> <span>Archivos</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){ ?>
        <li class="submenu <?php if(isset($menuFinanceiro)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-money"></i> <span>Finanzas</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/financiero/movimientos">Movimientos</a></li>
          </ul>
        </li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente') || $this->permission->checkPermission($this->session->userdata('permissao'),'rProduto') || $this->permission->checkPermission($this->session->userdata('permissao'),'rServico') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOs') || $this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro') || $this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
        
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Reportes</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/reportes/clientes">Clientes</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){ ?>
                <li><a href="<?php echo base_url()?>index.php/reportes/productos">Productos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){ ?>
                <li><a href="<?php echo base_url()?>index.php/reportes/servicios">Servicios</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){ ?>
                 <li><a href="<?php echo base_url()?>index.php/reportes/os">Ordenes de Servicio</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
                <li><a href="<?php echo base_url()?>index.php/reportes/ventas">Ventas</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){ ?>
                <li><a href="<?php echo base_url()?>index.php/reportes/financiero">Financieros</a></li>
            <?php } ?>
            
          </ul>
        </li>

    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Configuraciones</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios">Usuarios</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/emitente">Empresa</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permisos">Permisos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/backup">Backup</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    <li class=""><a href="<?php echo base_url()?>index.php/mapos/sair"><i class="icon icon-share-alt"></i> <span>Salir</span></a></li>
  </ul>
</div>



<div id="content" style="min-height:550px;">
      <div id="content-header">
        <div id="breadcrumb"><a href="" title="" class="tip-bottom"> <i class="icon-home"></i> Panel Control</a></div>
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
                          
                      <?php if(isset($view)){echo $this->load->view($view);}?>


      </div>
    </div>
  </div>
</div>



<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12" style="color:white;font-size:18px;"> 2020 &copy; MiCasita Hipotecaria </div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>







