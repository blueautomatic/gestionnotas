<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Notas pendientes de envío';
$this->breadcrumbs=array(
	'Pendientes de envío',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#notas-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('re-install-date-picker', "
	function reinstallDatePicker(id, data) {
		$('#datepicker_fechaenvio').datepicker(jQuery.datepicker.regional['es'],{'dateFormat':'yy-mm-dd'});
	}
");
?>
<style>
	.grid-view-loading
	{
		background:url(loading.gif) no-repeat;
	}

	.grid-view
	{
		padding: 15px 0;
	}

	.grid-view table.items
	{
		background: #f7f7f7;
		/*border-collapse: collapse;*/
		width: 100%;
		/*border: 1px #D0E3EF solid;*/
		border: 2px solid #8e8e8e !important;
	}

	.grid-view table.items th, .grid-view table.items td
	{
		font-size: 13.5pt;
		border: 1px solid #eeeeee;
		padding: 7px;
	}
	
	.grid-view table.items td {
		padding: 15px !important;
	}

	.grid-view table.items th
	{
		color: #434D5F !important;
		background: #eee;
		/*color: white;
		background: url("bg.gif") repeat-x scroll left top white;*/
		text-align: center;
	}

	.grid-view table.items th a
	{
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
		background: #cde9f4;
		cursor: pointer;
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
		padding: 7px;
		/*width: 100%;*/
		margin:0;
		left:0;
		border: 1px solid #ccc;
	}
</style>
<script>
	$(document).ready(function() {
		/*$(".view-conmicss:contains('No enviada')").addClass("no-enviada");
		$(".view-conmicss:contains('Enviada')").addClass("enviada"); */

		$(".miBtn").click(function() {
			if(this.value === '-') {
				//si está expandido, contraerlo
				open = false;
				this.value = '+';
				$(this).next("div.contenedor").hide("slow");
			}
			else {
				//si está contraido, expanderlo
				open = true;
				this.value = '-';
				$(this).siblings("[value='-']").click();
				$(this).next("div.contenedor").show("slow");
			}
		});
		
		$("div.items a div.view-conmicss input.miBtn.definetly-not-a-link").click(function( event ) {
			event.preventDefault();
		});
		
		/*$("div.view-conmicss input.miBtn.definetly-not-a-link").click(function( event ) {
			event.preventDefault();
			return false;
		});

		$('div.view-conmicss input.miBtn.definetly-not-a-link').each(function () {
			$(this).replaceWith($(this).text());
		});*/
		
		$('.search-button').click(function(){
			if($(this).text() === "-") {
				$(this).text("Búsqueda").attr("title", "");
			} else $(this).text("-").attr("title", "Contraer");
			$('.search-form').toggle("fast");
			return false;
		});
		// || (key.charCode < 95 || key.charCode > 106) ||
		// (key.charCode < 36 || key.charCode > 41) ||  ||
		// key.charCode = 13 || key.charCode = 46
		/*$('#Nota_numeronota').keypress(function(key) {
			if(key.charCode === 13 || key.charCode === 8|| key.charCode === 46 || key.charCode === 37 || key.charCode === 39) return true 
			else if(key.charCode > 47 || key.charCode < 56) return true
		});*/
		
		//Función que hace que los radiobutton sean uncheckable
		(function($){
			$.fn.uncheckableRadio = function() {
				return this.each(function() {
					$(this).mousedown(function() {
						$(this).data('wasChecked', this.checked);

						$(this).click(function() {
							if ($(this).data('wasChecked'))
								this.checked = false;
						});
					});
				});
			};
		})(jQuery);
		$('input[type=radio]').uncheckableRadio();
		
		$("#origen").keyup(function() {
			if($.trim($("#origen").val()) === "")
			{
				$("#Nota_origen").focus().val("");
				$("#Nota_origen").blur();
			}
		});
		
		$("#destino").keyup(function() {
			if($.trim($("#destino").val()) === "")
			{
				$("#Nota_destino").focus().val("");
				$("#Nota_destino").blur();
			}
		});
		
		$("#uIdusuario").keyup(function() {
			if($.trim($("#uIdusuario").val()) === "")
			{
				$("#Nota_usuario_emisor").focus().val("");
				$("#Nota_usuario_emisor").blur();
			}
		});
	});
</script>

<h1>Notas pendientes de envío</h1>
<br />
<?php #echo CHtml::link('Búsqueda','#',array('class'=>'search-button answer','style'=>'text-decoration:none;border-radius:4px;transition: all .5s;')); ?>
<!--<div class="search-form" style="display:none;">
	<?php /*$this->renderPartial('_search',array(
			'model'=>$model,
		));*/
	?>
</div>-->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'notas-grid',
	'htmlOptions'=>array('style'=>'width:1320px;font: 13pt Arial;'),
	'summaryText' => 'Viendo {start}-{end} de {count} notas pendientes de envío.',
	'template'=>'{summary} {pager} ' . '<p></p>' . ' {items} ' . '<p></p>' . ' {pager}',
	'dataProvider'=>$model->search4(),
	'rowCssClassExpression' => '$data->status ? "leido2" : "no-leido2"',
	'emptyText'=>'No hay notas.',
	'pager'=>array(
				   'firstPageLabel'=>'Primera',
				   'prevPageLabel'=>'<',
				   'nextPageLabel'=>'>',
				   'lastPageLabel'=>'Última',
				   'htmlOptions'=>array('class'=>'miPaginator')
				),
	'filter'=>$model,
	'selectionChanged'=>"function(id){
		window.location='" . $this->createUrl('notas/asignarFecha', array('id'=>$model->id)) . "'+$.fn.yiiGridView.getSelection(id);
	}",
	'columns'=>array(
		/*array(
			'header'=>'ID',
			'name'=>'id',
			'value'=>'$data->id',
			'htmlOptions'=>array('style'=>'font-weight:bolder;background-color: #f4db69;width: 38px !important;text-align: center;'),
		),*/
		array(
			'header'=>'N° nota',
			'name'=>'nronota',
			'value'=>'$data->getNumeroDeNota($data->id)',
			'htmlOptions'=>array('style'=>'width: 70px !important;text-align: center;'),
		),
		/*array(
			'name'=>'fechaenvio',
			'header'=>'Enviada el',
			'type'=>'raw',
			'value'=>'$data->setFecha($data->fechaenvio)',
			'htmlOptions'=>array('style'=>'width: 200px !important;text-align: center;'),
			'filter'=>false
		),*/
		array(
			'header'=>'Detalle',
			'name'=>'descripcion',
			'value'=>'$data->descripcion',
			'htmlOptions'=>array('style'=>'width:750px;white-space: nowrap;display:block;overflow:hidden;text-overflow:ellipsis;'),
		),
		/*array(
			'header'=>'Importe',
			'value'=>'$data->notasProveedores[0]->importe',
		),*/
		array(
			'header'=>'Hacia',
			'name'=>'destino',
			'value'=>'Areas::model()->findByPk($data->destino)->nombre',
			'htmlOptions'=>array('style'=>'width: 400px !important;'),
			'filter'=>CHtml::listData(Areas::model()->findAll(array('order'=>"`nombre` ASC")),'id','nombre'),
		),
		/*array(
			'header'=>'Proveedor',
			'type'=>'raw',
			'value'=>'NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id)) ? NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id))->idproveedor0->nombre : ""',
		),
		array(
			'header'=>'Importe',
			'type'=>'raw',
			'value'=>'NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id)) ? NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id))->importe : ""',
		),*/
		/* 'idusuario', */
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
	'afterAjaxUpdate'=>'js:function(id, data){
		reinstallDatePicker(id, data);
		
		$("#datepicker_fechaenvio").datepicker("option","dateFormat","yy-mm-dd");
		if($("#datepicker_fechaenvio").val() == "")
			$(this).blur();
	}'
)); ?>