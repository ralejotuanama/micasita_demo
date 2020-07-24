<!DOCTYPE html>
<html lang="es">
    
<head>
        <title>miCasita Hipotecaria </title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.min.js"></script>
    </head>
    <body style="margin-top: 0px;">
        <div id="loginbox">            
            <form  class="form-vertical" id="formLogin" method="post" action="<?php echo base_url()?>index.php/mapos/verificarLogin">
                  <?php if($this->session->flashdata('error') != null){?>
                        <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <?php echo $this->session->flashdata('error');?>
                       </div>
                  <?php }?>

                  <h2 style="text-align:center;">Zona Administrador</h2>
                <div class="control-group normal_text"> <h3>
                   <!-- <img src="<?php echo base_url()?>assets/img/logo1.png" alt="Logo" />-->
                <!-- modificado por rat 11/05/2020 -->
                <img src="<?php echo base_url()?>assets/img/logo10.png" alt="Logo" />
                  <!-- modificado por rat 11/05/2020 -->
                </h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lr"><i class="icon-user"></i></span><input id="email" name="email" type="text" placeholder="Usuario" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="clave" name="clave" type="password" placeholder="Contraseña" />
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    <button class="btn btn-info btn-large"/> Ingresar</button>
               <!-- <input type="button" value="Volver" class="btn btn-info btn-large" id="btnRouter" onclick="location.href = '#'">-->
                </div>
            </form>
       
        </div>
        
        
        
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/validate.js"></script>




        <script type="text/javascript">
            $(document).ready(function(){
/*
                $('#email').focus();
                $("#formLogin").validate({
                     rules :{
                          email: { required: true, email: true},
                          clave: { required: true}
                    },
                    messages:{
                          email: { required: 'Campo Requerido.', email: 'Escriba un Email válido'},
                          clave: {required: 'Campo Requerido.'}
                    },
                   submitHandler: function( form ){       
                         var dados = $( form ).serialize();
                        $.ajax({
                            cache:false,
                          type: "POST",
                          url: "<?php echo base_url();?>index.php/mapos/verificarLogin?ajax=true",
                          data: dados,
                          dataType: 'json',
                          success: function(data)
                          {
                            if(data.result == true){
                                window.location.href = "<?php echo base_url();?>index.php/clientes";
                            }
                            else{
                                window.location.href = "<?php echo base_url();?>index.php/panelcliente/painel";
                                $('#call-modal').trigger('click');
                            }
                          },
                          error: function( jqXHR, textStatus, errorThrown ) {
                            window.location.href = "<?php echo base_url();?>index.php/clientes";
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                            }
                          });

                          return false;
                    },

                    errorClass: "help-inline",
                    errorElement: "span",
                    highlight:function(element, errorClass, validClass) {
                        $(element).parents('.control-group').addClass('error');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).parents('.control-group').removeClass('error');
                        $(element).parents('.control-group').addClass('success');
                    }
                });
*/
            });

        </script>



        <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>

        <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="myModalLabel">miCasita Hipotecaria </h4>
          </div>
          <div class="modal-body">
            <h5 style="text-align: center">Los datos de acesso son incorrectos, por favor vuelva a intentarlo</h5>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>

          </div>
        </div>


    </body>

</html>









