<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<!-- inicio div row-fluid-->
<div class="row-fluid" style="margin-top:0">

   <!-- inicio div span12-->
    <div class="span12" >
                <h5>Editar Linea</h5>

                <!--inicio form -->
                <form action="<?php echo base_url()?>index.php/clientes/editarsolicitudbd" id="editarsolicitudbd" method="post" enctype="multipart/form-data">

              

                           <div class="widget-title">
                                <ul class="nav nav-tabs">
                                  
                                     <li class="active"><a data-toggle="tab" href="#tab3">Resultados</a></li>
                               
                                </ul>
                           </div>

                      <!--inicio div  widget-content->-->
                    <div class="widget-content tab-content">
                         

                   
                        <div id="tab3" class="tab-pane active" style="min-height: 300px">  


                            
                       
                            <div class="span12"> 
                          
                                 <label for="tipo"  class="">Estado Evaluación:<span class="required"></span></label>
                                  <select id="esta"    type="text" name="esta" value="" class="span12">   
                                  <option  <?php if($result->estadosolicitud == '0'){echo 'selected';} ?>  value="0">Evaluacion</option>
                                    <option  <?php if($result->estadosolicitud == '1'){echo 'selected';} ?>  value="1">Aprobado</option>
                                    <option  <?php if($result->estadosolicitud == '2'){echo 'selected';} ?> value="2">Rechazado</option>
                                
                                 </select>  
                                 <input id="idsolult" name="idsolult" type="hidden" value="<?php  echo $result->so ?>">
                                 <?php /* echo $result->so */?>
                            </div> 
                            <div class="span12" style="padding: 0%; margin-left: 0">                                               
                                        <div class="span6">
                                            <label for="finicio">Fecha Inicio Vigencia:<span class="required"></span></label>
                                            <input id="finicio"   class="span12 datepicker" type="text" name="finicio" value="<?php echo date('d/m/Y', strtotime($result->fechainicio)); ?>"/>
                                        </div>   
                                        <div class="span6">
                                            <label for="ffinal">Fecha Fin Vigencia:</label>
                                            <input id="ffinal"   type="text" class="span12 datepicker" name="ffinal" value="<?php   
                                             $dataFinal = date(('d/m/Y'),strtotime($result->fechafin));
                                            if($dataFinal ==  "01/01/1970"){
                                                echo '';
                                            }
                                            else{
                                                echo $dataFinal;
                                            }  ?>"  />
                                        </div>          
                            </div>
                            <div class="span12" style="padding: 0%; margin-left: 0">                                            
                                        <div class="span6"> 
                                        <label for="">Adjuntar Archivo</label>
                                        <input type="file" class="span12" name="userfile20" multiple="multiple" size="20" />
                                           </div>         
                            </div>
                          
                        </div> 
                        

                        <button type="submit" class="btn btn-success">Guardar</button>
                         <a href="http://localhost:8082/micasita_demo/index.php/clientes" id=""
                          class="btn btn-primary "><i class="icon-arrow-left"></i> Volver</a>  
                      
                        
                     </div>  <!-- fin div widget-content-->     
               </form>  <!-- fin form-->              
          </div><!-- fin div12-->
     </div><!-- fin div row-fluid-->



                  

<script type="text/javascript">


        $(document).ready(function(){
            $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
    })


</script>