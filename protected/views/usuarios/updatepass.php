<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->pageTitle=Yii::app()->name . ' - Cambiar contraseña';
$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Cambiar contraseña',
	$model->usuario=>array('view','id'=>$model->id),
);

?>

<h1>Cambiar contraseña</h1></br>

<?php 
	$this->renderPartial('_form2', array('model'=>$model));
?>