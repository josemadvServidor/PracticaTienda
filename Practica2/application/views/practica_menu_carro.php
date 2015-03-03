

<?php

if ($array == null)
{
	?>
	<div><h1>Carrito de la compra</h1>
	<p>no ahi productos</p><a href="<?=site_url('/practica_principal')?>">Volver</a></div>
<?php 
}else{
	?><h1>Carrito de la compra</h1>
	<a href="<?=site_url('/Practica_principal/vacia_carro')?>">Vaciar el carrito</a>
<table><tr><th>Identificador</th><th>Nombre</th><th>Precio/Unidad</th><th>Cantidad</th></tr>
<?php 
foreach ($array as $prodCarro):
?>
<tr><td><?=$prodCarro['id']?></td>
     <td><?=$prodCarro['nombre']?></td>
     <td><?=$prodCarro['precio']?></td>
     <td><?=$prodCarro['cantidad']?></td>

<td><a href="<?=site_url('/practica_principal/saca_producto/' . $prodCarro['id'])?>">Sacar del carrito</a></td></tr>

 
<?php 

endforeach;

?>

<p>Precio Total: <?php echo $pTotal[0] . " Euros";

?></p>
</table>

<?php 

if ($this->session->userdata('dentro') == false)
{
	?><p>Para comprar antes <a href="<?=site_url('/practica_principal/inicioSesion')?>">Inicie sesion</a></p><?php
}else{
	
 ?><p><a href="<?=site_url('/practica_principal/resumen_productos')?>">Ir a compra</a></p><?php 
}

}
