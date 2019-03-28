<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<script>
	$(document).ready(function() {
		//Clears contrasenia_repeat input when detects a change made on contrasenia input
		$("#Usuarios_contrasenia").on('input propertychange paste', function() {
			$("#Usuarios_contrasenia_repeat").val("");
		});
	});
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contrasenia'); ?>
		<?php echo $form->passwordField($model,'contrasenia',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'contrasenia'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'contrasenia_repeat'); ?>
		<?php echo $form->passwordField($model,'contrasenia_repeat',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'contrasenia_repeat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class'=>'answer')); ?>
	</div>

	<?php echo $form->errorSummary($model); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->