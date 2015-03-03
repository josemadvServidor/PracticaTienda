<?php
class Practica_principal extends CI_Controller{
	
	/**
	 * almacenara las categorias
	 * @var unknown
	 */
	public $categorias;
	
	/**
	 * Almacenara el carrito de la compra
	 * @var unknown
	 */
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
	
	/**
	 * Muestra la lista de destacados
	 * @param number $pag registro por el que empieza a mostrar
	 */
	public function index($pag=0){
		
		
		//Recogemos la informacion del numero de destacados tortal
		$destacanT = array ("array" => $this->practica_modelo_productos->rec_destacados_total());
		
		//Incluimos el archivo de configuracion del paginador de destacados
		require_once realpath(__DIR__.'/../config/paginardest.php');
		

		//Recogemos la informacion de los destacados a mostrar
		$destacan = array ("array" => $this->practica_modelo_productos->rec_destacados($pag, $config['per_page']));

		

		$this->pagination->initialize($config);
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_p', $destacan);
		$this->load->view('practica_pie');
		
	}
	
	/**
	 * Inicia la sesion
	 */
	public function inicioSesion()
	{
		//Se establecen las normas para los campos del formulario de validacion
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('clave', 'Clave', 'required');
		
		//Comprobamos si los campos a buscar cumplen las normas para los campos
		if ($this->form_validation->run()==false)
		{
		//Si no es correcto o si e sla primera vez mostramos el menu de inicio
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_inicio');
		$this->load->view('practica_pie');
		
		}else{
			
			//Si es correcto comprobamos si la combinacion usuario-clave es valida
			if (count($datosUs = $this->practica_modelo_usuarios->valida_usuario($this->input->post('nombre'), $this->input->post('clave'))) > 0)
			{
				
				//Si es correcto guardamos la informacion del usuario en variables de sesion
				$this->session->set_userdata("nombre", $this->input->post('nombre'));
				$this->session->set_userdata("dentro", true);
				$this->session->set_userdata("id", $datosUs[0]['idUsuario']);
				$this->session->set_userdata("nombreR", $datosUs[0]['nombre_real_usu']);
				$this->session->set_userdata("apellidos", $datosUs[0]['apellidos_usu']);
				$this->session->set_userdata("direccion", $datosUs[0]['direccion_usu']);
				$this->session->set_userdata("cp", $datosUs[0]['cp_usu']);
				$this->session->set_userdata("prov", $datosUs[0]['cod_prov']);
				
				$this->load->view('practica_encabezado');
				$this->load->view('practica_cabecera');
				$this->load->view('practica_menu_cat', $this->categorias);
				$this->load->view('practica_exito_validacion');
				$this->load->view('practica_pie');
				
			}else{
			
			//Si no escorrecto enviamos a la vista los datos que enviamos anteriormente
			$datos = array ("nombre" => $this->input->post('nombre'),
			                "clave" => $this->input->post('clave'));
			
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_inicio_fallido', $datos);
		$this->load->view('practica_pie');
				
			}
			
			
		}
		
		
	}
	
	/**
	 * Muestra una lista de los productos de una categoria
	 * @param unknown $idCat Identificador d ela categoria
	 * @param number $pag Registro por el que empezar a mostrar
	 */
	public function muestraCat($idCat, $pag=0)
	{
		
		$productosCategoriaT = array ("array" => $this->practica_modelo_productos->rec_categoria_total($idCat));
		
		//Incluimos el archivo de configuracion del paginador de categorias
		require_once realpath(__DIR__.'/../config/paginarcat.php');
		

        //Recogemos todos los productos de una categoria
		$productosCategoria = array ("array" => $this->practica_modelo_productos->rec_categoria($idCat, $pag, $config['per_page']),
		                              "carro" => $this->carro->get_content());
		
		
		$this->pagination->initialize($config);
		
        
		
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_p', $productosCategoria);
		$this->load->view('practica_pie');
		
	}
	
	/**
	 * Muestra el carro de la compra y sus productos
	 */
	public function ir_carro()
	{
        //Recogemos la informacion necesaria para la vista
		$productosCarro = array ("array" => $this->carro->get_content(),
		                         "pTotal" => $precioT = array("0"=>$this->carro->precio_total()));
		
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_menu_carro', $productosCarro);
		$this->load->view('practica_pie');
		
	}
    
