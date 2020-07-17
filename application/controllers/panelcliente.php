<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelCliente extends CI_Controller {

	public function __construct(){

		parent::__construct();
        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('Conecte_model');
        $this->load->library("email");
        
    }
    




	public function index(){

        $this->load->library('form_validation');       
        $this->data['custom_error'] = '';
        $this->load->view('panelcliente/login',$this->data);    
        mail('ronald152515@gmail.com', 'Nueva O.S', 'Nueva Orden de Servicio Ingresada');    
		
	}

	public function sair(){
        $this->session->sess_destroy();
        redirect('panelcliente');
    }


    public function login(){

        $this->load->library('form_validation');
     /* $this->form_validation->set_rules('email','Email','valid_email|required|xss_clean|trim');*/
        $this->form_validation->set_rules('documento','Documento','Documento valido|required|xss_clean|trim');
      /*  $this->form_validation->set_rules('telefono','Telefono','required|xss_clean|trim');*/
      $this->form_validation->set_rules('clave','Clave','required|xss_clean|trim');
        $ajax = $this->input->get('ajax');
        if ($this->form_validation->run() == false) {
            
            if($ajax == true){
                $json = array('result' => false);
                echo json_encode($json);
            }
            else{
                $this->session->set_flashdata('error','Los datos de acceso son incorrectos.');
                redirect(base_url().'panelcliente');
            }

        } 
        else {
          /* $email = $this->input->post('email');*/ 
          $clave = $this->input->post('clave');
          $this->load->library('encrypt');   
          $clave = $this->encrypt->sha1($clave);
           $documento = $this->input->post('documento');
          /*  $telefono = $this->input->post('telefono');*/
          /* $this->db->where('email',$email);*/
           $this->db->where('documento',$documento);
          /*  $this->db->where('telefono',$telefono);*/
           $this->db->where('clave',$clave);

            $this->db->limit(1);

            $cliente = $this->db->get('clientes')->row();

            if(count($cliente) > 0){
                $dados = array('nombre' => $cliente->nombreCliente, 'id' => $cliente->idClientes,'token' => 20540658, 'ruc' => $cliente->documento, 'conectado' => TRUE);
                $this->session->set_userdata($dados);

                if($ajax == true){
                    $json = array('result' => true);
                    echo json_encode($json);
                }
                else{
                    redirect(base_url().'panelcliente');
                }    
            }
            else{
                if($ajax == true){
                    $json = array('result' => false);
                    echo json_encode($json);
                }
                else{
                    $this->session->set_flashdata('error','Los datos de acceso son incorrectos.');
                    redirect(base_url().'panelcliente');
                }
            }
            
        }
        
    }




	public function painel(){
		
		

        $data['menuPainel'] = 'painel';
		$data['compras'] = $this->Conecte_model->getLastCompras($this->session->userdata('id'));
        $data['os'] = $this->Conecte_model->getLastOs($this->session->userdata('id'));
        $data['cantidadsolicitudes'] = $this->Conecte_model->countsolicitudes('solicitudes',0);

		$data['output'] = 'panelcliente/painel';
		$this->load->view('panelcliente/template',$data);

	}


	public function conta(){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $this->load->model('clientes_model');
        $this->load->library('table');
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php/panelcliente/conta/';
        $config['total_rows'] = $this->Conecte_model->countx('lineas');
        $config['per_page'] = 20;
        $config['next_link'] = 'Siguiente';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Ultimo';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 	
        
	    $data['results3'] = $this->Conecte_model->geta('lineas','idlinea,descripcion,fechainicio,fechafin,fecharegistro,estadolinea,idClientes',$this->session->userdata('id'),$config['per_page'],$this->uri->segment(3));
        $data['results4'] = $this->Conecte_model->getb('solicitudes','idsolicitud,nombre,fechainicio,fechafin,fecharegistro,estadosolicitud,idClientes',$this->session->userdata('id'),$config['per_page'],$this->uri->segment(3));
            
        $data['menuConta'] = 'conta';
        $data['result'] = $this->Conecte_model->getDados();
        $data['result2'] = $this->Conecte_model->getSolicitudById($this->session->userdata('id'));
        $data['anexos2'] = $this->Conecte_model->getAnexos($this->session->userdata('id'));
       
        $data['output'] = 'panelcliente/conta';
        $this->load->view('panelcliente/template',$data);
	}




    public function editarDados($id = null){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
            redirect('conecte');
        }

        $data['menuConta'] = 'conta';

        $this->load->library('form_validation');
        $data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeCliente' => $this->input->post('nomeCliente'),
                'documento' => $this->input->post('documento'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'rua' => $this->input->post('rua'),
                'numero' => $this->input->post('numero'),
                'bairro' => $this->input->post('bairro'),
                'cidade' => $this->input->post('cidade'),
                'estado' => $this->input->post('estado'),
                'cep' => $this->input->post('cep')
            );

            if ($this->Conecte_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
                $this->session->set_flashdata('success','Datos editados con éxito!');
                redirect(base_url() . 'index.php/panelcliente/conta');
            } else {
                
            }
        }

        $data['result'] = $this->Conecte_model->getDados();
       
        $data['output'] = 'panelcliente/editar_dados';
        $this->load->view('panelcliente/template',$data);
    }


   

	public function compras(){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['menuVendas'] = 'vendas';
		$this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/panelcliente/compras/';
        $config['total_rows'] = $this->Conecte_model->count('vendas',$this->session->userdata('id'));
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        	
        $this->pagination->initialize($config); 	

		$data['results'] = $this->Conecte_model->getCompras('vendas','*','',$config['per_page'],$this->uri->segment(3),'','',$this->session->userdata('id'));
       
	    $data['output'] = 'panelcliente/compras';
       	$this->load->view('panelcliente/template',$data);

	}

	public function os(){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['menuOs'] = 'os';
		$this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/panelcliente/os/';
        $config['total_rows'] = $this->Conecte_model->count('os',$this->session->userdata('id'));
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        	
        $this->pagination->initialize($config); 	

		$data['results'] = $this->Conecte_model->getOs('os','*','',$config['per_page'],$this->uri->segment(3),'','',$this->session->userdata('id'));
       
	    $data['output'] = 'panelcliente/os';
       	$this->load->view('panelcliente/template',$data);
	}

    public function aparatos(){
        
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
            redirect('panelcliente');
        }

        $data['menua'] = 'aparatos';
        $this->load->library('pagination');
        
        $config['base_url'] = base_url().'index.php/panelcliente/aparatos/';
        $config['total_rows'] = $this->Conecte_model->count('aparatos',$this->session->userdata('id'));
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
            
        $this->pagination->initialize($config);     

        $data['results'] = $this->Conecte_model->obtenerA('aparatos','*','',$config['per_page'],$this->uri->segment(3),'','',$this->session->userdata('id'));
       
        $data['output'] = 'panelcliente/aparatos';
        $this->load->view('panelcliente/template',$data);
    }

    public function solicitaros(){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
            redirect('panelcliente');
        }


        $this->load->library('form_validation');
        $data['menuOs'] = 'os';
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('os') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {
                
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];

            } catch (Exception $e) {
               $dataInicial = date('Y/m/d'); 
            }

            $data = array(
                'dataInicial' => $dataInicial,

                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),

                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),

                'dataFinal' => $dataFinal,

                'garantia' => set_value('garantia'),

                'descricaoProduto' => set_value('descricaoProduto'),

                'defeito' => set_value('defeito'),

                'status' => set_value('status'),

                'observacoes' => set_value('observacoes'),

                'laudoTecnico' => set_value('laudoTecnico'),
                
                'modelo' => set_value('modelo'),
                
                'marca' => set_value('marca'),
                
                'serie' => set_value('serie'),
                
                'tipo' => set_value('tipo'),

                'faturado' => 0
            );

            if ( is_numeric($id = $this->Conecte_model->add('os', $data, true)) ) {
                $this->session->set_flashdata('success','Su solicitud se registró con exito, en breve nos contactaremos con usted');
                mail('tuEmail', 'Solicitud de Servicio', 'Solicitud de Servicio abierta por el Cliente, por favor Ponerce en contacto en el Cliente lo antes posible.');
                redirect('panelcliente/os/');

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Hubo un error</p></div>';
            }
        }
        $data['result'] = $this->Conecte_model->getDados(); 
        $data['output'] = 'panelcliente/solicitar_servicio';
        $this->load->view('panelcliente/template', $data);
    }
    

    public function adicionarAjax(){
        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
           $json = array("result"=> false);
           echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),

                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),

                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),

                'dataFinal' => set_value('dataFinal'),

                'garantia' => set_value('garantia'),

                'descricaoProduto' => set_value('descricaoProduto'),

                'defeito' => set_value('defeito'),

                'status' => set_value('status'),

                'observacoes' => set_value('observacoes'),

                'laudoTecnico' => set_value('laudoTecnico'),
                
                'modelo' => set_value('modelo'),
                
                'marca' => set_value('marca'),
                
                'serie' => set_value('serie'),
                
                'tipo' => set_value('tipo')
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $json = array("result"=> true, "id"=> $id);
                echo json_encode($json);

            } else {
                $json = array("result"=> false);
                echo json_encode($json);

            }
        }
         
    }

	public function visualizarOs($id = null){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['menuOs'] = 'os';
		$this->data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->load->model('os_model');
        $data['result'] = $this->os_model->getById($this->uri->segment(3));
        $data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $data['emitente'] = $this->mapos_model->getEmitente();

        $data['output'] = 'panelcliente/visualizar_os';
        $this->load->view('panelcliente/template', $data);

	}

	public function visualizarCompra($id = null){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['menuVendas'] = 'vendas';
		$data['custom_error'] = '';
        $this->load->model('mapos_model');
        $this->load->model('vendas_model');
        $data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $data['emitente'] = $this->mapos_model->getEmitente();

        $data['output'] = 'panelcliente/visualizar_compra';
        $this->load->view('panelcliente/template', $data);
    }
    

    
    public function visualizarLineas($id = null){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['result'] = $this->Conecte_model->getById_clientes_lineas($this->uri->segment(3));
        $data['anexos'] = $this->Conecte_model->getAnexosfiltroslinea($this->session->userdata('id'),'1',$this->uri->segment(3));
        $data['anexos3'] = $this->Conecte_model->getAnexosfiltroslinearpta($this->session->userdata('id'),'3',$this->uri->segment(3));
        $data['output'] = 'panelcliente/visualizarlineas';
        $this->load->view('panelcliente/template', $data);
    }
    

    public function editarLineas($id = null){
		
		if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
        	redirect('panelcliente');
        }

        $data['result'] = $this->Conecte_model->getById_clientes_lineas($this->uri->segment(3));
        $data['anexos'] = $this->Conecte_model->getAnexosfiltroslinea($this->session->userdata('id'),'1',$this->uri->segment(3));
       
        $data['output'] = 'panelcliente/editarLineas';
        $this->load->view('panelcliente/template', $data);
    }


    public function editarlineabd($id = null){
		
               if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
                   redirect('panelcliente');
                 }
                
                  $this->load->model('conecte_model');

                 $data['result'] = $this->Conecte_model->getlineaById_($this->uri->segment(3));
                 $data['anexos'] = $this->Conecte_model->getAnexosfiltroslinea($this->session->userdata('id'),'1',$this->uri->segment(3));

                  $datax = array(

                       'descripcion' => $this->session->userdata('nombre') ,
                       'idClientes' => $this->session->userdata('id')   

                );

                 if ($this->conecte_model->edit('lineas', $datax, 'idlinea',$this->uri->segment(3) ) == TRUE) {

                            if(!empty($_FILES['userfile1']['name'])){
                              $nombreCompleto          = $_FILES['userfile1']['name'];
                              $config['upload_path']   = '././assets/anexos/';
                              $config['allowed_types'] = '*';
                              $config['max_size']      = 2000;
                              $config['max_width']     = 0;
                              $config['max_height']    = 0;
                              $config['file_name']     = $nombreCompleto;
                              $this->load->library('upload', $config);
        
                               if (!$this->upload->do_upload('userfile1')) {
                
                                $data['uploadError'] = $this->upload->display_errors();
                                echo $this->upload->display_errors();
                                return;
                               }
            
                               $data['uploadSuccess'] = $this->upload->data();

                                $this->Conecte_model->anexarlinea($this->session->userdata('id'), $_FILES['userfile1']['name'] ,base_url().'assets/anexos/','thumb_'.$_FILES['userfile1']['name'],realpath('./assets/anexos/'),'1',$this->input->post('idlineaultimo'),'archivo linea1');
                  } 


                  if(!empty($_FILES['userfile2']['name'])){
                               $nombreCompleto          = $_FILES['userfile2']['name'];
                               $config['upload_path']   = '././assets/anexos/';
                               $config['allowed_types'] = '*';
                               $config['max_size']      = 2000;
                               $config['max_width']     = 0;
                               $config['max_height']    = 0;
                                $config['file_name']     = $nombreCompleto;
                               $this->load->library('upload', $config);
 
                            if (!$this->upload->do_upload('userfile2')) {
         
                             $data['uploadError'] = $this->upload->display_errors();
                             echo $this->upload->display_errors();
                            return;
                           }
     
                            $data['uploadSuccess'] = $this->upload->data();
                             $this->Conecte_model->anexarlinea($this->session->userdata('id'), $_FILES['userfile2']['name'] ,base_url().'assets/anexos/','thumb_'.$_FILES['userfile2']['name'],realpath('./assets/anexos/'),'1',$this->input->post('idlineaultimo'),'archivo linea2');
                    } 



                  if(!empty($_FILES['userfile3']['name'])){        
                            $nombreCompleto          = $_FILES['userfile3']['name'];
                            $config['upload_path']   = '././assets/anexos/';
                            $config['allowed_types'] = '*';
                            $config['max_size']      = 2000;
                             $config['max_width']     = 0;
                            $config['max_height']    = 0;
                            $config['file_name']     = $nombreCompleto;
                            $this->load->library('upload', $config);

                           if (!$this->upload->do_upload('userfile3')) {
 
                             $data['uploadError'] = $this->upload->display_errors();
                              echo $this->upload->display_errors();
                             return;
                           }

                           $data['uploadSuccess'] = $this->upload->data();

 
                           $this->Conecte_model->anexarlinea($this->session->userdata('id'), $_FILES['userfile3']['name'] ,base_url().'assets/anexos/','thumb_'.$_FILES['userfile3']['name'],realpath('./assets/anexos/'),'1',$this->input->post('idlineaultimo'),'archivo linea3');
                    } 

                    if(!empty($_FILES['userfile4']['name'])){
                        $nombreCompleto          = $_FILES['userfile4']['name'];
                        $config['upload_path']   = '././assets/anexos/';
                        $config['allowed_types'] = '*';
                        $config['max_size']      = 2000;
                        $config['max_width']     = 0;
                        $config['max_height']    = 0;
                         $config['file_name']     = $nombreCompleto;
                         $this->load->library('upload', $config);

                       if (!$this->upload->do_upload('userfile4')) {

                         $data['uploadError'] = $this->upload->display_errors();
                        echo $this->upload->display_errors();
                           return;
                        }

                       $data['uploadSuccess'] = $this->upload->data();


                         $this->Conecte_model->anexarlinea($this->session->userdata('id'), $_FILES['userfile4']['name'] ,base_url().'assets/anexos/','thumb_'.$_FILES['userfile4']['name'],realpath('./assets/anexos/'),'1',$this->input->post('idlineaultimo'),'archivo linea4');
                     } 

                   

                   $this->session->set_flashdata('success','linea modificada con éxito!');
                    redirect(base_url() . 'index.php/panelcliente/conta');
                 } else {
                      $data['custom_error'] = '<div class="form_error"><p>A ocurrido un error.</p></div>';
                 }


              $data['output'] = 'panelcliente/editarLineas';
              $this->load->view('panelcliente/template', $data);
    }






    public function apcrear() {

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
            redirect('panelcliente');
        }

        
        $this->load->library('form_validation');
        $data['menua'] = 'aparatos';
        $data['custom_error'] = '';
        $this->load->model('conecte_model');
        

        if ($this->form_validation->run('aparatos') == false) {
            $data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {            
            $data = array(
                'IDclientes' => set_value('clid'),
                'nombre' => set_value('nombre'),
                'tipo' => set_value('tipo'),
                'modelo' => set_value('modelo'),                
                'marca' => set_value('marca'),
                'n_serie' => set_value('serie')
                
            );

            if ($this->conecte_model->aparatoadd('aparatos', $data) == TRUE) {
                $this->session->set_flashdata('success','Producto agregado con éxito!');
                redirect(base_url() . 'index.php/panelcliente/aparatos/');
            } else {
                $data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        
        $data['output'] = 'panelcliente/adicionaraparato';;
        $this->load->view('panelcliente/template', $data);
     
    } 


   public function adicionarCo() {
    
        $this->load->model('clientes_model');
        $this->load->library('form_validation');
        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            redirect(base_url().'panelcliente');
        } else {

            $this->load->library('encrypt');     
            $data = array(
               
                'documento' => $this->input->post('documento'),
                'tipodocumento' => $this->input->post('tipodocumento'),
                'nombreCliente' => $this->input->post('nombre'),
                'email' => $this->input->post('correo'),
                'fechaRegistro' => date('Y-m-d'),
                'estadocli' => "pendiente",
                'clave' => $this->encrypt->sha1($this->input->post('clave'))

            );

            if ($this->clientes_model->add('clientes', $data) == TRUE) {
              
                $documento = $this->input->post('documento');
                $clave = $this->input->post('clave');
                  
                $clave = $this->encrypt->sha1($clave);

                $this->db->where('documento',$documento);
              
                $this->db->where('clave',$clave);
      
                 $this->db->limit(1);
      
                 
                $cliente2 = $this->db->get('clientes')->row();

                 if(count($cliente2) > 0){
                      $dados = array('nombre' => $cliente2->nombreCliente, 'id' => $cliente2->idClientes,'token' => 20540658, 'ruc' => $cliente2->documento, 'conectado' => TRUE);
                       $this->session->set_userdata($dados);
                  
                  }




            
             $this->session->set_flashdata('success','Bienvenido '.$cliente2->nombreCliente."!");
               
            
             redirect(base_url().'index.php/panelcliente/painel');
            } else { 
                $this->data['custom_error'] = '<div class="form_error"><p>A ocurrido un error guardando sus datos pongase en contacto con el administrador</p></div>';
               
               
            }    
        }

      
       $this->load->view('panelcliente/login',$this->data);

    }





    public function agregarsolicitudes(){
        $this->load->model('Conecte_model');
     
     
        $data['result'] = $this->Conecte_model->getById($this->session->userdata('id'));

      
    
        $data['output'] = 'panelcliente/agregarsolicitudes';
        $this->load->view('panelcliente/template',$data);  
    }




    public function editarsolicitudes(){

        $this->load->model('Conecte_model');
      

      $data1 = array(
        'nombreCliente' => $this->input->post('nombreCliente'),
        'barrio' => $this->input->post('barrio'),
        'ciudad' => $this->input->post('ciudad'),
        'estado' => $this->input->post('estado')
       
    );

   
    if ($this->Conecte_model->edit('clientes', $data1, 'idClientes', $this->session->userdata('id')) == TRUE) {

        $data2 = array( 
            'nombre'	=> $this->input->post('tipo') , 
            'idClientes' =>  $this->session->userdata('id')
            
        );
       $this->db->insert('solicitudes', $data2);


        $this->session->set_flashdata('success','Cliente editado con éxito!');
        redirect(base_url() . 'index.php/panelcliente/agregarsolicitudes');

    } else {
       $this->data['custom_error'] = '<div class="form_error"><p>Ocurrió un error</p></div>';
    }
     
        
        $data['output'] = 'panelcliente/agregarsolicitudes';
        $this->load->view('panelcliente/template',$data);

    }


    public function agregarlineas(){

        $this->load->model('Conecte_model');
        $data['result'] = $this->Conecte_model->getById($this->session->userdata('id'));
        $data['anexos'] = $this->Conecte_model->getAnexos($this->session->userdata('id'));
        $data['output'] = 'panelcliente/agregarlineas';
        $this->load->view('panelcliente/template',$data);  

    }



    public function anexar(){

        $this->load->library('upload');
        $this->load->library('image_lib');
        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para adjuntar a la OS
            'max_size'      => 0,
            );

        $this->upload->initialize($upload_conf);

        // Change $_FILES to new vars and loop them

        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }

        // Unset the useless one ;)
        unset($_FILES['userfile']);
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
                // if upload fail, grab error 
                $error['upload'][] = $this->upload->display_errors();
            }
            else
            {
                // otherwise, put the upload datas here.
                // if you want to use database, put insert query in this loop
                $upload_data = $this->upload->data();

                if($upload_data['is_image'] == 1){
                   // set the resize config

                    $resize_conf = array(
                        // it's something like "/full/path/to/the/image.jpg" maybe
                        'source_image'  => $upload_data['full_path'], 
                        // and it's "/full/path/to/the/" + "thumb_" + "image.jpg
                        // or you can use 'create_thumbs' => true option instead
                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],

                        'width'         => 200,

                        'height'        => 125

                        );

                    // initializing

                    $this->image_lib->initialize($resize_conf);

                    // do it!

                    if ( ! $this->image_lib->resize())

                    {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    }
                    else
                    {
                        // otherwise, put each upload data to an array.
                        $success[] = $upload_data;
                      //  $this->load->model('Os_model');
                        $this->load->model('Conecte_model');
                        $this->Conecte_model->anexar($this->session->userdata('id'), $upload_data['file_name'] ,base_url().'assets/anexos/','thumb_'.$upload_data['file_name'],realpath('./assets/anexos/'));
                    } 
                }

                else{

                    $success[] = $upload_data;
                    //$this->load->model('Os_model');
                    $this->load->model('Conecte_model');
                    $this->Conecte_model->anexar($this->session->userdata('id'), $upload_data['file_name'] ,base_url().'assets/anexos/','',realpath('./assets/anexos/'));
                }

            }

        }

        // see what we get
        if(count($error) > 0)
        {
            //print_r($data['error'] = $error);
            echo json_encode(array('result'=> false, 'mensagem' => 'Ningún archivo fue adjuntado.'));
        }
        else
        {
            //print_r($data['success'] = $upload_data);
            echo json_encode(array('result'=> true, 'mensagem' => 'Archivo(s) adjuntado(s) con éxito.'));
        }
    }


    public function subirArchivo(){

		$config['upload_path'] = './assets/anexos/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '20048';

        $this->load->library('upload',$config);

        if (!$this->upload->do_upload("userfile")) {
            $data['errorArch'] = $this->upload->display_errors();
			
          //  $this->load->view('vupload',$data);
            
            $this->load->view('panelcliente/template',$data);  
			
        } else {

            $file_info = $this->upload->data();
           
            $titulo = "xxx";
            $archivo = $file_info['file_name'];
            $subir = $this->Conecte_model->cargararchivos($titulo,$archivo,$this->session->userdata('id'));  
            
            
            $data['archivo'] = $archivo;
	
         //  $documento = $this->input->post('documento');
           $razonsocial = $this->input->post('razonsocial');
           $telefono1 = $this->input->post('telefono1');
           $telefono2 = $this->input->post('telefono2');
           $telefono3 = $this->input->post('telefono3');
           $correo1 = $this->input->post('correo1');
           $correo2 = $this->input->post('correo2');
           $departamento = $this->input->post('departamento');
           $provincia = $this->input->post('provincia');
           $distrito = $this->input->post('distrito');
           $direccion = $this->input->post('direccion');
           $referencia = $this->input->post('referencia');


           $datax = array(
            'razonsocial' => $this->input->post('razonsocial'),
            'telefono' => $this->input->post('telefono1'),
            'celular' => $this->input->post('telefono2'),
            'telefono3' => $this->input->post('telefono3'),
            'email' => $this->input->post('correo1'),
            'email2' => $this->input->post('correo2'),
            'estado' => $this->input->post('departamento'),
            'ciudad' => $this->input->post('provincia'),
            'barrio' => $this->input->post('distrito'),
            'ruc' => $this->input->post('direccion'),
            'referencia' => $this->input->post('referencia')

           
        );
 


           /*  */
           if ($this->Conecte_model->edit('clientes', $datax, 'idClientes', $this->session->userdata('id')) == TRUE) {
            $this->session->set_flashdata('success','linea creada satisfactoriamente y datos actualizados!');
            redirect(base_url() . 'index.php/panelcliente/conta');
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocurrió un error</p></div>';
        }
          /*   */


          $data['output'] = 'panelcliente/agregarlineas';
         $this->load->view('panelcliente/template',$data);
			
        }
    }





    public function guardar_linea(){




                         $razonsocial = $this->input->post('razonsocial');
                         $telefono1   = $this->input->post('telefono1');
                         $telefono2   = $this->input->post('telefono2');
                         $telefono3   = $this->input->post('telefono3');
                         $correo1     = $this->input->post('correo1');
                         $correo2     = $this->input->post('correo2');
                         $departamento = $this->input->post('departamento');
                         $provincia = $this->input->post('provincia');
                         $distrito = $this->input->post('distrito');
                         $direccion = $this->input->post('direccion');
                         $referencia = $this->input->post('referencia');


                       $datax = array(
                            'razonsocial' => $this->input->post('razonsocial'),
                            'telefono' => $this->input->post('telefono1'),
                            'celular' => $this->input->post('telefono2'),
                            'telefono3' => $this->input->post('telefono3'),
                            'email' => $this->input->post('correo1'),
                            'email2' => $this->input->post('correo2'),
                            'estado' => $this->input->post('departamento'),
                             'ciudad' => $this->input->post('provincia'),
                            'barrio' => $this->input->post('distrito'),
                            'ruc' => $this->input->post('direccion'),
                            'referencia' => $this->input->post('referencia')
                       );


                       $data2= array(
                            'descripcion' => $this->input->post('razonsocial'),
                            'fechainicio' => '',
                            'fechafin' => '',
                            'fecharegistro' => date('d-m-Y'),
                            'estadolinea' => '0',
                            'idClientes' => $this->session->userdata('id')
                          );


                     if ($this->Conecte_model->edit('clientes', $datax, 'idClientes', $this->session->userdata('id')) == TRUE) {



                        if ( is_numeric($codlinea = $this->Conecte_model->addlineanueva('lineas', $data2,true))) {

		                            //configuracion para gmail
		                               $configGmail = array(
			                               'protocol' => 'smtp',
			                              /* 'smtp_host' => 'smtp.live.com', */
			                               'smtp_host' => 'ssl://smtp.gmail.com',
			                               'smtp_port' => 465,
			                               'smtp_user' => 'ronald152515@gmail.com',
			                               'smtp_pass' => 'ronaldsandy',
			                               'mailtype' => 'html',
			                               'charset' => 'utf-8',
			                               'newline' => "\r\n"
		                                 );

		                           //cargamos la configuración para enviar con gmail
		                                $this->email->initialize($configGmail);

		                                 $this->email->from('ronald152515@gmail.com');
		                                 $this->email->to("ronald152515@gmail.com");
		                                 $this->email->subject('Esto es una prueba');
		                                 $this->email->message('<h2>Correo con imagen</h2>');


		                                for ($i=1; $i <=1 ; $i++) { 
			                                 if ($this->email->send()) {
				                                      echo "Enviado ronald alejo";
			                                    }else{
				                                     show_error($this->email->print_debugger());
			                                        }
			                                sleep(1);
		                                      }



                                if(!empty($_FILES['userfile1']['name'])){

                                     $nombreCompleto          = $_FILES['userfile1']['name'];
                                     $config['upload_path']   = '././assets/anexos/';
                                     $config['allowed_types'] = '*';
                                     $config['max_size']      = 2000;
                                     $config['max_width']     = 0;
                                     $config['max_height']    = 0;
                                     $config['file_name']     = $nombreCompleto;
                                     $this->load->library('upload', $config);
                                
                                    if (!$this->upload->do_upload('userfile1')) {
                                        //*** ocurrio un error
                                        $data['uploadError'] = $this->upload->display_errors();
                                        echo $this->upload->display_errors();
                                        return;
                                    }
                                
                                    $data['uploadSuccess'] = $this->upload->data();
                
                                    $this->Conecte_model->anexarlinea($this->session->userdata('id'),  $nombreCompleto ,base_url().'assets/anexos/','thumb_'. $nombreCompleto,realpath('./assets/anexos/'),'1',$codlinea,"archivo linea1");
                                  } 
                
                                if(!empty($_FILES['userfile2']['name'])){
                                            
                                    $nombreCompleto2          = $_FILES['userfile2']['name'];
                                    $config2['upload_path']   = '././assets/anexos/';
                                    $config2['allowed_types'] = '*';
                                    $config2['max_size']      = 2000;
                                    $config2['max_width']     = 0;
                                    $config2['max_height']    = 0;
                                    $config2['file_name']     = $nombreCompleto2;
                                    $this->load->library('upload', $config2);
                                
                                    if (!$this->upload->do_upload('userfile2')) {
                                        //*** ocurrio un error
                                        $data['uploadError'] = $this->upload->display_errors();
                                        echo $this->upload->display_errors();
                                        return;
                                    }
                                
                                    $data['uploadSuccess'] = $this->upload->data();
                                    $this->Conecte_model->anexarlinea($this->session->userdata('id'),$nombreCompleto2 ,base_url().'assets/anexos/','thumb_'. $nombreCompleto2,realpath('./assets/anexos/'),'1',$codlinea, "archivo linea2");
                                 }


                                if(!empty($_FILES['userfile3']['name'])){
                                        
                                    $nombreCompleto3          = $_FILES['userfile3']['name'];
                                    $config3['upload_path']   = '././assets/anexos/';
                                    $config3['allowed_types'] = '*';
                                    $config3['max_size']      = 2000;
                                    $config3['max_width']     = 0;
                                    $config3['max_height']    = 0;
                                    $config3['file_name']     = $nombreCompleto3;
                                    $this->load->library('upload', $config3);
                                
                                    if (!$this->upload->do_upload('userfile3')) {
                                        //*** ocurrio un error
                                        $data['uploadError'] = $this->upload->display_errors();
                                        echo $this->upload->display_errors();
                                        return;
                                    }
                                
                                    $data['uploadSuccess'] = $this->upload->data();
                                   
                                    $this->Conecte_model->anexarlinea($this->session->userdata('id'), $nombreCompleto3 ,base_url().'assets/anexos/','thumb_'.$nombreCompleto3,realpath('./assets/anexos/'),'1',$codlinea,"archivo linea3");
                                 }

                                if(!empty($_FILES['userfile4']['name'])){
                                             
                                    $nombreCompleto4          = $_FILES['userfile4']['name'];
                                    $config4['upload_path']   = '././assets/anexos/';
                                    $config4['allowed_types'] = '*';
                                    $config4['max_size']      = 2000;
                                    $config4['max_width']     = 0;
                                    $config4['max_height']    = 0;
                                    $config4['file_name']     = $nombreCompleto4;
                                    $this->load->library('upload', $config4);
                                
                                    if (!$this->upload->do_upload('userfile4')) {
                                        //*** ocurrio un error
                                        $data['uploadError'] = $this->upload->display_errors();
                                        echo $this->upload->display_errors();
                                        return;
                                    }
                                
                                    $data['uploadSuccess'] = $this->upload->data();
                                   
                                    $this->Conecte_model->anexarlinea($this->session->userdata('id'), $nombreCompleto4 ,base_url().'assets/anexos/','thumb_'.$nombreCompleto4,realpath('./assets/anexos/'),'1',$codlinea,"archivo linea4");
                                 }


                                $this->session->set_flashdata('success','Linea agregada con éxito!');
                                // redirect(base_url() . 'index.php/panelcliente/conta');

                            } else {
                                 $this->data['custom_error'] = '<div class="form_error"><p>No se pudo agregar línea.</p></div>';
                           }

                                $this->session->set_flashdata('success','linea creada satisfactoriamente y datos actualizados!');
                                redirect(base_url() . 'index.php/panelcliente/conta');

                      } else {
                          $this->data['custom_error'] = '<div class="form_error"><p>Ocurrió un error</p></div>';
                      }
          
                     $data['output'] = 'panelcliente/agregarlineas';
                     $this->load->view('panelcliente/template',$data);
        }
    

    


        public function guardarsolicitud(){

            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
                redirect('panelcliente');
            }
    
            $data['custom_error'] = '';
            $this->load->model('conecte_model');
            
                  
                    $data = array(
                        'nombre' => $this->input->post('tipo') ,
                        'idClientes' => $this->session->userdata('id')      
                    );

                    if ( is_numeric($codsolicitud = $this->conecte_model->addSolicitud('solicitudes', $data,true))) {

                        $configGmail = array(
                            'protocol' => 'smtp',
                           /*'smtp_host' => 'smtp.live.com',*/
                            'smtp_host' => 'ssl://smtp.gmail.com',
                            'smtp_port' => 465,
                            'smtp_user' => '******',
                            'smtp_pass' => '******',
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n"
                          );

                    //cargamos la configuración para enviar con gmail
                         $this->email->initialize($configGmail);

                          $this->email->from('********');
                          $this->email->to("*********);
                          $this->email->subject('Esto es una prueba');
                          $this->email->message('<h2>Correo con imagen</h2>');


                            for ($i=1; $i <=1 ; $i++) { 
                                   if ($this->email->send()) {
                                            echo "Enviado ronald alejo";
                                     }else{
                                           show_error($this->email->print_debugger());
                                        }
                                     sleep(1);
                               }


                                if(!empty($_FILES['userfile1']['name'])){
                                      $nombreCompleto          = $_FILES['userfile1']['name'];
                                      $config['upload_path']   = '././assets/anexos2/';
                                      $config['allowed_types'] = '*';
                                      $config['max_size']      = 2000;
                                      $config['max_width']     = 0;
                                      $config['max_height']    = 0;
                                      $config['file_name']     = $nombreCompleto;
                                      $this->load->library('upload', $config);
                    
                                if (!$this->upload->do_upload('userfile1')) {
                                            //*** ocurrio un error
                                           $data['uploadError'] = $this->upload->display_errors();
                                            echo $this->upload->display_errors();
                                        return;
                                  }
                    
                                 $data['uploadSuccess'] = $this->upload->data();
                                 $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile1']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile1']['name'],realpath('./assets/anexos2/'),'2',$codsolicitud,"archivo solicitud1");
                                } 

                                if(!empty($_FILES['userfile2']['name'])){
                                       $nombreCompleto2          = $_FILES['userfile2']['name'];
                                       $config2['upload_path']   = '././assets/anexos2/';
                                       $config2['allowed_types'] = '*';
                                       $config2['max_size']      = 2000;
                                       $config2['max_width']     = 0;
                                       $config2['max_height']    = 0;
                                       $config2['file_name']     = $nombreCompleto2;
                                       $this->load->library('upload', $config2);
                    
                                    if (!$this->upload->do_upload('userfile2')) {
                                           //*** ocurrio un error
                                          $data['uploadError'] = $this->upload->display_errors();
                                          echo $this->upload->display_errors();
                                          return;
                                       }
                    
                                    $data['uploadSuccess'] = $this->upload->data();
                                    $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile2']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile2']['name'],realpath('./assets/anexos2/'),'2',$codsolicitud,"archivo solicitud2");
                                  }
                                   if(!empty($_FILES['userfile3']['name'])){
                     
                                         $nombreCompleto3          = $_FILES['userfile3']['name'];
                                        $config3['upload_path']   = '././assets/anexos2/';
                                        $config3['allowed_types'] = '*';
                                        $config3['max_size']      = 2000;
                                        $config3['max_width']     = 0;
                                         $config3['max_height']    = 0;
                                          $config3['file_name']     = $nombreCompleto3;
                                        $this->load->library('upload', $config3);
                    
                                   if (!$this->upload->do_upload('userfile3')) {
                                         //*** ocurrio un error
                                     $data['uploadError'] = $this->upload->display_errors();
                                    echo $this->upload->display_errors();
                                   return;
                                   }
                    
                                    $data['uploadSuccess'] = $this->upload->data();
                                    $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile3']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile3']['name'],realpath('./assets/anexos2/'),'2',$codsolicitud,"archivo solicitud3");
                                   }
                                  if(!empty($_FILES['userfile4']['name'])){                                
                                     $nombreCompleto4          = $_FILES['userfile4']['name'];
                                     $config4['upload_path']   = '././assets/anexos2/';
                                     $config4['allowed_types'] = '*';
                                      $config4['max_size']      = 2000;
                                      $config4['max_width']     = 0;
                                     $config4['max_height']    = 0;
                                      $config4['file_name']     = $nombreCompleto4;
                                      $this->load->library('upload', $config4);
                    
                       
                    
                                    if (!$this->upload->do_upload('userfile4')) {
                                            //*** ocurrio un error
                                       $data['uploadError'] = $this->upload->display_errors();
                                       echo $this->upload->display_errors();
                                       return;
                                     }
                    
                                     $data['uploadSuccess'] = $this->upload->data();
                       
                                        $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile4']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile4']['name'],realpath('./assets/anexos2/'),'2',$codsolicitud,"archivo solicitud4");
                                   }


                               $this->session->set_flashdata('success','Solicitud agregada con éxito!');
                              redirect(base_url() . 'index.php/panelcliente/conta');
                     }       
                      else {
                           $data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
                       
                           $data['output'] = 'panelcliente/adicionaraparato';
                           $this->load->view('panelcliente/template', $data);
         
                       }

                }


                public function visualizarSolicitudes($id = null){
		
                    if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
                        redirect('panelcliente');
                    }
            
            
                    $data['result'] = $this->Conecte_model->getSolicitudById_($this->uri->segment(3));
                    $data['anexos'] = $this->Conecte_model->getAnexosfiltros($this->session->userdata('id'),'2',$this->uri->segment(3));
                    $data['anexos3'] = $this->Conecte_model->getAnexosfiltrossolicitudrpta($this->session->userdata('id'),'4',$this->uri->segment(3));
            
                    $data['output'] = 'panelcliente/visualizarSolicitudes';
                    $this->load->view('panelcliente/template', $data);
                }


        public function editarsolicitud($id = null){
		
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
                redirect('panelcliente');
            }
            $this->load->model('conecte_model');
            
            $data['result'] = $this->Conecte_model->getSolicitudById_($this->uri->segment(3));
            $data['anexos'] = $this->Conecte_model->getAnexosfiltros($this->session->userdata('id'),'2',$this->uri->segment(3));
           
       /*  $data = array(
                'nombre' => $this->input->post('tipo') ,
                'idClientes' => $this->session->userdata('id')      
            );*/

           // if ($this->conecte_model->edit('solicitudes', $data, 'idsolicitud','54' ) == TRUE) {

                /* if(!empty($_FILES['userfile1']['name'])){

                 
                       $nombreCompleto          = $_FILES['userfile1']['name'];
                       $config['upload_path']   = '././assets/anexos2/';
                       $config['allowed_types'] = '*';
                       $config['max_size']      = 2000;
                       $config['max_width']     = 0;
                       $config['max_height']    = 0;
                       $config['file_name']     = $nombreCompleto;
                       $this->load->library('upload', $config);
            
                    if (!$this->upload->do_upload('userfile1')) {
                    
                        $data['uploadError'] = $this->upload->display_errors();
                        echo $this->upload->display_errors();
                        return;
                    }
                
                    $data['uploadSuccess'] = $this->upload->data();

                    
                    $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile1']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile1']['name'],realpath('./assets/anexos2/'),'2');
            } */

                
            /*    $this->session->set_flashdata('success','Solicitud modificada con éxito!');
                redirect(base_url() . 'index.php/panelcliente/conta');
            } else {
                $data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
*/
            $data['output'] = 'panelcliente/editarsolicitudes';
            $this->load->view('panelcliente/template', $data);
        }




        public function editarsolicitudbd($id = null){
		
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('conectado') || ($this->session->userdata('token') != 20540658))){
                redirect('panelcliente');
            }
            $this->load->model('conecte_model');
  
            $data['result'] = $this->Conecte_model->getSolicitudById_($this->uri->segment(3));
            $data['anexos'] = $this->Conecte_model->getAnexosfiltros($this->session->userdata('id'),'2',$this->uri->segment(3));
           
            $data = array(
                'nombre' => $this->input->post('tipo') ,
                'idClientes' => $this->session->userdata('id')      
            );

            if ($this->conecte_model->edit('solicitudes', $data, 'idsolicitud',$this->uri->segment(3) ) == TRUE) {

                 if(!empty($_FILES['userfile1']['name'])){

                 
                       $nombreCompleto          = $_FILES['userfile1']['name'];
                       $config['upload_path']   = '././assets/anexos2/';
                       $config['allowed_types'] = '*';
                       $config['max_size']      = 2000;
                       $config['max_width']     = 0;
                       $config['max_height']    = 0;
                       $config['file_name']     = $nombreCompleto;
                       $this->load->library('upload', $config);
            
                    if (!$this->upload->do_upload('userfile1')) {
                    
                        $data['uploadError'] = $this->upload->display_errors();
                        echo $this->upload->display_errors();
                        return;
                    }
                
                    $data['uploadSuccess'] = $this->upload->data();

                    
                    $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile1']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile1']['name'],realpath('./assets/anexos2/'),'2',$this->input->post('soli').'archivo solicitud1');
            } 


            if(!empty($_FILES['userfile2']['name'])){

                 
                $nombreCompleto          = $_FILES['userfile2']['name'];
                $config['upload_path']   = '././assets/anexos2/';
                $config['allowed_types'] = '*';
                $config['max_size']      = 2000;
                $config['max_width']     = 0;
                $config['max_height']    = 0;
                $config['file_name']     = $nombreCompleto;
                $this->load->library('upload', $config);
     
             if (!$this->upload->do_upload('userfile2')) {
             
                 $data['uploadError'] = $this->upload->display_errors();
                 echo $this->upload->display_errors();
                 return;
             }
         
             $data['uploadSuccess'] = $this->upload->data();

             
             $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile2']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile1']['name'],realpath('./assets/anexos2/'),'2',$this->input->post('soli'),'archivo solicitud2');
     } 



     if(!empty($_FILES['userfile3']['name'])){

                 
        $nombreCompleto          = $_FILES['userfile3']['name'];
        $config['upload_path']   = '././assets/anexos2/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 2000;
        $config['max_width']     = 0;
        $config['max_height']    = 0;
        $config['file_name']     = $nombreCompleto;
        $this->load->library('upload', $config);

     if (!$this->upload->do_upload('userfile3')) {
     
         $data['uploadError'] = $this->upload->display_errors();
         echo $this->upload->display_errors();
         return;
     }
 
     $data['uploadSuccess'] = $this->upload->data();

     
     $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile3']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile3']['name'],realpath('./assets/anexos2/'),'2',$this->input->post('soli'),'archivo solicitud3');
} 
   
