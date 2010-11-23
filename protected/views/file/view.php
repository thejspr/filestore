<?php

$this->menu=array(
	array('label'=>'Upload File', 'url'=>array('create')),
	array('label'=>'Edit File', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete File', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h2>View File: <?php echo $model->file_name; ?></h2>

<? if ($this->isImage($model)){ ?>
    <div class="file-image">
        <img src="<?= Yii::app()->params['filesPath'].$model->folder_id.'/'.$model->file_name ?>"
             alt="<?= $model->file_name ?>" />
    </div>
<? } ?>

<b>Folder:</b><br />
<?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))); ?>
<br />
<b>Owner:</b><br />
<?= CHtml::link($owner->username, $this->createUrl('user/view', array('id'=>$owner->id))); ?>
<br />
<b>Public:</b><br />
<?= $model->public == 1 ? "Yes" : "No" ?>
<br />
<b>Uploaded:</b><br />
<?= date(Yii::app()->params['time_long'],$model->created) ?>
<br />
<b>Last edit:</b><br />
<?= $model->last_edit == 0 ? "Never edited" : date(Yii::app()->params['time_long'],$model->last_edit) ?>
<br />