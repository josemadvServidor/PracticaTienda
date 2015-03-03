<h1>Formulario inicio sesion</h1>

<?php echo validation_errors();?>
<form action="<?=site_url('/practica_principal/inicioSesion')?>" method="post">

Nombre de Usuario <?=form_input("nombre")?><br>
Clave <?=form_password("clave")?><br>

<input type="submit" value="Enviar">
</form><br>
<a href="<?=site_url('/practica_usuarios/creaUsuario')?>">Nuevo usuario</a>
<p><a href="<?=site_url('/practica_usuarios/recupera_clave')?>">Recuperar clave</a></p>
<br>