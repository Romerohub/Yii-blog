<?php
$this->breadcrumbs=array(
	'Privat Msgs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PrivatMsgs', 'url'=>array('index')),
	array('label'=>'Create PrivatMsgs', 'url'=>array('create')),
	array('label'=>'View PrivatMsgs', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PrivatMsgs', 'url'=>array('admin')),
);
?>

<h1>Update PrivatMsgs <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>