<?php
//require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Practica_servicio extends JSON_WebServer_Controller {



	public function __construct(){
	
        parent::__construct();
	
		$this->load->model('practica_modelo_categorias');
		$this->load->model('practica_modelo_productos');
		$this->load->model('practica_modelo_pedidos');
		$this->load->model('practica_modelo_usuarios');
		$this->load->model('practica_modelo_provincias');


		// Activamos o no depuración
		//$this->Debug(self::DEBUG);
		
		// Registramos funciones disponibles
		$this->RegisterFunction('Total()', 'Devuelve la suma de los dos números');
		$this->RegisterFunction('Lista(inicio, numeroP)', 'Devuelve productos desde \'inicio\' hasta \'offset\'');
		
	}
	
	
	protected function Total()
	{
		return count($this->practica_modelo_productos->rec_destacados_total());
	}
	

	protected function Lista($offset, $limit)
	{
		$proDest = $this->practica_modelo_productos->rec_destacados($offset, $limit);
		
		$devolver= [];
		
		foreach ($proDest as $producto)
		{
			$devolver[] = array(
					'nombre'=>$producto['nombre'],
					'descripcion'=>$producto['descripcion'],
					'precio'=>$producto['precio_venta'],
					'img'=>$producto['imagen'],
					'url'=>site_url('practica_principal/info_producto/' . $producto['idProd'])
			                    );
			
		}
		
		return $devolver;
		
		/*
		'nombre'=>texto,
		'descripcion'=>text,
		'precio'=>precio del producto,
		'img'=>url donde está la imagen,
		'url'=>url en la que se puede comprar el producto en vuestra aplicacion
		*/
		
	}
	
}
