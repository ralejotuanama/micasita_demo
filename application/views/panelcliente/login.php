<!DOCTYPE html>
<html lang="es">
    
<head>
        <title>miCasita Hipotecaria </title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/matrix-login1.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>
    </head>
    <body style="margin-top: 0 !important;">
        <div id="loginbox" >            
            <form  class="form-vertical" id="formLogin" method="post" action="<?php echo base_url()?>/index.php/panelcliente/login">
    
               <?php  echo $custom_error; ?>

                  <?php if($this->session->flashdata('error') != null){?>
                        <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <?php echo $this->session->flashdata('error');?>
                       </div>
                  <?php }
                  
                
                  ?>

                  <?php if($this->session->flashdata('success') != null){?>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <?php echo $this->session->flashdata('success');?>
                       </div>
                  <?php }?>

               <!-- <div class="control-group normal_text"> <h3><img src="<?php echo base_url()?>assets/img/logo10.png" alt="Logo" /></h3></div>-->

               <!--  modificado by rat 12/05/2020 --> 
               <h2 style="text-align:center;">Zona Clientes</h2>
               <div class="control-group normal_text"> <h3><img src="<?php echo base_url()?>assets/img/logo10.png" alt="Logo" /></h3></div>
                <!-- modificado by rat 12/05/2020  --> 
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <!--<span class="add-on bg_lg"><i class="icon-user"></i></span><input id="email" name="email" type="text" placeholder="Email" />-->
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input id="documento" name="documento" type="text" placeholder="documento" />
                            
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                           <!-- <span class="add-on bg_ly"><i class="icon-star"></i></span><input name="telefono" type="text" placeholder="Contraseña" />-->
                        
                           <span class="add-on bg_ly"><i class="icon-star"></i></span><input name="clave" id="clave" type="password" placeholder="Contraseña" />
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    <button class="btn btn-info btn-large" id="btnlogin"> Acceder</button>
                <!--<input type="button" value="Volver" class="btn btn-danger btn-large" id="btnRouter" onclick="location.href = '#'">-->
                <br>
                <h6>Si aún no esta registrado en miCasita Hipotecaria  puede hacerlo aquí</h6>
                <a href="#modalCliente" data-toggle="modal" role="button" class="btn btn-success btn-large" title="Registrese como nuevo Cliente"><i class=""></i> Registrarse</a>
                </div>
            </form>
       
        </div>
        
        
        
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>js/jquery.validate.js"></script>



        <script type="text/javascript">

            $(document).ready(function(){

                      
           /*
                  
                $('#documento').focus();
                $("#formLogin").validate({
                     rules :{
                          email: { required: true, email: true},
                          senha: { required: true}
                    },
                    messages:{
                          email: { required: 'Campo Requerido1.', email: 'Introduzca un Email valido1'},
                          senha: {required: 'Campo Requerido.'}
                    },
                   submitHandler: function( form ){       
                         var dados = $( form ).serialize();
                         //alert(dados);
                         
                    
                        $.ajax({
                          type: "POST",
                          url: "<?php echo base_url();?>index.php/panelcliente/login?ajax=true",
                          data: dados,
                          dataType: 'json',
                          success: function(data)
                          {
                            if(data.result == true){
                                window.location.href = "<?php echo base_url();?>index.php/panelcliente/painel";
                            }
                            else{
                              window.location.href = "<?php echo base_url();?>index.php/panelcliente/painel";
                                $('#call-modal').trigger('click');
                                $("#documento").val('');
                                $("#clave").val('');
                                $("#documento").focus();
                            }
                          },
                          error: function( jqXHR, textStatus, errorThrown ) {
                            window.location.href = "<?php echo base_url();?>index.php/panelcliente/painel";
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

                                  function mayus(e) {
                                              e.value = e.value.toUpperCase();
                                   }



                                  $(function(){
                                        $(".validar").keydown(function(event){
                                       //alert(event.keyCode);
                                     if((event.keyCode < 48 || event.keyCode > 57) &&
                                      (event.keyCode < 96 || event.keyCode > 105) &&
                                       event.keyCode !==190  && event.keyCode !==110 && 
                                       event.keyCode !==8 && event.keyCode !==9  ){
                                               return false;
                                             }
                                      });


                                     

                                 });


                               
  

        </script>



        <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>

        <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            <h4 id="myModalLabel">MiCasita Hipotecaria </h4>
          </div>
          <div class="modal-body">
            <h5 style="text-align: center">Los datos de acceso son incorrectos, por favor intentelo nuevamente!</h5>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>

          </div>
        </div>
        
<!-- Modal Cliente-->        
        <div id="modalCliente" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:40%;height:84%;overflow-y:hidden;">
            <form id="formClientes" action="<?php echo base_url() ?>index.php/panelcliente/adicionarCo" method="post">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                          <h4 style="text-align:center;" id="myModalLabel">miCasita Hipotecaria  - Registrarse</h4>
                   </div>
        <div class="modal-body" style="max-height:430px;">
                <!--<div class="widget-content nopadding">-->
                

                                      <div class="control-group5"  style="text-align:center;">
                                            <label for="tipodocumento" style="font-size:12px;margin-right:125px;">Tipo Documento:<span class="required"></span></label>
                                            <select class="" name="tipodocumento" id="tipodocumento" value="">
                                                <option value="RUC">RUC</option>
                                                <option value="DNI">DNI</option>  
                                            </select>
                                           
                                      </div>

               

                   



                      <div class="control-group5" style="text-align:center;">
                         <label for="documento" class="control-label" style="font-size:12px;margin-right:172px;">Numero:<span class="required"></span></label>
                         <div class="controls">
                            <input id="documento" required type="text" name="documento" value="<?php echo set_value('documento'); ?>" placeholder="" class="validar" />
                           
                         </div>
                       </div>
  
                       <div class="control-group5" style="text-align:center;">
                         <label for="nombre" class="control-label" style="font-size:12px;margin-right:172px;">Nombre:<span class="required"></span></label>
                         <div class="controls">
                            <input id="nombre" required type="text" name="nombre" value="" placeholder=""  onkeyup="mayus(this);"/>
                           
                         </div>
                       </div>

                       <div class="control-group5" style="text-align:center;">
                         <label for="correo" class="control-label" style="font-size:12px;margin-right:180px;">Correo:<span class="required"></span></label>
                         <div class="controls">
                            <input id="correo" required type="email" name="correo" value="" placeholder="" />
                            
                         </div>
                       </div>


                        <div class="control-group5" style="text-align:center;">
                                              <label for="clave" style="font-size:12px;margin-right:155px;" class="control-label">Contraseña:</label>
                                           <div class="controls">
                                                 <input id="clave" required type="password" name="clave" value=""  placeholder="Ingrese contraseña"  />
                                            
                                           </div>
                        </div>


                        <div class="control-group5" style="text-align:center;">
                                              <label for="confirmarclave"  style="font-size:12px;margin-right:96px;" class="control-label">Confirmar Contraseña:</label>
                                           <div class="controls">
                                                 <input id="confirmarclave" required type="password" name="confirmarclave" value=""  placeholder="confirme contraseña"  />
                                             
                                           </div>
                        </div>
                                
                                
                         <div class="form-actions5" style="text-align:center;">
                              
                                       <button type="submit" class="btn btn-success"> Ingresar</button>
                                       <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                                
                         </div>
                    
               <!--  </div>-->
             </div>

             </form>
        </div>



    </body>

</html>











