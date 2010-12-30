<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'ef90a239-1e5d-4674-8319-e21f5b0a79ff'});</script>

<?php
if (!Yii::app()->user->isGuest || $model->public == 1) {
    $menu = array();
    $menu[] = array('label'=>'Download', 'url'=>array('file/get', 'id'=>$model->id));

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
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<? if ($this->isImage($model)){ ?>
    <? $file_path = Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name; ?>
    <div class="file-image">
        <a href="<?= $this->createUrl('file/get', array('id'=>$model->id)) ?>">
        <img src="<?= $file_path ?>"
             alt="<?= $model->file_name ?>" title="Click to download"/>
        </a>
    </div>
<? } ?>
<? if (substr($model->file_name, strlen($model->file_name)-4) == ".mp3") { ?>
   <? $file_path = Yii::app()->params['filesPath'].$model->owner_id.'/'.$model->file_name ?>
    <div id="mp3-player">
        <p><b>Audioplayer</b></p>
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="165" height="38" id="niftyPlayer1" align="">
        <param name=movie value="niftyplayer.swf?file=betty.mp3&as=1">
        <param name=quality value=high>
        <param name=bgcolor value=#FFFFFF>
        <embed src="mp3/niftyplayer.swf?file=<?= $file_path ?>&as=0" quality=high bgcolor=#FFFFFF width="165" height="38" name="niftyPlayer1" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
        </embed>
        </object>
    </div>
<? } ?>
<b>File name:</b><br />
<img src="<?= File::model()->getIcon($model->file_name) ?>" class="v-centered" alt="filetype" /> <?= $model->file_name; ?>
<br />
<? 
$folder = Folder::model()->FindByPk($model->folder_id);
if ($folder->public == 1 || $folder->owner_id == Yii::app()->user->id) { ?>
    <b>Folder:</b><br />
    <?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))); ?>
    <br />
<? } ?>
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
<b>File Size:</b><br />
<?= File::model()->format_size($model->file_size) ?>
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
<br/>
