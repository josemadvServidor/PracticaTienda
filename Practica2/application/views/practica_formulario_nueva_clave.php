<?php echo validation_errors();?>
<form action="<?=site_url('/practica_usuarios/recupera_clave')?>" method="post">
Indique su email <?=form_input("email")?><br>
<input type="submit" value="Enviar">
</form><br>