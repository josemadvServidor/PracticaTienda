<?php
class personas extends CI_Controller{

	public function index(){
		
		$this->load->model('personaM');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
        $this->load->view('Menupersonas');
				

	}
	
	public function aniadir()
	{
		$this->load->model('personaM');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('dni', 'DNI', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required|min_length[2]');
		$this->form_validation->set_rules('peso', 'Peso', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		
	

		if ($this->form_validation->run()==false)
		{
			 echo validation_errors(); 
			$this->load->view('formpersonas');
			
			
		}else{
			$dni=$this->input->post('dni');
			$nombre=$this->input->post('nombre');
			$apellidos=$this->input->post('apellidos');
			$peso=$this->input->post('peso');
			$email=$this->input->post('email');
			$fecha=$this->input->post('fecha');
			
			list($dia, $mes, $anio) = split('[/.-]', $fecha);
			$fecha = $anio ."-" . $mes . "-" . $dia;
			
			if ($this->personaM->adicion($dni, $nombre, $apellidos, $peso, $email, $fecha))
					{
						$this->load->view('altaCorrecta');
					}else{
						
						$this->load->view('altaIncorrecta');
					}
			
		}
		
	}
	
	public function borrar()
	{
		$this->load->model('personaM');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('dni', 'DNI', 'required|callback_comprueba_dni');
		
		if ($this->form_validation->run()==false)
		{
			echo validation_errors();
			$this->load->view('formbpersonas');
				
				
		}else{
			
			$dni=$this->input->post('dni');
			
			if ($this->personaM->borrar($dni))
			{
				$this->load->view('altaCorrecta');
			}else{
			
				$this->load->view('altaIncorrecta');
			}
				
			
		}
		
	
	}
	
	public function comprueba_dni($dni)
	{
		
	
		return $this->personaM->comprueba_dni($dni);
	
	
	}
	
	public function editar()
	{
		$this->load->model('personaM');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('dniant', 'DNI antiguo', 'required');
		$this->form_validation->set_rules('dni', 'DNI', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[3]');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required|min_length[2]');
		$this->form_validation->set_rules('peso', 'Peso', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
		
		if ($this->form_validation->run()==false)
		{
			echo validation_errors();
			$this->load->view('formEdpersonas');
				
		}else{
			$dniant=$this->input->post('dniant');
			$dni=$this->input->post('dni');
			$nombre=$this->input->post('nombre');
			$apellidos=$this->input->post('apellidos');
			$peso=$this->input->post('peso');
			$email=$this->input->post('email');
			$fecha=$this->input->post('fecha');
				
			list($dia, $mes, $anio) = split('[/.-]', $fecha);
			$fecha = $anio ."-" . $mes . "-" . $dia;
				
			if ($this->personaM->modificar($dniant, $dni, $nombre, $apellidos, $peso, $email, $fecha))
			{
				$this->load->view('altaCorrecta');
			}else{
		
				$this->load->view('altaIncorrecta');
			}
				
		}
	
	}

	
}