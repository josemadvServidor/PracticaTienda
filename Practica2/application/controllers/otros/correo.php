<?php
class correo extends CI_Controller{
	
	public function index(){
		

		$this->load->library('email');
		
		//$infoUsuario = $this->Practica_modelo_usuarios->informacion_usu($this->session->userdata('nombre'));
		
		

		//
		
		
		//$this->email->initialize();
		
		$this->email->from('aula4@iessansebastian.com', 'Administrador');
		$this->email->to('josemanueldiazvidal2@gmail.com');
		$this->email->subject('Resumen compra');		
		
		$this->email->message("<p>Prueba correo</p>");
		
		if ($this->email->send())
		{
			
			echo "<pre>\n\nENVIADO CON EXITO\n</pre>";
		}
		else
		{
			echo "</pre>\n\n**** NO SE HA ENVIADO ****</pre>\n";
		}
		
		
	}
	
	
}