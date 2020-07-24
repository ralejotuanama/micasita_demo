<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mapos_model','',TRUE);   
    }

    public function index() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        $this->data['ordensW'] = $this->mapos_model->getOsWeb();
        $this->data['ordens'] = $this->mapos_model->getOsAbertas();
        $this->data['produtos'] = $this->mapos_model->getProdutosMinimo();
        $this->data['os'] = $this->mapos_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro'] = $this->mapos_model->getEstatisticasFinanceiro();
        $this->data['menuPainel'] = 'Painel';
        $this->data['view'] = 'mapos/painel';
        $this->load->view('tema/topo',  $this->data);
    }

    public function minhaConta() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        $this->data['usuario'] = $this->mapos_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'mapos/minhaConta';
        $this->load->view('tema/topo',  $this->data);
    }

public function alterarSenha() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect(site_url('mapos/login'));
        }
/* se obtienen las contraseñas del formulario */

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');

/* se encryptan las contraseñas del formulario */

        $this->load->library('encrypt');           
        $senha = $this->encrypt->sha1($senha);
        $oldSenha = $this->encrypt->sha1($oldSenha);

/* se envian las contraseñas encryptadas al modelo */

        $id= $this->session->userdata('id');
        $result = $this->mapos_model->alterarSenha($senha,$oldSenha,$id);
        if($result){
            $this->session->set_flashdata('success','Contraseña modificada con éxito!');
            redirect(site_url('mapos/minhaConta'));
        }
        else{
            $this->session->set_flashdata('error','Ocurrió un error al modificar la contraseña!');
            redirect(site_url('mapos/minhaConta'));   
        }
    }

    public function pesquisar() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $termo = $this->input->get('termo');
        $data['results'] = $this->mapos_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['aparatos'] = $data['results']['aparatos'];
        $this->data['view'] = 'mapos/pesquisa';
        $this->load->view('tema/topo',  $this->data);
    }

    public function login(){
        $this->load->view('mapos/login');  
    }
    public function sair(){
        $this->session->sess_destroy();
        redirect('mapos/login');
    }

    public function verificarLogin(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','valid_email|required|xss_clean|trim');
        $this->form_validation->set_rules('clave','Clave','required|xss_clean|trim');
        $ajax = $this->input->get('ajax');
        if ($this->form_validation->run() == false) {
            
            if($ajax == true){
                $json = array('result' => false);
                echo json_encode($json);
            }
            else{
                $this->session->set_flashdata('error','Los datos de acceso son incorrectos.');
                redirect($this->login);
            }
        } 
        else {

            $email = $this->input->post('email');
            $clave = $this->input->post('clave');

            $this->load->library('encrypt');   
            $clave = $this->encrypt->sha1($clave);

            $this->db->where('email',$email);
            $this->db->where('clave',$clave);
            $this->db->where('situacion',1);
            $this->db->limit(1);
            $usuario = $this->db->get('usuarios')->row();
            if(count($usuario) > 0){
                $dados = array('nombre' => $usuario->nombre, 'id' => $usuario->idUsuarios,'permissao' => $usuario->permissoes_id , 'logado' => TRUE);
                $this->session->set_userdata($dados);
                $this->session->set_flashdata('success','Bienvenido al Sistema'." ".$dados[nombre]);
                redirect(base_url().'index.php/clientes');

               /* if($ajax == true){
                    $json = array('result' => true);
                    echo json_encode($json);  
                    
                }
                else{
                    
                   redirect(base_url().'clientes');
                } */  
            }
            else{
                
               /* if($ajax == true){
                    $json = array('result' => false);
                    echo json_encode($json);
                }
                else{
                    $this->session->set_flashdata('error','Los datos de acceso son incorrectos.');
                    redirect($this->login);
                }*/
                $this->session->set_flashdata('error','Los datos de acceso son incorrectos, vuelva a ingresar sus credenciales');
                redirect(base_url().'/index.php/mapos/login');
            }
            
        }
        
    }


    public function backup(){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){
           $this->session->set_flashdata('error','No tiene permiso para efectuar back-up.');
           redirect(base_url());
        }

        
        
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup =& $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }


    public function emitente(){   

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','No tiene permiso para configurar una empresa.');
           redirect(base_url());
        }

        $data['menuConfiguracoes'] = 'Configuracoes';
        $data['dados'] = $this->mapos_model->getEmitente();
        $data['view'] = 'mapos/emitente';
        $this->load->view('tema/topo',$data);
        $this->load->view('tema/rodape');
    }

    function do_upload(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','No tiene permiso para configurar una empresa.');
           redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp|JPEG||PNG||JPG||pdf||BMP||PDF',
            'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $file_info = array($this->upload->data());
            return $file_info[0]['file_name'];
        }

    }


    public function cadastrarEmitente() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','No tiene permiso para configurar una empresa.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|xss_clean|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|xss_clean|trim');
        $this->form_validation->set_rules('ie','IE','required|xss_clean|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|xss_clean|trim');
        $this->form_validation->set_rules('numero','Número','required|xss_clean|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|xss_clean|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|xss_clean|trim');
        $this->form_validation->set_rules('uf','UF','required|xss_clean|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|xss_clean|trim');
        $this->form_validation->set_rules('email','E-mail','required|xss_clean|trim');


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Los campos obligatorios están vacíos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $image = $this->do_upload();
            $logo = base_url().'assets/uploads/'.$image;


            $retorno = $this->mapos_model->addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email, $logo);
            if($retorno){

                $this->session->set_flashdata('success','La información se ha introducido con éxito.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Se produjo un error al tratar de introducir la información.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }


    public function editarEmitente() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Usted no está autorizado a configurar una empresa.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|xss_clean|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|xss_clean|trim');
        $this->form_validation->set_rules('ie','IE','required|xss_clean|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|xss_clean|trim');
        $this->form_validation->set_rules('numero','Número','required|xss_clean|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|xss_clean|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|xss_clean|trim');
        $this->form_validation->set_rules('uf','UF','required|xss_clean|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|xss_clean|trim');
        $this->form_validation->set_rules('email','E-mail','required|xss_clean|trim');


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Los campos obligatorios están vacíos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $id = $this->input->post('id');


            $retorno = $this->mapos_model->editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email);
            if($retorno){

                $this->session->set_flashdata('success','La información se ha cambiado correctamente.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Se produjo un error al tratar de cambiar la información.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }


    public function editarLogo(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Usted no está autorizado a configurar una empresa.');
           redirect(base_url());
        }

        $id = $this->input->post('id');
        if($id == null || !is_numeric($id)){
           $this->session->set_flashdata('error','Se produjo un error al intentar cambiar el logomarca.');
           redirect(base_url().'index.php/mapos/emitente'); 
        }
        $this->load->helper('file');
        delete_files(FCPATH .'assets/uploads/');

        $image = $this->do_upload();
        $logo = base_url().'assets/uploads/'.$image;

        $retorno = $this->mapos_model->editLogo($id, $logo);
        if($retorno){

            $this->session->set_flashdata('success','La información se ha cambiado correctamente.');
            redirect(base_url().'index.php/mapos/emitente');
        }
        else{
            $this->session->set_flashdata('error','Se produjo un error al tratar de cambiar la información.');
            redirect(base_url().'index.php/mapos/emitente');
        }

    }

    
}
