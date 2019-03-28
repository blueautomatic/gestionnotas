<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->pageTitle=Yii::app()->name . ' - Modificar datos de usuario';
$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	'Modificar datos de usuario',
	$model->usuario=>array('view','id'=>$model->id),
);

?>

<h1>Modificar los datos del usuario <strong><em><?php echo $model->nombre . ' ' . $model->apellido; ?></em></strong></h1></br>

<?php 
	$this->renderPartial('_form', array('model'=>$model,'modelua'=>$modelua));
?>