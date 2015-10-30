<?php
$this->breadcrumbs=array(
	$model->title,
);
$this->pageTitle=$model->title;
Yii::app()->clientScript->registerMetaTag($model->description, 'description'); 
?>
	 
<?php 
$this->renderPartial('_view', array(
	'data'=>$model,
)); 
?>


