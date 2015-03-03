<?php
Class Practica_modelo_productos extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Recoge todos los productos que àpareceran en la lista de destacados
	 */
	function rec_destacados_total()
	{	
		$pDest = $this->db->query(" select * from producto where 
	destacado = TRUE and 
    oculto_p = FALSE and 
    stock_disp > 0 and
    (
        fecha_ini is null and fecha_fin is null
        or
        fecha_ini is null and fecha_fin >= now()
        or 
        fecha_fin is null and fecha_ini <= now()
        or
        fecha_ini<=now() and fecha_fin>=now()
    )");
		
		return $pDest->result_array();
	}
	
	function rec_destacados($desde, $numReg)
	{
		//$ahora = date('Y-m-d H:i:s');
		
		$pDest = $this->db->query("select * from producto where 
	destacado = TRUE and 
    oculto_p = FALSE and 
    stock_disp > 0 and
    (
        fecha_ini is null and fecha_fin is null
        or
        fecha_ini is null and fecha_fin >= now()
        or 
        fecha_fin is null and fecha_ini <= now()
        or
        fecha_ini<=now() and fecha_fin>=now()
    ) Limit $desde, $numReg");
		
		
		return $pDest->result_array();
	}
	
	/**
	 * Recoge todos los productos de una determinada categoria que cumplan con los requisitos para aparecer
	 * @param unknown $categoria Identificador de la categoria 
	 * @param unknown $desde Numero del registro por el que empezar a cogerlos
	 * @param unknown $numR Cantidad de registros a devolver
	 */
	function rec_categoria($categoria, $desde, $numR)
	{
		$pCat = $this->db->query("select * from producto where Categoria_idCat = $categoria 
				                                         and oculto_p = FALSE
				                                         and stock_disp > 0 Limit $desde, $numR");
	
		return $pCat->result_array();
	}
	
	/**
	 * Devuelve todos los productos de una catgoria sin  tener en cuenta la limitacion en el numero de registros
	 * y permite saber la cantidad de productos que cumplen los requisitos
	 * @param unknown $categoria Identificador de la categoria 
	 */
	function rec_categoria_total($categoria)
	{
		$pCat = $this->db->query("select * from producto where Categoria_idCat = $categoria
				and oculto_p = FALSE
				and stock_disp > 0");
	
				return $pCat->result_array();
	}
	
	/**
	 * Disminuye el stock de un determinado producto
	 * @param unknown $id Identificador del producto
	 * @param unknown $cant Cantidad a reducir
	 * @return unknown
	 */
	function disminuye_stock($id, $cant)
	{
		$dis_stock = $this->db->query("update producto set stock_disp = stock_disp - $cant where idProd = $id");
	
		return $dis_stock;
	}
	
	/**
	 * Recoge la informacion del producto con la id que se le pase como parametro
	 * @param unknown $id
	 */
	function recogePorId($id)
	{
		$prod = $this->db->query("select * from producto where idProd = $id");
	
		return $prod->result_array();
	}
	
	function recupera_stock($cantidad, $id)
	{
		
		$rec_stock = $this->db->query("update producto set stock_disp = stock_disp + $cantidad where idProd = $id");
		
		return $rec_stock;
	}
	
	function recuperaTodos()
	{
		$prod = $this->db->query("select * from producto");
		
		return $prod->result_array();
		
	}


	function crea_producto($codigo, $nombre, $precio_venta, $descuento_apl, $imagen,
                           $iva, $descripcion, $anuncio, $stock_disp, $destacados,
                           $fecha_ini, $fecha_fin, $oculto_p, $Categoria_idCat)
	{
		
		$id = count($this->recuperaTodos());
		
		
		return $prodNuevo = $this->db->query("insert into producto
				values ($id, '$codigo', '$nombre', '$precio_venta', '$descuento_apl', '$imagen',
                           '$iva', '$descripcion', '$anuncio', '$stock_disp', '$destacados',
                          '$fecha_ini', '$fecha_fin', '$oculto_p', '$Categoria_idCat')");
	}
	
	

	
}
