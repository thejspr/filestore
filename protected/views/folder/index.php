<script type="text/javascript">
function loadFiles(folder_id){
    var folder_element = $('#expand-folder-img-'+folder_id);
    if (folder_element.attr('alt') == "expand") {
        $.ajax({
          url: 'index.php?r=folder/files&id='+folder_id,
          success: function(data) {
            $('#folder-'+folder_id).after(data);
            $(folder_element).attr('src', 'images/folder_close.gif');
            $(folder_element).attr('alt', 'collapse');
            alternateRowColor('#folder-index');
          }
        });
    } else {
       $(".nested-"+folder_id).each(function(){
            $(this).remove();
       });
       $(folder_element).attr('src', 'images/folder_open.gif');
       $(folder_element).attr('alt', 'expand');
       alternateRowColor('#folder-index');
    }
}

$('document').ready(function(){
    alternateRowColor('#folder-index');
    alternateRowColor('#shared-folder-index');
});
</script>
<?php
$this->menu=array(
    array('label'=>'Upload File', 'url'=>array('file/create', 'folderid'=>$root_folder->id)),
	array('label'=>'Create Folder', 'url'=>array('create')),
);
?>

<h1>My Files</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<? if (count($root_files) == 0 && count($folders) == 0 && count($shared_files) == 0) { ?>
    <div class="empty-page">
        You have no files or folders at the moment.<br />
        Create new folders or upload files using the links above.
    </div>
<? } else { ?>
    <? if ( (count($folders) > 0) || (count($root_files) > 0))  { ?>
        <table class="item-list" id="folder-index">
        <thead>
            <th>File/Folder name</th>
            <th class="rightalign">Size</th>
        </thead>
        <? foreach($folders as $folder){ ?>
            <tr id="folder-<?= $folder->id?>">
                <td>
                    <img src="images/icons/folder.png" alt="folder" />
                    <?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))) ?>
                </td>
                <td class="expand-folder">
                    <? if (Folder::model()->hasFiles($folder->id) > 0) { ?>
                        <img onclick="javascript:loadFiles(<?= $folder->id ?>)" id="expand-folder-img-<?= $folder->id?>" src="images/folder_open.gif" alt="expand" />
                    <? } ?>
                </td>
            </tr>
         <? } ?>
        <? foreach($root_files as $file){ ?>
            <tr>
                <td>
                    <img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />
                    <?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
                </td>
                <td class="rightalign"><?= File::model()->format_size($file->file_size) ?></td>
            </tr>
        <? } ?>
        </table>
    <? } ?>
    <? if (count($shared_files) > 0) { ?>
        <br />
        <h3>Files shared with you by other users</h3>
        <table class="item-list" id="shared-folder-index">
        <?foreach ($shared_files as $file) { ?>
            <tr>
                <td>
                    <img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />
                    <?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
                </td>
                <td></td>
            </tr>
        <? } ?>
        </table>
    <? } ?>
<? } ?>