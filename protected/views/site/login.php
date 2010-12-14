<?php
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<h1>Login</h1>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<div class="login-wrapper centered">
    <div class="login">
    
    	<p>Please fill out the following form with your login credentials:</p>
    
    	<div class="form login-form">
    		<?php $form=$this->beginWidget('CActiveForm', array(
    			'id'=>'login-form',
    			'enableAjaxValidation'=>false,
    		)); ?>
    
    			<div class="row">
    				<?php echo $form->labelEx($model,'username'); ?>
    				<?php echo $form->textField($model,'username'); ?>
    				<?php echo $form->error($model,'username'); ?>
    			</div>
    
    			<div class="row">
    				<?php echo $form->labelEx($model,'password'); ?>
    				<?php echo $form->passwordField($model,'password'); ?>
    				<?php echo $form->error($model,'password'); ?>
    			</div>
    
    			<div class="row rememberMe">
    				<?php echo $form->label($model,'rememberMe'); ?>
    				<?php echo $form->checkBox($model,'rememberMe'); ?>
    				<?php echo $form->error($model,'rememberMe'); ?>
    			</div>
    
    			<div class="row buttons">
    				<?php echo CHtml::submitButton('Login'); ?>
    			</div>
    
    		<?php $this->endWidget(); ?>
    	</div><!-- form -->
    </div>
    
    <? if(Yii::app()->params['fb']) { ?>
        <div class="fb-login-box">
            Authenticate using Facebook:
            <br/><br/>
            <fb:login-button perms="email"></fb:login-button>
        </div>
    <? } ?>
    
</div>