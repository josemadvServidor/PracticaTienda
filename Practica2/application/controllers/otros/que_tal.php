<?php
class que_tal extends CI_Controller{
	
	public function index(){
		
		$this->load->view('que_tal');
		
	}
	/*4. Añadir la acción “CuentaNumeros” al controlador “Que_Tal_Estas” 
	 * la cual recibirá como parámetro un número y mostrará por pantalla
	 *  los números menores que el pasado como parámetro. 
Por defecto si no se indica ningún número se tomará el valor 10.
Incluir en  el menú de Hola_Mundo enlaces para que nos muestre los números 
menores que 5, 10 y 100.*/
	public function CuentaNumeros($ini = 10)
	{
		while($ini >= 0)
		{
			echo $ini . "<br>";
			$ini--;
		}
		
	}
	
}
