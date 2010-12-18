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
        <b>Last Profile Edit:</b><br />
            <?= $model->updated ?>
        <br />
        <b>Last Login:</b><br />
            <?= $model->last_login ?>
        <br />
        <b>Logins:</b><br />
            <?= $model->login_count ?>
        <br />
        <b>Join Date:</b><br />
            <?= $model->created ?>
        <br />
        <b>Failed Login Attempts:</b><br />
            <?= $model->failed_login_attempts ?>
        <br />
    <? } ?>
</div>