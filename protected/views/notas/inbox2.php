<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Bandeja de entrada';
$this->breadcrumbs=array(
	'Inbox',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	var ajaxRequest = $('.search-form form').serialize();
	//#clistview-nota es el CListView
	$.fn.yiiListView.update('clistview-nota', {
		data: ajaxRequest
	});
	return false;
});
");

?>

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

<h1>Bandeja de entrada</h1>
<br />
<?php echo CHtml::link('Búsqueda','#',array('class'=>'search-button','style'=>'text-decoration:none;border-radius:4px;transition: all .5s;')); ?>
<div class="search-form" style="display:none;">
	<?php $this->renderPartial('_search',array(
			'model'=>$model,
		));
	?>
</div>
<br></br>
<?php 
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search2(),
	'itemView'=>'_inboxNota',
	'template'=>'{summary} {pager} {items} {pager}',
	'htmlOptions'=>array('style'=>'width:950px;'),
	'emptyText' => '<span style="width:190px;padding:10px;position:absolute;left:50%;top:28%;background-color: #ccc;">No hay notas recibidas.</span>',
	'id'=>'clistview-nota',
	'pager'=>array('prevPageLabel'=>'<',
				   'nextPageLabel'=>'>',
				   'htmlOptions'=>array('class'=>'miPaginator')
				),
	'afterAjaxUpdate'=>'js:function(id, data){
		$(document).ready(function(){

			$(\'.view-conmicss.enviada a.definetly-not-a-link\').click(function( event ) {
				event.preventDefault();
				return false;
			});

			$(\'.view-conmicss.enviada a.definetly-not-a-link\').each(function () {
				$(this).replaceWith($(this).text());
			});
			
			$("div.items a div.view-conmicss input.miBtn.definetly-not-a-link").click(function( event ) {
				event.preventDefault();
			});
			
			$(".miBtn").click(function() {
				if(this.value === \'-\') {
					//si está expandido, contraerlo
					open = false;
					this.value = \'+\';
					$(this).next("div.contenedor").hide("slow");
				}
				else {
					//si está contraido, expanderlo
					open = true;
					this.value = \'-\';
					$(this).siblings("[value=\'-\']").click();
					$(this).next("div.contenedor").show("slow");
				}
			});
		});
	}'
)); 
?>