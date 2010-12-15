<?php
if (!Yii::app()->user->isGuest) {
    $this->menu=array(
        array('label'=>'Upload File', 'url'=>array('file/create', 'folderid'=>$model->id)),
        array('label'=>'Edit Folder', 'url'=>array('update', 'id'=>$model->id)),
    );
    if ($model->owner_id == Yii::app()->user->id)
        $this->menu[] = array('label'=>'Delete Folder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this folder and all the files in it?'));
}
?>
<script>
    $('document').ready(function(){
        alternateRowColor('.item-list');
    });
</script>

<h1>Files in <b><?php echo $model->folder_name; ?></b></h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?= $model->public == 1 ? "<div class='public-msg'>This folder is public and its content is accessible to all users.</div><br />" : ""; ?>
<? if (count($files) > 0) { ?>
    <table class="item-list">
        <thead>
            <th>File name</th>
            <th class="rightalign">Size</th>
        </thead>
        <?foreach ($files as $file) { ?>
            <tr>
                <td>
                    <img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />&nbsp;&nbsp;
                    <?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
                </td>
                <td class="rightalign"><?= File::model()->format_size($file->file_size) ?></td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <div class="empty-page">
        This folder is empty.
    </div>
<? } ?>