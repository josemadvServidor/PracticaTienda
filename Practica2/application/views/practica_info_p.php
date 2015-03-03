
<h1>Informacion del producto</h1>
<?php 
if ($array[0]['imagen'] != null)
{
	
echo "<IMG src=\"" . $array[0]['imagen'] . "\" width=\"300px\" height=\"300px\">";

}else{

echo "<IMG src=\"http://static.trendipia.com/5/3/1/c/531c3b4000a427778f4e9a817b226aa87f82777a/producto-no-disponible1_full.jpg\" width=\"300px\" height=\"300px\">";
	
}

?>
<form action="<?=site_url('/practica_principal/aniade_producto/' . $array[0]['idProd'] . '/')?>" method="post">
<p>Nombre: <?=$array[0]['nombre'] ?></p>
<p>Precio: <?=$array[0]['precio_venta'] ?></p>
<p>Descuento: <?=$array[0]['descuento_apl'] ?></p>
<p>IVA: <?=$array[0]['iva'] ?></p>
<p>Descripcion: <?=$array[0]['descripcion'] ?></p>
<p>Anuncio: <?=$array[0]['anuncio'] ?></p>
<p>Cantidad Disponible: 
<?php 

$cant = $array[0]['stock_disp'];

if (count($carro) == 0){

}else{
foreach ($carro as $producto):
//var_dump($producto[0]);
if ($array[0]['idProd'] == $producto['id'])
{
	$cant = $cant - $producto['cantidad'];
}
endforeach;
}
if ($cant == 0)
{
	?>
	
	Todo el stock de este producto esta ya en su carro.
	
	<?php
}else{
?>
<select name="cantidad">
<?php 
for ($n = 0; $n <= $cant; $n++)
{


	echo "<option value=\"$n\">$n";

}	
?></select><?php 
}
if ($cant == 0){
?>
<a href="<?=site_url('/practica_principal/ir_carro')?>">Ir al carro</a>
     <?php }else{ 
     	?>
          </p><input type="submit" value="Enviar al carrito">	
     	<?php 
     }?>
</form>