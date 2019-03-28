<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Notas enviadas';
$this->breadcrumbs=array(
	'Outbox',
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
		
		$("#prov_filtro").dblclick(function(){
			if($.trim($("#prov_filtro").val()) === "")
			{
				$("#NotasProveedores_idproveedor").focus().val("");
			}
		});
		
		$("#Notas_date_first").dblclick(function(){
			$("#Notas_date_first").focus().val("");
		});
		
		$("#Notas_date_last").dblclick(function(){
			$("#Notas_date_last").focus().val("");
		});
	});
</script>

<h1>Notas enviadas</h1>
<br />
<?php echo CHtml::link("Exportar a Excel",array("notas/excel"),array('class'=>'answer')); ?> &emsp;&emsp;&emsp;
<?php #echo CHtml::link('Búsqueda','#',array('class'=>'search-button answer','style'=>'text-decoration:none;border-radius:4px;transition: all .5s;')); ?>
<!--<div class="search-form" style="display:none;">
	<?php /*$this->renderPartial('_search',array(
			'model'=>$model,
		));*/
	?>
</div>-->

<?php
// this is the date picker
$dateisOn = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		/*'model'=>$model,
		'attribute' => 'date_first',*/
		'name' => 'Notas[date_first]',
		'value' => $model->date_first,
		'language'=>'es',
		'options'=>array(
		'showAnim'=>'fold',
		'dateFormat'=>'yy-mm-dd',
		'changeMonth' => 'true',
		'changeYear'=>'true',
		'constrainInput' => 'false',
	),
		'htmlOptions'=>array(
			'style'=>'height:20px;width:120px;',
			'placeholder'=>'Desde',
		),
	),true) /*. '<br> a <br> '*/ .
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		/*'model'=>$model,
		'attribute' => 'date_last',*/
		'name' => 'Notas[date_last]',
		'value' => $model->date_last,
		'language'=>'es',
		'options'=>array(
		'showAnim'=>'fold',
		'dateFormat'=>'yy-mm-dd',
		'changeMonth' => 'true',
		'changeYear'=>'true',
		'constrainInput' => 'false',
	),
		'htmlOptions'=>array(
			'style'=>'height:20px;width:120px',
			'placeholder'=>'Hasta',
		),
	),true);

$autoCompletar = CHtml::activeHiddenField($model->prov, 'idproveedor') . $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	'name'=>"prov_filtro", // Nombre para el campo de autocompletar
	'model'=>$model,
	'value'=>$model->isNewRecord ? '' : $model->prov->idproveedor0->nombre,
	'source'=>$this->createUrl('notasproveedores/autocomplete'), // URL que genera el conjunto de datos
	#'htmlOptions'=>array_merge($disabled,array('size'=>'60','title'=>'Ingrese Producto/Medicamento y su lote')),
	'options'=>array(
		'showAnim'=>'fold',
		'size'=>'50',
		'minLenght'=>'1', // Mínimo de caracteres que hay que digitar antes de realizar la búsqueda
		'select'=>'js:function(event, ui){
			$("#NotasProveedores_idproveedor").val(ui.item.id);
		}'
	),
	'htmlOptions'=>array(
		'size'=>'35',
		'placeholder'=>'Ingrese proveedor',
	),
),true);

$filtroProv = CHtml::activeTextField($model, 'importeA', array('placeholder'=>'Desde')) . CHtml::activeTextField($model, 'importeB', array('placeholder'=>'Hasta'));