if(!empty($_FILES['userfile4']['name'])){

                 
    $nombreCompleto          = $_FILES['userfile4']['name'];
    $config['upload_path']   = '././assets/anexos2/';
    $config['allowed_types'] = '*';
    $config['max_size']      = 2000;
    $config['max_width']     = 0;
    $config['max_height']    = 0;
    $config['file_name']     = $nombreCompleto;
    $this->load->library('upload', $config);

 if (!$this->upload->do_upload('userfile4')) {
 
     $data['uploadError'] = $this->upload->display_errors();
     echo $this->upload->display_errors();
     return;
 }

 $data['uploadSuccess'] = $this->upload->data();

 
 $this->Conecte_model->anexarsolicitud($this->session->userdata('id'), $_FILES['userfile4']['name'] ,base_url().'assets/anexos2/','thumb_'.$_FILES['userfile4']['name'],realpath('./assets/anexos2/'),'2',$this->input->post('soli'),'archivo solicitud4');
} 





               $this->session->set_flashdata('success','Solicitud modificada con éxito!');
                redirect(base_url() . 'index.php/panelcliente/conta');
            } else {
                $data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }

            $data['output'] = 'panelcliente/editarsolicitudes';
            $this->load->view('panelcliente/template', $data);
        }






        public function guardar_solicitud(){

            $config['upload_path'] = './assets/anexos/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '20048';
    
            $this->load->library('upload',$config);
    
            if (!$this->upload->do_upload("userfile")) {
                $data['errorArch'] = $this->upload->display_errors();
                
              //  $this->load->view('vupload',$data);
                
                $this->load->view('panelcliente/template',$data);  
                
            } else {
    
                $file_info = $this->upload->data();
               
                $titulo = "xxx";
                $archivo = $file_info['file_name'];
                $subir = $this->Conecte_model->cargararchivos($titulo,$archivo,$this->session->userdata('id'));  
            
                $data['archivo'] = $archivo;
        
               $datax = array(
                'nombre' => $this->input->post('tipo'),
                'idClientes' => $this->session->userdata('id')   
            );
    
                if ($this->Conecte_model->add2('solicitudes', $datax) == TRUE) {
                    $this->session->set_flashdata('success','Solicitud creada correctamente');
                    redirect(base_url() . 'index.php/panelcliente/conta');
                } else {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ha ocurrido un error.</p></div>';
                }
    
              $data['output'] = 'panelcliente/agregarsolicitudes';
             $this->load->view('panelcliente/template',$data);
                
            }
        }



    public function anexarnuevo(){

        $this->load->library('upload');
        $this->load->library('image_lib');
        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para adjuntar a la OS
            'max_size'      => 0,
            );

        $this->upload->initialize( $upload_conf );

        // Change $_FILES to new vars and loop them

        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        // Unset the useless one ;)
        unset($_FILES['userfile']);
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
                // if upload fail, grab error 
                $error['upload'][] = $this->upload->display_errors();
            }
            else

            {

                // otherwise, put the upload datas here.

                // if you want to use database, put insert query in this loop

                $upload_data = $this->upload->data();

                

                if($upload_data['is_image'] == 1){



                   // set the resize config

                    $resize_conf = array(

                        // it's something like "/full/path/to/the/image.jpg" maybe

                        'source_image'  => $upload_data['full_path'], 

                        // and it's "/full/path/to/the/" + "thumb_" + "image.jpg

                        // or you can use 'create_thumbs' => true option instead

                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],

                        'width'         => 200,

                        'height'        => 125

                        );



                    // initializing

                    $this->image_lib->initialize($resize_conf);



                    // do it!

                    if ( ! $this->image_lib->resize())

                    {

                        // if got fail.

                        $error['resize'][] = $this->image_lib->display_errors();

                    }

                    else

                    {

                        // otherwise, put each upload data to an array.

                        $success[] = $upload_data;



                        $this->load->model('Conecte_model');



                        $this->Conecte_model->anexarlinea($this->session->userdata('id'), $upload_data['file_name'] ,base_url().'assets/anexos/','thumb_'.$upload_data['file_name'],realpath('./assets/anexos/'),'1');



                    } 

                }

                else{



                    $success[] = $upload_data;



                    $this->load->model('Conecte_model');



                    $this->Conecte_model->anexarlinea($this->session->userdata('id'), $upload_data['file_name'] ,base_url().'assets/anexos/','',realpath('./assets/anexos/'),'1');

 

                }

                

            }

        }



        // see what we get

        if(count($error) > 0)

        {

            //print_r($data['error'] = $error);

            echo json_encode(array('result'=> false, 'mensagem' => 'Ningún archivo fue adjuntado.'));

        }

        else

        {

            //print_r($data['success'] = $upload_data);

            echo json_encode(array('result'=> true, 'mensagem' => 'Archivo(s) adjuntado(s) con éxito.'));

        }

    }





    public function downloadanexo($id = null){
        if($id != null && is_numeric($id)){
            $this->db->where('idAnexos', $id);

            $file = $this->db->get('anexos',1)->row();

            $this->load->library('zip');
            $path = $file->path;
            $this->zip->read_file($path.'/'.str_replace(" ","_",$file->anexo)); 
            $this->zip->download('file'.date('d-m-Y-H.i.s').'.zip'); 
        }
    }


    public function excluirAnexo($id = null){
        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensaje' => 'Error al intentar eliminar el archivo.'));
        }
        else{
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();
            unlink($file->path.'/'.$file->anexo);

            if($file->thumb != null){

                unlink($file->path.'/thumbs/'.$file->thumb);    
            }

            if($this->Conecte_model->delete('anexos','idAnexos',$id) == true){
                echo json_encode(array('result'=> true, 'mensaje' => 'Archivo adjunto eliminado con éxito.'));
            }
            else{
                echo json_encode(array('result'=> false, 'mensaje' => 'Error al intentar eliminar el archivo.'));
            }

        }

    }



}

/* End of file conecte.php */
/* Location: ./application/controllers/conecte.php */