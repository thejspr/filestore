<?php
$this->menu=array(
	array('label'=>'Create Folder', 'url'=>array('create')),
);
?>

<h2>My Files</h2>

<table id="folder-list">
<? 
foreach($models as $model){ ?>
	<tr>
		<td>
			<img src="images/icons/folder.png" alt="folder" />&nbsp;&nbsp;
			<?= CHtml::link($model->folder_name, $this->createUrl('folder/view', array('id'=>$model->id))) ?>
		</td>
	</tr>
<? } ?>
</table>
