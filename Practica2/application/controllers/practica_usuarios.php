<?php

class Practica_usuarios extends CI_Controller{

	public function index(){

		

	}
	/**
	 * Almacenara las categorias
	 * @var unknown
	 */
	public $categorias;
	
	/**
	 * Almacenara el carrito de la compra
	 * @var unknown
	 */
	public $carro;
	
	/**
	 * Comprueba si un email ya esta en uso
	 * @param unknown $mail
	 * @return boolean
	 */
	function compruebamail($mail){
		
		if (count($this->practica_modelo_usuarios->comprueba_mail($mail)) > 0)
		{
			return false;
			
		}else{
			
			return true;
			
		}
		
	}
	
	/**
	 * Comprueba si un email ya esta en uso (version para el campo de modificar)
	 * @param unknown $mail
	 * @return boolean
	 */
	function compruebamailMod($mail){
	
	
	
		if (count($this->practica_modelo_usuarios->comprueba_mail($mail)) > 1)
		{
			return false;
				
		}else{
				
			return true;
				
		}
	
	}
	
	/**
	 * Valida un DNI
	 * @param unknown $dni
	 * @return boolean
	 */
	function validaDNI($dni) {
		if (strlen($dni) != 9 ||
				preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $dni, $matches) !== 1) {
					return false;
				}
	
				$map = 'TRWAGMYFPDXBNJZSQVHLCKE';
	
				list(, $number, $letter) = $matches;
	
