<?php
/* @var $this NotasController */
/* @var $model Notas */

$this->pageTitle = Yii::app()->name . ' - Pases';
$this->breadcrumbs=array(
	'Notas'=>array('index'),
	$modelshow->getNumeroDeNota($modelshow->nronota),
);

?>

<script>
	$(document).ready(function(){
		$("#prov").keyup(function(){
			if($("#prov").val() === "")
			{
				$("#NotasProveedores_idproveedor").focus().val("");
				$("#NotasProveedores_idproveedor").blur();
			}
		});

		$("#prov").blur(function(){
			var text = $("#prov").val();
			$("#Notas_name_prov").val(text);
		});

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
	});
	
</script>

<style>
	.grid-view-loading
	{
		background:url(themes/images/loading.gif) no-repeat;
	}

	.grid-view
	{
		padding: 15px 0;
	}

	.grid-view table.items
	{
		background: white;
		border-collapse: collapse;
		width: 100%;
		border: 1px #D0E3EF solid;
	}

	.grid-view table.items th, .grid-view table.items td
	{
		font-size: 12.1pt !important;
		padding: 0.5em !important;
		border: 1px solid #bbb !important;
		background: #fcfcfc;
	}

	.grid-view table.items th
	{
		color: #434D5F !important;
		background: #eee /*#434D5F url("bg.gif") repeat-x scroll left top white*/;
		text-align: center;
	}

	.grid-view table.items th a
	{
		background: #eee;
		color: #434D5F;
		font-weight: bold;
		text-decoration: none;
	}

	.grid-view table.items th a:hover
	{
		color: #FFF;
	}

	.grid-view table.items th a.asc
	{
		background:url(up.gif) right center no-repeat;
		padding-right: 10px;
	}

	.grid-view table.items th a.desc
	{
		background:url(down.gif) right center no-repeat;
		padding-right: 10px;
	}

	.grid-view table.items tr.even
	{
		background: #F8F8F8;
	}

	.grid-view table.items tr.odd
	{
		background: #E5F1F4;
	}

	.grid-view table.items tr.selected
	{
		background: #BCE774;
	}

	.grid-view table.items tr:hover.selected
	{
		background: #CCFF66;
	}

	.grid-view table.items tbody tr:hover
	{
		background: #ECFBD4;
	}

	.grid-view .link-column img
	{
		border: 0;
	}

	.grid-view .button-column
	{
		text-align: center;
		width: 60px;
	}

	.grid-view .button-column img
	{
		border: 0;
	}

	.grid-view .checkbox-column
	{
		width: 15px;
	}

	.grid-view .summary
	{
		margin: 0 0 5px 0;
		text-align: right;
	}

	.grid-view .pager
	{
		margin: 5px 0 0 0;
		text-align: right;
	}

	.grid-view .empty
	{
		font-style: italic;
	}

	.grid-view .filters input,
	.grid-view .filters select
	{
		width: 100%;
		border: 1px solid #ccc;
	}
</style>