	/**
	 * Muestra la informacion de un determinado producto
	 * @param unknown $id Identificador del producto
	 */
	public function info_producto($id)
	{
	    //Recogemos la informacion del producto
		$infoP = array ("array" => $this->practica_modelo_productos->recogePorId($id),
		                "carro" => $this->carro->get_content());
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_info_p', $infoP);
		$this->load->view('practica_pie');
	}
	
	/**
	 * Aniade un producto al carrito
	 * @param unknown $id
	 */
	public function aniade_producto($id)
	{
		
        //Nos aseguramos de que se eligio al menos uno en cantidad
     	if ($this->input->post('cantidad') == 0)
     	{
     		
     		$this->load->view('practica_encabezado');
		    $this->load->view('practica_cabecera');
		    $this->load->view('practica_menu_cat', $this->categorias);
     		$this->load->view('practica_al_menos_uno', $infoP);
     		$this->load->view('practica_pie');
     		
     		
     	}else{
     		
     	//Recogemos la informacion del prodducto que se almacenara
     	$producto = $this->practica_modelo_productos->recogePorId($id);
     	$infoP = array ("array" => $producto);
     	
     	//Recogemos la catidad
     	$cantidad = $this->input->post('cantidad');
     	
     	//Calculamos el precio tras descuentos e iva
     	$precio = $producto[0]['precio_venta'] - ($producto[0]['precio_venta'] / 100 * $producto[0]['descuento_apl']);
        $precio = $precio + ($producto[0]['precio_venta'] / 100 * $producto[0]['iva']);
     	
        //Creamos el array del producto
     	$articulo = array ( "id" => $producto[0]['idProd'],
     		            	"cantidad" => $this->input->post('cantidad'),
     		             	"precio" => round($precio, 2),
                            "nombre" => $producto[0]['nombre']
     	                   ); 
     	
     	//Se aniade el producto
     	$this->carro->add($articulo);
     	
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_aniadir_prod', $infoP);
		$this->load->view('practica_pie');
		
     	}
     
		
	}
	
	/**
	 * Vacia el carrito
	 */
	public function vacia_carro()
	{
		$this->carro->destroy();
		
		$productosCarro = array ("array" => $this->carro->get_content(),
		                         "pTotal" => $precioT = array("0"=>$this->carro->precio_total()));
			
			
			$this->load->view('practica_encabezado');
		    $this->load->view('practica_cabecera');
	     	$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_menu_carro', $productosCarro);
			$this->load->view('practica_pie');
			

	}
  
