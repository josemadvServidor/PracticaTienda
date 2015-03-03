<?php

class tablas extends CI_Controller{

	public function index(){

		$this->load->view('tablas');

	}
	
	public function tabla($num = null)
	{
		if (!$_POST){
		if ($num == null)
		{
			$this->load->view('tablas_error');
		}else{
			
			$array = array('numero' => $num);
			
			$this->load->view('tablas_correcto', $array);
		}
		}else {
			if ($_REQUEST['numero'] == null)
			{
				$this->load->view('tablas_error');
			}else{
					
				$array = array('numero' => $_REQUEST['numero']);
					
				$this->load->view('tablas_correcto', $array);
			}
		}
	}

}