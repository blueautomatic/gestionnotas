<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<script>
	$(document).ready(function() {
		//Limpia el campo contrasenia_repeat cuando detecta algún cambio tecleado en campo contrasenia
		$("#Usuarios_contrasenia").on('input propertychange paste', function() {
			$("#Usuarios_contrasenia_repeat").val("");
		});
		
		$("#nombre_area").click(function() {
			$(this).select();
		});
		
		var idarea = $("#UsuariosAreas_idarea").val();
		$("#nombre_area").keyup(function() {
			if($.trim($("#nombre_area").val()) === "")
			{
				$("#UsuariosAreas_idarea").focus().val(idarea);
				$("#UsuarioAreas_idarea").blur();
			}
		});
		
		$("#nombre_area").click(function() {
			$(this).select();
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
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'usuario'); ?>
	</div>

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
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido'); ?>
		<?php echo $form->textField($model,'apellido',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'apellido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelua,'idarea'); ?>
		<?php echo $form->dropDownList($modelua,'idarea', $modelua->getListaDeAreas(), array('prompt'=>'Seleccione área...')); ?>
		<?php echo $form->error($modelua,'idarea'); ?>
	</div>
	
	<?php echo $form->errorSummary(array($model,$modelua)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class'=>'answer')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->