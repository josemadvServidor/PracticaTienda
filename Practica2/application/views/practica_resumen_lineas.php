<tr><td><img src="<?=$informacion[0]['imagen']?>" width="100px" height="100px"></td>
<td><?=$informacion[0]['codigo']?></td><td><?=$informacion[0]['nombre']?></td>
<td><?=$infoP['cantidad_pro'] . " unidades"?></td>
<td><?=
round($infoP['precio_unidad'] * $infoP['cantidad_pro'],2)
?></td>
<td><?=$informacion[0]['descripcion']?></td>
</tr>
<?php
