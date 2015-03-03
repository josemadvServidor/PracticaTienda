<?php
class Practica_excell extends CI_Controller{

	public $categorias;
	public $carro;

	public function __construct(){
	
        parent::__construct();
	
		$this->load->model('practica_modelo_categorias');
		$this->load->model('practica_modelo_productos');
		$this->load->model('practica_modelo_pedidos');
		$this->load->model('practica_modelo_usuarios');
		$this->load->model('practica_modelo_provincias');
	
		$this->load->library('Carrito');
		$this->carro = new Carrito();
		$this->categorias = array ("array" => $this->practica_modelo_categorias->rec_categoria());
	}
	
	
	
	public function index(){
	
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_excell');
		$this->load->view('practica_pie');
		
	}
	

	
	public function importarexcel()
	{
		
		if ($this->form_validation->run()==false)
		{
				
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_formulario_subida_ex');
			$this->load->view('practica_pie');
				
				
		}
		
	}
	
}
