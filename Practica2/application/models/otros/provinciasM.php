<?php
Class ProvinciasM extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
		
        $this->load->database();
	}
	
	function consulta()
	{
		$prov = $this->db->query("select * from tbl_provincias");
		
		return $prov->result_array();
	}
	
	function adicion($cod,$nombre,$comunidad)
	{
		$inser = $this->db->query("insert into tbl_provincias values (\"$cod\", \"$nombre\", $comunidad)");
	
		return $inser;
	}
	
	function borrar($cod)
	{
		$del = $this->db->query("delete from tbl_provincias where cod = \"$cod\"");
	
		return $del;
	}
	
	function modificar($cod, $nombreN)
	{
		$upd = $this->db->query("update tbl_provincias set nombre=\"$nombreN\" where cod=\"$cod\"");
	
		return $upd;
	}
}