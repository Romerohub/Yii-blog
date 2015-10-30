<?php
$this->breadcrumbs=array(
	'Privat Msgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PrivatMsgs', 'url'=>array('index')),
	array('label'=>'Manage PrivatMsgs', 'url'=>array('admin')),
);
?>

<h1>Create PrivatMsgs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>