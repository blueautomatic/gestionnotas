<?php
/* @var $this AreasController */
/* @var $model Areas */

$this->pageTitle=Yii::app()->name . ' - Ver detalle de área';
$this->breadcrumbs=array(
	'Áreas'=>array('admin'),
	$model->id,
);

?>

<h1>Detalle del área <strong><em><?php echo $model->nombre; ?></em></strong></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'contador',
		array(
			'label'=>'Usuario(s) asociados a esta área',
			'type'=>'raw',
			'value'=>$model->getUsuarios($model->id, $model->nombre),
		),
	),
)); ?>
