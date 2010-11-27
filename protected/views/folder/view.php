<?php

$this->menu=array(
    array('label'=>'Upload File', 'url'=>array('file/create', 'folderid'=>$model->id)),
	array('label'=>'Edit Folder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Folder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this folder and all the files in it?')),
);
?>

<h1>Files in <b><?php echo $model->folder_name; ?></b></h1>
<?= $model->public == 1 ? "<em><span style='color:green;'>This folder is public</span></em>" : ""; ?>
<br /><br />
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