<?php
$config['base_url'] = site_url('/practica_principal/muestraCat/' . $idCat . '/');
$config['total_rows'] = count($productosCategoriaT['array']);
$config['per_page'] = '3';
$config['uri_segment'] = 4;