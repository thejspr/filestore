<? if (Yii::app()->user->isGuest) { ?>
    <h1>Welcome</h1>
    <div class="empty-page">
            Please <?= CHtml::link("register", array("/user/create")) ?> or
            <?= CHtml::link("login", array("/site/login")) ?> to use FileStore.<br />
<? } else { ?>
    <h1>Hello <b><?= Yii::app()->user->name ?></b></h1>
    <div class="empty-page">
         You can now <?= CHtml::link("upload files", array("/file/create")) ?>,
        <?= CHtml::link("create folders", array("/folder/create")) ?> or
        <?= CHtml::link('edit your Profile', array('user/update','id'=>Yii::app()->user->id)) ?>.<br />
<? } ?>
        To learn more about the site go to <?= CHtml::link('here', array('/site/page', 'view'=>'about'))?>.
    </div>
