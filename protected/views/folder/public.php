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
            alternateRowColor('#public-index');
          }
        });
    } else {
       $(".nested-"+folder_id).each(function(){
            $(this).remove();
       });
       $(folder_element).attr('src', 'images/folder_open.gif');
       $(folder_element).attr('alt', 'expand');
       alternateRowColor('#public-index');
    }
}

$('document').ready(function(){
    alternateRowColor('#public-index');
});
</script>
<?php
if (!Yii::app()->user->isGuest) {
    $this->menu=array(
        array('label'=>'Upload File', 'url'=>array('file/create', 'public'=>1)),
    	array('label'=>'Create Folder', 'url'=>array('create', 'public'=>1)),
    	array('label'=>'RSS Feed', 'url'=>array('folder/rss')),
    );
} else {
    $this->menu=array(
        array('label'=>'RSS Feed', 'url'=>array('folder/rss')),
    );
}
?>

<h1>Public Files</h1>

<? if (count($files) == 0 && count($folders) == 0) { ?>
    <div class="empty-page">
        You have no files or folders at the moment.<br />
        Create new folders or upload files using the links above.
    </div>
<? } else { ?>
<table class="item-list" id="public-index">
    <thead>
        <th>File/Folder name</th>
        <th class="rightalign">Size</th>
    </thead>
<?
foreach($folders as $folder){ ?>
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
<?
foreach($files as $file){ ?>
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