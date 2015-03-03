<?php
class provincias extends CI_Controller{

	public function index(){

		$this->load->view('provincias');
		$this->load->model('provinciasM');
	}
	
	function orden($or)
	{
		$this->load->model('provinciasM');
		if ($or == 1)
		{
			$array = array ("array" => $this->provinciasM->consulta());

			$this->load->view('listar', $array);
			
			
		}
		
		if ($or == 2)
		{
			if (!$_POST)
			{
				$this->load->view('formadic');
			
			}else{
				
			$a = $this->provinciasM->adicion($_REQUEST['cod'],$_REQUEST['nombre'],$_REQUEST['comunidad']);

			$array = array("resultado" => $a);

			$this->load->view('adicion', $array);
				
			}
				
		}
		
		if ($or == 3)
		{
			if (!$_POST)
			{
				$this->load->view('formdel');
					
			}else{
		
				$a = $this->provinciasM->borrar($_REQUEST['cod']);
		
				$array = array("resultado" => $a);
		
				$this->load->view('borrado', $array);
		
			}
		
		}
		
		if ($or == 4)
		{
			if (!$_POST)
			{
				$this->load->view('formup');
					
			}else{
		
				$a = $this->provinciasM->modificar($_REQUEST['cod'], $_REQUEST['nombre']);
		
				$array = array("resultado" => $a);
		
				$this->load->view('actualiza', $array);
		
			}
		
		}
	}


}