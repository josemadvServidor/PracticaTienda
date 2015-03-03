<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function pdf()
	{
		$this->load->library('PDF', array());
		
		//$this->pdf->output();
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',8);
		
		for ($i = 0; $i <= 1000; $i++)
		{
		$pdf->Cell(10,10,$i,0,1);
		}
		
		$pdf->Output();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */