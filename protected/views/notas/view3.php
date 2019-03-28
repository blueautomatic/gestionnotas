<?php
/* @var $this NotasController */
/* @var $model Notas */

$this->pageTitle = Yii::app()->name . ' — ' . $model->getNumeroDeNota($model->nronota) . ' - ' . $model->origen0->nombre;
$this->breadcrumbs=array(
	'Notas'=>array('index'),
	$model->getNumeroDeNota($model->nronota) . ' - ' . $model->origen0->nombre,
);

/*$this->menu=array(
	array('label'=>'List Notas', 'url'=>array('index')),
	array('label'=>'Create Notas', 'url'=>array('create')),
	array('label'=>'Update Notas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notas', 'url'=>array('admin')),
);*/
?>
<script>
	$(document).ready(function(){
		$("#Notas_fechaenvio").val("");
	});
</script>

<style>
	.grid-view-loading
	{
		background:url(loading.gif) no-repeat;
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
		background: #66e0ff;
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

<h1 class="answer">Nota &nbsp;<?php echo $model->getNumeroDeNota($model->nronota); ?> &emsp;</h1>

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
	'htmlOptions'=>array('style'=>'width:1340px;'),
	'dataProvider'=>$model->search(),
	'summaryText'=>false,
	//'filter'=>$model,
	//'cssFile' => Yii::app()->theme->baseUrl . '/classic/css/grid-view-custom-style.css',
	'columns'=>array(
		array(
			'header'=>'ID',
			'value'=>'$data->id',
			'htmlOptions'=>array('style'=>'font-weight:bolder;background-color: #f4db69;width: 50px !important;text-align: center;'),
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
			'type'=>'raw',
			'value'=>'$data->setFecha($data->fechaenvio)',
			'htmlOptions'=>array('style'=>'width: 150px !important;text-align: center;'),
		),
		array(
			'header'=>'Hacia',
			'value'=>'$data->destino0->nombre',
			'htmlOptions'=>array('style'=>'width: 200px !important;'),
		),
		array(
			'header'=>'Descripción',
			'value'=>'$data->descripcion',
			'htmlOptions'=>array('style'=>'width: 350px !important;'),
		),
		array(
			'header'=>'Observaciones',
			'value'=>'$data->observaciones',
			'htmlOptions'=>array('style'=>'width: 340px !important;'),
		),
		//'idusuario',
	),
)); ?>

	<div class="form" style="width:1000px;">
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

		<?php echo $form->errorSummary(array($model)); ?>
	
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
		</div><br></br>

		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Asignar fecha' : 'Asignar fecha', array('class'=>'answer')); ?>
		</div>

		<?php $this->endWidget(); ?>
	</div><!-- form -->