?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'notas-grid',
	'htmlOptions'=>array('style'=>'width:1320px;font: 13pt Arial;'),
	'summaryText' => 'Viendo {start}-{end} de {count} notas enviadas.',
	'template'=>'{summary} {pager} ' . '<p></p>' . ' {items} ' . '<p></p>' . ' {pager}',
	'dataProvider'=>$model->search3(),
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
		window.location='" . $this->createUrl('notas/ver') . "/'+$.fn.yiiGridView.getSelection(id);
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
			'htmlOptions'=>array('style'=>'width: 100px !important;text-align: center;'),
		),
		/*array(
			'name'=>'fechaenvio',
			'header'=>'Enviada el',
			'type'=>'raw',
			'value'=>'$data->setFecha($data->fechaenvio)',
			'htmlOptions'=>array('style'=>'width: 170px !important;text-align: center;'),
			'filter'=>false,/*$this->widget('zii.widgets.jui.CJuiDatePicker',
				array(
					'model'=>$model,
					'attribute'=>'fechaenvio',
					'language'=>'es',
					'htmlOptions'=>array(
						'id' => 'datepicker_fechaenvio',
						'size' => '10',
					),
					#'value'=>date('d/m/Y'),
					'options'=>array(
						'dateFormat'=>'yy-mm-dd',
						'constraintInput'=>'true',
						'duration'=>'slow',
						'selectOtherMonths'=>true,
						'showOtherMonths'=>true,
						'changeMonth'=>'true',
						'changeYear'=>'true',
						'showAnim'=>'fade',
						#'minDate'=>date('Y-m-d'),
					),),
			true),*
		),*/
		array(
			'name'=>'fechaenvio',
			'value'=>'$data->setFecha($data->fechaenvio)',
			'filter'=>$dateisOn,
			#'value'=>'$data->fechaenvio'
			'htmlOptions'=>array('style'=>'width:150px;'),
		),
		array(
			'header'=>'Detalle',
			'name'=>'descripcion',
			'value'=>'$data->descripcion',
			'htmlOptions'=>array('style'=>'width: 500px !important;white-space: nowrap;display:block;overflow:hidden;text-overflow:ellipsis;'),
		),
		/*array(
			'header'=>'Importe',
			'value'=>'$data->notasProveedores[0]->importe',
		),*/
		array(
			'header'=>'Hacia',
			'name'=>'destino',
			'value'=>'Areas::model()->findByPk($data->destino)->nombre',
			'htmlOptions'=>array('style'=>'width: 200px !important;'),
			'filter'=>CHtml::listData(Areas::model()->findAll(array('order'=>"`nombre` ASC")),'id','nombre'),
		),
		array(
			'header'=>'Proveedor',
			'name'=>'notasProveedores.idproveedor',
			'type'=>'raw',
			'value'=>'NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id)) ? NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id))->idproveedor0->nombre : ""',
			'filter'=>$autoCompletar,
		),
		array(
			'header'=>'Importe',
			'name'=>'notasProveedores.importe',
			'type'=>'raw',
			'value'=>'NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id)) ? NotasProveedores::model()->cambiarPuntoPorComa(NotasProveedores::model()->findByAttributes(array(\'idnota\'=>$data->id))->importe) : ""',
			'filter'=>$filtroProv,
		),
		array(
			'header'=>'Área',
			'visible'=>$model->checkVisible() ? true : false,
			'name'=>'destinoCustom',
			'type'=>'raw',
			'filter'=>$model->checkVisible() ? $model->getListaAreas() : false,
		),
		/* 'idusuario', */
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
	'afterAjaxUpdate'=>'js:function(id, data){
		jQuery("#Notas_date_first").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["es"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeMonth":"true","showButtonPanel":"true","changeYear":"true","constrainInput":"false"}));
		jQuery("#Notas_date_last").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["es"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeMonth":"true","showButtonPanel":"true","changeYear":"true","constrainInput":"false"}));
		
		jQuery("#prov_filtro").autocomplete({
			"delay":300,
			"minLenght":1,
			"source":"' . $this->createUrl('notasproveedores/autocomplete') . '",
			"focus":function(event, ui) {
				$("#NotasProveedores_idproveedor").val(ui.item.id);
			},
			"select":function(event, ui) {
				$.fn.yiiGridView.update("notas-grid", {
					data: $("#notas-grid .filters input, #notas-grid .filters select").serialize()
				});
			}
		});
		
		$("#prov_filtro").dblclick(function(){
			if($.trim($("#prov_filtro").val()) === "")
			{
				$("#NotasProveedores_idproveedor").focus().val("");
			}
		});
		
		$("#Notas_date_first").dblclick(function(){
			$("#Notas_date_first").focus().val("");
		});
		
		$("#Notas_date_last").dblclick(function(){
			$("#Notas_date_last").focus().val("");
		});
	}'
)); ?>