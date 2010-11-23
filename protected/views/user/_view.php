<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Joined')); ?>:</b>
	<?php echo CHtml::encode(date(Yii::app()->params['time_long'],$data->created)); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Last profile edit')); ?>:</b>
	<?php echo CHtml::encode(date(Yii::app()->params['time_long'],$data->updated)); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Last login')); ?>:</b>
	<?php echo CHtml::encode(date(Yii::app()->params['time_long'],$data->last_login)); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Login count')); ?>:</b>
	<?php echo CHtml::encode($data->login_count); ?>
	<br /><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Failed login attempts')); ?>:</b>
	<?php echo CHtml::encode($data->failed_login_attempts); ?>
	<br /><br />

</div>