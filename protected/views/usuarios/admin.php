<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

$this->pageTitle=Yii::app()->name . ' - Administrar usuarios';
$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
	'Administrar usuarios',
);

$this->menu=array(
	array('label'=>'List Usuarios', 'url'=>array('index')),
	array('label'=>'Create Usuarios', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usuarios-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Usuarios</h1>
<br />
<?php echo CHtml::link("Crear nuevo Usuario",array("usuarios/create"),array('class'=>'answer')); ?>
<!--<div class="search-form" style="display:none">
<?php #$this->renderPartial('_search',array(
	#'model'=>$model,
#)); ?>
</div>--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions'=>array('style'=>'width: 1100px;font: 13pt Arial;'),
	'template'=>'{pager} {items} {summary}',
	'pager'=>array('prevPageLabel'=>'<',
				   'nextPageLabel'=>'>',
				   'htmlOptions'=>array('class'=>'miPaginator')
				),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'usuario',
		array(
			'name'=>'contrasenia',
			'filter'=>false,
		),
		'nombre',
		'apellido',
		array(
			'class'=>'CButtonColumn',
			'htmlOptions' => array('style'=>'width:70px !important;'),
			'buttons'=>array
			(
				'view'=>array(
                    'label'=>'<i class="fa fa-eye" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Ver','class'=>'grid-view-links', 'style' =>'color:#264409;margin-right:6px;'),
                    'url'=>'$this->grid->controller->createUrl("usuarios/view", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
				'update'=>array(
                    'label'=>'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Modificar','class'=>'grid-view-links', 'style' =>'color:#514721;margin-right:6px;'),
                    'url'=>'$this->grid->controller->createUrl("usuarios/modificar", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
				'delete'=>array(
                    'label'=>'<i class="fa fa-times" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Eliminar','class'=>'grid-view-l', 'style' =>'color:#8a1f11;'),
                    'url'=>'$this->grid->controller->createUrl("usuarios/delete", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
			),
		),
	),
)); ?>