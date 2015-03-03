<?php
class Hola_mundo extends CI_Controller{
	
	public function index(){
		
		$this->load->view('hola');
		
	}
	
	public function menu(){
	
		$this->load->view('menu');
	
	}
	
	public function Adios_mundo(){
	
		$this->load->view('Adios_mundo');
	
	}
}