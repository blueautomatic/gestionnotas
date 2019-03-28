<?php
/* @var $this NotasController */
/* @var $model Notas */

$this->pageTitle=Yii::app()->name . ' - Cargar nota';
$this->breadcrumbs=array(
	'Notas'=>array('inbox'),
	'Cargar nota',
);

/*$this->menu=array(
	array('label'=>'List Notas', 'url'=>array('index')),
	array('label'=>'Manage Notas', 'url'=>array('admin')),
);*/
?>

<script>
	$(document).ready(function(){
		$("#Notas_fechaenvio").dblclick(function(){
			$("#Notas_fechaenvio").removeAttr("readonly","false");
		});
	});
</script>

<h1>Cargar datos de la nota</h1><br />

<?php $this->renderPartial('_cargar', array('model'=>$model,'modelseg'=>$modelseg, 'modeldoc'=>$modeldoc, 'modelpro'=>$modelpro)); ?>