<?php
class calendario extends CI_Controller{
	
	public function index(){
		
		$this->load->library('calendar');
	     
	    echo "Usar generate() <br>" . $this->calendar->generate();
	    
	}

}