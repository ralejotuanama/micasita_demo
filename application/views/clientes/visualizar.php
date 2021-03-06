<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Datos del Cliente</a></li>
            <li><a data-toggle="tab" href="#tab2">Archivos </a></li>
           <!-- <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/clientes/editar/'.$result->idClientes.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>-->
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">

            <div class="accordion" id="collapse-group">
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Datos de Carácter Personal</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Nombre</strong></td>
                                                    <td><?php echo $result->nombreCliente ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>DNI/RUC</strong></td>
                                                    <td><?php echo $result->documento ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Fecha de Registro</strong></td>
                                                    <td><?php echo date('d/m/Y',  strtotime($result->fechaRegistro)) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Contactos</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Teléfono</strong></td>
                                                    <td><?php echo $result->telefono ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Tel. Móvil</strong></td>
                                                    <td><?php echo $result->celular ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Email</strong></td>
                                                    <td><?php echo $result->email ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dirección</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGThree">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Dirección</strong></td>
                                                    <td><?php echo $result->ruc ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Número</strong></td>
                                                    <td><?php echo $result->numero ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Distrito</strong></td>
                                                    <td><?php echo $result->barrio ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>Ciudad</strong></td>
                                                    <td><?php echo $result->ciudad ?> 
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>País</strong></td>
                                                    <td><?php echo $result->estado ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right"><strong>CP</strong></td>
                                                    <td><?php echo $result->cep ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



          
        </div>


        <!--Tab 2-->
        <div id="tab2" class="tab-pane" style="min-height: 300px">

        <div class="span12 well" style="padding: 1%; margin-left: 0" id="form-anexos">
                                    <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8" method="post">
                                    <div class="span10">
                                
                                        <input type="hidden" name="idOsServico" id="idOsServico" value="<?php/* echo $result->idOs  */?>" />
                                        <label for="">Adjuntar Archivo</label>
                                        <input type="file" class="span12" name="userfile[]" multiple="multiple" size="20" />
                                    </div>
                                    <div class="span2">
                                        <label for="">.</label>
                                        <button class="btn btn-success span12"><i class="icon-white icon-plus"></i> Adjuntar</button>
                                    </div>
                                    </form>
                                </div>
                
                                <div class="span12" id="divAnexos" style="margin-left: 0">
                                    <?php 
                                   $cont = 1;
                                    $flag = 5;
                                   foreach ($anexos as $a) {

                                        if($a->thumb == null){
                                            $thumb = base_url().'assets/img/icon-file.png';
                                            $link = base_url().'assets/img/icon-file.png';
                                        }
                                        else{
                                            $thumb = base_url().'assets/anexos/thumbs/'.$a->thumb;
                                            $link = $a->url.$a->anexo;
                                        }

                                        if($cont == $flag){
                                           echo '<div style="margin-left: 0" class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                           $flag += 4;
                                        }
                                        else{
                                           echo '<div class="span3"><a href="#modal-anexo" imagem="'.$a->idAnexos.'" link="'.$link.'" role="button" class="btn anexo" data-toggle="modal"><img src="'.$thumb.'" alt=""></a></div>'; 
                                        }
                                        $cont ++;
                                    }  ?>
                                </div>






            <?php/* if (!$results) { */?>
                
                       <!-- <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#</th>
                                    <th>Fecha Inicial</th>
                                    <th>Fecha Final</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td colspan="6">Ninguna Solicitud Registrada</td>
                                </tr>
                            </tbody>
                        </table>-->
                
                <?php /*} else {*/ ?>


              

                      <!--  <table class="table table-bordered ">
                            <thead>
                                <tr style="backgroud-color: #2D335B">
                                    <th>#</th>
                                    <th>Fecha Inicial</th>
                                    <th>Fecha Final</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>-->
<?php
         /*       foreach ($results as $r) {
                    $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                    $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                    echo '<tr>';
                    echo '<td>' . $r->idOs . '</td>';
                    echo '<td>'.$dataInicial.'</td>';
                    if($dataFinal ==  "01/01/1970"){
                    echo '<td>'.' La orden sigue abierta '.'</td>';
                    }
                    else{
                    echo '<td>'.$dataFinal.'</td>';
                    }
                    echo '<td>' . $r->descricaoProduto . '</td>';
                    echo '<td>' . $r->status . '</td>';

                    echo '<td>';
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
                        echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn tip-top" title="Ver mas detalles"><i class="icon-eye-open"></i></a>'; 
                    }
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
                        echo '<a href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="btn btn-info tip-top" title="Editar OS"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                    
                    echo  '</td>';
                    echo '</tr>';
                }*/ ?>
                           <!-- <tr>

                            </tr>
                        </tbody>
                    </table>-->
            

            <?php /* }*/ ?>
    
        </div>
    </div>