	/**
	 * Elimina un producto dle carrito
	 * @param unknown $id Identificador del producto a eliminar
	 */
public function saca_producto($id)
{ 
	
	$this->carro->remove_producto($id);
	
	$productosCarro = array ("array" => $this->carro->get_content(),
		                     "pTotal" => $precioT = array("0"=>$this->carro->precio_total()));
	
	$this->load->view('practica_encabezado');
	$this->load->view('practica_cabecera');
	$this->load->view('practica_menu_cat', $this->categorias);
	$this->load->view('practica_menu_carro', $productosCarro);
	$this->load->view('practica_pie');
}

/**
 * Muestra un resumen antes de la confirmacion final de la compra
 */
public function resumen_productos()
{
	//Nos aseguramos de que ahi un usuario conectado
	if ($this->session->userdata('dentro') == true){
	
	//Recogemos los productos del carro
	$productos = $this->carro->get_content();
	
	//Aqui se almacenara el precio el pedido
    $precioT = 0;
	
	$this->load->view('practica_encabezado');
	$this->load->view('practica_cabecera');
	$this->load->view('practica_menu_cat', $this->categorias);
	$this->load->view('practica_encabezado_resumen');
	// Aqui mostramos la inforacion de cada producto llamando a l amisma vista
	foreach ($productos as $producto):
	
	//Recogemos la informacion del producto
	$infoP = array ("informacion" =>  $this->practica_modelo_productos->recogePorId($producto['id']),
	                 "infoP" => $producto);
	
	$this->load->view('practica_resumen', $infoP);
	
	//$precio = $infoP["informacion"][0]['precio_venta'];
	//$descuento =$infoP["informacion"][0]['descuento_apl'];
	//$iva = $infoP["informacion"][0]['iva'];
	
	$precioT += $producto['precio'] * $producto['cantidad'];
	endforeach;	
	
	//Informacion que s emostrara en el pie de pagina del resumen
	$infoPie = array ("precio" =>  round($precioT,2),
	                "totalProductos" => $this->carro->articulos_total());
	
	$this->load->view('practica_pie_resumen',$infoPie);
	$this->load->view('practica_pie');
	
	}else{
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_no_sesion');
		$this->load->view('practica_pie');
		
	}
	
}

/**
 * Consulta los pedidos realizados por el usuario actual
 */
public function consulta_pedidos()
{
	//Nos aseguramos de que haya un usuario conectado
	if ($this->session->userdata('dentro') == true)
	{
		//Almacenamos los pedidos del usuario conectado
		$pedidos = array("pedidos" => $this->practica_modelo_pedidos->rec_pedidos($this->session->userdata('id')));
		
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		
		//Comprobamos cuantos pedidos tiene y si tiene alguno
		if (count($pedidos['pedidos']) > 0)
		{
			
		$this->load->view('practica_pedidos', $pedidos);
		
		}else{
			
			$this->load->view('practica_no_pedidos');
			
		}
		$this->load->view('practica_pie');
		
		
	}else{
		
	    $this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_no_sesion');
		$this->load->view('practica_pie');
		
	}
	
}


/**
 * Muestra el resumen de un pedido realizado anteriormente
 * @param unknown $id
 */
public function resumen_pedido($id)
{
	//Nos aseguramos de que haya un usuario conectado
	if ($this->session->userdata('dentro') == true)
	{
	
	//Recogemos las lineas y los datos del pedido
	$lineasP = $this->practica_modelo_pedidos->rec_lineas_pedido($id);
	$datosP = $this->practica_modelo_pedidos->rec_pedido($id);
	

	$this->load->view('practica_encabezado');
	$this->load->view('practica_cabecera');
	$this->load->view('practica_menu_cat', $this->categorias);
	$this->load->view('practica_encabezado_resumen_lineas');
	
	//Variable en la que despues se almacenara el precio total
	$precioT = 0;
	
	//En cada linea del pedido llamamso a una vista que genera una interfaz para mostrar sus datos
	foreach ($lineasP as $producto):
	
	//Recogemos la informacion del producto actual de la base de datos para obtener las partes de 
	//la informacion que no estan en la linea
	$infoP = array ("informacion" =>  $this->practica_modelo_productos->recogePorId($producto['Producto_idProd']),
			"infoP" => $producto);
	
	$this->load->view('practica_resumen_lineas', $infoP);
	
	$precioT = $datosP[0]['precio_total'];
	
	endforeach;
	$infoPie = array ("precio" =>  $precioT,
			"totalProductos" => count($lineasP));
	
	$this->load->view('practica_pie_resumen_2',$infoPie);
	$this->load->view('practica_pie');
	
		
	}else{
		
			$this->load->view('practica_encabezado');
		    $this->load->view('practica_cabecera');
		    $this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_no_sesion');
			$this->load->view('practica_pie');
		
		}
}

/**
 * Borra un pedido y sus lineas
 * @param unknown $id Identificador del pedido a borrar
 */
public function borra_pedido($id)
{
	//Nos aseguramos de ahi una sesion iniciada
	if ($this->session->userdata('dentro') == true)
	{
		//Recogemos las lineas del pedido
		$lineas = $this->practica_modelo_pedidos->rec_lineas_pedido($id);
		
		
		foreach ($lineas as $linea):
		//En cada linea reponemos el stock del producto
		$this->practica_modelo_productos->recupera_stock($linea['cantidad_pro'], $linea['Producto_idProd']);
		
		endforeach;
		
		//Borramos el pedido y las lineas
		$this->practica_modelo_pedidos->borra_pedido($id);
		
		
		$pedidos = array("pedidos" => $this->practica_modelo_pedidos->rec_pedidos($this->session->userdata('id')));
	
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_pedidos', $pedidos);
		$this->load->view('practica_pie');
	
	
	}else{
	
	    $this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_no_sesion');
		$this->load->view('practica_pie');
	
	}
	
	
	
}

/**
 * Termina de confirmar una compra
 */
public function confirma_compra()
{
	//Array para almacenar los productos en caso de que no halla stock
	$productosNoStock = [];
	$suficienteStock = true;

	//Nos aseguramos de que se a iniciado sesion
	if ($this->session->userdata('dentro') == true){
		
		//Recogemos los productos del carro
		$productos = $this->carro->get_content();
		
		foreach ($productos as $producto):
		
		//Recogemos la informacion del producto d ela base de datos
		$informacion =  $this->practica_modelo_productos->recogePorId($producto['id']);
		
		//Comprobamos si ahi stock suficiente
		if ($producto['cantidad'] > $informacion[0]['stock_disp'])
		{
			$productosNoStock[]= $producto;
			$suficienteStock = false;
			
		}
		
		
		endforeach;
		$productosSinStock =array("productosNoStock" => $productosNoStock);
		
		//Comprobamos si todos los productos tienen suficiente stock
		if($suficienteStock == true){
			
		//Recogemos la informacion del usuario
		$infoUsuario = $this->practica_modelo_usuarios->informacion_usu($this->session->userdata('id'));
		
        //Iniciamos el texto del email
		$mensaje = "<h1>Resumen Compra</h1><br><table border=\"1\"><tr><th>Codigo</th><th>Nombre</th><th>Precio</th>
				<th>Descuento</th><th>IVA</th><th>Cantidad</th><th>Precio Final</th><th>Descripcion</th></tr> ";
	
	
    $precioT = 0;
	
    $this->load->view('practica_encabezado');
    $this->load->view('practica_cabecera');
	$this->load->view('practica_menu_cat', $this->categorias);
	$this->load->view('practica_compra_confirmada');
	$this->load->view('practica_pie');
	
	foreach ($productos as $producto):
	
	
	$infoP = array ("informacion" =>  $this->practica_modelo_productos->recogePorId($producto['id']),
	                 "infoP" => $producto);
	
	
	
	
	$precio = $infoP["informacion"][0]['precio_venta'];

	$descontar = ($infoP["informacion"][0]['precio_venta'] / 100) * $infoP["informacion"][0]['descuento_apl'];
	
	$iva =  ($infoP["informacion"][0]['precio_venta'] / 100) * $infoP["informacion"][0]['iva'];
	
	$precioFinal = $infoP["informacion"][0]['precio_venta'] -  $descontar + $iva;
	$precioT += $precioFinal * $producto['cantidad'];
	
	//En cada producto ampliamos el mensaje a enviar con su informacion
$mensaje = $mensaje . "<tr><td>" .  $infoP["informacion"][0]['codigo'] . "</td><td>" . $infoP["informacion"][0]['nombre'] . "</td><td>" . $infoP["informacion"][0]['precio_venta']
. "</td><td>" . $infoP["informacion"][0]['descuento_apl'] . "</td><td>" . $infoP["informacion"][0]['iva'] . "</td><td>" . $infoP["infoP"]['cantidad'] . "</td><td>" . $precioFinal
."</td><td>" . $infoP["informacion"][0]['descripcion'] . "</td></tr>";
	
    //Disminuimos el stock para los productos
    $this->practica_modelo_productos->disminuye_stock($producto['id'], $producto['cantidad']);

	endforeach;	
	
	$precioT= round($precioT,2);
	$infoPie = array ("precio" => $precioT,
	                  "totalProductos" => $this->carro->articulos_total());
	
	//Completamos el mensaje
	$mensaje = $mensaje .  "</table><br><table border=\"1\"><tr><td>Precio Total</td><td>" . $infoPie['precio'] . 
	" E</td></tr>" . "<tr><td>Total productos</td><td>" . $infoPie['totalProductos'] . "</td></tr></table>";
 
	//Configuramos los datos del email
	$this->email->from('aula4@iessansebastian.com', 'Administrador');
	$this->email->to($infoUsuario[0]['email_usu']);
	$this->email->subject('Resumen compra');
	$this->email->message($mensaje);
	

	$idPedido;
	
	//Creamos el pedido
	if ($this->practica_modelo_pedidos->nuevo_pedido($infoPie['totalProductos'],$infoPie['precio'] ,"p",
	    $this->session->userdata('id'), $this->session->userdata('nombreR'), 
	    $this->session->userdata('apellidos'),$this->session->userdata('direccion'),
	    $this->session->userdata('cp'), $this->session->userdata('prov')))
	{
		
		$informacion = $this->practica_modelo_pedidos->id_ultimo();
		
		foreach ($productos as $producto):
		
		
		foreach ($informacion[0] as $inf):
		$idPedido =  $inf;
		endforeach;
		
		//S ecrean las lineas del pedido
		$this->practica_modelo_pedidos->crea_linea_pedido($producto['cantidad'], 
				                                          $producto['precio'],
				                                          $idPedido,
				                                          $producto['id']);
		
		endforeach;
		
		
	}else{
		
		echo "No se pudo crear el pedido";
	}

	//Generamos el PDF de la factura
	$fileName=APPPATH.'/PDF/factura.pdf';
	$this->generaPdf($idPedido, $fileName);
	
	//Ligamos el PDF al email
	$this->email->attach($fileName);
	
	$this->email->send();

	//Vaciamos el carro
	$this->carro->destroy();
		}else{
			
			$this->load->view('practica_encabezado');
		    $this->load->view('practica_cabecera');
		    $this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_no_stock',$productosSinStock);
			$this->load->view('practica_pie');
			
		}
	
	}else{
		
	    $this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_no_sesion');
		$this->load->view('practica_pie');
		
	}
	
}

/**
 * Genera un pdf con el albaran/factura para un pedido
 * @param unknown $idP
 * @param string $fileName
 */
public function generaPdf($idP, $fileName='')
{
	$this->load->library('PDF', array());
	$pdf = new FPDF();
	
	$pedido = $this->practica_modelo_pedidos->rec_pedido($idP);
	$lineasPedido = $this->practica_modelo_pedidos->rec_lineas_pedido($idP);
	
	$pdf->AddPage();
	$pdf->SetFillColor(120,255,0);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(60,10,"Resumen Pedido Nº" . $pedido[0]['id_pedido'],0,1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(100,10,"Informacion de Usuario",1,1,'',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(30,10,"Codigo cliente: " . $pedido[0]['Usuarios_idUsuario'],1);
	$pdf->SetX(40);
	$pdf->Cell(70,10,"Nombre completo cliente: " . $pedido[0]['nombre_usu']. " " . $pedido[0]['apellidos_usu'],1) ;
	$pdf->SetXY(112,20);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(90,10,"Informacion de facturación",1,1,'',true);
	$pdf->SetXY(112,30);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(60,10,"Dirección: " . $pedido[0]['direccion_ped'],1);
	$pdf->SetXY(172,30);
	$pdf->Cell(30,10,"CP: " . $pedido[0]['cp_usu'],1);
	$pdf->SetXY(10,50);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(132,10,"Productos",0,1,'');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(70,10,"Nombre",1,0,'',true);
	$pdf->Cell(20,10,"Cantidad",1,0,'C',true);
	$pdf->Cell(22,10,"Precio unidad",1,0,'C',true);
	$pdf->Cell(20,10,"Precio Total",1,1,'C',true);
	$pdf->SetFont('Arial','',8);
  foreach ($lineasPedido as $linea):
  
  $InfoP = $this->practica_modelo_productos->recogePorId($linea['Producto_idProd']);

	$pdf->Cell(70,10,$InfoP[0]['nombre'],1,0);
	$pdf->Cell(20,10,$linea['cantidad_pro'],1,0,'C');
	$pdf->Cell(22,10,$linea['precio_unidad'] . " E",1,0,'C');
	$pdf->Cell(20,10,$linea['precio_unidad'] * $linea['cantidad_pro']  . " E",1,1,'C');
  
	endforeach;
	
	$pdf->Cell(20,10,"",0,1);
	
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70,10,"Total Productos", 1,0,'',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,10,$pedido[0]['num_productos'], 1, 0, 'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(22,10,"Precio Total", 1, 0,'',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,10,$pedido[0]['precio_total']. " E", 1, 1);
	
	if ($fileName == ''){
	
		$pdf->Output();
	
	}else{
		
	$pdf->Output($fileName, 'F');
		
	}
	
}

/*
 public function pdf()
 {
$this->load->library('PDF', array());

//$this->pdf->output();
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

for ($i = 0; $i <= 1000; $i++)
{
$pdf->Cell(10,10,$i,0,1);
}

$pdf->Output();
}
*/

}