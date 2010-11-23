<h1>Welcome</h1>
<? if (Yii::app()->user->isGuest) { ?>
	<p>
        Please <?= CHtml::link("register", array("/user/create")) ?> or
        <?= CHtml::link("login", array("/site/login")) ?> to use FileStore.
        To learn more about the site go to <?= CHtml::link('here', array('/site/page', 'view'=>'about'))?>.
    </p>
<? } else { ?>
	<h3>
        Hello <b><?= Yii::app()->user->name ?></b>
    </h3>
    <p>
        Use the menu to access and upload files.
    </p>
<? } ?>