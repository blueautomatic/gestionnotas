<?php
/* @var $this NotasController */
/* @var $model Notas */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nronota'); ?>
		<?php echo $form->textField($model,'nronota'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecharealizacion'); ?>
		<?php echo $form->textField($model,'fecharealizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaenvio'); ?>
		<?php echo $form->textField($model, 'fechaenvio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destino'); ?>
		<?php echo $form->textField($model,'destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>10000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observaciones'); ?>
		<?php echo $form->textField($model,'observaciones',array('size'=>60,'maxlength'=>5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idusuario'); ?>
		<?php echo $form->textField($model,'idusuario'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->