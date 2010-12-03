<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->hiddenField($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Choose Folder'); ?>
		<?php echo $form->dropDownList($model,'folder_id',CHtml::listData($folders, 'id', 'folder_name')); ?>
		<?php echo $form->error($model,'folder_id'); ?>
	</div>
    <? if ($model->file_name == "" && $model->created == "") { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'File'); ?>
		<?php echo $form->fileField($model,'file_name'); ?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>       
    <? } else { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'Filename'); ?>
		<?php echo $form->textField($model,'file_name'); ?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>
    <? } ?>
	<div class="row">
		<?php echo $form->labelEx($model,'public'); ?>
		<?php echo $form->checkbox($model,'public'); ?>
		<?php echo $form->error($model,'public'); ?><br />
        <i>Public files can be shared on popular services like Facebook and Twitter as they are accessible without login.</i>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'last_edit'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
