<?php

class Probar_xml extends CI_Controller{


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

		$xml=new DomDocument("1.0","UTF-8");

		$categorias = $xml->createElement('categorias');
		$categorias = $xml->appendChild($categorias); 
		
		$categoriasB = $this->practica_modelo_categorias->rec_categoriasT();

		foreach ($categoriasB as $cat):
		 
		$categoria=$xml->createElement('categoria');
		$categoria = $categorias->appendChild($categoria);
		
		$id = $xml->createElement('id', (string)$cat['idCat']);
		$id = $categoria->appendChild($id);

		$cod = $xml->createElement('cod',(string)$cat['cod_categ']);
		$cod = $categoria->appendChild($cod);
		
		$nombre = $xml->createElement('nombre', $cat['nombre_cat']);
		$nombre = $categoria->appendChild($nombre);
		
		$descripcion = $xml->createElement('descripcion', $cat['descr_cat']);
		$descripcion = $categoria->appendChild($descripcion);

		$anuncio = $xml->createElement('anuncio', $cat['anuncio_cat']);
		$anuncio = $categoria->appendChild($anuncio);
		
		$oculto = $xml->createElement('oculto',(string)$cat['oculto']);
		$oculto = $categoria->appendChild($oculto);
		
		
		endforeach;
		
		$xml->formatOut=true;
		
		$strings_xml = $xml->saveXML(); 

        
		
		if($xml->save(APPPATH.'/PDF/xml.xml')){
			echo "Termino de crear el xml.";
		}else{
			echo "No pudimos guardar el xml.";
		}
		
	}



}