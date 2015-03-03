<p>La creacion del usuario a tenido exito</p>
<a href="<?=site_url('/practica_principal/ir_carro')?>">Ir al carro</a>
<a href="<?=site_url('/practica_principal')?>">Continuar comprando</a>
<?php 
 if ($this->session->userdata('dentro') == true)
 {?>
 	<a href="<?=site_url('/practica_principal/resumen_productos')?>">Ir al resumen de precompra</a>
<?php  }