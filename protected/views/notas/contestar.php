<?php
/* @var $this NotasController */
/* @var $model Notas */

$this->breadcrumbs=array(
	'Notas'=>array('index'),
	'Carga de datos',
);

/*$this->menu=array(
	array('label'=>'List Notas', 'url'=>array('index')),
	array('label'=>'Manage Notas', 'url'=>array('admin')),
);*/
?>

<h1>Cargar datos de la nota</h1><br />

<?php $this->renderPartial('_contestar', array('model'=>$model,'modelseg'=>$modelseg, 'modeldoc'=>$modeldoc, 'modelpro'=>$modelpro)); ?>