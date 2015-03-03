<?php
Class Practica_modelo_provincias extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}
    
	/**
	 * Devuelve todas la provincias
	 */
	function rec_provincias()
	{
		$rP = $this->db->query("select * from tbl_provincias");

		return $rP->result_array();
	}

	}
