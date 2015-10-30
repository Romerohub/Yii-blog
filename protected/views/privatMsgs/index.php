<?php
$this->breadcrumbs=array(
	'Privat Msgs',
);

$this->menu=array(
	array('label'=>'Create PrivatMsgs', 'url'=>array('create')),
	array('label'=>'Manage PrivatMsgs', 'url'=>array('admin')),
);
?>

<h1>Privat Msgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
