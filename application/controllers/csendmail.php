<?php
class Csendmail extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function sendMailGmail()
	{
		//cargamos la libreria email de ci
		$this->load->library("email");

		//Configuracion para yahoo
		// $configYahoo = array(
		// 	'protocol' => 'smtp',
		// 	'smtp_host' => 'smtp.mail.yahoo.com',
		// 	'smtp_port' => 587,
		// 	'smtp_crypto' => 'tls',
		// 	'smtp_user' => 'emaildeyahoo',
		// 	'smtp_pass' => 'password',
		// 	'mailtype' => 'html',
		// 	'charset' => 'utf-8',
		// 	'newline' => "\r\n"
		// ); 


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
		
	}

}