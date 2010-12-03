<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'ef90a239-1e5d-4674-8319-e21f5b0a79ff'});</script>

<?php
if (!Yii::app()->user->isGuest) {
    $menu = array();
    $menu[] = array('label'=>'Download', 'url'=>Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name);

    if (Folder::model()->findByPk($model->folder_id)->public == 1)
        $menu[] = array('label'=>'Back To Folder', 'url'=>array('folder/view', 'id'=>$model->folder_id));
    
    if($model->owner_id == Yii::app()->user->id) {
        $menu[] = array('label'=>'Edit File', 'url'=>array('update', 'id'=>$model->id));
        $menu[] = array('label'=>'Edit Shares', 'url'=>array('shares', 'id'=>$model->id));
        $menu[] = array('label'=>'Delete File', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this file?'));
    }
    $this->menu = $menu;
}
?>

<h1>File Details</h1>

<? if ($this->isImage($model)){ ?>
    <div class="file-image">
        <a href="<?= Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name?>">
        <img src="<?= Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name ?>"
             alt="<?= $model->file_name ?>" title="Click to download"/>
        </a>
    </div>
<? } ?>
<b>File name:</b><br />
<img src="<?= File::model()->getIcon($model->file_name) ?>" class="v-centered" alt="filetype" /> <?= $model->file_name; ?>
<br />
<b>Folder:</b><br />
<?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))); ?>
<br />
<b>Owner:</b><br />
<?= CHtml::link($owner->username, $this->createUrl('user/view', array('id'=>$owner->id))); ?>
<br />
<b>Shared with:</b><br />
<? if (count($shared) > 0) {
    $names = "";
    foreach ($shared as $share) {
        $username = User::model()->findByPk($share->user_id)->username;
        $url = $this->createUrl('user/view',array('id'=>$share->user_id));
        echo "<a href='$url'>$username</a><br />";
    }
} else { ?>
<em>No one</em>
<br />
<? } ?>
<b>Public:</b><br />
<?= $model->public == 1 ? "Yes" : "No" ?>
<br />
<b>Uploaded:</b><br />
<?= date(Yii::app()->params['time_long'],$model->created) ?>
<br />
<b>Last edit:</b><br />
<?= $model->last_edit == 0 ? "Never edited" : date(Yii::app()->params['time_long'],$model->last_edit) ?>
<br />
<? if (File::model()->isPublic($model)) { ?>
<b>Share:</b><br/>
<!-- sharethis -->
    <span class="st_twitter_hcount" displayText="Tweet"></span>
    <span class="st_facebook_hcount" displayText="Share"></span>
<br/>
<? } ?>