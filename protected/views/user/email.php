<h1>Welcome <?= $model->username ?></h1>

<p>
    This email confirms that you have signed up at 
    <?= CHtml::link("FileStorage", $this->createAbsoluteUrl('site/index'))?>.
</p>

<p>
    We hope you enjoy the service and welcome feedback on 
    <a href="mailto:jkjeldgaard@gmail.com">jkjeldgaard@gmail.com</a>
</p>

<p>
    <i>Regards,<br/> 
    Jesper Kjeldgaard</i>
</p>