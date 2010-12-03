<?php
$this->menu=array(
	array('label'=>'View Profile', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Edit Profile: <?= $model->username ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
