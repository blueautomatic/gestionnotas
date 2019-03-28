<?php
/* @var $this NotasController */
/* @var $data Notas */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nronota')); ?>:</b>
	<?php echo CHtml::encode($data->nronota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecharealizacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecharealizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaenvio')); ?>:</b>
	<?php echo CHtml::encode($data->fechaenvio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destino')); ?>:</b>
	<?php echo CHtml::encode($data->destino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('idusuario')); ?>:</b>
	<?php echo CHtml::encode($data->idusuario); ?>
	<br />

	*/ ?>

</div>