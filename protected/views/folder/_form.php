<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'folder-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_name'); ?>
		<?php echo $form->textField($model,'folder_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'folder_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'public'); ?>
		<?php echo $form->checkbox($model,'public'); ?>
		<?php echo $form->error($model,'public'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
