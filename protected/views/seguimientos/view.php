<?php
/* @var $this SeguimientosController */
/* @var $model Seguimientos */

$this->breadcrumbs=array(
	'Seguimientos'=>array('index'),
	$model->id,
);

?>
<style>
	.grid-view-loading
	{
		background:url(/themes/classic/images/loading.gif) no-repeat;
	}

	.grid-view
	{
		padding: 15px 0;
	}

	.grid-view table.items
	{
		background: white;
		border-collapse: collapse;
		width: 100%;
		border: 1px #D0E3EF solid;
	}

	.grid-view table.items th, .grid-view table.items td
	{
		font-size: 13.5pt;
		padding: 0.5em !important;
		border: 1px solid #bbb !important;
		background: #fcfcfc;
	}

	.grid-view table.items th
	{
		color: #434D5F !important;
		background: #eee /*#434D5F url("bg.gif") repeat-x scroll left top white*/;
		text-align: center;
	}

	.grid-view table.items th a
	{
		background: #eee;
		color: #434D5F;
		font-weight: bold;
		text-decoration: none;
	}

	.grid-view table.items th a:hover
	{
		color: #FFF;
	}

	.grid-view table.items th a.asc
	{
		background:url(up.gif) right center no-repeat;
		padding-right: 10px;
	}

	.grid-view table.items th a.desc
	{
		background:url(down.gif) right center no-repeat;
		padding-right: 10px;
	}

	.grid-view table.items tr.even
	{
		background: #F8F8F8;
	}

	.grid-view table.items tr.odd
	{
		background: #E5F1F4;
	}

	.grid-view table.items tr.selected
	{
		background: #BCE774;
	}

	.grid-view table.items tr:hover.selected
	{
		background: #66e0ff;
	}

	.grid-view table.items tbody tr:hover
	{
		background: #ECFBD4;
	}

	.grid-view .link-column img
	{
		border: 0;
	}

	.grid-view .button-column
	{
		text-align: center;
		width: 60px;
	}

	.grid-view .button-column img
	{
		border: 0;
	}

	.grid-view .checkbox-column
	{
		width: 15px;
	}

	.grid-view .summary
	{
		margin: 0 0 5px 0;
		text-align: right;
	}

	.grid-view .pager
	{
		margin: 5px 0 0 0;
		text-align: right;
	}

	.grid-view .empty
	{
		font-style: italic;
	}

	.grid-view .filters input,
	.grid-view .filters select
	{
		font-size: 13.5pt;
		padding: 2px;
		width: 100%;
		border: 1px solid #ccc;
	}
</style>

<h1>Seguimiento nota <?php echo $model->idnota0->getNumeroDeNota($model->idnota); ?></h1>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'idnota',
		'asunto',
		'idnota_referencia',
	),
));*/

#var_dump(gettype($model->search2($model->idnota_referencia))); var_dump($model->search2($model->idnota_referencia));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'seguimientos-grid',
	'template'=>'{items}',
	'htmlOptions'=>array('style'=>'width:1300px !important;font: 13pt Arial !important;'),
	'dataProvider'=>$model->search2($model->idnota_referencia),
	'columns'=>array(
		#'id',
		#'idnota',
		array(
			'header'=>'N° nota',
			'value'=>'$data->idnota0->getNumeroDeNota($data->idnota)',
			'htmlOptions'=>array('style'=>'width: 80px !important;'),
		),
		array(
			'header'=>'Origen',
			'value'=>'$data->aorigen0->nombre',
			'htmlOptions'=>array('style'=>'width: 90px !important;'),
		),
		array(
			'header'=>'Destino',
			'value'=>'$data->adestino0->nombre',
			'htmlOptions'=>array('style'=>'width: 90px !important;'),
		),
		array(
			'header'=>'Fecha realización',
			'value'=>'$data->idnota0->setFecha($data->frealizacion)',
			'htmlOptions'=>array('style'=>'width:90px;'),
		),
		array(
			'header'=>'Fecha envío',
			'value'=>'$data->idnota0->setFecha($data->fenvio)',
			'htmlOptions'=>array('style'=>'width:90px;'),
		),
		array(
			'header'=>'Detalle',
			'value'=>'$data->asunto',
			'htmlOptions'=>array('style'=>'width: 150px !important;'),
		),
		array(
			'header'=>'ID nota referencia',
			'value'=>'$data->idnota_referencia',
			'htmlOptions'=>array('style'=>'width: 80px !important;text-align:center;'),
		),
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
));
?>

<?php
	

	/*echo '<h2>Ingreso en mesa de entrada</h2>';
	#var_dump(gettype($ing->search3($model))); var_dump($ing->search3($model));
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ingresos-grid',
	'htmlOptions'=>array('style'=>'width:1320px !important;font: 13pt Arial !important;'),
	'template'=>'{items}',
	'dataProvider'=>$dataProvider, 'emptyText'=>'Holo :3',
	'columns'=>array(
		/*'id',//
		'a_origen',
		'a_destino',
		'f_registro',
		'f_recibido',
		'detalle',
		'nnota',
	),
));*/ ?>