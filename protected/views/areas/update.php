<?php
/* @var $this AreasController */
/* @var $model Areas */

$this->pageTitle=Yii::app()->name . ' - Actualizar datos del área';
$this->breadcrumbs=array(
	'Áreas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar datos',
);

?>

<h1>Modificar datos del área <strong><em><?php echo $model->nombre; ?></strong></em></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>