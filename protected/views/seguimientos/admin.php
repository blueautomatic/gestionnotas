<?php
/* @var $this SeguimientosController */
/* @var $model Seguimientos */

$this->breadcrumbs=array(
	'Notas'=>array('notas/inbox'),
	'Seguimientos',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#seguimientos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

#Yii::app()->clientscript->scriptMap['jquery.js'] = false;
?>

<script>
	$(document).ready(function(){
		$("#Seguimientos_date_first").dblclick(function(){
			$("#Seguimientos_date_first").focus().val("");
		});
		
		$("#Seguimientos_date_last").dblclick(function(){
			$("#Seguimientos_date_last").focus().val("");
		});
	});
</script>

<style>
	.grid-view-loading
	{
		background:url(themes/classic/images/loading.gif) no-repeat;
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

<h1>Seguimiento de notas</h1>
<br />
<?php echo CHtml::link("Exportar a Excel",array("seguimientos/excel"),array('class'=>'answer')); ?>
<?php #echo CHtml::link('Búsqueda avanzada','#',array('class'=>'search-button answer')); ?>
<!--<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ 

$dateisOn = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		/*'model'=>$model,
		'attribute' => 'date_first',*/
		'name' => 'Seguimientos[date_first]',
		'value' => $model->date_first,
		'language'=>'es',
		'options'=>array(
			'showAnim'=>'fold',
			'dateFormat'=>'yy-mm-dd',
			'changeMonth' => 'true',
			'changeYear'=>'true',
			'constrainInput' => 'false',
			#'onClose' => 'js:function(selectedDate) { $("#Notas_date_last").datepicker("option", "minDate", selectedDate); }',
		),
		'htmlOptions'=>array(
			'style'=>'height:20px;width:120px;', #'readonly'=>true,
			'placeholder'=>'Desde',
		),
	),true) /*. '<br> a <br> '*/ .
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		/*'model'=>$model,
		'attribute' => 'date_last',*/
		'name' => 'Seguimientos[date_last]',
		'value' => $model->date_last,
		'language'=>'es',
		'options'=>array(
			'showAnim'=>'fold',
			'dateFormat'=>'yy-mm-dd',
			'changeMonth' => 'true',
			'changeYear'=>'true',
			'constrainInput' => 'false',
			'minDate' => 'Seguimientos[date_first]',
		),
		'htmlOptions'=>array(
			'style'=>'height:20px;width:120px', #'readonly'=>true,
			'placeholder'=>'Hasta',
		),
	),true);

?>
</div>--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'seguimientos-grid',
	'htmlOptions'=>array('style'=>'width:1320px !important;font: 13pt Arial !important;'),
	'summaryText' => 'Viendo {start}-{end} de {count} seguimientos.',
	'template'=>'{summary} {pager} ' . '<p></p>' . ' {items} ' . '<p></p>' . ' {pager}',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectionChanged'=>'function(id){
		jQuery.ajax({
			"url": "' . $this->createUrl('view') . '/"+$.fn.yiiGridView.getSelection(id),
			"type":"POST",
			"success":function(content)
			{
				$("#detailsDialog").html(content).dialog("open");
				return false;
			}
		});
	}',
	/*'selectionChanged'=>'js:function(id){
		n = $.fn.yiiGridView.getSelection(id);
		if (n>0){
			$.ajax({
				url: "'.Yii::app()->urlManager->createUrl('seguimientos/view/').'",
				type: "GET",
				data: {"id": parseInt(n)},
				dataType: "html",
				done: function(data) {
					$("#detailsDialog").html(data).dialog("open");
					
				}
			});
		}
	}',*/
	'emptyText'=>'Ingrese datos en los filtros de búsqueda.',
	'pager'=>array(
				   'firstPageLabel'=>'Primera',
				   'prevPageLabel'=>'<',
				   'nextPageLabel'=>'>',
				   'lastPageLabel'=>'Última',
				   'htmlOptions'=>array('class'=>'miPaginator')
				),
	'columns'=>array(
		#'id',
		#'idnota',
		array(
			'header'=>'N° nota',
			'name'=>'idnota0.nronota',
			'value'=>'$data->idnota0->getNumeroDeNota($data->idnota)',
			'htmlOptions'=>array('style'=>'width: 100px !important;text-align: center;'),
			'filter'=>CHtml::activeTextField($model->notamod, 'nronota'),
		),
		array(
			'header'=>'Fecha envío',
			'name'=>'fenvio',
			'value'=>'$data->idnota0->setFecha($data->fenvio)',
			'filter'=>$dateisOn,
			'htmlOptions'=>array('style'=>'width:150px;'),
		),
		array(
			'header'=>'Desde',
			'visible'=>Notas::model()->checkVisible() ? true : false,
			'name'=>'origenCustom',
			'value'=>'$data->aorigen0->nombre',
			'filter'=>$model->getListaAreas(),
		),
		array(
			'header'=>'Hacia',
			'name'=>'adestino',
			'value'=>'$data->adestino0->nombre',
			'filter'=>CHtml::listData(Areas::model()->findAll(array('order'=>"`nombre` ASC")),'id','nombre'),
		),
		array(
			'header'=>'Detalle',
			'name'=>'asunto',
		),
		/*array(
			'header'=>'ID nota referencia',
			'name'=>'idnota_referencia',
			'value'=>'$data->idnota_referencia',
		),*/
		array(
			'type'=>'html',
			'value'=>'CHtml::image(Yii::app()->theme->baseUrl . "/images/file.png", "", array("style"=>"width: 30px !important;"))',
			'htmlOptions'=>array('style'=>'cursor:pointer !important;', "title"=>"Ver seguimiento"),
		),
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
	'afterAjaxUpdate'=>'js:function(id, data){
		$(document).ready(function(){
			$("#Seguimientos_date_first").dblclick(function(){
				$("#Seguimientos_date_first").focus().val("");
			});

			$("#Seguimientos_date_last").dblclick(function(){
				$("#Seguimientos_date_last").focus().val("");
			});
		});

		$.fn.yiiGridView.settings[id].selectionChanged(id);

		jQuery("#Seguimientos_date_first").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["es"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeMonth":"true","showButtonPanel":"true","changeYear":"true","constrainInput":"false"}));
		jQuery("#Seguimientos_date_last").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["es"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeMonth":"true","showButtonPanel":"true","changeYear":"true","constrainInput":"false"}));
	}'
));

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	'id'=>'detailsDialog',
	// opciones javascript adicionales para el plugin del cuadro de diálogo CJuiDialog
	'options'=>array(
		'title'=>'Detalles',
		'width'=>'auto',
		'height'=>'auto',
		'language'=>'es',
		'autoOpen'=>false,
	),
));

$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>