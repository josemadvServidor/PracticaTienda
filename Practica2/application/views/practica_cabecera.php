<div style="background-color: #E0FFFF; margin: 10px">
<div style="align: center; width: 120px; position: absolute; margin-left: 1100px">
<a style="text-align: right" href="<?=site_url('/practica_principal/ir_carro')?>">Acceder al carro</a></div>
<?php if ($this->session->userdata('dentro') == false){?>
<p><a href="<?=site_url('/practica_principal/inicioSesion')?>">Iniciar Sesion</a></p>

<?php }else{?>
	<div style="">
	<p>Usuario: <?=$this->session->userdata('nombre')?>

	<a href="<?=site_url('/practica_usuarios/cierre_sesion')?>">Cerrar sesion</a></p>
	<p><a href="<?=site_url('/practica_usuarios/mod_datos')?>">Modificar informacion de usuario</a></p>
	<p><a href="<?=site_url('/practica_principal/consulta_pedidos')?>">Mostrar pedidos</a></p>
	<p><a href="<?=site_url('/practica_usuarios/aviso_baja')?>">Darse de baja</a></p></div>
	<?php 
}?>
</div>
