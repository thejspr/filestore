<? if (Yii::app()->params['fb']) { ?>
    <script>
        FB.logout(function(response) {
          // user is now logged out
        });
        
        document.cookie = 'fbs_<?= Yii::app()->params["fb_appid"] ?>=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
        window.location = '<?= $this->createUrl('site/login'); ?>'
    </script>
<? } ?>

