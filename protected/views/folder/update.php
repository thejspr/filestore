<?php

$this->menu=array(
	array('label'=>'Create Folder', 'url'=>array('create')),
	array('label'=>'View Folder', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Edit Folder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
