<h1>Gestion de usuarios</h1>
<form action="<?=site_url('/practica_usuarios/creaUsuario')?>" method="post">
DNI <?=form_input("dni", set_value('dni'))?>  <?=form_error('dni')?><br>
Nombre de Usuario <?=form_input("nombre", set_value('nombre'))?>  <?=form_error('nombre')?><br>
Clave <?=form_password("clave", set_value('clave'))?> <?=form_error('clave')?><br>
Confirma clave <?=form_password("confirClave")?>  <?=form_error('confirClave')?><br>
Email <?=form_input("email",set_value('email'))?> <?=form_error('email')?><br>
Nombre Real <?=form_input("nombreR", set_value('nombreR'))?> <?=form_error('nombreR')?><br>
Apellidos <?=form_input("apellidos",set_value('apellidos'))?> <?=form_error('apellidos')?><br>
Direccion <?=form_input("dir",set_value('dir'))?> <?=form_error('dir')?><br>
Codigo Postal <?=form_input("cp",set_value('cp'))?> <?=form_error('cp')?><br>
Provincia <select name="provincia">

<?php 
foreach ($provincias as $provincia):?>


<option value="<?=$provincia['cod']?>" <?php if(set_value('provincia') == $provincia['cod']){echo "selected";}?>><?=$provincia['nombre']?>

<?php 

endforeach;
?>

</select><br>
<input type="submit" value="Enviar">
</form><br>