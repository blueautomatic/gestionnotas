<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

$this->pageTitle=Yii::app()->name . ' - Ver datos del usuario';
$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
	$model->id,
);

?>

<h1>Ver detalle el usuario <strong><em><?php echo $model->nombre . ' ' . $model->apellido; ?></em></strong></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'usuario',
		'contrasenia',
		'nombre',
		'apellido',
		array(
			'label'=>'Área(s) del usuario',
			'type'=>'raw',
			'value'=>$model->getAreas($model->id),
		),
	),
)); ?><br /><br />

<div>
	<h2>Asignar/quitar roles de usuario</h2>
	<div id="rol-col">
		<?php foreach(Yii::app()->authManager->getAuthItems() as $data): ?>
			<div><br></br>
				<?php $habilitado = Yii::app()->authManager->checkAccess($data->name, $model->id); ?>
				<?php $habilitado ? $clase = "habilitado" : $clase = "deshabilitado"; ?>
				<?php echo CHtml::link($habilitado ? "Quitar":"Asignar", array("usuarios/asignarRol","id"=>$model->id,"item"=>$data->name), array("class"=>$clase)); ?>
			</div>
			<div class="rol-container">
				<div class="rol-col">
					<?php echo $data->name; ?>
					<small style="color: #cdcdcd;">
						<?php if($data->type == 2) echo "Rol"; ?>
						<?php if($data->type == 1) echo "Tarea"; ?>
						<?php if($data->type == 0) echo "Operación"; ?>
						<?php echo $habilitado ? " | <span style=\"color:LightCoral\">Habilitado</span> ":" " ?>
					</small>
				</div>
				<div class="rol-col">
					<small title="Descripción">	
						<?php echo $data->description; ?>
					</small>
				</div><br />
			</div>
		<?php endforeach; ?>
	</div>
</div>