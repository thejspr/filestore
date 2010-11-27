<script type="text/javascript">
function loadFiles(folder_id, odd){
    var folder_element = $('#expand-folder-link-'+folder_id);
    if (folder_element.text() == "+") {
        $.ajax({
          url: 'index.php?r=folder/files&id='+folder_id+'&odd='+odd,
          success: function(data) {
            $('#folder-'+folder_id).after(data);
            $(folder_element).text('-');
          }
        });
    } else {
       $(".nested-"+folder_id).each(function(){
            $(this).hide();
       });
       $(folder_element).text('+');
    }
}
</script>
<?php
$this->menu=array(
    array('label'=>'Upload File', 'url'=>array('file/create', 'folderid'=>$root_folder->id)),
	array('label'=>'Create Folder', 'url'=>array('create')),
);
?>

<h2>My Files</h2>

<table class="item-list" width="400px">
<?
$odd = true;
foreach($folders as $folder){ ?>
	<tr class="<?= $odd ? 'odd' : 'even' ?>" id="folder-<?= $folder->id?>">
		<td>
			<img src="images/icons/folder.png" alt="folder" />
			<?= CHtml::link($folder->folder_name, $this->createUrl('folder/view', array('id'=>$folder->id))) ?>
		</td>
        <td class="expand-folder">
            <a id="expand-folder-link-<?= $folder->id?>" href="javascript:loadFiles(<?= $folder->id ?>, '<?= !$odd ? 'odd' : 'even' ?>')">+</a>
        </td>
	</tr>
    <? $odd = !$odd; ?>
<? } ?>
<?
foreach($root_files as $file){ ?>
	<tr class="<?= $odd ? 'odd' : 'even' ?>">
		<td>
			<img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />
			<?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
		</td>
        <td></td>
	</tr>
    <? $odd = !$odd; ?>
<? } ?>
</table>