<?php
$this->breadcrumbs=array(
	'File Shares'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FileShare', 'url'=>array('index')),
	array('label'=>'Create FileShare', 'url'=>array('create')),
	array('label'=>'View FileShare', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FileShare', 'url'=>array('admin')),
);
?>

<h1>Update FileShare <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>