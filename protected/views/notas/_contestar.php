<?php
/* @var $this NotasController */
/* @var $model Notas */
/* @var $form CActiveForm */
?>

<script>
	$(document).ready(function(){
		$("#ndestino").keyup(function(){
			if($("#ndestino").val() === "")
			{
				$("#Notas_destino").focus().val("");
				$("#Notas_destino").blur();
			}
		});
		
		$("#ndestino").blur(function(){
			$("#Notas_destino").focus().blur();
		});
		
		$("#Notas_origen").blur(function(){
			$("#Notas_nronota").focus();
			$("#Notas_nronota").blur();
		});
		
		$("#Documentacionesadjuntas_tipo_documentacion").change(function(){
			var tipo = $("#Documentacionesadjuntas_tipo_documentacion option:selected").text();
			$("#Documentacionesadjuntas_tipo").val(tipo);
		});
		
		$("#Notas_nronota").dblclick(function(){
			$("#Notas_nronota").removeAttr("readonly");
		});
	});
	
</script>

	<div class="form" style="width:1200px;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'notas-form',
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

		<?php echo $form->errorSummary(array($model,$modelseg,$modeldoc,$modelpro)); ?>

		<div id="f-nota" style="margin-left: 70px;width:570px !important;float:left !important;">
			<div class="row">
				<?php echo $form->labelEx($modelseg,'idnota_referencia'); ?>
				<?php echo $form->textField($modelseg,'idnota_referencia',array('readonly'=>'readonly')); ?>
				<?php echo $form->error($modelseg,'idnota_referencia'); ?>
			</div>

			<?php $areaUsuario = $model->getAreaUsuario();
				if(gettype($areaUsuario) == "string") {
			?>
				<div id="row-col">
					<div class="row">
						<?php echo $form->labelEx($model,'origen'); ?>
						<?php echo $form->hiddenField($model,'origen'); ?>
						<?php echo $form->textField($model,'mostrar_origen',array('readonly'=>'readonly')); ?>
						<?php echo $form->error($model,'origen'); ?>
					</div>
				</div>
				<div id="row-col">
					<div class="row">
						<?php echo $form->labelEx($model,'nronota'); ?>
						<?php 
							if($model->get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Firefox")
								echo '<div class="notas-field-container">' . $form->textArea($model,'nronota',array('class'=>'a','readonly'=>'readonly')) . '<div class="notas-field">/' . date("Y") . '</div></div>'
						?>
						<?php 
							if($model->get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Chrome")
								echo '<div class="notas-field-container">' . $form->textArea($model,'nronota',array('class'=>'b','readonly'=>'readonly')) . '<div class="notas-field">/' . date("Y") . '</div></div>'
						?>
						<?php echo $form->error($model,'nronota'); ?>
					</div>
				</div>
			<?php } else { ?>
				<div id="row-col">
					<div class="row">
						<?php echo $form->labelEx($model,'origen'); ?>
						<?php $htmlOptions = array(
							//$htmlOptions es un ajaxCAll - cuando cambia el valor de mostrar_origen, se actualiza el campo mostrar_nronota
							'ajax'=>array(
								'type'=>'POST',
								'url'=>$this->createUrl('notas/crearNronota'),
								/*'url'=>Yii::app()->createUrl('notas/actionUdpateTxt'),*/
								'update'=>'#Notas_nronota',
							),
							'prompt'=>'Seleccione área...',
						); ?>
						<?php echo $form->dropDownList($model,'origen',$model->getListaDeAreasDelUsuario(),$htmlOptions) ?>
						<?php echo $form->error($model,'origen'); ?>
					</div>
				</div>

				<div id="row-col">
					<div class="row">
						<?php echo $form->labelEx($model,'nronota'); ?>
						<?php 
							if($model->get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Firefox")
								echo '<div class="notas-field-container">' . $form->textArea($model,'nronota',array('class'=>'a','readonly'=>'readonly')) . '<div class="notas-field">/' . date("Y") . '</div></div>'
						?>
						<?php 
							if($model->get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Chrome")
								echo '<div class="notas-field-container">' . $form->textArea($model,'nronota',array('class'=>'b','readonly'=>'readonly')) . '<div class="notas-field">/' . date("Y") . '</div></div>'
						?>
						<?php echo $form->error($model,'nronota'); ?>
					</div>
				</div>
			<?php } ?>

			<br></br><div id="row-col">
				<div class="row">
					<?php echo $form->labelEx($model,'fecharealizacion'); ?>
					<?php echo $form->hiddenField($model, 'fecharealizacion'); ?>
					<?php echo $form->textField($model, 'mostrar_fecharealizacion',array('readonly'=>'readonly')); ?>
					<?php echo $form->error($model,'fecharealizacion'); ?>
				</div>
			</div>

			<div id="row-col">
				<div class="row">
					<?php echo $form->labelEx($model,'fechaenvio'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						array(
								'model'=>$model,
								'attribute'=>'fechaenvio',
								'language'=>'es',
								'htmlOptions'=>array('readonly'=>true),
								'options'=>array(
									'value'=>date('d-m-Y'),
									#'constraintInput'=>'true',
									'duration'=>'slow',
									'selectOtherMonths'=>true,
									'showOtherMonths'=>true,
									'changeMonth'=>'true',
									'changeYear'=>'true',
									'showAnim'=>'fade',
									'minDate'=>0,
								),
							)
						);
					?>
					<?php echo $form->error($model,'fechaenvio'); ?>
				</div>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'destino'); ?>
				<?php echo $form->hiddenField($model,'destino'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>"ndestino", // Nombre para el campo de autocompletar
						'model'=>$model,
						'value'=>$model->destino ? $model->destino0->nombre : $model->destino0->nombre,
						'source'=>$this->createUrl('notas/autocomplete'), // URL que genera el conjunto de datos
						#'htmlOptions'=>array_merge($disabled,array('size'=>'60','title'=>'Ingrese Producto/Medicamento y su lote')),
						'options'=>array(
							'showAnim'=>'fold',
							'size'=>'50',
							'minLenght'=>'1', // Mínimo de caracteres que hay que digitar antes de realizar la búsqueda
							'select'=>'js:function(event, ui){
								$("#Notas_destino").val(ui.item.id);
							}'
						),
						'htmlOptions'=>array(
							'size'=>'35',
							'placeholder'=>'Ingrese área',
						),
					)); ?>
				<?php echo $form->error($model,'destino'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'descripcion'); ?>
				<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>10000)); ?>
				<?php echo $form->error($model,'descripcion'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'observaciones'); ?>
				<?php echo $form->textField($model,'observaciones',array('size'=>60,'maxlength'=>5000)); ?>
				<?php echo $form->error($model,'observaciones'); ?>
			</div>

			<div class="row">
				<?php #echo $form->labelEx($model,'idusuario'); ?>
				<?php echo $form->hiddenField($model,'idusuario'); ?>
				<?php #echo $form->error($model,'idusuario'); ?>
			</div>
		</div>

		<div id="prov-docadj" style="margin-top:18px;width:510px !important;float:right !important;">
			<div class="row" style="display:inline-block;">
				<?php echo $form->labelEx($modelpro,'idproveedor'); ?>
				<?php echo $form->hiddenField($model, 'name_prov', array('placeholder'=>'Holo :3')); ?>
				<?php echo $form->hiddenField($modelpro,'idproveedor'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>"prov", // Nombre para el campo de autocompletar
					'model'=>$modelpro,
					'value'=>$modelpro->isNewRecord ? '' : $model->idproveedor0->nombre,
					'source'=>$this->createUrl('notasproveedores/autocomplete'), // URL que genera el conjunto de datos
					#'htmlOptions'=>array_merge($disabled,array('size'=>'60','title'=>'Ingrese Producto/Medicamento y su lote')),
					'options'=>array(
						'showAnim'=>'fold',
						'size'=>'50',
						'minLenght'=>'1', // Mínimo de caracteres que hay que digitar antes de realizar la búsqueda
						'select'=>'js:function(event, ui){
							$("#NotasProveedores_idproveedor").val(ui.item.id);
						}'
					),
					'htmlOptions'=>array(
						'size'=>'35',
						'placeholder'=>'Ingrese proveedor',
					),
				)); ?>
				<?php echo $form->error($modelpro,'idproveedor'); ?>
			</div>

			<div class="row" style="display:inline-block;">
				<?php echo $form->labelEx($modelpro,'importe'); ?>
				<?php echo $form->textField($modelpro,'importe'); ?>
				<?php echo $form->error($modelpro,'importe'); ?>
			</div>

			<br></br><div class="row">
				<?php echo $form->labelEx($modeldoc,'tipo'); ?>
				<?php echo $form->hiddenField($modeldoc,'tipo'); ?>
				<?php echo $form->dropDownList($modeldoc,'tipo_documentacion',$modeldoc->array_tipo_documentacion,array('empty'=>'Seleccione tipo de documentacion adjunta')); ?><br></br>
				<?php echo $form->textArea($modeldoc,'descripcion',array('style'=>'width:345px;height:150px;margin-top: -20px;font: 13pt Arial;')); ?>
			</div><br></br>
		</div>
		
		<div class="row buttons" style="margin-top:80px !important;margin-left: 70px;display:block !important;clear:both;">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class'=>'answer')); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->