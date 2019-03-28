<?php
/* @var $this SeguimientosController */
/* @var $model Seguimientos */

$this->breadcrumbs=array(
	'Seguimientoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Seguimientos', 'url'=>array('index')),
	array('label'=>'Manage Seguimientos', 'url'=>array('admin')),
);
?>

<h1>Create Seguimientos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>