<?php
/* @var $this AreasController */
/* @var $model Areas */
/* @var $form CActiveForm */
?>

<br></br><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'areas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contador'); ?>
		<?php echo $form->textField($model,'contador'); ?>
		<?php echo $form->error($model,'contador'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class'=>'answer')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->