<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
	'Crear',
);

?>

<h1>Crear nuevo usuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'modelua'=>$modelua)); ?>