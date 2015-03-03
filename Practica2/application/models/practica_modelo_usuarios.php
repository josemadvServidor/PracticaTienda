<?php
Class Practica_modelo_usuarios extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}
	
	/**
	 * Actualiza la informacion de un usuario salvo nombre de usuario y clave
	 * @param unknown $id identificador para localizar al usuario
	 * @param unknown $dni Nuevo dni del usuario
	 * @param unknown $email Nuevo email del usuario
	 * @param unknown $nombreR Nuevo nombre completo del usuario
	 * @param unknown $apellidos Nuevos apellidos  del usuario
	 * @param unknown $dir Nueva direccion del usuario
	 * @param unknown $cp Nuevo codigo postal del usuario
	 * @param unknown $cod_prov Nuevo codigo de la provincia del usuario
	 * @return unknown
	 */
	function actualiza_u($id, $dni,$email, $nombreR, $apellidos, $dir, $cp, $cod_prov)
	{
		$acUser = $this->db->query("update usuarios set dni_usu = \"$dni\",
				                                        email_usu = \"$email\",
				                                        nombre_real_usu = \"$nombreR\",
				                                        apellidos_usu = \"$apellidos\",
				                                        direccion_usu = \"$dir\",
				                                        cp_usu = \"$cp\",
				                                        cod_prov = \"$cod_prov\" 
				                   where idUsuario = \"$id\"");
		
		return $acUser;
		
	}
	
	/**
	 *Devuelve la informacion de un usuario 
	 * @param unknown $id identificador del usuario
	 */
	function informacion_usu($id)
	{
		$info = $this->db->query("select * from usuarios
				where idUsuario = \"$id\"
				");
		
		return $info->result_array();
		
	}
	
	
	/**
	 * Devuelve informacion del ultimo usuario insertado
	 */
	function id_ultimo()
	{
		return $usuarioNuevo = $this->db->query("select * from usuarios where idUsuario = (select Max(idUsuario) from usuarios)")->result_array();
	
	}
	
	/**
	 * Crea un nuevo usuario
	 * @param unknown $dni dni del nuevo usuario
	 * @param unknown $nombre nombre del nuevo usuario
	 * @param unknown $contrasenia clave del nuevo usuario
	 * @param unknown $email email del nuevo usuario
	 * @param unknown $nombreR nombre real del nuevo usuario
	 * @param unknown $apellidos apellidos del nuevo usuario
	 * @param unknown $dir direccion del nuevo usuario
	 * @param unknown $cp codigo postal del nuevo usuario
	 * @param unknown $cod_prov codigo de la provincia del nuevo usuario
	 */
	function nuevo_usuario($dni, $nombre, $contrasenia, $email, $nombreR, $apellidos, $dir, $cp, $cod_prov)
	{
	
		
		
			
		return $usuarioNuevo = $this->db->query("insert into usuarios 
				values (null, '$dni','$nombre','$contrasenia','$email','$nombreR',
				'$apellidos','$dir','$cp','$cod_prov')");
	
	}
	
	/**
	 * Comprueba si existe la combinacion usuario-clave enviada
	 * @param unknown $nombre Nombre a comprobar
	 * @param unknown $clave Clave a comprobar
	 */
	function valida_usuario($nombre, $clave)
	{
		$clave= md5($clave);
		
		return $valida = $this->db->query("select * from usuarios 
				                   where nombre_usu = \"$nombre\" 
				                   and contrasenia_usu =\"$clave\"")->result_array();

	}
	
	function cambia_clave($email, $clave)
	{
		
		$cambiaClave = $this->db->query("update usuarios set contrasenia_usu = \"$clave\" where email_usu = \"$email\"");
		
		return $cambiaClave;
	}
	
	function baja($id)
	{
		return $this->db->query("delete from usuarios where idUsuario = $id");

	}
	
	function comprueba_mail($mail)
	{
		return $comp = $this->db->query("select * from usuarios
				where email_usu = \"$mail\"")->result_array();
		
		
	}

}