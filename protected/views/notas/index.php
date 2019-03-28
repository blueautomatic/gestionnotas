<?php
/* @var $this NotasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Notas',
);

?>

<h1>Notas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>