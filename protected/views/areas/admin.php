<?php
/* @var $this AreasController */
/* @var $model Areas */

$this->breadcrumbs=array(
	'Áreas'=>array('admin'),
	'Administrar',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#areas-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Áreas</h1>
<br />
<?php echo CHtml::link("Crear nueva Área",array("areas/create"),array('class'=>'answer')); ?>
<?php #echo CHtml::link('Advanced Search','#',array('class'=>'search-button answer')); ?>
<!--<div class="search-form" style="display:none">
<?php #$this->renderPartial('_search',array(
	#'model'=>$model,
#)); ?>
</div>--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'areas-grid',
	'dataProvider'=>$model->search(),
	'htmlOptions'=>array('style'=>'width: 1100px;font: 13pt Arial;'),
	'template'=>'{pager} {items} {summary}',
	'pager'=>array('prevPageLabel'=>'<',
				   'nextPageLabel'=>'>',
				   'htmlOptions'=>array('class'=>'miPaginator')
				),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'header'=>'ID área',
			'htmlOptions' => array('style'=>'width:70px !important;'),
			'value'=>'$data->id',
		),
		array(
			'name'=>'nombre',
			'header'=>'Nombre',
			'value'=>'$data->nombre',
		),
		array(
			'name'=>'contador',
			'header'=>'Contador utilizado en el N° de nota',
			'htmlOptions' => array('style'=>'width:140px !important;'),
			'value'=>'$data->contador',
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions' => array('style'=>'width:70px !important;'),
			'buttons'=>array
			(
				'view'=>array(
                    'label'=>'<i class="fa fa-eye" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Ver','class'=>'grid-view-links', 'style' =>'color:#264409;margin-right:6px;'),
                    'url'=>'$this->grid->controller->createUrl("areas/view", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
				'update'=>array(
                    'label'=>'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Modificar','class'=>'grid-view-links', 'style' =>'color:#514721;margin-right:6px;'),
                    'url'=>'$this->grid->controller->createUrl("areas/modificar", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
				'delete'=>array(
                    'label'=>'<i class="fa fa-times" aria-hidden="true"></i>',
                    'options'=>array('rel' => 'tooltip', 'title'=>'Eliminar','class'=>'grid-view-l', 'style' =>'color:#8a1f11;'),
                    'url'=>'$this->grid->controller->createUrl("areas/delete", array("id"=>$data->id))',
                    'imageUrl'=>false,
                    #'visible'=>'(Yii::app()->user->checkAccess("crear_notas") || Yii::app()->user->checkAccess("administrar_notas"))?true:false'
                ),
			),
		),
	),
)); ?>
