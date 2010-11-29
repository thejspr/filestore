<?
foreach($files as $file){ ?>
	<tr class="nested-<?=$file->folder_id?>">
		<td class="nested">
			<img src="<?= File::model()->getIcon($file->file_name) ?>" alt="file" />
			<?= CHtml::link($file->file_name, $this->createUrl('file/view', array('id'=>$file->id))) ?>
		</td>
        <td></td>
	</tr>
<? } ?>