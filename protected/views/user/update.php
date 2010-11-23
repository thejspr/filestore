<?php
$this->menu=array(
	array('label'=>'View Profile', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h2>Edit Profile: <?= $model->username ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
