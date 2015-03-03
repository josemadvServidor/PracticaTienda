<?php
class Practica_xml extends CI_Controller{

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
		$this->load->view('practica_menu_xml');
		$this->load->view('practica_pie');
		
	}
	
	/**
	 * Recoge la informacion de productos y categorias y la inserta en formato xml en un archivo
	 */
	public function exportarxml()
	{
		
		$problemas = false;
		
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
		
		
		
		if(!$xml->save(APPPATH.'../Assets/XML/datos.xml')){
			$problemas = true;
		}
		
		//
		
		$productos = $xml->createElement('productos');
		$productos = $xml->appendChild($productos);
		
		$productosT = $this->practica_modelo_productos->recuperaTodos();
		
		foreach ($productosT as $prod):
		
		
		$producto=$xml->createElement('producto');
		$producto = $productos->appendChild($producto);
		
		$id = $xml->createElement('id', (string)$prod['idProd']);
		$id = $producto->appendChild($id);
		
		$cod = $xml->createElement('cod',(string)$prod['codigo']);
		$cod = $producto->appendChild($cod);
		
		$nombre = $xml->createElement('nombre', $prod['nombre']);
		$nombre = $producto->appendChild($nombre);
		
		$precio = $xml->createElement('precio', $prod['precio_venta']);
		$precio = $producto->appendChild($precio);
		
		$descuento = $xml->createElement('descuento', $prod['descuento_apl']);
		$descuento = $producto->appendChild($descuento);
		
		$imagen = $xml->createElement('imagen', $prod['imagen']);
		$imagen = $producto->appendChild($imagen);
		
		$iva = $xml->createElement('iva', $prod['iva']);
		$iva = $producto->appendChild($iva);
		
		$descripcion = $xml->createElement('descripcion', $prod['descripcion']);
		$descripcion = $producto->appendChild($descripcion);
		
		$anuncio = $xml->createElement('anuncio', $prod['anuncio']);
		$anuncio = $producto->appendChild($anuncio);
		
		$stock = $xml->createElement('stock', $prod['stock_disp']);
		$stock = $producto->appendChild($stock);
		
		$destacado = $xml->createElement('destacado', $prod['destacado']);
		$destacado = $producto->appendChild($destacado);
		
		$fecha_ini = $xml->createElement('fechaI', $prod['fecha_ini']);
		$fecha_ini = $producto->appendChild($fecha_ini);
		
		$fecha_fin = $xml->createElement('fechaF', $prod['fecha_fin']);
		$fecha_fin = $producto->appendChild($fecha_fin);
		
		$oculto = $xml->createElement('oculto',(string)$prod['oculto_p']);
		$oculto = $producto->appendChild($oculto);
		
		$idC = $xml->createElement('idCat',(string)$prod['Categoria_idCat']);
		$idC = $producto->appendChild($idC);
		
		endforeach;
		$xml->formatOut=true;
		
		$strings_xml = $xml->saveXML();
		
		
		
		if(!$xml->save(APPPATH.'../Assets/XML/datos.xml')){
			$problemas = true;
		}
		
		if ($problemas == false){
			
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_exporta_exito');
			$this->load->view('practica_pie');
			
		}else{
			
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_exporta_fallida');
			$this->load->view('practica_pie');
			
		}
		
	}
	
	/**
	 * Importa un xml y lo envia al controlador de subida
	 */
	public function importarxml()
	{
		
		
		if ($this->form_validation->run()==false)
		{
			
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_formulario_subida');
			$this->load->view('practica_pie');
			
			
		}
		
	}
	
}