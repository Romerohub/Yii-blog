<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Ошибка <?php echo $code; ?></h2>

<div class="error">
Нет такой страницы.
<?php //echo CHtml::encode($message); ?>
</div>