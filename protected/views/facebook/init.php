<?
	if (Yii::app()->params["facebook"]) {
		require 'facebook/facebook.php';

		// Create our Application instance (replace this with your appId and secret).
		$facebook = new Facebook(array(
		  'appId'  => Yii::app()->params['facebook_api'],
		  'secret' => Yii::app()->params['facebook_secret'],
		  'cookie' => true,
		));

		$session = $facebook->getSession();

		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $facebook->getUser();
		    $me = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}

		// login or logout url will be needed depending on current user state.
		if ($me) {
		  $logoutUrl = $facebook->getLogoutUrl();
		} else {
		  $loginUrl = $facebook->getLoginUrl();
		}
	?>
	<div id="fb-root"></div>
	<script>
		window.fbAsyncInit = function() {
		FB.init({
		  appId   : '<?php echo $facebook->getAppId(); ?>',
		  session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
		  status  : true, // check login status
		  cookie  : true, // enable cookies to allow the server to access the session
		  xfbml   : true // parse XFBML
		});

		// whenever the user logs in, we refresh the page
		FB.Event.subscribe('auth.login', function() {
		  window.location.reload();
		});
		};

		(function() {
		var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
		}());
	</script>
<? } ?>