<h1 class="answer">Reenviar Nota &nbsp;<?php echo $modelshow->getNumeroDeNota($modelshow->id); ?> &emsp;</h1>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nronota',
		array(
			'name'=>'fecharealizacion',
			'value'=>$model->setFecha($model->fecharealizacion),
		),
		array(
			'name'=>'fechaenvio',
			'value'=>$model->setFecha($model->fechaenvio),
		),
		'destino',
		'descripcion',
		'observaciones',
		'idusuario',
	),
));*/ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'notas-grid',
	'htmlOptions'=>array('style'=>'width:1445px;'),
	'dataProvider'=>$modelshow->search(),
	'summaryText'=>false,
	//'filter'=>$model,
	//'cssFile' => Yii::app()->theme->baseUrl . '/classic/css/grid-view-custom-style.css',
	'columns'=>array(
		array(
			'header'=>'ID',
			'value'=>'$data->id',
			'htmlOptions'=>array('style'=>'font-weight:bolder;background-color: #f2d89f;width: 50px !important;text-align: center;'),
		),
		array(
			'header'=>'N° nota',
			'value'=>'$data->getNumeroDeNota($data->id)',
			'htmlOptions'=>array('style'=>'width: 70px !important;text-align: center;'),
		),
		array(
			'header'=>'Fecha de realización',
			'value'=>'$data->setFecha($data->fecharealizacion)',
			'htmlOptions'=>array('style'=>'width: 160px !important;text-align: center;'),
		),
		array(
			'header'=>'Fecha de envío',
			'value'=>'$data->setFecha($data->fechaenvio)',
			'htmlOptions'=>array('style'=>'width: 150px !important;text-align: center;'),
		),
		array(
			'header'=>'Recibida desde',
			'value'=>'$data->origen0->nombre',
			'htmlOptions'=>array('style'=>'width: 200px !important;'),
		),
		array(
			'header'=>'Detalle',
			'value'=>'$data->descripcion',
		),
		array(
			'header'=>'Observaciones',
			'value'=>'$data->observaciones',
		),
		//'idusuario',
	),
)); ?>

<div class="form" style="width:1150px;">
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

	<?php echo $form->errorSummary(array($model,$modeldoc,$modelpro)); ?>
		<div style="margin-left: 40px;display: inline-block !important; vertical-align: 300px;">
			<div id="row-col">
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
				<?php } else { ?>
				<div id="row-col">
					<div class="row">
						<?php echo $form->labelEx($model,'origen'); ?>
						<?php echo $form->dropDownList($model,'origen',$model->getListaDeAreasDelUsuario()); ?>
						<?php echo $form->error($model,'origen'); ?>
					</div>
				</div>
				<?php } ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'destino'); ?>
				<?php echo $form->hiddenField($model,'destino'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>"ndestino", // Nombre para el campo de autocompletar
						'model'=>$model,
						'value'=>$model->isNewRecord ? '' : $model->destino0->nombre,
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

			<div class="row">
				<?php echo $form->labelEx($model,'descripcion'); ?>
				<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>10000)); ?>
				<?php echo $form->error($model,'descripcion'); ?>
			</div>
		</div>

		<div style="margin-left: 100px;display: inline-block !important; vertical-align: 200px;">
			<div class="row">
				<?php echo $form->labelEx($modelpro,'idproveedor'); ?>
				<?php echo $form->hiddenField($model, 'name_prov', array('placeholder'=>'Holo :3')); ?>
				<?php echo $form->hiddenField($modelpro,'idproveedor'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>"prov", // Nombre para el campo de autocompletar
					'model'=>$modelpro,
					'value'=>$modelpro->isNewRecord ? '' : $modelpro->idproveedor0->nombre,
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

			<div class="row">
				<?php echo $form->labelEx($modelpro,'importe'); ?>
				<?php echo $form->textField($modelpro,'importe'); ?>
				<?php echo $form->error($modelpro,'importe'); ?>
			</div><br></br>

			<div class="row">
				<?php echo $form->labelEx($modeldoc,'tipo'); ?>
				<?php echo $form->hiddenField($modeldoc,'tipo'); ?>
				<?php echo $form->dropDownList($modeldoc,'tipo_documentacion',$modeldoc->array_tipo_documentacion,array('empty'=>'Seleccione tipo de documentacion adjunta')); ?><br></br>
				<?php echo $form->textArea($modeldoc,'descripcion',array('style'=>'width:345px;height:150px;margin-top: -20px;font: 13pt Arial;')); ?>
			</div>
		</div>

		<div class="row buttons" style="margin-top:-150px;margin-left: 40px;display:block !important;clear:both !important;">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar', array('class'=>'answer')); ?>
		</div>

		<?php $this->endWidget(); ?>
</div><!-- form -->