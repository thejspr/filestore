<?
$this->menu=array(
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h2>Users</h2>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
