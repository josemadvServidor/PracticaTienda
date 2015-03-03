<h1>Gestion de productos</h1>
<?php
foreach ($productosNoStock as $p):
?>
<p>No hay suficente cantidad del producto <?=$p['nombre']?></p>
<?php 
endforeach;