<?php
/* @var $this NotaController */
/* @var $model Nota */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="clistview-nota">
		<?php echo $form->label($model,'idnota'); ?>
		<?php echo $form->textField($model,'idnota'); ?>
	</div>-->

	<div class="clistview-nota">
		<?php echo $form->label($model,'origen'); ?>
		<?php 
			echo $form->hiddenField($model,'origen',array()); //Campo oculto para guardar el ID del área seleccionada
			$this->widget('zii.widgets.jui.CJuiAutoComplete',
				array(
					'name'=>'origen', //Nombre para el campo de autocompletar
					'model'=>$model->isNewRecord ? '' : $model->origen0->nombre,
					'source'=>$this->createUrl('nota/autocomplete'), //URL que genera el conjunto de datos
					'options'=>array(
						'showAnim'=>'fold',
						#'size'=>'30',
						'minLenght'=>'2', //Mínimo de caracteres que hay que tipear antes de realizar la búsqueda
						'select'=>"js:function(event, ui) {
							$('#Nota_origen').val(ui.item.id); //HTML-Id del campo hidden
						}"
					),
					'htmlOptions'=>array(
						#'size'=>'60',
						'placeholder'=>'Área origen',
						//'title'=>'Indique el área . . .'
					),
				));
		?>
	</div>

	<!--<div class="clistview-nota">
		<?php echo $form->label($model,'fecharealizacion'); ?>
		<?php echo $form->textField($model,'fecharealizacion'); ?>
	</div>

	<div class="clistview-nota">
		<?php echo $form->label($model,'fechaenvio'); ?>
		<?php echo $form->textField($model,'fechaenvio'); ?>
	</div>-->

	<div class="clistview-nota">
		<?php echo $form->label($model,'cuerpo'); ?>
		<?php echo $form->textField($model,'cuerpo'); ?>
	</div>

	<div class="clistview-nota">
		<?php echo $form->label($model,'numeronota'); ?>
		<?php echo $form->textField($model,'numeronota'); ?>
	</div>
	
	<!--<div class="clistview-nota">
		<?php echo $form->label($model,'usuario_receptor'); ?>
		<?php echo $form->textField($model,'usuario_receptor'); ?>
	</div>-->
	
	<div class="clistview-nota">
		<?php echo $form->label($model,'usuario_emisor'); ?>
		<?php 
			echo $form->hiddenField($model,'usuario_emisor',array()); //Campo oculto para guardar el ID del área seleccionada
			$this->widget('zii.widgets.jui.CJuiAutoComplete',
				array(
					'name'=>'uIdusuario', //Nombre para el campo de autocompletar
					'model'=>$model->isNewRecord ? '' : $model->usuarioIdusuario->apellido,
					'source'=>$this->createUrl('nota/autocomplete2'), //URL que genera el conjunto de datos
					'options'=>array(
						'showAnim'=>'fold',
						#'size'=>'30',
						'minLenght'=>'2', //Mínimo de caracteres que hay que tipear antes de realizar la búsqueda
						'select'=>"js:function(event, ui) {
							$('#Nota_usuario_emisor').val(ui.item.id); //HTML-Id del campo hidden
						}"
					),
					'htmlOptions'=>array(
						#'size'=>'60',
						'placeholder'=>'Nombre o apellido del usuario',
						//'title'=>'Indique el área a la cual pertenece el usuario'
					),
				));
		?>
	</div>
	
	<div class="clistview-nota">
		<?php echo $form->label($model,'fecharealizacion'); ?>
		<?php 
			$this->widget('application.extensions.EDateRangePicker.EDateRangePicker',array(
				'id'=>'fecharealizacion',
				'language'=>'es',
				'name'=>'Nota[fecharealizacion]',
				#'value'=>'10/02/2011',
				'options'=>array(/*'arrows'=>true*/
					'selectOtherMonths'=>'true',
					'showOtherMonths'=>'true',
					'changeMonth'=>'true',
					'changeYear'=>'true',
				),
				#'htmlOptions'=>array('class'=>'inputClass'),
			));
		?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->