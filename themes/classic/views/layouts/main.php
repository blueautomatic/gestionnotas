<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/assets/font-awesome-4.6.3/css/font-awesome.min.css">

	<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/mplogo.png" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<script>
		$(document).ready(function(){
			$("input").attr('autocomplete','off');
		});
	</script>
</head>

<?php Yii::app()->clientScript->registerScript(
	'myHideEffect',
	'$(".flashes").animate({opacity: 1.0}, 7000).fadeOut("slow");',
	CClientScript::POS_READY
); ?>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<a href="<?php echo Yii::app()->baseUrl; ?>"><?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/LogoMuni2016.png"); ?></a>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Cargar', 'url'=>array('/notas/cargar'), 'visible'=>Yii::app()->user->checkAccess('crear_notas')),
				array('label'=>'Recibidas', 'url'=>array('/notas/inbox'), 'visible'=>Yii::app()->user->checkAccess('crear_notas')),
				array('label'=>'Enviadas', 'url'=>array('/notas/outbox'), 'visible'=>Yii::app()->user->checkAccess('crear_notas')),
				array('label'=>'Pendientes de envío', 'url'=>array('/notas/pendientes'), 'visible'=>Yii::app()->user->checkAccess('crear_notas')),
				array('label'=>'Seguimiento de notas', 'url'=>array('/seguimientos/'), 'visible'=>Yii::app()->user->checkAccess('crear_notas')),
				array('label'=>'Áreas', 'url'=>array('/areas/admin'), 'visible'=>Yii::app()->user->checkAccess('administrador')),
				array('label'=>'Usuarios', 'url'=>array('/usuarios/admin'), 'visible'=>Yii::app()->user->checkAccess('administrador')),
				array(
					'label'=>Yii::app()->user->name,
					#'url'=>'#',
					'visible'=>!Yii::app()->user->isGuest,
					'items'=>array(
						array(
							'label'=>Usuarios::model()->getLabel(Yii::app()->user->id),
							'url'=>array('/usuarios/modificar/'  . Yii::app()->user->id),
							'visible'=>!Yii::app()->user->isGuest,
						),
						array(
							'label'=>'Cerrar sesión',
							'url'=>array('/site/logout'),
							'visible'=>!Yii::app()->user->isGuest,
						),
					),
				),
			),
		)); ?>
	</div><!-- mainmenu -->
	
	<?php
		$flashMessages = Yii::app()->user->getFlashes();
		if($flashMessages)
		{
			foreach($flashMessages as $key => $message) {
				if($key == "success") echo '<div class="flashes flash-' . $key . '">&emsp;<i class="fa fa-check-circle" aria-hidden="true"></i>' . html_entity_decode("&emsp;&emsp;") . $message . "</div>\n";
				if($key == "notice") echo '<div class="flashes flash-' . $key . '">&emsp;<i class="fa fa-info-circle" aria-hidden="true"></i>' . html_entity_decode("&emsp;&emsp;") . $message . "</div>\n";
				if($key == "error") echo '<div class="flashes flash-' . $key . '">&emsp;<i class="fa fa-exclamation-circle" aria-hidden="true"></i>' . html_entity_decode("&emsp;&emsp;") . $message . "</div>\n";
			}
		}
	?>

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Gestión de Notas<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>