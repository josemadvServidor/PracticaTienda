<h1>Menu de modificacion de datos de usuario</h1>
<form action="<?=site_url('/practica_usuarios/mod_datos')?>" method="post">
<p>Nuevo DNI <?=form_input("dni", $infoUs[0]['dni_usu'])?> <?=form_error('dni')?></p>
<p>Email <?=form_input("email", $infoUs[0]['email_usu'])?> <?=form_error('email')?></p>
<p>Nombre Real <?=form_input("nombreR", $infoUs[0]['nombre_real_usu'])?> <?=form_error('nombreR')?></p>
<p>Apellidos <?=form_input("apellidos", $infoUs[0]['apellidos_usu'])?> <?=form_error('apellidos')?></p>
<p>Direccion <?=form_input("dir", $infoUs[0]['direccion_usu'])?>  <?=form_error('dir')?></p>
<p>Codigo Postal <?=form_input("cp", $infoUs[0]['cp_usu'])?> <?=form_error('cp')?></p>
<p>Provincia <select name="provincia">
<?php 
foreach ($provincias as $provincia):?>


<option value="<?=$provincia['cod']?>" <?php if ($provincia['cod'] == $infoUs[0]['cod_prov']){echo "selected";};?>><?=$provincia['nombre']?>

<?php 

endforeach;
?>

</select></p>
<input type="submit" value="Enviar">
</form><br>