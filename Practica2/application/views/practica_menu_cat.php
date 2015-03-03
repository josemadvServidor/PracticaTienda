
<div style="background-color: yellow ; width: 120px; height: 700px ; float:left ; text-align:center ; margin: 10px 10px 10px 10px ">
<a href="<?=site_url('/practica_principal/index')?>">Inicio/Destacados</a><br><br>
<?php foreach ($array as $categoria):?>

<a href="<?=site_url('/practica_principal/muestraCat/' . $categoria['idCat'] . '/')?>"><?=$categoria['nombre_cat']?> </a><br>
<?php 
endforeach;
?>

</div>
<?php 
