<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<br></br>
<h1 style="text-align:center;">Error <?php echo $code; ?></h1>

<div class="error" style="font-size: 15pt;text-align:center;">
<?php echo CHtml::encode($message); ?>
</div><br></br>