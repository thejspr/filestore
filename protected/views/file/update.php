<?php

$this->menu=array(
    array('label'=>'Back', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Edit Shares', 'url'=>array('shares', 'id'=>$model->id)),
    array('label'=>'Delete File', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this file?')),
	array('label'=>'Upload New File', 'url'=>array('create')),
);
?>

<h1>Update File</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'folders'=>$folders)); ?>
