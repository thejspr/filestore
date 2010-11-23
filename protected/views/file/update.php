<?php

$this->menu=array(
	array('label'=>'Upload File', 'url'=>array('create')),
	array('label'=>'View File', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update File <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'folders'=>$folders)); ?>
