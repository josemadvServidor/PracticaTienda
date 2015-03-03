<form method="post" action="http://localhost/CodeIgniter/index.php/personas/editar">
<?php
echo "DNI antiguo:" . form_input("dniant") . "<br>";
echo "DNI:" . form_input("dni") . "<br>";
echo "Nombre:" . form_input("nombre") . "<br>";
echo "Apellidos:" . form_input("apellidos") . "<br>";
echo "Peso:" . form_input("peso") . "<br>";
echo "Email:" . form_input("email") . "<br>";
echo "Fecha:" . form_input("fecha") . "<br>";
?>
<input type="submit" name="aniadir" value="Enviar">
</form>
<?php 
