<?php
/* @var $this SeguimientosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seguimientoses',
);

$this->menu=array(
	array('label'=>'Create Seguimientos', 'url'=>array('create')),
	array('label'=>'Manage Seguimientos', 'url'=>array('admin')),
);
?>

<h1>Seguimientoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>