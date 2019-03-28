<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Inicio de sesión';
$this->breadcrumbs=array(
	'Inicio de sesión',
);
?>

<script>
	$(document).ready(function(){
		$("input#LoginForm_username").focus();
	});
</script>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('style'=>'margin-left: 16% !important;'),
)); ?>

<h1>Iniciar sesión</h1><br></br>

	<div class="row" style="display: inline-block;margin-right: 30px;">
		<?php #echo $form->labelEx($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
		<?php echo $form->textField($model,'username', array('placeholder'=>'Ingresar usuario')); ?>
	</div>

	<div class="row" style="display: inline-block;">
		<?php #echo $form->labelEx($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('placeholder'=>'Ingresar contraseña')); ?>
	</div><br />

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div><br />

	<div class="row buttons" style="margin-top: 30px;">
		<?php echo CHtml::submitButton('Ingresar', array('class'=>'answer')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
