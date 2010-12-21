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
    <b>Username:</b><br />
        <?= $model->username ?>
    <br />
    <b>Email:</b><br />
        <?= $model->email ?>
    <br />
    <?php if ($model->id == Yii::app()->user->id) { ?>
        <b>Free Storage Space:</b><br />
            <?= File::model()->format_size($model->storage_left) ?> of 100MB
        <br />
        <b>Last Profile Edit:</b><br />
            <?= date(Yii::app()->params['time_long'],$model->updated) ?>
        <br />
        <b>Last Login:</b><br />
            <?= date(Yii::app()->params['time_long'],$model->last_login) ?>
        <br />
        <b>Logins:</b><br />
            <?= $model->login_count ?>
        <br />
        <b>Join Date:</b><br />
            <?= date(Yii::app()->params['time_long'],$model->created) ?>
        <br />
        <b>Failed Login Attempts:</b><br />
            <?= $model->failed_login_attempts ?>
        <br />
    <? } ?>
</div>