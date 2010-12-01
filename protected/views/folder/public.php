<script type="text/javascript">
function alternateRowColor() {
    var odd = false;
    $('.item-list tr').each(function(){
        if (odd)
            $(this).addClass('odd');
        else
            $(this).removeClass('odd');

        odd = !odd;
    });
}

function loadFiles(folder_id){
    var folder_element = $('#expand-folder-link-'+folder_id);
    if (folder_element.text() == "expand") {
        $.ajax({
          url: 'index.php?r=folder/files&id='+folder_id,
          success: function(data) {
            $('#folder-'+folder_id).after(data);
            $(folder_element).text('collapse');
            alternateRowColor();
          }
        });
    } else {
       $(".nested-"+folder_id).each(function(){
            $(this).hide();
       });
       $(folder_element).text('expand');
       alternateRowColor();
    }
}

$('document').ready(function(){
    alternateRowColor();
});
</script>
<?php
if (!Yii::app()->user->isGuest) {
    $this->menu=array(
        array('label'=>'Upload File', 'url'=>array('file/create')),
        array('label'=>'Create Folder', 'url'=>array('create')),
    );
}
?>

<h2>Public Files</h2>

<? if (count($files) == 0 && count($folders) == 0) { ?>
    <div class="empty-page">
        There are no public files or folders at the moment.<br />
        Create new folders or upload files uding the links above.
    </div>
<? } else { ?>
<table class="item-list">
<?
$odd = true;
foreach($folders as $folder){ ?>
	<tr id="folder-<?= $folder->id?>">
		<td>
			<img src="images/icons/folder.png" alt="folder" />
			<?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))) ?>
		</td>
        <td class="expand-folder">
            <? if (Folder::model()->hasFiles($folder->id) > 0) { ?>
            <a id="expand-folder-link-<?= $folder->id?>" href="javascript:loadFiles(<?= $folder->id ?>)">expand</a>
            <? } ?>
        </td>
	</tr>
    <? $odd = !$odd; ?>
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
    <? $odd = !$odd; ?>
<? } ?>
</table>
<? } ?>