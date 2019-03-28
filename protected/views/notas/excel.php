<table style="border: 1px solid black;font-size:13pt;">
	<tr>
		<th style="border: 1px solid black;">Número de nota</th>
		<th style="border: 1px solid black;">Enviada el</th>
		<th style="border: 1px solid black;">Detalle</th>
		<th style="border: 1px solid black;">Enviada hacia</th>
	</tr>
	<?php foreach($model as $data): ?>
	<tr>
		<td style="border: 1px solid black;"><?php echo $data->getNumeroDeNota($data->id); ?></td>
		<td style="border: 1px solid black;"><?php echo $data->fechaenvio; ?></td>
		<td style="border: 1px solid black;"><?php echo $data->descripcion; ?></td>
		<td style="border: 1px solid black;"><?php echo $data->origen0->nombre; ?></td>
	</tr>
	<?php endforeach; ?>
</table>