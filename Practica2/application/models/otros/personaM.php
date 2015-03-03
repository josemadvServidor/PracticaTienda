<?php
Class PersonaM extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	function consulta()
	{
		$prov = $this->db->query("select * from personas");

		return $per->result_array();
	}

	function adicion($dni,$nombre,$apellidos, $peso, $email, $fecha)
	{
		$inser = $this->db->query("insert into personas values (\"$dni\", \"$nombre\", \"$apellidos\", $peso, \"$email\", \"$fecha\")");

		return $inser;
	}

	function borrar($dni)
	{
		$del = $this->db->query("delete from personas where dni = \"$dni\"");

		return $del;
	}

	function modificar($dniant, $dni, $nombreN, $apellidos, $peso, $email, $fecha)
	{
		$upd = $this->db->query("update personas set nombre=\"$nombreN\", apellidos=\"$apellidos\", 
				                                     peso=$peso , email=\"$email\" , fecha=\"$fecha\" 
				                 where dni=\"$dniant\"");

		return $upd;
	}
	
	function comprueba_dni($dni)
	{
		$busca = $this->db->query("select * from personas where dni = \"$dni\"")->result_array();

		if (count($busca) > 0){
			
		return true;
		
		}else{
			
		 return false;
		 
		}
	}
	
}