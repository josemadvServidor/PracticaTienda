<?php
class dni extends CI_Controller{
	
	public function index(){
		
		$this->load->helper('dni');
		
		if (!$_POST){
			
			$this->load->view('formdni');
		
		}else{
		
		$nif = dni_DNIConLetra($_REQUEST['dni']);
		
		echo dni_DNIConLetra(76453321);
		
		echo dni_DNIConLetra(10937683);
		
		$this->load->view('dniV', $array = array("dni" => $nif));
		
		}
	}

}