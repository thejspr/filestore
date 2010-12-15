<?php
if (Yii::app()->user->id == $model->id) {
    $this->menu=array(
        array('label'=>'Edit Profile', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Delete Profile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete your profile including all your files?')),
    );
}
?>

<h1>View Profile</h1>
<div class="profile">
<?php 
if ($model->id == Yii::app()->user->id) {
    $this->widget('zii.widgets.CDetailView', array(
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
    )); 
} else {
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'username',
            'email',
            array('label' => 'Last Login', 'value' => ($model->last_login > 0) ? date(Yii::app()->params['time_long'], $model->last_login) : "This is your first login."),
            array('label' => 'Join date', 'value' => date(Yii::app()->params['time_long'], $model->created)),
        ),
    ));
}
?>
</div>