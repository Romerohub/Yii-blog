<?php
$this->breadcrumbs=array(
	'Privat Msgs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PrivatMsgs', 'url'=>array('index')),
	array('label'=>'Create PrivatMsgs', 'url'=>array('create')),
	array('label'=>'Update PrivatMsgs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PrivatMsgs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PrivatMsgs', 'url'=>array('admin')),
);
?>

<h1>View PrivatMsgs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_add',
		'name',
		'email',
		'msg_text',
	),
)); ?>
