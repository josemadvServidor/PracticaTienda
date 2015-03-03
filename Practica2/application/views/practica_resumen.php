
<tr><td><img src="<?=$informacion[0]['imagen']?>" width="100px" height="100px"></td>
<td><?=$informacion[0]['codigo']?></td><td><?=$informacion[0]['nombre']?></td>
<td><?=$informacion[0]['precio_venta'] . "E"?></td><td><?=$informacion[0]['descuento_apl'] . "%"?></td>
<td><?=$informacion[0]['iva'] . "%"?></td><td><?=$infoP['cantidad'] . " unidades"?></td>
<td><?php 


	
	echo $infoP['precio']. " E";
	




?></td>
<td><?=$informacion[0]['descripcion']?></td>
</tr>
<?php
