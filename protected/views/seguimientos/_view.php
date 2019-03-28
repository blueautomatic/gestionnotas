<?php
/* @var $this SeguimientosController */
/* @var $data Seguimientos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idnota')); ?>:</b>
	<?php echo CHtml::encode($data->idnota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asunto')); ?>:</b>
	<?php echo CHtml::encode($data->asunto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idnota_referencia')); ?>:</b>
	<?php echo CHtml::encode($data->idnota_referencia); ?>
	<br />


</div>