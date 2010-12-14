<? if (Yii::app()->params['fb'] == 1) { ?>

    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?= Yii::app()->params['fb_appid'] ?>', status: true, cookie: true, xfbml: true});
        FB.Event.subscribe('auth.login', function(response) {
            if (response.session) {
              // A user has logged in, and a new cookie has been saved
              window.location = '<?= $this->createUrl('site/fblogin') ?>';
            } else {
              // The user has logged out, and the cookie has been cleared
            }
        });
    </script>    
<? } ?>