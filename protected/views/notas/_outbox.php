<?php
/* @var $this NotaController */
/* @var $data Nota */
?>
<a href="<?php echo Yii::app()->baseUrl . '/notas/ver/' . $data->id; ?>">
	<div class="view-conmicss <?php echo $data->getClaseInbox($data->status); ?>">
		<?php /*echo '<b style="font-size:18pt;">' . CHtml::link(CHtml::encode('Nota ' . $data->numeronota . '/' . $data->getDatosParaActualizar($data->idnota)->mostrar_year),
					array('modificar', 'id'=>$data->idnota),
					array('class'=>'definetly-not-a-link', 'title'=>'Editar nota')) . '</b>';*/
		?>
		
		<?php echo '<b style="font-size:18pt;">' . CHtml::encode('Nota ' . $data->getNumeroDeNota($data->id)) . '</b>';	?>
		<br />

		<b><?php echo CHtml::encode('Enviada el'); ?>:</b>
		<?php echo html_entity_decode(CHtml::encode($data->setFecha($data->fechaenvio))); ?>
		<br />

		<b><?php echo CHtml::encode('Hacia'); ?>:</b>
		<?php echo CHtml::encode($data->destino0->nombre); ?>
		<br />

		<!-- Expanding/Collapsing: hay que poner el botón para expandir/contraer
			 el contenido deseado justo por encima del contenido que se quiere 
			 mostrar/ocultar. Esto se debe a la parte de javascript (en vista index.php)
			 $(this).next("div.contenedor").show/hide("slow") ya que si no están uno
			 al lado del otro, pues no funciona lo de mostrar/ocultar -->
		<input class="miBtn definetly-not-a-link" type="button" value="+"></input>
		<div class="contenedor" style="display:none;">
			<!--<b><?php #echo CHtml::encode($data->getAttributeLabel('mostrar_estado')); ?>:</b>
			<?php #echo CHtml::encode($data->setEstado($data->idnota)); ?>
			<br />-->
			
			<b><?php echo CHtml::encode('Fecha de realización'); ?>:</b>
			<?php echo CHtml::encode($data->setFecha($data->fecharealizacion)); ?>
			<br />
		
			<b><?php echo CHtml::encode('Origen'); ?>:</b>
			<?php echo html_entity_decode(CHtml::encode($data->origen0->nombre)); ?>
			<br />
			
			<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
			<?php echo CHtml::encode($data->descripcion); ?>
			<br />

			<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
			<?php echo CHtml::encode($data->observaciones); ?>
			<br />
		</div>
	</div>
</a>
<hr></hr>