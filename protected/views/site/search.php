<script type="text/javascript">
$('document').ready(function(){
    alternateRowColor('tr');
});
</script>
<?php
$this->menu=array(
    array('label'=>'Upload File', 'url'=>array('file/create')),
	array('label'=>'Create Folder', 'url'=>array('folder/create')),
);
?>

<h1>Search results</h1>

<? if (count($files) == 0 && count($folders) == 0) { ?>
    <div class="empty-page">
        Your search for <b><?= $query ?></b> came up empty.
    </div>
<? } else { ?>
    <p>A search for <b><?= $query ?></b> yielded the following results:</p>
    <br/>
    <table class="item-list">
        <? foreach($folders as $folder){ ?>
            <tr id="folder-<?= $folder->id?>">
                <td>
                    <img src="images/icons/folder.png" alt="folder" />
                    <?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))) ?>
                </td>
            </tr>
         <? } ?>
        <? foreach($files as $file){ ?>
            <tr>
                <td>
                    <img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />
                    <?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
                </td>
            </tr>
        <? } ?>
    </table>
<? } ?>