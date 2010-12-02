<script type="text/javascript">
function alternateRowColor(selector) {
    $(selector+':even').each(function(){
        $(this).css("background-color", "#FFF")
    });
    $(selector+':odd').each(function(){
        $(this).css("background-color", "#E6F2FF")
    });
}

function loadFiles(folder_id){
    var folder_element = $('#expand-folder-img-'+folder_id);
    if (folder_element.attr('alt') == "expand") {
        $.ajax({
          url: 'index.php?r=folder/files&id='+folder_id,
          success: function(data) {
            $('#folder-'+folder_id).after(data);
            $(folder_element).attr('src', 'images/folder_close.gif');
            $(folder_element).attr('alt', 'collapse');
            alternateRowColor('tr');
          }
        });
    } else {
       $(".nested-"+folder_id).each(function(){
            $(this).remove();
       });
       $(folder_element).attr('src', 'images/folder_open.gif');
       $(folder_element).attr('alt', 'expand');
       alternateRowColor('tr');
    }
}

$('document').ready(function(){
    alternateRowColor('tr');
});
</script>
<?php
$this->menu=array(
    array('label'=>'Upload File', 'url'=>array('file/create')),
	array('label'=>'Create Folder', 'url'=>array('create')),
);
?>

<h2>Public Files</h2>

<? if (count($files) == 0 && count($folders) == 0) { ?>
    <div class="empty-page">
        You have no files or folders at the moment.<br />
        Create new folders or upload files uding the links above.
    </div>
<? } else { ?>
<table class="item-list">
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
        <td></td>
	</tr>
<? } ?>
</table>
<? } ?>