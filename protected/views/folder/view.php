<?php
if (!Yii::app()->user->isGuest) {
    $this->menu=array(
        array('label'=>'Upload File', 'url'=>array('file/create', 'folderid'=>$model->id)),
        array('label'=>'Edit Folder', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Delete Folder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this folder and all the files in it?')),
    );
}
?>

<h1>Files in <b><?php echo $model->folder_name; ?></b></h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?= $model->public == 1 ? "<div class='public-msg'>This folder is public and its content is accessible to all users.</div>" : ""; ?>
<br /><br />
<? if (count($files) > 0) { ?>
    <table id="folder-list">
        <?foreach ($files as $file) { ?>
            <tr>
                <td>
                    <img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />&nbsp;&nbsp;
                    <?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
                </td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <div class="empty-page">
        This folder is empty.
    </div>
<? } ?>