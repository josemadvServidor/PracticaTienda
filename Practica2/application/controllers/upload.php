<?php
class Upload extends CI_Controller {
	
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
	
	function index()
	{	
		$this->load->view('practica_formulario_subida', array('error' => ' ' ));
	}
	
	/**
	 * Sube un archivo y añade a las tablas d ela base de datos los productos y categorias de este
	 */
	function do_upload()
	{
		$config['upload_path'] = realpath(__DIR__.'/../uploads/');
		$config['allowed_types'] = 'xml';

		
		$this->load->library('upload', $config);
		
	
		if ( ! $this->upload->do_upload('archivo'))
		{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_formulario_subida', $error);
			$this->load->view('practica_pie');
		}	
		else
		{
			$data = $this->upload->data();
			
			
			$fichero = new SimpleXMLElement($data['full_path'], null, true);
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			
			$nuevasCat = 0;
			$nuevosProd = 0;
			
			foreach($fichero->categoria as $categoria) :
				
			
				if(!$this->practica_modelo_categorias->crea_categoria($categoria->id, $categoria->cod
			                                         ,$categoria->nombre,$categoria->descripcion
			                                         ,$categoria->anuncio, $categoria->oculto))
				{

					
					
					
					
				}else{
					
					$nuevasCat++;
					
					
				}
				
			endforeach;
			
			foreach($fichero->producto as $producto) :
			
			
			if(!$this->practica_modelo_productos->crea_producto($producto->cod,
					$producto->nombre,$producto->precio,$producto->descuento,
					$producto->imagen,$producto->iva,$producto->descripcion,
					$producto->anuncio,$producto->stock,$producto->destacado,
					$producto->fechaI, $producto->fechaF,$producto->oculto, $producto->categoriaId))
			{
			
					
					
					
					
			}else{
					
				$nuevosProd++;
					
					
			}
			
			endforeach;
			
			if ($nuevasCat > 0){
				
				echo "<p>Se han creado " . $nuevasCat . " nuevas categorias</p>";
				
			}else{
				
				echo "<p>No se han creado nuevas categorias</p>";
				
			}
			
			if ($nuevosProd > 0){
			
				echo "<p>Se han creado " . $nuevosProd . " nuevos productos</p>";
			
			}else{
			
				echo "<p>No se han creado nuevos productos</p>";
			
			}
			
			$this->load->view('practica_pie');
			
		}
	}	
	
	
}
?>