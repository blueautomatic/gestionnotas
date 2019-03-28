<?php
/* @var $this AreasController */
/* @var $model Areas */

$this->pageTitle=Yii::app()->name . ' - Crear nueva área';
$this->breadcrumbs=array(
	'Áreas'=>array('admin'),
	'Crear',
);

?>

<h1>Crear área</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>