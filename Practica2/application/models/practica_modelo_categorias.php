<?php
Class Practica_Modelo_Categorias extends CI_Model{

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Recoge y devuelve los datos de todas la categorias
	 */
	function rec_categoria()
	{
		$pCat = $this->db->query("select * from categoria where oculto = FALSE");

		return $pCat->result_array();
	}

	function rec_categoriasT()
	{
		$pCat = $this->db->query("select * from categoria");
		
		return $pCat->result_array();
		
	}
	
	function crea_categoria($idCat, $cod_categ, $nombre_cat, $descr_cat, $anuncio_cat, $oculto)
	{
		$pCat = $this->db->query("insert into categoria 
				values (null, '$cod_categ','$nombre_cat','$descr_cat','$anuncio_cat','$oculto')");
	
		return $pCat;
	
	}
	
	
	}
