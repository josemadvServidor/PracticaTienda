<?php

Class Practica_modelo_pedidos extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Recoge la informacion de uno o varios pedidos que pertenezcan a un dterminado a usuario
	 * @param unknown $id Identificador del usuario
	 */
	function rec_pedidos($id)
	{
		$pUs = $this->db->query("select * from pedido where Usuarios_idUsuario = $id");

		return $pUs->result_array();
	}
	
	/**
	 * Recoge la informacion de un determinado pedido
	 * @param unknown $id Identificador del pedido
	 */
	function rec_pedido($id)
	{
		$pUs = $this->db->query("select * from pedido where id_pedido = $id");
	
		return $pUs->result_array();
	}
	
	
	/**
	 * Recoge todas la lineas de un determinado pedido
	 * @param unknown $id Identificador del pedido
	 */
	function rec_lineas_pedido($id)
	{
		$lineas = $this->db->query("select * from linea_ped where pedido_id_pedido = $id");
	
		return $lineas->result_array();
	}
	
	
	/**
	 * Crea un nuevo pedido
	 * @param unknown $num_productos Numero de productos del pedido
	 * @param unknown $precio_total Precio total del pedido
	 * @param unknown $estado_ped Estado actual del pedido
	 * @param unknown $Usuarios_id_usuario Identificador dle usuario al que pertenece el pedido
	 * @param unknown $nombre_usu Nombre completo del usuario dueño del pedido
	 * @param unknown $apellidos_usu apellidos completo del usuario dueño del pedido
	 * @param unknown $direccion_ped Direccion del usuario dueño del pedido
	 * @param unknown $cp_usu codigo postal del usuario dueño del pedido
	 * @param unknown $cod_prov codigo de la provincia del usuario dueño del pedido
	 */
	function nuevo_pedido($num_productos, $precio_total, $estado_ped, $Usuarios_id_usuario,
                          $nombre_usu, $apellidos_usu, $direccion_ped, $cp_usu, $cod_prov)
	{
		return $PedidoNuevo = $this->db->query("insert into pedido 
				values (null,'$num_productos','$precio_total','$estado_ped','$Usuarios_id_usuario',
				'$nombre_usu','$apellidos_usu','$direccion_ped','$cp_usu','$cod_prov')");
	
	}
	
	/**
	 * Crea una nueva linea para un pedido
	 * @param unknown $cantidad cantidad del producto
	 * @param unknown $precio precio del producto
	 * @param unknown $idPedido identificador del pedido al que pertenece la linea
	 * @param unknown $idProd identificador del producto al que pertenece la linea
	 */
	function crea_linea_pedido($cantidad, $precio, $idPedido, $idProd)
	{
		return $lineaNueva = $this->db->query("insert into linea_ped
				values (null, $cantidad,$precio,$idPedido,$idProd)");
		
	}
	
	
	/**
	 * Devuelve el id del ultimo pedido insertado para poder accder a  el directamente tras su creacion
	 */
	function id_ultimo()
	{
		return $lineaNueva = $this->db->query("select max(id_pedido) from pedido")->result_array();
		
	}
    
	/**
	 * Borra un pedido y todas sus lineas
	 * @param unknown $id Identificador del pedido
	 */
	function borra_pedido($id)
	{
		
		//Borramos las lineas del pedido
		$this->db->query("delete from linea_ped where pedido_id_pedido = $id");
	
		return $this->db->query("delete from pedido where id_pedido = $id");
	}
	
}