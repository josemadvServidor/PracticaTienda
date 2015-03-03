<?php

require_once (APPPATH.'/libraries/fpdf17/fpdf.php');

class PDF extends FPDF {
	
	public function __construct($params=array())
	{
		//FPDF([string orientation [, string unit [, mixed size]]])
		$orientation=isset($params['orientation']) ? $params['orientation'] : 'P';
		$unit=isset($params['unit']) ? $params['unit'] : 'mm';
		$size=isset($params['size']) ? $params['size'] : 'A4';
		
		//var_dump($orientation);
		//exit;
		parent::__construct($orientation, $unit, $size);
		
	}
}