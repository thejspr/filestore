<h1>Register</h1>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<div class="login-wrapper centered">
    <div class="login">
        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    
    <? if(Yii::app()->params['fb']) { ?>
        <div class="fb-login-box">
            Register using Facebook:
            <br/><br/>
            <fb:login-button perms="email"></fb:login-button>
        </div>
    <? } ?>
    
</div>
