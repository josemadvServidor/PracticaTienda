
<div style="margin-bottom:10px">
<?php

echo $this->pagination->create_links();
?>
</div>
<?php 
foreach ($array as $destaca):
	?>
<div style="border:1px solid; background-color: lightblue; width:300px; height:210px; margin-left: 150px">
<?php 
if ($destaca['imagen'] != null)
{
	?>
	<IMG src="<?=$destaca['imagen']?>" width="100px" height=\100px" style="margin-top: 10px; margin-left: 10px">
<?php 
}else{

	echo "<IMG src=\"http://static.trendipia.com/5/3/1/c/531c3b4000a427778f4e9a817b226aa87f82777a/producto-no-disponible1_full.jpg\" width=\"100px\" height=\"100px\" style=\"margin-top: 10px; margin-left: 10px\">";
	
}
?>

	 <br> Nombre: <?=$destaca['nombre']?>
     <br>Precio: <?=$destaca['precio_venta']?>
     <br>Descripcion: <?=$destaca['descripcion']?>
     <br>Anuncio: <?=$destaca['anuncio']?>
     <br>Stock actual: <?=$destaca['stock_disp']?>
     <br><a href="<?=site_url('/practica_principal/info_producto/' . $destaca['idProd'] . '/')?>">Mas informacion</a></div></br>
<?php 
endforeach;


?><br>