				return strtoupper($letter) === $map[((int) $number) % 23];
	}
	
	/**
	 * Se asegura de que todos los componente de una cadena sean numeros
	 * @param unknown $cad
	 * @return boolean
	 */
	function es_numero($cad)
	{
		if (is_numeric($cad) == true)
		{
			return true;
		}else{
		return false;
		}
	}
	
	public function __construct(){
	
		parent::__construct();
	
		$this->load->model('practica_modelo_categorias');
		$this->load->model('practica_modelo_productos');
		$this->load->model('practica_modelo_pedidos');
		$this->load->model('practica_modelo_usuarios');
		$this->load->model('practica_modelo_provincias');
		
		$this->load->library('Carrito');
		$this->carro = new Carrito();
		$this->categorias = array ("array" => $this->practica_modelo_categorias->rec_categoria());
	}
	
	/**
	 * Cierra la sesion actual
	 */
	public function cierre_sesion(){
		
 $this->session->sess_destroy();
  

    $this->load->view('practica_encabezado');
	$this->load->view('practica_cabecera');
	$this->load->view('practica_menu_cat', $this->categorias);
    $this->load->view('practica_cierre_sesion');
    $this->load->view('practica_pie');
  

	}

	
	/**
	 * Crea un nuevo usuario
	 */
	public function creaUsuario()
	{
		   //Establecemos la normas para los campos del formulario de creacion
			$this->form_validation->set_rules('dni', 'DNI', 'required|callback_validaDNI');
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('clave', 'Clave', 'required|matches[confirClave]');
			$this->form_validation->set_rules('confirClave', 'Confirma Clave', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email| required|callback_compruebamail');
            $this->form_validation->set_rules('nombreR', 'Nombre Real', 'required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
            $this->form_validation->set_rules('dir', 'Direccion', 'required');
            $this->form_validation->set_rules('cp', 'Codigo Postal', 'required|min_length[5]|max_length[5]|callback_es_numero');
            
            $this->form_validation->set_message('validaDNI', "El dni indicado no es correcto");
            $this->form_validation->set_message('es_numero', "El valor debe ser un numero");
            $this->form_validation->set_message('compruebamail', "El email ya esta en uso");
            
			$provincias = array ("provincias" => $this->practica_modelo_provincias->rec_provincias());
  
			//Comprobamos si la validacion es correcta o si es la primera vuelta
			if ($this->form_validation->run()==false)
			{
				
				
				$this->load->view('practica_encabezado');
	         	$this->load->view('practica_cabecera');
		        $this->load->view('practica_menu_cat', $this->categorias);
				$this->load->view('practica_formulario_usuarios', $provincias);
				$this->load->view('practica_pie');
				
			}else{
				
				//Creamos el usuario
				$nuevoUs = $this->practica_modelo_usuarios->nuevo_usuario($this->input->post('dni'), $this->input->post('nombre'), 
						                                       md5($this->input->post('clave')), $this->input->post('email'),
						                                       $this->input->post('nombreR'), $this->input->post('apellidos'),
						                                       $this->input->post('dir'), $this->input->post('cp'), 
						                                       $this->input->post('provincia'));
				//Comprobamo si la creacion fue bien
				if ($nuevoUs)
				{
					
					//Recogemos la informacion del ultimo usuario creado para iniciar sesion
					$datosUs = $this->practica_modelo_usuarios->id_ultimo();
					
					//Iniciamos sesion con el nuevo usuario
					$this->session->set_userdata("nombre", $this->input->post('nombre'));
					$this->session->set_userdata("dentro", true);
					$this->session->set_userdata("id", $datosUs[0]['idUsuario']);
					$this->session->set_userdata("nombreR", $datosUs[0]['nombre_real_usu']);
					$this->session->set_userdata("apellidos", $datosUs[0]['apellidos_usu']);
					$this->session->set_userdata("direccion", $datosUs[0]['direccion_usu']);
					$this->session->set_userdata("cp", $datosUs[0]['cp_usu']);
					$this->session->set_userdata("prov", $datosUs[0]['cod_prov']);
					
					
					$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
					$this->load->view('practica_creacion_usu_correcta');
					$this->load->view('practica_pie');
					
				}else{
					
			$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
					$this->load->view('practica_creacion_usu_fallida');
					$this->load->view('practica_pie');
					
				}

				
			}
		
	}
	
    /**
     * Modifica la informacion del usuario excepto el nomnre de usuario y la clave
     */
	public function mod_datos()
	{
		
		//Se establecen las normas de validacion
		$this->form_validation->set_rules('dni', 'DNI', 'required|callback_validaDNI');
		$this->form_validation->set_rules('email', 'Email', 'valid_email| required|callback_compruebamailMod');
		$this->form_validation->set_rules('nombreR', 'Nombre Real', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		$this->form_validation->set_rules('dir', 'Direccion', 'required');
		$this->form_validation->set_rules('cp', 'Codigo Postal', 'required|min_length[5]|max_length[5]|callback_es_numero');

		$this->form_validation->set_message('validaDNI', "El dni indicado no es correcto");
		$this->form_validation->set_message('es_numero', "El valor debe ser un numero");
		$this->form_validation->set_message('compruebamailMod', "El email ya esta en uso");
		
		$datos = array ("provincias" => $this->practica_modelo_provincias->rec_provincias(),
		                 "infoUs" => $this->practica_modelo_usuarios->informacion_usu($this->session->userdata('id')));
		
			//Comprobamos si la informacion enviada es valida
		if ($this->form_validation->run()==false)
		{
		
		
		$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
		$this->load->view('practica_formulario_mod_usuarios', $datos);
		$this->load->view('practica_pie');
		
		}else{
		
		    //Actualizamos la informacion del usuario
			$ModUs = $this->practica_modelo_usuarios->actualiza_u($this->session->userdata('id'),$this->input->post('dni'), $this->input->post('email'),
					$this->input->post('nombreR'), $this->input->post('apellidos'),
					$this->input->post('dir'), $this->input->post('cp'),
					$this->input->post('provincia'));
		
			if ($ModUs)
			{
					
			$this->load->view('practica_encabezado');
		$this->load->view('practica_cabecera');
		$this->load->view('practica_menu_cat', $this->categorias);
				$this->load->view('practica_mod_usu_correcta');
				$this->load->view('practica_pie');
					
			}else{
					
				$this->load->view('practica_encabezado');
				$this->load->view('practica_cabecera');
				$this->load->view('practica_menu_cat', $this->categorias);
				$this->load->view('practica_mod_usu_fallida');
				$this->load->view('practica_pie');
					
			}
		
		
		}
		
		
	}
	
	/**
	 * Envia un email con una nueva clave y la cambia por la actual para un determinado email
	 */
	public function recupera_clave()
	{

		$this->form_validation->set_rules('email', 'Email', 'valid_email| required');

		if ($this->form_validation->run()==false)
		{
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_formulario_nueva_clave');
			$this->load->view('practica_pie');
			
			
		}else{
			
			$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
			$numerodeletras=10; //numero de letras para generar el texto
			$mensaje = ""; //variable para almacenar la cadena generada
			for($i=0;$i<$numerodeletras;$i++)
			{
				$mensaje .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
				entre el rango 0 a Numero de letras que tiene la cadena */
			}
			
			$clave = md5($mensaje);
			
			$this->practica_modelo_usuarios->cambia_clave($this->input->post('email'), $clave);

			$mensaje = "La nueva clave es " . $mensaje;
			
			$this->email->from('aula4@iessansebastian.com', 'Administrador');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Nueva Clave');
			$this->email->message($mensaje);
			
			if ($this->email->send($this->input->post('email')))
			{
				$this->load->view('practica_encabezado');
				$this->load->view('practica_cabecera');
				$this->load->view('practica_menu_cat', $this->categorias);
				$this->load->view('practica_nueva_clave_correcto');
				$this->load->view('practica_pie');
				
			}
			else
			{
				echo "</pre>\n\n**** NO SE HA ENVIADO ****</pre>\n";
			}
			
		
		}
	}
	
	/**
	 * Antes de dar a un usuario de baja pide confirmacion
	 */
	public function aviso_baja()
	{
		if ($this->session->userdata['dentro'] == true)
		{
	
				
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_seguridad_baja');
			$this->load->view('practica_pie');
				
		}else{
	
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_no_sesion');
			$this->load->view('practica_pie');
	
		}
	
	}
	
	/**
	 * Da  aun usuario de baja
	 */
	public function usuario_baja()
	{
		//Nos aseguramos de que ahi un usuario conectado
		if ($this->session->userdata('dentro') == true)
		{
			//Recogemos y eliminamos los pedidos del usuario y sus lineas
			$pedidos = $this->practica_modelo_pedidos->rec_pedidos($this->session->userdata('id'));
			
			foreach ($pedidos as $pedido):
			
			$this->practica_modelo_pedidos->borra_pedido($pedido['id_pedido']);
			
			endforeach;
			
			//borramos al usuario
            $this->practica_modelo_usuarios->baja($this->session->userdata('id'));
		
            //Cerramos la sesion
			$this->session->sess_destroy();
			
			
			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_baja');
			$this->load->view('practica_pie');
			
		}else{

			$this->load->view('practica_encabezado');
			$this->load->view('practica_cabecera');
			$this->load->view('practica_menu_cat', $this->categorias);
			$this->load->view('practica_no_sesion');
			$this->load->view('practica_pie');
				
		}
	
	}
	
}