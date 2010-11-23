<?php
$this->menu=array(
	array('label'=>'Edit Profile', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Profile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete your profile including all your files?')),
);
?>

<h2>View Profile: <?php echo $model->username; ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		array('label' => 'Last profile edit', 'value' => ($model->updated > 0) ? date(Yii::app()->params['time_long'], $model->updated) : "No edits performed yet."),
		array('label' => 'Last Login', 'value' => ($model->last_login > 0) ? date(Yii::app()->params['time_long'], $model->last_login) : "This is your first login."),
		'login_count',
		array('label' => 'Join date', 'value' => date(Yii::app()->params['time_long'], $model->created)),
		'failed_login_attempts'
	),
)); ?>
