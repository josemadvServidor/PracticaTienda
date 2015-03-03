<h1>Formulario inicio sesion</h1>
<p style="color: red">Combinacion usuario - clave invalida</p>
<form action="<?=site_url('/practica_principal/inicioSesion')?>" method="post">

Nombre de Usuario <input type="text"  name="nombre" value="<?=$nombre?>"><br>
Clave <input type="password" name="clave" value="<?=$clave?>"><br>

<input type="submit" value="Enviar">
</form><br>
<a href="<?=site_url('/practica_usuarios/creaUsuario')?>">Nuevo usuario</a>
<p><a href="<?=site_url('/practica_usuarios/recupera_clave')?>">Recuperar clave</a></p>